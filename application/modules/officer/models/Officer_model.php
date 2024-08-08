<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Officer_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}

	public function get_allemp($group)
	{
		$this->db->order_by('surname', 'asc');
		$this->db->join('tblEmpPersonal', 'tblEmpPersonal.empNumber = tblEmpPosition.empNumber');

		$this->db->where('statusOfAppointment', 'In-Service');
		$this->db->where("(group1 = '".$group."' or group2 = '".$group."' or group3 = '".$group."' or group4 = '".$group."' or group5 ='".$group."')");

		return $this->db->get('tblEmpPosition')->result_array();
	}



		
}
