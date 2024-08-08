<?php 
/** 
Purpose of file:    Controller for Agency Profile Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agency_profile extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/agency_profile_model'));
    }

	public function index()
	{
		$this->arrData['arrAgency'] = $this->agency_profile_model->getData();
		$this->template->load('template/template_view', 'libraries/agency_profile/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/agency_profile/add_view',$this->arrData);	
		}
		else
		{	
			$strAgencyName = $arrPost['strAgencyName'];
			$strAgencyCode = $arrPost['strAgencyCode'];
			$strRegion = $arrPost['strRegion'];
			$intTinNum = $arrPost['intTinNum'];
			$strAddress = $arrPost['strAddress'];
			$intZipCode = $arrPost['intZipCode'];
			$intTelephone = $arrPost['intTelephone'];
			$intFax = $arrPost['intFax'];
			$strEmail = $arrPost['strEmail'];
			$strWebsite = $arrPost['strWebsite'];
			// $strSalarySched = $arrPost['strSalarySched'];
			// $intGSISNum = $arrPost['intGSISNum'];
			// $intGSISEmpShare = $arrPost['intGSISEmpShare'];
			// $intGSISEmprShare = $arrPost['intGSISEmprShare'];
			// $intPagibigNum = $arrPost['intPagibigNum'];
			// $intPagibigEmpShare = $arrPost['intPagibigEmpShare'];
			// $intPagibigEmprShare = $arrPost['intPagibigEmprShare'];
			// $intProvidentEmpShare = $arrPost['intProvidentEmpShare'];
			// $intProvidentEmprShare = $arrPost['intProvidentEmprShare'];
			// $intPhilhealthEmpShare = $arrPost['intPhilhealthEmpShare'];
			// $intPhilhealthEmprShare = $arrPost['intPhilhealthEmprShare'];
			// $intPhilhealthPercentage = $arrPost['intPhilhealthPercentage'];
			// $intPhilhealthNum = $arrPost['intPhilhealthNum'];
			$strMission = $arrPost['strMission'];
			$strVision = $arrPost['strVision'];
			$strMandate = $arrPost['strMandate'];
			// $strAccountNum = $arrPost['strAccountNum'];
			if(!empty($strAgencyName) && !empty($strAgencyCode) && !empty($strRegion))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->agency_profile_model->checkExist($strAgencyName, $strAgencyCode))==0)
				{
					$arrData = array(
						'agencyName'=>$strAgencyName,
						'abbreviation'=>$strAgencyCode,
						'region'=>$strRegion,
						'agencyTin'=>$intTinNum,
						'address'=>$strAddress,
						'zipCode'=>$intZipCode,
						'telephone'=>$intTelephone,
						'facsimile'=>$intFax,
						'email'=>$strEmail,
						'website'=>$strWebsite,
						// 'salarySchedule'=>$strSalarySched,
						// 'gsisId'=>$intGSISNum,
						// 'gsisEmpShare'=>$intGSISEmpShare,
						// 'gsisEmprShare'=>$intGSISEmprShare,
						// 'pagibigId'=>$intPagibigNum,
						// 'pagibigEmpShare'=>$intPagibigEmpShare,
						// 'pagibigEmprShare'=>$intPagibigEmprShare,
						// 'providentEmpShare'=>$intProvidentEmpShare,
						// 'providentEmprShare'=>$intProvidentEmprShare,
						// 'philhealthEmpShare'=>$intPhilhealthEmpShare,
						// 'philhealthEmprShare'=>$intPhilhealthEmprShare,
						// 'philhealthPercentage'=>$intPhilhealthPercentage,
						// 'PhilhealthNum'=>$intPhilhealthNum,
						'Mission'=>$strMission,
						'Vision'=>$strMandate,
						'Mandate'=>$strVision,
						// 'AccountNum'=>$strAccountNum,
						
					);
					$blnReturn  = $this->agency_profile_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblagency','Added '.$strAgencyName.' Agency_profile',implode(';',$arrData),'');
					
						$this->session->set_flashdata('strSuccessMsg','Agency name added successfully.');
					}
					redirect('libraries/agency_profile');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Agency already exists.');
					$this->session->set_flashdata('strAgencyName',$strAgencyName);
					$this->session->set_flashdata('strAgencyCode',$strAgencyCode);
					redirect('libraries/agency_profile/add');
				}
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intAgencyName = urldecode($this->uri->segment(4));
			$this->arrData['arrAgency']=$this->agency_profile_model->getData($intAgencyName);
			$this->template->load('template/template_view','libraries/agency_profile/edit_view', $this->arrData);
		}
		else
		{
			$intAgencyName = $arrPost['intAgencyName'];
			$strAgencyName = $arrPost['strAgencyName'];
			$strAgencyCode = $arrPost['strAgencyCode'];
			$strRegion = $arrPost['strRegion'];
			$intTinNum = $arrPost['intTinNum'];
			$strAddress = $arrPost['strAddress'];
			$intZipCode = $arrPost['intZipCode'];
			$intTelephone = $arrPost['intTelephone'];
			$intFax = $arrPost['intFax'];
			$strEmail = $arrPost['strEmail'];
			$strWebsite = $arrPost['strWebsite'];
			$strSalarySched = $arrPost['strSalarySched'];

			$intBeforeOT = $arrPost['intBeforeOT'];
			$intMaxOT = $arrPost['intMaxOT'];
			$dtmExpMon = $arrPost['dtmExpMon'];
			$dtmExpYr = $arrPost['dtmExpYr'];
			$intFlagTime = $arrPost['intFlagTime'];
			$intAutoComputeTax = isset($arrPost['intAutoComputeTax']) ? 1 : 0;

			$intGSISNum = $arrPost['intGSISNum'];
			$intGSISEmpShare = $arrPost['intGSISEmpShare'];
			$intGSISEmprShare = $arrPost['intGSISEmprShare'];
			$intPagibigNum = $arrPost['intPagibigNum'];
			$intPagibigEmpShare = $arrPost['intPagibigEmpShare'];
			$intPagibigEmprShare = $arrPost['intPagibigEmprShare'];
			$intProvidentEmpShare = $arrPost['intProvidentEmpShare'];
			$intProvidentEmprShare = $arrPost['intProvidentEmprShare'];
			$intPhilhealthEmpShare = $arrPost['intPhilhealthEmpShare'];
			$intPhilhealthEmprShare = $arrPost['intPhilhealthEmprShare'];
			$intPhilhealthPercentage = $arrPost['intPhilhealthPercentage'];
			$intPhilhealthNum = $arrPost['intPhilhealthNum'];
			$strMission = $arrPost['strMission'];
			$strVision = $arrPost['strVision'];
			$strMandate = $arrPost['strMandate'];
			$strAccountNum = $arrPost['strAccountNum'];
			if(!empty($strAgencyName) AND !empty($strAgencyCode)) 
			{
				$arrData = array(
						'agencyName'=>$strAgencyName,
						'abbreviation'=>$strAgencyCode,
						'region'=>$strRegion,
						'agencyTin'=>$intTinNum,
						'address'=>$strAddress,
						'zipCode'=>$intZipCode,
						'telephone'=>$intTelephone,
						'facsimile'=>$intFax,
						'email'=>$strEmail,
						'website'=>$strWebsite,
						'salarySchedule'=>$strSalarySched,
						'minOT'=>$intBeforeOT,
						'maxOT'=>$intMaxOT,
						'expr_cto_mon'=>$dtmExpMon,
						'expr_cto_yr'=>$dtmExpYr,
						'flagTime'=>$intFlagTime,
						'autoComputeTax'=>$intAutoComputeTax,
						'gsisId'=>$intGSISNum,
						'gsisEmpShare'=>$intGSISEmpShare,
						'gsisEmprShare'=>$intGSISEmprShare,
						'pagibigId'=>$intPagibigNum,
						'pagibigEmpShare'=>$intPagibigEmpShare,
						'pagibigEmprShare'=>$intPagibigEmprShare,
						'providentEmpShare'=>$intProvidentEmpShare,
						'providentEmprShare'=>$intProvidentEmprShare,
						'philhealthEmpShare'=>$intPhilhealthEmpShare,
						'philhealthEmprShare'=>$intPhilhealthEmprShare,
						'philhealthPercentage'=>$intPhilhealthPercentage,
						'PhilhealthNum'=>$intPhilhealthNum,
						'Mission'=>$strMission,
						'Vision'=>$strVision,
						'Mandate'=>$strMandate,
						'AccountNum'=>$strAccountNum,
					
				);
				$blnReturn = $this->agency_profile_model->save($arrData, $intAgencyName);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblagency','Edited '.$strAgencyName.' Agency_profile',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Agency profile updated successfully.');
				}
				redirect('libraries/agency_profile');
			}
		}
	}

	public function edit_logo()
	{
	 	$arrPost = $this->input->post();
		$this->template->load('template/template_view','libraries/agency_profile/edit_logo_view', $this->arrData);
	
	}

	public function upload()
	{
		$arrPost = $this->input->post();

		$config['upload_path']          = 'assets/images/';
        $config['allowed_types']        = 'jpg|png';
        
		$config['file_name'] = 'logo.png';
		$config['overwrite'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload('userfile'))
		{
			//echo $this->upload->display_errors();
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
			$this->session->set_flashdata('error','Please try again!');
		}
		else
		{
			$data = $this->upload->data();
			print_r($data);

				$arrLogo = array(
					'agencyLogo' => $data['file_name']	
				);
			// $this->agency_profile_model->edit_logo($arrLogo, $arrPost['id']);
			$this->session->set_flashdata('upload_status','Upload successfully saved.');
		}
		redirect('libraries/agency_profile');
		
	}

	public function delete()
	{
		$arrPost = $this->input->post();
		$intAgencyName = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->agency_profile_model->getData($intAgencyName);
			$this->template->load('template/template_view','libraries/agency_profile/delete_view',$this->arrData);
		}
		else
		{
			$intAgencyName = $arrPost['intAgencyName'];
			//add condition for checking dependencies from other tables
			if(!empty($intAgencyName))
			{
				$arrAgency = $this->agency_profile_model->getData($intAgencyName);
				$strAgencyCode = $arrAgency[0]['abbreviation'];	
				$blnReturn = $this->agency_profile_model->delete($intAgencyName);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblagency','Deleted '.$strAgencyName.' Agency_profile',implode(';',$arrAgency[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Agency profile deleted successfully.');
				}
				redirect('libraries/agency_profile');
			}
		}
		
	}
}
