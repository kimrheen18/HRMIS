<?php 
/** 
Purpose of file:    Controller for Payroll Group Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_group extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/payroll_group_model','libraries/project_code_model'));
    }

	public function index()
	{
		$this->arrData['arrPayrollGroup'] = $this->payroll_group_model->getData();
		//$this->arrData['arrPayrollGroup'] = $this->payroll_group_model->getProjectDetails();
		
		// $this->arrTemplateData['arrPG']=$this->employeename_model->getDetails();
		$this->template->load('template/template_view', 'libraries/payroll_group/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['action'] = 'add';
			$this->arrData['arrProject']=$this->project_code_model->getData(); 
			$this->template->load('template/template_view','libraries/payroll_group/add_view',$this->arrData);	
		}
		else
		{	
			$strProject = $arrPost['strProject'];
			$strPayrollGroupCode = $arrPost['strPayrollGroupCode'];
			$strPayrollGroupDesc = $arrPost['strPayrollGroupDesc'];
			$intPayrollGroupOrder = $arrPost['intPayrollGroupOrder'];
			$strResponsibilityCntr = $arrPost['strResponsibilityCntr'];
			if(!empty($strProject) && !empty($strPayrollGroupCode) && !empty($strPayrollGroupDesc) && !empty($intPayrollGroupOrder) && !empty($strResponsibilityCntr))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->payroll_group_model->checkExist($strPayrollGroupCode, $strPayrollGroupDesc))==0)
				{
					$arrData = array(
						'projectCode'=>$strProject,
						'payrollGroupCode'=>$strPayrollGroupCode,
						'payrollGroupName'=>$strPayrollGroupDesc,
						'payrollGroupOrder'=>$intPayrollGroupOrder,
						'payrollGroupRC'=>$strResponsibilityCntr
					);
					$blnReturn  = $this->payroll_group_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblpayrollgroup','Added '.$strPayrollGroupCode.' Payroll_Group',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Payroll group added successfully.');
					}
					redirect('libraries/payroll_group');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Payroll code/description already exists.');
					$this->session->set_flashdata('strProject',$strProject);
					$this->session->set_flashdata('strPayrollGroupCode',$strPayrollGroupCode);
					$this->session->set_flashdata('strPayrollGroupDesc',$strPayrollGroupDesc);	
					$this->session->set_flashdata('intPayrollGroupOrder',$intPayrollGroupOrder);
					$this->session->set_flashdata('strResponsibilityCntr',$strResponsibilityCntr);				//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/payroll_group/add');
				}
			}
		}
    	
    	
    }

    public function edit()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$intPayrollGroupId = urldecode($this->uri->segment(4));
			$this->arrData['action'] = 'edit';
			$this->arrData['arrProject']=$this->project_code_model->getData(); 
			$this->arrData['arrPayrollGroup']=$this->payroll_group_model->getData($intPayrollGroupId);
		
			$this->template->load('template/template_view','libraries/payroll_group/edit_view', $this->arrData);
		}
		else
		{
			$intPayrollGroupId = $arrPost['intPayrollGroupId'];
			$strProject = $arrPost['strProject'];
			$strPayrollGroupCode = $arrPost['strPayrollGroupCode'];
			$strPayrollGroupDesc = $arrPost['strPayrollGroupDesc'];
			$intPayrollGroupOrder = $arrPost['intPayrollGroupOrder'];
			$strResponsibilityCntr = $arrPost['strResponsibilityCntr'];
			//print_r($arrPost);
			if(!empty($strProject) AND !empty($strPayrollGroupCode) AND !empty($strPayrollGroupDesc) AND !empty($intPayrollGroupOrder) AND !empty($strResponsibilityCntr)) 
			{ //print_r($arrPost);
				$arrData = array(
					'projectCode'=>$strProject,
					'payrollGroupCode'=>$strPayrollGroupCode,
					'payrollGroupName'=>$strPayrollGroupDesc,
					'payrollGroupOrder'=>$intPayrollGroupOrder,
					'payrollGroupRC'=>$strResponsibilityCntr
				);
				$blnReturn = $this->payroll_group_model->save($arrData, $intPayrollGroupId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblpayrollgroup','Edited '.$strPayrollGroupCode.' Payroll_Group',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Payroll Group updated successfully.');
				}
				redirect('libraries/payroll_group');
			}
		}
		
	}

	public function delete_payrollgroup()
	{
		$intPayrollGroupId = urldecode($this->uri->segment(4));
		$this->arrData['action'] = 'delete';
		$this->arrData['arrProject'] = $this->project_code_model->getData(); 
		$this->arrData['arrPayrollGroup']=$this->payroll_group_model->getData($intPayrollGroupId);
		
		$this->template->load('template/template_view','libraries/payroll_group/edit_view', $this->arrData);
	}

	public function delete()
	{
		$id = $this->uri->segment(4);
		$this->payroll_group_model->deleteById($id);
		$this->session->set_flashdata('strSuccessMsg','Payroll group deleted successfully.');
		redirect('libraries/payroll_group');
	}

	// public function delete()
	// {
	// 	//$strDescription=$arrPost['strDescription'];
	// 	$arrPost = $this->input->post();
	// 	$intPayrollGroupId = $this->uri->segment(4);
	// 	if(empty($arrPost))
	// 	{
	// 		$this->arrData['arrData'] = $this->payroll_group_model->getData($intPayrollGroupId);
	// 		$this->template->load('template/template_view','libraries/payroll_group/delete_view',$this->arrData);
	// 	}
	// 	else
	// 	{
	// 		$intPayrollGroupId = $arrPost['intPayrollGroupId'];
	// 		//add condition for checking dependencies from other tables
	// 		if(!empty($intPayrollGroupId))
	// 		{
	// 			$arrPayrollGroup = $this->payroll_group_model->getData($intPayrollGroupId);
	// 			$strProject = $arrPayrollGroup[0]['strProject'];	
	// 			$blnReturn = $this->payroll_group_model->delete($intPayrollGroupId);
	// 			if(count($blnReturn)>0)
	// 			{
	// 				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblpayrollgroup','Deleted '.$strPayrollGroupCode.' Payroll_Group',implode(';',$arrPayrollGroup[0]),'');
	
	// 				$this->session->set_flashdata('strMsg','Payroll group deleted successfully.');
	// 			}
	// 			redirect('libraries/payroll_group');
	// 		}
	// 	}
		
	// }
}
