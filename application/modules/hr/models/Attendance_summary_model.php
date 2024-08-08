<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Attendance_summary_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function getData($dtrid)
	{
		$res = $this->db->get_where('tblEmpDTR',array('id' => $dtrid))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function getdtr_log($log_date)
	{
		$this->db->where("log_date like '".$log_date."%'");
		$res = $this->db->get('tblEmpDTR_log')->result_array();
		return $res;
	}

	function getflag_ceremony($flag_date)
	{
		$this->db->where("flag_datetime like '".$flag_date."%'");
		$res = $this->db->get('tblFlagCeremony')->result_array();
		return $res;
	}

	function edit_dtr($arrData, $dtrid)
	{
		$this->db->where('id', $dtrid);
		$this->db->update('tblEmpDTR', $arrData);
		
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function edit_dtrkios($arrData, $dtrid)
	{
		$arrData = $this->convert_to_standardtime($arrData); //comment if v10

		$this->db->where('id', $dtrid);
		$this->db->update('tblEmpDTR', $arrData);
		
		return $this->db->last_query();
	}

	public function add_dtr($arrData)
	{
		$this->db->insert('tblEmpDTR', $arrData);
		return $this->db->insert_id();		
	}

	public function add_dtrkios($arrData)
	{
		$arrData = $this->convert_to_standardtime($arrData); //comment if v10

		$this->db->insert('tblEmpDTR', $arrData);
		return $this->db->last_query();
	}

	public function add_dtr_log($arrData)
	{
		$this->db->insert('tblEmpDTR_log', $arrData);
		return $this->db->insert_id();		
	}

	//retrieve eto for dtr
	function get_eto_dtr($empno, $etodate){
		$this->db->where('empNumber', $empno);
		$this->db->where('requestStatus', 'CERTIFIED');
		$res = $this->db->get('tblEmpRequest')->result_array();
		return $res;

	}


	function getEmployee_dtr($empid,$sdate,$edate)
	{
		$this->db->where('empNumber', $empid);
		if($sdate == $edate){
			$this->db->where("dtrDate",$sdate);
		}else{
			$this->db->where("dtrDate BETWEEN '".$sdate."' AND '".$edate."'");
		}
		$res = $this->db->get('tblEmpDTR')->result_array();
		$res = $this->convert_to_militarytime($res); //comment if v10
		
		if(count($res) > 0){
			return $res;
		}else{
			return null;
		}
	}

	function getcurrent_dtr($empid)
	{
		$this->db->where('empNumber', $empid);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$res = $this->db->get('tblEmpDTR')->row_array(); //from result_array();
		$res = $this->convert_to_militarytime($res); //comment if v10

		return $res;
	}


	function getcurrent_dtr201($empid,$thedate)
	{
		$this->db->where('empNumber', $empid);
		$this->db->where('dtrDate', $thedate);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$res = $this->db->get('tblEmpQRScan')->result_array(); //from result_array();
		$res = $this->convert_to_militarytime($res); //comment if v10

		return $res;
	}
	function getdtr_bydate($yr,$month)
	{
		$this->db->where("dtrDate like '".$yr."-".$month."%'");
		return $this->db->get('tblEmpDTR')->result_array();
	}

	function getincomplete_dtr($yr,$month)
	{
		$this->db->where("empNumber NOT IN (SELECT empNumber FROM tblEmpDTR WHERE dtrDate like '".$yr."-".$month."%')");
		$this->db->where('statusOfAppointment', 'In-Service');
		return $this->db->get('tblEmpPosition')->result_array();
	}

	public function getemp_dtr($empid, $datefrom, $dateto)
	{
		// echo '<pre>';
		$this->load->model(array('libraries/Holiday_model','employee/Official_business_model','finance/Dtr_model','employee/Travelorder_model','employee/Leave_model','libraries/Attendance_scheme_model','employee/Compensatory_leave_model'));
		$this->load->helper('dtr_helper');

		# Begin Broken Schedule
		$broken_sched = $this->Attendance_summary_model->getBrokenschedules($empid, $datefrom, $dateto);
		# End Broken Schedule
		
		# DTR Data
		$arrData = $this->Dtr_model->getData($empid,0,0,$datefrom,$dateto);
		$reg_holidays = $this->Holiday_model->getAllHolidates($empid,$datefrom,$dateto);
		$work_suspensions = $this->Holiday_model->get_work_suspension($datefrom,$dateto);
		
		$arr_first_days = $this->get_the_firstday_ofthe_week($datefrom,$dateto,$reg_holidays);
		
		$arrDataOb = $this->Official_business_model->getEmployeeOB($empid,$datefrom,$dateto);
		$arrOb = array();
		foreach($arrDataOb as $data_ob):
			foreach(dateRange($data_ob['obDateFrom'],$data_ob['obDateTo']) as $ob_date):
				$arrOb[] = array_merge($data_ob,array('obdate' => $ob_date));
			endforeach;
		endforeach;

		$arrDataTo = $this->Travelorder_model->getEmployeeTO($empid,$datefrom,$dateto);
		$arrTo = array();
		foreach($arrDataTo as $data_to):
			foreach(dateRange($data_to['toDateFrom'],$data_to['toDateTo']) as $to_date):
				$arrTo[] = array_merge($data_to,array('todate' => $to_date));
			endforeach;
		endforeach;

		$arrDataLeaves = $this->Leave_model->getleave($empid,$datefrom,$dateto);
		$arrLeaves = array();
		foreach($arrDataLeaves as $data_leave):
			foreach(dateRange($data_leave['leaveFrom'],$data_leave['leaveTo']) as $leave_date):
				if(!(in_array($leave_date,$reg_holidays) || in_array(date('D',strtotime($leave_date)),array('Sat','Sun')))):
					$arrLeaves[] = array_merge($data_leave,array('leavedate' => $leave_date));
				endif;
			endforeach;
		endforeach;
		
		$emp_dtr = array();
		$work_hrs = 0;
		foreach(dateRange($datefrom,$dateto) as $dtrdate):
			$emp_cto = array();
			$att_scheme = $this->Attendance_scheme_model->getAttendanceScheme($empid);
			$att_scheme_temp = $att_scheme;

			$bs_sched = array();
			if(count($broken_sched) > 0):
				foreach($broken_sched as $bs):
					if($dtrdate >= $bs['dateFrom'] && $dtrdate <= $bs['dateTo']){
						$att_scheme = $bs;
						$att_scheme_temp = $att_scheme;
						$bs_sched['scheme'] = $bs['schemeType'];
						$bs_sched['from'] = $bs['amTimeinFrom'];
						$bs_sched['to'] = $bs['pmTimeoutTo'];
					}
				endforeach;
			endif;
			
			$work_hrs = 0;
			# Begin DTR
			$dtr = array();
			if(in_array($dtrdate,array_column($arrData,'dtrDate'))):
				$dtr = $arrData[array_search($dtrdate, array_column($arrData, 'dtrDate'))];
			endif;
			# End DTR

			# Begin OB
			$obs = array();
			if(in_array($dtrdate,array_column($arrOb,'obdate'))):
				$ob_list  = array_intersect(array_column($arrOb,'obdate'),array($dtrdate));
				foreach($ob_list as $key=>$oblist):
					$obs[] = $arrOb[$key];
				endforeach;
			endif;
			# End OB

			# Begin TO
			$tos = array();
			if(in_array($dtrdate,array_column($arrTo,'todate'))):
				$to_list  = array_intersect(array_column($arrTo,'todate'),array($dtrdate));
				foreach($to_list as $key=>$tolist):
					$tos[] = $arrTo[$key];
				endforeach;
			endif;
			# End TO

			# Begin Leave
			$leaves = array();
			if(in_array($dtrdate,array_column($arrLeaves,'leavedate'))):
				$leave_list  = array_intersect(array_column($arrLeaves,'leavedate'),array($dtrdate));
				foreach($leave_list as $key=>$leavelist):
					$leaves[] = $arrLeaves[$key];
				endforeach;
			endif;
			# End Leave

			$temp_dtr = $dtr;
			# Begin Late and UnderTime
			$lates = 0;
			$utimes = 0;
			if(!empty($dtr)):
				if($dtr['remarks'] == 'CL'):
					$emp_cto = $this->Compensatory_leave_model->get_emp_cto($dtr['id']);
				endif;

				if(in_array($dtrdate,$arr_first_days)):
					$flag_ceremony_time = flag_ceremony_time();
					if($flag_ceremony_time != '' && $flag_ceremony_time != '00:00:00'):
						$att_scheme['amTimeinTo'] = $flag_ceremony_time;
						$att_scheme['pmTimeoutTo'] = date('H:i:s', strtotime($flag_ceremony_time) + 60*60*9);
					endif;
				else:
					$att_scheme['amTimeinTo'] = $att_scheme_temp['amTimeinTo'];
					$att_scheme['pmTimeoutTo'] = $att_scheme_temp['pmTimeoutTo'];
				endif;

				# Added checking of OB incase there is and if has existing DTR
				if(count($obs) > 0):
					$arr_ob_timein = $this->check_obtime_in($att_scheme,$obs);
					$arr_ob_timeout = $this->check_obtime_out($att_scheme,$obs);

					$dtr['dtrDate'] = $dtrdate;
					$dtr['inAM'] = strtotime($dtr['inAM']) <= strtotime($arr_ob_timein['in_am']) ? $dtr['inAM'] : $arr_ob_timein['in_am'];
					$dtr['outAM'] = $arr_ob_timeout['out_am'];
					$dtr['inPM'] = $arr_ob_timein['in_pm'];
					$dtr['outPM'] = strtotime($dtr['outPM']) >= strtotime(date('h:i', strtotime($arr_ob_timeout['out_pm']))) ? $dtr['outPM'] : date('h:i', strtotime($arr_ob_timeout['out_pm']));
					$dtr['inOT'] = '';
					$dtr['outOT'] = '';
				endif;	

				$work_hrs = $this->compute_working_hours($att_scheme,$dtr);
			else:
				# NO DTR VALUE;
				# Check OB
				if(count($obs) > 0):
					$arr_ob_timein = $this->check_obtime_in($att_scheme,$obs);
					$arr_ob_timeout = $this->check_obtime_out($att_scheme,$obs);
					
					$dtr['dtrDate'] = $dtrdate;
					$dtr['inAM'] = $arr_ob_timein['in_am'];
					$dtr['outAM'] = $arr_ob_timeout['out_am'];
					$dtr['inPM'] = $arr_ob_timein['in_pm'];
					$dtr['outPM'] = date('h:i', strtotime($arr_ob_timeout['out_pm']));
					$dtr['inOT'] = '';
					$dtr['outOT'] = '';
				endif;
				# CTO
			endif;

			# Begin work suspension
			$emp_ws = array();
			if(in_array($dtrdate,array_column($work_suspensions,'holidayDate'))):
				$ws_list  = array_intersect(array_column($work_suspensions,'holidayDate'),array($dtrdate));
				foreach($ws_list as $key=>$wslist):
					$emp_ws[] = $work_suspensions[$key];
				endforeach;
			endif;
			# End work suspension


			# No lates and undertime for Weekends and Holidays
			if(!(in_array($dtrdate,$reg_holidays) || in_array(date('D',strtotime($dtrdate)),array('Sat','Sun')))):
				$lates = $this->compute_late($att_scheme,$dtr);
				$utimes = $this->compute_undertime($emp_ws,$att_scheme,$dtr);
			endif;
			# End Late

			# Begin Compute Overtime
			$ot = 0;
			// print_r($dtr);
			if(in_array($dtrdate,$reg_holidays) || in_array(date('D',strtotime($dtrdate)),array('Sat','Sun'))):
				# weekend and holiday ot
				if(!empty($dtr)):
					$ot = $this->compute_working_hours($att_scheme,$dtr);
				endif;

			else:
				# regular days ot; if dtr is not empty, and no lates or undertime; 
				if(!empty($dtr) && ($lates+$utimes) < 1):
					$ot = $this->compute_overtime($att_scheme,$dtr);
				endif;
			endif;
			# End Compute Overtime



			# Begin Data for Holiday
			$holiday_name = array();
			if(in_array($dtrdate,$reg_holidays)):
				$holiday_name = $this->Holiday_model->getHolidayDetails($dtrdate);
			endif;
			# End Data for Holiday
			
			# Begin Data Array
			$dtr = $temp_dtr;
			$day = date('D', strtotime($dtrdate));
			
			$emp_dtr[] = array('day' => $day, 'dtrdate' => $dtrdate, 'dtr' => $dtr, 'obs' => $obs, 'tos' => $tos, 'leaves' => $leaves, 'lates' => $lates, 'utimes' => $utimes, 'ot' => $ot, 'holiday_name' => $holiday_name, 'emp_ws' => $emp_ws, 'broken_sched' => $bs_sched, 'work_hrs' => $work_hrs,'att_scheme'=>$att_scheme, 'emp_cto' => $emp_cto);
			# End Data Array
			// echo '<hr>';
		endforeach;
		// print_r($emp_dtr);
		// die();
		return $emp_dtr;
	}

	# Begin Broken Sched
	public function add_brokensched($arrData)
	{
		$this->db->insert('tblBrokenSched', $arrData);
		return $this->db->insert_id();		
	}

	function edit_brokensched($arrData, $id)
	{
		$this->db->where('rec_ID', $id);
		$this->db->update('tblBrokenSched', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_brokensched($id)
	{
		$this->db->where('rec_ID', $id);
		$this->db->delete('tblBrokenSched'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	public function getBrokenschedules($empid,$datefrom='',$dateto='')
	{
		$this->db->join('tblAttendanceScheme', 'tblAttendanceScheme.schemeCode = tblBrokenSched.schemeCode', 'left');
		if($datefrom !='' && $dateto !=''){
			$this->db->where("(dateFrom between '".$datefrom."' and '".$dateto."' or dateTo between '".$datefrom."' and '".$dateto."')");
		}
		$res = $this->db->get_where('tblBrokenSched', array('empNumber' => $empid))->result_array();
		return $res;
	}

	public function getSchedule($id)
	{
		return $this->db->get_where('tblBrokenSched', array('rec_ID' => $id))->result_array();
	}
	# End Broken Sched

	# Begin Broken Sched
	public function add_localholiday($arrData)
	{
		$this->db->insert('tblEmpLocalHoliday', $arrData);
		return $this->db->insert_id();		
	}

	function edit_localholiday($arrData, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('tblEmpLocalHoliday', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_localholiday($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tblEmpLocalHoliday');
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	public function getLocalHolidays($empid,$month='',$yr='')
	{
		$arrcond = array('empNumber' => $empid);
		if($month!='' && $yr!=''):
			$arrcond['holidayYear'] = $yr;
			$arrcond['holidayMonth'] = (int) $month;
		endif;
		$this->db->join('tblLocalHoliday', 'tblLocalHoliday.holidayCode = tblEmpLocalHoliday.holidayCode', 'left');
		return $this->db->get_where('tblEmpLocalHoliday', $arrcond)->result_array();
	}

	public function getHoliday($id)
	{
		return $this->db->get_where('tblEmpLocalHoliday', array('id' => $id))->result_array();
	}
	# End Broken Sched

	# Begin OB
	public function add_ob($arrData)
	{
		$this->db->insert('tblEmpOB', $arrData);
		$res = $this->db->insert_id();
		return $res;
	}

	function edit_ob($arrData, $id)
	{
		$this->db->where('obID', $id);
		$this->db->update('tblEmpOB', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_ob($id)
	{
		$this->db->where('obID', $id);
		$this->db->delete('tblEmpOB');
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	public function getobs($empid, $ddate='',$dtr=0)
	{
		$this->db->where('tblEmpOB.empNumber', $empid);
		if($dtr==0){
			$this->db->where('requestStatus', 'Certified');
			$this->db->where('requestCode', 'OB');	
		}
		
		if($ddate != ''):
			$this->db->where("('".$ddate."' >= obDateFrom and '".$ddate."' <= obDateTo)");
		endif;

		if($dtr==0){
			$this->db->join('tblEmpRequest', 'tblEmpRequest.empNumber = tblEmpOB.empNumber', 'left');
		}
		$res = $this->db->get('tblEmpOB')->result_array();

		return $res;
	}

	public function getOb($id)
	{
		return $this->db->get_where('tblEmpOB', array('obID' => $id))->result_array();
	}
	# End OB

	# Begin Leave
	public function add_leave($arrData)
	{
		$this->db->insert('tblEmpLeave', $arrData);
		return $this->db->insert_id();		
	}

	function edit_leave($arrData, $id)
	{
		$this->db->where('leaveID', $id);
		$this->db->update('tblEmpLeave', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_leave($id)
	{
		$this->db->where('leaveID', $id);
		$this->db->delete('tblEmpLeave');
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	public function getleaves($empid,$leavetype='',$ddate='')
	{
		$this->db->where('tblEmpLeave.empNumber', $empid);
		$this->db->where('requestStatus', 'Certified');
		if($leavetype != ''):
			$this->db->where('tblEmpLeave.leaveCode', $leavetype);
		endif;
		if($ddate != ''):
			$this->db->where("('".$ddate."' >= leaveFrom and '".$ddate."' <= leaveTo)");
		endif;
		$this->db->join('tblEmpRequest', 'tblEmpRequest.empNumber = tblEmpLeave.empNumber', 'left');
		$this->db->join('tblLeave', 'tblLeave.leaveCode = tblEmpLeave.leaveCode', 'left');
		return $this->db->get('tblEmpLeave')->result_array();
	}

	public function getLeave($id)
	{
		$this->db->join('tblLeave', 'tblLeave.leaveCode = tblEmpLeave.leaveCode', 'left');
		return $this->db->get_where('tblEmpLeave', array('leaveID' => $id))->result_array();
	}

	public function getSpecificLeave($type)
	{
		return $this->db->get_where('tblSpecificLeave', array('leaveCode' => $type))->result_array();
	}

	public function getTotalnoofdays($leavefrom,$leaveto)
	{
		$totaldays = 0;
		while (strtotime($leavefrom) <= strtotime($leaveto)) {
			$validday = date('D', strtotime($leavefrom)); # holiday no included
			if($validday != 'Sat' && $validday != 'Sun'){
				$totaldays++;
			}
			$leavefrom = date ("Y-m-d", strtotime("+1 day", strtotime($leavefrom)));
		}
		return $totaldays;
	}
	# End Leave

	# Begin Compensatory Leave
	function edit_comp_leave($arrData, $empnumber, $dtrdate)
	{
		$this->db->where('empNumber', $empnumber);
		$this->db->where('dtrDate', $dtrdate);
		$this->db->update('tblEmpDTR', $arrData);
		if($this->db->affected_rows() > 0):
			$res = $this->db->get_where('tblEmpDTR', array('dtrDate' => $dtrdate))->result_array();
			return $res[0]['id'];
		else:
			return 0;
		endif;

	}

	public function getcomp_leaves($empid)
	{
		return $this->db->get_where('tblEmpDTR', array('empNumber' => $empid, 'remarks' => 'CL'))->result_array();
	}
	# End Compensatory Leave

	# Begin Time
	function edit_dtrTime($arrData, $empnumber, $dtrdate)
	{
		$this->db->where('empNumber', $empnumber);
		$this->db->where('dtrDate', $dtrdate);
		$this->db->update('tblEmpDTR', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	public function getdtrTimes($empid)
	{
		return $this->db->get_where('tblEmpDTR', array('empNumber' => $empid, 'remarks' => ''))->result_array();
	}
	# End Time

	# Begin Travel Order
	public function add_to($arrData)
	{
		$this->db->insert('tblEmpTravelOrder', $arrData);
		return $this->db->insert_id();		
	}

	function edit_to($arrData, $id)
	{
		$this->db->where('toID', $id);
		$this->db->update('tblEmpTravelOrder', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete_to($id)
	{
		$this->db->where('toID', $id);
		$this->db->delete('tblEmpTravelOrder');
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	public function gettos($empid,$ddate='')
	{
		$this->db->where('tblEmpTravelOrder.empNumber', $empid);
		// $this->db->where('LCASE(\'requestStatus\')', 'certified');
		// $this->db->where('requestCode', 'TO');

		if($ddate != ''):
			$this->db->where("('".$ddate."' >= toDateFrom and '".$ddate."' <= toDateTo)");
		endif;
		// $this->db->join('tblEmpRequest', 'tblEmpRequest.empNumber = tblEmpTravelOrder.empNumber', 'left');
		return $this->db->get('tblEmpTravelOrder')->result_array();
	}

	public function getTo($id)
	{
		return $this->db->get_where('tblEmpTravelOrder', array('toID' => $id))->result_array();
	}
	# End Travel Order

	# Begin Flag Ceremony
	public function add_flagcrmy($arrData)
	{
		$this->db->insert('tblEmpDTR', $arrData);
		return $this->db->insert_id();		
	}

	function edit_flagcrmy($arrData, $empnumber, $dtrdate)
	{
		$this->db->where('empNumber', $empnumber);
		$this->db->where('dtrDate', $dtrdate);
		$this->db->update('tblEmpDTR', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	public function getflagcrmys($empid)
	{
		return $this->db->get_where('tblEmpDTR', array('empNumber' => $empid, 'remarks' => 'FC'))->result_array();
	}

	public function getFlagcrmy($id)
	{
		return $this->db->get_where('tblEmpDTR', array('id' => $id))->result_array();
	}

	public function checkEntry($empid, $dtrdate)
	{
		return $this->db->get_where('tblEmpDTR', array('empNumber' => $empid, 'dtrDate' => $dtrdate))->result_array();
	}
	# End Flag Ceremony

	# begin offset balance
	public function getOffsetBalance($empid, $month, $yr)
	{
		echo '<pre>';
		$offbal = $this->db->get_where('tblEmpLeaveBalance', array('empNumber' => $empid, 'periodMonth' => $month, 'periodYear' => $yr))->result_array();
		$offbal = count($offbal) > 0 ? $offbal[0]['off_bal'] : 0;
		print_r($offbal);
		die();
	}
	# end offset balance

	function get_the_firstday_ofthe_week($datefrom,$dateto,$holidays)
	{
		$array_first_day_of_theweek = array();
		foreach(get_day($datefrom,$dateto,1) as $mdate):
			$week_firstday = '';
			$monday = $mdate;
			$friday = date('Y-m-d', strtotime('friday this week', strtotime($mdate)));
			$weekdates = dateRange($monday,$friday);
			$not_holidays = $this->sort_date(array_diff($weekdates,$holidays));

			if(count($not_holidays) > 0):
				$week_firstday = $not_holidays[0];
			endif;
			array_push($array_first_day_of_theweek,$week_firstday);
		endforeach;

		return $array_first_day_of_theweek;
	}

	function sort_date($arrDates)
	{
		usort($arrDates, "date_sort");
		return $arrDates;
	}

	function compute_late($att_scheme,$dtr)
	{
		if(!empty($dtr)):
			# Attendance Scheme
			// $sc_am_timein_from = date('H:i',strtotime($att_scheme['amTimeinFrom'].' AM'));
			$sc_am_timein_to = $att_scheme['amTimeinTo'];
			$sc_nn_timein_from = $att_scheme['nnTimeinFrom'];
			$sc_nn_timein_to = date('H:i',strtotime($att_scheme['nnTimeinTo'].' PM'));
			// $sc_pm_timeout_from = date('H:i',strtotime($att_scheme['pmTimeoutFrom'].' PM'));
			// $sc_pm_timeout_to = date('H:i',strtotime($att_scheme['pmTimeoutTo'].' PM'));
			
			# DTR Data
			$am_timein 	= date('H:i',strtotime($dtr['inAM']));
			$am_timeout = $dtr['outAM'] == '' || $dtr['outAM'] == '00:00:00' ? $sc_nn_timein_from : date('H:i',strtotime($dtr['outAM']));
			$pm_timein 	= $dtr['inPM'] == '' || $dtr['inPM'] == '00:00:00' ? $sc_nn_timein_from : date('H:i',strtotime($dtr['inPM']));
			$pm_timeout = date('H:i',strtotime($dtr['outPM']));
			
			# morning Late
			$am_late = 0;
			if($am_timein > $sc_am_timein_to):
				$am_late = toMinutes($am_timein) - toMinutes($sc_am_timein_to);
			endif;

			# afternoon Late
			$pm_late = 0;
			if($pm_timein > $sc_nn_timein_to):
				$pm_late = toMinutes($pm_timein) - toMinutes($sc_nn_timein_to);
			endif;

			return ($am_late + $pm_late);
		else:
			return 0;
		endif;
	}

	function compute_undertime($emp_ws,$att_scheme,$dtr)
	{
		if(!empty($dtr)):
			# Attendance Scheme
			$sc_am_timein_from = $att_scheme['amTimeinFrom'];
			$sc_am_timein_to = $att_scheme['amTimeinTo'];
			$sc_nn_timein_from = $att_scheme['nnTimeinFrom'];
			$sc_nn_timein_to = $att_scheme['nnTimeinTo'];
			$sc_pm_timeout_from = $att_scheme['pmTimeoutFrom'];
			// $sc_pm_timeout_to = date('H:i',strtotime($att_scheme['pmTimeoutTo'].' PM'));

			$req_hours = toMinutes($sc_pm_timeout_from) - toMinutes($sc_am_timein_from);
			
			# DTR Data
			$am_timein 	= date('H:i',strtotime($dtr['inAM']));
			$am_timeout = $dtr['outAM'] == '' || $dtr['outAM'] == '00:00:00' ? $sc_nn_timein_from : date('H:i',strtotime($dtr['outAM']));
			$pm_timein 	= $dtr['inPM'] == '' || $dtr['inPM'] == '00:00:00' ? $sc_nn_timein_from : date('H:i',strtotime($dtr['inPM']));
			$pm_timeout = $dtr['outPM'] == '' || $dtr['outPM'] == '00:00:00' ? '' : date('H:i',strtotime($dtr['outPM']));

			# Get Expected Timeout
			$expctd_pm_timeout = 0;
			if($am_timein < $sc_am_timein_from):
				$expctd_pm_timeout = date('H:i:s', strtotime('+'.$req_hours.' minutes', strtotime($sc_am_timein_from)));
			elseif($am_timein > $sc_am_timein_to):
				$expctd_pm_timeout = date('H:i:s', strtotime('+'.$req_hours.' minutes', strtotime($sc_am_timein_to)));
			else:
				$expctd_pm_timeout = date('H:i:s', strtotime('+'.$req_hours.' minutes', strtotime($am_timein)));
			endif;

			if(count($emp_ws) > 0):
				if($emp_ws[0]['holidayTime'] >= $sc_nn_timein_from):
					$expctd_pm_timeout = date('H:i', strtotime($emp_ws[0]['holidayTime']));
				else:
					$sc_nn_timein_from = date('H:i', strtotime($emp_ws[0]['holidayTime']));
					$expctd_pm_timeout = date('H:i', strtotime($emp_ws[0]['holidayTime']));
				endif;
			endif;

			# AM Undertime
			$am_utime = 0;
			if($am_timeout < $sc_nn_timein_from):
				$am_utime = toMinutes($sc_nn_timein_from) - toMinutes($am_timeout);
			endif;

			# PM Undertime
			$pm_utime = 0;
			if($expctd_pm_timeout > $sc_nn_timein_to):
				if($pm_timeout < $expctd_pm_timeout):
					if($pm_timeout  == '' || $pm_timeout  == '00:00'):
						$pm_utime = toMinutes($expctd_pm_timeout) - toMinutes($sc_nn_timein_to);
					else:
						$pm_utime = toMinutes($expctd_pm_timeout) - toMinutes($pm_timeout);
					endif;
				endif;
			endif;
			
			return ($am_utime + $pm_utime);
		else:
			return 0;
		endif;
	}

	function check_obtime_in($att_scheme,$obs)
	{
		# Attendance Scheme
		$sc_nn_timein_from = $att_scheme['nnTimeinFrom'];

		$in_am = '';
		$in_pm = '';

		foreach($obs as $ob):
			$ob_time_in = date('H:i',strtotime($ob['obTimeFrom']));

			if($ob_time_in >= $sc_nn_timein_from):
				if($in_pm == ''):
					$in_pm = $ob_time_in;
				else:
					if($ob_time_in < $in_pm):
						$in_pm = $ob_time_in;
					endif;
				endif;
			else:
				if($in_am == ''):
					$in_am = $ob_time_in;
				else:
					if($ob_time_in < $in_am):
						$in_am = $ob_time_in;
					endif;
				endif;
			endif;

		endforeach;

		return array('in_am' => $in_am, 'in_pm' => $in_pm);
	}

	function check_obtime_out($att_scheme,$obs)
	{
		# Attendance Scheme
		$sc_nn_timein_from = $att_scheme['nnTimeinFrom'];
		$sc_nn_timein_to = $att_scheme['nnTimeinTo'];

		$out_am = '';
		$out_pm = '';

		foreach($obs as $ob):
			$ob_time_out = date('H:i',strtotime($ob['obTimeTo']));

			if($ob_time_out >= $sc_nn_timein_from && $ob_time_out <= $sc_nn_timein_to):
				if($out_am == ''):
					$out_am = $ob_time_out;
				else:
					if($ob_time_out > $out_am):
						if($ob_time_out > $out_pm):
							$out_am = $out_pm;
							$out_pm = $ob_time_out;
						else:
							$out_am = $ob_time_out;
						endif;
					endif;
				endif;
			else:
				if($ob_time_out > $sc_nn_timein_to):
					if($out_pm == ''):
						$out_pm = $ob_time_out;
					else:
						if($ob_time_out > $out_pm):
							$out_pm = $ob_time_out;
						endif;
					endif;
				else:
					if($out_am == ''):
						$out_am = $ob_time_out;
					else:
						if($ob_time_out > $am_out):
							$out_am = $ob_time_out;
						endif;
					endif;
				endif;
			endif;

		endforeach;

		return array('out_am' => $out_am, 'out_pm' => $out_pm);

	}

	function compute_overtime($att_scheme,$dtr)
	{
		if(!empty($dtr)):
			# Attendance Scheme
			$sc_am_timein_from = $att_scheme['amTimeinFrom'];
			$sc_am_timein_to   = $att_scheme['amTimeinTo'];
			$sc_nn_timein_from = $att_scheme['nnTimeinFrom'];
			$sc_nn_timein_to   = $att_scheme['nnTimeinTo'];
			$sc_pm_timeout_from= $att_scheme['pmTimeoutFrom'];
			$sc_pm_timeout_to  = $att_scheme['pmTimeoutTo'];

			$req_hours = toMinutes($sc_pm_timeout_from) - toMinutes($sc_am_timein_from);
			
			# DTR Data
			$am_timein 	= $dtr['inAM'] == '' || $dtr['inAM'] == '00:00:00' ? '' : date('H:i',strtotime($dtr['inAM']));
			$am_timeout = $dtr['outAM'] == '' || $dtr['outAM'] == '00:00:00' ? $sc_nn_timein_from : date('H:i',strtotime($dtr['outAM']));
			$pm_timein 	= $dtr['inPM'] == '' || $dtr['inPM'] == '00:00:00' ? $sc_nn_timein_from : date('H:i',strtotime($dtr['inPM']));
			$pm_timeout = $dtr['outPM'] == '' || $dtr['outPM'] == '00:00:00' ? '' : date('H:i',strtotime($dtr['outPM']));
			$ot_timein  = $dtr['inOT'] == '' || $dtr['inOT'] == '00:00:00' ? '' : date('H:i',strtotime($dtr['inOT']));
			$ot_timeout = $dtr['outOT'] == '' || $dtr['outOT'] == '00:00:00' ? '' : date('H:i',strtotime($dtr['outOT']));

			$ot_details = array();
			$min_before_ot = 0;
			$max_ot = 0;
			$min_ot = 0;

			if($ot_timein == '' && $ot_timeout == ''):
				# Get Expected Timeout
				$expctd_pm_timeout = 0;
				if($am_timein < $sc_am_timein_from):
					$expctd_pm_timeout = date('H:i', strtotime('+'.$req_hours.' minutes', strtotime($sc_am_timein_from)));
				elseif($am_timein > $sc_am_timein_to):
					$expctd_pm_timeout = date('H:i', strtotime('+'.$req_hours.' minutes', strtotime($sc_am_timein_to)));
				else:
					$expctd_pm_timeout = date('H:i', strtotime('+'.$req_hours.' minutes', strtotime($am_timein)));
				endif;

				$ot_details = overtime_details();
				$min_before_ot = toMinutes($ot_details['minOT']);
				$max_ot = toMinutes($ot_details['maxOT']);
				$min_ot = toMinutes($ot_details['minOT']);

				$ot_pm_out = date('H:i', strtotime('+'.$min_before_ot.' minutes', strtotime($expctd_pm_timeout)));

				$ot_hrs = 0;
				if($pm_timeout > $ot_pm_out):
					$ot_hrs = toMinutes($pm_timeout) - toMinutes($ot_pm_out);
				endif;	

				# check if OT is greater than minutes before OT
				if($ot_hrs >= $min_before_ot):
					$ot_hrs = $ot_hrs - $min_before_ot;
					# removed excess hours of OT
					if($max_ot > 0):
						$ot_hrs = ($ot_hrs > $max_ot) ? $max_ot : $ot_hrs;
					endif;
				endif;
			else:
				$ot_hrs = toMinutes($ot_timeout) - toMinutes($ot_timein);
			endif;

			return ($ot_hrs >= $min_ot) ? $ot_hrs : 0;
		else:
			return 0;
		endif;
	}

	function compute_working_hours($att_scheme,$dtr)
	{
		if(!empty($dtr)):
			# Attendance Scheme
			$sc_am_timein_from  = $att_scheme['amTimeinFrom'];
			$sc_am_timein_to    = $att_scheme['amTimeinTo'];
			$sc_nn_timein_from  = $att_scheme['nnTimeinFrom'];
			$sc_nn_timein_to    = $att_scheme['nnTimeinTo'];
			$sc_pm_timeout_from = $att_scheme['pmTimeoutFrom'];
			$sc_pm_timeout_to   = $att_scheme['pmTimeoutTo'];

			$req_hours = toMinutes($sc_pm_timeout_from) - toMinutes($sc_am_timein_from);
			
			# DTR Data
			$am_timein 	= $dtr['inAM'] == '' || $dtr['inAM'] == '00:00:00' ? '' : date('H:i',strtotime($dtr['inAM']));
			$am_timeout = $dtr['outAM'] == '' || $dtr['outAM'] == '00:00:00' ? $sc_nn_timein_from : date('H:i',strtotime($dtr['outAM']));
			$pm_timein 	= $dtr['inPM'] == '' || $dtr['inPM'] == '00:00:00' ? $sc_nn_timein_from : date('H:i',strtotime($dtr['inPM']));
			$pm_timeout = $dtr['outPM'] == '' || $dtr['outPM'] == '00:00:00' ? '' : date('H:i',strtotime($dtr['outPM']));
			
			# Get Expected Timeout and official Time in
			$off_timein = '';
			if($am_timein < $sc_am_timein_from):
				$off_timein = $sc_am_timein_from;
			elseif($am_timein > $sc_am_timein_to):
				$off_timein = $sc_am_timein_to;
			else:
				$off_timein = $am_timein;
			endif;
			
			# get working hours
			$am_working_hours = 0;
			if($am_timein != ''):
				if($am_timeout >= $sc_nn_timein_from):
					$am_working_hours = toMinutes($sc_nn_timein_from) - toMinutes($am_timein);
				else:
					$am_working_hours = toMinutes($am_timeout) - toMinutes($off_timein);
				endif;
			endif;

			$pm_working_hours = 0;
			if($pm_timeout==''):
				$pm_working_hours = 0;	
			else:
				if($pm_timeout >= $sc_nn_timein_to):
					if($pm_timein >= $sc_nn_timein_to):
						$pm_working_hours = toMinutes($pm_timeout) - toMinutes($pm_timein);
					else:
						$pm_working_hours = toMinutes($pm_timeout) - toMinutes($sc_nn_timein_to);
					endif;
				else:
					$pm_working_hours = 0;
				endif;
			endif;

			return ($am_working_hours + $pm_working_hours);
		else:
			return 0;
		endif;
	}

	function convert_to_standardtime($arrData)
	{
		if(array_key_exists("inAM",$arrData))
			$arrData['inAM'] = ($arrData['inAM']  == '00:00:00' || $arrData['inAM']  == '') ? '00:00:00' : date('h:i:s',strtotime($arrData['inAM']));
		if(array_key_exists("outAM",$arrData))
			$arrData['outAM'] = ($arrData['outAM']  == '00:00:00' || $arrData['outAM']  ==  '') ? '00:00:00' : date('h:i:s',strtotime($arrData['outAM']));
		if(array_key_exists("inPM",$arrData))
			$arrData['inPM'] = ($arrData['inPM']  == '00:00:00' || $arrData['inPM']  ==  '') ? '00:00:00' : date('h:i:s',strtotime($arrData['inPM']));
		if(array_key_exists("outPM",$arrData))
			$arrData['outPM'] = ($arrData['outPM']  == '00:00:00' || $arrData['outPM']  ==  '') ? '00:00:00' : date('h:i:s',strtotime($arrData['outPM']));
		if(array_key_exists("inOT",$arrData))
			$arrData['inOT'] = ($arrData['inOT']  == '00:00:00' || $arrData['inOT']  ==  '') ? '00:00:00' : date('h:i:s',strtotime($arrData['inOT']));
		if(array_key_exists("outOT",$arrData))
			$arrData['outOT'] = ($arrData['outOT']  == '00:00:00' || $arrData['outOT']  ==  '') ? '00:00:00' : date('h:i:s',strtotime($arrData['outOT']));

		return $arrData;
	}

	function convert_to_militarytime($arrData)
	{
		if(array_key_exists("inAM",$arrData))
			$arrData['inAM'] = ($arrData['inAM']  == '00:00:00' || $arrData['inAM']  == '') ? '00:00:00' : date('H:i:s',strtotime($arrData['inAM']));
		if(array_key_exists("outAM",$arrData))
			$arrData['outAM'] = ($arrData['outAM']  == '00:00:00' || $arrData['outAM']  ==  '') ? '00:00:00' : date('H:i:s',strtotime($arrData['outAM']));
		if(array_key_exists("inPM",$arrData))
			$arrData['inPM'] = ($arrData['inPM']  == '00:00:00' || $arrData['inPM']  ==  '') ? '00:00:00' : date('H:i:s',strtotime($arrData['inPM']));
		if(array_key_exists("outPM",$arrData))
			$arrData['outPM'] = ($arrData['outPM']  == '00:00:00' || $arrData['outPM']  ==  '') ? '00:00:00' : date('H:i:s',strtotime($arrData['outPM']));
		if(array_key_exists("inOT",$arrData))
			$arrData['inOT'] = ($arrData['inOT']  == '00:00:00' || $arrData['inOT']  ==  '') ? '00:00:00' : date('H:i:s',strtotime($arrData['inOT']));
		if(array_key_exists("outOT",$arrData))
			$arrData['outOT'] = ($arrData['outOT']  == '00:00:00' || $arrData['outOT']  ==  '') ? '00:00:00' : date('H:i:s',strtotime($arrData['outOT']));

		return $arrData;
	}

	public function convert_dtrtime($col)
	{
		$sql = 'UPDATE tblEmpDTR SET '.$col.' = TIME_FORMAT('.$col.', "%h:%i:%s") WHERE '.$col.' != "00:00:00" AND '.$col.' IS NOT NULL'; 
        $query = $this->db->query($sql);
		$res = $this->db->affected_rows();
		return $res;
	}

}
/* End of file Dtr_model.php */
/* Location: ./application/modules/finance/models/Dtr_model.php */