<?php 
/** 
Purpose of file:    Controller for Country Library
Author:             Rose Anne Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/country_model'));
    }

	public function index()
	{
		$this->arrData['arrCountries'] = $this->country_model->getData();
		$this->template->load('template/template_view', 'libraries/country/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/country/add_view',$this->arrData);	
		}
		else
		{	
			$strCountryName = $arrPost['strCountryName'];
			$strCountryCode = $arrPost['strCountryCode'];
			if(!empty($strCountryName) && !empty($strCountryCode))
			{	
				// check if country name or country code already exist
				if(count($this->country_model->checkExist($strCountryName, $strCountryCode))==0)
				{
					$arrData = array(
						'countryName'=>$strCountryName,
						'countryCode'=>$strCountryCode
					);
					$blnReturn  = $this->country_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblCountrY','Added '.$strCountryName.' Country',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Country added successfully.');
					}
					redirect('libraries/country');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Country name and/or country code already exists.');
					$this->session->set_flashdata('strCountryName',$strCountryName);
					$this->session->set_flashdata('strCountryCode',$strCountryCode);
					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/country/add');
				}
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intCountryId = urldecode($this->uri->segment(4));
			$this->arrData['arrCountries']=$this->country_model->getData($intCountryId);
			$this->template->load('template/template_view','libraries/country/edit_view', $this->arrData);
		}
		else
		{
			$intCountryId = $arrPost['intCountryId'];
			$strCountryName = $arrPost['strCountryName'];
			$strCountryCode = $arrPost['strCountryCode'];
			if(!empty($strCountryName) AND !empty($strCountryCode)) 
			{
				$arrData = array(
					'countryName'=>$strCountryName,
					'countryCode'=>$strCountryCode
				);
				$blnReturn = $this->country_model->save($arrData, $intCountryId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblCountry','Edited '.$strCountryName.' Country',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Country updated successfully.');
				}
				redirect('libraries/country');
			}
		}
		
	}
	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intCountryId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->country_model->getData($intCountryId);
			$this->template->load('template/template_view','libraries/country/delete_view',$this->arrData);
		}
		else
		{
			$intCountryId = $arrPost['intCountryId'];
			//add condition for checking dependencies from other tables
			if(!empty($intCountryId))
			{
				$arrCountries = $this->country_model->getData($intCountryId);
				$strCountryName = $arrCountries[0]['countryName'];	
				$blnReturn = $this->country_model->delete($intCountryId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblCountry','Deleted '.$strCountryName.' Country',implode(';',$arrCountries[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','Country deleted successfully.');
				}
				redirect('libraries/country');
			}
		}
		
	}
}
