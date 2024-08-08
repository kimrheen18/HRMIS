<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requests extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/Request_model'));
    }

	public function cancel_request()
	{
		$arrpost = $this->input->post();
		if(!empty($arrpost)):
			$requestid = $arrpost['txtreqid'];
			$arrData = array('requestStatus' => 'Cancelled', 'statusDate' => date('Y-m-d'));
			$this->Request_model->update_employeeRequest($arrData, $requestid);
			$this->session->set_flashdata('strSuccessMsg','Schedule added successfully.');
			redirect('employee/notification');
		endif;
	}

	

}
