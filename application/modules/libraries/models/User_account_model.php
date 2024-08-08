<?php 
/** 
Purpose of file:    Model for User Account Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_account_model extends CI_Model {

	var $table = 'tblEmpAccount';
	var $tableid = 'empNumber';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intEmpNumber = '')
	{		
		if($intEmpNumber != "")
		{
			$this->db->where($this->tableid,$intEmpNumber);
		}
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();		
	}

	function getEmpDetails($intEmpNumber = '')
	{		
	    if($intEmpNumber != "")
		{
			$this->db->where($this->tableid,$intEmpNumber);
		}
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.$this->table.'.empNumber','left');
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function getUserLevel($strULevel = '')
	{		
		if($strULevel != "")
		{
			$this->db->where('userLevel',$strULevel);
		}
		// $this->db->group_by('userLevel');
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();		
	}

	function getPayrollGroup($intPGroup = '')
	{		
		if($intPGroup != "")
		{
			$this->db->where('payrollGroupId',$intPGroup);
		}
		// $this->db->group_by('payrollGroupName');
		$objQuery = $this->db->get('tblPayrollGroup');
		return $objQuery->result_array();		
	}

	
	function add($arrData)
	{			
		$this->db->insert($this->table, $arrData);
		// echo $this->db->last_query();
		return $this->db->insert_id();	
	}
	
	function checkExist($strAccessLevel = '', $strUsername = '')
	{		

		$this->db->where('userLevel',$strAccessLevel);
		$this->db->or_where('userName', $strUsername);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function check_user_exists($username,$empnumber)
	{
		$this->db->where('userName',$username);
		$this->db->or_where('empNumber',$empnumber);
		return $this->db->get('tblEmpAccount')->result_array();
	}

	function save($arrData, $intEmpNumber)
	{
		$this->db->where($this->tableid, $intEmpNumber);
		$this->db->update($this->table, $arrData);
		// echo $this->db->last_query();
		// exit(1);
		// echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intEmpNumber)
	{
		$this->db->where($this->tableid, $intEmpNumber);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	
	function getemployee_forapi($empnumber = '')
	{
		# personal
		$this->db->select('tblEmpPersonal.empNumber,tblEmpPersonal.surname,tblEmpPersonal.firstname,tblEmpPersonal.middlename,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension,tblEmpPersonal.sex,tblEmpPersonal.birthday,tblEmpPersonal.mobile,tblEmpPersonal.email,tblEmpPersonal.telephone1,tblEmpPosition.positionCode,tblPosition.positionDesc,tblEmpPosition.group3,tblEmpPosition.appointmentCode,tblGroup3.empNumber AS divhead');
		# user account
		$this->db->select('tblEmpAccount.userName,tblEmpAccount.userPassword');

		$this->db->join('tblEmpAccount','tblEmpAccount.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition','tblPosition.positionCode = tblEmpPosition.positionCode','left');
		$this->db->join('tblGroup3','tblGroup3.group3Code = tblEmpPosition.group3','left');

		$this->db->order_by('tblEmpPersonal.surname', 'ASC');

		if($empnumber == ''):
			$res = $this->db->get_where('tblEmpPosition',array('tblEmpPosition.statusOfAppointment' => 'In-Service'))->result_array();
		else:
			$res = $this->db->get_where('tblEmpPosition',array('tblEmpPosition.empNumber' => $empnumber))->result_array();
			$res[0]['office_code'] = employee_office($empnumber);
			$res[0]['office_name'] = office_name($res[0]['office_code']);
			$res = $res[0];
		endif;

		return $res;
	}

	function getdivision_forapi()
	{
		$this->db->order_by('group3Name', 'ASC');
		$res = $this->db->get('tblGroup3')->result_array();
		return $res;
	}

	function getgroups_forapi()
	{
		$this->db->select('tblGroup3.group3Code, tblGroup3.group2Code, tblGroup3.group1Code, tblGroup3.empNumber AS g3empNumber, tblGroup2.empNumber AS g2empNumber, tblGroup1.empNumber AS g1empNumber, group3Name');

		$this->db->join('tblGroup2','tblGroup2.group2Code = tblGroup3.group2Code','left');
		$this->db->join('tblGroup1','tblGroup1.group1Code = tblGroup3.group1Code','left');
		$this->db->order_by('group3Name', 'ASC');
		$res = $this->db->get('tblGroup3')->result_array();
		return $res;
	}


}
