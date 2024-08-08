<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dtr_log_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		$this->db->initialize();
		$this->load->model(array('hr/Attendance_summary_model'));
	}
	
	function chekdtr_log($empid,$dtrdate,$dtrlog,$is_intl,$wfh) 
	{
		# initialization
		$emp_scheme = $this->db->get_where('tblEmpPosition', array('empNumber' => $empid))->result_array();
		$att_scheme_ini = $this->db->get_where('tblAttendanceScheme_online_dtr', array('schemeCode' => $emp_scheme[0]['schemeCode']))->result_array();
		
		$err_message = array();
		$is_strict = $att_scheme_ini[0]['strict'] == 'Y' ? 1 : 0;
		$has_30mins_allow = $att_scheme_ini[0]['allow30'] == 'Y' ? 1 : 0;
		
		$nn_out_from = '';$nn_out_to = '';$nn_in_from = '';$nn_in_to = '';
		$dtrid = '';$am_timein = '';$am_timeout = '';$pm_timein = '';$pm_timeout = '';$ot_timein = '';$ot_timeout = '';

		$sql_str = "";

		// added condition to use client or server date
		// changed all server date to variables
		if($is_intl)
		{
			$coldate = $dtrdate;
			$coldate_log = $dtrdate . " " . $dtrlog;
			$edit_date = $dtrdate . " " . $dtrlog .  " A";
		}
		else
		{
			$coldate = date('Y-m-d');
			$coldate_log = date('Y-m-d H:i:s');
			$edit_date = date('Y-m-d H:i:s A');
		}
		
		$arrdtr = array();
		$empdtr = $this->Attendance_summary_model->getEmployee_dtr($empid,$coldate,$coldate);
	
		$emp_att_scheme = $this->get_employee_attscheme($empid);
		if(!empty($emp_att_scheme)):
			# initializing employee attendance scheme
			$nn_out_from = $emp_att_scheme['nnTimeoutFrom'];
			$nn_out_to = $emp_att_scheme['nnTimeoutTo'];
			$nn_in_from = $emp_att_scheme['nnTimeinFrom'];
			$nn_in_to = $emp_att_scheme['nnTimeinTo'];
		else:
			$err_message = array('strErrorMsg','No Attendance Scheme. Please contact administrator.');
			// added log
			$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => $err_message[1] , 'log_ip' => $this->input->ip_address()));
			return $err_message;
		endif;
	
		# check if dtr is empty
		if(count($empdtr) < 1):
			# check if dtrlog < morning out
			if($dtrlog < $nn_out_from):
				# if true, set to inAM
				$am_timein = $dtrlog;
			else:
				# if false, set to inPM
				$pm_timein = $dtrlog;
			endif;
		else:
			$empdtr = $empdtr[0];
			# if employee has already dtr log
			$dtrid = $empdtr['id'];
			$am_timein  = $empdtr['inAM']  == '00:00:00' ? '' : $empdtr['inAM'];
			$am_timeout = $empdtr['outAM'] == '00:00:00' ? '' : $empdtr['outAM'];
			$pm_timein  = $empdtr['inPM']  == '00:00:00' ? '' : $empdtr['inPM'];
			$pm_timeout = $empdtr['outPM'] == '00:00:00' ? '' : $empdtr['outPM'];
			$ot_timein  = $empdtr['inOT']  == '00:00:00' ? '' : $empdtr['inOT'];
			$ot_timeout = $empdtr['outOT'] == '00:00:00' ? '' : $empdtr['outOT'];

			# check if dtrlog < morning out
			if(strtotime($dtrlog) < strtotime($nn_out_from)):
				# if true, check if strict;
				if($is_strict):
					# if yes, check if am_timein is empty
					if($am_timein != ''):
						# if not empty, employee may try am_timeout, but the condition is strictly dont allow that
						$err_message = array('strErrorMsg','You are not allow to logout! Lunch break is between '.$nn_out_from.' and '.$nn_in_to.'. Please contact administrator.');
					else:
						# if empty, set am_timein
						$am_timein = $dtrlog;
					endif;
				else:
					# if no, check if am_timein is empty
					if($am_timein != ''):
						# if not empty, check if am_timeout is empty
						if($am_timeout != ''):
							# if not empty, set pm_timein
							$pm_timein = $dtrlog;
							$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
						else:
							// added condition to avoid dual time in within 5 minutes
							if(strtotime($dtrlog) >= strtotime($am_timein) && strtotime($dtrlog) <= (strtotime($am_timein)+300) && strtotime($dtrlog) <= strtotime($nn_out_from)):
								$err_message =  array('strErrorMsg','You are not allow to logout! Lunch break is between '.$nn_out_from.' and '.$nn_in_to.'. Please contact administrator.');
							else:
								# if empty, set am_timeout
								$am_timeout = $dtrlog;
								$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
							endif;
						endif;
					else:
						# if empty, set am_timein
						$am_timein = $dtrlog;
					endif;
				endif;
			else:
				# if false, process for [LUNCH BREAK]
				# check if lunch break is not broken (for 30 mins allowance purposes)
				if($nn_out_from == $nn_in_from && $nn_out_to == $nn_in_to):
					# if lunchbreak is not broken, check if dtrlog is between lunch break
					if(strtotime($nn_in_to) > strtotime($dtrlog) && strtotime($nn_out_from) <= strtotime($dtrlog)):
						# check if am_timein is empty, set to am_timein
						if($am_timein == ''):
							$am_timein = $dtrlog;
						else:
							# check if am_timeout is empty, then set to am_timeout if yes
							if($am_timeout == ''):
								$process_data  = $this->set_am_timeout($dtrlog,$empdtr,$has_30mins_allow,$is_strict,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to);
								if(!empty($process_data)):
									$err_message = $process_data['err_message'];
									$am_timeout  = $process_data['am_timeout'];
									$err_message = $process_data['err_message'];
								endif;
							else:
								if($empdtr['outAM'] == '' || $empdtr['outAM'] == '00:00:00'):
									# check if with 30 mins allowance
									if($has_30mins_allow):
										# if yes, check if am_timeout + 30 mins is equal to dtrlog
										if($dtrlog >= date('H:i', strtotime('+30 minutes', strtotime($empdtr['outAM'])))):
											# if yes, set pm_timeout
											$pm_timeout = $dtrlog;
										else:
											# otherwise, employee not allow to login, need to wait for 30 mins
											$err_message = array('strErrorMsg','You are not allow to login! Your login time should be on '.(date('H:i', strtotime('+30 minutes', strtotime($am_timeout)))).'. Please contact administrator.');
										endif;
									else:
										# if no, set pm_timeout
										$pm_timeout = $dtrlog;
									endif;
								else:
									# if no, check if with 30 mins allowance
									if($has_30mins_allow):
										# if yes, check if am_timeout + 30 mins is equal to dtrlog
										if($dtrlog >= date('H:i:s', strtotime('+30 minutes', strtotime($empdtr['outAM'])))):
											# otherwise, set pm_timeout
											$pm_timein = $dtrlog;
										else:
											# if no, employee not allow to login, need to wait for 30 mins
											$err_message = array('strErrorMsg','You are not allow to login! Your login time should be on '.(date('H:i', strtotime('+30 minutes', strtotime($am_timeout)))).'. Please contact administrator.');
										endif;
									else:
										# if no, set pm_timeout
										$pm_timein = $dtrlog;
									endif;
								endif;
							endif;
						endif;
					else:
						$process_data  = $this->set_pm_timeout($dtrlog,$empdtr,$has_30mins_allow,$is_strict,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to);
						if(!empty($process_data)):
							$err_message = $process_data['err_message'];
							$pm_timein  = $process_data['pm_timein'];
							$pm_timeout  = $process_data['pm_timeout'];
							$ot_timein  = $process_data['ot_timein'];
							$ot_timeout  = $process_data['ot_timeout'];
						endif;
					endif;
				else:
					$process_data  = $this->set_broken_nnbreak($dtrlog,$empdtr,$has_30mins_allow,$is_strict,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to);
					if($process_data == false):
						$process_data  = $this->set_pm_timeout($dtrlog,$empdtr,$has_30mins_allow,$is_strict,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to);
						if(!empty($process_data)):
							$err_message = $process_data['err_message'];
							$pm_timein  = $process_data['pm_timein'];
							$pm_timeout  = $process_data['pm_timeout'];
							$ot_timein  = $process_data['ot_timein'];
							$ot_timeout  = $process_data['ot_timeout'];
						endif;
					else:
						if(!empty($process_data)):
							$err_message = $process_data['err_message'];
							$am_timeout  = $process_data['am_timeout'];
							$pm_timein   = $process_data['pm_timein'];
						endif;
					endif;
				endif;
			endif;

		endif;

		$arrdtr = array('empNumber' => $empid, 'dtrDate' => $dtrdate, 'inAM' => $am_timein, 'outAM' => $am_timeout, 'inPM' => $pm_timein, 'outPM' => $pm_timeout, 'inOT' => $ot_timein, 'outOT' => $ot_timeout);

		# insert/update tblEmpDtr
		if($dtrid==''):
			$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
			$arrdtr['name'] = 'System';
			$arrdtr['editdate'] = $edit_date;
			$arrdtr['ip'] = $this->input->ip_address();
			$arrdtr['wfh'] = $wfh;
			$sql_str = $this->Attendance_summary_model->add_dtrkios($arrdtr);
			$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => $err_message[1] , 'log_ip' => $this->input->ip_address()));
			
			return $err_message;
		else:
			if($err_message[0] == 'strSuccessMsg'):
				$sql_str = $this->Attendance_summary_model->edit_dtrkios($arrdtr, $dtrid);
				$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => $err_message[1] , 'log_ip' => $this->input->ip_address()));
				return $err_message;
			else:
				// added log
				$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => $err_message[1] , 'log_ip' => $this->input->ip_address()));
				return $err_message;
			endif;
		endif;
	}

	function set_pm_timeout($dtrlog,$empdtr,$has_30mins_allow,$is_strict,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to)
	{
		$pm_timein = $empdtr['inPM'];
		$pm_timeout = $empdtr['outPM'];
		$ot_timein = $empdtr['inOT'];
		$ot_timeout = $empdtr['outOT'];
		$err_message = array();
		# check if dtrlog is greater than pm max timein
		if($dtrlog > $nn_in_to):
			# check if strict
			if($is_strict):
				# check if timeout is empty, if yes, set pm logout,
				if($pm_timeout == '' || $pm_timeout == '00:00:00'):
					$pm_timeout = $dtrlog;
					$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
				else:
					# else, set overtime
					$ot = $this->set_pm_overtime($dtrlog,$empdtr,$has_30mins_allow,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to);
					$err_message = $ot['err_message'];
					$ot_timein   = $ot['ot_timein'];
					$ot_timeout  = $ot['ot_timeout'];
				endif;
			else:
				# check if am_timeout is empty, check if am_timein is also empty
				if($empdtr['outAM'] == '' || $empdtr['outAM'] == '00:00:00'):
					# if am_timein is empty, check if pm_timein is empty 
					if($empdtr['inAM'] == '' || $empdtr['inAM'] == '00:00:00'):
						# if yes, check if pm_timein, if yes, set pm_timein
						if($empdtr['inPM'] == '' || $empdtr['inPM'] == '00:00:00'):
							$pm_timein = $dtrlog;
							$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
						else:
							# if no, check if timeout is empty, if yes, set pm logout,
							if($pm_timeout == '' || $pm_timeout == '00:00:00'):
								$pm_timeout = $dtrlog;
								$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
							else:
								# else, set overtime
								$ot = $this->set_pm_overtime($dtrlog,$empdtr,$has_30mins_allow,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to);
								$err_message = $ot['err_message'];
								$ot_timein   = $ot['ot_timein'];
								$ot_timeout  = $ot['ot_timeout'];
							endif;
						endif;
					else:
						# if no, check if timeout is empty, if yes, set pm logout,
						if($pm_timeout == '' || $pm_timeout == '00:00:00'):
							$pm_timeout = $dtrlog;
							$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
						else:
							# else, set overtime
							$ot = $this->set_pm_overtime($dtrlog,$empdtr,$has_30mins_allow,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to);
							$err_message = $ot['err_message'];
							$ot_timein   = $ot['ot_timein'];
							$ot_timeout  = $ot['ot_timeout'];
						endif;
					endif;
				else:
					# check if pm_timein is empty, set pm_timein
					if($empdtr['inPM'] == '' || $empdtr['inPM'] == '00:00:00'):
						$pm_timein = $dtrlog;
						$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
					else:
						# if no, check if am_timein is empty, check if pm_timein is empty 
						if($empdtr['inAM'] == '' || $empdtr['inAM'] == '00:00:00'):
							# if yes, set to pm_timein
							$pm_timein = $dtrlog;
							$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
						else:
							# if no, check if timeout is empty, if yes, set pm logout,
							if($pm_timeout == '' || $pm_timeout == '00:00:00'):
								$pm_timeout = $dtrlog;
								$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
							else:
								# else, set overtime
								$ot = $this->set_pm_overtime($dtrlog,$empdtr,$has_30mins_allow,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to);
								$err_message = $ot['err_message'];
								$ot_timein   = $ot['ot_timein'];
								$ot_timeout  = $ot['ot_timeout'];
							endif;
						endif;
					endif;
				endif;
			endif;
		endif;

		return array('err_message' => $err_message, 'pm_timeout' => $pm_timeout, 'pm_timein' => $pm_timein, 'ot_timein' => $ot_timein, 'ot_timeout' => $ot_timeout);
	}

	function set_am_timeout($dtrlog,$empdtr,$has_30mins_allow,$is_strict,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to)
	{
		$am_timeout = '';
		$err_message = array();
		# check if has 30 mins allowance
		if($has_30mins_allow):
			# if logdtr + 30 mins is > last nn break time out
			if(date('H:i:s', strtotime('+30 minutes', strtotime($dtrlog))) > $nn_in_to):
				# if yes, employee not allow to logout for morning, pm time in will be beyond the last nn break time out
				$err_message = array('strErrorMsg','You are not allow to logout for or login from lunch break! Please contact administrator.');
			else:
				$am_timeout = $dtrlog;
				$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
			endif;
		else:
			$am_timeout = $dtrlog;
			$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
		endif;

		return array('err_message' => $err_message, 'am_timeout' => $am_timeout);
	}

	function set_pm_overtime($dtrlog,$empdtr,$has_30mins_allow,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to)
	{
		$err_message = array();
		$ot_timein = $empdtr['inOT'];
		$ot_timeout = $empdtr['outOT'];

		if($ot_timein == '' || $ot_timein == '00:00:00'):
			$ot_timein = $dtrlog;
			$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
		else:
			if($ot_timeout == '' || $ot_timeout == '00:00:00'):
				$ot_timeout = $dtrlog;
				$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
			else:
				$err_message = array('strErrorMsg','You are not allow to login for another Over Time. Please contact administrator.');
			endif;
		endif;

		return array('err_message' => $err_message, 'ot_timein' => $ot_timein, 'ot_timeout' => $ot_timeout);
	}

	function set_broken_nnbreak($dtrlog,$empdtr,$has_30mins_allow,$is_strict,$nn_out_from,$nn_out_to,$nn_in_from,$nn_in_to)
	{
		$err_message = array();
		$am_timeout = $empdtr['outAM'];
		$pm_timein = $empdtr['inPM'];

		# check if dtrlog is between nn_out_from and nn_out_to
		if($dtrlog >= $nn_out_from && $dtrlog <= $nn_out_to):
			# if yes, check if am_timeout is empty
			if($am_timeout == '' || $am_timeout == '00:00:00'):
				# if yes, check if allow 30 mins,
				if($has_30mins_allow):
					if(date('H:i:s', strtotime('+30 minutes', strtotime($dtrlog))) > $nn_in_to):
						$err_message = array('strErrorMsg','You are not allow to logout for or login from lunch break! Please contact administrator.');
					else:
						$am_timeout = $dtrlog;
						$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
					endif;
				else:
					# if no, set am_timeout
					$am_timeout = $dtrlog;
					$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
				endif;
			else:
				# else, check if allow 30 mins, if yes, check if am_timeout is within 30 minutes
				if($has_30mins_allow):
					if($dtrlog >= date('H:i:s', strtotime('+30 minutes', strtotime($empdtr['outAM'])))):
						# if yes, set pm_timein
						$pm_timein = $dtrlog;
						$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
					else:
						$err_message = array('strErrorMsg','You are not allow to login! Your login time should be on '.(date('H:i', strtotime('+30 minutes', strtotime($empdtr['outAM'])))).'. Please contact administrator.');
					endif;
				else:
					# else, set pm_timein
					$pm_timein = $dtrlog;
					$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
				endif;
			endif;
		elseif($dtrlog >= $nn_in_from && $dtrlog <= $nn_in_to):
			# if yes, check if am_timeout is empty
			if($am_timeout == '' || $am_timeout == '00:00:00'):
				# if yes, check if allow 30 mins,
				if($has_30mins_allow):
					$err_message = array('strErrorMsg','You are not allow to logout for or login from lunch break! Please contact administrator.');
				else:
					# if no, set am_timeout
					$am_timeout = $dtrlog;
					$err_message = array('strSuccessMsg','You have successfully Logged-OUT !!!');
				endif;
			else:
				# else, check if allow 30 mins, if yes, check if am_timeout is within 30 minutes
				if($has_30mins_allow):
					if($dtrlog >= date('H:i:s', strtotime('+30 minutes', strtotime($empdtr['outAM'])))):
						# if yes, set pm_timein
						$pm_timein = $dtrlog;
						$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
					else:
						$err_message = array('strErrorMsg','You are not allow to login! Your login time should be on '.(date('H:i', strtotime('+30 minutes', strtotime($empdtr['outAM'])))).'. Please contact administrator.');
					endif;
				else:
					# else, set pm_timein
					$pm_timein = $dtrlog;
					$err_message = array('strSuccessMsg','You have successfully Logged-IN !!!');
				endif;
			endif;
		else:
			return false;
		endif;

		return array('err_message' => $err_message, 'am_timeout' => $am_timeout, 'pm_timein' => $pm_timein);
	}

	function get_employee_attscheme($empid)
	{
		$res = $this->db->join('tblAttendanceScheme_online_dtr', 'tblAttendanceScheme_online_dtr.schemeCode = tblEmpPosition.schemeCode')
						->get_where('tblEmpPosition', array('empNumber' => $empid))->result_array();

		return count($res) > 0 ? $res[0] : array();
	}


	function update_nnbreak_time($empid,$dtrdate,$dtrlog,$is_intl)
	{
		$emp_att_scheme = $this->get_employee_attscheme($empid);
		$empdtr = $this->Attendance_summary_model->getcurrent_dtr($empid);

		
		$nn_out_from = $emp_att_scheme['nnTimeoutFrom'];
		$nn_out_to = $emp_att_scheme['nnTimeoutTo'];
		$nn_in_from = $emp_att_scheme['nnTimeinFrom'];
		$nn_in_to = $emp_att_scheme['nnTimeinTo'];

		$sql_str = "";

		if($is_intl)
		{
			$coldate = $dtrdate;
			$coldate_log = $dtrdate . " " . $dtrlog;
			$edit_date = $dtrdate . " " . $dtrlog .  " A";
		}
		else
		{
			$coldate = date('Y-m-d');
			$coldate_log = date('Y-m-d H:i:s');
			$edit_date = date('Y-m-d H:i:s A');
		}

		// check if have dtr today regarding out/in notification error
		$empdtr_today = $this->Attendance_summary_model->getEmployee_dtr($empid,$coldate,$coldate);

		$dtrid = count($empdtr) > 0 ? $empdtr['id']  == '' ? '' : $empdtr['id'] : '';
		$am_timein  = count($empdtr) > 0 ? $empdtr['inAM']  == '' || $empdtr['inAM']  == '00:00:00' ? '' : $empdtr['inAM'] : '';
		$am_timeout = count($empdtr) > 0 ? $empdtr['outAM'] == '' || $empdtr['outAM'] == '00:00:00' ? '' : $empdtr['outAM'] : '';
		$pm_timein  = count($empdtr) > 0 ? $empdtr['inPM']  == '' || $empdtr['inPM']  == '00:00:00' ? '' : $empdtr['inPM'] : '';
		$pm_timeout = count($empdtr) > 0 ? $empdtr['outPM'] == '' || $empdtr['outPM'] == '00:00:00' ? '' : $empdtr['outPM'] : '';
		$ot_timein  = count($empdtr) > 0 ? $empdtr['inOT']  == '' || $empdtr['inOT']  == '00:00:00' ? '' : $empdtr['inOT'] : '';
		$ot_timeout = count($empdtr) > 0 ? $empdtr['outOT'] == '' || $empdtr['outOT'] == '00:00:00' ? '' : $empdtr['outOT'] : '';

		// $has_30mins_allow = $emp_att_scheme['allow30'];
		// $is_strict = $emp_att_scheme['strict'];

		$is_strict = $att_scheme_ini[0]['strict'] == 'Y' ? 1 : 0;
		$has_30mins_allow = $att_scheme_ini[0]['allow30'] == 'Y' ? 1 : 0;

		$res = array();
		if(strtotime($dtrlog) >= strtotime($nn_out_from) && strtotime($dtrlog) <= strtotime($nn_in_to)):
			if($has_30mins_allow && $is_strict):
				$res = array('strErrorMsg','You are not allow to use asterisk (*)! Your log noon time should have 30 minutes distance. Please contact administrator.');
			else:
				if($has_30mins_allow && !$is_strict):
					$res = array('strErrorMsg','You are not allow to use asterisk (*)! Your log noon time should have 30 minutes distance. Please contact administrator.');
				elseif(!$has_30mins_allow && $is_strict):
					if(strtotime($dtrlog) >= strtotime($nn_out_from) || strtotime($dtrlog) > strtotime($nn_in_to)):
						$res = array('strErrorMsg','You are not allow to logout for or login from lunch break! Please contact administrator.');
					else:
						$msg = array();
						$warn = 0;
						
						if($am_timeout=='' && $empdtr_today!=''):
							if($dtrid!=''):
								$sql_str = $this->Attendance_summary_model->edit_dtrkios(array('outAM' => $dtrlog), $dtrid);
								$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => count($res) > 0 ? $res[1] : '' , 'log_ip' => $this->input->ip_address()));
							else:
								$arrdtr = array('empNumber' => $empid, 'dtrDate' => $coldate, 'outAM' => $dtrlog);
								$sql_str = $this->Attendance_summary_model->add_dtrkios($arrdtr);
								$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => count($res) > 0 ? $res[1] : '' , 'log_ip' => $this->input->ip_address()));
							endif;
						elseif($am_timeout!='' && $empdtr_today!=''):
							array_push($msg, '<li>You already have AM OUT!!!</li>');
							$warn = $warn + 1;
						else:
							array_push($msg, "<li>You don&apos;t have AM IN!!!</li>");
							$warn = $warn + 1;
						endif;

						if($pm_timein=='' && $empdtr_today!=''):
							if($dtrid!=''):
								$sql_str = $this->Attendance_summary_model->edit_dtrkios(array('inPM' => $dtrlog), $dtrid);
								$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => count($res) > 0 ? $res[1] : '' , 'log_ip' => $this->input->ip_address()));
							else:
								$arrdtr = array('empNumber' => $empid, 'dtrDate' => $coldate, 'inPM' => $dtrlog);
								$sql_str = $this->Attendance_summary_model->add_dtrkios($arrdtr);
								$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => count($res) > 0 ? $res[1] : '' , 'log_ip' => $this->input->ip_address()));
							endif;
						elseif($pm_timein!='' && $empdtr_today!=''):
							array_push($msg, '<li>You already have PM IN!!!</li>');
							$warn = $warn + 1;
						else:
							$warn = $warn + 1;
						endif;

						if($warn > 0):
							$res = array('err_message' => array('strMsg',implode(' ',$msg)));
						else:
							$res = array('err_message' => array('strSuccessMsg','You have successfully Logged-IN !!!'));
						endif;
					endif;
				else:
					$msg = array();
					$warn = 0;
					if($dtrid!=''):
						// combined am out and pm in to one query
						if($am_timeout=='' && $pm_timein=='' && $empdtr_today!=''):
							$sql_str = $this->Attendance_summary_model->edit_dtrkios(array('outAM' => $dtrlog, 'inPM' => $dtrlog), $dtrid);
						elseif($am_timeout!='' && $pm_timein=='' && $empdtr_today!=''):
							array_push($msg, '<li>You already have AM OUT!!!</li>');
							$warn = $warn + 1;
						elseif($pm_timein!='' && $am_timeout=='' && $empdtr_today!=''):
							array_push($msg, '<li>You already have PM IN!!!</li>');
							$warn = $warn + 1;
						elseif($empdtr_today==''):
							array_push($msg, "<li>You don&apos;t have AM IN!!!</li>");
							$warn = $warn + 1;
						else:
							array_push($msg, "<li>You already have AM OUT and PM IN!!!</li>");
							$warn = $warn + 1;
						endif;

						// if($pm_timein=='' && $empdtr_today!=''):
						// 	$sql_str = $this->Attendance_summary_model->edit_dtrkios(array('inPM' => $dtrlog), $dtrid);
						// elseif($pm_timein!='' && $empdtr_today!=''):
						// 	array_push($msg, '<li>You already have PM IN!!!</li>');
						// 	$warn = $warn + 1;
						// else:
						// 	$warn = $warn + 1;
						// endif;

						if($warn > 0):
							$res = array('err_message' => array('strMsg',implode(' ',$msg)));
						else:
							$res = array('err_message' => array('strSuccessMsg','You have successfully Logged-OUT-IN !!!'));
						endif;
					else:
						$arrdtr = array('empNumber' => $empid, 'dtrDate' => $coldate, 'outAM' => $dtrlog, 'inPM' => $dtrlog);
						$sql_str = $this->Attendance_summary_model->add_dtrkios($arrdtr);
						$res = array('err_message' => array('strSuccessMsg','You have successfully Logged-IN !!!'));
					endif;
				endif;
			endif;
		else:
			$res = array('err_message' => array('strErrorMsg','Invalid use of asterisk (*), Please try again without asterisk.'));
		endif;

		$this->Attendance_summary_model->add_dtr_log(array('empNumber' => $empid, 'log_date' => $coldate_log, 'log_sql' => $sql_str, 'log_notify' => count($res) > 0 ? $res['err_message'][1]: '' , 'log_ip' => $this->input->ip_address()));

		return $res['err_message'];
	}

	function check_dtr_for_hcd($empid,$dtrdate,$dtrlog,$is_intl)
	{
		if($is_intl)
		{
			$coldate = $dtrdate;
			$coldate_log = $dtrdate . " " . $dtrlog;
			$edit_date = $dtrdate . " " . $dtrlog .  " A";
		}
		else
		{
			$coldate = date('Y-m-d');
			$coldate_log = date('Y-m-d H:i:s');
			$edit_date = date('Y-m-d H:i:s A');
		}

		$this->db->where('empNumber', $empid);
		$this->db->where("dtrDate",$dtrdate);
		$emphcd = $this->db->get('tblOnlineDTR_HCD')->result_array();
		
		$empdtr = $this->Attendance_summary_model->getEmployee_dtr($empid,$coldate,$coldate);

		return count($emphcd) == 0 ? 2 : 1;
	}

	public function update_wfh($id,$empnumber,$dtrdate)
	{
		$type = $this->db->get_where('tblOnlineDTR_HCD',array('qn_id' => $qsn_id))->row()->qn_type;
	}

}
