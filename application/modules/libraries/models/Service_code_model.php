<?php 
/** 
Purpose of file:    Model for Service Code Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Service_code_model extends CI_Model {

	var $table = 'tblServiceCode';
	var $tableid = 'serviceId';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intServiceId = '')
	{		
		
		if($intServiceId != "")
		{
			$this->db->where($this->tableid,$intServiceId);
		}
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function checkExist($strServiceCode = '', $strServiceDescription = '')
	{		
		
		$this->db->where('serviceCode',$strServiceCode);
		$this->db->or_where('serviceDesc', $strServiceDescription);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
	
	function save($arrData, $intServiceId)
	{
		$this->db->where($this->tableid, $intServiceId);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intServiceId)
	{
		$this->db->where($this->tableid, $intServiceId);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
}
