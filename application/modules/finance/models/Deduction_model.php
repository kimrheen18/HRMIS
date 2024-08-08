<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Deduction_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function getData($code='')
	{
		if($code==''):
			return $this->db->order_by('deductionGroupCode, deductionDesc')->get('tblDeduction')->result_array();
		else:
			$res = $this->db->get_where('tblDeduction', array('deductionCode' => $code))->result_array();
			return count($res) > 0 ? $res[0] : array();
		endif;
	}

	function add($arrData)
	{
		$this->db->insert('tblDeduction', $arrData);
		return $this->db->insert_id();
	}

	function add_emp_deductions($arrData)
	{
		$this->db->insert('tblEmpDeductions', $arrData);
		return $this->db->insert_id();
	}

	function addAgency($arrData)
	{
		$this->db->insert('tblDeductionGroup', $arrData);
		return $this->db->insert_id();
	}

	function edit_empdeduction_byempnumber($arrData,$deductioncode,$empid)
	{
		$this->db->where('deductionCode',$deductioncode);
		$this->db->where('empNumber',$empid);
		$this->db->update('tblEmpDeductions', $arrData);
		return $this->db->affected_rows();	
	}

	function edit_empdeduction($arrData, $code)
	{
		$this->db->where('deductCode',$code);
		$this->db->update('tblEmpDeductions', $arrData);
		return $this->db->affected_rows();
	}

	function edit($arrData, $id)
	{
		$this->db->where('deduction_id',$id);
		$this->db->update('tblDeduction', $arrData);
		return $this->db->affected_rows();
	}

	public function delete($tab, $id)
	{
		if($tab == 1):
			$this->db->where('deduction_id', $id);
			$this->db->delete('tblDeduction');	
		else:
			$this->db->where('deduct_id', $id);
			$this->db->delete('tblDeductionGroup');	
		endif;
		return $this->db->affected_rows(); 
	}

	function edit_agency($arrData, $id)
	{
		$this->db->where('deduct_id',$id);
		$this->db->update('tblDeductionGroup', $arrData);
		return $this->db->affected_rows();
	}

	function getDeductionsByStatus($status='')
	{
		if($status==''):
			return $this->db->order_by('deductionGroupCode, deductionDesc')->get('tblDeduction')->result_array();
		else:
			return $this->db->get_where('tblDeduction', array('hidden' => $status))->result_array();
		endif;
	}

	function getDeductionsByType($type)
	{
		$this->db->order_by('deductionDesc');
		return $this->db->get_where('tblDeduction', array('deductionType' => $type,'hidden' => 0))->result_array();
	}

	function getDeductionGroup($id='')
	{
		if($id==''):
			return $this->db->order_by('deductionGroupCode','ASC')->get('tblDeductionGroup')->result_array();
		else:
			$result = $this->db->get_where('tblDeductionGroup', array('deduct_id' => $id))->result_array();
			return $result[0];
		endif;
	}

	function getDeductions($id='',$select='deductionCode')
	{
		if($id==''):
			return $this->db->select($select)->order_by('deductionDesc')->get('tblDeduction')->result_array();
		else:
			$result = $this->db->get_where('tblDeduction', array('deduction_id' => $id))->result_array();
			return $result[0];
		endif;
	}
	
	function isDeductionCodeExists($code, $action)
	{
		$result = $this->db->get_where('tblDeduction', array('deductionCode' => $code))->result_array();
		if($action == 'add'):
			if(count($result) > 0):
				return true;
			endif;
		else:
			if(count($result) > 1):
				return true;
			endif;
		endif;
		return false;
	}

	function isDeductionGroupExists($code, $action)
	{
		$result = $this->db->get_where('tblDeductionGroup', array('deductionGroupCode' => $code))->result_array();
		if($action == 'add'):
			if(count($result) > 0):
				return true;
			endif;
		else:
			if(count($result) > 1):
				return true;
			endif;
		endif;
		return false;
	}

	function getMaturingLoans($month, $yr)
	{
		$strSQL = "SELECT *, IFNULL((SELECT SUM(deductAmount)
						FROM tblEmpDeductionRemit
						WHERE tblEmpDeductionRemit.code=tblEmpDeductions.deductCode),0)  AS total_remit
							FROM tblEmpDeductions 
							LEFT JOIN tblDeduction ON tblDeduction.deductionCode = tblEmpDeductions.deductionCode 
							LEFT JOIN tblEmpPersonal on tblEmpDeductions.empNumber = tblEmpPersonal.empNumber 
								WHERE actualEndMonth='$month' AND actualEndYear='$yr' AND status='1' AND deductionType='Loan'";

		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();
	}

	function getMatureDeductions($month,$yr)
	{
		$this->db->select('tblDeduction.*,tblEmpDeductions.*,IFNULL((SELECT SUM(deductAmount)
						FROM tblEmpDeductionRemit
						WHERE tblEmpDeductionRemit.code=tblEmpDeductions.deductCode),0)  AS total_remit');
		$this->db->join('tblDeduction', 'tblDeduction.deductionCode = tblEmpDeductions.deductionCode');
		return $this->db->get_where('tblEmpDeductions',array('actualEndYear' => $yr, 'actualEndMonth' => $month))->result_array();
	}

	function getAgencyDeductionShare()
	{
		$res = $this->db->get_where('tblAgency')->result_array();
		return $res[0];
	}

	function getEmployee_regular_deduction($empid)
	{
		$regular_deductions = $this->getDeductionsByType('Regular');
		$this->db->order_by('deductionCode');
		$this->db->where_in('deductionCode',array_column($regular_deductions,'deductionCode'));
		$res = $this->db->get_where('tblEmpDeductions', array('empNumber' => $empid))->result_array();
		return $res;
	}

	function getDeductionByProcess($process_id,$empid)
	{
		$this->join('tblProcess','tblEmpDeductionRemit.processID = tblProcess.processID','left');
		$this->join('tblDeduction','tblDeduction.deductionCode = tblEmpDeductionRemit.deductionCode','left');
		$this->db->where("tblEmpDeductionRemit.deductionCode!='UNDABS'");
		$this->db->where('tblEmpDeductionRemit.empNumber',$empid);
		$this->db->where('tblProcess.processID', $process_id);
		$this->db->get('tblEmpDeductionRemit')->result_array();
	}

	function getDeductionByEmployee($empid,$mon,$yr)
	{
		# Regular deductions not included
		$regular_deductions = $this->getDeductionsByType('Regular');
		// print_r($regular_deductions);
		$totaldays = cal_days_in_month(CAL_GREGORIAN, $mon, $yr);
		// $this->db->order_by('deductionCode');
		// $this->db->where_not_in('deductionCode',array_column($regular_deductions,'deductionCode'));
		// $this->db->where("(STR_TO_DATE(CONCAT(actualStartYear,'-',actualStartMonth,'-01'), '%Y-%m-%d') <= '".$yr."-".$mon."-01')");
		// $this->db->where("(STR_TO_DATE(CONCAT(actualEndYear,'-',actualEndMonth,'-".$totaldays."'), '%Y-%m-%d') >= '".$yr."-".$mon."-01')");

		// $res = $this->db->get_where('tblEmpDeductions', array('empNumber' => $empid))->result_array();
		// echo $this->db->last_query();
		// return $res;
	}

	function add_deduction_remit($arrData)
	{
		$this->db->insert('tblEmpDeductionRemit', $arrData);
		return $this->db->insert_id();
	}

	function del_deduction_remit($process_id)
	{
		$this->db->where('processID', $process_id);
		$this->db->delete('tblEmpDeductionRemit');
	}
	
	function getPhilHealthRange($salary)
	{
		$this->db->where('philhealthFrom <= ',$salary);
		$this->db->where('philhealthTo >= ',$salary);

		$res = $this->db->get('tblPhilhealthRange')->result_array();
		return count($res) > 0 ? $res[0] : array('philMonthlyContri' => 0);
	}

	function get_employee_deductions($empnumber,$deduct_code,$type='')
	{
		if($type!=''):
			if($type=='ot'):
				$this->db->where('tblDeduction.deductionType','Regular');
				$this->db->where("(tblEmpDeductions.deductionCode!='LIFE' AND tblEmpDeductions.deductionCode!='PHILHEALTH' AND tblEmpDeductions.deductionCode!='PAGIBIG' AND tblEmpDeductions.deductionCode!='LPTAX' AND tblEmpDeductions.deductionCode!='HPTAX')");
			else:
				$this->db->where('tblDeduction.deductionType',$type);
				if(count($deduct_code) > 0){
					$this->db->where_in('tblEmpDeductions.deductionCode',$deduct_code);
				}
			endif;
		else:
			if(count($deduct_code) > 0){
				$this->db->where_in('tblEmpDeductions.deductionCode',$deduct_code);
			}
		endif;

		$this->db->join('tblDeduction', 'tblEmpDeductions.deductionCode = tblDeduction.deductionCode', 'left');
		$res = $this->db->get_where('tblEmpDeductions',array('empNumber' => $empnumber,'status' => 1))->result_array();
		
		return $res;
	}

	function check_empdeductions($mon,$yr,$appt)
	{
		$res = $this->db->distinct()->select('tblEmpDeductionRemit.deductionCode')
						->join('tblProcess','tblProcess ON tblProcess.processID = tblEmpDeductionRemit.processID','left')
						->get_where('tblEmpDeductionRemit', array('tblProcess.processMonth' => $mon, 'processYear' => $yr, 'employeeAppoint' => $appt))
						->result_array();
		return $res;
	}

	function update_loan($mon,$yr)
	{
		$matured_loans = $this->db->join('tblEmpDeductionRemit','tblEmpDeductionRemit.code = tblEmpDeductions.deductCode','left')
								  ->join('tblDeduction','tblDeduction.deductionCode = tblEmpDeductions.deductionCode','left')
								  ->where("(tblDeduction.deductionType='Loan' OR tblDeduction.deductionType='Contribution')")
								  ->where('status!=',2)
								  ->get_where('tblEmpDeductions',array('tblEmpDeductions.actualEndMonth' => $mon, 'actualEndYear' => $yr))->result_array();
		
		foreach($matured_loans as $mloan):
			$this->db->where('deductCode', $mloan['deductCode'])->update('tblEmpDeductions', array('status' => 0));
		endforeach;

	}

	function get_deduction_remit($process_id,$deduct_type,$mon,$yr)
	{
		$this->db->distinct()->select('tblEmpDeductions.*');
		$this->db->join('tblEmpDeductionRemit','tblEmpDeductionRemit.empNumber = tblEmpDeductions.empNumber','inner');
		$this->db->join('tblDeduction','tblDeduction.deductionCode = tblEmpDeductions.deductionCode','left');
		$this->db->where('tblEmpDeductionRemit.processID',$process_id);
		$this->db->where('tblDeduction.deductionType',$deduct_type);
		$this->db->where('actualEndMonth',$mon);
		$this->db->where('actualEndYear',$yr);
		return $this->db->get('tblEmpDeductions')->result_array();
	}



}
/* End of file Deduction_model.php */
/* Location: ./application/modules/finance/models/Deduction_model.php */