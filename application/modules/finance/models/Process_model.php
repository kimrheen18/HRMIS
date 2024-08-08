<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Process_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function add($arrData)
	{
		$this->db->insert('tblPayrollProcess', $arrData);
		return $this->db->insert_id();		
	}

	function edit($arrData, $id)
	{
		$this->db->where('process_id', $id);
		$this->db->update('tblPayrollProcess', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	public function delete($id)
	{
		$this->db->where('process_id', $id);
		$this->db->delete('tblPayrollProcess');
		return $this->db->affected_rows(); 
	}

	function getData($month, $yr)
	{
		$process = $this->db->join('tblAppointment', 'tblAppointment.appointmentCode = tblProcess.employeeAppoint', 'left')
							->order_by('employeeAppoint ASC, processCode ASC, processDate DESC')
							->where('processMonth',$month)
							->where('processYear',$yr)
							->get('tblProcess')->result_array();

		$arrProcess = array();
		foreach($process as $key => $proc):
			$proc['payroll_period'] = $proc['employeeAppoint']!='P' ? ' - period'.$proc['period'] : '';
			$p_groupname = $this->db->get_where('tblPayrollGroup', array('payrollGroupCode' => $proc['payrollGroupCode']))->result_array();
			$proc['payrollgroup_name'] = count($p_groupname) > 0 ? $p_groupname[0]['payrollGroupName'] : '';
			array_push($arrProcess, $proc);
		endforeach;
		return $arrProcess;
	}

	function getProcessData($id='')
	{
		if($id==''):
			return $this->db->join('tblAppointment', 'tblPayrollProcess.appointmentCode = tblAppointment.appointmentCode', 'inner')
							->distinct()
							->select('tblPayrollProcess.process_id,tblPayrollProcess.appointmentCode,tblPayrollProcess.processWith,tblPayrollProcess.computation, tblAppointment.appointmentDesc')
							->get('tblPayrollProcess')->result_array();
		else:
			$arrData = $this->db->get_where('tblPayrollProcess',array('process_id' => $id))->result_array();
			return $arrData[0];
		endif;
	}

	function isCodeExists($code, $action)
	{
		$result = $this->db->get_where('tblPayrollProcess', array('appointmentCode' => $code))->result_array();
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

	function getPayrollProcessed($emp,$process,$pmont,$pyear)
	{
		if($process != '*'){
			$condition['processCode'] = $process;	
		}
		if($emp != '*'){
			$condition['employeeAppoint'] = $emp;
		}
		
		$condition['processMonth'] = $pmont;
		$condition['processYear'] = $pyear;
		$res = $this->db->get_where('tblProcess',$condition)->result_array();
		return $res;
	}

	function deleteProcess($processid,$appt)
	{
		# delete tblEmpIncome where processid
		# update tblEmpDeductions set status=1
		# delete tblEmpDeductionRemit where processid
		/* if appt=JO; delete tblNonPermComputationInstance where appointmentCode=appt,month,yr,period;
			else delete tblNonPermComputationInstance where payrollGroupCode=appt,month,yr,period*/
		# delete tblProcess where processid
	}

	// public function getWorkingDays($month, $yr)
	// {
		
		
	// }




}
/* End of file Process_model.php */
/* Location: ./application/modules/finance/models/Process_model.php */