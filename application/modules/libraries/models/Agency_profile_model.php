<?php 
/** 
Purpose of file:    Model for Agency Profile Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agency_profile_model extends CI_Model {

	var $table = 'tblAgency';
	var $tableid = 'agencyName';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intAgencyName = '')
	{		
		if($intAgencyName != "")
		{
			$this->db->where($this->tableid,$intAgencyName);
		}
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function getImage($ImageId = '')
	{		
		if($intAgencyName != "")
		{
			$this->db->where($this->tableid,$intAgencyName);
		}
		$this->db->join('tblagencyimages','tblagencyimages.id = '.$this->table.'.agencyName','left');
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function checkExist($strAgencyName = '', $strAgencyCode = '')
	{		
		
		$this->db->where('agencyName',$strAgencyName);
		$this->db->or_where('agencyCode', $strAgencyCode);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
	
	function save($arrData, $strAgencyName)
	{
		$this->db->where($this->tableid, $strAgencyName);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function saveImage($arrData, $ImageId)
	{
		$this->db->where('id', $ImageId);
		$this->db->update('tblagencyimages', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($strAgencyName)
	{
		$this->db->where($this->tableid, $strAgencyName);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	// upload logo
	// function edit_logo($arrLogo, $ImageId)
	// {
	// 	$this->db->where('id',$ImageId);
	// 	$this->db->update('tblAgencyImages', $arrLogo);
	// 	//echo $this->db->affected_rows();
	// 	return $this->db->affected_rows()>0?TRUE:FALSE;
	// }


}
