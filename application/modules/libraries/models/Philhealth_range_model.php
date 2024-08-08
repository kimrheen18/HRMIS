<?php 
/** 
Purpose of file:    Model for PhilHealth Range Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Philhealth_range_model extends CI_Model {

	var $table = 'tblPhilhealthRange';
	var $tableid = 'philHealthId';


	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getPhilhealth($intPhId = '')
	{		
		if($intPhId != "")
		{
			$this->db->where($this->tableid,$intPhId);
		}
		$this->db->order_by('philhealthFrom');
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function checkExist($strRangeFrom = '', $strRangeTo = '')
	{		
		$this->db->where('philhealthFrom',$strRangeFrom);
		$this->db->or_where('philhealthTo', $strRangeTo);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function save($arrData, $intPhId)
	{
		$this->db->where($this->tableid, $intPhId);
		$this->db->update($this->table, $arrData);
		// echo $this->db->last_query();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	
	function delete($intPhId)
	{
		$this->db->where($this->tableid, $intPhId);
		$this->db->delete($this->table);
		// echo $this->db->last_query();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
