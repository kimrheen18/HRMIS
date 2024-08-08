<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class LoanBalanceReports extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('Deduction_model'));
        $this->arrData = array();
    }

	public function index()
	{
		$this->arrData['arrLoans'] = $this->Deduction_model->getDeductionsByType('Loan');
		$this->template->load('template/template_view','finance/reports/loan_balance/loan_balance_view',$this->arrData);
	}

}
/* End of file LoanBalanceReports.php
 * Location: ./application/modules/finance/controllers/reports/LoanBalanceReports.php */