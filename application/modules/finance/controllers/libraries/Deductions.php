<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Deductions extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('Deduction_Model'));
    }

	public function index()
	{
		$curr_status = isset($_GET['status']) ? $_GET['status'] : 0;
		$arrstatus = array('all','active','inactive');
		$this->arrData['allstat'] = $arrstatus;
		unset($arrstatus[$curr_status]);
		$this->arrData['arrstatus'] = $arrstatus;

		if($curr_status==1):
			$this->arrData['deductions'] = $this->Deduction_Model->getDeductionsByStatus(1);
		elseif($curr_status==2):
			$this->arrData['deductions'] = $this->Deduction_Model->getDeductionsByStatus(0);
		else:
			$this->arrData['deductions'] = $this->Deduction_Model->getDeductionsByStatus();
		endif;
		$this->arrData['agency'] = $this->Deduction_Model->getDeductionGroup('');
		$this->arrData['curr_status'] = $curr_status;

		$this->template->load('template/template_view','finance/libraries/deductions/deductions_view',$this->arrData);
	}

	public function add()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'deductionCode' => $arrPost['txtddcode'],
				'deductionDesc' => $arrPost['txtdesc'],
				'deductionType' => $arrPost['seltype'],
				'deductionGroupCode' => $arrPost['selAgency'],
				'deductionAccountCode' => $arrPost['txtacctcode'],
				'hidden' => 0
			);
			if(!$this->Deduction_Model->isDeductionCodeExists($arrPost['txtddcode'],'add')):
				$this->Deduction_Model->add($arrData);
				$this->session->set_flashdata('strSuccessMsg','Deduction added successfully.');
				redirect('finance/libraries/deductions');
			else:
				$this->arrData['err'] = 'Code already exists';
			endif;
		endif;
		$this->arrData['action'] = 'add';
		$this->arrData['checkbox'] = 0;
		$this->arrData['agency'] = $this->Deduction_Model->getDeductionGroup('');
		$this->template->load('template/template_view','finance/libraries/deductions/deductions_add',$this->arrData);
	}

	public function add_agency()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'deductionGroupCode' => $arrPost['agency-code'],
				'deductionGroupDesc' => $arrPost['agency-desc'],
				'deductionGroupAccountCode' => $arrPost['acct-code']
			);
			if(!$this->Deduction_Model->isDeductionGroupExists($arrPost['agency-code'],'add')):
				$this->Deduction_Model->addAgency($arrData);
				$this->session->set_flashdata('strSuccessMsg','Agency added successfully.');
				redirect('finance/libraries/deductions?tab=agency');
			else:
				$this->arrData['err'] = 'Code already exists';
			endif;		
		endif;
		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view','finance/libraries/deductions/agency_add',$this->arrData);
	}

	public function edit($id)
	{
		$id = $this->uri->segment(5);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'deductionDesc' => $arrPost['txtdesc'],
				'deductionType' => $arrPost['seltype'],
				'deductionGroupCode' => $arrPost['selAgency'],
				'deductionAccountCode' => $arrPost['txtacctcode'],
				'hidden' => $arrPost['chkisactive'] == 'on' ? 1 : 0
			);
			$this->Deduction_Model->edit($arrData, $id);
			$this->session->set_flashdata('strSuccessMsg','Deduction updated successfully.');
			redirect('finance/libraries/deductions');
		else:
			$this->arrData['action'] = 'edit';
			$this->arrData['data'] = $this->Deduction_Model->getDeductions($id);
			$this->arrData['agency'] = $this->Deduction_Model->getDeductionGroup('');
			$this->template->load('template/template_view','finance/libraries/deductions/deductions_add',$this->arrData);
		endif;
	}

	public function delete_deduction($id)
	{
		$this->arrData['action'] = 'delete';
		$this->arrData['data'] = $this->Deduction_Model->getDeductions($id);
		$this->arrData['agency'] = $this->Deduction_Model->getDeductionGroup('');
		$this->template->load('template/template_view','finance/libraries/deductions/deductions_add',$this->arrData);
	}

	public function delete_agency($id)
	{
		$id = $this->uri->segment(5);
		$this->arrData['action'] = 'delete';
		$this->arrData['arrData'] = $this->Deduction_Model->getDeductionGroup($id);
		$this->template->load('template/template_view','finance/libraries/deductions/agency_add',$this->arrData);
	}

	public function delete()
	{
		$this->load->model('Check_exists_model');
		$arrget = $this->input->get();
		if($arrget['tab'] == 'agency'):
			if($this->Check_exists_model->check_deduction($arrget['code']) > 0):
				$this->session->set_flashdata('strMsg','Agency is unable to delete. Contact administrator.');
			else:
				$this->Deduction_Model->delete(0, $arrget['id']);
			$this->session->set_flashdata('strSuccessMsg','Agency successfully deleted.');
			endif;
			redirect('finance/libraries/deductions?tab=agency');
		else:
			if($this->Check_exists_model->check_deduction($arrget['code']) > 0):
				$this->session->set_flashdata('strMsg','Deduction is unable to delete. Contact administrator.');
			else:
				$this->Deduction_Model->delete(1, $arrget['id']);
				$this->session->set_flashdata('strSuccessMsg','Deduction successfully deleted.');
			endif;
			redirect('finance/libraries/deductions');
		endif;
	}

	public function edit_agency($id)
	{
		$id = $this->uri->segment(5);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'deductionGroupDesc' => $arrPost['agency-desc'],
				'deductionGroupAccountCode' => $arrPost['acct-code']
			);
			if(!$this->Deduction_Model->isDeductionGroupExists($arrPost['agency-code'],'edit')):
				$this->Deduction_Model->edit_agency($arrData, $id);
				$this->session->set_flashdata('strSuccessMsg','Agency updated successfully.');
				redirect('finance/libraries/deductions?tab=agency');
			else:
				$this->arrData['err'] = 'Code already exists';
			endif;
		endif;
		$this->arrData['action'] = 'edit';
		$this->arrData['arrData'] = $this->Deduction_Model->getDeductionGroup($id);
		$this->template->load('template/template_view','finance/libraries/deductions/agency_add',$this->arrData);
	}

	

}
/* End of file Deductions.php
 * Location: ./application/modules/finance/controllers/libraries/Deductions.php */