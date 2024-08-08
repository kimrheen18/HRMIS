<?php 
/** 
Purpose of file:    Model for PDS update
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pds_update_model extends CI_Model {

	var $table = 'tblEmpPersonal';
	var $tableid = 'empNumber';

	var $tableSchool = 'tblEmpSchool';
	var $tableSchoolid = 'levelCode';

	var $tableEduc = 'tblEducationalLevel';
	var $tableEducid = 'levelId';

	var $tableCourse = 'tblCourse';
	var $tableCourseid = 'courseCode';

	var $tableScholarship = 'tblScholarship';
	var $tableScholarshipid = 'id';

	var $tableTraining = 'tblEmpTraining';
	var $tableTrainingid = 'XtrainingCode';

	var $tableExam = 'tblExamType';
	var $tableExamid = 'examId';

	var $tableWorkExp = 'tblServiceRecord';
	var $tableWorkExpid = 'serviceRecID';
	
	var $tableAppoint = 'tblAppointment';
	var $tableAppointid = 'appointmentId';

	var $tableSepCause = 'tblSeparationCause';
	var $tableSepCauseid = 'separationCause';

	var $tableRef = 'tblempreference';
	var $tableRefid = 'refName';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	// getting data
	public function getDetails($strEmpNo="",$strSearch="",$strAppStatus="")
	{
		$this->db->select('tblEmpPersonal.*,tblEmpPosition.*,tblPosition.positionDesc,tblAppointment.appointmentDesc');
		$where='';
		if($strEmpNo!="")
			$this->db->where('tblEmpPersonal.empNumber',$strEmpNo);
			//$where .= " AND tblEmpPersonal.empNumber='".$strEmpNo."'";
		if($strSearch!="")
			$this->db->where("(tblEmpPersonal.empNumber LIKE '%".$strSearch."%' OR surname LIKE '%".$strSearch."%' OR firstname LIKE '%".$strSearch."%' OR middlename LIKE '%".$strSearch."%')",NULL,FALSE);
			//$where .= " AND (tblEmpPersonal.empNumber LIKE '%".$strSearch."%' OR surname LIKE '%".$strSearch."%' OR firstname LIKE '%".$strSearch."%' OR middlename LIKE '%".$strSearch."%')";
		if($strAppStatus!="")
			$this->db->where('tblEmpPosition.statusOfAppointment',$strAppStatus);
		else
			$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
			//$where .= " AND tblEmpPosition.statusOfAppointment='".$strAppStatus."'";
		$this->db->join('tblEmpPosition','tblEmpPosition.empNumber=tblEmpPersonal.empNumber','left')
		->join('tblPosition','tblPosition.positionCode=tblEmpPosition.positionCode','left')
		->join('tblAppointment','tblAppointment.appointmentCode=tblEmpPosition.appointmentCode','left')
		->order_by('surname,firstname,middlename','asc');
		$strSQL = " SELECT tblEmpPersonal.*,tblEmpPosition.statusOfAppointment,tblEmpPosition.appointmentCode,tblEmpPosition.positionCode,tblPosition.positionDesc FROM tblEmpPersonal						
					LEFT JOIN tblEmpPosition ON tblEmpPosition.empNumber=tblEmpPersonal.empNumber
					LEFT JOIN tblPosition ON tblPosition.positionCode=tblEmpPosition.positionCode
					WHERE 1=1 
					$where
					ORDER BY surname,firstname,middlename
					";
		// echo $strSQL;exit(1);				
		//$objQuery = $this->db->query($strSQL);
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}	

	function getData($strEmpNumber = '')
	{		
		if($strEmpNumber != "")
		{
			$this->db->where($this->tableid,$strEmpNumber);
		}
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function getEmployeeDetails($strEmpNo,$strSelect,$strTable,$strOrder="",$strJoinTable="",$strJoinString="",$strJoinType="")
	{
		if($strOrder!='')
			$this->db->order_by($strOrder);
		if($strJoinTable!='' && $strJoinString!='' && $strJoinType!='')
			$this->db->join($strJoinTable,$strJoinString,$strJoinType);
		if($strEmpNo!='')
			$this->db->where('empNumber',$strEmpNo);
		$this->db->select($strSelect);
		$rs = $this->db->get($strTable);
		return $rs->result_array();
	}

	function getEducData($intLevelId = '')
	{		
		if($intLevelId != "")
		{
			$this->db->where($this->tableEducid,$intLevelId);
		}
		$objQuery = $this->db->get($this->tableEduc);
		return $objQuery->result_array();	
	}
	function getEduc($strEmpNumber)
	{		
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_EDUC.'.empNumber','left');
		$this->db->where(TABLE_EDUC.'.empNumber',$strEmpNumber);
		$objQuery = $this->db->get(TABLE_EDUC);
		return $objQuery->result_array();	
	}

	function getCourseData($strCourseCode = '')
	{		
		if($strCourseCode != "")
		{
			$this->db->where($this->tableCourseid,$strCourseCode);
		}
		$objQuery = $this->db->get($this->tableCourse);
		return $objQuery->result_array();	
	}

	function getScholarshipData($intScholarId = '')
	{		
		if($intScholarId != "")
		{
			$this->db->where($this->tableScholarshipid,$intScholarId);
		}
		$objQuery = $this->db->get($this->tableScholarship);
		return $objQuery->result_array();	
	}
	function getSchoolData($intEmpNum = '')
	{		
		if($intEmpNum != "")
		{
			$this->db->where($this->tableSchoolid,$intEmpNum);
		}
		$objQuery = $this->db->get($this->tableSchool);
		return $objQuery->result_array();	
	}

	function getTrainingData($strTableTraining = '')
	{		
		if($strTableTraining != "")
		{
			$this->db->where($this->tableTrainingid,$strTableTraining);
		}
		$objQuery = $this->db->get($this->tableTraining);
		return $objQuery->result_array();	
	}
	function getTraining($strEmpNumber)
	{		
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_TRAINING.'.empNumber','left');
		$this->db->where(TABLE_TRAINING.'.empNumber',$strEmpNumber);
		$this->db->order_by('tblEmpTraining.'.$this->tableTrainingid,'ASC');
		$objQuery = $this->db->get(TABLE_TRAINING);
		return $objQuery->result_array();	
	}

	function getExamData($intExamId = '')
	{		
		if($intExamId != "")
		{
			$this->db->where($this->tableExamid,$intExamId);
			$this->db->order_by('tableExam'.$this->tableExamid,'ASC');
		}
		$objQuery = $this->db->get($this->tableExam);
		return $objQuery->result_array();	
	}
	function getExamination($strEmpNumber)
	{		
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_EXAM.'.empNumber','left');
		$this->db->where(TABLE_EXAM.'.empNumber',$strEmpNumber);
		$objQuery = $this->db->get(TABLE_EXAM);
		return $objQuery->result_array();	
	}

	function getRefData($strEmpNumber)
	{		
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_REFERENCE.'.empNumber','left');
		$this->db->where(TABLE_REFERENCE.'.empNumber',$strEmpNumber);
		$objQuery = $this->db->get(TABLE_REFERENCE);
		//echo $this->db->last_query();
		return $objQuery->result_array();	
	}

	function getVoluntary($strEmpNumber)
	{		
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_VOLUNTARY.'.empNumber','left');
		$this->db->where(TABLE_VOLUNTARY.'.empNumber',$strEmpNumber);
		$objQuery = $this->db->get(TABLE_VOLUNTARY);
		return $objQuery->result_array();	
	}

	function getExpData($intSerId = '')
	{		
		if($intSerId != "")
		{
			$this->db->where($this->tableWorkExpid,$intSerId);
		}
		$objQuery = $this->db->get($this->tableWorkExp);
		return $objQuery->result_array();	
	}

	function getExperience($strEmpNumber)
	{		
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_SERVICE.'.empNumber','left');
		$this->db->where(TABLE_SERVICE.'.empNumber',$strEmpNumber);
		$objQuery = $this->db->get(TABLE_SERVICE);
		return $objQuery->result_array();	
	}

	function getAppointData($intAppointmentId = '')
	{		
		if($intAppointmentId != "")
		{
			$this->db->where($this->tableAppointid,$intAppointmentId);
		}
		$objQuery = $this->db->get($this->tableAppoint);
		return $objQuery->result_array();	
	}

	function getSepCauseData($strSepCause = '')
	{		
		if($strSepCause != "")
		{
			$this->db->where($this->tableSepCauseid,$strSepCause);
		}
		$objQuery = $this->db->get($this->tableSepCause);
		return $objQuery->result_array();	
	}

	// submission of requests
	function submit_request($arrData)
	{
		$this->db->insert('tblEmpRequest', $arrData);
		return $this->db->insert_id();		
	}
	// function submitProfile($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }
	// function submitFam($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }
	// function submitEduc($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }	
	// function submitTraining($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }
	// function submitExam($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }
	// function submitChild($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }
	// function submitTax($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }
	// function submitRef($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }
	// function submitVol($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }	
	// function submitWorkExp($arrData)
	// {
	// 	$this->db->insert('tblEmpRequest', $arrData);
	// 	return $this->db->insert_id();		
	// }

	// check existence
	function checkExist($strSname = '', $strFname = '')
	{		
		$strSQL = " SELECT * FROM tblEmpRequest					
					WHERE  
					requestDetails ='$strSname' OR
					requestDate ='$strFname'					
					";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}

	// saving updates
	function save($arrData, $intReqId)
	{
		$this->db->where('requestID', $intReqId);
		$this->db->update('tblEmpRequest', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	
	// deleting enties
	function delete($intReqId)
	{
		$this->db->where('requestID', $intReqId);
		$this->db->delete('tblEmpRequest'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
