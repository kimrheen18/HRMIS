<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProjectCode extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('ProjectCode_model'));
    }

	public function index()
	{
		$this->arrData['projectcodes'] = $this->ProjectCode_model->getData('');
		$this->template->load('template/template_view','finance/libraries/projectcode/projectcode_view',$this->arrData);
	}

	public function add()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'projectCode' => $arrPost['txtcode'],
				'projectDesc' => $arrPost['txtdesc'],
				'projectOrder' => $arrPost['txtorder']
			);
			if(!$this->ProjectCode_model->isCodeExists($arrPost['txtcode'],'add')):
				$this->ProjectCode_model->add($arrData);
				$this->session->set_flashdata('strSuccessMsg','Project Code added successfully.');
				redirect('finance/libraries/projectcode');
			else:
				$this->arrData['err'] = 'Code already exists';
			endif;
		endif;
		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view','finance/libraries/projectcode/projectcode_add',$this->arrData);
	}

	public function edit($id)
	{
		$id = $this->uri->segment(5);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'projectDesc' => $arrPost['txtdesc'],
				'projectOrder' => $arrPost['txtorder']
			);
			$this->ProjectCode_model->edit($arrData, $id);
			$this->session->set_flashdata('strSuccessMsg','Project Code updated successfully.');
			redirect('finance/libraries/projectcode');
		else:
			$this->arrData['action'] = 'edit';
			$this->arrData['data'] = $this->ProjectCode_model->getData($id);
			$this->template->load('template/template_view','finance/libraries/projectcode/projectcode_add',$this->arrData);
		endif;
	}

	public function delete_projectcode()
	{
		$id = $this->uri->segment(5);
		$this->arrData['action'] = 'delete';
		$this->arrData['data'] = $this->ProjectCode_model->getData($id);
		$this->template->load('template/template_view','finance/libraries/projectcode/projectcode_add',$this->arrData);
	}

	public function delete()
	{
		$this->load->model('Check_exists_model');
		$arrget = $this->input->get();
		$id = $this->uri->segment(5);
		if($this->Check_exists_model->check_project_code($arrget['code']) > 0):
			$this->session->set_flashdata('strMsg','Project code is unable to delete. Contact administrator.');
		else:
			$this->ProjectCode_model->delete($id);
			$this->session->set_flashdata('strSuccessMsg','Project code successfully deleted.');
		endif;
		redirect('finance/libraries/projectcode');
	}


}
