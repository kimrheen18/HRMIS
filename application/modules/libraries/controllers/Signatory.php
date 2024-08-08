<?php 
/** 
Purpose of file:    Controller for Signatory Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signatory extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/signatory_model','libraries/payroll_group_model','hr/hr_model'));
    }

	public function index()
	{
		$this->arrData['arrSignatory'] = $this->signatory_model->getData();
		$this->template->load('template/template_view', 'libraries/signatory/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrSignatory'] = $this->signatory_model->getData();
			$this->template->load('template/template_view','libraries/signatory/add_view',$this->arrData);	
		}
		else
		{	
			// $strPayrollGroupCode = $arrPost['strPayrollGroupCode'];
			$strSignatory = $arrPost['strSignatory'];
			$strPosition = $arrPost['strPosition'];
			if(!empty($strSignatory) && !empty($strPosition)) 
			{	 
				// check if exam code and/or exam desc already exist
				if(count($this->signatory_model->checkExist($strSignatory, $strPosition))==0)
				{
					$arrData = array(
						// 'payrollGroupCode'=>$strPayrollGroupCode,
						'signatory'=>$strSignatory,
						'signatoryPosition'=>$strPosition,
						
					);
					$blnReturn  = $this->signatory_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblsignatory','Added '.$strSignatory.' Signatory',implode(';',$arrData),'');
						$this->session->set_flashdata('strMsg','Signatory added successfully.');
					}
					redirect('libraries/signatory');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Signatory already exists.');
					// $this->session->set_flashdata('strPayrollGroupCode',$strPayrollGroupCode);
					$this->session->set_flashdata('strSignatory',$strSignatory);
					$this->session->set_flashdata('strPosition',$strPosition);
					redirect('libraries/signatory/add');
				}
			}
		}
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intSignatoryId = urldecode($this->uri->segment(4));
			$this->arrData['arrSignatory']=$this->signatory_model->getData($intSignatoryId);
			$this->template->load('template/template_view','libraries/signatory/edit_view', $this->arrData);
		}
		else
		{
			$intSignatoryId = $arrPost['intSignatoryId'];
			// $strPayrollGroupCode = $arrPost['strPayrollGroupCode'];
			$strSignatory = $arrPost['strSignatory'];
			$strPosition = $arrPost['strPosition'];
			if(!empty($strSignatory) AND !empty($strPosition)) 
			{
				$arrData = array(
					// 'payrollGroupCode'=>$strPayrollGroupCode,
					'signatory'=>$strSignatory,
					'signatoryPosition'=>$strPosition
					
				);
				$blnReturn = $this->signatory_model->save($arrData, $intSignatoryId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblsignatory','Edited '.$strSignatory.' Signatory',implode(';',$arrData),'');
					$this->session->set_flashdata('strMsg','Signatory saved successfully.');
				}
				redirect('libraries/signatory');
			}
		}
		
	}
	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intSignatoryId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->signatory_model->getData($intSignatoryId);
			$this->template->load('template/template_view','libraries/signatory/delete_view',$this->arrData);
		}
		else
		{
			$intSignatoryId = $arrPost['intSignatoryId'];
			//add condition for checking dependencies from other tables
			if(!empty($intSignatoryId))
			{
				$arrSignatory = $this->signatory_model->getData($intSignatoryId);
				$strSignatory = $arrSignatory[0]['signatory'];	
				$blnReturn = $this->signatory_model->delete($intSignatoryId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblsignatory','Deleted '.$strSignatory.' Signatory',implode(';',$arrSignatory[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Signatory deleted successfully.');
				}
				redirect('libraries/signatory');
			}
		}
		
	}
}
