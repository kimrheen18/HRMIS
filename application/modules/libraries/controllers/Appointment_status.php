<?php 
/** 
Purpose of file:    Controller for Appointment Status Library
Author:             Edgardo P. Catorce Jr.
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_status extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/appointment_status_model'));
    }

	public function index()
	{
		$this->arrData['arrAppointStatuses'] = $this->appointment_status_model->getData();
		$this->template->load('template/template_view', 'libraries/appointment_status/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/appointment_status/add_view',$this->arrData);	
		}
		else
		{	
			$strAppointmentCode = $arrPost['strAppointmentCode'];
			$strAppointmentDesc = $arrPost['strAppointmentDesc'];
			$strLeaveEntitled = $arrPost['strLeaveEntitled'];
			$intIncludedPlantilla = $arrPost['intIncludedPlantilla'];
			if(!empty($strAppointmentCode) && !empty($strAppointmentDesc))
			{	
				// check if appointment code or appointment desc already exist
				if(count($this->appointment_status_model->checkExist($strAppointmentCode, $strAppointmentDesc))==0)
				{
					$arrData = array(
						'appointmentCode'=>$strAppointmentCode,
						'appointmentDesc'=>$strAppointmentDesc,
						'leaveEntitled'=>$strLeaveEntitled,
						'incPlantilla'=>$intIncludedPlantilla,
						'system'=>0
					);
					$blnReturn  = $this->appointment_status_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblAppointment','Added '.$strAppointmentDesc.' Appointment Status',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Appointment Status added successfully.');
					}
					redirect('libraries/appointment_status');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Appointment code and/or Appointment  Description already exists.');
					$this->session->set_flashdata('strAppointmentCode',$strAppointmentCode);
					$this->session->set_flashdata('strAppointmentDesc',$strAppointmentDesc);
					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/appointment_status/add');
				}
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intAppointmentId = urldecode($this->uri->segment(4));
			$this->arrData['arrAppointStatuses']=$this->appointment_status_model->getData($intAppointmentId);
			$this->template->load('template/template_view','libraries/appointment_status/edit_view', $this->arrData);
		}
		else
		{
			$intAppointmentId = $arrPost['intAppointmentId'];
			$strAppointmentCode = $arrPost['strAppointmentCode'];
			$strAppointmentDesc = $arrPost['strAppointmentDesc'];
			$strLeaveEntitled = $arrPost['strLeaveEntitled'];
			$intIncludedPlantilla = $arrPost['intIncludedPlantilla'];
			if(!empty($strAppointmentCode) AND !empty($strAppointmentDesc)) 
			{
				$arrData = array(
					'appointmentId'=>$intAppointmentId,
					'appointmentCode'=>$strAppointmentCode,
					'appointmentDesc'=>$strAppointmentDesc,
					'leaveEntitled'=>$strLeaveEntitled,
					'incPlantilla'=>$intIncludedPlantilla
				);
				$blnReturn = $this->appointment_status_model->save($arrData, $intAppointmentId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblAppointment','Edited '.$strAppointmentDesc.' Appointment status',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Appointment status updated successfully.');
				}
				redirect('libraries/appointment_status');
			}
		}
		
	}

	public function delete()
	{
		$arrPost = $this->input->post();
		$intAppointmentId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrAppointStatuses']=$this->appointment_status_model->getData($intAppointmentId);
			$this->template->load('template/template_view','libraries/appointment_status/delete_view',$this->arrData);
		}
		else
		{
			$intAppointmentId = $arrPost['intAppointmentId'];
			if(!empty($intAppointmentId))
			{
				$arrAppointStatuses = $this->appointment_status_model->getData($intAppointmentId);
				$strAppointmentCode = $arrAppointStatuses[0]['appointmentCode'];	
				$blnReturn = $this->appointment_status_model->delete($intAppointmentId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblPhilhealthRange','Deleted '.$strAppointmentCode.' Appointment status',implode(';',$arrAppointStatuses[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Appointment status deleted successfully.');
				}
				redirect('libraries/appointment_status');
			}
		}
		
	}
}
