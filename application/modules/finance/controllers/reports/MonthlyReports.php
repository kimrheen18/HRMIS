<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class MonthlyReports extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('Payroll_process_model','libraries/Position_model','hr/Hr_model'));
        $this->arrData = array();
    }

	public function index()
	{
		$this->arrData['arrProcess'] = $this->Payroll_process_model->get_payroll_process(currmo(),curryr());
		$this->template->load('template/template_view','finance/reports/monthly_reports/mreports_view',$this->arrData);
	}

	public function payslip()
	{
		$this->load->model('reports/payslip/Payslip');
		$this->Payslip->generate();
	}

	public function remittances()
	{
		$this->load->model('reports/remittances/Remittances');
		$this->Remittances->generate();
	}

	public function all_payslip()
	{
		# get Process
		$process_id = isset($_GET['pprocess']) ? $_GET['pprocess'] : '';
		$process = $this->Payroll_process_model->getData($process_id);

		# get employee
		$employees = $this->Hr_model->getempby_appointment($_GET['appt']);
		
		$emp_income = $this->Payroll_process_model->getemployee_income($process_id);
		$emp_deduct = $this->Payroll_process_model->getemployee_deductionremit($process_id);
		
		foreach($employees as $key => $emp):
			$inc_salary = array();
			$arrincome = array_keys(array_column($emp_income, 'empNumber'), $emp['empNumber']);
			if(!empty($arrincome)):
				foreach($arrincome as $i_key):
					$emp_income[$i_key]['incomeDesc'] = $this->Payroll_process_model->get_incomedesc($emp_income[$i_key]['incomeCode']);
					$employees[$key]['income'][] = $emp_income[$i_key];
					if($emp_income[$i_key]['incomeCode'] == 'SALARY'):
						$inc_salary = $emp_income[$i_key];
					endif;
				endforeach;
			else:
				$employees[$key]['income'][] = array();
			endif;

			$arrincome = array_keys(array_column($emp_deduct, 'empNumber'), $emp['empNumber']);
			if(!empty($arrincome)):
				foreach($arrincome as $d_key):
					$employees[$key]['deduct'][] = $emp_deduct[$d_key];
				endforeach;
			else:
				$employees[$key]['deduct'][] = array();
			endif;
			$employees[$key]['inc_salary'] = $inc_salary;
		endforeach;
		
		$this->load->model('reports/payslip/Payslip');
		$this->Payslip->generate_allemployees(array('employees' => $employees, 'pgroup' => $_GET['pprocess'], 'ps_yr' => $_GET['yr'], 'month' => $_GET['month'], 'period' => $_GET['period']));
	}

	public function payroll_register()
	{
		$this->load->model('reports/payroll_register/Register');
		$this->Register->generate(array('pgroup' => $_GET['pprocess'], 'ps_yr' => $_GET['yr'], 'month' => $_GET['month'], 'period' => $_GET['period']));
	}


}
/* End of file MonthlyReports.php
 * Location: ./application/modules/finance/controllers/reports/MonthlyReports.php */
