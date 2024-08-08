<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payroll_register_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function employee_list($appt)
	{
		$this->db->join('tblPayrollGroup','tblPayrollGroup.payrollGroupCode = tblEmpPosition.payrollGroupCode','left');
		$this->db->join('tblProject','tblProject.projectCode = tblPayrollGroup.projectCode','left');
		$this->db->select('tblEmpPosition.empNumber,tblEmpPosition.appointmentCode,tblEmpPosition.statusOfAppointment,tblEmpPosition.payrollSwitch,tblEmpPosition.payrollGroupCode,tblPayrollGroup.payrollGroupName,tblProject.projectDesc');
		$this->db->where('tblEmpPosition.appointmentCode',$appt);
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('tblEmpPosition.payrollSwitch','Y');
		$res = $this->db->get('tblEmpPosition')->result_array();
		return $res;
	}

	// function deduction_list($empno, $process_id)
	// {
	// 	$this->db->order_by('deductionDesc', 'asc');
	// 	$this->db->join('tblDeduction', 'tblDeduction.deductionCode = tblEmpDeductionRemit.deductionCode', 'right');
	// 	$this->db->where('tblEmpDeductionRemit.deductionCode !=','UNDABS');
	// 	$res = $this->db->get_where('tblEmpDeductionRemit', array('empNumber' => $empno, 'processID' => $process_id))->result_array();
	// 	return $res;
	// }

	// function get_employee_salary($process_id, $empnumber)
	// {
	// 	$res = $this->db->get_where('tblEmpIncome', array('incomeCode' => 'SALARY', 'processID' => $process_id, 'empNumber' => $empnumber))->result_array();
		
	// 	return count($res) > 0 ? $res[0] : null;
	// }

	// function get_employee_undabs($process_id, $empnumber)
	// {
	// 	$res = $this->db->get_where('tblEmpDeductionRemit', array('deductionCode' => 'UNDABS', 'processID' => $process_id, 'empNumber' => $empnumber))->result_array();
	// 	return count($res) > 0 ? $res[0] : null;
	// }

	// function get_employee_overtime($process_id, $empnumber)
	// {
	// 	$res = $this->db->get_where('tblEmpIncome', array('incomeCode' => 'OT', 'processID' => $process_id, 'empNumber' => $empnumber))->result_array();
	// 	return count($res) > 0 ? $res[0] : null;
	// }



}