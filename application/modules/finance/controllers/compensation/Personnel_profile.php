<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Personnel_profile extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('hr/Hr_model','Deduction_model',
        						 'Compensation_model', 'libraries/Appointment_status_model','hr/Attendance_summary_model','employee/Leave_model',
        						 'Benefit_model','finance/Signatory_model'));
        $this->load->helper('payroll_helper');
    }

	public function index()
	{
		$this->arrData['arrEmployees'] = $this->Hr_model->getData('','','all');
		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_all',$this->arrData);
	}

	public function employee($empid)
	{
		$this->load->model(array('Payroll_group_model', 'Rata_model',
								 'libraries/Attendance_scheme_model', 'Tax_exempt_model',
								 'libraries/Plantilla_model', 'libraries/Separation_mode_model',
								 'Benefit_model'));

		$res = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = count($res) > 0 ? $res[0] : array();
		$this->arrData['pGroups'] = $this->Payroll_group_model->getData();
		$this->arrData['rata'] = count($res) > 0 ? $this->Rata_model->getData($res[0]['RATACode']) : array();
		$this->arrData['pg'] = count($res) > 0 ? $this->Payroll_group_model->getData($res[0]['payrollGroupCode']) : array();

		$arrAs = array();
		$arrAttSchemes = $this->Attendance_scheme_model->getData();
		foreach($arrAttSchemes as $as):
			if($as['schemeType'] == 'Sliding'):
				$varas['code'] = $as['schemeCode'];
				$varas['label'] = $as['schemeName'].'-'.$as['schemeType'].' ('.substr($as['amTimeinFrom'],0,5).'-'.substr($as['amTimeinTo'],0,5).','.substr($as['pmTimeoutFrom'],0,5).'-'.substr($as['pmTimeoutTo'],0,5).')';
			else:
				$varas['code'] = $as['schemeCode'];
				$varas['label'] = $as['schemeName'].'-'.$as['schemeType'].' ('.substr($as['amTimeinFrom'],0,5)."-".substr($as['pmTimeoutTo'],0,5).')';
			endif;
			$arrAs[] = $varas;
		endforeach;
		$this->arrData['arrAttSchemes'] = $arrAs;
		$this->arrData['tax_status'] = $this->Tax_exempt_model->getData();
		$this->arrData['arrRataCode'] = $this->Rata_model->getData();

		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrPlantillaList'] = $this->Plantilla_model->getAllPlantilla();
		$this->arrData['arrSeparationModes'] = $this->Separation_mode_model->getData();

		if(!isset($_GET['yr']) && !isset($_GET['mon'])):
			$_GET['yr'] = date('Y'); $_GET['mon'] = date('n');
		endif;
		$arrEmpBenefits = $this->Benefit_model->getEmployeeBenefit($empid,$_GET['yr'],$_GET['mon']);
		$this->arrData['arrEmpBenefits'] = $arrEmpBenefits;
		$this->arrData['empSalary'] = $this->arrData['arrData']['actualSalary'];
		$this->arrData['arrEmpDeductions'] = $this->Compensation_model->getEmployeeDeduction($empid,$_GET['yr'],$_GET['mon']);
		$this->arrData['arrdtr'] = $this->Attendance_summary_model->getEmployee_dtr($empid,date('Y-m-d'),date('Y-m-d'));
		
		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function edit_payrollDetails()
	{
		$arrPost = $this->input->post();
		$empid = $this->uri->segment(5);
		
		if(!empty($arrPost)):
			$arrData = array(
					'payrollGroupCode'  => $arrPost['selpayrollGrp'],
					'payrollSwitch'     => isset($arrPost['chkis_incPayroll']) ? $arrPost['chkis_incPayroll'] : '',
					'schemeCode'        => $arrPost['selattScheme'],
					'taxSwitch'         => isset($arrPost['chkis_selfemployed']) ? $arrPost['chkis_selfemployed'] : '',
					'taxStatCode'       => $arrPost['seltaxStatus'],
					'dependents'        => $arrPost['txtnodependents'],
					'healthProvider'    => isset($arrPost['chkis_health']) ? $arrPost['chkis_health'] : '',
					'taxRate'           => $arrPost['txttxtRate'],
					'hpFactor'          => $arrPost['txthazardPay'],
					'RATACode'          => $arrPost['selrataCode'],
					'RATAVehicle'       => isset($arrPost['chkw_govt_vehicle']) ? $arrPost['chkw_govt_vehicle'] : '');
			$this->session->set_flashdata('strSuccessMsg','Payroll Details updated successfully.');
			$this->Compensation_model->editEmpPosition($arrData, $empid, $arrPost['txtacctNumber']);
		endif;
		redirect('finance/compensation/personnel_profile/employee/'.$empid.'/1');

	}

	public function edit_positionDetails()
	{
		$arrPost = $this->input->post();
		$empid = $this->uri->segment(5);
		if(!empty($arrPost)):
			$arrData = array(
					'appointmentCode'	=> $arrPost['selappointment'],
					'uniqueItemNumber'	=> $arrPost['selitem'],
					'actualSalary'		=> $arrPost['txtactual_salary'],
					'authorizeSalary'	=> $arrPost['txtauth_salary'],
					'positionDate'		=> $arrPost['txtposdate'],
					'statusOfAppointment' => $arrPost['selmodeofseparation'],
					'salaryGradeNumber'	=> $arrPost['txtsalaryGrade'],
					'stepNumber'		=> $arrPost['selStep_number'],
					'dateIncremented'	=> $arrPost['txtdateincrement']);
			$this->session->set_flashdata('strSuccessMsg','Position Details updated successfully.');
			$this->Compensation_model->editEmpPosition($arrData, $empid);
		endif;
		redirect('finance/compensation/personnel_profile/employee/'.$empid.'/2');
	}

	# Begin 2nd tab of personnel_profile = 'income' 
	public function income($empid)
	{
		$this->load->model(array('Income_model','Longevity_model','Benefit_model','libraries/Payroll_process_model'));
		$res = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $res[0];

		// BENEFIT LIST
		$incomes = $this->Income_model->getDataByType('Benefit');
		$benefits = $this->Benefit_model->getBenefits($empid);
		$this->arrData['benefitList'] = $this->Benefit_model->getBenefitsfromArray($benefits, $incomes);
		$this->arrData['arrStatus'] = array('1' => 'On-going','2' => 'Paused','0' => 'Remove');
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrAppointments_by2'] = count($this->arrData['arrAppointments']) / 2;

		// PAYROLL PROCESS
		$res_process = $this->Payroll_process_model->getData($res[0]['appointmentCode']);
		$this->arrData['empPayrollProcess'] = $res_process[0]['computation'];

		// LONGEVITY PAY
		$this->arrData['arrLongevity'] = $this->Longevity_model->getLongevity($empid);

		// BONUS
		$bonusList = $this->Income_model->getDataByType('Bonus');
		$this->arrData['arrBonuslist'] = $this->Benefit_model->getBenefitsfromArray($benefits, $bonusList);

		$addtlIncome = $this->Income_model->getDataByType('Additional');
		$this->arrData['arrAddtlIncome'] = $this->Benefit_model->getBenefitsfromArray($benefits, $addtlIncome);

		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function actionLongevity()
	{
		$this->load->model('Income_model');
		$arrPost = $this->input->post();
		$empid = $this->uri->segment(5);

		if(!empty($arrPost)):
			$this->load->model('Longevity_model');
			$salary = str_replace(',','',$arrPost['txtsalary']);
			if(isset($arrPost['txtaction'])):
				if($arrPost['txtaction'] == 'add'):
					$arrData = array(
							'empNumber'		=> $empid,
							'longiDate'		=> $arrPost['txtlongevitydate'],
							'longiAmount'	=> $salary,
							'longiPercent'	=> $arrPost['txtpercent'],
							'longiPay'		=> $salary * ($arrPost['txtpercent'] / 100));
					$this->Longevity_model->addLongevity($arrData);
					$this->session->set_flashdata('strSuccessMsg','Longevity pay added successfully.');
				endif;

				if($arrPost['txtaction'] == 'edit'):
					$arrData = array(
							'longiDate'		=> $arrPost['txtlongevitydate'],
							'longiAmount'	=> $salary,
							'longiPercent'	=> $arrPost['txtpercent'],
							'longiPay'		=> $salary * ($arrPost['txtpercent'] / 100));
					$this->Longevity_model->editLongevity($arrData, $empid, $arrPost['txtlongevityid']);
					$this->session->set_flashdata('strSuccessMsg','Longevity pay updated successfully.');
				endif;
			endif;

			if(isset($arrPost['txtdel_action'])):
				if($arrPost['txtdel_action'] == 'del'):
					$this->Longevity_model->delLongevity($empid, $arrPost['txtdel_longevityid']);
					$this->session->set_flashdata('strSuccessMsg','Longevity pay deleted successfully.');
				endif;
			endif;

			# update longevity table
			$income_amount = $arrPost['txtamount'] + ($arrPost['txtsalary'] * ($arrPost['txtpercent'] / 100));
			$this->session->set_flashdata('strSuccessMsg','Longevity and Benefit Details updated successfully.');
			$this->Income_model->editBy_empid_income(array('incomeAmount' => $income_amount, 'period1' => $income_amount), $empid, 'LONGI');
		endif;
		redirect('finance/compensation/personnel_profile/income/'.$empid.'/2');
	}

	public function edit_benefits($empid,$arrData=array(),$updateall=0)
	{
		if($updateall == 1):
			$arrPost = $arrData;
		else:
			$arrPost = $this->input->post();
			$empid = $this->uri->segment(5);
		endif;

		# check if exist in benefits
		$checkexist = $this->Benefit_model->getBenefits($empid, $arrPost['txtincomecode']);
		if(count($checkexist) > 0):
			$arrPost['txtbenefitcode'] = isset($arrPost['txtbenefitcode']) ? $arrPost['txtbenefitcode'] : $checkexist[0]['benefitCode'];
			$arrData = array('incomeAmount' => strtofloat($arrPost['txtamount']),
							 'ITW' => strtofloat($arrPost['txttax']),
							 'period1' => strtofloat($arrPost['txtperiod1']),
							 'period2' => strtofloat($arrPost['txtperiod2']),
							 'status' => $arrPost['selstatus']);
			$this->Benefit_model->edit($arrData, $arrPost['txtbenefitcode']);
			$this->session->set_flashdata('strSuccessMsg', $arrPost['txtbenefitType'].' updated successfully.');
		else:
			$arrData = array('empNumber' => $empid,
							 'incomeCode' => $arrPost['txtincomecode'],
							 'incomeAmount' => strtofloat($arrPost['txtamount']),
							 'ITW' =>strtofloat( $arrPost['txttax']),
							 'period1' => strtofloat($arrPost['txtperiod1']),
							 'period2' => strtofloat($arrPost['txtperiod2']),
							 'status' => $arrPost['selstatus']);
			$this->Benefit_model->add($arrData);
			$this->session->set_flashdata('strSuccessMsg', $arrPost['txtbenefitType'].' added successfully.');
		endif;

		if($updateall == 0):
			redirect('finance/compensation/personnel_profile/income/'.$this->uri->segment(5));
		endif;
	}

	public function updateAllEmployees()
	{
		$arrPost = $this->input->post();
		$module = $this->uri->segment(6);

		# get employees according to appointment given
		$this->load->model('libraries/Position_model');	
		foreach($arrPost['chkappnt'] as $apptcode):
			$empnumbers = $this->Position_model->getDataByFields('appointmentCode', $apptcode, 'empNumber');
			if(count($empnumbers) > 0):
				# update or add benefits
				foreach($empnumbers as $emp):
					if($module == 'income'):
						$this->edit_benefits($emp['empNumber'],$arrPost,1);
					else:
						$this->edit_deduction($emp['empNumber'],$arrPost,1);
					endif;
				endforeach;
			endif;
		endforeach;
		
		if($module == 'income'):
			redirect('finance/compensation/personnel_profile/income/'.$this->uri->segment(5));
		else:
			redirect('finance/compensation/personnel_profile/premium_loan/'.$this->uri->segment(5));
		endif;
	}
	# End 2nd tab of personnel_profile = 'income' 

	public function deduction_summary($empid)
	{
		$this->load->model('libraries/Agency_profile_model');
		$employeeData = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $employeeData[0];

		$res = $this->Hr_model->getData($empid,'','all');
		$agencyData = $this->Agency_profile_model->getData();

		// LIFE RETIREMENT
		$this->arrData['lifeRetirement'] = $this->Compensation_model->getLifeRetirement(
												$res[0]['lifeRetSwitch'], $res[0]['actualSalary'],
												$agencyData[0]['gsisEmpShare'], $agencyData[0]['gsisEmprShare'], $empid);
		// PAGIBIG
		$this->arrData['pagibig'] = $this->Compensation_model->getPagibig(
												$res[0]['pagibigSwitch'], $res[0]['actualSalary'],
												$agencyData[0]['pagibigEmpShare'], $agencyData[0]['pagibigEmprShare'],$empid);

		// PHILHEALTH
		$this->arrData['philhealth'] = $this->Compensation_model->getPhilhealth(
												$res[0]['philhealthSwitch'], $res[0]['actualSalary'],
												$agencyData[0]['philhealthEmpShare'], $agencyData[0]['philhealthEmprShare'],$empid);
		// ITW
		$this->arrData['itw'] = $this->Compensation_model->getITW($empid);

		$this->arrData['arrLoans'] = $this->Compensation_model->getLoans($empid);
		$this->arrData['arrContributions'] = $this->Compensation_model->getContributions($empid);
		$this->arrData['arrFinishedLoans'] = $this->Compensation_model->getFinishedLoans($empid);

		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function premium_loan($empid)
	{
		$this->load->model('libraries/Payroll_process_model');
		$employeeData = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $employeeData[0];

		$this->arrData['arrDeductions'] = $this->Compensation_model->getPremiumDeduction($empid, 'Regular');
		$this->arrData['arrLoans'] = $this->Compensation_model->getPremiumDeduction($empid, 'Loan');
		$this->arrData['arrContributions'] = $this->Compensation_model->getPremiumContribution($empid, 'Contribution');

		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrAppointments_by2'] = count($this->arrData['arrAppointments']) / 2;

		// PAYROLL PROCESS
		$res_process = $this->Payroll_process_model->getData($employeeData[0]['appointmentCode']);
		$this->arrData['empPayrollProcess'] = $res_process[0]['computation'];

		$this->arrData['arrStatus'] = array('1' => 'On-going','2' => 'Paused','0' => 'Remove');
		
		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function remittances($empid)
	{
		$employeeData = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $employeeData[0];

		$arrPost = $this->input->get();
		if(!empty($arrPost)):
			$this->load->model('Remittance_model');
			$this->arrData['arrRemittances'] = $this->Remittance_model->getRemittance($empid, $arrPost['selpayrollGrp'], $arrPost['from'], $arrPost['to']);
		endif;

		$arrDeductions = $this->Deduction_model->getDeductionsByStatus(0);
		array_push($arrDeductions, array('deductionCode' => 'ALLGSIS', 'deductionDesc' => 'ALL GSIS Deduction(exc. Life and Ret. Prem.)'));
		$this->arrData['arrDeductions'] = $arrDeductions;
		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function reports($empid)
	{
		$this->load->model('finance/Payroll_process_model');
		$employeeData = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $employeeData[0];

		$emp_position = $this->Hr_model->get_employee_position($this->uri->segment(5));
		$emp_position = $emp_position[0]['appointmentCode'];
		$this->arrData['periods'] = $this->Payroll_process_model->get_process_by_appointment($emp_position,currmo(),curryr());

		$arrDeductions = $this->Deduction_model->getDeductionsByStatus(0);
		array_push($arrDeductions, array('deductionCode' => 'ALLGSIS', 'deductionDesc' => 'ALL GSIS Deduction(exc. Life and Ret. Prem.)'));
		$this->arrData['arrDeductions'] = $arrDeductions;
		$this->arrData['arrSignatories'] = $this->Signatory_model->getSignatoriesByModule(check_module() == 'hr' ? 1 : 0); #1=hr;0=payroll
		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function tax_details($empid)
	{
		$this->load->model('TaxDetails_model');
		$employeeData = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $employeeData[0];
		$this->arrData['action'] = 'view';

		$this->arrData['arrTaxDetails'] = $this->TaxDetails_model->getTaxDetails($empid);
		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function edit_tax_details($empid)
	{
		$this->load->model('TaxDetails_model');
		$employeeData = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $employeeData[0];
		$this->arrData['action'] = 'edit';
		$arrTaxDetails = $this->TaxDetails_model->getTaxDetails($empid);
		
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array('otherDependent' => $arrPost['txtdependent_name'],
							 'dBirthDate' => $arrPost['txtdependent_bday'],
							 'dRelationship' => $arrPost['txtdependent_rel'],

							 'pTin' => $arrPost['txtemp1_tin'],
							 'pAddress' => $arrPost['txtemp1_reg'],
							 'pEmployer' => $arrPost['txtemp1_name'],
							 'pZipCode' => $arrPost['txtemp1_zip'],

							 'pTin1' => $arrPost['txtemp2_tin'],
							 'pAddress1' => $arrPost['txtemp2_reg'],
							 'pEmployer1' => $arrPost['txtemp2_name'],
							 'pZipCode1' => $arrPost['txtemp2_zip'],

							 'pTin2' => $arrPost['txtemp3_tin'],
							 'pAddress2' => $arrPost['txtemp3_reg'],
							 'pEmployer2' => $arrPost['txtemp3_name'],
							 'pZipCode2' => $arrPost['txtemp3_zip'],

							 'pTaxComp' => $arrPost['txtcompen'],
							 'pTaxWheld' => $arrPost['txttax']
							);
			if($arrTaxDetails !=null):
				$this->TaxDetails_model->editTaxDetails($arrData, $empid);
				$this->session->set_flashdata('strSuccessMsg','Tax details updated successfully.');
				redirect('finance/compensation/personnel_profile/tax_details/'.$empid);
			else:
				$arrData['empNumber'] = $empid;
				$this->TaxDetails_model->add($arrData);
				$this->session->set_flashdata('strSuccessMsg','Tax details added successfully.');
				redirect('finance/compensation/personnel_profile/tax_details/'.$empid);
			endif;
		endif;

		$this->arrData['arrTaxDetails'] = $arrTaxDetails;
		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function dtr($empid)
	{
		$this->load->model('libraries/Holiday_model');
		$this->load->helper(array('payroll_helper','dtr_helper'));
		
		$empid = $this->uri->segment(5);
		$res = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $res[0];

		$datefrom = isset($_GET['datefrom']) ? $_GET['datefrom'] : date('Y-m-').'01';
		$dateto = isset($_GET['dateto']) ? $_GET['dateto'] : date('Y-m-').cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

		$holidays = $this->Holiday_model->getAllHolidates($empid,$datefrom,$dateto);
		$this->arrData['working_days'] = get_workingdays('','',$holidays,$datefrom,$dateto);

		$arremp_dtr = $this->Attendance_summary_model->getemp_dtr($empid, $datefrom, $dateto);
		$this->arrData['arrLatestBalance'] = $this->Leave_model->getLatestBalance($empid);
		$this->arrData['arremp_dtr'] = $arremp_dtr;

		if(in_array(check_module(),array('officer','executive'))):
			$this->arrData['arrdtr'] = $this->Attendance_summary_model->getcurrent_dtr($empid);
		endif;
		
		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function edit_deduction($empid,$arrData=array(),$updateall=0)
	{
		if($updateall == 1):
			$arrPost = $arrData;
			$arrPost['txtdeductcode'] = '';
		else:
			$arrPost = $this->input->post();
			$empid = $this->uri->segment(5);
		endif;
		# check if exist in benefits
		$arrPost['selsmonth'] = ltrim($arrPost['selsmonth'],'0');
		$arrPost['selemonth'] = ltrim($arrPost['selemonth'],'0');

		$checkexist = $this->Compensation_model->getDeduction($empid, $arrPost['txtdeductioncode']);
		if(count($checkexist) > 0):
			$arrPost['txtdeductcode'] = $arrPost['txtdeductcode'] != '' ? $arrPost['txtdeductcode'] : $checkexist[0]['deductCode'];
			$arrData = array('deductionCode' => $arrPost['txtdeductioncode'],
							 'monthly' => str_replace(',', '', $arrPost['txtamount']),
							 'period1' => isset($arrPost['txtperiod1']) ? str_replace(',', '', $arrPost['txtperiod1']) : '',
							 'period2' => isset($arrPost['txtperiod2']) ? str_replace(',', '', $arrPost['txtperiod2']) : '',
							 'period3' => isset($arrPost['txtperiod3']) ? str_replace(',', '', $arrPost['txtperiod3']) : '',
							 'period4' => isset($arrPost['txtperiod4']) ? str_replace(',', '', $arrPost['txtperiod4']) : '',
							 'status' => $arrPost['selstatus']);

			if($arrPost['txtstat'] == 'loan'):
				$arrData['actualStartYear'] = $arrPost['selsyear'];
				$arrData['actualStartMonth'] = $arrPost['selsmonth'];
				$arrData['actualEndYear'] = $arrPost['seleyr'];
				$arrData['actualEndMonth'] = $arrPost['selemonth'];
			endif;
			$this->Compensation_model->editDeduction($arrData, $arrPost['txtdeductcode'], $empid);
			$this->session->set_flashdata('strSuccessMsg', $arrPost['txtdeductionType'].' updated successfully.');
		else:
			$arrData = array('empNumber' => $empid,
							 'deductionCode' => $arrPost['txtdeductioncode'],
							 'monthly' => $arrPost['txtamount'],
							 'period1' => isset($arrPost['txtperiod1']) ? str_replace(',', '', $arrPost['txtperiod1']) : '',
							 'period2' => isset($arrPost['txtperiod2']) ? str_replace(',', '', $arrPost['txtperiod2']) : '',
							 'period3' => isset($arrPost['txtperiod3']) ? str_replace(',', '', $arrPost['txtperiod3']) : '',
							 'period4' => isset($arrPost['txtperiod4']) ? str_replace(',', '', $arrPost['txtperiod4']) : '',
							 'status' => $arrPost['selstatus']);

			if($arrPost['txtstat'] == 'loan'):
				$arrData['actualStartYear'] = $arrPost['selsyear'];
				$arrData['actualStartMonth'] = $arrPost['selsmonth'];
				$arrData['actualEndYear'] = $arrPost['seleyr'];
				$arrData['actualEndMonth'] = $arrPost['selemonth'];
			endif;
			$this->Compensation_model->addDeduction($arrData);
			$this->session->set_flashdata('strSuccessMsg', $arrPost['txtdeductionType'].' added successfully.');
		endif;
		
		if($updateall == 0):
			redirect('finance/compensation/personnel_profile/premium_loan/'.$empid);
		endif;
	}

	# BEGIN ADJUSTMENT
	public function adjustments($empid)
	{
		$this->load->model(array('Income_model','Adjustments_model','Deduction_model','libraries/Payroll_process_model'));
		$employeeData = $this->Hr_model->getData($empid,'','all');
		$this->arrData['arrData'] = $employeeData[0];

		$mon = isset($_GET['mon']) ? $_GET['mon'] : 0;
		$yr = isset($_GET['yr']) ? $_GET['yr'] : 0;
		$period = isset($_GET['period']) ? $_GET['period'] : "";

		// PAYROLL PROCESS
		$res_process = $this->Payroll_process_model->getData($employeeData[0]['appointmentCode']);
		$this->arrData['empPayrollProcess'] = $res_process[0]['computation'];

		$mon 	= isset($_GET['month']) ? $_GET['month'] == 'all' ? 0 : ltrim($_GET['month'], '0') : 0;
		$yr 	= isset($_GET['yr']) ? $_GET['yr'] == 'all' ? 0 : $_GET['yr'] : 0;
		$period = isset($_GET['period']) ? $_GET['period'] == 'all' ? 0 : $_GET['period'] : 0;
		$this->arrData['arrDataDeduct'] = $this->Adjustments_model->getDeductions($empid,$mon,$yr,$period);
		$this->arrData['arrDataIncome'] = $this->Adjustments_model->getIncome($empid,$mon,$yr,$period);

		$this->arrData['arrIncomes'] = $this->Income_model->getDataByIncomeCode();
		$this->arrData['arrDeductions'] = $this->Deduction_model->getDeductions('','*');

		$this->template->load('template/template_view','finance/compensation/personnel_profile/view_employee',$this->arrData);
	}

	public function income_adjustment($empid)
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$this->load->model('Adjustments_model');
			if($arrPost['txtaction'] == 'add'):
				$arrData = array('empNumber' 	=> 	$empid,
								 'incomeCode' 	=> 	$arrPost['selincome'],
								 'incomeMonth' 	=> 	$arrPost['selinc_month'],
								 'incomeYear' 	=> 	$arrPost['selinc_yr'],
								 'incomeAmount' => 	$arrPost['txtinc_amt'],
								 'type' 		=> 	$arrPost['selinc_type'],
								 'adjustMonth' 	=> 	$arrPost['txtadjmon'],
								 'adjustYear' 	=> 	$arrPost['txtadjyr'],
								 'adjustPeriod' => 	$arrPost['txtadjper']);
				$this->Adjustments_model->addAdj_income($arrData);
				$this->session->set_flashdata('strSuccessMsg', 'Adjustment income added successfully.');
			endif;
			if($arrPost['txtaction'] == 'edit'):
				$arrData = array('incomeCode' 	=> 	$arrPost['selincome'],
								 'incomeMonth' 	=> 	$arrPost['selinc_month'],
								 'incomeYear' 	=> 	$arrPost['selinc_yr'],
								 'incomeAmount' => 	$arrPost['txtinc_amt'],
								 'type' 		=> 	$arrPost['selinc_type'],
								 'adjustMonth' 	=> 	$arrPost['txtadjmon'],
								 'adjustYear' 	=> 	$arrPost['txtadjyr'],
								 'adjustPeriod' => 	$arrPost['txtadjper']);
				$this->Adjustments_model->editAdj_income($arrData, $arrPost['txtinc_id']);
				$this->session->set_flashdata('strSuccessMsg', 'Adjustment income updated successfully.');
			endif;
			redirect('finance/compensation/personnel_profile/adjustments/'.$empid.'?mon='.$arrPost['txtadjmon'].'&yr='.$arrPost['txtadjyr'].'&period='.$arrPost['txtadjper']);
		endif;
	}

	public function deduction_adjustment($empid)
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$this->load->model('Adjustments_model');
			if($arrPost['txtded_action'] == 'add'):
				$arrData = array('empNumber' 	=> 	$empid,
								 'deductionCode'=> 	$arrPost['seldeduct'],
								 'deductMonth' 	=> 	$arrPost['selded_month'],
								 'deductYear' 	=> 	$arrPost['selded_yr'],
								 'deductAmount' => 	$arrPost['txtded_amt'],
								 'type' 		=> 	$arrPost['selded_type'],
								 'adjustMonth' 	=> 	$arrPost['seladjmon_adj'],
								 'adjustYear' 	=> 	$arrPost['seladjyr_adj'],
								 'adjustPeriod' => 	$arrPost['seladjper_adj']);
				$this->Adjustments_model->addAdj_deduction($arrData);
				$this->session->set_flashdata('strSuccessMsg', 'Adjustment deduction added successfully.');
			endif;
			if($arrPost['txtded_action'] == 'edit'):
				$arrData = array('deductionCode'=> 	$arrPost['seldeduct'],
								 'deductMonth' 	=> 	$arrPost['selded_month'],
								 'deductYear' 	=> 	$arrPost['selded_yr'],
								 'deductAmount' => 	$arrPost['txtded_amt'],
								 'type' 		=> 	$arrPost['selded_type'],
								 'adjustMonth' 	=> 	$arrPost['seladjmon_adj'],
								 'adjustYear' 	=> 	$arrPost['seladjyr_adj'],
								 'adjustPeriod' => 	$arrPost['seladjper_adj']);
				$this->Adjustments_model->editAdj_deduction($arrData, $arrPost['txtded_id']);
				$this->session->set_flashdata('strSuccessMsg', 'Adjustment deduction updated successfully.');
			endif;
			redirect('finance/compensation/personnel_profile/adjustments/'.$empid.'?mon='.$arrPost['txtadjmon'].'&yr='.$arrPost['txtadjyr'].'&period='.$arrPost['txtadjper']);
		endif;
	}

	public function delete_adjustment()
	{
		$arrPost = $this->input->post();
		$empid = $this->uri->segment(5);

		if(!empty($arrPost)):
			$this->load->model('Adjustments_model');

			if($arrPost['txtdel_action'] == 'income'):
				$this->Adjustments_model->delAdj_income($arrPost['txtdel_id']);
				$this->session->set_flashdata('strSuccessMsg', 'Adjustment income deleted successfully.');
			endif;

			if($arrPost['txtdel_action'] == 'deduction'):
				$this->Adjustments_model->delAdj_deduction($arrPost['txtdel_id']);
				$this->session->set_flashdata('strSuccessMsg', 'Adjustment deduction deleted successfully.');
			endif;

			redirect('finance/compensation/personnel_profile/adjustments/'.$empid.'?mon='.$_GET['mon'].'&yr='.$_GET['yr'].'&period='.$_GET['period']);
		endif;
		
	}
	# END ADJUSTMENT

}
/* End of file Deductions.php
 * Location: ./application/modules/finance/controllers/compensation/Personnel_profile.php */