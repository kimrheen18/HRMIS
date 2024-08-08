<?php 
/** 
Purpose of file:    Model for Salary Schedule Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Salary_sched_model extends CI_Model {

	var $table = 'tblSalarySchedVersion';
	var $tableid = 'version';

	var $table2 = 'tblSalarySched';
	var $tableid2 = 'version';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getVersion($intVersion = '',$blnActive='')
	{		
		if($intVersion != "")
		{
			$this->db->where($this->tableid,$intVersion);
		}
		if($blnActive)
		{
			$this->db->where('active',1);
		}
		
		//$this->db->join('tblsalarysched','tblsalarysched.version = '.$this->table.'.version','left');
		$objQuery = $this->db->get($this->table);
		// echo $this->db->last_query();
		return $objQuery->result_array();	
	}	

	function getSG($strSG = '')
	{		
		if($strSG != "")
		{
			$this->db->where('salaryGradeNumber',$strSG);
		}
		$this->db->select('distinct(salaryGradeNumber)')
				 ->order_by('salaryGradeNumber', 'ASC');
		$objQuery = $this->db->get($this->table2);
		return $objQuery->result_array();	
	}	

	function getStepNum($intStepNum = '')
	{		
		if($intStepNum != "")
		{
			$this->db->where('stepNumber',$intStepNum);
		}
		$this->db->select('distinct(stepNumber)')
				 ->order_by('stepNumber', 'ASC');
		$objQuery = $this->db->get($this->table2);
		return $objQuery->result_array();	
	}	


	function getSchedHeader($field, $version)
	{		
		$this->db->select('distinct('.$field.')')
		         ->from('tblSalarySched')
		         ->order_by($field, 'ASC');
		         // ->where('version', $version);
		$objQuery = $this->db->get();

		return $objQuery->result_array();	
	}

	function getDataSched($strSalarySched = '')
	{		
		if($strSalarySched != "")
		{
			$this->db->where($this->tableid2,$strSalarySched);
		}else{
			$this->db->where($this->tableid2,1);
		}

		//$this->db->join('tblsalarysched','tblsalarysched.version = '.$this->table.'.version','left');
		$objQuery = $this->db->get($this->table2);
		return $objQuery->result_array();	
	}		

	function checkExist($strNewSalarySched = '')
	{		
		
		$this->db->where('title',$strNewSalarySched);
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function checkExistSalary($strSalarySched = '',$strSG = '',$intStepNum = '')
	{		
		
		$this->db->where('version',$strSalarySched);
		$this->db->where('salaryGradeNumber',$strSG);
		$this->db->where('stepNumber',$intStepNum);
		
		$objQuery = $this->db->get($this->table2);
		return $objQuery->result_array();	
	}

	function getSalarySched($strSG = '',$intStepNum = '',$intSalary = '')
	{		
		
		$this->db->where('salaryGradeNumber',$strSG);
		$this->db->where('stepNumber',$intStepNum);
		$this->db->where('actualSalary',$intSalary);
		
		$objQuery = $this->db->get($this->table2);
		//echo $this->db->last_query();

		return $objQuery->result_array();	
	}
		
	function add($arrData)
	{
		$this->db->insert('tblSalarySchedVersion', $arrData);
		return $this->db->insert_id();		
	}

	function add_sched($arrData)
	{
		$this->db->insert('tblSalarySched', $arrData);
		return $this->db->insert_id();		
	}

	function add_existing($arrData, $intFromVersion)
	{
		$this->db->insert('tblSalarySchedVersion', $arrData);		
		$intVersion= $this->db->insert_id();		
		
		$this->db->where('version',$intFromVersion);
		$objQuery=$this->db->get($this->table2);
		$result= $objQuery->result_array();	
		
		foreach ($result as $row)
			{
				$arrData = array(
						'stepNumber'=>$row['stepNumber'],
						'salaryGradeNumber'=>$row['salaryGradeNumber'],
						'actualSalary'=>$row['actualSalary'],
						'version'=>$intVersion			
					);
			  	$this->db->insert($this->table2, $arrData);
			}	
		
			
	}
	
	
	// function updateSalary($intVersion){
	// 	$result=mysql_query("SELECT * FROM tblSalarySched WHERE version='$intVersion'");
	// 	while($row=mysql_fetch_array($result)){
	// 		 $sn=$row["stepNumber"];
	// 		 $sg=$row["salaryGradeNumber"];
	// 		 $as = $row["actualSalary"];
	// 		 $asy= $row["actualSalary"]*12;
	// 	 	 mysql_query("UPDATE tblEmpPosition SET actualSalary='$as' WHERE stepNumber='$sn' AND salaryGradeNumber='$sg' AND statusOfAppointment='In-Service'");
	// 		 if($sn=='1') {
	// 		 mysql_query("UPDATE tblEmpPosition SET authorizeSalary='$as' WHERE stepNumber='$sn' AND salaryGradeNumber='$sg' AND statusOfAppointment='In-Service'");
	// 		 mysql_query("UPDATE tblPlantilla SET authorizeSalary='$as',authorizeSalaryYear ='$asy' WHERE  salaryGrade='$sg'");
	// 		 }
	// 	}
	// 	mysql_query("UPDATE tblSalarySchedVersion SET active = '0'");
	// 	mysql_query("UPDATE tblSalarySchedVersion SET active = '1' WHERE version='$intVersion'");
	// }

	function save($arrData,$strSG,$intStepNum,$intVersion)
	{
		$this->db->where('salaryGradeNumber',$strSG);
		$this->db->where('stepNumber',$intStepNum);
		$this->db->where('version',$intVersion);
		$this->db->update('tblSalarySched', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intVersion)
	{
		$this->db->where('version', $intVersion);
		$this->db->delete('tblSalarySchedVersion'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
