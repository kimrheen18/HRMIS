<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('hr/Hr_model','Compensation_model'));
        $this->arrData = array();
    }

	public function npayroll()
	{
		$arrEmployees = array();
		$employees = $this->Hr_model->getData('','','');
		foreach($employees as $employee):
			if($employee['payrollSwitch'] == 'Y'):
				array_push($arrEmployees, $employee);
			endif;
		endforeach;
		$this->arrData['arrEmployees'] = $arrEmployees;
		$this->template->load('template/template_view','finance/notifications/npayroll/view_employees',$this->arrData);
	}

	public function nlongi()
	{
		$this->load->model('Longevity_model');
		$arrEmployees = array();
		$this->arrData['arrEmployees'] = $this->Longevity_model->getLongevityFactor();
		$this->template->load('template/template_view','finance/notifications/nlongi/view_employees',$this->arrData);
	}

	public function updateLongevityFactor()
	{
		$this->load->model(array('libraries/Position_model','Benefit_model'));

		# update longifactor
		$arrData = array('longiFactor'		=> 	$_POST['txtlongefactor'],
						 'longevitySwitch' 	=> 	'Y');
		$this->Position_model->editPosition($arrData, array('empNumber' => $_POST['txtempnumber']));

		$empPost = $this->Position_model->getDataByFields('empNumber', $_POST['txtempnumber']);
		$longiPay = $empPost[0]['actualSalary'];
		$arrData = array('incomeAmount'		=> 	$_POST['txtlongefactor'],
						 'period1'		 	=> 	'Y');
		$this->Benefit_model->editByFields($arrData, array('empNumber' => $_POST['txtempnumber'], 'incomeCode' => 'LONGI'));

		$this->session->set_flashdata('strSuccessMsg', 'Employee factor updated successfully.');
		redirect('finance/notifications/nlongi');
	}

	public function matureloans()
	{
		$this->load->model('Deduction_model');
		$arrEmployees = array();
		$this->arrData['arrEmployees'] = $this->Deduction_model->getMatureDeductions(date('n'), date('Y'));
		$this->template->load('template/template_view','finance/notifications/mloans/view_employees',$this->arrData);
	}

	public function updatematuringLoans()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$this->load->model('Deduction_model');
			$arrData = array('dateGranted'		=> $arrPost['txtdateGranted'],
							 'actualStartYear'	=> $arrPost['selsdate_yr'],
							 'actualStartMonth'	=> ltrim($arrPost['selsdate_mon'],'0'),
							 'actualEndYear'	=> $arrPost['seledate_yr'],
							 'actualEndMonth'	=> ltrim($arrPost['seledate_mon'],'0'),
							 'amountGranted'	=> str_replace(',', '', $arrPost['txtamtGranted']),
							 'monthly'			=> str_replace(',', '', $arrPost['txtmonthly']),
							 'period1'			=> str_replace(',', '', $arrPost['txtperiod1']),
							 'period2'			=> str_replace(',', '', $arrPost['txtperiod2']),
							 'period3'			=> str_replace(',', '', $arrPost['txtperiod3']),
							 'period4'			=> str_replace(',', '', $arrPost['txtperiod4']),
							 'status'			=> $arrPost['selstatus']);
			$this->Deduction_model->edit_empdeduction($arrData, $arrPost['txtid']);
			$this->session->set_flashdata('strSuccessMsg','Loan updated successfully.');
			redirect('finance/notifications/matureloans');
		endif;
	}

}
/* End of file Notifications.php
 * Location: ./application/modules/finance/controllers/notifications/Notifications.php */