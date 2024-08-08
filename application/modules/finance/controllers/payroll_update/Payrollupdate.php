<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Payrollupdate extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('Payrollupdate_model','Deduction_model','libraries/Appointment_status_model','pds/Pds_model','Payroll_process_model','hr/Attendance_summary_model','employee/Leave_model','finance/Income_model','finance/Benefit_model','hr/Hr_model','Computation_instance_model','finance/Process_model'));
        $this->load->helper('payroll_helper');
        $this->arrData = array();
    }

    ## PROCESS - STEP 1
	public function index()
	{
		$process_name = $this->uri->segment(4);
		$_GET['selemployment'] = isset($_GET['selemployment']) ? $_GET['selemployment'] : 'P';
		$_GET['mon'] = isset($_GET['mon']) ? $_GET['mon'] : date('n');
		$_GET['yr'] = isset($_GET['yr']) ? $_GET['yr'] : date('Y');
		$_GET['period'] = isset($_GET['period']) ? $_GET['period'] : 'Period 1';
		$_GET['selcode'] = isset($_GET['selcode']) ? $_GET['selcode'] : 'SALARY';
		
		$this->arrData['arr_form_data'] = isset($_GET['data']) ? json_decode($_GET['data'],1) : array();

		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getAppointmentJointPermanent(true);
		$this->arrData['arrProcesses'] = $this->Process_model->getPayrollProcessed('*','*',$_GET['mon'],$_GET['yr']);
		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function check_processed_payroll()
	{
		$selemployment = isset($_GET['selemployment']) ? $_GET['selemployment'] : 'P';
		$selmonth = isset($_GET['selmonth']) ? $_GET['selmonth'] : currmo();
		$selyr = isset($_GET['selyr']) ? $_GET['selyr'] : curryr();
		$selcode = isset($_GET['selcode']) ? $_GET['selcode'] : 'SALARY';
		$processes = $this->Process_model->getPayrollProcessed(strtoupper($selemployment),strtoupper($selcode),$selmonth,$selyr);
		echo json_encode($processes);
	}

	## PROCESS - STEP 2
	public function select_benefits_perm()
	{
		$arrPost = $this->input->post();

		$this->arrData['arrBenefit'] = $this->Payrollupdate_model->payroll_select_income_process($arrPost['mon'],$arrPost['yr'],$arrPost['selemployment'],'Benefit');
		$this->arrData['arrBonus'] = $this->Payrollupdate_model->payroll_select_income_process($arrPost['mon'],$arrPost['yr'],$arrPost['selemployment'],'Bonus');
		$this->arrData['arrIncome'] = $this->Payrollupdate_model->payroll_select_income_process($arrPost['mon'],$arrPost['yr'],$arrPost['selemployment'],'Others');
		// $this->arrData['salary'] = $this->Payrollupdate_model->check_salary_exist($arrPost['mon'],$arrPost['yr'],$arrPost['selemployment']);
		$this->arrData['process'] = $this->Payroll_process_model->get_process_by_appointment($arrPost['selemployment'],$arrPost['mon'],$arrPost['yr']);
		$this->arrData['arrLoan'] = $this->Deduction_model->getDeductionsByType('Loan');
		$this->arrData['arrContrib'] = $this->Deduction_model->getDeductionsByType('Contribution');
		$this->arrData['arrOthers'] = $this->Deduction_model->getDeductionsByType('Others');

		if(isset($_GET['data'])):
		    $_GET['data'] = json_decode($_GET['data'],true);
		    $process_details = json_encode($_GET['data']['txtprocess']);
		else:
			$process_details = json_encode($_POST);
		endif;
		$this->arrData['process_details'] = $process_details;
		
		$computation = isset($_GET['data']['txtprocess']) ? $_GET['data']['txtprocess']['txtcomputation'] : strtolower($_POST['txtcomputation']);
		switch($computation):
		    case 'monthly':
		        $form = 'finance/payroll_update/compute_benefits_perm'; break;
		    case 'daily':
		        $form = 'finance/payroll_update/compute_benefits_nonperm_trc'; break;
		    default:
		        $form = 'finance/payroll_update/computation_nonperm'; break;
		endswitch;
		$this->arrData['form'] = $form;
		
		# check all benefits
		$chk_all_benefits = 0;
		$chk_all_bonus = 0;
		$chk_all_income = 0;
		if(isset($_GET['data'])):
		    $chk_all_benefits = isset($_GET['data']['chkbenefit']) ? count($_GET['data']['chkbenefit']) == count($this->arrData['arrBenefit']) ? 1 : 0 : 0;
		    $chk_all_bonus    = isset($_GET['data']['chkbonus']) ? count($_GET['data']['chkbonus']) == count($this->arrData['arrBonus']) ? 1 : 0 : 0;
		    $chk_all_income   = isset($_GET['data']['chkincome']) ? count($_GET['data']['chkincome']) == count($this->arrData['arrIncome']) ? 1 : 0 : 0;
		else:
			$chk_all_benefits = strtoupper($_POST['selemployment']) == 'P' ? 1 : 0;
		endif;

		$this->arrData['chk_all_benefits'] = $chk_all_benefits;
		$this->arrData['chk_all_bonus'] = $chk_all_bonus;
		$this->arrData['chk_all_income'] = $chk_all_income;

		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function compute_benefits_perm()
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
								'no_empty_lb'		 => $computed_benefits['no_empty_lb']);

		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function save_benefits_perm()
	{
		$arrPost = $this->input->post();
		$arremp_computations = fixArray($arrPost['txtjson']);
		$process_data = fixArray($arrPost['txtprocess']);
		$arrPost['chkbenefit'] = fixArray($arrPost['chkbenefit']);

		$computed_benefits = $this->Payrollupdate_model->compute_benefits($arrPost, $process_data);
		
		$arrrData_comp_instance = array('month' 			=> $process_data['data_fr_mon'],
										'year'				=> $process_data['data_fr_yr'],
										'appointmentCode'  	=> $process_data['selemployment'],
										'pmonth' 			=> $process_data['mon'],
										'pyear' 			=> $process_data['yr'],
										'totalNumDays' 		=> $computed_benefits['workingdays']);
		$fk_id = $this->Computation_instance_model->insert_computation_instance($arrrData_comp_instance);

		foreach($computed_benefits['arremployees'] as $emp_comp):
			$arrComputation_codes = array(array('code' => 'HAZARD', 'amount' => $emp_comp['hp']),
											 array('code' => 'LAUNDRY','amount' => $emp_comp['laundry']),
											 array('code' => 'LONGI',  'amount' => $emp_comp['longevity'] == '' ? 0.00 : $emp_comp['longevity']),
											 array('code' => 'SUBSIS', 'amount' => $emp_comp['subsis']),
											 array('code' => 'SALARY', 'amount' => $emp_comp['emp_detail']['actualSalary']),
											 array('code' => 'RA', 	'amount' => $emp_comp['rata']['ra_amount']),
											 array('code' => 'TA', 	'amount' => $emp_comp['rata']['ta_amount']));
			foreach($arrComputation_codes as $comp_code):
				$arrData_computation = array('fk_id' 	 => $fk_id,
											 'empNumber' => $emp_comp['emp_detail']['empNumber'],
											 'code' 	 => $comp_code['code'],
											 'amount' 	 => $comp_code['amount']);
				# tablename : tblComputation
				$code_id[$comp_code['code']] = $this->Computation_instance_model->insert_computation($arrData_computation);	
			endforeach;

			// INSERT INTO tblComputationDetails  (fk_id,empNumber,periodMonth,periodYear,workingDays,nodaysPresent,nodaysAbsent, hpFactor,ctr_8h,ctr_6h,ctr_5h,ctr_4h, ctr_wmeal, ctr_diem, ctr_laundry,  rataAmount,rataVehicle,rataCode,daysWithVehicle, raPercent,taPercent,latest, hazardCode,hazard,laundryCode,laundry,subsisCode,subsistence,salaryCode,salary,longi,ra,ta) 
			$arrData_comp_details = array('fk_id'			=> $fk_id,
										  'empNumber'		=> $emp_comp['emp_detail']['empNumber'],
										  'periodMonth'		=> $process_data['mon'],
										  'periodYear'		=> $process_data['yr'],
										  'workingDays'		=> $computed_benefits['workingdays'],
										  'nodaysPresent'	=> $emp_comp['actual_days_present'],
										  'nodaysAbsent'	=> $emp_comp['actual_days_absent'],
										  'hpFactor'		=> $emp_comp['emp_detail']['hpFactor'],
										  'ctr_8h'			=> $emp_comp['emp_leavebal']['ctr_8h'],
										  'ctr_6h'			=> $emp_comp['emp_leavebal']['ctr_6h'],
										  'ctr_5h'			=> $emp_comp['emp_leavebal']['ctr_5h'],
										  'ctr_4h'			=> $emp_comp['emp_leavebal']['ctr_4h'],
										  'ctr_wmeal'		=> $emp_comp['emp_leavebal']['ctr_wmeal'],
										  'ctr_diem'		=> $emp_comp['emp_leavebal']['ctr_diem'],
										  'ctr_laundry'		=> $emp_comp['emp_leavebal']['ctr_laundry'],
										  'rataAmount'		=> $emp_comp['rata_amt'],
										  'rataVehicle'		=> $emp_comp['emp_detail']['RATAVehicle'] == '' ? 'N' : $emp_comp['emp_detail']['RATAVehicle'],
										  'rataCode'		=> $emp_comp['emp_detail']['RATACode'] == '' ? '' : $emp_comp['emp_detail']['RATACode'],
										  'daysWithVehicle'	=> $emp_comp['emp_detail']['RATAVehicle'] == 'Y' ? $computed_benefits['workingdays'] : 0,
										  'raPercent'		=> $emp_comp['rata']['ra_percent'],
										  'taPercent'		=> $emp_comp['rata']['ta_percent'],
										  'latest'			=> count($emp_comp['emp_leavebal']) > 0 ? 'Y' : 'N',
										  'hazardCode'		=> count($code_id) > 0 ? $code_id['HAZARD'] : 0,
										  'hazard'			=> $emp_comp['hp'],
										  'laundryCode'		=> count($code_id) > 0 ? $code_id['LAUNDRY'] : 0,
										  'laundry'			=> $emp_comp['laundry'],
										  'subsisCode'		=> count($code_id) > 0 ? $code_id['SUBSIS'] : 0,
										  'subsistence'		=> $emp_comp['subsis'],
										  'salaryCode'		=> count($code_id) > 0 ? $code_id['SALARY'] : 0,
										  'salary'			=> $emp_comp['emp_detail']['actualSalary'],
										  'longi'			=> $emp_comp['longevity'] == '' ? 0.00 : $emp_comp['longevity'],
										  'ra'				=> $emp_comp['rata']['ra_amount'] == '' ? 0.00 : $emp_comp['rata']['ra_amount'],
										  'ta'				=> $emp_comp['rata']['ta_amount']);
			$this->Computation_instance_model->insert_computation_details($arrData_comp_details);

			# Delete Benefits
			// if($process_data['selemployment'] == 'P'):
				// DELETE tblEmpBenefits.* FROM tblEmpBenefits LEFT JOIN tblEmpPosition ON tblEmpBenefits.empNumber = tblEmpPosition.empNumber WHERE $SQLappoint AND (tblEmpBenefits.incomeCode = 'HAZARD' OR tblEmpBenefits.incomeCode='LAUNDRY' OR tblEmpBenefits.incomeCode='SUBSIS' OR tblEmpBenefits.incomeCode = 'LONGI' OR tblEmpBenefits.incomeCode = 'TA' OR tblEmpBenefits.incomeCode = 'RA')

			// endif;
			// DELETE tblEmpBenefits.* FROM tblEmpBenefits LEFT JOIN tblEmpPosition ON tblEmpBenefits.empNumber = tblEmpPosition.empNumber WHERE $SQLappoint AND (tblEmpBenefits.incomeCode = 'SALARY')
			$arremp_numbers = $this->Payroll_process_model->getEmployees($process_data['selemployment'],'',1,1);
			$this->Benefit_model->delete_empbenefit_byempNumber($process_data['selemployment'],array($emp_comp['emp_detail']['empNumber']));
			
			# Insert benefits
			$payroll_process = $this->Payroll_process_model->process_with($process_data['selemployment']);
			if($process_data['selemployment'] == 'P'):
				// INSERT INTO tblEmpBenefits (empNumber, incomeCode, incomeMonth, incomeAmount, period1,status) SELECT c.empNumber, c.code, '$pmonth' AS incomeMonth, ROUND(c.amount,2), ROUND(c.amount,2), '1' FROM tblComputation c LEFT JOIN tblComputationInstance ci ON ci.id = c.fk_id WHERE ci.pmonth='$pmonth' AND ci.pyear='$pyear' AND ci.appointmentCode='$appoint' AND c.code != 'SALARY' GROUP BY `c`.`empNumber` , `c`.`code`
				foreach($arrComputation_codes as $comp_code):
					$arrData_benefits = array('empNumber' 	=> $emp_comp['emp_detail']['empNumber'],
											  'incomeCode' 	=> $comp_code['code'],
											  'incomeYear'  => $process_data['yr'],
											  'incomeMonth' => $process_data['mon'],
											  'incomeAmount'=> round($comp_code['amount'],2),
											  'status' 		=> '1');
					if($comp_code['code'] == 'SALARY'):
						switch ($payroll_process['computation']):
							case 'Monthly':
								$arrData_benefits['period1'] = round($comp_code['amount'],2);
								break;
							case 'Semimonthly':
							case 'Bi-Monthly':
								$arrData_benefits['period1'] = round(($comp_code['amount']/2),2);
								$arrData_benefits['period2'] = round(($comp_code['amount']/2),2);
								break;
							case 'Weekly':
							case 'Daily':
								$arrData_benefits['period1'] = round(($comp_code['amount']/4),2);
								$arrData_benefits['period2'] = round(($comp_code['amount']/4),2);
								$arrData_benefits['period3'] = round(($comp_code['amount']/4),2);
								$arrData_benefits['period4'] = round(($comp_code['amount']/4),2);
								break;
						endswitch;
					else:
						$arrData_benefits['period1'] = round($comp_code['amount'],2);
					endif;
					$this->Benefit_model->add($arrData_benefits);
				endforeach;
			endif;

		endforeach;

		$this->Computation_instance_model->edit_computation_instance(array('status' => 0),$process_data['selemployment']);
		$this->Computation_instance_model->edit_computation_instance(array('status' => 1),$process_data['selemployment'],$process_data['mon'],$process_data['yr']);

		$this->session->set_flashdata('strSuccessMsg','Compute benefits saved successfully.');
		$this->arrData = array( 'employment_type'	 => $process_data['selemployment'],
								'payroll_date'		 => date('F Y',strtotime($process_data['yr'].'-'.$process_data['mon'].'-1')),
								'process_data_date'	 => date('F Y',strtotime($process_data['data_fr_yr'].'-'.$process_data['data_fr_mon'].'-1')),
								'process_data_workingdays' => $computed_benefits['workingdays'],
								'curr_period_workingdays'  => $computed_benefits['curr_workingdays'],
								'arrEmployees'		 => $computed_benefits['arremployees'],
								'no_empty_lb'		 => $computed_benefits['no_empty_lb']);

		
		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function select_deductions_perm()
	{
		$arrPost = $this->input->post();
		$arrEmployees = array();
		if(!empty($arrPost)):
			if(gettype($arrPost['chkbenefit']) == 'string'):
				$arrPost['chkbenefit'] = json_decode($arrPost['chkbenefit'],true);
			endif;
		endif;

		$this->arrData['arrEmployees'] = $arrPost['txtjson'];
		$this->arrData['arrLoan'] = $this->Deduction_model->getDeductionsByType('Loan');
		$this->arrData['arrContrib'] = $this->Deduction_model->getDeductionsByType('Contribution');
		$this->arrData['arrOthers'] = $this->Deduction_model->getDeductionsByType('Others');

		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function complete_process_perm()
	{
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
				if(count($emp_addtl) > 0):
					foreach($emp_addtl as $emp_addtl):
						if(($emp_addtl['period1'] + $emp_addtl['period2'] + $emp_addtl['period3'] + $emp_addtl['period4']) > 0):
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
						endif;
					endforeach;
				endif;
				

				# Process Bonus
				# chkbonus
				# INSERT INTO tblEmpIncome (processID, empNumber, incomeCode, incomeYear, incomeMonth, actualSalary, incomeAmount, app
				# get bonus from tblEmpBenefits
				if(count(fixArray($bonus)) > 0):
					$emp_bonus = $this->Income_model->get_employee_income($emp['emp_detail']['empNumber'],fixArray($bonus),'Bonus');
					foreach($emp_bonus as $emp_bonus):
						if(($emp_bonus['period1'] + $emp_bonus['period2'] + $emp_bonus['period3'] + $emp_bonus['period4']) > 0):
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
						endif;
						
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
				endif;
				
				# Process Deductions
				# deduction - Loan
				# INSERT INTO tblEmpDeductionRemit
				if(count($loans) > 0):
					$empLoans = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],$loans,'Loan');
					foreach($empLoans as $loan):
						if(($loan['period1'] + $loan['period2'] + $loan['period3'] + $loan['period4']) > 0):
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
						endif;
					endforeach;
				endif;
				# Income - Benefit
				# INSERT INTO tblEmpIncome
				if(count(fixArray($benefits)) > 0):
					$emp_benefit = $this->Income_model->get_employee_income($emp['emp_detail']['empNumber'],fixArray($benefits),'Benefit');
					# insert income; tablename : tblempincome
					foreach($emp_benefit as $emp_benefit):
						if(($emp_benefit['period1'] + $emp_benefit['period2'] + $emp_benefit['period3'] + $emp_benefit['period4']) > 0):
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
				endif;

				# LONGI
				# INSERT INTO tblEmpDeductionRemit
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

				# deduction - Others
				# INSERT INTO tblEmpDeductionRemit
				if(count(fixArray($others)) > 0):
					$others_deductions = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],fixArray($others),'Others');
					foreach($others_deductions as $oth_d):
						if(($oth_d['period1'] + $oth_d['period2'] + $oth_d['period3'] + $oth_d['period4']) > 0):
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
						endif;
					endforeach;
				endif;

				# deduction - Contributions (contri)
				# INSERT INTO tblEmpDeductionRemit
				$check_deductions = $this->Deduction_model->check_empdeductions($process_data['mon'],$process_data['yr'],$emp['emp_detail']['appointmentCode']);
				if(count($check_deductions) > 0):
					$contri_deductions = $this->Deduction_model->get_employee_deductions($emp['emp_detail']['empNumber'],fixArray($contri),'Contribution');
					foreach($contri_deductions as $contri):
						if(($contri['period1'] + $contri['period2'] + $contri['period3'] + $contri['period4']) > 0):
							$arrData_contri = array('processID'	 => $processid['proc_id'],
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
							$this->Deduction_model->add_deduction_remit($arrData_contri);
						endif;
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
				$netPayPeriod1 = 0;
				$netPayPeriod2 = 0;
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
		// redirect('finance/payroll_update/reports?processid='.implode(';',array_column($arrProcess_id,'proc_id')));
		redirect('finance/reports/monthly?month='.$process_data['mon'].'&yr='.$process_data['yr'].'&appt='.$process_data['selemployment'].'&processid='.$arrProcess_id[0]['proc_id']);

	}

	public function reprocess()
	{
		$arrPost = $this->input->post();
		$this->Computation_instance_model->del_computation_details_byPeriod($arrPost['txtperiodmon'],$arrPost['txtperiodyr']);
		$this->Computation_instance_model->edit_computation_details(array('latest' => 'N'));
		$comp_instance = $this->Computation_instance_model->getData($arrPost['txtperiodmon'],$arrPost['txtperiodyr'],$arrPost['txtappt']);
		foreach($comp_instance as $comp_ins):
			$this->Computation_instance_model->del_computation($comp_ins['id']);
		endforeach;
		$this->Computation_instance_model->del_computation_instance_byperiod($arrPost['txtperiodmon'],$arrPost['txtperiodyr'],$arrPost['txtappt']);
		$this->Income_model->delete_byprocessid($arrPost['txtreprocess_id']);
		
		$deduction_remit = $this->Deduction_model->get_deduction_remit($arrPost['txtreprocess_id'],'Loan',$arrPost['txtperiodmon'],$arrPost['txtperiodyr']);
		foreach($deduction_remit as $remit):
			$this->Deduction_model->edit_empdeduction_byempnumber(array('STATUS' => 1),$remit['deductionCode'],$remit['empNumber']);
		endforeach;
		
		$this->Deduction_model->del_deduction_remit($arrPost['txtreprocess_id']);
		$this->Computation_instance_model->del_computation_nonperm_instance($arrPost['txtappt'],$arrPost['txtperiodmon'],$arrPost['txtperiodyr'],$arrPost['txtperiod']);
		$this->Payroll_process_model->delete_payroll_process_byid($arrPost['txtreprocess_id']);

		$this->session->set_flashdata('strSuccessMsg','Data removed successfully.');
		redirect('finance/payroll_update/process');
	}

	public function reports()
	{
		$this->template->load('template/template_view','finance/payroll/process_step',$this->arrData);
	}

	public function view_or()
	{
		$this->arrData['arr_orlist'] = $this->Payroll_process_model->get_orlist('','',0);
		$this->template->load('template/template_view','finance/payroll/or/_view',$this->arrData);
	}

	public function update_or()
	{
		$arrmsg = array();
		$arrPost = $this->input->post();
		if(!empty($arrPost)){
			$employees = $arrPost['selproc_emp'];
			foreach($employees as $employee):
				$arrData = array('orNumber' => $arrPost['txtorno'], 'orDate' => $arrPost['txtordate']);
				$update = $this->Payroll_process_model->update_or($arrData,$arrPost['selproc_sal'],$arrPost['selproc_deduction'],$employee);
				
				if(!$update){
					array_push($arrmsg,$employee);
				}
			endforeach;

			if(count($arrmsg) < 1){
				$this->session->set_flashdata('strSuccessMsg','OR Remittances updated successfully.');
				redirect('finance/payroll_update/update_or');
			}
		}

		$arr_remitt = array();
		if(isset($_GET['remitt_id'])){
			$arr_remitt = $this->Payroll_process_model->get_deduction_remit($_GET['remitt_id']);
		}
		$this->arrData['arr_remitt'] = $arr_remitt;
		$this->arrData['arrmsg'] = $arrmsg;
		$this->arrData['arrpayroll'] = $this->Payroll_process_model->get_payroll_process(currmo(),curryr());
		$this->arrData['arremployees'] = $this->Hr_model->getData();
		$this->arrData['deduction_list'] = $this->Deduction_model->getData();
		$this->template->load('template/template_view','finance/payroll/or/_update',$this->arrData);
	}

	public function or_delete()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)){
			$arrData = array('orNumber' => '', 'orDate' => NULL);
			$update = $this->Payroll_process_model->update_orby_remitt($arrData,$arrPost['txtremitt_id']);

			$this->session->set_flashdata('strSuccessMsg','OR Remittances deleted successfully.');
			redirect('finance/payroll_update/view_or');
		}
	}

	public function fieldsinPayroll()
	{
		$arrPayrollFields['arrBenefit'] = $this->Payrollupdate_model->getPayrollUpdate($_GET['employment'], $_GET['month'], $_GET['year'], $_GET['period'], 'Benefit');
		$arrPayrollFields['arrBonus'] = $this->Payrollupdate_model->getPayrollUpdate($_GET['employment'], $_GET['month'], $_GET['year'], $_GET['period'], 'Bonus');
		$arrPayrollFields['arrIncome'] = $this->Payrollupdate_model->getPayrollUpdate($_GET['employment'], $_GET['month'], $_GET['year'], $_GET['period'], 'Additional');

		echo json_encode($arrPayrollFields);
	}
	
	public function getListofEmployee()
	{
		// $this->load->model(array('libraries/Appointment_status_model','pds/Pds_model'));
		// $appt = $this->Appointment_status_model->getData($_GET['selemployment'],$_GET['selmon'],$_GET['selyr']);
		// $arrData['appt'] = $appt[0]['appointmentDesc'];
		// $arrWhere = array('appointmentCode' => $_GET['selemployment'], 'month' => $_GET['selmon'], 'year' => $_GET['selyr']);
		// $arrData['arrEmployees'] = $this->Pds_model->getDataByField($arrWhere,'P');

		// echo json_encode($arrData);
	}

	public function process_history()
	{
		$this->arrData['arrprocess'] = $this->Payroll_process_model->getall_process(currmo(),curryr());
		$this->template->load('template/template_view','finance/payroll/process_history',$this->arrData);
	}

	public function publish_process()
	{
		$empid = $this->uri->segment(4);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array('publish' => $arrPost['txtpublish_val']);
			$this->Payroll_process_model->edit_payroll_process($arrData, $arrPost['txtprocess_id']);
			$this->session->set_flashdata('strSuccessMsg','Process '.($arrPost['txtpublish_val'] == 1 ? 'published' : 'unpublished').' successfully.');
			redirect('finance/payroll_update/process_history?month='.currmo().'&yr='.curryr());
		endif;
	}

	public function process_reports()
	{
		$this->template->load('template/template_view','finance/payroll/process_history',$this->arrData);
	}
	

}
/* End of file Payrollupdate.php
 * Location: ./application/modules/finance/controllers/payroll_update/Payrollupdate.php */