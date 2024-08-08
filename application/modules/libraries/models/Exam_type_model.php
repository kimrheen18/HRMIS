<?php 
/** 
Purpose of file:    Model for Exam Type Library
Author:             Rose Anne Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exam_type_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intExamId = '')
	{
		if($intExamId!=''):
			return $this->db->order_by('examDesc', 'ASC')->get_where('tblExamType',array('examId' => $intExamId))->result_array();
		else:
			return $this->db->order_by('examDesc', 'ASC')->get('tblExamType')->result_array();
		endif;
	}

	function add($arrData)
	{
		$this->db->insert('tblExamType', $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($strExamCode = '', $strExamDesc = '')
	{		
		$strSQL = " SELECT * FROM tblExamType					
					WHERE  
					examCode ='$strExamCode' OR
					examDesc ='$strExamDesc'					
					";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}			
		
	function save($arrData, $intExamId)
	{
		$this->db->where('examId', $intExamId);
		$this->db->update('tblExamType', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intExamId)
	{
		$this->db->where('examId', $intExamId);
		$this->db->delete('tblExamType'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
