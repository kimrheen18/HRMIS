<?php 
/** 
Purpose of file:    Model for Plantilla Group Library
Author:             Edgardo P. Catorce Jr.
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plantilla_group_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intPlantillaGroupId = '')
	{		
		$strWhere = '';
		if($intPlantillaGroupId != "")
			$strWhere .= " AND plantillaGroupId = '".$intPlantillaGroupId."'";
		
		$strSQL = " SELECT * FROM tblPlantillaGroup					
					WHERE 1=1 
					$strWhere
					ORDER BY plantillaGroupOrder
					";
		//]echo $strSQL;exit(1);				
		$objQuery = $this->db->query($strSQL);
		//print_r($objQuery->result_array());
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert('tblPlantillaGroup', $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($strPlantillaGroupCode = '', $strPlantillaGroupName = '')
	{		
		$strSQL = " SELECT * FROM tblPlantillaGroup					
					WHERE  
					plantillaGroupCode ='$strPlantillaGroupCode' OR
					plantillaGroupName ='$strPlantillaGroupName'					
					";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}

				
		
	function save($arrData, $intPlantillaGroupId)
	{
		$this->db->where('plantillaGroupId', $intPlantillaGroupId);
		$this->db->update('tblPlantillaGroup', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intPlantillaGroupId)
	{
		$this->db->where('plantillaGroupId', $intPlantillaGroupId);
		$this->db->delete('tblPlantillaGroup'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
