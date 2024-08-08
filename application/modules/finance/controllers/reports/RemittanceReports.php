<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class RemittanceReports extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('Deduction_model','hr/Hr_model','libraries/Appointment_status_model'));
        $this->arrData = array();
    }

	public function index()
	{
		$this->arrData['arrRemittances'] = $this->Deduction_model->getDeductionsByStatus();
		$this->arrData['arrEmployees'] = $this->Hr_model->getData();
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getAppointmentJointPermanent();
		$this->template->load('template/template_view','finance/reports/remittances/remittance_view',$this->arrData);
	}

}
/* End of file RemittanceReports.php
 * Location: ./application/modules/finance/controllers/reports/RemittanceReports.php */