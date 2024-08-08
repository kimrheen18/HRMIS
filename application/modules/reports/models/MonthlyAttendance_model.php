<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MonthlyAttendance_model extends CI_Model {

	var $w=array(70,70,60,60);

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('report_helper', 'dtr_helper'));
	}
	
	public function Header()
	{

	}
	
	function Footer()
	{		
		$this->fpdf->SetFont('Arial','',7);	
		$this->fpdf->Cell(50,3,date('Y-m-d h:i A'),0,0,'L');
		$this->fpdf->Cell(0,3,"Page ".$this->fpdf->PageNo(),0,0,'R');
	}

	function getSQLData($intMonth="",$intYear="")
	{
		$arrPermGroup = getPermanentGroup();
		if(count($arrPermGroup)>0)
		{
			$arrGroup = explode(',',$arrPermGroup[0]['processWith']);
			$strGroup = implode('","',$arrGroup);
		}
		
		$this->db->select("a.empNumber, b.surname, b.firstname, b.middleInitial, c.positionDesc, FORMAT(a.actualSalary,2) AS actualsalary, COALESCE(e.wfh,0) AS office, COALESCE(d.wfh,0) AS wfh, COALESCE(e.wfh,0) AS daysinoffice, a.hpFactor, COALESCE(f.subsistence,0) AS subsistence");
		$this->db->join('tblEmpPersonal b','b.empNumber = a.empNumber','left');
		$this->db->join('tblPosition c','c.positionCode = a.positionCode','left');
		$this->db->join('(SELECT empNumber, COUNT(wfh) AS wfh FROM tblEmpDTR WHERE wfh = 1 AND YEAR(dtrDate) = '.$intYear.' AND MONTH(dtrDate) = '.$intMonth.' AND dtrDate NOT IN (SELECT holidayDate FROM tblHolidayYear) AND DAYOFWEEK(dtrDate) NOT IN (1,7) AND (inAM != "00:00:00" OR outPM != "00:00:00") GROUP BY empNumber) d','d.empNumber = a.empNumber','left');
		$this->db->join('(SELECT empNumber, COUNT(wfh) AS wfh FROM tblEmpDTR WHERE wfh = 0 AND YEAR(dtrDate) = '.$intYear.' AND MONTH(dtrDate) = '.$intMonth.' AND dtrDate NOT IN (SELECT holidayDate FROM tblHolidayYear) AND DAYOFWEEK(dtrDate) NOT IN (1,7) AND (inAM != "00:00:00" or outPM != "00:00:00") GROUP BY empNumber) e','e.empNumber = a.empNumber','left');
		$this->db->join('(SELECT SUM(CASE WHEN hrs >= 8 THEN 150 WHEN hrs BETWEEN 6 AND 7 THEN 125 WHEN hrs = 5 THEN 100 WHEN hrs = 4 THEN 75 ELSE 0 END) subsistence, empNumber FROM
			(SELECT CASE 
			WHEN outPM = "00:00:00" AND outAM != "00:00:00" THEN HOUR(TIMEDIFF(inAM, outAM)) 
			WHEN outPM != "00:00:00" THEN HOUR(TIMEDIFF(inAM,time_format(str_to_date(CONCAT(outPM, "PM"),"%r"),"%T"))) 
			WHEN outPM = "00:00:00" AND outAM = "00:00:00" THEN 0 END AS hrs, 
			inAm, outAM, outPM, dtrDate, empNumber
			FROM tblEmpDTR WHERE MONTH(dtrDate) = '.$intMonth.' AND YEAR(dtrDate) = '.$intYear.' AND dtrDate NOT IN (SELECT holidayDate FROM tblHolidayYear) AND DAYOFWEEK(dtrDate) NOT IN (1,7) AND wfh = 0) x  GROUP BY empNumber) f','f.empNumber = a.empNumber','left');
		// $this->db->where('year(dtrDate)',$intYear);
		// $this->db->where('month(dtrDate)',$intMonth);
		$this->db->where_in('a.appointmentCode',$arrGroup);
		$this->db->where('a.statusofappointment',"In-Service");
		$this->db->where('a.hpFactor !=',0);
		$this->db->where('b.surname !=',"");
		$this->db->group_by('a.empNumber');
		$this->db->order_by('b.surname');
		// $this->db->limit(3);
		$objQuery = $this->db->get('tblEmpPosition a');

		// echo $this->db->last_query();exit(1);
		return $objQuery->result_array();
	}

	function generate($arrData)
	{	
		$this->load->model('libraries/Holiday_model');

		$this->fpdf->AddPage('L','A4');
		$this->fpdf->Ln(18);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,6,strtoupper('monthly attendance report'), 0, 0, 'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,6,"For the Month of " .date("F", mktime(0, 0, 0, $arrData['intMonth'], 10)). ', ' .$arrData['intYear'], 0, 0, 'C');
		$this->fpdf->Ln(15);
		
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->SetFillColor(150,150,150);
		$this->fpdf->Cell(30,10,"Last Name",1,0,'C',1);
		$this->fpdf->Cell(30,10,"First Name",1,0,'C',1);
		$this->fpdf->Cell(10,10,"M.I.",1,0,'C',1);
		$this->fpdf->Cell(45,10,"Position",1,0,'C',1);
		$this->fpdf->Cell(25,10,"Salary",1,0,'C',1);
		$this->fpdf->Cell(30,5,"Attendance",1,0,'C',1);
		$this->fpdf->Cell(30,5,"Number of ","L,R,T",0,'C',1);
		$this->fpdf->Cell(15,10,"%",1,0,'C',1);
		$this->fpdf->Cell(20,10,"Laundry",1,0,'C',1);
		$this->fpdf->Cell(22,10,"Subsistence",1,0,'C',1);
		$this->fpdf->Cell(20,10,"Hazard",1,0,'C',1);
		$this->fpdf->Cell(0,0,"",0,1);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(140,5,"",0,0);
		$this->fpdf->Cell(15,5,"Office",1,0,'C',1);
		$this->fpdf->Cell(15,5,"WFH",1,0,'C',1);
		$this->fpdf->Cell(30,5,"days in Office","L,R,B",0,'C',1);

		$this->fpdf->Ln(6);
		
		$objQuery = $this->getSQLData($arrData['intMonth'],$arrData['intYear']);
		$this->fpdf->SetFillColor(255,255,255);
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetFont('Arial','',10);

		$i=1;
		$totalsalary = 0;
		$totalhazard = 0;
		$totallaundry = 0;
		$totalsubsistence = 0;

		foreach($objQuery as $arrEmp)
		//while($arrSalaryGrade = mysql_fetch_array($objSalaryGrade))
		{
			$percent = 0;
			$hazard = 0;
			
			if($arrEmp['office'] >= 15 && $arrEmp['hpFactor'] == 30)
				$percent = 0.30;
			else if($arrEmp['office'] >= 15 && $arrEmp['hpFactor'] == 23)
				$percent = 0.23;
			else if($arrEmp['office'] >= 15 && $arrEmp['hpFactor'] == 15)
				$percent = 0.15;
			else if($arrEmp['office'] >= 15 && $arrEmp['hpFactor'] == 12)
				$percent = 0.12;
			else if(($arrEmp['office'] >= 8 && $arrEmp['office'] <= 14) &&  $arrEmp['hpFactor'] == 30)
				$percent = 0.23;
			else if(($arrEmp['office'] >= 8 && $arrEmp['office'] <= 14) &&  $arrEmp['hpFactor'] == 23)
				$percent = 0.15;
			else if(($arrEmp['office'] >= 8 && $arrEmp['office'] <= 14) &&  $arrEmp['hpFactor'] == 15)
				$percent = 0.12;
			else if(($arrEmp['office'] < 8 && $arrEmp['office'] > 0) && $arrEmp['hpFactor'] == 30)
				$percent = 0.15;
			else if(($arrEmp['office'] < 8 && $arrEmp['office'] > 0) && $arrEmp['hpFactor'] == 15)
				$percent = 0.10;
			else 
				$percent = 0.00;

			$hazard = (float)str_replace(',','',$arrEmp["actualsalary"]) * $percent;

			$datefrom = $arrData['intYear'].'-'.$arrData['intMonth'].'-01';
			$dateto = $arrData['intYear'].'-'.$arrData['intMonth'].'-'.cal_days_in_month(CAL_GREGORIAN, $arrData['intMonth'], $arrData['intYear']);

			$holidays = $this->Holiday_model->getAllHolidates($arrEmp["empNumber"],$datefrom,$dateto);
			$workingdays = get_workingdays('','',$holidays,$datefrom,$dateto);
			$laundryday = 500 / count($workingdays);
			$laundry = ($arrEmp["office"] + $arrEmp["wfh"]) * $laundryday;

			$w = array(30,30,10,45,25,15,15,30,15,20,22,20);
			$Ln = array('L','L','C','L','R','C','C','C','C','R','R','R');
			$this->fpdf->SetWidths($w);
			$this->fpdf->SetAligns($Ln);
			$this->fpdf->FancyRow(array($i.'. '.$arrEmp["surname"],$arrEmp["firstname"],$arrEmp["middleInitial"],$arrEmp["positionDesc"],$arrEmp["actualsalary"],$arrEmp["office"],$arrEmp["wfh"],$arrEmp["daysinoffice"],$percent*100,number_format($laundry,2),number_format($arrEmp["subsistence"],2),number_format($hazard,2)),array(1,1,1,1,1,1,1,1,1,1,1,1),$Ln);

			$totalsalary += (float)str_replace(',','',$arrEmp["actualsalary"]);
			$totalhazard += $hazard;
			$totallaundry += $laundry;
			$totalsubsistence += $arrEmp["subsistence"];
			$i++;
		}

		$this->fpdf->FancyRow(array("","Grand Total","","",number_format($totalsalary,2),"","","","",number_format($totallaundry,2),number_format($totalsubsistence,2),number_format($totalhazard,2)),array(1,1,1,1,1,1,1,1,1,1,1,1),$Ln);
		

		/* Signatory */
		 if($this->fpdf->GetY()>195)
			 $this->fpdf->AddPage();
			
		$this->fpdf->Ln(20);
		$this->fpdf->Cell(160);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','B',12);		
		$this->fpdf->Cell(0,30,"Certified Copy:",0,0,'L');
		

		$sig=getSignatories($arrData['intSignatory']);
		if(count($sig)>0){
			$sigName = $sig[0]['signatory'];
			$sigPos = $sig[0]['signatoryPosition'];
		}else{
			$sigName='';
			$sigPos='';
		}

		$sigName='MA. VERONICA B. TOLEDANO';
		$sigPos='Administrative Officer IV';

		$this->fpdf->Ln(20);
		$this->fpdf->Cell(5);
		$this->fpdf->Cell(5);				
		$this->fpdf->SetFont('Arial','B',12);		
		$this->fpdf->Cell(0,10,$sigName,0,0,'L');

		$this->fpdf->Ln(4);
		$this->fpdf->Cell(5);
		$this->fpdf->Cell(5);				
		$this->fpdf->SetFont('Arial','',12);				
		$this->fpdf->Cell(0,10,$sigPos,0,0,'L');

		$this->fpdf->Ln(1);
		$this->fpdf->Cell(150);
		$this->fpdf->Cell(55);				
		$this->fpdf->SetFont('Arial','B',12);				
		$this->fpdf->Cell(0,0,'JESSICA L. MORAL',0,0,'L');

		$this->fpdf->Ln(4);
		$this->fpdf->Cell(140);
		$this->fpdf->Cell(55);				
		$this->fpdf->SetFont('Arial','',12);				
		$this->fpdf->Cell(0,0,'Supervising Administrative Officer',0,0,'L');

		$this->fpdf->Ln(4);
		$this->fpdf->Cell(155);
		$this->fpdf->Cell(55);				
		$this->fpdf->SetFont('Arial','',12);				
		$this->fpdf->Cell(0,0,'Personnel Division',0,0,'L');
		
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','',12);				
		//$this->fpdf->Cell(0,10,$sig[0],0,0,'L');
		$this->fpdf->Ln(15);
		
		echo $this->fpdf->Output();
	}

	function generate2($arrData)
	{
		$this->load->model('libraries/Holiday_model');

		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$objQuery = $this->getSQLData($arrData['intMonth'],$arrData['intYear']);

		$i=1;
		$totalsalary = 0;
		$totalhazard = 0;
		$totallaundry = 0;
		$totalsubsistence = 0;

		$data = array();

		foreach($objQuery as $arrEmp)
		{
			$sub_array = array();

			$percent = 0;
			$hazard = 0;
			
			if($arrEmp['office'] >= 15 && $arrEmp['hpFactor'] == 30)
				$percent = 0.30;
			else if($arrEmp['office'] >= 15 && $arrEmp['hpFactor'] == 23)
				$percent = 0.23;
			else if($arrEmp['office'] >= 15 && $arrEmp['hpFactor'] == 15)
				$percent = 0.15;
			else if($arrEmp['office'] >= 15 && $arrEmp['hpFactor'] == 12)
				$percent = 0.12;
			else if(($arrEmp['office'] >= 8 && $arrEmp['office'] <= 14) &&  $arrEmp['hpFactor'] == 30)
				$percent = 0.23;
			else if(($arrEmp['office'] >= 8 && $arrEmp['office'] <= 14) &&  $arrEmp['hpFactor'] == 23)
				$percent = 0.15;
			else if(($arrEmp['office'] >= 8 && $arrEmp['office'] <= 14) &&  $arrEmp['hpFactor'] == 15)
				$percent = 0.12;
			else if(($arrEmp['office'] < 8 && $arrEmp['office'] > 0) && $arrEmp['hpFactor'] == 30)
				$percent = 0.15;
			else if(($arrEmp['office'] < 8 && $arrEmp['office'] > 0) && $arrEmp['hpFactor'] == 15)
				$percent = 0.10;
			else 
				$percent = 0.00;

			$hazard = (float)str_replace(',','',$arrEmp["actualsalary"]) * $percent;

			$datefrom = $arrData['intYear'].'-'.$arrData['intMonth'].'-01';
			$dateto = $arrData['intYear'].'-'.$arrData['intMonth'].'-'.cal_days_in_month(CAL_GREGORIAN, $arrData['intMonth'], $arrData['intYear']);

			$holidays = $this->Holiday_model->getAllHolidates($arrEmp["empNumber"],$datefrom,$dateto);
			$workingdays = get_workingdays('','',$holidays,$datefrom,$dateto);
			$laundryday = 500 / count($workingdays);
			$laundry = ($arrEmp["office"]) * $laundryday; // + $arrEmp["wfh"]

			$sub_array['no'] = $i;
			$sub_array['lname'] = $i.'. '.$arrEmp["surname"];
			$sub_array['fname'] = $arrEmp["firstname"];
			$sub_array['mi'] = $arrEmp["middleInitial"];
			$sub_array['position'] = $arrEmp["positionDesc"];
			$sub_array['salary'] = $arrEmp["actualsalary"];
			$sub_array['ofc'] = $arrEmp["office"];
			$sub_array['wfh'] = $arrEmp["wfh"];
			$sub_array['ofcdays'] = $arrEmp["daysinoffice"];
			$sub_array['percent'] = (string)($percent*100);
			$sub_array['laundry'] = number_format($laundry,2);
			$sub_array['subsistence'] = number_format($arrEmp["subsistence"],2);
			$sub_array['hazard'] = number_format($hazard,2);

			$sub_array['workdays'] = count($workingdays);
			$sub_array['attendance'] = intval($arrEmp["office"])+intval($arrEmp["wfh"]);
			$sub_array['subsday'] = 150;
			$sub_array['laundryday'] =  $laundryday;
			$sub_array['hpfactor'] =  $arrEmp['hpFactor'];

			$totalsalary += (float)str_replace(',','',$arrEmp["actualsalary"]);
			$totalhazard += $hazard;
			$totallaundry += $laundry;
			$totalsubsistence += $arrEmp["subsistence"];
			$i++;

			$data[] = $sub_array;
		}
		
		$sub_array = array();
		$sub_array['no'] = $i;
		$sub_array['lname'] = "";
		$sub_array['fname'] = "Grand Total";
		$sub_array['mi'] = "";
		$sub_array['position'] = "";
		$sub_array['salary'] = number_format($totalsalary,2);
		$sub_array['ofc'] = "";
		$sub_array['wfh'] = "";
		$sub_array['ofcdays'] = "";
		$sub_array['percent'] = "";
		$sub_array['laundry'] = number_format($totallaundry,2);
		$sub_array['subsistence'] = number_format($totalsubsistence,2);
		$sub_array['hazard'] = number_format($totalhazard,2);

		$sub_array['workdays'] = 0;
		$sub_array['attendance'] = 0;
		$sub_array['subsday'] = 0;
		$sub_array['laundryday'] = 0;
		$sub_array['hpfactor'] = 0;

		$data[] = $sub_array;

		$output = array
		(
			"draw" => $draw,
			"recordsTotal" => count($records),
			"recordsFiltered" => count($records),
			"data" => $data
		);

		echo json_encode($output);
		exit();
	}
}
/* End of file MonthlyAttendance_model.php */
/* Location: ./application/modules/reports/models/reports/MonthlyAttendance_model.php */