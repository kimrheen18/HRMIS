<?php 
/** 
Purpose of file:    Controller for Scholarship Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scholarship extends MY_Controller 
{

	var $arrData;

	function __construct() 
	{
        parent::__construct();
        $this->load->model(array('libraries/scholarship_model'));
    }

	public function index()
	{
		$this->arrData['arrScholarship'] = $this->scholarship_model->getData();
		$this->template->load('template/template_view', 'libraries/scholarship/list_view', $this->arrData);
	}
	
	public function add()
  	{
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/scholarship/add_view',$this->arrData);	
		}
		else
		{	
			$strScholarship = $arrPost['strScholarship'];
			
			if(!empty($strScholarship))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->scholarship_model->checkExist($strScholarship))==0)
				{
					$arrData = array(
						'description'=>$strScholarship,
						
					);
					$blnReturn  = $this->scholarship_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblScholarship','Added '.$strScholarship.' Scholarship',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Scholarship added successfully.');
					}
					redirect('libraries/scholarship');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Scholarship already exists.');
					$this->session->set_flashdata('description',$strScholarship);
					redirect('libraries/scholarship/add');
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
			$intScholarshipId = urldecode($this->uri->segment(4));
			$this->arrData['arrScholarship']=$this->scholarship_model->getData($intScholarshipId);
			$this->template->load('template/template_view','libraries/scholarship/edit_view', $this->arrData);
		}
		else
		{
			$intScholarshipId = $arrPost['intScholarshipId'];
			$strScholarship = $arrPost['strScholarship'];
			
			if(!empty($strScholarship)) 
			{
				$arrData = array(
					'description'=>$strScholarship,
				
				);
				$blnReturn = $this->scholarship_model->save($arrData, $intScholarshipId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblScholarship','Edited '.$strScholarship.' Scholarship',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Scholarship updated successfully.');
				}
				redirect('libraries/scholarship');
			}
		}
		
	}

	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intScholarshipId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->scholarship_model->getData($intScholarshipId);
			$this->template->load('template/template_view','libraries/scholarship/delete_view',$this->arrData);
		}
		else
		{
			$intScholarshipId = $arrPost['intScholarshipId'];
			//add condition for checking dependencies from other tables
			if(!empty($intScholarshipId))
			{
				$arrScholarship = $this->scholarship_model->getData($intScholarshipId);
				$strScholarship = $arrScholarship[0]['description'];	
				$blnReturn = $this->scholarship_model->delete($intScholarshipId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblScholarship','Deleted '.$strScholarship.' Scholarship',implode(';',$arrScholarship[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','Scholarship deleted successfully.');
				}
				redirect('libraries/scholarship');
			}
		}
		
	}
}

