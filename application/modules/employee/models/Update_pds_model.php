<?php 
/** 
Purpose of file:    Model for PDS update
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Update_pds_model extends CI_Model {

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
	
	function getall_request($empno='')
	{
		if($empno!=''):
			$this->db->where('empNumber',$empno);
		endif;
		$this->db->like('requestCode', '201', 'after',false);
		return $this->db->order_by('requestDate','DESC')->get('tblEmpRequest')->result_array();
	}

	function getpds_request($reqid='')
	{
		if($reqid!=''):
			$res = $this->db->get_where('tblEmpRequest',array('requestID' => $reqid))->result_array();
			return count($res) > 0 ? $res[0] : array();
		else:
			return $this->db->get('tblEmpRequest')->result_array();
		endif;

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

	function geteduc_data($educid)
	{		
		$res = $this->db->get_where('tblEmpSchool',array('SchoolIndex' => $educid))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function gettra_data($traid)
	{		
		$res = $this->db->get_where('tblEmpTraining',array('TrainingIndex' => $traid))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function getexam_data($examid)
	{		
		$res = $this->db->get_where('tblEmpExam',array('ExamIndex' => $examid))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function getchild_data($childid)
	{		
		$res = $this->db->get_where('tblEmpChild',array('childCode' => $childid))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function getreference_data($refid)
	{		
		$res = $this->db->get_where('tblEmpReference',array('ReferenceIndex' => $refid))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function getvoluntary_data($volid)
	{		
		$res = $this->db->get_where('tblEmpVoluntaryWork',array('VoluntaryIndex' => $volid))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function getworkxp_data($wxpid)
	{		
		$res = $this->db->get_where('tblServiceRecord',array('serviceRecID' => $wxpid))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function getChildren($empnumber)
	{		
		return $this->db->get_where('tblEmpChild',array('empNumber' => $empnumber))->result_array();
	}

	function save_children($arrData)
	{
		$this->db->insert('tblEmpChild', $arrData);
		return $this->db->insert_id();
	}

	function update_children($arrData, $child_id)
	{
		$this->db->where('childCode', $child_id);
		$this->db->update('tblEmpChild', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
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

	function save_school($arrData)
	{
		$this->db->insert($this->tableSchool, $arrData);
		return $this->db->insert_id();
	}

	function update_school($arrData, $schoolid)
	{
		$this->db->where('SchoolIndex', $schoolid);
		$this->db->update($this->tableSchool, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
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
		// $this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_TRAINING.'.empNumber','left');
		$this->db->where($this->tableTraining.'.empNumber',$strEmpNumber);
		$this->db->order_by('tblEmpTraining.'.$this->tableTrainingid,'ASC');
		$objQuery = $this->db->get($this->tableTraining);
		return $objQuery->result_array();	
	}

	function save_training($arrData)
	{
		$this->db->insert($this->tableTraining, $arrData);
		echo $this->db->insert_id();
	}

	function update_training($arrData, $training_id)
	{
		$this->db->where('TrainingIndex', $training_id);
		$this->db->update($this->tableTraining, $arrData);
		echo $this->db->affected_rows()>0?TRUE:FALSE;
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

	function save_eligibility($arrData)
	{
		$this->db->insert('tblEmpExam', $arrData);
		echo $this->db->insert_id();
	}

	function update_eligibility($arrData, $exam_id)
	{
		$this->db->where('ExamIndex', $exam_id);
		$this->db->update('tblEmpExam', $arrData);
		echo $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function getRefData($strEmpNumber)
	{		
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_REFERENCE.'.empNumber','left');
		$this->db->where(TABLE_REFERENCE.'.empNumber',$strEmpNumber);
		$objQuery = $this->db->get(TABLE_REFERENCE);
		return $objQuery->result_array();	
	}

	function save_reference($arrData)
	{
		$this->db->insert('tblEmpReference', $arrData);
		return $this->db->insert_id();
	}

	function update_reference($arrData, $ref_id)
	{
		$this->db->where('ReferenceIndex', $ref_id);
		$this->db->update('tblEmpReference', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function getVoluntary($strEmpNumber)
	{		
		$this->db->join('tblEmpPersonal','tblEmpPersonal.empNumber = '.TABLE_VOLUNTARY.'.empNumber','left');
		$this->db->where(TABLE_VOLUNTARY.'.empNumber',$strEmpNumber);
		$objQuery = $this->db->get(TABLE_VOLUNTARY);
		return $objQuery->result_array();	
	}

	function save_voluntary($arrData)
	{
		$this->db->insert('tblEmpVoluntaryWork', $arrData);
		return $this->db->insert_id();
	}

	function update_voluntary($arrData, $vol_id)
	{
		$this->db->where('VoluntaryIndex', $vol_id);
		$this->db->update('tblEmpVoluntaryWork', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
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

	function save_workxp($arrData)
	{
		$this->db->insert('tblServiceRecord', $arrData);
		return $this->db->insert_id();
	}

	function update_workxp($arrData, $xp_id)
	{
		$this->db->where('serviceRecID', $xp_id);
		$this->db->update('tblServiceRecord', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
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

	# submission of requests
	function submit_request($arrData)
	{
		$this->db->insert('tblEmpRequest', $arrData);
		return $this->db->insert_id();		
	}

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

	function save_personal($arrData, $empno)
	{
		$this->db->where('empNumber', $empno);
		$this->db->update('tblEmpPersonal', $arrData);
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
