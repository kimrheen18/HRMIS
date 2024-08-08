<?php 
/** 
Purpose of file:    Model for Appointment Status Library
Author:             Rose Anne Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Appointment_status_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function getData($intAppointmentId = '')
	{
		if($intAppointmentId != ''):
			return $this->db->get_where('tblAppointment', array('appointmentId' => $intAppointmentId))->result_array();
		else:
			$this->db->order_by('appointmentDesc', 'asc');
			return $this->db->get('tblAppointment')->result_array();
		endif;
	}

	function employee_appointment($apptid='')
	{
		if($apptid != ''):
			return $this->db->get_where('tblAppointment', array('appointmentissuedcode' => $apptid))->result_array();
		else:
			$this->db->order_by('positionCode', 'asc');
			return $this->db->get('tblEmpAppointment')->result_array();
		endif;	
	}

	function employee_appointment_byEmpNumber($empid='')
	{
		$this->db->join('tblPosition', 'tblPosition.positionCode = tblEmpAppointment.positionCode','left');
		return $this->db->get_where('tblEmpAppointment', array('empNumber' => $empid))->result_array();
	}

	function add($arrData)
	{
		$this->db->insert('tblAppointment', $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($strAppointmentCode = '', $strAppointmentDesc = '')
	{		
		$strSQL = " SELECT * FROM tblAppointment					
					WHERE  
					appointmentCode ='$strAppointmentCode' OR
					appointmentDesc ='$strAppointmentDesc'					
					";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}

	function save($arrData, $intAppointmentId)
	{
		$this->db->where('appointmentId', $intAppointmentId);
		$this->db->update('tblAppointment', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intAppointmentId)
	{
		$this->db->where('appointmentId', $intAppointmentId);
		$this->db->delete('tblAppointment'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	
	function getAppointmentJointPermanent($ispayroll=false)
	{
		$this->db->order_by('appointmentDesc');

		if($ispayroll):
			$this->db->join('tblAppointment','tblAppointment.appointmentCode = tblPayrollProcess.appointmentCode','left');
			return $this->db->get('tblPayrollProcess')->result_array();

			$query = "Select * from tblPayrollProcess LEFT JOIN tblAppointment ON tblAppointment.appointmentCode = tblPayrollProcess.appointmentCode ORDER BY appointmentDesc";
		else:
			return $this->db->where('appointmentCode', 'P')
						->or_where('incPlantilla', '0')
						->get('tblAppointment')->result_array();
		endif;
	}


}
