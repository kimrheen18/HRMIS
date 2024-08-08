<?php 
/** 
Purpose of file:    Controller for Plantilla Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plantilla extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/plantilla_model','libraries/position_model', 'libraries/payroll_group_model', 'libraries/plantilla_group_model' ,'libraries/exam_type_model'));
    }

	public function index()
	{
		$this->arrData['arrPlantilla'] = $this->plantilla_model->getData();
		$this->template->load('template/template_view', 'libraries/plantilla/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrPlantilla']=$this->plantilla_model->getData(); 
			$this->arrData['arrPosition']=$this->position_model->getData(); 
			$this->arrData['arrPlantillaGroup']=$this->plantilla_group_model->getData(); 
			$this->arrData['arrExam']=$this->exam_type_model->getData(); 
			$this->template->load('template/template_view','libraries/plantilla/add_view',$this->arrData);	
		}
		else
		{	
			$strItemNumber  = $arrPost['strItemNumber'];
			$strPosition  = $arrPost['strPosition'];
			$strSG = $arrPost['strSG'];
			$intAreaCode = $arrPost['intAreaCode'];
			$strAreaType = $arrPost['strAreaType'];
			$strCSEligibility = $arrPost['strCSEligibility'];
			$strPlantillaGroup = $arrPost['strPlantillaGroup'];
			$strEducationalReq = $arrPost['strEducationalReq'];
			$strTrainingReq = $arrPost['strTrainingReq'];
			$strExperienceReq = $arrPost['strExperienceReq'];
			if(!empty($strItemNumber) && !empty($strPosition))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->plantilla_model->checkExist($strItemNumber, $strPosition))==0)
				{
					$arrData = array(
						'itemNumber'=>$strItemNumber,
						'positionCode'=>$strPosition,
						'salaryGrade'=>$strSG,
						'areaCode'=>$intAreaCode,
						'areaType'=>$strAreaType,
						'examCode'=>$strCSEligibility,
						'plantillaGroupCode'=>$strPlantillaGroup,
						'educational'=>$strEducationalReq,
						'experience'=>$strTrainingReq,
						'training'=>$strExperienceReq
					);
					// print_r($arrData);
					$blnReturn  = $this->plantilla_model->add($arrData);
					
					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblplantilla','Added '.$strItemNumber.' Plantilla',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Plantilla added successfully.');
					}
					redirect('libraries/plantilla');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Plantilla code/description already exists.');
					$this->session->set_flashdata('strItemNumber ',$strItemNumber );
					$this->session->set_flashdata('strPosition',$strPosition);
					redirect('libraries/plantilla/add');
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
			$intPlantillaId = urldecode($this->uri->segment(4));
			$this->arrData['arrPlantilla']=$this->plantilla_model->getData($intPlantillaId); 
			$this->arrData['arrPosition']=$this->position_model->getData(); 
			$this->arrData['arrPlantillaGroup']=$this->plantilla_group_model->getData(); 
			$this->arrData['arrExam']=$this->exam_type_model->getData(); 
			$this->arrData['arrSG']=$this->plantilla_model->getAllSG(); 
			$this->template->load('template/template_view','libraries/plantilla/edit_view', $this->arrData);
		}
		else
		{
			$intPlantillaId = $arrPost['intPlantillaId'];
			$strItemNumber = $arrPost['strItemNumber'];
			$strPosition = $arrPost['strPosition'];
			$strSG = $arrPost['strSG'];
			$intAreaCode = $arrPost['intAreaCode'];
			$strAreaType = $arrPost['strAreaType'];
			$strCSEligibility = $arrPost['strCSEligibility'];
			$strPlantillaGroup = $arrPost['strPlantillaGroup'];
			$strEducationalReq = $arrPost['strEducationalReq'];
			$strTrainingReq = $arrPost['strTrainingReq'];
			$strExperienceReq = $arrPost['strExperienceReq'];
			if(!empty($strItemNumber) && !empty($strPosition))
			{
				$arrData = array(
					'itemNumber'=>$strItemNumber,
					'positionCode'=>$strPosition,
					'salaryGrade'=>$strSG,
					'areaCode'=>$intAreaCode,
					'areaType'=>$strAreaType,
					'examCode'=>$strCSEligibility,
					'plantillaGroupCode'=>$strPlantillaGroup,
					'educational'=>$strEducationalReq,
					'experience'=>$strTrainingReq,
					'training'=>$strExperienceReq
				);
				$blnReturn = $this->plantilla_model->save($arrData, $intPlantillaId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblplantilla','Edited '.$strItemNumber.' Plantilla',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Plantilla updated successfully.');
				}
				redirect('libraries/plantilla');
			}
		}
	}

	public function delete()
	{
		$arrPost = $this->input->post();
		$intPlantillaId = $this->uri->segment(4);
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$this->arrData['arrPlantilla'] = $this->plantilla_model->getData($intPlantillaId);
			$this->template->load('template/template_view','libraries/plantilla/delete_view',$this->arrData);
		}
		else
		{
			$intPlantillaId = $arrPost['intPlantillaId'];
			//add condition for checking dependencies from other tables
			if(!empty($intPlantillaId))
			{
				$arrPlantilla = $this->plantilla_model->getData($intPlantillaId);
				$strItemNumber = $arrPlantilla[0]['itemNumber'];	
				$blnReturn = $this->plantilla_model->delete($intPlantillaId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblplantilla','Deleted '.$strItemNumber.' Plantilla',implode(';',$arrPlantilla[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Plantilla name deleted successfully.');
				}
				redirect('libraries/plantilla');
			}
		}
	}
}
