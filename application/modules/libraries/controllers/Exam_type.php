<?php 
/** 
Purpose of file:    Controller for Exam Type Library
Author:             Edgardo P. Catorce Jr.
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_type extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/exam_type_model'));
    }

	public function index()
	{
		$this->arrData['arrExamTypes'] = $this->exam_type_model->getData();
		$this->template->load('template/template_view', 'libraries/exam_type/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/exam_type/add_view',$this->arrData);	
		}
		else
		{	
			$strExamCode = $arrPost['strExamCode'];
			$strExamDesc = $arrPost['strExamDesc'];
			$blnCSCEligible = $arrPost['blnCSCEligible'];
			if(!empty($strExamCode) && !empty($strExamDesc))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->exam_type_model->checkExist($strExamCode, $strExamDesc))==0)
				{
					$arrData = array(
						'examCode'=>$strExamCode,
						'examDesc'=>$strExamDesc,
						'csElligible'=>$blnCSCEligible
					);
					$blnReturn  = $this->exam_type_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblExamType','Added '.$strExamDesc.' Exam Type',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Exam Type added successfully.');
					}
					redirect('libraries/exam_type');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Exam code and/or Exam  Description already exists.');
					$this->session->set_flashdata('strExamCode',$strExamCode);
					$this->session->set_flashdata('strExamDesc',$strExamDesc);
					$this->session->set_flashdata('blnCSCEligible',$blnCSCEligible);					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/exam_type/add');
				}
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intExamId = urldecode($this->uri->segment(4));
			$this->arrData['arrExamTypes']=$this->exam_type_model->getData($intExamId);
			$this->template->load('template/template_view','libraries/exam_type/edit_view', $this->arrData);
		}
		else
		{
			$intExamId = $arrPost['intExamId'];
			$strExamCode = $arrPost['strExamCode'];
			$strExamDesc = $arrPost['strExamDesc'];
			$blnCSCEligible = $arrPost['blnCSCEligible'];
			if(!empty($strExamCode) AND !empty($strExamDesc)) 
			{
				$arrData = array(
					'examCode'=>$strExamCode,
					'examDesc'=>$strExamDesc,
					'csElligible'=>$blnCSCEligible
				);
				$blnReturn = $this->exam_type_model->save($arrData, $intExamId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblExamType','Edited '.$strExamDesc.' Exam Type',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Exam Type updated successfully.');
				}
				redirect('libraries/exam_type');
			}
		}
		
	}
	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intExamId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->exam_type_model->getData($intExamId);
			$this->template->load('template/template_view','libraries/exam_type/delete_view',$this->arrData);
		}
		else
		{
			$intExamId = $arrPost['intExamId'];
			//add condition for checking dependencies from other tables
			if(!empty($intExamId))
			{
				$arrExamTypes = $this->exam_type_model->getData($intExamId);
				$strExamDesc = $arrExamTypes[0]['appointmentDesc'];	
				$blnReturn = $this->exam_type_model->delete($intExamId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblExamType','Deleted '.$strExamDesc.' Exam Type',implode(';',$arrExamTypes[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','Exam Type deleted successfully.');
				}
				redirect('libraries/exam_type');
			}
		}
		
	}
}
