<?php 
/** 
Purpose of file:    Model for Signatory Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Signatory_model extends CI_Model {

	var $table = 'tblsignatory';
	var $tableid = 'signatoryId';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intSignatoryId = '')
	{		
		if($intSignatoryId != "")
		{
			$this->db->where($this->tableid,$intSignatoryId);
		}
		$this->db->join('tblPayrollGroup','tblpayrollgroup.payrollGroupCode = '.$this->table.'.payrollGroupCode','left');
		$this->db->order_by('tblsignatory.'.$this->tableid,'ASC');
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function checkExist($strPayrollGroupCode = '', $strSignatory = '', $strPosition = '')
	{		
		
		$this->db->where('payrollGroupCode',$strPayrollGroupCode);
		$this->db->or_where('signatory', $strSignatory);			
		$this->db->or_where('signatoryPosition', $strPosition);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
	
	function save($arrData, $intSignatoryId)
	{
		$this->db->where($this->tableid, $intSignatoryId);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intSignatoryId)
	{
		$this->db->where($this->tableid, $intSignatoryId);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
}
