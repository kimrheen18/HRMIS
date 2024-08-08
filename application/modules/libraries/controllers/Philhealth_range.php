<?php 
/** 
Purpose of file:    Controller for PhilHealth Range Library
Author:             Rose Anne Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class philhealth_range extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/philhealth_range_model'));
    }

	public function index()
	{
		$this->arrData['arrPhilHealth'] = $this->philhealth_range_model->getPhilhealth();
		$this->template->load('template/template_view', 'libraries/philhealth_range/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/philhealth_range/add_view',$this->arrData);	
		}
		else
		{	
			$strRangeFrom = $arrPost['strRangeFrom'];
			$strRangeTo = $arrPost['strRangeTo'];
			$strSalBase = $arrPost['strSalBase'];
			$intTotalContri = $arrPost['intTotalContri'];
			if(!empty($strRangeFrom) && !empty($strRangeTo))
			{	
				if(count($this->philhealth_range_model->checkExist($strRangeFrom, $strRangeTo))==0)
				{
					$arrData = array(
						'philhealthFrom'=>$strRangeFrom,
						'philhealthTo'=>$strRangeTo,
						'philSalaryBase'=>$strSalBase,
						'philMonthlyContri'=>$intTotalContri
					);
					$blnReturn  = $this->philhealth_range_model->add($arrData);
					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblPhilhealthRange','Added '.$strRangeFrom.' PhilHealth Range',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Philhealth Range added successfully.');
					}
					redirect('libraries/philhealth_range');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Philhealth range already exists.');
					$this->session->set_flashdata('strRangeFrom',$strRangeFrom);
					$this->session->set_flashdata('strRangeTo',$strRangeTo);
					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/philhealth_range/add');
				}
			}
		}
    	
    	
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intPhId = urldecode($this->uri->segment(4));
			$this->arrData['arrPhilHealth']=$this->philhealth_range_model->getPhilhealth($intPhId);
			$this->template->load('template/template_view','libraries/philhealth_range/edit_view', $this->arrData);
		}
		else
		{
			$intPhId = $arrPost['intPhId'];
			$strRangeFrom = $arrPost['strRangeFrom'];
			$strRangeTo = $arrPost['strRangeTo'];
			$strSalBase = $arrPost['strSalBase'];
			$intTotalContri = $arrPost['intTotalContri'];
			if(!empty($strRangeFrom) && !empty($strRangeTo))
			{	
				$arrData = array(
					'philhealthFrom'=>$strRangeFrom,
					'philhealthTo'=>$strRangeTo,
					'philSalaryBase'=>$strSalBase,
					'philMonthlyContri'=>$intTotalContri
				);
				// print_r($arrData);
				// exit(1);
				$blnReturn = $this->philhealth_range_model->save($arrData, $intPhId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblPhilhealthRange','Edited '.$strRangeFrom.' PhilHealth Range',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','PhilHealth Range updated successfully.');
				}
				redirect('libraries/philhealth_range');
			}
		}
		
	}
	public function delete()
	{
		$arrPost = $this->input->post();
		$intPhId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrPhilHealth'] = $this->philhealth_range_model->getPhilhealth($intPhId);
			$this->template->load('template/template_view','libraries/philhealth_range/delete_view',$this->arrData);
		}
		else
		{			
			$intPhId = $arrPost['intPhId'];
			if(!empty($intPhId))
			{
				$arrPhilHealth = $this->philhealth_range_model->getPhilhealth($intPhId);
				$strRangeFrom = $arrPhilHealth[0]['philhealthFrom'];	
				$blnReturn = $this->philhealth_range_model->delete($intPhId);

				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblPhilhealthRange','Deleted '.$strRangeFrom.' PhilHealth Range',implode(';',$arrPhilHealth[0]),'');
	
					$this->session->set_flashdata('strSuccessMsg','PhilHealth Range deleted successfully.');
				}
				redirect('libraries/philhealth_range');
			}
		}
		
	}
}
