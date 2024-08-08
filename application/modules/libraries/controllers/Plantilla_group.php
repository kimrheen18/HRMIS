<?php 
/** 
Purpose of file:    Controller for Plantilla Group Library
Author:             Edgardo P. Catorce Jr.
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plantilla_group extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/plantilla_group_model'));
    }

	public function index()
	{
		$this->arrData['arrPlantillaGroups'] = $this->plantilla_group_model->getData();
		$this->template->load('template/template_view', 'libraries/plantilla_group/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/plantilla_group/add_view',$this->arrData);	
		}
		else
		{	
			$strPlantillaGroupCode = $arrPost['strPlantillaGroupCode'];
			$strPlantillaGroupName = $arrPost['strPlantillaGroupName'];
			$intPlantillaGroupOrder = $arrPost['intPlantillaGroupOrder'];
			if(!empty($strPlantillaGroupCode) && !empty($strPlantillaGroupName))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->plantilla_group_model->checkExist($strPlantillaGroupCode, $strPlantillaGroupName))==0)
				{
					$arrData = array(
						'plantillaGroupCode'=>$strPlantillaGroupCode,
						'plantillaGroupName'=>$strPlantillaGroupName,
						'plantillaGroupOrder'=>$intPlantillaGroupOrder
					);
					$blnReturn  = $this->plantilla_group_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblplantillagroup','Added '.$strPlantillaGroupName.' Plantilla Group',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Plantilla Group added successfully.');
					}
					redirect('libraries/plantilla_group');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Plantilla group code and/or Plantilla group name already exists.');
					$this->session->set_flashdata('strPlantillaGroupCode',$strPlantillaGroupCode);
					$this->session->set_flashdata('strPlantillaGroupName',$strPlantillaGroupName);
					$this->session->set_flashdata('intPlantillaGroupOrder',$intPlantillaGroupOrder);					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/plantilla_group/add');
				}
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intPlantillaGroupId = urldecode($this->uri->segment(4));
			$this->arrData['arrPlantillaGroups']=$this->plantilla_group_model->getData($intPlantillaGroupId);
			$this->template->load('template/template_view','libraries/plantilla_group/edit_view', $this->arrData);
		}
		else
		{
			$intPlantillaGroupId = $arrPost['intPlantillaGroupId'];
			$strPlantillaGroupCode = $arrPost['strPlantillaGroupCode'];
			$strPlantillaGroupName = $arrPost['strPlantillaGroupName'];
			$intPlantillaGroupOrder = $arrPost['intPlantillaGroupOrder'];
			if(!empty($strPlantillaGroupCode) AND !empty($strPlantillaGroupName)) 
			{
				$arrData = array(
					'plantillaGroupCode'=>$strPlantillaGroupCode,
					'plantillaGroupName'=>$strPlantillaGroupName,
					'plantillaGroupOrder'=>$intPlantillaGroupOrder
				);
				$blnReturn = $this->plantilla_group_model->save($arrData, $intPlantillaGroupId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblplantillagroup','Edited '.$strPlantillaGroupName.' Plantilla Group',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Plantilla Group updated successfully.');
				}
				redirect('libraries/plantilla_group');
			}
		}
		
	}
	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intPlantillaGroupId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->plantilla_group_model->getData($intPlantillaGroupId);
			$this->template->load('template/template_view','libraries/plantilla_group/delete_view',$this->arrData);
		}
		else
		{
			$intPlantillaGroupId = $arrPost['intPlantillaGroupId'];
			//add condition for checking dependencies from other tables
			if(!empty($intPlantillaGroupId))
			{
				$arrPlantillaGroups = $this->plantilla_group_model->getData($intPlantillaGroupId);
				$strPlantillaGroupName = $arrPlantillaGroups[0]['appointmentDesc'];	
				$blnReturn = $this->plantilla_group_model->delete($intPlantillaGroupId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblplantillagroup','Deleted '.$strPlantillaGroupName.' Plantilla Group',implode(';',$arrPlantillaGroups[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','Plantilla Group deleted successfully.');
				}
				redirect('libraries/plantilla_group');
			}
		}
		
	}
}
