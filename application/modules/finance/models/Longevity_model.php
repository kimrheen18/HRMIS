<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Longevity_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function getLongevityFactor()
	{
		$payrollProc = $this->db->get_where('tblPayrollProcess', array('appointmentCode' => longeAppt()))->result_array();
		$payrollProc = "'".str_replace(",", "','", $payrollProc[0]['processWith'])."'";

		$empLonge = $this->db->join("tblEmpPosition", "tblEmpPersonal.empNumber = tblEmpPosition.empNumber", "inner")
									->where("tblEmpPosition.statusOfAppointment", "In-Service")
									->where("(tblEmpPosition.detailedfrom = 2 OR tblEmpPosition.detailedfrom = 0)")
									->where("tblEmpPosition.appointmentCode IN (".$payrollProc.")")
									->get("tblEmpPersonal")
									->result_array();
		$arrLongevity = array();
		$no=1;
		foreach($empLonge as $key => $longe):
			$fdayAgncy = $longe['firstDayAgency'];
			$fyrAgncy = date('Y', strtotime($fdayAgncy));
			$difYear = date('Y') - $fyrAgncy;
			$dateofIncrease = date('Y').'-'.date('m-d', strtotime($fdayAgncy));
			
			if(in_array($difYear, array('5','10','15','20','25','30','35','40')) && $difYear > $longe['longiFactor']):
				$longe['difYear'] = $difYear;
				$longe['dateofIncrease'] = $dateofIncrease;
				array_push($arrLongevity, $longe);
			endif;
		endforeach;
		return $arrLongevity;
	}

	function getLongevity($empid='')
	{
		return $this->db->get_where('tblEmpLongevity', array('empNumber' => $empid))->result_array();
	}

	function getLongevitySum($empid='')
	{
		$this->db->select('SUM(longiPay) AS longiPay');
		$res = $this->db->get_where('tblEmpLongevity', array('empNumber' => $empid))->result_array();
		return count($res) > 0 ? $res[0]['longiPay'] : 0;
	}

	function addLongevity($arrData)
	{
		$this->db->insert('tblEmpLongevity', $arrData);
		return $this->db->insert_id();
	}

	function editLongevity($arrData, $empid, $id)
	{
		$this->db->where('id',$id);
		$this->db->where('empNumber',$empid);
		$this->db->update('tblEmpLongevity', $arrData);
		return $this->db->affected_rows();
	}

	public function delLongevity($empid, $id)
	{
		$this->db->where('id',$id);
		$this->db->where('empNumber',$empid);
		$this->db->delete('tblEmpLongevity');
		return $this->db->affected_rows(); 
	}


}
/* End of file Longevity_model.php */
/* Location: ./application/modules/finance/models/Longevity_model.php */