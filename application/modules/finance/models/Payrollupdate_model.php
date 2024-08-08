<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payrollupdate_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function getPayrollUpdate($type)
	{
		$this->db->order_by('incomeDesc');
		return $this->db->get_where('tblIncome', array('incomeType' => $type, 'hidden' => 0))->result_array();
	}

	function payroll_select_income_process($process_mo,$process_yr,$appt,$inc_type,$period=0)
	{
		if($appt != 'P'){
			$this->db->where('tblProcess.period',$period);
		}
		$processed = $this->db->distinct()->select('tblEmpIncome.incomeCode')
							  ->join('tblProcess','tblProcess ON tblProcess.processID = tblEmpIncome.processID')
							  ->where('tblProcess.processMonth',$process_mo)
							  ->where('tblProcess.processYear',$process_yr)
							  ->where('tblProcess.employeeAppoint',$appt)
							  ->get('tblEmpIncome')->result_array();

		$arrResults = array();
		if($inc_type == 'Others'):
			if(count($processed) > 0):
				$this->db->where_not_in('incomeCode', array_column($processed,'incomeCode'));
			endif;
			$arrResults = $this->db->where("(incomeType='Additional' OR incomeType='Monthly')")
								   ->where('hidden',0)->get('tblIncome')->result_array();
		else:
			if(count($processed) > 0):
				$this->db->where_not_in('incomeCode', array_column($processed,'incomeCode'));
			endif;
			$arrResults = $this->db->get_where('tblIncome',array('incomeType' => $inc_type, 'hidden' => 0))->result_array();
		endif;
		return $arrResults;
	}

	// function check_salary_exist($process_mo,$process_yr,$appt)
	// {
	// 	$salary = $this->db->distinct()
	// 					   ->select('tblEmpIncome.incomeCode')
	// 					   ->join('tblProcess','tblProcess.processID = tblEmpIncome.processID')
	// 					   ->where('tblProcess.processMonth',$process_mo)
	// 					   ->where('processYear',$process_yr)
	// 					   ->where('employeeAppoint',$appt)
	// 					   ->where('incomeCode','SALARY')->get('tblEmpIncome')->result_array();

	// 	return count($salary) > 0 ? 1 : 0;
	// }

	function compute_benefits($arrPost, $process_data,$empid='')
	{
		$this->load->helper(array('payroll_helper','dtr_helper'));
		$this->load->model(array('Dtr_model','Longevity_model','Rata_model','libraries/Attendance_scheme_model'));

		$month = sprintf('%02d', $process_data['data_fr_mon']);
		$yr = $process_data['data_fr_yr'];

		if($process_data['txt_dtfrom']!='' && $process_data['txt_dtto']!=''):
			$datefrom = date('Y-m-d', strtotime($process_data['txt_dtfrom']));
			$dateto = date('Y-m-d', strtotime($process_data['txt_dtto']));
			$process_data_datediff = round((strtotime($process_data['txt_dtto']) - strtotime($process_data['txt_dtfrom'])) / (60 * 60 * 24)) + 1;
		else:
			$datefrom = implode('-',array($yr,$month,'01'));
			$dateto = implode('-',array($yr,$month,cal_days_in_month(CAL_GREGORIAN,$month,$yr)));
			$process_data_datediff = 0;
		endif;

		$arrrata = $this->Rata_model->getData();

		$att_schemes = $this->Attendance_scheme_model->getData();
		// $arrholidays = array();
		
		// foreach($holidays as $hday):
		// 	if(!in_array(date('D', strtotime($hday['holidayDate'])), array('Sat','Sun'))){
		// 		array_push($arrholidays,$hday['holidayDate']); }
		// endforeach;

		/** curr_workingdays = working days in the current period
		    workingdays = working days from process month/date */
		# current period working days
		if($process_data['txt_dtfrom']!=null && $process_data['txt_dtto']!=null){
			$curr_holidays = $this->Dtr_model->getHoliday('',1,$datefrom,$dateto);
			$curr_workingdays = get_workingdays('','',$curr_holidays,$datefrom,$dateto);
			# process data working days
			$workingdays = $curr_workingdays;
		}else{
			$curr_holidays = $this->Dtr_model->getHoliday($process_data['yr'].'-'.sprintf('%02d', $process_data['mon']).'-',1);
			$curr_workingdays = get_workingdays(sprintf('%02d', $process_data['mon']),$process_data['yr'],$curr_holidays);
			# process data working days
			$holidays = $this->Dtr_model->getHoliday($yr.'-'.$month.'-',1);
			$workingdays = get_workingdays($month,$yr,$holidays);
		}

		// echo 'working days :<br>';
		// print_r($workingdays);
		// echo '<br>';
		$no_empty_lb = 0;
		$arremployees = array();
		$emp_leavebal = $this->Leave_model->getEmpLeave_balance('',$month,$yr);
		$process_employees = $this->Payroll_process_model->getEmployees($process_data['selemployment'],$empid,1,1);
		$rata_details = $this->Payroll_process_model->get_rata_details();
		foreach($process_employees as $emp):
			# employee attendance scheme
			$emp_att_scheme = $att_schemes[array_search($emp['schemeCode'], array_column($att_schemes, 'schemeCode'))];
			# Employee Local Holiday
			$emplocal_holidays = $this->Dtr_model->getLocalHoliday($emp['empNumber']);
			# Employee OB
			$obdates = $this->Dtr_model->getemp_obdates($emp['empNumber'],$datefrom,$dateto,0);
			// print_r($obdates);
			# Employee TO
			$todates = $this->Dtr_model->getemp_todates($emp['empNumber'],$datefrom,$dateto,1);

			$curr_workingdays = array_diff($curr_workingdays,array_column($emplocal_holidays, 'holidate'));
			$workingdays = array_diff($workingdays,array_column($emplocal_holidays, 'holidate'));

			if($process_data['txt_dtfrom']!=null && $process_data['txt_dtto']!=null){
				$empdtr = $this->Dtr_model->getData($emp['empNumber'],'','',$datefrom,$dateto);
			}else{
				$empdtr = $this->Dtr_model->getData($emp['empNumber'],$yr,$month);
			}
			
			$empdays_present = array_column($empdtr, 'dtrDate', 'id');

			$actual_present = array_intersect($empdays_present,$workingdays);
			$total_late = 0;
			$total_ut = 0;
			$actual_days_presents =  0;
			$date_presents = array();
			// print_r(array_column($empdtr, 'dtrDate'));
			foreach($actual_present as $key => $att):
				// echo 'key '.$key.' val '.$att;
				// print_r($empdtr[$key]);
				$emp_att = $empdtr[array_search($key, array_column($empdtr, 'id'))];
				$dtr_empty = count(array_keys(array($emp_att['inAM'],$emp_att['outAM'],$emp_att['inPM'],$emp_att['outPM']), '00:00:00'));
				#compute present days not include ob
				if(!in_array($emp_att['dtrDate'],array_unique(array_column($obdates, 'date')))):
					if($dtr_empty <= 4):
						$actual_days_presents++;
						array_push($date_presents,$emp_att['dtrDate']);
						# Lates
						$late = $this->Dtr_model->computeLate($emp_att_scheme, $emp_att, $todates);
						$total_late = $total_late + $late;
						# Undertimes
						$uts = $this->Dtr_model->computeUndertime($emp_att_scheme, $emp_att, $late, $todates);
						$total_ut = $total_ut + $uts;
						// print_r($uts);
						// echo '<hr>';
					endif;
				// else:
				// 	$empob = $obdates[array_search($emp_att['dtrDate'], array_column($obdates, 'date'))];
				// 	print_r($empob);
				// 	print_r($emp_att);
				// 	echo '<hr>';
				endif;

				// # check OB
				
				// echo '<br>';
			endforeach;

			// print_r($obdates);
			# Manage OB
			foreach($obdates as $obd):
				$obd_date = $obd['date'];
				$obd_stime = $obd['obTimeFrom'];
				$obd_etime = $obd['obTimeTo'];

				# if ob is exact 8 hrs
				$obhrs = $this->Dtr_model->time_subtract($obd_stime, $obd_etime);
				if(strtotime($obhrs) >= strtotime('09:00')):
					$actual_days_presents = $actual_days_presents + 1;
				else:
					$emp_att = $empdtr[array_search($obd['date'], array_column($empdtr, 'dtrDate'))];
					# ob with dtrdata
					$obdatekey = array_search($obd['date'], array_column($empdtr, 'dtrDate'));
					if(is_numeric($obdatekey)):
						# if ob start time is PM, dtr time in pm is equals to ob start time, else vice versa
						if(date('A', strtotime($obd_stime)) == 'AM'):
							$emp_att['inAM'] = $emp_att['inAM'] == '00:00:00' ? date("g:i:s", strtotime($obd_stime)) : $emp_att['inAM'];
						else:
							$emp_att['outAM'] = $emp_att['outAM'] == '00:00:00' ? date("g:i:s", strtotime($obd_stime)) : $emp_att['outAM'];
							$emp_att['inPM'] = $emp_att['inPM'] == '00:00:00' ? date("g:i:s", strtotime($obd_stime)) : $emp_att['inPM'];
						endif;
						# if ob end time is PM, dtr time out pm is equals to ob end time
						if(date('A', strtotime($obd_etime)) == 'PM'):
							# if between 12 - 1 PM
							if((strtotime($obd_etime) >= strtotime(fixTime($emp_att_scheme['nnTimeoutFrom'],'PM'))) && (strtotime($obd_etime) <= strtotime(fixTime($emp_att_scheme['nnTimeinTo'],'PM')))):
								$emp_att['outAM'] = $emp_att['outAM'] == '00:00:00' ? date("g:i:s", strtotime($obd_etime)) : $emp_att['outAM'];
								$emp_att['inPM'] = $emp_att['inPM'] == '00:00:00' ? date("g:i:s", strtotime($obd_etime)) : $emp_att['inPM'];
							endif;

							if($emp_att['outPM'] == '00:00:00'):
								$emp_att['outPM'] = date("g:i:s", strtotime($obd_etime));
							else:
								$outPM_check = date('H:i:s', strtotime($emp_att['outPM'].' PM'));
								if(strtotime($outPM_check) < strtotime($obd['obTimeTo'])):
									$emp_att['outPM'] = date("g:i:s", strtotime($obd_etime));
								endif;
							endif;
						endif;
					else:
						# ob without dtrdata
					endif;
					// print_r($obd);
					// echo '<hr>';
					$actual_days_presents = $actual_days_presents + 1;
					# Late with ob
					$oblate = $this->Dtr_model->computeLate($emp_att_scheme, $emp_att, $todates);
					$total_late = $total_late + $oblate;
					# undertime with ob
					$obuts = $this->Dtr_model->computeUndertime($emp_att_scheme, $emp_att, $oblate, $todates);
					$total_ut = $total_ut + $obuts;
				endif;
			endforeach;

			// $obs = array_intersect($workingdays,$obdates);
			# check all obdates not present in empdays_present
			// print_r($obdates);
			// print_r($date_presents);
			// $allobs = array_intersect($date_presents,array_unique(array_column($obdates, 'date')));
			// $obs = array_diff(array_unique(array_column($obdates, 'date')),$allobs);
			// print_r($allobs);
			// print_r($obs);
			// // $ctrob = 0;
			// // print_r(array_intersect($empdays_present,$obdates));
			// // if(count(array_intersect($empdays_present,$obdates)) < 1):

			// // else:

			// // endif;
			// $actual_days_presents = $actual_days_presents + count($obs);

			# Check TO dates
			// print_r($todates);
			$alltos = array_intersect($date_presents,$todates);
			// print_r($todates);

			// print_r($alltos);

			// print_r($empdays_present);
			$tos = array_diff($todates,$alltos);
			// print_r($tos);
			// echo 'tos: ';
			// print_r(count($tos));
			// echo '<br>';
			$actual_days_presents = $actual_days_presents + count($tos);
			// $actual_days_absent = count($workingdays) - $actual_days_presents;
			# current working days - days absent
			// $days_work = count($curr_workingdays) - $actual_days_absent;
			if(count($emp_leavebal) > 0):
				$emp_lb = $emp_leavebal[array_search($emp['empNumber'], array_column($emp_leavebal, 'empNumber'))];
				if(count($emp_lb) < 1):
					$no_empty_lb = $no_empty_lb + 1;
				endif;
			endif;

			$lbkey = array_search($emp['empNumber'], array_column($emp_leavebal, 'empNumber'));
			$lb_details = is_numeric($lbkey) ? $emp_leavebal[$lbkey] : null;
			
			$emp_lb = array('ctr_8h' => $lb_details['ctr_8h'] == '' ? 0 : $lb_details['ctr_8h'],
							'ctr_6h' => $lb_details['ctr_6h'] == '' ? 0 : $lb_details['ctr_6h'],
							'ctr_5h' => $lb_details['ctr_5h'] == '' ? 0 : $lb_details['ctr_5h'],
							'ctr_4h' => $lb_details['ctr_4h'] == '' ? 0 : $lb_details['ctr_4h'],
							'ctr_wmeal' => $lb_details['ctr_wmeal'] == '' ? 0 : $lb_details['ctr_wmeal'],
							'ctr_diem' => $lb_details['ctr_diem'] == '' ? 0 : $lb_details['ctr_diem'],
							'ctr_laundry' => $lb_details['ctr_laundry'] == '' ? 0 : $lb_details['ctr_laundry'],
							'nodays_absent' => $lb_details['nodays_absent'] == '' ? 0 : $lb_details['nodays_absent']);
			# if not permanent
			if($process_data['selemployment'] != 'P'):
				$emp_lb['nodays_absent'] = count($curr_workingdays) - $actual_days_presents;
			endif;
			$days_work = count($curr_workingdays) - $lb_details['nodays_absent'];
			// $actual_days_presents = 0;
			// $date_presents = array();
			// foreach($empdtr as $dtr):
				// print_r($dtr);
			// 	if(!in_array($dtr['dtrDate'],$arrholidays)):
					// $dtr_empty = count(array_keys(array($dtr['inAM'],$dtr['outAM'],$dtr['inPM'],$dtr['outPM']), '00:00:00'));
					// if($dtr_empty < 4):
					// 	$actual_days_presents++;
					// 	array_push($date_presents,$dtr['dtrDate']);
					// endif;
			// 	endif;
			// 	echo '<br>';
			// endforeach;
			// print_r($date_presents);
			// echo 'presents '.$actual_days_presents;
			// // foreach(range(1, cal_days_in_month(CAL_GREGORIAN, $process_data['data_fr_mon'], $process_data['data_fr_yr'])) as $day):
			// // 	echo '<br>';
			// // 	print_r($day);
			// // endforeach;
			// echo '<hr>';

			# deduction and salary period computation
			$per_period = $emp['actualSalary'] / 2;
			if(strtolower($process_data['txtcomputation']) == 'daily'){
				$salary_days = $process_data_datediff;
			}else{
				$salary_days = SALARY_DAYS;
			}
			$per_day = $emp['actualSalary'] / $salary_days;
			$per_hr = $per_day / 8;
			$per_min = $per_hr / 60;
			$deduct_day = $emp_lb['nodays_absent'] * $per_day;
			$deduct_mins = ($total_late + $total_ut) * $per_min;
			$total_deduct = $deduct_day + $deduct_mins;
			$period_salary = $per_period - $total_deduct;

			$hpfactor = hpfactor($days_work, $emp['hpFactor']);
			$hpfactor = $emp['actualSalary'] * $hpfactor;
			$subsis = substistence(count($curr_workingdays), count($workingdays), $emp_lb);
			$laundry = laundry($emp_lb['ctr_laundry']);
			$longevity = $this->Longevity_model->getLongevitySum($emp['empNumber']);
			$rata = rata($arrrata, $days_work, count($curr_workingdays), $emp['RATACode'], $emp['RATAVehicle']);
			$total_income = $hpfactor + $subsis + $laundry + $longevity + $rata['ra_amount'] + $rata['ta_amount'] + AMT_PERA;

			# RATA Details
			$rata_key = array_search($emp['RATACode'], array_column($rata_details, 'RATACode'));
			$rata_amt = is_numeric($rata_key) ? $rata_details[$rata_key]['RATAAmount'] : 0;

			$arremployees[] = array( 'emp_detail' 			=> $emp,
									 'actual_days_present' 	=> $actual_days_presents,
									 'actual_days_absent' 	=> $emp_lb['nodays_absent'],
									 'hp' 					=> $hpfactor,
									 'emp_leavebal'			=> $emp_lb,
									 'subsis'				=> isset($arrPost['chkbenefit']) ? in_array('SUBSIS', $arrPost['chkbenefit']) ? $subsis : 0 : 0,
									 'laundry'				=> $laundry,
									 'longevity'			=> $longevity,
									 'rata'					=> $rata,
									 'total_income'			=> $total_income,
									 'total_late'			=> $total_late,
									 'total_ut'				=> $total_ut,
									 'total_deduct'			=> $total_deduct,
									 'period_salary'		=> $period_salary,
									 'rata_amt'				=> $rata_amt);
			// print_r(array( 'emp_detail' 			=> $emp,
			// 						 'actual_days_present' 	=> $actual_days_presents,
			// 						 'actual_days_absent' 	=> count($workingdays) - $actual_days_presents,
			// 						 'hp' 					=> $hpfactor,
			// 						 'emp_leavebal'			=> $emp_lb));
		endforeach;

		return array('arremployees' => $arremployees, 'workingdays' => count($workingdays), 'curr_workingdays' => count($curr_workingdays), 'no_empty_lb' => $no_empty_lb, 'process_data_datediff' => $process_data_datediff);
	}


}
/* End of file Payrollupdate_model.php */
/* Location: ./application/modules/finance/models/Payrollupdate_model.php */



