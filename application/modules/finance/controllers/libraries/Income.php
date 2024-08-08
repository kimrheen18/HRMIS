<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('Income_Model'));
    }

	public function index($status='')
	{
		$this->arrData['income'] = $this->Income_Model->getIncome($status);
		$this->arrData['status'][0] = $status == '' ? array('Show All', '') : ($status == 1 ? array('Show Inactive', 1) : array('Show Active', 0));
		$this->arrData['status'][1] = $status == '' ? array('Show Active', 0) : ($status == 1 ? array('Show Active', 0) : array('Show All', ''));
		$this->arrData['status'][2] = $status == '' ? array('Show Inactive', 1) : ($status == 1 ? array('Show All', '') : array('Show Inactive', 1));
		$this->template->load('template/template_view','finance/libraries/income/income_view',$this->arrData);
	}

	public function add()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'incomeCode' => $arrPost['txtinccode'],
				'incomeDesc' => $arrPost['txtincdesc'],
				'incomeType' => $arrPost['selinctype'],
				'hidden' => 0
			);
			if(!$this->Income_Model->isCodeExists($arrPost['txtinccode'],'add')):
				$this->Income_Model->add($arrData);
				$this->session->set_flashdata('strSuccessMsg','Income added successfully.');
				redirect('finance/libraries/income');
			else:
				$this->arrData['err'] = 'Code already exists';
			endif;
		endif;
		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view','finance/libraries/income/income_add',$this->arrData);
	}

	public function edit($code)
	{
		$code = str_replace('%20', ' ', $code);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'incomeDesc' => $arrPost['txtincdesc'],
				'incomeType' => $arrPost['selinctype'],
				'hidden' => $arrPost['chkisactive'] == 'on' ? 1 : 0
			);
			$this->Income_Model->edit($arrData, $code);
			$this->session->set_flashdata('strSuccessMsg','Income updated successfully.');
			redirect('finance/libraries/income');
		else:
			$this->arrData['action'] = 'edit';
			$this->arrData['arrData'] = $this->Income_Model->getIncomeData($code);
			$this->template->load('template/template_view','finance/libraries/income/income_add',$this->arrData);
		endif;
	}
	
	public function delete_income($code)
	{
		$id = $this->uri->segment(5);
		$this->arrData['action'] = 'delete';
		$this->arrData['arrData'] = $this->Income_Model->getIncomeById($id);
		$this->template->load('template/template_view','finance/libraries/income/income_add',$this->arrData);
	}

	public function delete()
	{
		$this->load->model('Check_exists_model');
		$arrget = $this->input->get();
		$id = $this->uri->segment(5);
		if($this->Check_exists_model->check_income($arrget['code']) > 0):
			$this->session->set_flashdata('strMsg','Income is unable to delete. Contact administrator.');
		else:
			$this->Income_Model->delete($id);
			$this->session->set_flashdata('strSuccessMsg','Income successfully deleted.');
		endif;
		
		redirect('finance/libraries/income');
	}

}
