<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Compensation_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function add($arrData)
	{
		$this->db->insert('tblPayrollGroup', $arrData);
		return $this->db->insert_id();
	}

	function editEmpPosition($arrData, $empid, $acctNumber='')
	{
		$this->db->where('empNumber',$empid);
		$this->db->update('tblEmpPosition', $arrData);

		if($acctNumber != ''):
			$this->db->where('empNumber',$empid);
			$this->db->update('tblEmpPersonal', array('AccountNum' => $acctNumber));
		endif;
		return $this->db->affected_rows();
	}

	function getEmployeeDeduction($empid, $yr, $mon)
	{
		$res = $this->db->select('distinct(tblDeduction.deductionCode),tblDeduction.deductionCode,period1,period2,period3,period4')
					->join('tblDeduction', 'tblEmpDeductionRemit.deductionCode = tblDeduction.deductionCode', 'left')
					->where('empNumber',$empid)
					->where('hidden',0)
					->where('deductYear',$yr)
					->where('deductMonth',$mon)
					->get('tblEmpDeductionRemit')->result_array();
		return $res;
	}

	function getEmployeeShare($empid, $contriCode)
	{
		return $this->db->join('tblEmpPosition', 'tblEmpPosition.empNumber = tblEmpDeductions.empNumber', 'left')
					->where('tblEmpDeductions.empNumber',$empid)
					->where("(appointmentCode='P' OR appointmentCode='CT' OR appointmentCode='CTI')")
					->where('deductionCode', $contriCode)
					->where('status', 1)
					->get('tblEmpDeductions')->result_array();
	}

	function getLifeRetirement($switch, $salary, $empShare, $emprShare, $empid)
	{
		if($switch == 'Y'):
			$liferetirement = $this->getEmployeeShare($empid, 'LIFE');
			if(count($liferetirement) > 0):
				$gsisContri = $this->db->get('tblAgency')->result_array();
				$empShare = $salary * ($gsisContri[0]['gsisEmpShare'] / 100);
				$emprShare = $salary * ($gsisContri[0]['gsisEmprShare'] / 100);
			else:
				$empShare = 0;
				$emprShare = 0;
			endif;
		else:
			$empShare = 0;
			$emprShare = 0;
		endif;
		return array('empShare' => $empShare, 'emprShare' => $emprShare);
	}
	
	function getPagibig($switch, $salary, $empShare, $emprShare, $empid)
	{
		if($switch == 'Y'):
			$pagibig = $this->getEmployeeShare($empid, 'PAGIBIG');
			if(count($pagibig) > 0):
				$pagibigContri = $this->db->get('tblAgency')->result_array();
				$emprShare = $pagibigContri[0]['pagibigEmprShare'];
			else:
				$emprShare = 0;
			endif;
		else:
			$emprShare = 0;
		endif;

		$pagibigEmpContri = $this->db->get_where('tblEmpDeductions', array('empNumber' => $empid, 'deductionCode' => 'PAGIBIG', 'status' => '1'))->result_array();
		if(count($pagibigEmpContri) > 0):
			$empShare = $pagibigEmpContri[0]['monthly'];
		else:
			$empShare = 0;
		endif;
		return array('empShare' => $empShare, 'emprShare' => $emprShare);
	}
	
	function getPhilhealth($switch, $salary, $empShare, $emprShare, $empid)
	{
		if($switch == 'Y'):
			$phealth = $this->getEmployeeShare($empid, 'PHILHEALTH');
			if(count($phealth) > 0):
				$philhealthcont = $this->db->get('tblAgency')->result_array();
				// $empShareContri = $philhealthcont[0]['philhealthEmpShare'] / 100;
				$emprShareContri = $philhealthcont[0]['philhealthEmprShare'] / 100;
				
				$philhealthcont = $this->db->get_where('tblPhilhealthRange', array('philhealthTo>=' => $salary, 'philhealthFrom<=' => $salary))->result_array();
				$empContri = $philhealthcont[0]['philMonthlyContri'];
					
				// $empShare = $empContri * $empShareContri;
				$emprShare = $empContri * $emprShareContri;
			else:
				// $empShare = 0;
				$emprShare = 0;
			endif;
		else:
			$emprShare = 0;
		endif;

		$philhealthcont = $this->db->get_where('tblEmpDeductions', array('empNumber' => $empid, 'deductionCode' => 'PHILHEALTH', 'status' => '1'))->result_array();
		if(count($philhealthcont) > 0):
			$empShare = $philhealthcont[0]['monthly'];
		else:
			$empShare = 0;
		endif;
		return array('empShare' => $empShare, 'emprShare' => $emprShare);
	}

	function getITW($empid)
	{
		$res = $this->db->get_where('tblEmpDeductions', array('empNumber' => $empid, 'deductionCode' => 'ITW'))->result_array();
		if(count($res) > 0):
			return $res[0]['period1'] + $res[0]['period2'] + $res[0]['period3'] + $res[0]['period4'];
		else:
			return 0;
		endif;
	}

	function getLoans($empid)
	{
		$sql = "SELECT tblEmpDeductions.deductionCode, deductionDesc, tblEmpDeductions.deductCode as loanCode,
					amountGranted, period1+period2+period3+period4 AS deductAmount, actualEndMonth, actualEndYear,
					IFNULL((SELECT SUM(deductAmount) FROM tblEmpDeductionRemit WHERE tblEmpDeductionRemit.code=tblEmpDeductions.deductCode),0)  AS total_remit
					FROM tblEmpDeductions
						LEFT JOIN tblDeduction on tblDeduction.deductionCode = tblEmpDeductions.deductionCode
						WHERE empNumber='$empid' 
						AND tblEmpDeductions.deductionCode IN (
							SELECT tblDeduction.deductionCode FROM tblDeduction WHERE deductionType='Loan')
						AND status=1 ORDER BY tblEmpDeductions.deductionCode";

		return $this->db->query($sql)->result_array();
	}

	function getContributions($empid)
	{
		$sql = "SELECT tblDeduction.deductionDesc, tblEmpDeductions.deductionCode, deductCode AS contriCode, period1+period2+period3+period4 AS deductAmount
					FROM tblEmpDeductions
                    LEFT JOIN tblDeduction on tblDeduction.deductionCode = tblEmpDeductions.deductionCode
					WHERE empNumber='$empid'
					AND status=1 AND tblEmpDeductions.deductionCode IN (
						SELECT tblDeduction.deductionCode FROM tblDeduction 
						WHERE deductionType='Contribution' OR deductionType='Others')
					ORDER BY tblEmpDeductions.deductionCode";

		return $this->db->query($sql)->result_array();
	}

	function getFinishedLoans($empid)
	{
		$sql = "SELECT tblDeduction.deductionDesc, deductCode, tblDeduction.deductionCode, deductCode as loanCode, amountGranted, period1+period2+period3+period4 AS deductAmount
					FROM tblEmpDeductions
					LEFT JOIN tblDeduction on tblDeduction.deductionCode = tblEmpDeductions.deductionCode
					WHERE empNumber='$empid' AND tblDeduction.deductionCode IN (
						SELECT tblDeduction.deductionCode FROM tblDeduction WHERE deductionType='Loan')
					AND status=0 ORDER BY tblDeduction.deductionCode";

		return $this->db->query($sql)->result_array();
	}

	function getPremiumDeduction($empid, $deductionType)
	{
		$sql = "SELECT tblDeduction.`deductionCode`, `amountGranted`,`annual`,`deductionDesc`, `monthly`,`period1`,`period2`,`period3`,`period4`, empNumber, tblDeduction.`deductionType`, `deductCode`,`status`, `actualStartMonth`, `actualStartYear`, `actualEndMonth`, `actualEndYear`, tblDeduction2.deductCode
					FROM (SELECT * FROM tblEmpDeductions WHERE empNumber='$empid') AS tblDeduction2
					RIGHT JOIN tblDeduction ON   tblDeduction2.deductionCode =tblDeduction.deductionCode  WHERE deductionType='$deductionType' AND hidden='0' 
					ORDER BY status desc, deductionDesc ASC";

		return $this->db->query($sql)->result_array();
	}

	function getPremiumContribution($empid, $deductionType)
	{
		$sql = "SELECT tblDeduction.`deductionCode`, `amountGranted`,`annual`,`deductionDesc`, `monthly`,`period1`,`period2`,`period3`,`period4`, empNumber, tblDeduction.`deductionType`, `deductCode`,`status`
					FROM (SELECT * FROM tblEmpDeductions WHERE empNumber='$empid') AS tblDeduction2
					RIGHT JOIN tblDeduction ON   tblDeduction2.deductionCode =tblDeduction.deductionCode
						WHERE (deductionType='$deductionType' OR deductionType='Others')AND hidden='0' ORDER BY deductionDesc ASC";
		return $this->db->query($sql)->result_array();
	}

	public function getDeduction($empid, $deductionCode)
	{
		return $this->db->get_where('tblEmpDeductions', array('empNumber' => $empid, 'deductionCode' => $deductionCode))->result_array();
	}

	function editDeduction($arrData, $id, $empid)
	{
		$this->db->where('deductCode',$id);
		$this->db->where('empNumber',$empid);
		$this->db->update('tblEmpDeductions', $arrData);
		$this->db->last_query();
		return $this->db->affected_rows();
	}

	function addDeduction($arrData)
	{
		$this->db->insert('tblEmpDeductions', $arrData);
		return $this->db->insert_id();
	}


}
/* End of file ProjectCode_model.php */
/* Location: ./application/modules/finance/models/Compensation_model.php */