<?php 
/** 
Purpose of file:    Controller for Zone Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zone extends MY_Controller 
{

	var $arrData;

	function __construct() 
	{
        parent::__construct();
        $this->load->model(array('libraries/zone_model'));
    }

	public function index()
	{
		$this->arrData['arrZone'] = $this->zone_model->getData();
		$this->template->load('template/template_view', 'libraries/zone/list_view', $this->arrData);
	}
	
	public function add()
  	{
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/zone/add_view',$this->arrData);	
		}
		else
		{	
			$strZoneCode = $arrPost['strZoneCode'];
			$strZoneDesc = $arrPost['strZoneDesc'];
			$strSerName = $arrPost['strSerName'];
			$strUsername = $arrPost['strUsername'];
			$strPassword = $arrPost['strPassword'];
			$strDbaseName = $arrPost['strDbaseName'];
			
			if(!empty($strZoneCode) && !empty($strZoneDesc) && !empty($strSerName) && !empty($strUsername) && !empty($strPassword) && !empty($strDbaseName))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->zone_model->checkExist($strZoneCode, $strZoneDesc))==0)
				{
					$arrData = array(
						'zonecode'=>$strZoneCode,
						'zonedesc'=>$strZoneDesc,
						'serverName'=>$strSerName,
						'username'=>$strUsername,
						'password'=>$strPassword,
						'databaseName'=>$strDbaseName
					);
					$blnReturn  = $this->zone_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblzone','Added '.$strZoneCode.' Zone',implode(';',$arrData),'');
						$this->session->set_flashdata('strMsg','Zone added successfully.');
					}
					redirect('libraries/zone');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Zone already exists.');
					$this->session->set_flashdata('strZoneCode',$strZoneCode);
					$this->session->set_flashdata('strZoneDesc',$strZoneDesc);
					redirect('libraries/zone/add');
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
			$strCode = urldecode($this->uri->segment(4));
			$this->arrData['arrZone']=$this->zone_model->getData($strCode);
			$this->template->load('template/template_view','libraries/zone/edit_view', $this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			$strZoneCode = $arrPost['strZoneCode'];
			$strZoneDesc = $arrPost['strZoneDesc'];
			$strSerName = $arrPost['strSerName'];
			$strUsername = $arrPost['strUsername'];
			$strPassword = $arrPost['strPassword'];
			$strDbaseName = $arrPost['strDbaseName'];
			
			if(!empty($strCode)) 
			{
				$arrData = array(
					'zonecode'=>$strZoneCode,
					'zonedesc'=>$strZoneDesc,
					'serverName'=>$strSerName,
					'username'=>$strUsername,
					'password'=>$strPassword,
					'databaseName'=>$strDbaseName
				);
				$blnReturn = $this->zone_model->save($arrData, $strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblzone','Edited '.$strZoneCode.' Zone',implode(';',$arrData),'');
					$this->session->set_flashdata('strMsg','Zone saved successfully.');
				}
				redirect('libraries/zone');
			}
		}
		
	}

	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strCode = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->zone_model->getData($strCode);
			$this->template->load('template/template_view','libraries/zone/delete_view',$this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			//add condition for checking dependencies from other tables
			if(!empty($strCode))
			{
				$arrZone = $this->zone_model->getData($strCode);
				$strZoneDesc = $arrZone[0]['zonedesc'];	
				$blnReturn = $this->zone_model->delete($strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblzone','Deleted '.$strZoneCode.' Zone',implode(';',$arrZone[0]),'');
					$this->session->set_flashdata('strMsg','Zone deleted successfully.');
				}
				redirect('libraries/zone');
			}
		}
		
	}
}

