<?php 
/** 
Purpose of file:    Controller for Leave type Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_type extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/leave_type_model'));
    }

	public function index()
	{
		$this->arrData['arrLeave'] = $this->leave_type_model->getData();
		$this->template->load('template/template_view', 'libraries/leave_type/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/leave_type/add_view',$this->arrData);	
		}
		else
		{	
			$strLeaveCode = $arrPost['strLeaveCode'];
			$strLeaveType = $arrPost['strLeaveType'];
			$intDays = $arrPost['intDays'];
			if(!empty($strLeaveCode) && !empty($strLeaveType) && !empty($intDays))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->leave_type_model->checkExist($strLeaveCode, $strLeaveType))==0)
				{
					$arrData = array(
						'leaveCode'=>$strLeaveCode,
						'leaveType'=>$strLeaveType,
						'numOfDays'=>$intDays	
					);
					$blnReturn  = $this->leave_type_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblleave','Added '.$strLeaveCode.' Leave_type',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Leave type added successfully.');
					}
					redirect('libraries/leave_type');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Leave type already exists.');
					$this->session->set_flashdata('strLeaveCode',$strLeaveCode);
					$this->session->set_flashdata('strLeaveType',$strLeaveType);
					redirect('libraries/leave_type/add');
				}
			}
		}    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$strCode = urldecode($this->uri->segment(4));
			$this->arrData['arrLeave']=$this->leave_type_model->getData($strCode);
			$this->template->load('template/template_view','libraries/leave_type/edit_view', $this->arrData);
		}
		else
		{

			$strCode = $arrPost['strCode'];
			$strLeaveType = $arrPost['strLeaveType'];
			$intDays = $arrPost['intDays'];
			if(!empty($strLeaveType)) 
			{
				$arrData = array(
					'leaveType'=>$strLeaveType,
					'numOfDays'=>$intDays
				);

				$blnReturn = $this->leave_type_model->save($arrData, $strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblLeave','Edited '.$strLeaveCode.' Leave Type',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Leave type updated successfully.');
				}
				redirect('libraries/leave_type');
			}
		}
		
	}

	public function add_special()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrSpecialLeave'] = $this->leave_type_model->getSpecialLeave();
			$this->arrData['arrSpecialLeaveGroupby'] = $this->leave_type_model->getSpecialLeaveGroupby();
			$this->template->load('template/template_view','libraries/leave_type/add_special_view',$this->arrData);	
		}
		else
		{	
			$strSpecialLeaveCode = $arrPost['strSpecialLeaveCode'];
			$strSpecial = $arrPost['strSpecial'];
			if(!empty($strSpecialLeaveCode) && !empty($strSpecial))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->leave_type_model->check($strSpecial))==0)
				{
					$arrData = array(
						'leaveCode'=>$strSpecialLeaveCode,
						'specifyLeave'=>$strSpecial
					);
					$blnReturn  = $this->leave_type_model->add_special($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblspecificleave','Added '.$strSpecialLeaveCode.' Leave_type',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Leave type added successfully.');
					}
					redirect('libraries/leave_type/add_special');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Special leave already exists.');
					$this->session->set_flashdata('strSpecialLeaveCode',$strSpecialLeaveCode);
					$this->session->set_flashdata('strSpecial',$strSpecial);
					redirect('libraries/leave_type/add_special');
				}
			}
		}    	
    }

	public function edit_special()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$strSpecifyId = urldecode($this->uri->segment(4));
			$this->arrData['arrSpecialLeave']=$this->leave_type_model->getSpecialLeave($strSpecifyId);
			$this->template->load('template/template_view','libraries/leave_type/edit_special_view', $this->arrData);
		}
		else
		{
			$strSpecifyId = $arrPost['strSpecifyId'];
			$strSpecialLeaveCode  = $arrPost['strSpecialLeaveCode'];
	 		$strSpecial  = $arrPost['strSpecial'];
			if(!empty($strSpecial)) 
			{
				$arrData = array(
					'leaveCode' => $strSpecialLeaveCode,
					'specifyLeave'=>$strSpecial
				);
				// print_r($arrData);
				// exit(1);
				$blnReturn = $this->leave_type_model->save_special($arrData, $strSpecifyId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblspecificleave','Edited '.$strSpecialLeaveCode.' Leave Type',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Leave type updated successfully.');
				}
				redirect('libraries/leave_type/add_special');
			}
		}
		
	}

	public function delete_special()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strSpecifyId = $this->uri->segment(4);
		if(!empty($arrPost))
		{
			$strSpecifyLeave = $arrPost['strSpecifyLeave'];
			//add condition for checking dependencies from other tables
			if(!empty($strSpecifyLeave))
			{
				$blnReturn=$this->leave_type_model->delete_special($strSpecifyId);
				if(count($blnReturn)>0)
					$this->session->set_flashdata('strSuccessMsg','Leave deleted successfully.');
				redirect('libraries/leave_type/add_special');
			}
		}
		else
		{
			$this->arrData['arrSpecialLeave']=$this->leave_type_model->getSpecialLeave($strSpecifyId);
			$this->template->load('template/template_view','libraries/leave_type/delete_special_view',$this->arrData);
		}
	}

	
}
