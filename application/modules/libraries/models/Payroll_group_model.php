<?php 
/** 
Purpose of file:    Model for Payroll Group Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payroll_group_model extends CI_Model {

	var $table = 'tblPayrollGroup';
	var $tableid = 'payrollGroupCode';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getData($intPayrollGroupId = '')
	{		
		if($intPayrollGroupId != "")
		{
			$this->db->where('payrollGroupId',$intPayrollGroupId);
		}
		$this->db->join('tblProject','tblProject.projectCode = '.$this->table.'.projectCode','left');
		$this->db->order_by('tblPayrollGroup.'.$this->tableid,'ASC');
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	

	}

	// function getProject($intProjectId = '')
	// {		
	// 	if($intProjectId != "")
	// 	{
	// 		$this->db->where('projectId',$intProjectId);
	// 	}
		
	// 	$objQuery = $this->db->get('tblproject');
	// 	return $objQuery->result_array();	
	// }

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function checkExist($strPayrollGroupCode = '', $strPayrollGroupdesc = '')
	{		
		$this->db->where('payrollGroupCode',$strPayrollGroupCode);
		$this->db->or_where('payrollGroupName', $strPayrollGroupdesc);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function save($arrData, $intPayrollGroupId)
	{
		$this->db->where('payrollGroupId', $intPayrollGroupId);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		echo $this->db->last_query();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intPayrollGroupId)
	{
		$this->db->where($this->tableid, $intPayrollGroupId);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	
	public function deleteById($id)
	{
		$this->db->where('payrollGroupId', $id);
		$this->db->delete('tblPayrollGroup');
		return $this->db->affected_rows(); 
	}
	
}
