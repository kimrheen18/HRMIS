<?php 
/** 
Purpose of file:    Controller for Employment Status Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Separation_mode extends MY_Controller 
{

	var $arrData;

	function __construct() 
	{
        parent::__construct();
        $this->load->model(array('libraries/separation_mode_model'));
    }

	public function index()
	{
		$this->arrData['arrSeparation'] = $this->separation_mode_model->getData();
		$this->template->load('template/template_view', 'libraries/separation_mode/list_view', $this->arrData);
	}
	
	public function add()
  	{
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/separation_mode/add_view',$this->arrData);	
		}
		else
		{	
			$strSeparationMode = $arrPost['strSeparationMode'];
			
			if(!empty($strSeparationMode))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->separation_mode_model->checkExist($strSeparationMode))==0)
				{
					$arrData = array(
						'separationCause'=>$strSeparationMode,
						
					);
					$blnReturn  = $this->separation_mode_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblSeparationCause','Added '.$strSeparationMode.' Employment Status',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Employment Status added successfully.');
					}
					redirect('libraries/separation_mode');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Employment Status already exists.');
					$this->session->set_flashdata('separationCause',$strSeparationMode);
					redirect('libraries/separation_mode/add');
				}
			}
		}
    }

     public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$strSepCause = urldecode($this->uri->segment(4));
			$this->arrData['arrSeparation']=$this->separation_mode_model->getData($strSepCause);
			$this->template->load('template/template_view','libraries/separation_mode/edit_view', $this->arrData);
		}
		else
		{
			$strSepCause = $arrPost['strSepCause'];
			$strMode=$arrPost['strMode'];
		
			if(!empty($strMode)) 
			{
				$arrData = array(
					'separationCause'=>$strMode
					
				);
				$blnReturn = $this->separation_mode_model->save($arrData, $strSepCause);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblSeparationCause','Edited '.$strMode.' Employment Status',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Employment Status updated successfully.');
				}
				redirect('libraries/separation_mode');
			}
		}
	}

	public function delete()
	{
	
		$arrPost = $this->input->post();
		$strSepCause = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->separation_mode_model->getData($strSepCause);
			$this->template->load('template/template_view','libraries/separation_mode/delete_view', $this->arrData);
			
		}
		else
		{
			$strSepCause = $arrPost['strSepCause'];
			//add condition for checking dependencies from other tables
			if(!empty($strSepCause))
			{
				$arrSeparation = $this->separation_mode_model->getData($strSepCause);
				$strMode = $arrSeparation[0]['separationCause'];	
				$blnReturn = $this->separation_mode_model->delete($strSepCause);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblSeparationCause','Deleted '.$strCode.' Employment Status',implode(';',$arrSeparation[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Employment Status deleted successfully.');
				}
				redirect('libraries/separation_mode');
			}
		}
		
	}

}
