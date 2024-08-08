<?php 
/** 
Purpose of file:    Model for Org Structure Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Org_structure_model extends CI_Model {

	var $table = 'tblGroup1';
	var $tableid = 'group1Code';
	var $table2 = 'tblGroup2';
	var $tableid2 = 'group2Code';
	var $table3 = 'tblGroup3';
	var $tableid3 = 'group3Code';
	var $table4 = 'tblGroup4';
	var $tableid4 = 'group4Code';
	var $table5 = 'tblGroup5';
	var $tableid5 = 'group5Code';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getData($strExecOffice = '')
	{		
		if($strExecOffice != "")
		{
			$this->db->where($this->tableid,$strExecOffice);
		}
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.$this->table.'.empNumber','left');
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
	function getServiceData($strServiceCode = '')
	{		
		if($strServiceCode != "")
		{
			$this->db->where($this->tableid2,$strServiceCode);
		}
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.$this->table2.'.empNumber','left');
		$objQuery = $this->db->get($this->table2);
		return $objQuery->result_array();	
	}
	function getDivisionData($strDivCode = '')
	{		
		if($strDivCode != "")
		{
			$this->db->where($this->tableid3,$strDivCode);
		}
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.$this->table3.'.empNumber','left');
		$objQuery = $this->db->get($this->table3);
		return $objQuery->result_array();	
	}
	function getSectionData($strSecCode = '')
	{		
		if($strSecCode != "")
		{
			$this->db->where($this->tableid4,$strSecCode);
		}
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.$this->table4.'.empNumber','left');
		$objQuery = $this->db->get($this->table4);
		return $objQuery->result_array();	
	}
	function getSectionData1($strSecCode = '')
	{		
		if($strSecCode != "")
		{
			$this->db->where($this->tableid5,$strSecCode);
		}
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.$this->table5.'.empNumber','left');
		$objQuery = $this->db->get($this->table5);
		return $objQuery->result_array();	
	}
	function getDepartmentData($strDeptCode = '')
	{		
		if($strDeptCode != "")
		{
			$this->db->where($this->tableid5,$strDeptCode);
		}
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.$this->table5.'.empNumber','left');
		$objQuery = $this->db->get($this->table5);
		return $objQuery->result_array();	
	}

	//adding details of exec, service, div and section
	function add_exec($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}
	function add_service($arrData)
	{
		$this->db->insert($this->table2, $arrData);
		return $this->db->insert_id();		
	}
	function add_division($arrData)
	{
		$this->db->insert($this->table3, $arrData);
		$this->db->last_query();
		return $this->db->insert_id();		
	}
	function add_section($arrData)
	{
		$this->db->insert($this->table4, $arrData);
		return $this->db->insert_id();		
	}
	function add_department($arrData)
	{
		$this->db->insert($this->table5, $arrData);
		return $this->db->insert_id();		
	}

	//checking duplications
	function checkExist($strExecOffice = '', $strExecName = '')
	{		
		$this->db->where('group1Code',$strExecOffice);
		$this->db->or_where('group1Name', $strExecName);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
	function checkService($strExecutive = '', $strServiceCode = '')
	{		
		$this->db->where('group2Code',$strExecutive);
		$this->db->or_where('group2Name', $strServiceCode);			
		
		$objQuery = $this->db->get($this->table2);
		return $objQuery->result_array();	
	}

	function checkDivision($strDivCode = '', $strDivName = '')
	{		
		$this->db->where('group3Code',$strDivCode);
		$this->db->or_where('group3Name', $strDivName);			
		
		$objQuery = $this->db->get($this->table3);
		return $objQuery->result_array();	
	}

	function checkSection($strSecCode = '', $strSecName = '')
	{		
		$this->db->where('group4Code',$strSecCode);
		$this->db->or_where('group4Name', $strSecName);			
		
		$objQuery = $this->db->get($this->table4);
		return $objQuery->result_array();	
	}

	function checkDepartment($strDeptCode = '', $strDeptName = '')
	{		
		$this->db->where('group5Code',$strDeptCode);
		$this->db->or_where('group5Name', $strDeptName);			
		
		$objQuery = $this->db->get($this->table5);
		return $objQuery->result_array();	
	}
	
	//saving edited details of exec, service, div and section
	function save_exec($arrData, $strExecOffice)
	{
		$this->db->where($this->tableid, $strExecOffice);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	function save_service($arrData, $strServiceCode)
	{
		$this->db->where($this->tableid2, $strServiceCode);
		$this->db->update($this->table2, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	function save_division($arrData, $strDivCode)
	{
		$this->db->where($this->tableid3, $strDivCode);
		$this->db->update($this->table3, $arrData);
		//echo $this->db->affected_rows();
		echo $this->db->last_query();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	function save_section($arrData, $strSecCode)
	{
		$this->db->where($this->tableid4, $strSecCode);
		$this->db->update($this->table4, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	function save_department($arrData, $strDeptCode)
	{
		$this->db->where($this->tableid5, $strDeptCode);
		$this->db->update($this->table5, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	
	//deleting details of exec, service, div and section
	function delete_exec($strExecOffice)
	{
		$this->db->where($this->tableid, $strExecOffice);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	function delete_service($strServiceCode)
	{
		$this->db->where($this->tableid2, $strServiceCode);
		$this->db->delete($this->table2); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	function delete_division($strDivCode)
	{
		$this->db->where($this->tableid3, $strDivCode);
		$this->db->delete($this->table3); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	function delete_section($strSecCode)
	{
		$this->db->where($this->tableid4, $strSecCode);
		$this->db->delete($this->table4); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	function delete_department($strDeptCode)
	{
		$this->db->where($this->tableid5, $strDeptCode);
		$this->db->delete($this->table5); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	
	function getData_group1($grp_code='')
	{
		if($grp_code!=''):
			return $this->db->get_where('tblGroup1', array('group1Code' => $grp_code))->result_array();
		else:
			return $this->db->get('tblGroup1')->result_array();
		endif;
	}

	function getData_group2($grp_code='')
	{
		if($grp_code!=''):
			return $this->db->get_where('tblGroup2', array('group2Code' => $grp_code))->result_array();
		else:
			return $this->db->get('tblGroup2')->result_array();
		endif;
	}

	function getData_group3($grp_code='')
	{
		if($grp_code!=''):
			return $this->db->get_where('tblGroup3', array('group3Code' => $grp_code))->result_array();
		else:
			return $this->db->get('tblGroup3')->result_array();
		endif;
	}

	function getData_group4($grp_code='')
	{
		if($grp_code!=''):
			return $this->db->get_where('tblGroup4', array('group4Code' => $grp_code))->result_array();
		else:
			return $this->db->get('tblGroup4')->result_array();
		endif;
	}

	function getData_group5($grp_code='')
	{
		if($grp_code!=''):
			return $this->db->get_where('tblGroup5', array('group5Code' => $grp_code))->result_array();
		else:
			return $this->db->get('tblGroup5')->result_array();
		endif;
	}

	function getData_allgroups()
	{
		$res['arrGroup1'] = $_ENV['Group1'] !='' ? $this->getData_group1() : array();
		$res['arrGroup2'] = $_ENV['Group2'] !='' ? $this->getData_group2() : array();
		$res['arrGroup3'] = $_ENV['Group3'] !='' ? $this->getData_group3() : array();
		$res['arrGroup4'] = $_ENV['Group4'] !='' ? $this->getData_group4() : array();
		$res['arrGroup5'] = $_ENV['Group5'] !='' ? $this->getData_group5() : array();

		return $res;
	}
		
}
