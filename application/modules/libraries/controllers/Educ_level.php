<?php 
/** 
Purpose of file:    Controller for Educational Level Library
Author:             Edgardo P. Catorce Jr.
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Educ_level extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/educ_level_model'));
    }

	public function index()
	{
		$this->arrData['arrEducLevels'] = $this->educ_level_model->getData();
		$this->template->load('template/template_view', 'libraries/educational_level/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/educational_level/add_view',$this->arrData);	
		}
		else
		{	
			$strEducLevelCode = $arrPost['strEducLevelCode'];
			$strEducLevelDesc = $arrPost['strEducLevelDesc'];
			if(!empty($strEducLevelCode) && !empty($strEducLevelDesc))
			{	
				// check if educ level description or educ level code already exist
				if(count($this->educ_level_model->checkExist($strEducLevelCode, $strEducLevelDesc))==0)
				{
					$arrData = array(
						'levelCode'=>$strEducLevelCode,
						'levelDesc'=>$strEducLevelDesc,
						'system'=>0
					);
					$blnReturn  = $this->educ_level_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEducationalLevel','Added '.$strEducLevelDesc.' Educational Level',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Educational Level added successfully.');
					}
					redirect('libraries/educ_level');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Educational Level code and/or Educational Level Description already exists.');
					$this->session->set_flashdata('strEducLevelCode',$strEducLevelCode);
					$this->session->set_flashdata('strEducLevelDesc',$strEducLevelDesc);
					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/educ_level/add');
				}
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intEducLevelId = urldecode($this->uri->segment(4));
			$this->arrData['arrEducLevels']=$this->educ_level_model->getData($intEducLevelId);
			$this->template->load('template/template_view','libraries/educational_level/edit_view', $this->arrData);
		}
		else
		{
			$intEducLevelId = $arrPost['intEducLevelId'];
			$strEducLevelCode = $arrPost['strEducLevelCode'];
			$strEducLevelDesc = $arrPost['strEducLevelDesc'];
			if(!empty($strEducLevelCode) AND !empty($strEducLevelDesc)) 
			{
				$arrData = array(
					'levelCode'=>$strEducLevelCode,
					'levelDesc'=>$strEducLevelDesc
				);
				$blnReturn = $this->educ_level_model->save($arrData, $intEducLevelId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEducationalLevel','Edited '.$strEducLevelDesc.' Level',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Educational Level saved successfully.');
				}
				redirect('libraries/educ_level');
			}
		}
		
	}
	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intEducLevelId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->educ_level_model->getData($intEducLevelId);
			$this->template->load('template/template_view','libraries/educational_level/delete_view',$this->arrData);
		}
		else
		{
			$intEducLevelId = $arrPost['intEducLevelId'];
			//add condition for checking dependencies from other tables
			if(!empty($intEducLevelId))
			{
				$arrEducLevels = $this->educ_level_model->getData($intEducLevelId);
				$strEducLevelDesc = $arrEducLevels[0]['levelDesc'];	
				$blnReturn = $this->educ_level_model->delete($intEducLevelId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEducationalLevel','Deleted '.$strEducLevelDesc.' Level',implode(';',$arrEducLevels[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','Educational Level deleted successfully.');
				}
				redirect('libraries/educ_level');
			}
		}
		
	}
}
