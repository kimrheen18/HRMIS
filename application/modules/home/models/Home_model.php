<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}

	function getbirthdays()
	{
		$month = date('m');
		$this->db->select('surname,firstname,middlename,middleInitial,birthday,tblEmpPersonal.empNumber');
		$this->db->join('tblEmpPosition','tblEmpPosition.empNumber = tblEmpPersonal.empNumber');
		$this->db->like('birthday',"-".$month."-");
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->order_by('DAYOFMONTH(birthday)');
		$objQuery = $this->db->get('tblEmpPersonal');
		return $objQuery->result_array();
	}

	function getvacantpositions()
	{
		$this->db->select('DISTINCT(itemNumber), positionCode, plantillaGroupCode');
		$this->db->where('rationalized!=',1);
		$this->db->order_by('positionCode');
		$objQuery = $this->db->get('tblPlantilla');
		return $objQuery->result_array();
	}

	function getretirees()
	{
		$dtmCurYear = date("Y");
		$intYear = $dtmCurYear;
		$dtmPrevYear = $dtmCurYear - 65;
		$dtmJanYear = $dtmPrevYear . "-" . "01-01";
		$dtmDecYear = $dtmPrevYear . "-" . "12-31";
		$this->db->select('tblEmpPersonal.empNumber, 
									tblEmpPersonal.surname, 
									tblEmpPersonal.firstname, 
									tblEmpPersonal.middleInitial, 
									tblEmpPersonal.nameExtension,
									tblEmpPersonal.birthday, 
									tblEmpPosition.statusOfAppointment, 
									tblEmpPosition.positionCode,
									tblEmpPosition.groupCode,
									tblEmpPosition.group1,
									tblEmpPosition.group2,
									tblEmpPosition.group3,
									tblEmpPosition.group4,
									tblEmpPosition.group5');
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('(tblEmpPosition.detailedfrom=0 OR tblEmpPosition.detailedfrom=2)');
		$this->db->where('tblEmpPersonal.birthday>=',$dtmJanYear);
		$this->db->where('tblEmpPersonal.birthday<=',$dtmDecYear);
		$this->db->order_by('tblEmpPersonal.surname asc, tblEmpPersonal.firstname asc,tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		return $objQuery->result_array();
	}

	function getemployeesbyappointment($strAppStatus)
	{
		
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname, tblEmpPersonal.firstname, tblEmpPersonal.middlename,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension,tblEmpPosition.positionCode');
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		if($strAppStatus!='')
		{
			if($strAppStatus =='P')
			{ 
				$this->load->model('Hr_model');
				$arrAppStatus = $this->Hr_model->getpayrollprocess();
				$arrPerm = explode(',', $arrAppStatus[0]['processWith']);
				//$arrPerm = implode("','", $arrPerm);
				// $arrAppStatus = $this->getpayrollprocess($strAppStatus);
				//print_r($arrPerm);
				$this->db->where_in("appointmentCode",$arrPerm);
			}else{
				$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
			}
		}
		$this->db->order_by('tblEmpPersonal.surname asc, tblEmpPersonal.firstname asc,tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();exit(1);
		return $objQuery->result_array();
	}

	function getpayrollprocessx($strAppStatus)
	{
		if($strAppStatus=='P')
		{
			$this->db->select('processWith');
			$this->db->from('tblPayrollProcess');
			$this->db->where('appointmentCode',$strAppStatus);
			$subQuery = $this->db->_compile_select();
		}
		return $subQuery->result_array();
	}

	function gethightemp($dtrDate)
	{
		$this->db->select('*');
		$this->db->where('dtrDate',$dtrDate);
		$this->db->where('temperature >',37.5);
		$objQuery = $this->db->get('tblOnlineDTR_HCD');
		return $objQuery->result_array();
	}

	function getsymptoms($dtrDate, $symptoms="")
	{
		$concat = 'CONCAT_WS(", ", CASE WHEN q1_1 = 1 THEN "Fever for the 3 few days" ELSE NULL END, CASE WHEN q1_2 = 1 THEN "Dry Cough" ELSE NULL END, CASE WHEN q1_3 = 1 THEN "Fatigue" ELSE NULL END, CASE WHEN q1_4 = 1 THEN "Body Pains" ELSE NULL END, CASE WHEN q1_5 = 1 THEN "Runny Nose" ELSE NULL END, CASE WHEN q1_6 = 1 THEN "Shortness of Breath" ELSE NULL END, CASE WHEN q1_7 = 1 THEN "Diarrhea" ELSE NULL END, CASE WHEN q1_8 = 1 THEN "Headache" ELSE NULL END, CASE WHEN q1_9 = 1 THEN "Loss of Smell" ELSE NULL END, CASE WHEN q1_10 = 1 THEN "Loss of Taste" ELSE NULL END, CASE WHEN q1_11 = 1 THEN "Loss of Appetite" ELSE NULL END, CASE WHEN q1_12 = 1 THEN "Sore Throat" ELSE NULL END, CASE WHEN q1_13 = 1 THEN "Difficulty of Breathing" ELSE NULL END, CASE WHEN q1_14 = 1 THEN "Body Malaise" ELSE NULL END)';
		$sql = 'SELECT *, concat AS symptoms FROM tblOnlineDTR_HCD WHERE dtrDate = ? AND (q1_1+q1_2+q1_3+q1_4+q1_5+q1_6+q1_7+q1_8+q1_9+q1_10+q1_11+q1_12+q1_13+q1_14) > 0';
		$sql = str_replace('concat', $concat, $sql);

		$symp = "";
		foreach ($symptoms as $key=>$val) {
			$symp .= ($key > 0 ? ' OR ' : '') . $concat . ' LIKE "%'.$val.'%"' ;
		}

		$symp = ' AND (' . $symp .')'; 

		$sql = empty($symptoms) ? $sql : $sql . $symp;

        $query = $this->db->query($sql, array($dtrDate));
        return $query->result();
	}

	public function gethcd($empNumber, $dtrDate)
    {
        $this->db->select('*')->from('tblOnlineDTR_HCD');
        $this->db->where('empNumber', $empNumber);
        $this->db->where('dtrDate', $dtrDate);

        $result = $this->db->get();
        return $result->row();
    }

}

/* End of file Home_model.php */
/* Location: ./application/modules/home/models/Home_model.php */