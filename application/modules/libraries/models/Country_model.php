<?php 
/** 
Purpose of file:    Model for Country Library
Author:             Edgardo P. Catorce Jr.
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Country_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getData($intCountryId = '')
	{		
		$strWhere='';
		if($intCountryId != "")
			$strWhere .= " AND countryId='".$intCountryId."'";
		
		$strSQL = " SELECT * FROM tblCountry					
					WHERE 1=1 
					$strWhere
					ORDER BY countryName
					";
		//]echo $strSQL;exit(1);				
		$objQuery = $this->db->query($strSQL);
		//print_r($objQuery->result_array());
		return $objQuery->result_array();	
	}			
		
	function add($arrData)
	{
		$this->db->insert('tblCountry', $arrData);
		return $this->db->insert_id();		
	}
	
	// check if country name or country code already exist
	function checkExist($strCountryName = '', $strCountryCode = '')
	{		
		/*
		$strWhere = '';
		if($strCountryName!='')
			$strWhere .= " OR countryName ='".$strCountryName."'";

		if($strCountryCode!='')
			$strWhere .= " OR countryCode ='".$strCountryCode."'";
		*/
		$strSQL = " SELECT * FROM tblCountry					
					WHERE  
					countryName ='$strCountryName' OR
					countryCode ='$strCountryCode'					
					";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}
	
	function save($arrData, $intCountryId)
	{
		$this->db->where('countryId', $intCountryId);
		$this->db->update('tblCountry', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intCountryId)
	{
		$this->db->where('countryId', $intCountryId);
		$this->db->delete('tblCountry'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
