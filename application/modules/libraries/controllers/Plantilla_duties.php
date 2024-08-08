<?php 
/** 
Purpose of file:    Controller for Plantilla Duties Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plantilla_duties extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/plantilla_duties_model','libraries/plantilla_model'));
    }

	public function index()
	{
		$this->arrData['arrPDuties'] = $this->plantilla_duties_model->getData();
		$this->template->load('template/template_view', 'libraries/plantilla_duties/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrPlantilla']=$this->plantilla_model->getData(); 
			$this->arrData['arrPDuties'] = $this->plantilla_duties_model->getData();
			$this->template->load('template/template_view','libraries/plantilla_duties/add_view',$this->arrData);	
		}
		else
		{	
			$strPlantilla = $arrPost['strPlantilla'];
			$intPercentWork = $arrPost['intPercentWork'];
			$strDuties = $arrPost['strDuties'];
			if(!empty($strPlantilla) && !empty($intPercentWork) && !empty($strDuties))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->plantilla_duties_model->checkExist($strDuties))==0)
				{
					$arrData = array(
						'itemNumber'=>$strPlantilla,
						'percentWork'=>$intPercentWork,
						'itemDuties'=>$strDuties
					);
					$blnReturn  = $this->plantilla_duties_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblplantilladuties','Added '.$strDuties.' Plantilla_Duties',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Duties added successfully.');
					}
					redirect('libraries/plantilla_duties');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Plantilla duties already exists.');
					$this->session->set_flashdata('strPlantilla',$strPlantilla);
					$this->session->set_flashdata('intPercentWork',$intPercentWork);
					$this->session->set_flashdata('strDuties',$strDuties);	
					redirect('libraries/plantilla_duties/add');
				}
			}
		}
    	
    }

    public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intPDutiesIndex = urldecode($this->uri->segment(4));
			$this->arrData['arrPDuties'] = $this->plantilla_duties_model->getData($intPDutiesIndex);
			$this->template->load('template/template_view','libraries/plantilla_duties/edit_view', $this->arrData);
		}
		else
		{
			$intPDutiesIndex = $arrPost['intPDutiesIndex'];
			$intPercentWork = $arrPost['intPercentWork'];
			$strDuties = $arrPost['strDuties'];
			if(!empty($strDuties)) 
			{
				$arrData = array(
					'percentWork'=>$intPercentWork,
					'itemduties'=>$strDuties
				);
				$blnReturn = $this->plantilla_duties_model->save($arrData,$intPDutiesIndex);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblPlantillaDuties','Edited '.$strDuties.' Plantilla_Duties',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Plantilla Duties saved successfully.');
				}
				redirect('libraries/plantilla_duties');
			}
		}
		
	}


	public function delete()
	{
		$arrPost = $this->input->post();
		$intPDutiesIndex = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->plantilla_duties_model->getData($intPDutiesIndex);
			$this->template->load('template/template_view','libraries/plantilla_duties/delete_view',$this->arrData);
		}
		else
		{
			$intPDutiesIndex = $arrPost['intPDutiesIndex'];
			//add condition for checking dependencies from other tables
			if(!empty($intPDutiesIndex))
			{
				$arrDuties = $this->plantilla_duties_model->getData($intPDutiesIndex);
				$strDuties = $arrDuties[0]['itemduties'];	
				$blnReturn = $this->plantilla_duties_model->delete($intPDutiesIndex);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblPlantillaDuties','Deleted '.$strDuties.' Plantilla_Duties',implode(';',$arrDuties[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Duties deleted successfully.');
				}
				redirect('libraries/plantilla_duties');
			}
		}
		
	}

   
}
