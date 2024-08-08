<?php 
/** 
Purpose of file:    Model for Back up Library
Author:             Rose Anne Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Backup_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		$this->table = 'tblBackup';
	}
	
	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		// log_action($this->db->last_query(), 'Add Backup');
		return $this->db->insert_id();		
	}

	function getData($id=0)
	{
		if($id==0):
			return $this->db->get($this->table)->result_array();
		else:
			$result = $this->db->get_where($this->table, array('id' => $id))->result_array();
			return $result[0];
		endif;
	}
	

		
}
/* End of file Courses_model.php */
/* Location: ./application/modules/libraries/models/Courses_model.php */