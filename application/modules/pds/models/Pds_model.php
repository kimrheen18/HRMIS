<?php 
/** 
Purpose of file:    Model for PDS 
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pds_model extends CI_Model {

	var $table = 'tblEmpPersonal';
	var $tableid = 'empNumber';

	var $tblChild = 'tblEmpChild';
	var $tblChildId = 'childCode';

	var $tblEduc = 'tblEmpSchool';
	var $tblEducId = 'SchoolIndex';

	var $tblExam = 'tblEmpExam';
	var $tblExamId = 'ExamIndex';

	var $tblService = 'tblServiceRecord';
	var $tblServiceId = 'serviceRecID';

	var $tblVol = 'tblEmpVoluntaryWork';
	var $tblVolId = 'VoluntaryIndex';

	var $tblTraining = 'tblEmpTraining';
	var $tblTrainingId = 'TrainingIndex';

	var $tblPosition = 'tblEmpPosition';
	var $tblPositionId = 'empNumber';

	var $table9 = 'tblempduties';
	var $tableid9 = 'duties';

	var $table10 = 'tblplantilladuties';
	var $tableid10 = 'itemDuties';

	var $tableCharRef = 'tblEmpReference';
	var $tableCharRefId = 'ReferenceIndex';


	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
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

	function getChild($intChildCode = '')
	{		
		if($intChildCode != "")
		{
			$this->db->where($this->tblChildId,$intChildCode);
		}
		$objQuery = $this->db->get($this->tblChild);
		return $objQuery->result_array();	
	}

	function getEduc($intSchoolIndex = '')
	{		
		if($intSchoolIndex != "")
		{
			$this->db->where($this->tblEducId,$intSchoolIndex);
		}
		$objQuery = $this->db->get($this->tblEduc);
		return $objQuery->result_array();	
	}

	function getExam($intExamIndex = '')
	{		
		if($intExamIndex != "")
		{
			$this->db->where($this->tblExamId,$intExamIndex);
		}
		$objQuery = $this->db->get($this->tblExam);
		return $objQuery->result_array();	
	}

	function getTraining($strtraIndex = '')
	{		
		if($strtraIndex != "")
		{
			$this->db->where($this->tblTrainingId,$strtraIndex);
		}
		$objQuery = $this->db->get($this->tblTraining);
		return $objQuery->result_array();	
	}


	function getWorkExp($intServiceId = '')
	{		
		if($intServiceId != "")
		{
			$this->db->where($this->tblServiceId,$intServiceId);
		}
		$objQuery = $this->db->get($this->tblService);
		return $objQuery->result_array();	
	}

	function getPosition($strEmpNumber = '')
	{		
		if($strEmpNumber != "")
		{
			$this->db->where($this->tblPositionId,$strEmpNumber);
		}
		$objQuery = $this->db->get($this->tblPosition);
		return $objQuery->result_array();	
	}

	function getImage($ImageId = '')
	{		
		if($strEmpNumber != "")
		{
			$this->db->where($this->tableid,$strEmpNumber);
		}
		// $this->db->join('tblagencyimages','tblagencyimages.id = '.$this->table.'.agencyName','left');
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function add_child($arrData)
	{
		$this->db->insert($this->tblChild, $arrData);
		return $this->db->insert_id();		
	}

	function delete_child($code)
	{
		$this->db->where($this->tblChildId, $code);
		$this->db->delete($this->tblChild); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function checkExist($strAgencyName = '', $strAgencyCode = '')
	{		
		
		$this->db->where('agencyName',$strAgencyName);
		$this->db->or_where('agencyCode', $strAgencyCode);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
	
	function save_personal($arrData, $strEmpNumber)
	{
		$this->db->where($this->tableid, $strEmpNumber);
		$this->db->update($this->table, $arrData);
		//echo $this->db->last_query();exit(1);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function save_child($arrData, $intChildCode)
	{
		$this->db->where($this->tblChildId, $intChildCode);
		$this->db->update($this->tblChild, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	# BEGIN EDUCATION
	function add_educ($arrData)
	{
		$this->db->insert($this->tblEduc, $arrData);
		return $this->db->insert_id();
	}

	function save_educ($arrData, $intSchoolIndex)
	{
		$this->db->where($this->tblEducId, $intSchoolIndex);
		$this->db->update($this->tblEduc, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_educ($intSchoolIndex)
	{
		$this->db->where($this->tblEducId, $intSchoolIndex);
		$this->db->delete($this->tblEduc); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END EDUCATION

	# BEGIN EXAM
	function add_exam($arrData)
	{
		$this->db->insert($this->tblExam, $arrData);
		return $this->db->insert_id();
	}

	function save_exam($arrData, $intExamIndex)
	{
		$this->db->where($this->tblExamId, $intExamIndex);
		$this->db->update($this->tblExam, $arrData);
		// echo $this->db->last_query();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_exam($examid)
	{
		$this->db->where($this->tblExamId, $examid);
		$this->db->delete($this->tblExam); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END EXAM

	# BEGIN WORK EXPERIENCE
	function add_workExp($arrData)
	{
		$this->db->insert($this->tblService, $arrData);
		return $this->db->insert_id();
	}

	function save_workExp($arrData, $intServiceId)
	{
		$this->db->where($this->tblServiceId, $intServiceId);
		$this->db->update($this->tblService, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_workExp($intServiceId)
	{
		$this->db->where($this->tblServiceId, $intServiceId);
		$this->db->delete($this->tblService); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END WORK EXPERIENCE

	# BEGIN VOLUNTARY WORK
	function add_volWorks($arrData)
	{
		$this->db->insert($this->tblVol, $arrData);
		return $this->db->insert_id();
	}

	function save_volWorks($arrData, $strVolIndex)
	{
		$this->db->where($this->tblVolId, $strVolIndex);
		$this->db->update($this->tblVol, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_volWorks($strVolIndex)
	{
		$this->db->where($this->tblVolId, $strVolIndex);
		$this->db->delete($this->tblVol); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END VOLUNTARY WORK

	# ADD TRAINING
	function add_training($arrData)
	{
		$this->db->insert($this->tblTraining, $arrData);
		return $this->db->insert_id();
	}

	function save_training($arrData, $strtraIndex)
	{
		$this->db->where($this->tblTrainingId, $strtraIndex);
		$this->db->update($this->tblTraining, $arrData);
			// echo $this->db->last_query();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_training($strtraIndex)
	{
		$this->db->where($this->tblTrainingId, $strtraIndex);
		$this->db->delete($this->tblTraining); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END TRAINING

	# BEGIN CHARACTER REFERENCES
	function add_char_refs($arrData)
	{
		$this->db->insert($this->tableCharRef, $arrData);
		return $this->db->insert_id();
	}

	function save_char_refs($arrData, $strcharIndex)
	{
		$this->db->where($this->tableCharRefId, $strcharIndex);
		$this->db->update($this->tableCharRef, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_char_refs($strcharIndex)
	{
		$this->db->where($this->tableCharRefId, $strcharIndex);
		$this->db->delete($this->tableCharRef); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END CHARACTER REFERENCES

	# BEGIN DUTIES & RESPONSIBILITIES
	#	- For Position
	function add_duties_position($arrData)
	{
		$this->db->insert('tblDuties', $arrData);
		return $this->db->insert_id();
	}

	function save_duties_position($arrData, $duties_id)
	{
		$this->db->where('duties_index', $duties_id);
		$this->db->update('tblDuties', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_duties_position($duties_id)
	{
		$this->db->where('duties_index', $duties_id);
		$this->db->delete('tblDuties'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	#	- For Plantilla
	function add_duties_plantilla($arrData)
	{
		$this->db->insert('tblPlantillaDuties', $arrData);
		return $this->db->insert_id();
	}

	function save_duties_plantilla($arrData, $duties_id)
	{
		$this->db->where('plantilla_duties_index', $duties_id);
		$this->db->update('tblPlantillaDuties', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_duties_plantilla($duties_id)
	{
		$this->db->where('plantilla_duties_index', $duties_id);
		$this->db->delete('tblPlantillaDuties'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	#	- For Actual
	function add_duties_actual($arrData)
	{
		$this->db->insert('tblEmpDuties', $arrData);
		return $this->db->insert_id();
	}

	function save_duties_actual($arrData, $duties_id)
	{
		$this->db->where('empduties_index', $duties_id);
		$this->db->update('tblEmpDuties', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_duties_actual($duties_id)
	{
		$this->db->where('empduties_index', $duties_id);
		$this->db->delete('tblEmpDuties'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END DUTIES & RESPONSIBILITIES

	# BEGIN APPOINTMENT ISSUE
	function add_apptIssue($arrData)
	{
		$this->db->insert('tblEmpAppointment', $arrData);
		return $this->db->insert_id();
	}

	function save_apptIssue($arrData, $apptcode)
	{
		$this->db->where('appointmentissuedcode', $apptcode);
		$this->db->update('tblEmpAppointment', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_apptIssue($apptcode)
	{
		$this->db->where('appointmentissuedcode', $apptcode);
		$this->db->delete('tblEmpAppointment'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END APPOINTMENT ISSUE

	# BEGIN UPDATE EMPNUMBER
	function save_empnumber($old_empid,$new_empid)
	{
		$all_tables = $this->db->list_tables();
		foreach($all_tables as $tblname):
			if($this->db->field_exists('empNumber', $tblname)):
				$this->db->where('empNumber', $old_empid);
				$this->db->update($tblname, array('empNumber' => $new_empid));
			endif;
		endforeach;
	}
	# END UPDATE EMPNUMBER

	function save_skill($arrData, $strEmpNumber)
	{
		$this->db->where($this->tableid, $strEmpNumber);
		$this->db->update($this->table, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function save_position($arrData, $strEmpNumber)
	{
		$this->db->where($this->tblPositionId, $strEmpNumber);
		$this->db->update($this->tblPosition, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function save_Duties($arrData, $strEmpNumber)
	{
		$this->db->where($this->tableid9, $strEmpNumber);
		$this->db->update($this->table9, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function save($arrData, $strAgencyName)
	{
		$this->db->where($this->tableid, $strAgencyName);
		$this->db->update($this->table, $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function saveImage($arrData, $ImageId)
	{
		$this->db->where('id', $ImageId);
		$this->db->update('tblagencyimages', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($strAgencyName)
	{
		$this->db->where($this->tableid, $strAgencyName);
		$this->db->delete($this->table); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function getDataByField($arrWhere,$appt)
	{
		if($appt == 'P'):
			$compInstance = $this->db->get_where('tblComputationInstance',$arrWhere)->result_array();
			if(count($compInstance) > 0):
				$compInstance = $compInstance[0];
				$compDetails = $this->db->join('tblEmpPersonal', 'tblEmpPersonal.empNumber = tblComputationDetails.empNumber', 'left')
									->order_by('tblEmpPersonal.surname', 'ASC')
									->order_by('tblEmpPersonal.firstname', 'ASC')
									->where('fk_id',$compInstance['id'])
									->where('(periodmonth='.$compInstance['month'].' AND periodyear='.$compInstance['year'].')')
									->get('tblComputationDetails')->result_array();
				return $compDetails;
			endif;
		else:
		endif;
	}

	// EDIT EMPNUMBER
	function checkEmpNumExist($strEmpNumber = '')
	{		
		$this->db->where('empNumber',$strEmpNumber);	
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	// function getpayrollprocess($appt='')
 // 	{
 // 		// $arrProcesswith = $this->db->select('appointmentCode')->get_where('tblPayrollProcess',array('appointmentCode' => $appt,'processWith' =>'CT,PC1,PC2,PC3,PC4,PC5,CTI,E,O,PA,SE,SU,T,P'))->result_array();
 		
	// 	$sql ="SELECT `processWith` FROM `tblPayrollProcess` WHERE `appointmentCode`="P"";
	// 	echo $this->db->last_query();
 		
	// 	$objQuery = $this->db->query($sql);
	// 	return $objQuery->result_array();	

 // 	}

}
