<?php 
/** 
Purpose of file:    Model for Travel Order
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Travelorder_model extends CI_Model {

	var $table = 'tblEmpRequest';
	var $tableid = 'requestID';

	function __construct()
	{
		$this->load->database();
		$this->db->initialize();	
	}
	
	function getData($intReqId = '')
	{		
		$strWhere = '';
		if($intReqId != "")
			$strWhere .= " AND requestID = '".$intReqId."'";
		
		$strSQL = " SELECT * FROM tblEmpRequest					
					WHERE 1=1 
					$strWhere
					ORDER BY requestDate
					";
			
		$objQuery = $this->db->query($strSQL);
		//print_r($objQuery->result_array());
		return $objQuery->result_array();	
	}

	function submit($arrData)
	{
		$this->db->insert('tblEmpRequest', $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($dtmTOdatefrom = '')
	{		
		$strSQL = " SELECT * FROM tblEmpRequest					
					WHERE  
					-- requestDetails ='' AND
					requestDetails ='$dtmTOdatefrom'					
					";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}

	function save($arrData, $intReqId)
	{
		$this->db->where('requestID', $intReqId);
		$this->db->update('tblEmpRequest', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intReqId)
	{
		$this->db->where('requestID', $intReqId);
		$this->db->delete('tblEmpRequest'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function getEmployeeTO($empid,$datefrom,$dateto)
	{
		$this->db->where('empNumber', $empid);
		$this->db->where("(toDateFrom between '".$datefrom."' and '".$dateto."' or toDateTo between '".$datefrom."' and '".$dateto."')");
		return $this->db->get('tblEmpTravelOrder')->result_array();
	}
		
}
