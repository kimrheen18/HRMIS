<?php 
/** 
Purpose of file:    Controller for Salary Schedule Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_sched extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model('Salary_sched_model');
    }

	public function index()
	{
		$this->arrData['arrSalary'] = $this->Salary_sched_model->getVersion();
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(isset($arrPost['strversion'])):
			$version = $arrPost['strversion'];
		else:
			#default version
			$arrVersion= $this->Salary_sched_model->getVersion("",1);
			if(count($arrVersion)>0)
			{
				$version = $arrVersion[0]['version'];
			}
		endif;
		// echo $version;
		$this->arrData['arrSalarysched'] = $this->Salary_sched_model->getDataSched($version);
		$this->arrData['intVersion'] = $version;
		$this->arrData['stepNumber'] = $this->Salary_sched_model->getSchedHeader('stepNumber', $version); #column
		$this->arrData['sggradeNumber'] = $this->Salary_sched_model->getSchedHeader('salaryGradeNumber', $version); #row
		$this->template->load('template/template_view', 'libraries/salary_sched/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/salary_sched/add_view',$this->arrData);	
		}
		else
		{	
			$strTitle = $arrPost['strTitle'];
			$strDesc = $arrPost['strDesc'];
			$dtmEffectivity = $arrPost['dtmEffectivity'];	
			if(!empty($strTitle))
			{	
				// check if country name or country code already exist
				if(count($this->Salary_sched_model->checkExist($strTitle))==0)
				{
					$arrData = array(
						'title'=>$strTitle,
						'description'=>$strDesc,
						'effectivity'=>$dtmEffectivity
						
					);
					$blnReturn  = $this->Salary_sched_model->add($arrData);
					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblSalarySchedVersion','Added '.$strTitle.' Salary Schedule',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Salary schedule name added successfully.');
					}
					redirect('libraries/salary_sched/add');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Salary schedule name already exists.');
					$this->session->set_flashdata('strTitle',$strTitle);
					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/salary_sched/add');
				}
			}
		}
    }

    public function add_sched()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrSalary'] = $this->Salary_sched_model->getVersion();
			$this->arrData['arrSG'] = $this->Salary_sched_model->getSG();
			$this->arrData['arrStep'] = $this->Salary_sched_model->getStepNum();
			$this->template->load('template/template_view','libraries/salary_sched/add_sched_view',$this->arrData);	
		}
		else
		{	
			$strSalarySched = $arrPost['strSalarySched'];
			$strSG = $arrPost['strSG'];	
			$intStepNum = $arrPost['intStepNum'];	
			$intActualSalary = $arrPost['intActualSalary'];	
			if(!empty($strSalarySched) && !empty($strSG) && !empty($intStepNum) && !empty($intActualSalary))
			{	
				// check if country name or country code already exist
				if(count($this->Salary_sched_model->checkExistSalary($strSalarySched,$strSG,$intStepNum))==0)
				{
					$arrData = array(
						'version'=>$strSalarySched,
						'salaryGradeNumber'=>$strSG,
						'stepNumber'=>$intStepNum,
						'actualSalary'=>$intActualSalary,
						
					);
					$blnReturn  = $this->Salary_sched_model->add_sched($arrData);
					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblsalarysched','Added '.$strSalarySched.' Salary Schedule',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Salary schedule name added successfully.');
					}
					redirect('libraries/salary_sched/');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Salary schedule name already exists.');
					$this->session->set_flashdata('strSalarySched',$strSalarySched);
					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/salary_sched/');
				}
			}
		}
    }

   public function add_existing()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrSalary'] = $this->Salary_sched_model->getVersion();
			$this->template->load('template/template_view','libraries/salary_sched/add_existing_view',$this->arrData);	
		}
		else
		{	
			$strTitle = $arrPost['strTitle'];
			$strDesc = $arrPost['strDesc'];
			$dtmEffectivity = $arrPost['dtmEffectivity'];	
			$strVersion = $arrPost['strVersion'];	
			if(!empty($strTitle))
			{	
				// check if country name or country code already exist
				if(count($this->Salary_sched_model->checkExist($strTitle))==0)
				{
					$arrData = array(
						'title'=>$strTitle,
						'description'=>$strDesc,
						'effectivity'=>$dtmEffectivity						
												
					);
					$blnReturn  = $this->Salary_sched_model->add_existing($arrData,$strVersion);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblSalarySchedVersion','Added '.$strTitle.' Salary Schedule',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Salary schedule name added successfully.');

					}
					redirect('libraries/salary_sched/add');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Salary schedule name already exists.');
					$this->session->set_flashdata('strTitle',$strTitle);
					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/salary_sched/');
				}
			}
		}
    }

    public function edit()
    {
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$this->arrData['arrSalary'] = $this->Salary_sched_model->getVersion();
				$arrPost = $this->input->post();
				//print_r($arrPost);
				if(isset($arrPost['strversion'])):
					$version = $arrPost['strversion'];
				else:
					#default version
					$arrVersion= $this->Salary_sched_model->getVersion("",1);
					if(count($arrVersion)>0)
					{
						$version = $arrVersion[0]['version'];
					}
				endif;
			$this->arrData['arrSalarysched'] = $this->Salary_sched_model->getDataSched($version);
			$this->arrData['intVersion'] = $version;
			$this->arrData['sggradeNumber'] = $this->Salary_sched_model->getSchedHeader('salaryGradeNumber', $version); #row
				$this->arrData['stepNumber'] = $this->Salary_sched_model->getSchedHeader('stepNumber', $version); #column
			$strSG=$this->uri->segment(4);
			$intStepNum=$this->uri->segment(5);
			$intActualSalary=$this->uri->segment(6);
			$intVersion=$this->uri->segment(7);

			$this->arrData['arrSG'] = $this->Salary_sched_model->getSG();
			$this->arrData['arrStep'] = $this->Salary_sched_model->getStepNum();
			$this->arrData['arrVersion'] = $this->Salary_sched_model->getVersion();
			$this->arrData['arrSalarySched'] = $this->Salary_sched_model->getSalarySched($strSG,$intStepNum,$intActualSalary,$intVersion); 
			$this->template->load('template/template_view','libraries/salary_sched/edit_view', $this->arrData);
		}
		else
		{
			// print_r($arrPost);
			// foreach($arrPost as $row):

			// 	print_r($row);
			// 	$sg=$row['sg'][0];
			// 	echo $sg.'<br>';
			// endforeach;
			$strSG = $arrPost['SG'];
			$intStepNum = $arrPost['stepNum'];
			$intActualSalary = $arrPost['intActualSalary'];
			$intVersion =$arrPost['ver'];
			//print_r($arrPost);exit(1);
			if(!empty($intActualSalary)) 
			{
				$arrData = array(
					'actualSalary'=>$intActualSalary	
				);
				$blnReturn = $this->Salary_sched_model->save($arrData,$strSG,$intStepNum,$intVersion);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblsalarysched','Edited '.$strSG.' Salary Schedule',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Salary Schedule updated successfully.');
				}
				redirect('libraries/salary_sched');
			}
		}
    }
	
	
}
