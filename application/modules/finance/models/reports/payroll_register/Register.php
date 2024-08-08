<?php

/**
 * SystemName: Dost International S&T Linkages Database System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
class Register extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('finance_reports/payslip/Payroll_register_template');
		// $this->load->helper('payroll_helper');
		$this->load->model(array('reports/payroll_register/Payroll_register_model'));
		$this->fpdf = new Payroll_register_template();
	}

	function group_by($key, $data) {
	    $result = array();

	    foreach($data as $val) {
	        if(array_key_exists($key, $val)){
	            $result[$val[$key]][] = $val;
	        }else{
	            $result[""][] = $val;
	        }
	    }

	    return $result;
	}

	function generate($arrData=null)
	{
		$this->fpdf->SetFont('Arial','',9);
		$appt = $_GET['appt'];
		$employees = $this->Payroll_register_model->employee_list($appt);
		$groupby_project = $this->group_by("projectDesc", $employees);
		$border = array(0,0,0,0,0,0,0,0,0,0,0);
		$align = array('C','L','C','L','L','L','L','L','L','L','L');
		foreach($groupby_project as $projectdes => $arrproject):
			$this->fpdf->setproject_code($projectdes);
			$this->fpdf->AddPage('L');
			// echo $projectdes.'<br>';
			$groupby_office = $this->group_by("payrollGroupName", $arrproject);
			foreach($groupby_office as $officename => $arroffice):
				// echo '>>>'.$officename.'<br>';
				foreach($arroffice as $key=>$emp):
					$emp_details = employee_details($emp['empNumber']);
					$emp_details = $emp_details[0];
					$arroffice[$key]['fullname'] = getfullname($emp_details['firstname'],$emp_details['surname'],$emp_details['middlename'],$emp_details['middleInitial'],$emp_details['nameExtension']);
				endforeach;
				
				uasort($arroffice, function($a, $b) {
				    return $a['fullname'] <=> $b['fullname'];
				});
				$widths = array(25,25,45,24,24,24,24,24,24,24,24);
				$this->fpdf->SetWidths($widths);
				foreach($arroffice as $employee):
					$caption = array($employee['empNumber'],$employee['fullname'],$employee['payrollGroupName'],'','','','','','','','');
					$this->fpdf->FancyRow($caption,$border,$align);
				endforeach;

			endforeach;
		endforeach;
		// echo '<table border=1>';
		// foreach($employees as $emp):
		// 	$emp_details = employee_details($emp['empNumber']);
		// 	$emp_details = $emp_details[0];
		// 	$empname = fix_fullname($emp_details['firstname'],$emp_details['surname'],$emp_details['middlename'],$emp_details['middleInitial'],$emp_details['nameExtension']);
		// 	echo '<tr><td>'.$emp['empNumber'].'</td>
		// 			  <td>'.$empname.'</td>
		// 			  <td>'.$emp['payrollGroupName'].'</td>
		// 			  <td>'.$emp['projectDesc'].'</td></tr>';
		// endforeach;
		// echo '</table>';
		// die();
		// // $this->fpdf->SetAutoPageBreak(false);
		// $this->fpdf->setproject_code(22);
		// $this->fpdf->AddPage('L');
		
		// for ($i = 1; $i < 50; $i++) {
		// 	$this->fpdf->cell(0,5,$i.'. DEPARTMENT OF SCIENCE AND TECHNOLOGY',0,1,'L');	
		// }
		
		// $this->fpdf->setproject_code(23);
		// $this->fpdf->AddPage('L');
		
		// for ($c = 1; $c < 50; $c++) {
		// 	$this->fpdf->cell(0,5,$c.'. DEPARTMENT OF SCIENCE AND TECHNOLOGY',0,1,'L');	
		// }
		

		$this->fpdf->Output();
	}


	// payslip header
	// function payslip_header($copy,$empno)
	// {
	// 	$this->fpdf->SetFont('Arial','B',9);
	// 	$this->fpdf->cell(0,5,'DEPARTMENT OF SCIENCE AND TECHNOLOGY',0,1,'L');

	// 	$this->fpdf->SetFont('Arial','i',8);
	// 	$this->fpdf->cell(95,5,office_name(employee_office($empno)),0,0,'L');

	// 	$this->fpdf->SetFont('Arial','',9);
	// 	$this->fpdf->cell(95,5,$copy,0,1,'R');

	// 	$this->fpdf->ln(8);
	// 	$this->fpdf->SetFont('Arial','B',9);
	// 	$this->fpdf->cell(0,5,'EMPLOYEE PAY SLIP',0,1,'C');

	// }

}