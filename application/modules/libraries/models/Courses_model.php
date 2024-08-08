<?php 
/** 
Purpose of file:    Model for Course Library
Author:             Rose Anne Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Courses_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function add($arrData)
	{
		$this->db->insert('tblCourse', $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($strCode)
	{		
		$strSQL = " SELECT courseCode FROM tblCourse					
					WHERE 1=1 
					AND courseCode='".$strCode."'
					ORDER BY courseDesc
					";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}


	function getData($intCourseId="")
	{		
		// $where='';
		// if($intCourseId!="")
		// 	$where .= " AND courseId='".$intCourseId."'";
		
		// $strSQL = " SELECT * FROM tblCourse					
		// 			WHERE 1=1 
		// 			$where
		// 			ORDER BY courseDesc
		// 			";
		// //echo $strSQL;exit(1);				
		// $objQuery = $this->db->query($strSQL);
		// return $objQuery->result_array();
		$this->db->order_by('courseDesc');
		if($intCourseId!=''):
			return $this->db->get_where('tblCourse',array('courseId' => $intCourseId))->result_array();
		else:
			return $this->db->get('tblCourse')->result_array();
		endif;
	}			
		
	
	function save($arrData, $intCourseId)
	{
		$this->db->where('courseId',$intCourseId);
		$this->db->update('tblCourse', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intCourseId)
	{
		$this->db->where('courseId', $intCourseId);
		$this->db->delete('tblCourse'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
/* End of file Courses_model.php */
/* Location: ./application/modules/libraries/models/Courses_model.php */