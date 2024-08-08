<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chart_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function plantilla_positions()
	{
		return $this->db->select('tblPlantilla.plantillaID,tblPlantilla.itemNumber,tblPosition.positiondesc,tblEmpPosition.empNumber')
		->join('tblPosition','tblPlantilla.positioncode=tblPosition.positionCode','left')
		->join('tblEmpPosition','tblEmpPosition.itemNumber=tblPlantilla.itemNumber','left')
		->where('tblPlantilla.itemNumber!=','')
		->group_by('tblPlantilla.itemNumber,tblPlantilla.plantillaID,tblPosition.positiondesc,tblEmpPosition.empNumber')
		->get('tblPlantilla');
	}

	public function gender_appointment($strAppointment,$strGender)
	{
		$objQuery = $this->db->select('COUNT(sex) AS total')
				->join('tblEmpPosition','tblEmpPersonal.empNumber=tblEmpPosition.empNumber','left')
				->where('tblEmpPosition.statusOfAppointment','In-Service')
				->where('tblEmpPosition.appointmentCode',$strAppointment)
				->where('tblEmpPersonal.sex',$strGender)
				->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	// function getGenderByAppointment($strAppointment)
	// {
	// 	$sql="SELECT sex,appointmentCode FROM tblEmpPersonal 
	// 			LEFT JOIN tblEmpPosition ON tblEmpPersonal.empNumber=tblEmpPosition.empNumber
	// 			WHERE tblEmpPosition.statusOfAppointment='In-Service'
	// 			AND tblEmpPosition.appointmentCode='".$strAppointment."'
	// 			";
	// 	//echo $sql."<br>";		
	// 	$results = mysql_query($sql);
	// 	$intMale=0;$intFemale=0;
	// 	while($row=mysql_fetch_array($results))
	// 	{
	// 		if($row['sex']=="M")
	// 			$intMale+=1;
	// 		else
	// 			$intFemale+=1;	
	// 	}
	// 	return array($intMale,$intFemale);
	// }
}