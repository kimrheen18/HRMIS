<?php 
/** 
Purpose of file:    Model for Employment Status Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Separation_mode_model extends CI_Model {

	var $table = 'tblSeparationCause';
	var $tableid = 'separationCause';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getData($strMode = '')
	{		
		if($strMode != "")
		{
			$this->db->where($this->tableid,$strMode);
		}
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($strMode = '')
	{		
		$this->db->where('separationCause',$strMode);
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
	
	function save($arrData, $strMode)
	{
		$this->db->where($this->tableid, $strMode);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($strMode)
	{
		$this->db->where($this->tableid, $strMode);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
