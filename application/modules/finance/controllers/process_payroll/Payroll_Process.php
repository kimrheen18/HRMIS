<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_process extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('Finance/Deduction_Model'));
    }

	// public function index()
	// {
	// 	$status = $this->uri->segment(3);
	// 	$this->arrData['deductions'] = $this->Deduction_Model->getDeductionsByStatus($status);
	// 	$this->arrData['status'][0] = $status == '' ? array('Show All', '') : ($status == 1 ? array('Show Inactive', 1) : array('Show Active', 0));
	// 	$this->arrData['status'][1] = $status == '' ? array('Show Active', 0) : ($status == 1 ? array('Show Active', 0) : array('Show All', ''));
	// 	$this->arrData['status'][2] = $status == '' ? array('Show Inactive', 1) : ($status == 1 ? array('Show All', '') : array('Show Inactive', 1));
	// 	$this->arrData['agency'] = $this->Deduction_Model->getDeductionGroup('');
	// 	$this->template->load('template/template_view','finance/libraries/deductions/deductions_view',$this->arrData);
	// }

	// public function add()
	// {
	// 	$arrPost = $this->input->post();
	// 	if(!empty($arrPost)):
	// 		$arrData = array(
	// 			'deductionCode' => $arrPost['txtddcode'],
	// 			'deductionDesc' => $arrPost['txtdesc'],
	// 			'deductionType' => $arrPost['seltype'],
	// 			'deductionGroupCode' => $arrPost['selAgency'],
	// 			'deductionAccountCode' => $arrPost['txtacctcode'],
	// 			'hidden' => 0
	// 		);
	// 		if(!$this->Deduction_Model->isDeductionCodeExists($arrPost['txtddcode'],'add')):
	// 			$this->Deduction_Model->add($arrData);
	// 			$this->session->set_flashdata('strSuccessMsg','Deduction added successfully.');
	// 			redirect('finance/deductions');
	// 		else:
	// 			$this->arrData['err'] = 'Code already exists';
	// 		endif;
	// 	endif;
	// 	$this->arrData['action'] = 'add';
	// 	$this->arrData['checkbox'] = 0;
	// 	$this->arrData['agency'] = $this->Deduction_Model->getDeductionGroup('');
	// 	$this->template->load('template/template_view','finance/libraries/deductions/deductions_add',$this->arrData);
	// }

	// public function add_agency()
	// {
	// 	$arrPost = $this->input->post();
	// 	if(!empty($arrPost)):
	// 		$arrData = array(
	// 			'deductionGroupCode' => $arrPost['agency-code'],
	// 			'deductionGroupDesc' => $arrPost['agency-desc'],
	// 			'deductionGroupAccountCode' => $arrPost['acct-code']
	// 		);
	// 		if(!$this->Deduction_Model->isDeductionGroupExists($arrPost['agency-code'],'add')):
	// 			$this->Deduction_Model->addAgency($arrData);
	// 			$this->session->set_flashdata('strSuccessMsg','Agency added successfully.');
	// 			redirect('finance/deductions?tab=agency');
	// 		else:
	// 			$this->arrData['err'] = 'Code already exists';
	// 		endif;		
	// 	endif;
	// 	$this->arrData['action'] = 'add';
	// 	$this->template->load('template/template_view','finance/libraries/deductions/agency_add',$this->arrData);
	// }

	// public function edit($code)
	// {
	// 	$code = str_replace('%20', ' ', $code);
	// 	$arrPost = $this->input->post();
	// 	if(!empty($arrPost)):
	// 		$arrData = array(
	// 			'deductionDesc' => $arrPost['txtdesc'],
	// 			'deductionType' => $arrPost['seltype'],
	// 			'deductionGroupCode' => $arrPost['selAgency'],
	// 			'deductionAccountCode' => $arrPost['txtacctcode'],
	// 			'hidden' => $arrPost['chkisactive'] == 'on' ? 1 : 0
	// 		);
	// 		$this->Deduction_Model->edit($arrData, $code);
	// 		$this->session->set_flashdata('strSuccessMsg','Deduction updated successfully.');
	// 		redirect('finance/deductions');
	// 	else:
	// 		$this->arrData['action'] = 'edit';
	// 		$this->arrData['data'] = $this->Deduction_Model->getDeductions($code);
	// 		$this->arrData['agency'] = $this->Deduction_Model->getDeductionGroup('');
	// 		$this->template->load('template/template_view','finance/libraries/deductions/deductions_add',$this->arrData);
	// 	endif;
	// }

	// public function edit_agency($code)
	// {
	// 	$code = str_replace('%20', ' ', $code);
	// 	$arrPost = $this->input->post();
	// 	if(!empty($arrPost)):
	// 		$arrData = array(
	// 			'deductionGroupDesc' => $arrPost['agency-desc'],
	// 			'deductionGroupAccountCode' => $arrPost['acct-code']
	// 		);
	// 		if(!$this->Deduction_Model->isDeductionGroupExists($arrPost['agency-code'],'edit')):
	// 			$this->Deduction_Model->edit_agency($arrData, $code);
	// 			$this->session->set_flashdata('strSuccessMsg','Agency updated successfully.');
	// 			redirect('finance/deductions?tab=agency');
	// 		else:
	// 			$this->arrData['err'] = 'Code already exists';
	// 		endif;
	// 	endif;
	// 	$this->arrData['action'] = 'edit';
	// 	$this->arrData['arrData'] = $this->Deduction_Model->getDeductionGroup($code);
	// 	$this->template->load('template/template_view','finance/libraries/deductions/agency_add',$this->arrData);
	// }

	// public function delete()
	// {
	// 	$this->Deduction_Model->delete($_GET['tab'], $_GET['code']);
	// }

	// public function delete()
	// {
	// 	$arrPost = $this->input->post();
	// 	$this->Deduction_Model->delete($arrPost['txtappt']);
	// 	$this->session->set_flashdata('strSuccessMsg','Payroll process successfully deleted.');
	// 	redirect('finance/libraries/payrollprocess');
	// }

}
/* End of file Deductions.php
 * Location: ./application/modules/finance/controllers/libraries/Deductions.php */