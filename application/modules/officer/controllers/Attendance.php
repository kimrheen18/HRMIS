<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MY_Controller {

	var $arrData;
	
	function __construct() {
        parent::__construct();
        $this->load->model(array('Officer_model','hr/Attendance_summary_model','employee/Leave_model'));
    }

	public function officer_dtr()
	{
		$month = isset($_GET['month']) ? $_GET['month'] : date('m');
		$yr = isset($_GET['yr']) ? $_GET['yr'] : date('Y');

		$head_office = employee_office($_SESSION['sessEmpNo']);
		$employees = $this->Officer_model->get_allemp($head_office);
		$arremp = array();
		foreach($employees as $emp):
			$empdtr = $this->Attendance_summary_model->getemp_dtr($emp['empNumber'], $month, $yr);
			$arremp[] = array('empdetails' => $emp,
							  'absents'	   => $empdtr['date_absents']);
		endforeach;
		$this->arrData['arremployees'] = $arremp;

		$this->template->load('template/template_view','officer/dtr',$this->arrData);
	}

	public function employees_present()
	{
		$head_office = employee_office($_SESSION['sessEmpNo']);
		$employees = $this->Officer_model->get_allemp($head_office);
		$arremp = array();
		foreach($employees as $emp):
			$empdtr = $this->Attendance_summary_model->checkEntry($emp['empNumber'], date('Y-m-d'));
			if(count($empdtr) > 0):
				$arremp[] = array('empdetails' => $emp,
								  'dtr'	   	   => $empdtr);
			endif;
		endforeach;
		$this->arrData['arremployees'] = $arremp;
		
		$this->template->load('template/template_view','officer/dtr_emp_presents',$this->arrData);

	}

	public function employees_absent()
	{
		$head_office = employee_office($_SESSION['sessEmpNo']);
		$employees = $this->Officer_model->get_allemp($head_office);
		$arremp = array();
		foreach($employees as $emp):
			$empdtr = $this->Attendance_summary_model->checkEntry($emp['empNumber'], date('Y-m-d'));
			if(count($empdtr) <= 0):
				$arremp[] = array('empdetails' => $emp,
								  'dtr'	   	   => $empdtr);
			endif;
		endforeach;
		$this->arrData['arremployees'] = $arremp;
		
		$this->template->load('template/template_view','officer/dtr_emp_absents',$this->arrData);

	}

	public function employees_onleave()
	{
		$head_office = employee_office($_SESSION['sessEmpNo']);
		$employees = $this->Officer_model->get_allemp($head_office);
		$leavetypes = $this->Leave_model->getleave_data();
		$arremp = array();
		
		foreach($employees as $emp):
			$onleave = 0;
			foreach($leavetypes as $leave):
				$empdtr = $this->Attendance_summary_model->getleaves($emp['empNumber'],$leave['leaveCode'],date('Y-m-d'));
				$onleave = $onleave + count($empdtr);
			endforeach;
			if($onleave > 0):
				$arremp[] = array('empdetails' => $emp);
			endif;
		endforeach;
		$this->arrData['arremployees'] = $arremp;
		
		$this->template->load('template/template_view','officer/dtr_emp_onleave',$this->arrData);

	}

	public function employees_onottott()
	{
		$head_office = employee_office($_SESSION['sessEmpNo']);
		$employees = $this->Officer_model->get_allemp($head_office);
		$leavetypes = $this->Leave_model->getleave_data();
		$arremp = array();
		$remarks = array();
		foreach($employees as $emp):
			# get ob
			$onob = 0;
			$empdtr = $this->Attendance_summary_model->getobs($emp['empNumber'],date('Y-m-d', strtotime('2018-04-23')));
			$onob = $onob + count($empdtr);
			if($onob > 0):
				array_push($remarks, 'OB');
			endif;

			# get to
			$onto = 0;
			$empdtr = $this->Attendance_summary_model->gettos($emp['empNumber'],date('Y-m-d', strtotime('2018-04-23')));
			$onto = $onto + count($empdtr);

			if($onto > 0):
				array_push($remarks, 'TO');
			endif;

			if(count($remarks) > 0):
				$arremp[] = array('empdetails' => $emp, 'remarks' => $remarks);
			endif;
		endforeach;
		$this->arrData['arremployees'] = $arremp;
		
		$this->template->load('template/template_view','officer/dtr_emp_onobto',$this->arrData);

	}


}


