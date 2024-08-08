<?php 
/** 
Purpose of file:    Model for Plantilla Duties Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plantilla_duties_model extends CI_Model {

	var $table = 'tblPlantillaDuties';
	var $tableid = 'plantilla_duties_index';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getData($strDuties = '')
	{		
		if($strDuties != "")
		{
			$this->db->where($this->tableid,$strDuties);
		}
		// $this->db->join('tblPlantilla','tblPlantilla.itemNumber = '.$this->table.'.itemDuties','left');
		$this->db->order_by('tblPlantillaDuties.'.$this->tableid,'ASC');
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
		$this->db->where('itemDuties',$strDuties);		
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function save($arrPDuties, $intPDutiesIndex)
	{
		$this->db->where($this->tableid, $intPDutiesIndex);
		$this->db->update($this->table, $arrPDuties);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intPDutiesIndex)
	{
		$this->db->where($this->tableid, $intPDutiesIndex);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
