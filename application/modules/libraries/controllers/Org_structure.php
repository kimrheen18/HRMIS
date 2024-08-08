<?php 
/** 
Purpose of file:    Controller for Org Structure Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Org_structure extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/org_structure_model','hr/hr_model'));
    }

	public function index()
	{
		$this->arrData['arrOrganization'] = $this->org_structure_model->getData();
		$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
		$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData();
		$this->arrData['arrSection'] = $this->org_structure_model->getSectionData();
		$this->arrData['arrDepartment'] = $this->org_structure_model->getDepartmentData();
		$this->template->load('template/template_view', 'libraries/org_structure/list_view', $this->arrData);
	}
	
	//ADD EXECUTIVE NAME
	public function add_exec()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->template->load('template/template_view','libraries/org_structure/add_exec_view',$this->arrData);	
		}
		else
		{	
			$strExecOffice = $arrPost['strExecOffice'];
			$strExecName = $arrPost['strExecName'];
			$strExecHead = $arrPost['strExecHead'];
			$strHeadTitle = $arrPost['strHeadTitle'];
			$strSecretary = $arrPost['strSecretary'];
			
			if(!empty($strExecOffice) && !empty($strExecName) && !empty($strExecHead) && !empty($strHeadTitle))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->org_structure_model->checkExist($strExecOffice, $strExecName))==0)
				{
					$arrData = array(
					'group1Code'=>$strExecOffice,
						'group1Name'=>$strExecName,
						'empNumber'=>$strExecHead,
						'group1HeadTitle'=>$strHeadTitle,
						'group1Secretary'=>$strSecretary
						
					);
					$blnReturn  = $this->org_structure_model->add_exec($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup1','Added '.$strExecOffice.' Org_structure',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Executive Office added successfully.');
					}
					redirect('libraries/org_structure');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Organization Executive Office already exists.');
					$this->session->set_flashdata('strExecOffice',$strExecOffice);
					$this->session->set_flashdata('strExecName',$strExecName);
					redirect('libraries/org_structure');
				}
			}
		}    	
    }
    //EDIT EXECUTIVE NAME
	public function edit_exec()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$strCode = urldecode($this->uri->segment(4));
			$this->arrData['arrOrganization']=$this->org_structure_model->getData($strCode);
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->template->load('template/template_view','libraries/org_structure/edit_exec_view', $this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			$strExecOffice = $arrPost['strExecOffice'];
			$strExecName = $arrPost['strExecName'];
			$strExecHead = $arrPost['strExecHead'];
			$strHeadTitle = $arrPost['strHeadTitle'];
			$strSecretary= $arrPost['strSecretary'];
			
			if(!empty($strExecOffice) && !empty($strExecName) && !empty($strExecHead) && !empty($strHeadTitle))
			{
				$arrData = array(
					'group1Code'=>$strExecOffice,
					'group1Name'=>$strExecName,
					'empNumber'=>$strExecHead,
					'group1HeadTitle'=>$strHeadTitle,
					'group1Secretary'=>$strSecretary
					
					
				);
				$blnReturn = $this->org_structure_model->save_exec($arrData, $strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup1','Edited '.$strExecOffice.' Org_structure',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Executive name saved successfully.');
				}
				redirect('libraries/org_structure');
			}
		}	
	}
	//DELETE EXECUTIVE NAME
	public function delete_exec()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strCode = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrOrganization'] = $this->org_structure_model->getData($strCode);
			$this->template->load('template/template_view','libraries/org_structure/delete_exec_view',$this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			//add condition for checking dependencies from other tables
			if(!empty($strCode))
			{
				$arrOrganization = $this->org_structure_model->getData($strCode);
				$strExecName = $arrOrganization[0]['group1Name'];	
				$blnReturn = $this->org_structure_model->delete_exec($strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup1','Deleted '.$strExecOffice.' Org_structure',implode(';',$arrOrganization[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','Executive name deleted successfully.');
				}
				redirect('libraries/org_structure');
			}
		}	
	}

	//ADD SERVICE NAME
	public function add_service()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->template->load('template/template_view','libraries/org_structure/add_service_view',$this->arrData);	
		}
		else
		{	
			$strExecutive = $arrPost['strExecutive'];
			$strServiceCode = $arrPost['strServiceCode'];
			$strServiceName = $arrPost['strServiceName'];
			$strServiceHead = $arrPost['strServiceHead'];
			$strServiceTitle = $arrPost['strServiceTitle'];
			$strServiceSecretary = $arrPost['strServiceSecretary'];
			if(!empty($strExecutive) && !empty($strServiceCode) && !empty($strServiceName) && !empty($strServiceHead) && !empty($strServiceTitle))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->org_structure_model->checkService($strExecutive, $strServiceCode))==0)
				{
					$arrData = array(
						'group1Code'=>$strExecutive,
						'group2Code'=>$strServiceCode,
						'group2Name'=>$strServiceName,
						'empNumber'=>$strServiceHead,
						'group2HeadTitle'=>$strServiceTitle,	
						'group2Secretary'=>$strServiceSecretary
					);
					$blnReturn  = $this->org_structure_model->add_service($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup2','Added '.$strServiceCode.' Org_structure',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Service Name added successfully.');
					}
					redirect('libraries/org_structure');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Service Name already exists.');
					$this->session->set_flashdata('strExecutive',$strExecutive);
					$this->session->set_flashdata('strServiceCode',$strServiceCode);
					redirect('libraries/org_structure'.'/#tab_service');
				}
			}
		}    	
    }
	//EDIT SERVICE NAME
	public function edit_service()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$strCode = urldecode($this->uri->segment(4));
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData($strCode);
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->template->load('template/template_view','libraries/org_structure/edit_service_view', $this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			$strExecutive = $arrPost['strExecutive'];
			$strServiceCode = $arrPost['strServiceCode'];
			$strServiceName = $arrPost['strServiceName'];
			$strServiceHead = $arrPost['strServiceHead'];
			$strServiceTitle = $arrPost['strServiceTitle'];
			$strServiceSecretary = $arrPost['strServiceSecretary'];
			if(!empty($strExecutive) && !empty($strServiceCode) && !empty($strServiceName) && !empty($strServiceHead) && !empty($strServiceTitle))
			{	
				$arrData = array(
					'group1Code'=>$strExecutive,
					'group2Code'=>$strServiceCode,
					'group2Name'=>$strServiceName,
					'empNumber'=>$strServiceHead,
					'group2HeadTitle'=>$strServiceTitle,
					'group2Secretary'=>$strServiceSecretary
					
				);
				$blnReturn = $this->org_structure_model->save_service($arrData, $strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup2','Edited '.$strServiceCode.' Org_structure',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Service Name saved successfully.');
				}
				redirect('libraries/org_structure'.'/#tab_service');
			}
		}	
	}
	//DELETE SERVICE NAME
	public function delete_service()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strCode = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData($strCode);
			$this->arrData['arrOrganization'] = $this->org_structure_model->getData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData(); 
			$this->template->load('template/template_view','libraries/org_structure/delete_service_view',$this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			//add condition for checking dependencies from other tables
			if(!empty($strCode))
			{
				$arrService = $this->org_structure_model->getData($strCode);
				$strServiceName = $arrService[0]['group2Name'];	
				$blnReturn = $this->org_structure_model->delete_service($strCode);
				if(count($blnReturn)>0) //implode(';',$arrService[0]),'');
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup2','Deleted '.$strServiceCode.' Org_structure',implode(';',$arrService),'');
					$this->session->set_flashdata('strSuccessMsg','Service name deleted successfully.');
				}
				redirect('libraries/org_structure'.'/#tab_service');
			}
		}	
	}
	//ADD DIVISION NAME
	public function add_division()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->template->load('template/template_view','libraries/org_structure/add_division_view',$this->arrData);	
		}
		else
		{	
			$strCode = $arrPost['strCode'];
			$strExecDivision = $arrPost['strExecDivision'];
			$strSerDivision = $arrPost['strSerDivision'];
			$strDivCode = $arrPost['strDivCode'];
			$strDivName = $arrPost['strDivName'];
			$strDivHead = $arrPost['strDivHead'];
			$strDivHeadTitle = $arrPost['strDivHeadTitle'];
			$strDivSecretary = $arrPost['strDivSecretary'];
			if(!empty($strExecDivision) && !empty($strSerDivision) && !empty($strDivCode) && !empty($strDivName) && !empty($strDivHead) && !empty($strDivHeadTitle))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->org_structure_model->checkDivision($strDivCode, $strDivName))==0)
				{
					$arrData = array(
						'group1Code'=>$strExecDivision,
						'group2Code'=>$strSerDivision,
						'group3Code'=>$strDivCode,
						'group3Name'=>$strDivName,
						'empNumber'=>$strDivHead,	
						'group3HeadTitle'=>$strDivHeadTitle,
						'group3Secretary'=>$strDivSecretary
					);
					// print_r($arrPost);
					// exit(1);
					$blnReturn  = $this->org_structure_model->add_division($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup3','Added '.$strDivCode.' Org_structure',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Division Name added successfully.');
					}
					redirect('libraries/org_structure');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Division Name already exists.');
					$this->session->set_flashdata('strDivCode',$strDivCode);
					$this->session->set_flashdata('strDivName',$strDivName);
					redirect('libraries/org_structure'.'/#tab_division');
				}
			}
		}    	
    }
    //EDIT DIVISION NAME
	public function edit_division()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$strCode = urldecode($this->uri->segment(4));
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData($strCode);
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->template->load('template/template_view','libraries/org_structure/edit_division_view', $this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			$strExecDivision = $arrPost['strExecDivision'];
			$strSerDivision = $arrPost['strSerDivision'];
			$strDivCode = $arrPost['strDivCode'];
			$strDivName = $arrPost['strDivName'];
			$strDivHead = $arrPost['strDivHead'];
			$strDivHeadTitle = $arrPost['strDivHeadTitle'];
			$strDivSecretary = $arrPost['strDivSecretary'];
			if(!empty($strExecDivision) && !empty($strSerDivision) && !empty($strDivCode) && !empty($strDivName) && !empty($strDivHead) && !empty($strDivHeadTitle))
			{
				$arrData = array(
					'group1Code'=>$strExecDivision,
						'group2Code'=>$strSerDivision,
						'group3Code'=>$strDivCode,
						'group3Name'=>$strDivName,
						'empNumber'=>$strDivHead,	
						'group3HeadTitle'=>$strDivHeadTitle,
						'group3Secretary'=>$strDivSecretary
					
				);
				$blnReturn = $this->org_structure_model->save_division($arrData, $strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup3','Edited '.$strDivCode.' Org_structure',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Division name saved successfully.');
				}
				redirect('libraries/org_structure'.'/#tab_division');
			}
		}	
	}
	//DELETE DIVISION NAME
	public function delete_division()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strCode = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData($strCode);
			$this->template->load('template/template_view','libraries/org_structure/delete_division_view',$this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			//add condition for checking dependencies from other tables
			if(!empty($strCode))
			{
				$arrDivision = $this->org_structure_model->getData($strCode);
				$strDivCode = $arrDivision[0]['group3Code'];	
				$blnReturn = $this->org_structure_model->delete_division($strCode);
				if(count($blnReturn)>0)
				{
					
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup3','Deleted '.$strCode.' Org_structure',implode(';',$arrDivision),'');

					$this->session->set_flashdata('strSuccessMsg','Division name deleted successfully.');
				}
				redirect('libraries/org_structure'.'/#tab_division');
			}
		}	
	}
	//ADD SECTION NAME
	public function add_section()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrSection'] = $this->org_structure_model->getSectionData();
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData();
			$this->template->load('template/template_view','libraries/org_structure/add_section_view',$this->arrData);	
		}
		else
		{	
			$strExec = $arrPost['strExec'];
			$strService = $arrPost['strService'];
			$strDivision = $arrPost['strDivision'];
			$strSecCode = $arrPost['strSecCode'];
			$strSecName = $arrPost['strSecName'];
			$strSecHead = $arrPost['strSecHead'];
			$strSecHeadTitle = $arrPost['strSecHeadTitle'];
			$strSecSecretary = $arrPost['strSecSecretary'];
			if(!empty($strExec) && !empty($strService) && !empty($strDivision) && !empty($strSecCode) && !empty($strSecName) && !empty($strSecHead))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->org_structure_model->checkSection($strSecCode, $strSecName))==0)
				{
					$arrData = array(
						'group1Code'=>$strExec,
						'group2Code'=>$strService,
						'group3Code'=>$strDivision,
						'group4Code'=>$strSecCode,
						'group4Name'=>$strSecName,	
						'empNumber'=>$strSecHead,
						'group4HeadTitle'=>$strSecHeadTitle,
						'group4Secretary'=>$strSecSecretary
					);
					$blnReturn  = $this->org_structure_model->add_section($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup4','Added '.$strSecCode.' Org_structure',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Section Name added successfully.');
					}
					redirect('libraries/org_structure');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Section Name already exists.');
					$this->session->set_flashdata('strSecCode',$strSecCode);
					$this->session->set_flashdata('strSecName',$strSecName);
					redirect('libraries/org_structure'.'/#tab_section');
				}
			}
		}    	
    }
    //EDIT SECTION NAME
    public function edit_section()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$strCode = urldecode($this->uri->segment(4));
			$this->arrData['arrSection'] = $this->org_structure_model->getSectionData($strCode);
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData();
			$this->template->load('template/template_view','libraries/org_structure/edit_section_view', $this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			$strExec = $arrPost['strExec'];
			$strService = $arrPost['strService'];
			$strDivision = $arrPost['strDivision'];
			$strSecCode = $arrPost['strSecCode'];
			$strSecName= $arrPost['strSecName'];
			$strSecHead= $arrPost['strSecHead'];
			$strSecHeadTitle= $arrPost['strSecHeadTitle'];
			$strSecSecretary= $arrPost['strSecSecretary'];
			if(!empty($strExec) AND !empty($strService) AND !empty($strDivision) AND !empty($strSecCode) AND !empty($strSecName) AND !empty($strSecHead) AND !empty($strSecHeadTitle)) 
			{
				$arrData = array(
					'group1Code'=>$strExec,
					'group2Code'=>$strService,
					'group3Code'=>$strDivision,
					'group4Code'=>$strSecCode,
					'group4Name'=>$strSecName,	
					'empNumber'=>$strSecHead,
					'group4HeadTitle'=>$strSecHeadTitle,
					'group4Secretary'=>$strSecSecretary
					
				);
				$blnReturn = $this->org_structure_model->save_section($arrData, $strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup4','Edited '.$strSecCode.' Org_structure',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Section name saved successfully.');
				}
				redirect('libraries/org_structure'.'/#tab_section');
			}
		}	
	}
	//DELETE SECTION NAME
	public function delete_section()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strCode = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrSection'] = $this->org_structure_model->getSectionData($strCode);
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData();
			$this->template->load('template/template_view','libraries/org_structure/delete_section_view',$this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			//add condition for checking dependencies from other tables
			if(!empty($strCode))
			{
				$arrSection = $this->org_structure_model->getData($strCode);
				$strSecCode = $arrSection[0]['group4Code'];	
				$blnReturn = $this->org_structure_model->delete_section($strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup1','Deleted '.$strSecCode.' Org_structure',implode(';',$arrSection),'');
	
					$this->session->set_flashdata('strSuccessMsg','Section name deleted successfully.');
				}
				redirect('libraries/org_structure'.'/#tab_section');
			}
		}	
	}

	//ADD DEPARTMENT NAME
	public function add_department()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrDepartment'] = $this->org_structure_model->getDepartmentData();
			$this->arrData['arrSection'] = $this->org_structure_model->getSectionData();
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData();
			$this->template->load('template/template_view','libraries/org_structure/add_department_view',$this->arrData);	
		}
		else
		{	
			$strExec = $arrPost['strExec'];
			$strService = $arrPost['strService'];
			$strDivision = $arrPost['strDivision'];
			$strSection = $arrPost['strSection'];
			$strDeptCode = $arrPost['strDeptCode'];
			$strDeptName = $arrPost['strDeptName'];
			$strDeptHead = $arrPost['strDeptHead'];
			$strDeptHeadTitle = $arrPost['strDeptHeadTitle'];
			$strDeptSecretary = $arrPost['strDeptSecretary'];
			// !empty($strService) AND !empty($strDivision) AND !empty($strSection) AND !empty($strDeptHead) AND !empty($strDeptHeadTitle)
			if(!empty($strExec) AND !empty($strDeptCode) AND !empty($strDeptName) ) 
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->org_structure_model->checkDepartment($strDeptCode, $strDeptName))==0)
				{
					$arrData = array(
						'group1Code'=>$strExec,
						'group2Code'=>$strService,
						'group3Code'=>$strDivision,
						'group4Code'=>$strSection,
						'group5Code'=>$strDeptCode,
						'group5Name'=>$strDeptName,	
						'empNumber'=>$strDeptHead,
						'group5HeadTitle'=>$strDeptHeadTitle,
						'group5Secretary'=>$strDeptSecretary
					);
					$blnReturn  = $this->org_structure_model->add_department($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup5','Added '.$strDeptCode.' Org_structure',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Department Name added successfully.');
					}
					redirect('libraries/org_structure');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Department Name already exists.');
					$this->session->set_flashdata('strDeptCode',$strDeptCode);
					$this->session->set_flashdata('strDeptName',$strDeptName);
					redirect('libraries/org_structure'.'/#tab_department');
				}
			}
		}    	
    }
    //EDIT DEPARTMENT NAME
    public function edit_department()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$strCode = urldecode($this->uri->segment(4));
			$this->arrData['arrDepartment'] = $this->org_structure_model->getDepartmentData($strCode);
			$this->arrData['arrSection'] = $this->org_structure_model->getSectionData();
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData();
			$this->template->load('template/template_view','libraries/org_structure/edit_department_view', $this->arrData);
		}
		else
		{

			$strCode = $arrPost['strCode'];
			$strExec = $arrPost['strExec'];
			$strService = $arrPost['strService'];
			$strDivision = $arrPost['strDivision'];
			$strSection = $arrPost['strSection'];
			$strDeptCode = $arrPost['strDeptCode'];
			$strDeptName= $arrPost['strDeptName'];
			$strDeptHead= $arrPost['strDeptHead'];
			$strDeptHeadTitle= $arrPost['strDeptHeadTitle'];
			$strDeptSecretary= $arrPost['strDeptSecretary'];
			// !empty($strService) AND !empty($strDivision) AND !empty($strSection) AND !empty($strDeptHead) AND !empty($strDeptHeadTitle)
			if(!empty($strExec) AND !empty($strDeptCode) AND !empty($strDeptName) ) 
			{
				$arrData = array(
					'group1Code'=>$strExec,
					'group2Code'=>$strService,
					'group3Code'=>$strDivision,
					'group4Code'=>$strSection,
					'group5Code'=>$strDeptCode,
					'group5Name'=>$strDeptName,	
					'empNumber'=>$strDeptHead,
					'group5HeadTitle'=>$strDeptHeadTitle,
					'group5Secretary'=>$strDeptSecretary
					
				);
				$blnReturn = $this->org_structure_model->save_department($arrData, $strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup5','Edited '.$strDeptCode.' Org_structure',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Department name saved successfully.');
				}
				redirect('libraries/org_structure'.'/#tab_department');
			}
		}	
	}
	//DELETE DEPARTMENT NAME
	public function delete_department()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strCode = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrDepartment'] = $this->org_structure_model->getDepartmentData($strCode);
			$this->arrData['arrSection'] = $this->org_structure_model->getSectionData();
			$this->arrData['arrService'] = $this->org_structure_model->getServiceData();
			$this->arrData['arrEmployees'] = $this->hr_model->getData();
			$this->arrData['arrOrganization']=$this->org_structure_model->getData();
			$this->arrData['arrDivision'] = $this->org_structure_model->getDivisionData();
			$this->template->load('template/template_view','libraries/org_structure/delete_department_view',$this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			//add condition for checking dependencies from other tables
			if(!empty($strCode))
			{
				$arrDepartment = $this->org_structure_model->getData($strCode);
				$strDeptCode = $arrDepartment[0]['group5Code'];	
				$blnReturn = $this->org_structure_model->delete_department($strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblgroup5','Deleted '.$strDeptCode.' Org_structure',implode(';',$arrDepartment),'');
	
					$this->session->set_flashdata('strSuccessMsg','Department name deleted successfully.');
				}
				redirect('libraries/org_structure'.'/#tab_department');
			}
		}	
	}


}
