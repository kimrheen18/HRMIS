<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('hr/Hr_model','hr/chart_model','pds/pds_model','home_model'));
    }

	public function index()
	{
		$empid = $this->session->userdata('sessEmpNo');
		if($empid == 'HRMIS-QRSCANNER'):
			redirect('qrscan');
		endif;
	
		$userlevel = $this->session->userdata('sessUserLevel');
		if($userlevel == 2):
			redirect('finance/notifications/npayroll');
		endif;

		if(in_array($userlevel, array(3,4,5))):
			redirect('hr/profile/'.$empid);
		endif;

		# plantilla chart
		$arrPlantillaChart = $this->chart_model->plantilla_positions();
		$intFilled=0;$intVacant=0;
		foreach($arrPlantillaChart->result_array() as $row):
			if($row['empNumber']!='')
				$intFilled+=1;
			else
				$intVacant+=1;
		endforeach;
		$this->arrData['intFilled']=$intFilled;
		$this->arrData['intVacant']=$intVacant;
		# gender chart
		$arrAS = $this->Hr_model->appointment_status();
		$arrASFull = $this->Hr_model->appointment_status(TRUE);
				
		foreach($arrASFull as $row):
			$arrGenderChart[$row]['M'] = $this->chart_model->gender_appointment($row,'M');
			$arrGenderChart[$row]['M']['appCode'] = appstatus_code($row);
			$arrGenderChart[$row]['F'] = $this->chart_model->gender_appointment($row,'F');
			$arrGenderChart[$row]['F']['appCode'] = appstatus_code($row);
		endforeach;
		# total male
		$i=0;$arrGender=array('intTotalMale'=>0,'intTotalFemale'=>0);
		      foreach($arrASFull as $row):
		          $arrGender['intTotalMale'] += $arrGenderChart[$row]['M'][0]['total'];
		          $arrGender['intTotalFemale'] += $arrGenderChart[$row]['F'][0]['total'];
		      endforeach;

		$this->arrData['arrAS'] = $arrAS;
		$this->arrData['arrASFull'] = $arrASFull;
		$this->arrData['arrGender'] = $arrGender;
		$this->arrData['arrGenderChart'] = $arrGenderChart;

		/*dashboard*/
		$this->arrData['intBirthday'] = count($this->home_model->getbirthdays());
		$this->arrData['intVacant'] = count($this->vacantpositions(1));
		$this->arrData['intRetiree'] = count($this->retirees(1));
		$this->arrData['intP'] = count($this->home_model->getemployeesbyappointment('P'));
		$this->arrData['intGIA'] = count($this->home_model->getemployeesbyappointment('GIA'));
		$this->arrData['intJO'] = count($this->home_model->getemployeesbyappointment('JO'));
		$this->arrData['intCas'] = count($this->home_model->getemployeesbyappointment('Cas'));
		$this->arrData['intCONT'] = count($this->home_model->getemployeesbyappointment('CONT'));
		$this->arrData['intTemp'] = count($this->home_model->gethightemp(date('Y-m-d')));
		$this->arrData['intSymptoms'] = count($this->home_model->getsymptoms(date('Y-m-d')));

		$this->template->load('template/template_view','home/home_view',$this->arrData);
	}

	public function switch_hr_emp()
	{
		$empid = $this->session->userdata('sessEmpNo');
		$_SESSION['sessUserLevel'] = 5;
		redirect('hr/profile/'.$empid);
	}

	public function switch_emp_hr()
	{
		$empid = $this->session->userdata('sessEmpNo');
		$_SESSION['sessUserLevel'] = 1;
		redirect('home');
	}

	public function switch_fin_emp()
	{
		$empid = $this->session->userdata('sessEmpNo');
		$_SESSION['sessUserLevel'] = 5;
		redirect('hr/profile/'.$empid);
	}

	public function switch_emp_fin()
	{
		$empid = $this->session->userdata('sessEmpNo');
		$_SESSION['sessUserLevel'] = 2;
		redirect('home');
	}

	public function birthdays()
	{
		$this->arrData['arrData'] = $this->home_model->getbirthdays();
		$this->template->load('template/template_view','home/birthday_view',$this->arrData);
	}

	public function vacantpositions($count=0)
	{
		$arrData = array();
		$arrTmpData = $this->home_model->getvacantpositions();
		$i=0;
		foreach($arrTmpData as $row):
			$itemNumber = $row['itemNumber'];
			$positionCode = $row['positionCode'];
			$plantillaGroupCode = $row['plantillaGroupCode'];

			$objResult = $this->db->select('tblEmpPersonal.empNumber, tblEmpPosition.itemNumber,tblEmpPosition.statusOfAppointment')->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner')->where('tblEmpPosition.statusOfAppointment','In-Service')->where('tblEmpPosition.itemNumber',$itemNumber)->get('tblEmpPersonal')->result_array();
			//echo $this->db->last_query();
			$numResult = count($objResult);
			if($numResult==0)
			{
				$strPlantillaGroupName = plantilla_group($plantillaGroupCode);
				$strPositionName = position_name($positionCode);
				$arrData[$i] = array(
					'itemNumber'=>$itemNumber,
					'positionName'=>$strPositionName,
					'plantillaGroup'=>$strPlantillaGroupName
					);
				$i++;
				
			}
		endforeach;
		if($count) return $arrData;
		$this->arrData['arrData'] = $arrData;
		$this->template->load('template/template_view','home/vacantposition_view',$this->arrData);
	}

	public function retirees($count=0)
	{
		$arrData = array();
		$arrTmpData = $this->home_model->getretirees();
		$i=0;$dtmCurYear = date("Y");$intYear = $dtmCurYear;
		foreach($arrTmpData as $row)
		{
			$strEmpNum = $row['empNumber'];
			$strSName = strtoupper($row['surname']);
			$strFName = strtoupper($row['firstname']);
			$strMName = strtoupper($row['middleInitial']);
			// $strEmpName = $row['surname'].', '.$row['firstname'].' '.$row['middleInitial'];
			$strBirthday = $row['birthday'];
			$strStatusOfEmployment = $row['statusOfAppointment'];
			$strPositionCode =  $row['positionCode'];
			
			$strGroupCode =  $row['groupCode'];
			$strGroup1 =  $row['group1'];
			$strGroup2 =  $row['group2'];
			$strGroup3 =  $row['group3'];
			$strGroup4 =  $row['group4'];
			$strGroup5 =  $row['group5'];
			//$strOfficeCode =  $row['officeCode'];
			$strBirthdayEx = explode('-', $strBirthday);
			$arrBdayYear = $strBirthdayEx[0];
			$arrBdayMonth = $strBirthdayEx[1];
			$arrBdayDay = $strBirthdayEx[2];
			$intBdayYear = intval($arrBdayYear);

			$intRetireeAge = $intYear - $intBdayYear;

			if (($intRetireeAge >= 65)&&($strStatusOfEmployment == 'In-Service'))
			{	
				$strOffice = office_name(employee_office($row['empNumber']));
				$strPositionName = position_name($strPositionCode);
				$arrData[$i] = array(
					'empNumber'=>$strEmpNum,
					'surname' => $strSName,
					'firstname' => $strFName,
					'middleInitial' => $strMName,
					'office' => $strOffice,
					'position' => $strPositionName
					);	
				$i++;
				
			}
		}
		if($count) return $arrData;
		$this->arrData['arrData'] = $arrData;	
		$this->template->load('template/template_view','home/retiree_view',$this->arrData);
	}

	public function employees()
	{
		$strAppStatus = $this->uri->segment(3);
		$this->arrData['arrData'] = $this->home_model->getemployeesbyappointment($strAppStatus);
		$this->template->load('template/template_view','home/employee_view',$this->arrData);
	}

	public function change_hcddate()
	{
		$temp = count($this->home_model->gethightemp($_GET['dtrDate']));
		$symp = count($this->home_model->getsymptoms($_GET['dtrDate']));

		echo json_encode(array('status' => 'success', 'temp' => $temp, 'symp' => $symp ));
	}

	public function withhightemp()
	{
		$dtrDate = $this->uri->segment(3);
		$this->arrData['arrData'] = $this->home_model->gethightemp($dtrDate);
		$this->template->load('template/template_view','home/hightemp_view',$this->arrData);
	}

	public function withsymptoms()
	{
		$dtrDate = $this->uri->segment(3);
		// $this->arrData['arrData'] = $this->home_model->getsymptoms($dtrDate);
		$this->template->load('template/template_view','home/symptoms_view');
	}

	public function hcdform()
	{
		echo json_encode($this->home_model->gethcd($_GET['empNumber'], $_GET['dtrDate']));
	}

	public function withsymptoms_filtered()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$records = $this->home_model->getsymptoms($_GET['dtrdate'], $_GET['symps']);
		$data = array();

		foreach($records as $r) 
		{
			$sub_array = array();
			$sub_array['fullName'] = '<a href="'.base_url("hr/profile").'/'.$r->empNumber.'">'.$r->fullName.'</a>';
			$sub_array['office'] = employee_office($r->empNumber);
			$sub_array['symptoms'] = $r->symptoms;
			$sub_array['iswfh'] = '<div class="checker disabled"><span '.($r->wfh == 1 ? 'class="checked"' : '').'><input type="checkbox" '.($r->wfh == 1 ? 'checked="checked"' : '').' name="chkwfh" disabled  /></span></div>';
			$sub_array['empNumber'] = '<button type="button" class="btn btn-info" onclick="hcdForm(&quot;'.$r->empNumber.'&quot;)">Details</button>';
			$data[] = $sub_array;
		}

		$output = array
		(
			"draw" => $draw,
			"recordsTotal" => count($records),
			"recordsFiltered" => count($records),
			"data" => $data
		);

		echo json_encode($output);
	}
}
