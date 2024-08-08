<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Check_exists_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}

	function check_deduction($code)
	{
		$total_exists = 0;
		$total_exists = $this->db->where('deductionCode',$code)->from('tblEmpDeductLoan')->count_all_results();
		$total_exists = $this->db->where('deductionCode',$code)->from('tblEmpDeductLoanConAdjust')->count_all_results();
		$total_exists = $this->db->where('deductionCode',$code)->from('tblEmpDeductionRemit')->count_all_results();
		$total_exists = $this->db->where('deductionCode',$code)->from('tblEmpDeductions')->count_all_results();
		return $total_exists;
	}
	
	function check_agency($code)
	{
		$total_exists = 0;
		$total_exists = $this->db->where('deductionGroupCode',$code)->from('tblDeduction')->count_all_results();
		return $total_exists;
	}

	function check_income($code)
	{
		$total_exists = 0;
		$total_exists = $this->db->where('incomeCode',$code)->from('tblEmpAddIncome')->count_all_results();
		$total_exists = $this->db->where('incomeCode',$code)->from('tblEmpBenefits')->count_all_results();
		$total_exists = $this->db->where('incomeCode',$code)->from('tblEmpIncome')->count_all_results();
		$total_exists = $this->db->where('incomeCode',$code)->from('tblEmpIncomeAdjust')->count_all_results();
		$total_exists = $this->db->where('incomeCode',$code)->from('tblEmpMealDetails')->count_all_results();
		return $total_exists;
	}

	function check_payroll_process($code)
	{
		$total_exists = 0;
		$total_exists = $this->db->where('appointmentCode',$code)->from('tblPayrollProcess')->count_all_results();
		$total_exists = $this->db->where('appointmentCode',$code)->from('tblComputationInstance')->count_all_results();
		$total_exists = $this->db->where('appointmentCode',$code)->from('tblEmpDeductionRemit')->count_all_results();
		$total_exists = $this->db->where('appointmentCode',$code)->from('tblEmpIncomeAdjust')->count_all_results();
		$total_exists = $this->db->where('appointmentCode',$code)->from('tblNonPermComputationInstance')->count_all_results();
		$total_exists = $this->db->where('appointmentCode',$code)->from('tblOTComputationInstance')->count_all_results();
		$total_exists = $this->db->where('appointmentCode',$code)->from('tblProcessedEmployees')->count_all_results();
		return $total_exists;
	}

	function check_project_code($code)
	{
		$total_exists = 0;
		$total_exists = $this->db->where('projectCode',$code)->from('tblProcessedEmployees')->count_all_results();
		$total_exists = $this->db->where('projectCode',$code)->from('tblPayrollGroup')->count_all_results();
		$total_exists = $this->db->where('projectCode',$code)->from('tblProcessedPayrollGroup')->count_all_results();
		$total_exists = $this->db->where('projectCode',$code)->from('tblProcessedProject')->count_all_results();
		return $total_exists;
	}



}
/* End of file Check_exists_model.php */
/* Location: ./application/modules/finance/models/Check_exists_model.php */