<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends MY_Controller {

	var $arrData;
	
	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/Position_model','libraries/Request_model','employee/Notification_model'));
    }

	public function index()
	{
		$officer_empid = $this->session->userdata('sessEmpNo');
		$office = employee_office($officer_empid);
		$emps = $this->Position_model->getemployees_bygroup(3, $office);
		$emps = array_column($emps,'empNumber');
		$requestFlow = $this->Request_model->getRequestFlow($office);

		$allemp_request = array();

		$arremp_request = $this->Request_model->getEmployeeRequest($emps,curryr(),currmo());
		$arrRequest = $this->Notification_model->check_request_flow_and_signatories($requestFlow,$arremp_request);

		foreach($arrRequest as $req):
			if((strpos($req['req_nextsign'],$officer_empid) !== false)):
				$req['req_desti'] = $this->Notification_model->getDestination($req['req_nextsign']);
				$req['req_empname'] = employee_name($req['req_emp']);
				array_push($allemp_request,$req);
			endif;
		endforeach;
		
		$this->arrData['allemp_request'] = $allemp_request;
		$this->template->load('template/template_view', 'officer/tasks', $this->arrData);
	}

	public function task_executive()
	{
		$officer_empid = $this->session->userdata('sessEmpNo');
		$office = employee_office($officer_empid);
		$emps = $this->Position_model->getemployees_bygroup(1, $office);
		$allemp_request = array();
		
		if(count($emps) > 0):
			$exec_office = $emps[0]['group1'];
			$emps = array_column($emps,'empNumber');
			$requestFlow = $this->Request_model->getRequestFlow($exec_office);
			
			$arremp_request = $this->Request_model->getEmployeeRequest($emps,curryr(),currmo());
			$arrRequest = $this->Notification_model->check_request_flow_and_signatories($requestFlow,$arremp_request);

			foreach($arrRequest as $req):
				if((strpos($req['req_nextsign'],$officer_empid) !== false)):
					$req['req_desti'] = $this->Notification_model->getDestination($req['req_nextsign']);
					$req['req_empname'] = employee_name($req['req_emp']);
					array_push($allemp_request,$req);
				endif;
			endforeach;
		endif;
		
		$this->arrData['allemp_request'] = $allemp_request;
		$this->template->load('template/template_view', 'officer/tasks', $this->arrData);

	}

}