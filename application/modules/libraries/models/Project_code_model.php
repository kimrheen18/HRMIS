<?php 
/** 
Purpose of file:    Model for Project Code Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Project_code_model extends CI_Model {

	var $table = 'tblProject';
	var $tableid = 'projectId';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intProjectId = '')
	{		
		if($intProjectId != "")
		{
			$this->db->where($this->tableid,$intProjectId);
		}
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($strProjectCode = '', $strProjectDescription = '')
	{		
		
		$this->db->where('projectCode',$strProjectCode);
		$this->db->or_where('projectDesc', $strProjectDescription);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function save($arrData, $intProjectId)
	{
		$this->db->where($this->tableid, $intProjectId);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intProjectId)
	{
		$this->db->where($this->tableid, $intProjectId);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
