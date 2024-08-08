<?php 
/** 
Purpose of file:    Controller for Service Code Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_code extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/service_code_model'));
    }

	public function index()
	{
		$this->arrData['arrService'] = $this->service_code_model->getData();
		$this->template->load('template/template_view', 'libraries/service_code/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/service_code/add_view',$this->arrData);	
		}
		else
		{	
			$strServiceCode = $arrPost['strServiceCode'];
			$strServiceDescription = $arrPost['strServiceDescription'];
			if(!empty($strServiceCode) && !empty($strServiceDescription) && !empty($strServiceDescription))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->service_code_model->checkExist($strServiceCode, $strServiceDescription))==0)
				{
					$arrData = array(
						'serviceCode'=>$strServiceCode,
						'serviceDesc'=>$strServiceDescription,
						
					);
					$blnReturn  = $this->service_code_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblservicecode','Added '.$strServiceDescription.' Service_code',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Service code added successfully.');
					}
					redirect('libraries/service_code');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Service code and/or Service description already exists.');
					$this->session->set_flashdata('strServiceCode',$strServiceCode);
					$this->session->set_flashdata('strServiceDescription',$strServiceDescription);
					redirect('libraries/service_code/add');
				}
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intServiceId = urldecode($this->uri->segment(4));
			$this->arrData['arrService']=$this->service_code_model->getData($intServiceId);
			$this->template->load('template/template_view','libraries/service_code/edit_view', $this->arrData);
		}
		else
		{
			$intServiceId = $arrPost['intServiceId'];
			$strServiceCode = $arrPost['strServiceCode'];
			$strServiceDescription = $arrPost['strServiceDescription'];
			if(!empty($strServiceCode) AND !empty($strServiceDescription)) 
			{
				$arrData = array(
					'serviceCode'=>$strServiceCode,
					'serviceDesc'=>$strServiceDescription,
					
				);
				$blnReturn = $this->service_code_model->save($arrData, $intServiceId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblservicecode','Edited '.$strServiceDescription.' Service_code',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Service code updated successfully.');
				}
				redirect('libraries/service_code');
			}
		}
		
	}
	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intServiceId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->service_code_model->getData($intServiceId);
			$this->template->load('template/template_view','libraries/service_code/delete_view',$this->arrData);
		}
		else
		{
			$intServiceId = $arrPost['intServiceId'];
			//add condition for checking dependencies from other tables
			if(!empty($intServiceId))
			{
				$arrService = $this->service_code_model->getData($intServiceId);
				$strServiceDescription = $arrService[0]['serviceDesc'];	
				$blnReturn = $this->service_code_model->delete($intServiceId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblservicecode','Deleted '.$strServiceDescription.' Service_code',implode(';',$arrService[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','Service code deleted successfully.');
				}
				redirect('libraries/service_code');
			}
		}
		
	}
}
