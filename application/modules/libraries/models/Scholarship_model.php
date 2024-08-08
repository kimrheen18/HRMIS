<?php 
/** 
Purpose of file:    Model for Scholarship Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Scholarship_model extends CI_Model {

	var $table = 'tblScholarship';
	var $tableid = 'id';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intScholarshipId = '')
	{		
		$this->db->order_by('description');
		if($intScholarshipId!=''):
			return $this->db->get_where('tblScholarship',array('id' => $intScholarshipId))->result_array();
		else:
			return $this->db->get('tblScholarship')->result_array();
		endif;

	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function checkExist($strScholarship = '')
	{		
		
		$this->db->where('description',$strScholarship);			
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
				
	function save($arrData, $intScholarshipId)
	{
		$this->db->where($this->tableid, $intScholarshipId);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	
	function delete($intScholarshipId)
	{
		$this->db->where($this->tableid, $intScholarshipId);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
