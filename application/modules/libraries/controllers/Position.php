<?php 
/** 
Purpose of file:    Controller for Position Library
Author:             Edgardo P. Catorce Jr.
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Position extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/position_model'));
    }

	public function index()
	{
		$this->arrData['arrPositions'] = $this->position_model->getData();
		$this->template->load('template/template_view', 'libraries/position/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/position/add_view',$this->arrData);	
		}
		else
		{	
			$strPositionCode = $arrPost['strPositionCode'];
			$strPositionDescription = $arrPost['strPositionDescription'];
			$strPositionAbbreviation = $arrPost['strPositionAbbreviation'];
			if(!empty($strPositionCode) && !empty($strPositionDescription))
			{	

				$arrData = array(
					'positionCode'=>$strPositionCode,
					'positionDesc'=>$strPositionDescription,
					'positionAbb'=>$strPositionAbbreviation
				);
				$blnReturn  = $this->position_model->add($arrData);

				if(count($blnReturn)>0)
				{	
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblposition','Added '.$strPositionDescription.' Position',implode(';',$arrData),'');
				
					$this->session->set_flashdata('strSuccessMsg','Position added successfully.');
				}
				redirect('libraries/position');



				// check if exam code and/or exam desc already exist
				/*if(count($this->position_model->checkExist($strPositionCode, $strPositionDescription))==0)
				{
					$arrData = array(
						'positionCode'=>$strPositionCode,
						'positionDesc'=>$strPositionDescription,
						'positionAbb'=>$strPositionAbbreviation
					);
					$blnReturn  = $this->position_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblposition','Added '.$strPositionDescription.' Position',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Position added successfully.');
					}
					redirect('libraries/position');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Plantilla group code and/or Plantilla group name already exists.');
					$this->session->set_flashdata('strPositionCode',$strPositionCode);
					$this->session->set_flashdata('strPositionDescription',$strPositionDescription);
					$this->session->set_flashdata('strPositionAbbreviation',$strPositionAbbreviation);					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/position/add');
				}*/
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intPositionId = urldecode($this->uri->segment(4));
			$this->arrData['arrPositions']=$this->position_model->getData($intPositionId);
			$this->template->load('template/template_view','libraries/position/edit_view', $this->arrData);
		}
		else
		{
			$intPositionId = $arrPost['intPositionId'];
			$strPositionCode = $arrPost['strPositionCode'];
			$strPositionDescription = $arrPost['strPositionDescription'];
			$strPositionAbbreviation = $arrPost['strPositionAbbreviation'];
			if(!empty($strPositionCode) AND !empty($strPositionDescription)) 
			{
				$arrData = array(
					'positionCode'=>$strPositionCode,
					'positionDesc'=>$strPositionDescription,
					'positionAbb'=>$strPositionAbbreviation
				);
				$blnReturn = $this->position_model->save($arrData, $intPositionId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblposition','Edited '.$strPositionDescription.' Position',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Position updated successfully.');
				}
				redirect('libraries/position');
			}
		}
		
	}
	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intPositionId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->position_model->getData($intPositionId);
			$this->template->load('template/template_view','libraries/position/delete_view',$this->arrData);
		}
		else
		{
			$intPositionId = $arrPost['intPositionId'];
			//add condition for checking dependencies from other tables
			if(!empty($intPositionId))
			{
				$arrPositions = $this->position_model->getData($intPositionId);
				$strPositionDescription = $arrPositions[0]['positionDesc'];	
				$blnReturn = $this->position_model->delete($intPositionId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblposition','Deleted '.$strPositionDescription.' Position',implode(';',$arrPositions[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','Position deleted successfully.');
				}
				redirect('libraries/position');
			}
		}
		
	}
}
