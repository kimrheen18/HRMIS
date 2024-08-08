<?php 
/** 
Purpose of file:    Model for Educational level Library
Author:             Rose Anne Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Educ_level_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intEducLevelId = '')
	{
		$this->db->order_by('levelCode');
		if($intEducLevelId != ""):
			return $this->db->get_where('tblEducationalLevel', array('levelId' => $intEducLevelId))->result_array();
		else:
			return $this->db->get('tblEducationalLevel')->result_array();
		endif;	
	}

	function add($arrData)
	{
		$this->db->insert('tblEducationalLevel', $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($strEducLevelCode = '', $strEducLevelDesc = '')
	{		
		$strSQL = " SELECT * FROM tblEducationalLevel					
					WHERE  
					levelCode ='$strEducLevelCode' OR
					levelDesc ='$strEducLevelDesc'					
					";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}

				
		
	function save($arrData, $intEducLevelId)
	{
		$this->db->where('levelId', $intEducLevelId);
		$this->db->update('tblEducationalLevel', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intEducLevelId)
	{
		$this->db->where('levelId', $intEducLevelId);
		$this->db->delete('tblEducationalLevel'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
