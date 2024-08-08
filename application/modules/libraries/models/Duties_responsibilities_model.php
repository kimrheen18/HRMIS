<?php 
/** 
Purpose of file:    Model for Duties and Responsibilities Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Duties_responsibilities_model extends CI_Model {

	var $table = 'tblDuties';
	var $tableid = 'duties_index';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getData($intDutiesIndex = '')
	{		
		if($intDutiesIndex != "")
		{
			$this->db->where($this->tableid,$intDutiesIndex);
		}
		$this->db->order_by('tblDuties.'.$this->tableid,'ASC');
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function checkExist($strDuties = '')
	{		
		$this->db->where('duties',$strDuties);		
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function save($arrDuties, $intDutiesIndex)
	{
		$this->db->where($this->tableid, $intDutiesIndex);
		$this->db->update($this->table, $arrDuties);
		// echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intDutiesIndex)
	{
		$this->db->where($this->tableid, $intDutiesIndex);
		$this->db->delete($this->table); 	
		// echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
