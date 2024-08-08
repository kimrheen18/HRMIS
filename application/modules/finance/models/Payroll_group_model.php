<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payroll_group_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function add($arrData)
	{
		$this->db->insert('tblPayrollGroup', $arrData);
		return $this->db->insert_id();
	}

	function edit($arrData, $code)
	{
		$this->db->where('payrollGroupCode',$code);
		$this->db->update('tblPayrollGroup', $arrData);
		return $this->db->affected_rows();
	}

	public function delete($code)
	{
		$this->db->where('payrollGroupCode', $code);
		$this->db->delete('tblPayrollGroup');
		return $this->db->affected_rows(); 
	}

	function getData($code='')
	{
		if($code==''):
			return $this->db->join('tblProject', 'tblProject.projectCode = tblPayrollGroup.projectCode', 'left')->order_by('payrollGroupCode','ASC')->get('tblPayrollGroup')->result_array();
		else:
			$result = $this->db->get_where('tblPayrollGroup', array('payrollGroupCode' => $code))->result_array();
			return $result[0];
		endif;
	}

	function getDataById($id='')
	{
		if($id==''):
			return $this->db->join('tblProject', 'tblProject.projectCode = tblPayrollGroup.projectCode', 'left')->order_by('payrollGroupCode','ASC')->get('tblPayrollGroup')->result_array();
		else:
			$result = $this->db->get_where('tblPayrollGroup', array('payrollGroupId' => $id))->result_array();
			return $result[0];
		endif;
	}

	function getPayrollGroupCode($code='')
	{
		if($code==''):
			return $this->db->get('tblPayrollGroup')->result_array();
		else:
			return $this->db->get_where('tblPayrollGroup', array('payrollGroupCode' => $code))->result_array();
		endif;
	}
	
	function isCodeExists($code, $action)
	{
		$result = $this->db->get_where('tblPayrollGroup', array('payrollGroupCode' => $code))->result_array();
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
		
}
/* End of file ProjectCode_model.php */
/* Location: ./application/modules/finance/models/ProjectCode_model.php */