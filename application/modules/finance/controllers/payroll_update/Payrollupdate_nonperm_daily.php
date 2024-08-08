<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Payrollupdate_nonperm_daily extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('Payrollupdate_model','Deduction_model','libraries/Appointment_status_model','pds/Pds_model','Payroll_process_model','hr/Attendance_summary_model','employee/Leave_model','finance/Income_model','finance/Benefit_model','hr/Hr_model','Computation_instance_model'));
        $this->load->helper('payroll_helper');
        $this->arrData = array();
    }

	public function select_benefits_nonperm_trc()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost)):
			redirect('finance/payroll_update/process');
		endif;

		$this->arrData['arrBenefit'] = $this->Payrollupdate_model->payroll_select_income_process($arrPost['mon'],$arrPost['yr'],$arrPost['selemployment'],'Benefit',$arrPost['period']);
		$this->arrData['arrBonus'] = $this->Payrollupdate_model->payroll_select_income_process($arrPost['mon'],$arrPost['yr'],$arrPost['selemployment'],'Bonus',$arrPost['period']);
		$this->arrData['arrIncome'] = $this->Payrollupdate_model->payroll_select_income_process($arrPost['mon'],$arrPost['yr'],$arrPost['selemployment'],'Others',$arrPost['period']);
		// $this->arrData['salary'] = $this->Payrollupdate_model->check_salary_exist($arrPost['mon'],$arrPost['yr'],$arrPost['selemployment']);
		$this->arrData['process'] = $this->Payroll_process_model->get_process_by_appointment($arrPost['selemployment'],$arrPost['mon'],$arrPost['yr'],$arrPost['period']);
		$this->arrData['arrLoan'] = $this->Deduction_model->getDeductionsByType('Loan');
		$this->arrData['arrContrib'] = $this->Deduction_model->getDeductionsByType('Contribution');
		$this->arrData['arrOthers'] = $this->Deduction_model->getDeductionsByType('Others');

		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function compute_benefits_nonperm_trc()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			if(isset($arrPost['chkbenefit'])):
				if(gettype($arrPost['chkbenefit']) == 'string'):
					$arrPost['chkbenefit'] = json_decode($arrPost['chkbenefit'],true);
				endif;
			endif;
			if(isset($arrPost['txtprocess'])):
				$process_data = json_decode($arrPost['txtprocess'],true);
			else:
				$process_data = $arrPost;
			endif;
		else:
			redirect('finance/payroll_update/process');
		endif;

		$computed_benefits = $this->Payrollupdate_model->compute_benefits($arrPost, $process_data);

		$this->arrData = array( 'employment_type'	 => $process_data['selemployment'],
								'payroll_date'		 => date('F Y',strtotime($process_data['yr'].'-'.$process_data['mon'].'-1')),
								'process_data_date'	 => date('F Y',strtotime($process_data['data_fr_yr'].'-'.$process_data['data_fr_mon'].'-1')),
								'process_data_workingdays' => $computed_benefits['workingdays'],
								'curr_period_workingdays'  => $computed_benefits['curr_workingdays'],
								'arrEmployees'		 => $computed_benefits['arremployees'],
								'no_empty_lb'		 => $computed_benefits['no_empty_lb'],
								'period'		 	 => $process_data['period'],
								'process_data_datediff'=> $computed_benefits['process_data_datediff']);

		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function select_deduction_nonperm_trc()
	{
		$arrPost = $this->input->post();
		$arrEmployees = array();
		if(!empty($arrPost)):
			if(gettype($arrPost['chkbenefit']) == 'string'):
				$arrPost['chkbenefit'] = json_decode($arrPost['chkbenefit'],true);
			endif;
		endif;

		$this->arrData['arrEmployees'] = $arrPost['txtjson_computations'];
		$this->arrData['arrLoan'] = $this->Deduction_model->getDeductionsByType('Loan');
		$this->arrData['arrContrib'] = $this->Deduction_model->getDeductionsByType('Contribution');
		$this->arrData['arrOthers'] = $this->Deduction_model->getDeductionsByType('Others');

		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function save_computation_nonperm_trc()
	{
		$arrPost = $this->input->post();
		
		$process_data = fixArray($arrPost['txtprocess'],true);
		$arrEmployees = fixArray($arrPost['txtjson_computations'],true);
		$salary_period = 'period'.$process_data['period'];
		$loans = isset($arrPost['chkloan']) ? fixArray($arrPost['chkloan']) : array();

		# insert tablename: tblNonPermComputationInstance
		$arrData_comp_instance = array('startDate'		  => $process_data['txt_dtfrom'],
									   'endDate' 		  => $process_data['txt_dtto'],
									   'appointmentCode'  => $process_data['selemployment'],
									   'pmonth' 		  => $process_data['mon'],
									   'pyear' 			  => $process_data['yr'],
									   'period' 		  => $process_data['period']
									   /*'payrollGroupCode' => $process_data['txt_dtto']*/);
		$comp_instance_id = $this->Computation_instance_model->insert_nonpem_computation_instance($arrData_comp_instance);
		$oth_periods = array();

		for($i=1;$i<=4;$i++){ if($process_data['period'] != $i){array_push($oth_periods,'period'.$i);}}
		
		foreach($arrEmployees as $emp_comp):
			$tardy_mins = $emp_comp['total_late'] + $emp_comp['total_ut'];
			$tardy = explode(':', date('H:i', mktime(0, $tardy_mins)));
			# insert tablename: tblNonPermComputation
			if(strtolower($process_data['txtcomputation']) == 'daily'){
				$salary_days = $arrPost['date_diff'];
			}else{
				$salary_days = SALARY_DAYS;
			}
			$sal_perday =  $emp_comp['emp_detail']['actualSalary'] / $salary_days;
			echo '<br>$sal_perday = '.$sal_perday;
			$sal_perhr = $sal_perday / 8;
			$sal_permins = $sal_perhr / 60;

			$arrData_comp_instance = array('fk_id'		  	  => $comp_instance_id,
										   'empNumber' 		  => $emp_comp['emp_detail']['empNumber'],
										   'salary' 		  => $emp_comp['emp_detail']['actualSalary'] / 2,
										   'basicSalary' 	  => $emp_comp['emp_detail']['actualSalary'],
										   'nodays_absent' 	  => $emp_comp['actual_days_absent'],
										   'nodays_present'   => $emp_comp['actual_days_present'],
										   'totalTardyHour'   => $tardy[0],
										   'totalTardyMinute' => $tardy[1],
										   'no_workingdays'   => $process_data['selemployment'],
										   'lateamount' 	  => round($tardy_mins * $sal_permins,2),
										   'dayabsentamount'  => round($emp_comp['actual_days_absent'] * $sal_perday,2),
										   'tardyhouramount'  => round($tardy[0] * $sal_perhr,2),
										   'tardyminuteamount'=> round($tardy[1] * $sal_permins,2));
			$this->Computation_instance_model->insert_nonperm_computation($arrData_comp_instance);

			# check for Philhealth and Pagibig deductions
			$emp_deductions = $this->Deduction_model->get_employee_deductions($emp_comp['emp_detail']['empNumber'],array('PAGIBIG','PHILHEALTH'));
			$total_deductions = 0;
			foreach($emp_deductions as $emp_deduct):
				$total_deductions = $total_deductions + $emp_deduct[$salary_period];
			endforeach;
			$total_period_salary = ($emp_comp['emp_detail']['actualSalary'] / 2) - $total_deductions - round($tardy_mins * $sal_permins,2);

			# check employee tax switch and get tax amount
			if($emp_comp['emp_detail']['taxSwitch'] == 'Y'):
				$tax_amount = ($total_period_salary - $total_deductions) * TAX_PERCENT;
			else:
				$tax_amount = amt_tax_nonperm($total_period_salary - $total_deductions);
			endif;

			# get income tax and update
			$emp_income_tax = $this->Deduction_model->get_employee_deductions($emp_comp['emp_detail']['empNumber'],array('ITW'));
			if(count($emp_income_tax) > 0):
				# update tblEmpDeductions
				$arrData_emp_deductions = array($salary_period => round($tax_amount,2));
				$this->Deduction_model->edit_empdeduction_byempnumber($arrData_emp_deductions,'ITW',$emp_comp['emp_detail']['empNumber']);
			else:
				# insert tblEmpDeductions
				$arrData_emp_deductions = array('empNumber' 	=> $emp_comp['emp_detail']['empNumber'],
											    'deductionCode' => 'ITW',
											    'monthly' 		=> '0',
											    $salary_period  => ROUND($taxamount,2),
											    'status' 		=> '1');
				$this->Deduction_model->add_emp_deductions($arrData_emp_deductions);
			endif;

			# fetch empbenefits; tablename: tblEmpBenefits
			$emp_benefits = $this->Income_model->get_employee_income($emp_comp['emp_detail']['empNumber'],array('DIF'));
			if(count($emp_benefits) > 0):
				$arrData_emp_benefits = array('empNumber' 		=> $emp_comp['emp_detail']['empNumber'],
											  'incomeCode' 		=> 'DIF',
											  'incomeYear' 		=> $process_data['yr'],
											  'incomeMonth' 	=> $process_data['mon'],
											  'actualSalary' 	=> $emp_comp['emp_detail']['actualSalary'],
											  'positionCode' 	=> $emp_comp['emp_detail']['positionCode'],
											  'officeCode' 		=> $emp_comp['emp_detail']['officeCode'],
											  'incomeAmount' 	=> $emp_benefits[0]['incomeAmount'],
											  'appointmentCode' => $emp_comp['emp_detail']['appointmentCode'],
											  $salary_period  	=> ($emp_comp['emp_detail']['actualSalary'] / 2));
				$this->Income_model->add_emp_income($arrData_emp_benefits);
			endif;

		endforeach;

		# SAVE
		$this->Computation_instance_model->update_nonpem_computation_instance(array('status' => 0),$process_data['selemployment'],$process_data['mon'],$process_data['yr'],$process_data['period']);
		$this->Computation_instance_model->update_nonpem_computation_instance(array('status' => 0),$process_data['selemployment'],$process_data['mon'],$process_data['yr'],$process_data['period']);
		
		foreach($arrEmployees as $emp_comp):
			$emp_benefits_salary = $this->Benefit_model->getBenefits($emp_comp['emp_detail']['empNumber'],'SALARY');
			if(count($emp_benefits_salary) > 0):
				$arrbenefit_salary = array('period1' => $process_data['period'] == 1 ? $emp_comp['emp_detail']['actualSalary'] : 0,
										   'period2' => $process_data['period'] == 2 ? $emp_comp['emp_detail']['actualSalary'] : 0,
										   'period3' => $process_data['period'] == 3 ? $emp_comp['emp_detail']['actualSalary'] : 0,
										   'period4' => $process_data['period'] == 4 ? $emp_comp['emp_detail']['actualSalary'] : 0);
				$this->Benefit_model->update_benefits($arrbenefit_salary,$emp_comp['emp_detail']['empNumber'],'SALARY');
			else:
				$arrbenefit_salary = array('empNumber' 		=> $emp_comp['emp_detail']['empNumber'],
										   'incomeCode' 	=> 'SALARY',
										   'incomeAmount'	=> $emp_comp['emp_detail']['actualSalary'],
										   'status' 		=> 1,
										   $salary_period	=> $emp_comp['emp_detail']['actualSalary'] / 2);
				$this->Benefit_model->add($arrbenefit_salary);
			endif;

			# insert late and absents; tablename: tblEmpDeductions
			$emp_deductions_tardy = $this->Deduction_model->get_employee_deductions($emp_comp['emp_detail']['empNumber'],array('UNDABS'));
			if(count($emp_deductions_tardy) > 0):
				# update deductions
				$arrData_emp_tardy = array('period1' => $process_data['period'] == 1 ? round($tardy_mins * $sal_permins,2) : 0,
										   'period2' => $process_data['period'] == 2 ? round($tardy_mins * $sal_permins,2) : 0,
										   'period3' => $process_data['period'] == 3 ? round($tardy_mins * $sal_permins,2) : 0,
										   'period4' => $process_data['period'] == 4 ? round($tardy_mins * $sal_permins,2) : 0);
				$this->Deduction_model->edit_empdeduction_byempnumber($arrData_emp_tardy,'UNDABS',$emp_comp['emp_detail']['empNumber']);
			else:
				# insert deductions
				$arrData_emp_tardy = array('empNumber' 	   => $emp_comp['emp_detail']['empNumber'],
										   'deductionCode' => 'UNDABS',
										   $salary_period  => round($tardy_mins * $sal_permins,2),
										   'status'		   => 1);
				$this->Deduction_model->add_emp_deductions($arrData_emp_tardy);
			endif;
		endforeach;

		## PROCESS
		$arrPost = $this->input->post();
		$arrComputations = isset($arrPost['txtjson_computations']) ? fixArray($arrPost['txtjson_computations']) : array();
		$process_data = isset($arrPost['txtprocess']) ? fixArray($arrPost['txtprocess']) : array();
		$arrEmployees = isset($arrPost['txtjson']) ? fixArray($arrPost['txtjson']) : array();
		$benefits = isset($arrPost['chkbenefit']) ? fixArray($arrPost['chkbenefit']) : array();
		$bonus = isset($arrPost['chkbonus']) ? fixArray($arrPost['chkbonus']) : array();
		$income = isset($arrPost['chkincome']) ? fixArray($arrPost['chkincome']) : array();
		$others = isset($arrPost['chkothrs']) ? fixArray($arrPost['chkothrs']) : array();
		$loans = isset($arrPost['chkloan']) ? fixArray($arrPost['chkloan']) : array();
		$contri = isset($arrPost['chkcont']) ? fixArray($arrPost['chkcont']) : array();
		$process_exist = $this->Payroll_process_model->get_payroll_process($process_data['mon'],$process_data['yr'],$process_data['selemployment']);

		$process_code = array();
		if(isset($arrPost['chksalary'])):
			if($arrPost['chksalary'] != '') { array_push($process_code,'SALARY'); }
		endif;
		if(isset($arrPost['chkbenefit'])):
			if($arrPost['chkbenefit'] != ''):
				# check if salary exists in process
				if(in_array('SALARY',array_column($process_exist,'processCode'))):
					array_push($process_code,'BENEFITS');
				endif;
			endif;
		endif;
		if(isset($arrPost['chkbonus'])):
			if($arrPost['chkbonus'] != '') { array_push($process_code,'BONUS'); }
		endif;
		if(isset($arrPost['chkincome'])):
			if($arrPost['chkincome'] != '') { array_push($process_code,'ADDITIONAL'); }
		endif;

		# insert tblprocess
		$agency_info = $this->Deduction_model->getAgencyDeductionShare();
		$period = $process_data['selemployment'] == 'P' ? 4 : $process_data['period'];
		$arrProcess_id = array();
		foreach($process_code as $pcode):
			$arrData_process = array('employeeAppoint' => $process_data['selemployment'],
									 'empNumber' 	   => $this->session->userdata('sessEmpNo'),
									 'processDate'	   => date('Y-m-d'),
									 'processMonth'    => $process_data['mon'],
									 'processYear'     => $process_data['yr'],
									 'processCode'     => $pcode,
									 // 'payrollGroupCode'=> '',
									 'salarySchedule'  => $agency_info['salarySchedule'],
									 'period' 		   => $period,
									 'publish' 		   => 0);
			$proc_id = $this->Payroll_process_model->add_payroll_process($arrData_process);
			$arrProcess_id[] = array('proc_id' => $proc_id, 'code' => $pcode);
		endforeach;
		
		foreach($arrEmployees as $emp):
			# foreach payroll process
			foreach($arrProcess_id as $processid):
				# Process Others
				# chkothers
				# INSERT INTO tblEmpIncome (processID, empNumber, incomeCode, incomeYear, incomeMonth,actualSalary, incomeAmount, appointmentCode, positionCode,officeCode, period1, period2, period3, period4)
				# get bonus from tblEmpBenefits
				$emp_addtl = $this->Income_model->get_employee_income($emp['emp_detail']['empNumber'],fixArray($income),'Others');
				foreach($emp_addtl as $emp_addtl):
					$arrData_emp_addtl = array('processID' 	 => $processid['proc_id'],
												'empNumber' 	 => $emp['emp_detail']['empNumber'],
												'incomeCode'   => $emp_addtl['incomeCode'],
												'incomeYear'   => $process_data['yr'],
												'incomeMonth'  => $process_data['mon'],
												'actualSalary' => $emp['emp_detail']['actualSalary'],
												'positionCode' => $emp['emp_detail']['positionCode'],
												'officeCode' 	 => $emp['emp_detail']['officeCode'],
												'incomeAmount' => $emp_addtl['incomeAmount'] == '' ? 0 : $emp_addtl['incomeAmount'],
												'appointmentCode'=> $emp['emp_detail']['appointmentCode'],
												'period1' 	 => $emp_addtl['period1'],
												'period2' 	 => $emp_addtl['period2'],
												'period3' 	 => $emp_addtl['period3'],
												'period4' 	 => $emp_addtl['period4']);
					$this->Income_model->add_emp_income($arrData_emp_addtl);
				endforeach;
					
				# Process Bonus
				# chkbonus
				# INSERT INTO tblEmpIncome (processID, empNumber, incomeCode, incomeYear, incomeMonth, actualSalary, incomeAmount, app
				# get bonus from tblEmpBenefits
				$emp_bonus = $this->Income_model->get_employee_income($emp['emp_detail']['empNumber'],fixArray($income),'Bonus');
				foreach($emp_bonus as $emp_bonus):
					$arrData_empbonus = array('processID' 	 => $processid['proc_id'],
											  'empNumber' 	 => $emp['emp_detail']['empNumber'],
											  'incomeCode' 	 => $emp_bonus['incomeCode'],
											  'incomeYear' 	 => $process_data['yr'],
											  'incomeMonth'  => $process_data['mon'],
											  'actualSalary' => $emp['emp_detail']['actualSalary'],
											  'positionCode' => $emp['emp_detail']['positionCode'],
											  'officeCode' 	 => $emp['emp_detail']['officeCode'],
											  'incomeAmount' => $emp_bonus['incomeAmount'] == '' ? 0 : $emp_bonus['incomeAmount'],
											  'appointmentCode'=> $emp['emp_detail']['appointmentCode'],
											  'period1' 	 => $emp_bonus['period1'],
											  'period2' 	 => $emp_bonus['period2'],
											  'period3' 	 => $emp_bonus['period3'],
											  'period4' 	 => $emp_bonus['period4']);
					$this->Income_model->add_emp_income($arrData_empbonus);
					
					# INSERT INTO tblEmpDeductionRemit (processID, code, empNumber, deductionCode, deductAmount, period1, period2, period3, 
					$arrData_others = array('processID'	 => $processid['proc_id'],
										  'code'		 => 0,
										  'empNumber'	 => $emp['emp_detail']['empNumber'],
										  'deductionCode'=> $emp_bonus['incomeCode'].'TAX',
										  'deductAmount' => $emp_bonus['ITW'],
										  'period1'		 => $emp_bonus['ITW'],
										  'period2'		 => 0,
										  'period3'		 => 0,
										  'period4'		 => 0,
										  'deductMonth'	 => $process_data['mon'],
										  'deductYear'	 => $process_data['yr'],
										  'employerAmount'	=> 0);
					$this->Deduction_model->add_deduction_remit($arrData_others);
				endforeach;
				
				# Process Deductions
				# deduction - Loan
				# INSERT INTO tblEmpDeductionRemit
				$empLoans = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],$loans,'Loan');
				foreach($empLoans as $loan):
					$arrData_loan = array('processID'	 => $processid['proc_id'],
										  'code'		 => $loan['deductCode'],
										  'empNumber'	 => $emp['emp_detail']['empNumber'],
										  'deductionCode'=> $loan['deductionCode'],
										  'deductAmount' => $loan['amountGranted'],
										  'period1'		 => $loan['period1'],
										  'period2'		 => $loan['period2'],
										  'period3'		 => $loan['period3'],
										  'period4'		 => $loan['period4'],
										  'deductMonth'	 => $process_data['mon'],
										  'deductYear'	 => $process_data['yr'],
										  'appointmentCode'	=> $emp['emp_detail']['appointmentCode']);
					$this->Deduction_model->add_deduction_remit($arrData_loan);
				endforeach;

				# Income - Benefit
				# INSERT INTO tblEmpIncome
				$emp_benefit = $this->Income_model->get_employee_income($emp['emp_detail']['empNumber'],fixArray($benefits),'Benefit');
				# insert income; tablename : tblempincome
				foreach($emp_benefit as $emp_benefit):
					$allperiods = array($emp_benefit['period1'],$emp_benefit['period2'],$emp_benefit['period3'],$emp_benefit['period4']);
					if(count(array_unique($allperiods)) === 1 && end($allperiods) === 0.00):
						$arrData_empbenefit = array('processID' 	 => $processid['proc_id'],
												    'empNumber' 	 => $emp['emp_detail']['empNumber'],
												    'incomeCode' 	 => $emp_benefit['incomeCode'],
												    'incomeYear' 	 => $process_data['yr'],
												    'incomeMonth' 	 => $process_data['mon'],
												    'actualSalary' 	 => $emp['emp_detail']['actualSalary'],
												    'positionCode' 	 => $emp['emp_detail']['positionCode'],
												    'officeCode' 	 => $emp['emp_detail']['officeCode'],
												    'incomeAmount' 	 => $emp_benefit['incomeAmount'] == '' ? 0 : $emp_benefit['incomeAmount'],
												    'appointmentCode'=> $emp['emp_detail']['appointmentCode'],
												    'period1' 		 => $emp_benefit['period1'],
												    'period2' 		 => $emp_benefit['period2'],
												    'period3' 		 => $emp_benefit['period3'],
												    'period4' 		 => $emp_benefit['period4']);
						$this->Income_model->add_emp_income($arrData_empbenefit);
					endif;
				endforeach;

				# LONGI
				# INSERT INTO tblEmpDeductionRemit
				if(count($benefits) > 0):
					if(in_array('LONGI',$benefits)):
						$lp_tax = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],array('LPTAX'),'Regular');
						if(count($lp_tax) > 0):
							$arrData_lptax = array('processID'	 => $processid['proc_id'],
												  'code'		 => $lp_tax[0]['deductCode'],
												  'empNumber'	 => $emp['emp_detail']['empNumber'],
												  'deductionCode'=> $lp_tax[0]['deductionCode'],
												  'deductAmount' => $lp_tax[0]['amountGranted'],
												  'period1'		 => $lp_tax[0]['period1'],
												  'period2'		 => $lp_tax[0]['period2'],
												  'period3'		 => $lp_tax[0]['period3'],
												  'period4'		 => $lp_tax[0]['period4'],
												  'deductMonth'	 => $process_data['mon'],
												  'deductYear'	 => $process_data['yr'],
												  'appointmentCode'	=> $emp['emp_detail']['appointmentCode']);
							$this->Deduction_model->add_deduction_remit($arrData_lptax);
						endif;
					endif;

					# HAZARD
					# INSERT INTO tblEmpDeductionRemit
					if(in_array('HAZARD',$benefits)):
						$hp_tax = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],array('HPTAX'),'Regular');
						if(count($hp_tax) > 0):
							$arrData_hptax = array('processID'	 => $processid['proc_id'],
												  'code'		 => $hp_tax[0]['deductCode'],
												  'empNumber'	 => $emp['emp_detail']['empNumber'],
												  'deductionCode'=> $hp_tax[0]['deductionCode'],
												  'deductAmount' => $hp_tax[0]['amountGranted'],
												  'period1'		 => $hp_tax[0]['period1'],
												  'period2'		 => $hp_tax[0]['period2'],
												  'period3'		 => $hp_tax[0]['period3'],
												  'period4'		 => $hp_tax[0]['period4'],
												  'deductMonth'	 => $process_data['mon'],
												  'deductYear'	 => $process_data['yr'],
												  'appointmentCode'	=> $emp['emp_detail']['appointmentCode']);
							$this->Deduction_model->add_deduction_remit($arrData_hptax);
						endif;
					endif;
				endif;

				$income_salary = array();
				# if salary
				if($arrPost['chksalary'] == 'psalary'):
					# INSERT INTO tblEmpIncome
					# get salary from tblEmpBenefits
					$emp_income = $this->Income_model->get_employee_income($emp['emp_detail']['empNumber'],array('SALARY'));
					# insert income; tablename : tblempincome
					$arrData_empincome = array('processID' 		 => $processid['proc_id'],
											   'empNumber' 		 => $emp['emp_detail']['empNumber'],
											   'incomeCode' 	 => $processid['code'],
											   'incomeYear' 	 => $process_data['yr'],
											   'incomeMonth' 	 => $process_data['mon'],
											   'actualSalary' 	 => $emp['emp_detail']['actualSalary'],
											   'positionCode' 	 => $emp['emp_detail']['positionCode'],
											   'officeCode' 	 => $emp['emp_detail']['officeCode'],
											   'incomeAmount' 	 => $emp_income[0]['incomeAmount'] == '' ? 0 : $emp_income[0]['incomeAmount'],
											   'appointmentCode' => $emp['emp_detail']['appointmentCode'],
											   'period1' 		 => $process_data['period'] == 1 ? $emp['emp_detail']['actualSalary'] / 2 : 0,
											   'period2' 		 => $process_data['period'] == 2 ? $emp['emp_detail']['actualSalary'] / 2 : 0,
											   'period3' 		 => $process_data['period'] == 3 ? $emp['emp_detail']['actualSalary'] / 2 : 0,
											   'period4' 		 => $process_data['period'] == 4 ? $emp['emp_detail']['actualSalary'] / 2 : 0);
					
					$this->Income_model->add_emp_income($arrData_empincome);
					
					$income_salary['period1'] = $emp_income[0]['period1'];
					$income_salary['period2'] = $emp_income[0]['period2'];
					$income_salary['period3'] = $emp_income[0]['period3'];
					$income_salary['period4'] = $emp_income[0]['period4'];
				endif;
				# endif

				# deduction - OT
				# INSERT INTO tblEmpDeductionRemit
				if(count($benefits) > 0):
					if(in_array('OT',$benefits) && $arrPost['chksalary'] != 'psalary'):
						$ot = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],array(),'ot');
						if(count($ot) > 0):
							$arrData_ot = array('processID'	 => $processid['proc_id'],
												  'code'		 => $ot[0]['deductCode'],
												  'empNumber'	 => $emp['emp_detail']['empNumber'],
												  'deductionCode'=> $ot[0]['deductionCode'],
												  'deductAmount' => $ot[0]['amountGranted'],
												  'period1'		 => $ot[0]['period1'],
												  'period2'		 => $ot[0]['period2'],
												  'period3'		 => $ot[0]['period3'],
												  'period4'		 => $ot[0]['period4'],
												  'deductMonth'	 => $process_data['mon'],
												  'deductYear'	 => $process_data['yr'],
												  'appointmentCode'	=> $emp['emp_detail']['appointmentCode']);
							$this->Deduction_model->add_deduction_remit($arrData_ot);
						endif;
					endif;
				endif;

				# deduction - Others
				# INSERT INTO tblEmpDeductionRemit
				if(isset($arrPost['chkothrs'])):
					$others_deductions = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],fixArray($arrPost['chkothrs']),'Others');
					foreach($others_deductions as $oth_d):
						$arrData_others = array('processID'	 => $processid['proc_id'],
											  'code'		 => $oth_d['deductCode'],
											  'empNumber'	 => $emp['emp_detail']['empNumber'],
											  'deductionCode'=> $oth_d['deductionCode'],
											  'deductAmount' => $oth_d['amountGranted'],
											  'period1'		 => $oth_d['period1'],
											  'period2'		 => $oth_d['period2'],
											  'period3'		 => $oth_d['period3'],
											  'period4'		 => $oth_d['period4'],
											  'deductMonth'	 => $process_data['mon'],
											  'deductYear'	 => $process_data['yr'],
											  'appointmentCode'	=> $emp['emp_detail']['appointmentCode']);
						$this->Deduction_model->add_deduction_remit($arrData_others);
					endforeach;
				endif;

				# deduction - Contributions (contri)
				# INSERT INTO tblEmpDeductionRemit
				$check_deductions = $this->Deduction_model->check_empdeductions($process_data['mon'],$process_data['yr'],$emp['emp_detail']['appointmentCode']);
				if(count($check_deductions) > 0):
					$contri_deductions = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],fixArray($contri),'Contribution');
					foreach($contri_deductions as $contri):
						$arrData_others = array('processID'	 => $processid['proc_id'],
											  'code'		 => $contri['deductCode'],
											  'empNumber'	 => $emp['emp_detail']['empNumber'],
											  'deductionCode'=> $contri['deductionCode'],
											  'deductAmount' => $contri['amountGranted'],
											  'period1'		 => $contri['period1'],
											  'period2'		 => $contri['period2'],
											  'period3'		 => $contri['period3'],
											  'period4'		 => $contri['period4'],
											  'deductMonth'	 => $process_data['mon'],
											  'deductYear'	 => $process_data['yr'],
											  'appointmentCode'	=> $emp['emp_detail']['appointmentCode']);
						$this->Deduction_model->add_deduction_remit($arrData_others);
					endforeach;
				endif;

				# if salary
				if($arrPost['chksalary'] == 'psalary'):
					# UPDATE ALL MATURED LOANS
					$this->Deduction_model->update_loan($process_data['mon'],$process_data['yr']);
					# Insert PAG-IBIG Deductions
					$pagibig_deduction = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],array('PAGIBIG'),'');
					foreach($pagibig_deduction as $pagibig):
						$arrData_pagibig = array('processID'	 => $processid['proc_id'],
												 'code'			 => $pagibig['deductCode'],
												 'empNumber'	 => $emp['emp_detail']['empNumber'],
												 'deductionCode' => $pagibig['deductionCode'],
												 'deductAmount'	 => $pagibig['amountGranted'],
												 'period1'		 => $pagibig['period1'],
												 'period2'		 => $pagibig['period2'],
												 'period3'		 => $pagibig['period3'],
												 'period4'		 => $pagibig['period4'],
												 'deductMonth'	 => $process_data['mon'],
												 'deductYear'	 => $process_data['yr'],
												 'employerAmount' => $agency_info['pagibigEmprShare'],
												 'appointmentCode'=> $emp['emp_detail']['appointmentCode']);
						$this->Deduction_model->add_deduction_remit($arrData_pagibig);
					endforeach;

					# PHILHEALTH
					$phrange = $this->Deduction_model->getPhilHealthRange($emp['emp_detail']['actualSalary']);
					$ph_employer_amt = ($agency_info['philhealthEmprShare'] / 100) * $phrange['philMonthlyContri'];
					$ph_deduction = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],array('PHILHEALTH'),'');
					foreach($ph_deduction as $ph):
						$arrData_pagibig = array('processID'	 => $processid['proc_id'],
												 'code'			 => $ph['deductCode'],
												 'empNumber'	 => $emp['emp_detail']['empNumber'],
												 'deductionCode' => $ph['deductionCode'],
												 'deductAmount'	 => $ph['amountGranted'],
												 'period1'		 => $ph['period1'],
												 'period2'		 => $ph['period2'],
												 'period3'		 => $ph['period3'],
												 'period4'		 => $ph['period4'],
												 'deductMonth'	 => $process_data['mon'],
												 'deductYear'	 => $process_data['yr'],
												 'employerAmount' => $ph_employer_amt,
												 'appointmentCode'=> $emp['emp_detail']['appointmentCode']);
						$this->Deduction_model->add_deduction_remit($arrData_pagibig);
					endforeach;

					# GSIS
					$gsis_employer_amt = ($agency_info['philhealthEmprShare'] / 100) * $emp['emp_detail']['actualSalary'];
					$gsis_deduction = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],array('LIFE'),'');
					foreach($gsis_deduction as $gsis):
						$arrData_gsis = array('processID'	 	  => $processid['proc_id'],
												 'code'			  => $gsis['deductCode'],
												 'empNumber'	  => $emp['emp_detail']['empNumber'],
												 'deductionCode'  => $gsis['deductionCode'],
												 'deductAmount'	  => $gsis['amountGranted'],
												 'period1'		  => $gsis['period1'],
												 'period2'		  => $gsis['period2'],
												 'period3'		  => $gsis['period3'],
												 'period4'		  => $gsis['period4'],
												 'deductMonth'	  => $process_data['mon'],
												 'deductYear'	  => $process_data['yr'],
												 'employerAmount' => $gsis_employer_amt,
												 'appointmentCode'=> $emp['emp_detail']['appointmentCode']);
						$this->Deduction_model->add_deduction_remit($arrData_gsis);
					endforeach;

					# Regular
					$regular_deduction = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],array(),'ot');
					foreach($regular_deduction as $reg):
						$arrData_reg = array('processID'	 	 => $processid['proc_id'],
												 'code'			 => $reg['deductCode'],
												 'empNumber'	 => $emp['emp_detail']['empNumber'],
												 'deductionCode' => $reg['deductionCode'],
												 'deductAmount'	 => $reg['amountGranted'],
												 'period1'		 => $reg['period1'],
												 'period2'		 => $reg['period2'],
												 'period3'		 => $reg['period3'],
												 'period4'		 => $reg['period4'],
												 'deductMonth'	 => $process_data['mon'],
												 'deductYear'	 => $process_data['yr'],
												 'employerAmount' => $gsis_employer_amt,
												 'appointmentCode'=> $emp['emp_detail']['appointmentCode']);
						$this->Deduction_model->add_deduction_remit($arrData_reg);
					endforeach;
				endif;
				# endif

				# Processed Employees
				$period_amount = 0;
				$payroll_process = $this->Payroll_process_model->process_with($process_data['selemployment']);
				switch ($payroll_process['computation']):
					case 'Monthly':
						$period_amount = $income_salary['period1'];
						$netPayPeriod1 = $period_amount;
						$netPayPeriod2 = $period_amount;
						break;
					case 'Semimonthly':
					case 'Bi-Monthly':
						$period_amount = $process_data['period'] == 1 ? $income_salary['period1'] : $income_salary['period2'];
						$netPayPeriod1 = $process_data['period'] == 1 ? $income_salary['period1'] : 0;
						$netPayPeriod2 = $process_data['period'] == 1 ? 0 : $income_salary['period2'];
						break;
					case 'Weekly':
					case 'Daily':
						$period_amount = $process_data['period'] == 1 ? ($income_salary['period1'] + $income_salary['period2']) : ($income_salary['period3'] + $income_salary['period4']);
						$netPayPeriod1 = $process_data['period'] == 1 ? ($income_salary['period1'] + $income_salary['period2']) : 0;
						$netPayPeriod2 = $process_data['period'] == 1 ? 0 : ($income_salary['period3'] + $income_salary['period4']);
						break;
				endswitch;

				# INSERT INTO tblProcessedEmployees
				$arrProcessed_emp = array('processID' 		=> $processid['proc_id'],
										  'appointmentCode' => $emp['emp_detail']['appointmentCode'],
										  'empNumber' 		=> $emp['emp_detail']['empNumber'],
										  'surname' 		=> $emp['emp_detail']['surname'],
										  'firstname' 		=> $emp['emp_detail']['firstname'],
										  'middlename' 		=> $emp['emp_detail']['middlename'],
										  'middleInitial' 	=> $emp['emp_detail']['middleInitial'],
										  'nameExtension' 	=> $emp['emp_detail']['nameExtension'],
										  'positionAbb' 	=> $emp['emp_detail']['positionAbb'],
										  'processDate' 	=> date("Y-m-d"),
										  'processMonth' 	=> $process_data['mon'],
										  'processYear' 	=> $process_data['yr'],
										  'processCode' 	=> $processid['code'],
										  'payrollGroupCode'=> $emp['emp_detail']['payrollGroupCode'],
										  'projectCode' 	=> $emp['emp_detail']['projectCode'],
										  'netPayPeriod1' 	=> $netPayPeriod1,
										  'netPayPeriod2' 	=> $netPayPeriod2,
										  'netPay' 			=> $period_amount,
										  'actualSalary' 	=> $emp['emp_detail']['actualSalary'],
										  'positionCode' 	=> $emp['emp_detail']['positionCode'],
										  'officeCode' 		=> $emp['emp_detail']['officeCode'],
										  'salarySchedule'  => $payroll_process['computation'],
										  'period' 			=> $process_data['period']);
				# -- insert here
				$this->Payroll_process_model->add_processed_project($arrProcessed_emp);
				# INSERT INTO tblProcessedProject
				$arrProcessed_proj = array('processID' 	 => $processid['proc_id'],
										   'projectCode' => $emp['emp_detail']['payrollGroupCode'],
										   'projectDesc' => $emp['emp_detail']['projectDesc'],
										   'projectOrder'=> $emp['emp_detail']['projectOrder']);
				# -- insert here
				$this->Payroll_process_model->add_processed_employees($arrProcessed_proj);
				# INSERT INTO tblProcessedPayrollGroup
				$arrProcessed_pgroup = array('processID'   		=> $processid['proc_id'],
										     'payrollGroupCode' => $emp['emp_detail']['payrollGroupCode'],
										     'payrollGroupName' => $emp['emp_detail']['payrollGroupName'],
										     'projectCode' 		=> $emp['emp_detail']['projectCode'],
										     'payrollGroupOrder'=> $emp['emp_detail']['payrollGroupOrder']);
				# --insert here
				$this->Payroll_process_model->add_processed_pgroup($arrProcessed_pgroup);

			endforeach;
		endforeach;
		
		$this->session->set_flashdata('strSuccessMsg','Payroll saved successfully.');
		redirect('finance/payroll_update/reports?processid='.implode(';',array_column($arrProcess_id,'proc_id')));
	}


}
/* End of file Payrollupdate.php
 * Location: ./application/modules/finance/controllers/payroll_update/Payrollupdate.php */