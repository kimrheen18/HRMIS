<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payroll_process_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function getData($process_id=0)
	{
		if($process_id == 0):
			return $this->db->get('tblProcess')->result_array();
		else:
			$res = $this->db->get_where('tblProcess',array('processID' => $process_id))->result_array();
			return !empty($res) ? $res[0] : array();
		endif;
	}

	function getemployee_income($process_id)
	{
		return $this->db->get_where('tblEmpIncome',array('processID' => $process_id))->result_array();
	}
	function get_incomedesc($incomecode)
	{
		$res = $this->db->get_where('tblIncome',array('incomecode' => $incomecode))->result_array();
		return count($res) > 0 ? $res[0]['incomeDesc'] : $incomecode;
	}

	function getemployee_deductionremit($process_id)
	{
		$this->db->join('tblDeduction', 'tblDeduction.deductionCode = tblEmpDeductionRemit.deductionCode','left');
		return $this->db->get_where('tblEmpDeductionRemit',array('processID' => $process_id))->result_array();
	}

	function get_rata_details($code='')
	{
		if($code != ''):
			return $this->db->get_where('tblRATA',array('RATACode' => $code))->result_array();
		else:
			return $this->db->get('tblRATA')->result_array();
		endif;
	}

	function get_process_code($process_id)
	{
		set_sql_mode();
		$deduction_codes = $this->db->group_by('deductionCode')->get_where('tblEmpDeductionRemit',array('processID' => $process_id))->result_array();
		$income_codes = $this->db->group_by('incomeCode')->get_where('tblEmpIncome',array('processID' => $process_id))->result_array();
		return array_filter(array_merge(array_column($deduction_codes,'deductionCode'),array_column($income_codes,'incomeCode')));
	}

	function get_process_by_appointment($appt,$month,$yr,$period=0)
	{
		if($period!=0):
			if($appt != 'P'){
				$this->db->where('tblProcess.period',$period);
			}
		endif;
		$process = $this->db->get_where('tblProcess',array('employeeAppoint' => $appt, 'processMonth' => ltrim($month,'0'), 'processYear' => $yr))->result_array();
		foreach($process as $key => $p):
			$process[$key]['codes'] = $this->get_process_code($p['processID']);
		endforeach;

		return $process;
	}

	function get_payroll_process($month='',$yr='',$appt='',$processid='')
	{
		if($month!=''):
			$this->db->where('processMonth',ltrim($month,'0'));
		endif;
		if($yr!=''):
			$this->db->where('processYear',$yr);
		endif;
		if($appt!=''):
			$this->db->where('employeeAppoint',$appt);
		endif;
		if($processid!=''):
			$this->db->where('processID',$processid);
		endif;
		$this->db->join('tblAppointment','tblAppointment.appointmentCode = tblProcess.employeeAppoint','left');
		$process = $this->db->get('tblProcess')->result_array();
		
		return $process;
	}

	# Add payroll process
	function add_payroll_process($arrData)
	{
		$this->db->insert('tblProcess', $arrData);
		return $this->db->insert_id();
	}

	# Add processed project
	function add_processed_project($arrData)
	{
		$this->db->insert('tblProcessedEmployees', $arrData);
		return $this->db->insert_id();
	}

	# Add processed employees
	function add_processed_employees($arrData)
	{
		$this->db->insert('tblProcessedProject', $arrData);
		return $this->db->insert_id();
	}

	# Add processed pgroup
	function add_processed_pgroup($arrData)
	{
		$this->db->insert('tblProcessedPayrollGroup', $arrData);
		return $this->db->insert_id();
	}

	# delete payroll process
	function delete_payroll_process($month,$yr)
	{
		$this->db->delete('tblProcess', array('processMonth' => ltrim($month,'0'), 'processYear' => $yr));
	}

	function delete_payroll_process_byid($id)
	{
		$this->db->delete('tblProcess', array('processID' => $id));
	}

	function getall_process($month='all',$yr)
	{
		if($month == 'all'):
			$condition = array('processYear' => $yr);
		else:
			$condition = array('processMonth' => $month, 'processYear' => $yr);
		endif;

		$this->db->order_by('processDate');
		$this->db->join('tblAppointment','tblAppointment.appointmentCode = tblProcess.employeeAppoint','left');
		$process = $this->db->get_where('tblProcess', $condition)->result_array();

		foreach($process as $key => $proc):
			$process[$key]['details'] = implode(', ',$this->getprocess_details($proc['processID']));
		endforeach;
		
		return $process;
	}

	function getprocess_details($process_id)
	{
		$process_details = $this->db->distinct()->select('deductionCode')->get_where('tblEmpDeductionRemit', array('processID' => $process_id))->result_array();
		return array_column($process_details,'deductionCode');
	}

	function edit_payroll_process($arrData,$procid)
	{
		$this->db->where('processID',$procid);
		$this->db->update('tblProcess', $arrData);
		return $this->db->affected_rows();
	}

	function getEmployees($appt_code,$empid='',$tblposition=0,$tblproject=0)
	{
		$payroll_process = $this->db->get_where('tblPayrollProcess', array('appointmentCode' => $appt_code))->result_array();

		if(count($payroll_process) > 0):
			$condition['statusOfAppointment'] = 'In-Service';
			$condition['payrollSwitch'] = 'Y';
			if($empid!=''):
				$condition['tblEmpPersonal.empNumber'] = $empid;
			endif;
			# Employees
			$this->db->select("tblEmpPersonal.empNumber,tblEmpPersonal.surname,tblEmpPersonal.firstname,tblEmpPersonal.middlename,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension,tblEmpPosition.payrollGroupCode,
							    tblEmpPosition.authorizeSalary,tblEmpPosition.actualSalary,tblEmpPosition.hpFactor,tblEmpPosition.RATACode,tblEmpPosition.RATAVehicle,
							    tblEmpPosition.schemeCode,tblEmpPosition.payrollSwitch,tblEmpPosition.positionCode,tblEmpPosition.positionCode,tblEmpPosition.appointmentCode,
							    tblEmpPosition.officeCode,tblEmpPosition.taxSwitch");
			$this->db->join('tblEmpPersonal', 'tblEmpPersonal.empNumber = tblEmpPosition.empNumber');
			if($tblposition==1){
				$this->db->select("tblPosition.positionAbb");
				$this->db->join('tblPosition', 'tblEmpPosition.positionCode = tblPosition.positionCode');
			}
			if($tblproject==1){
				$this->db->select('tblProject.projectCode,tblProject.projectDesc,tblProject.projectOrder,tblPayrollGroup.payrollGroupName,tblPayrollGroup.payrollGroupOrder');
				$this->db->join('tblPayrollGroup', 'tblEmpPosition.payrollGroupCode = tblPayrollGroup.payrollGroupCode');
				$this->db->join('tblProject', 'tblProject.projectCode = tblPayrollGroup.projectCode');
			}
			$this->db->where_in('appointmentCode', explode(',',$payroll_process[0]['processWith']));
			$employees = $this->db->get_where('tblEmpPosition',$condition)->result_array();

			return $employees;
		endif;
	}

	function process_with($appt_code)
	{
		$res = $this->db->get_where('tblPayrollProcess', array('appointmentCode' => $appt_code))->result_array();
		return count($res) > 0 ? $res[0] : null;
	}

	function update_or($arrData,$processid,$deduction_code,$empid)
	{
		$this->db->where('processID',$processid);
		$this->db->where('deductionCode',$deduction_code);
		$this->db->where('empNumber',$empid);
		$this->db->update('tblEmpDeductionRemit', $arrData);
		return $this->db->affected_rows();
	}

	function update_orby_remitt($arrData,$remitt_id)
	{
		$this->db->where('remitt_id',$remitt_id);
		$this->db->update('tblEmpDeductionRemit', $arrData);
		return $this->db->affected_rows();
	}

	function get_orlist($processid='',$deduction_code='',$isnull=0)
	{
		$this->db->select('tblProcess.processID,tblProcess.empNumber,tblProcess.processMonth,tblProcess.processYear,tblProcess.employeeAppoint,tblDeduction.deductionDesc,tblDeduction.deductionCode,tblEmpDeductionRemit.deductMonth,tblEmpDeductionRemit.deductYear,tblEmpDeductionRemit.orNumber,tblEmpDeductionRemit.orDate,tblEmpDeductionRemit.remitt_id');
		$this->db->join('tblDeduction','tblDeduction.deductionCode = tblEmpDeductionRemit.deductionCode');
		$this->db->join('tblProcess','tblProcess.processID = tblEmpDeductionRemit.processID');
		
		if($isnull == 1){
			$this->db->where('orNumber IS NULL', null, false);
			$this->db->where('orDate IS NULL', null, false);
		}else{
			$this->db->where('orNumber IS NOT NULL', null, false);
			$this->db->where('orDate IS NOT NULL', null, false);
		}
		
		if($processid!=''){
			$this->db->where('tblProcess.processID',$processid);
		}
		if($deduction_code!=''){
			$this->db->where('tblDeduction.deductionCode',$deduction_code);
		}

		$res = $this->db->get('tblEmpDeductionRemit')->result_array();
		
		return $res;
	}

	function get_deduction_remit($remitt_id)
	{
		$res = $this->db->get_where('tblEmpDeductionRemit', array('remitt_id' => $remitt_id))->result_array();
		return count($res) > 0 ? $res[0] : null;
	}


}
/* End of file Process_model.php */
/* Location: ./application/modules/finance/models/Process_model.php */