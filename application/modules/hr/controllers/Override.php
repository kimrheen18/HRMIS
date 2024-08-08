<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Override extends MY_Controller {

	var $arrData;
	
	function __construct() {
        parent::__construct();
        $this->load->model(array('Override_model','libraries/Org_structure_model','libraries/Appointment_status_model','Hr_model','hr/Attendance_summary_model','pds/Pds_model','finance/Dtr_model'));
    }

	public function override_ob()
	{
		$this->arrData['arr_ob'] = $this->Override_model->get_override_ob();
		$this->template->load('template/template_view','attendance/override/override',$this->arrData);
	}

	public function override_ob_add()
	{
		$this->arrData['arrGroups'] = $this->Org_structure_model->getData_allgroups();
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrEmployees'] = $this->Hr_model->getData_byGroup();

		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$overrideData = array(
								 'override_type'=> 1,
								 'office_type'	=> $arrPost['seltype'],
								 'office'		=> $arrPost['txtoffice'],
								 'appt_status'	=> $arrPost['selappt'],
								 'created_date' => date('Y-m-d H:i:s'),
								 'created_by' 	=> $this->session->userdata('sessEmpNo'));
			$override_id = $this->Override_model->add($overrideData);

			foreach($arrPost['selemps'] as $emps):
				$arrData = array(
								'dateFiled'	 => date('Y-m-d'),
								'empNumber'	 => $emps,
								'obDateFrom' => $arrPost['ob_datefrom'],
								'obDateTo'	 => $arrPost['ob_dateto'],
								'obTimeFrom' => $arrPost['ob_timefrom'],
								'obTimeTo'	 => $arrPost['ob_timeto'],
								'obPlace'	 => $arrPost['txtob_place'],
								'obMeal'	 => isset($arrPost['chk_obmeal']) ? 'Y' : 'N',
								'purpose'	 => $arrPost['txtob_purpose'],
								'official'	 => isset($arrPost['isob']) ? $arrPost['isob'] : 'N',
								'approveHR'	 => 'Y',
								'is_override'=> 1,
								'override_id'=> $override_id);
				$this->Attendance_summary_model->add_ob($arrData);
			endforeach;
			
			$this->session->set_flashdata('strSuccessMsg','Override OB successfully.');
			redirect('hr/attendance/override/ob');
		endif;

		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view','attendance/override/override',$this->arrData);

	}

	public function override_ob_edit()
	{
		$arrob_data = $this->Override_model->get_override_ob($this->uri->segment(5));
		$this->arrData['arrob_data'] = $arrob_data;
		$this->arrData['arrGroups'] = $this->Org_structure_model->getData_allgroups();
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrEmployees'] = $this->Hr_model->getData_byGroup();

		$arrPost = $this->input->post();
		$override_id = $this->uri->segment(5);
		if(!empty($arrPost)):
			$overrideData = array(
								 'office_type'	=> $arrPost['seltype'],
								 'office'		=> $arrPost['txtoffice'],
								 'appt_status'	=> $arrPost['selappt'],
								 'lastupdated_date' => date('Y-m-d H:i:s'),
								 'lastupdate_dby' 	=> $this->session->userdata('sessEmpNo'));
			$this->Override_model->save($overrideData, $override_id);
			
			# reload ob data
			$arrob_data = $this->Override_model->get_override_ob(preg_replace("/\D/", "", $arrPost['txtobid']));
			# remove ob before insert new
			foreach(array_column($arrob_data, 'obID') as $obid):
				$this->Attendance_summary_model->delete_ob($obid);
			endforeach;

			# insert new ob
			foreach($arrPost['selemps'] as $emps):
				$arrData = array(
								'dateFiled'	 => date('Y-m-d'),
								'empNumber'	 => $emps,
								'obDateFrom' => $arrPost['ob_datefrom'],
								'obDateTo'	 => $arrPost['ob_dateto'],
								'obTimeFrom' => $arrPost['ob_timefrom'],
								'obTimeTo'	 => $arrPost['ob_timeto'],
								'obPlace'	 => $arrPost['txtob_place'],
								'obMeal'	 => isset($arrPost['chk_obmeal']) ? 'Y' : 'N',
								'purpose'	 => $arrPost['txtob_purpose'],
								'official'	 => isset($arrPost['isob']) ? $arrPost['isob'] : 'N',
								'approveHR'	 => 'Y',
								'is_override'=> 1,
								'override_id'=> $override_id);
				$this->Attendance_summary_model->add_ob($arrData);
			endforeach;
			
			$this->session->set_flashdata('strSuccessMsg','OB updated successfully.');
			redirect('hr/attendance/override/ob');
		endif;

		$this->arrData['action'] = 'edit';
		$this->template->load('template/template_view','attendance/override/override',$this->arrData);
	}

	public function override_ob_delete()
	{
		$arrPost = $this->input->post();
		$arrob_data = $this->Override_model->get_override_ob($arrPost['txtdelover_ob']);
		# remove emp ob
		foreach(array_column($arrob_data, 'obID') as $obid):
			$this->Attendance_summary_model->delete_ob($obid);
		endforeach;

		$this->Override_model->delete($arrPost['txtdelover_ob']);
		$this->session->set_flashdata('strSuccessMsg','OB deleted successfully.');
		redirect('hr/attendance/override/ob');
	}

	public function exclude_dtr()
	{
		$this->arrData['arr_excdtr'] = $this->Override_model->get_override_excdtr();
		$this->template->load('template/template_view','attendance/override/override',$this->arrData);
	}

	public function override_exec_dtr_add()
	{
		$this->arrData['arrGroups'] = $this->Org_structure_model->getData_allgroups();
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrEmployees'] = $this->Hr_model->getData_byGroup();

		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$overrideData = array(
								 'override_type'=> 2,
								 'office_type'	=> $arrPost['seltype'],
								 'office'		=> $arrPost['txtoffice'],
								 'appt_status'	=> $arrPost['selappt'],
								 'created_date' => date('Y-m-d H:i:s'),
								 'created_by' 	=> $this->session->userdata('sessEmpNo'));
			$override_id = $this->Override_model->add($overrideData);

			foreach($arrPost['selemps'] as $emps):
				$arrData = array(
								'dtrSwitch'	 => 'N',
								'is_override'=> 1,
								'override_id'=> $override_id);
				
				$this->Pds_model->save_position($arrData,$emps);
			endforeach;
			
			$this->session->set_flashdata('strSuccessMsg','Employee excluded in DTR successfully.');
			redirect('hr/attendance/override/exclude_dtr');
		endif;

		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view','attendance/override/override',$this->arrData);
	}

	public function override_exec_dtr_edit()
	{
		$arrexecdtr_data = $this->Override_model->get_override_excdtr($this->uri->segment(5));
		$this->arrData['arrexecdtr_data'] = $arrexecdtr_data;
		$this->arrData['arrGroups'] = $this->Org_structure_model->getData_allgroups();
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrEmployees'] = $this->Hr_model->getData_byGroup('N');

		$arrPost = $this->input->post();
		$override_id = $this->uri->segment(5);
		if(!empty($arrPost)):
			$overrideData = array(
								 'office_type'	=> $arrPost['seltype'],
								 'office'		=> $arrPost['txtoffice'],
								 'appt_status'	=> $arrPost['selappt'],
								 'lastupdated_date' => date('Y-m-d H:i:s'),
								 'lastupdate_dby' 	=> $this->session->userdata('sessEmpNo'));
			$this->Override_model->save($overrideData, $override_id);

			foreach(json_decode($arrPost['txtemp_ob']) as $oemps):
				$arrData = array(
								'dtrSwitch'	 => 'Y',
								'is_override'=> 0,
								'override_id'=> null);
				
				$this->Pds_model->save_position($arrData,$oemps);
			endforeach;
			
			foreach($arrPost['selemps'] as $emps):
				$arrData = array(
								'dtrSwitch'	 => 'N',
								'is_override'=> 1,
								'override_id'=> $override_id);
				
				$this->Pds_model->save_position($arrData,$emps);
			endforeach;
			
			$this->session->set_flashdata('strSuccessMsg','Employee excluded in DTR successfully.');
			redirect('hr/attendance/override/exclude_dtr');
		endif;

		$this->arrData['action'] = 'edit';
		$this->template->load('template/template_view','attendance/override/override',$this->arrData);
	}

	public function override_exec_dtr_delete()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrexecdtr_data = $this->Override_model->get_override_excdtr($arrPost['txtdel_excdtr']);
			# set position to switch dtr to Y
			foreach($arrexecdtr_data['emps'] as $oemps):
				$arrData = array(
								'dtrSwitch'	 => 'Y',
								'is_override'=> 0,
								'override_id'=> null);
				
				$this->Pds_model->save_position($arrData,$oemps['empNumber']);
			endforeach;
			
			$this->Override_model->delete($arrPost['txtdel_excdtr']);
		endif;

		$this->session->set_flashdata('strSuccessMsg','Employee included to DTR successfully.');
		redirect('hr/attendance/override/exclude_dtr');
	}

	public function generate_dtr()
	{
		$this->arrData['arrEmployees'] = $this->Hr_model->getData_byGroup('N');
		$this->template->load('template/template_view','attendance/override/override',$this->arrData);
	}

	public function override_inc_dtr()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'dtrSwitch'	 => 'Y',
							'is_override'=> 0,
							'override_id'=> null);
			$this->Pds_model->save_position($arrData,$arrPost['txtempinc_id']);

			$this->session->set_flashdata('strSuccessMsg','Employee included to DTR successfully.');
			redirect('hr/attendance/override/generate_dtr');
		endif;
	}

	public function override_gen_dtr()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$sdate = $arrPost['gendtr_datefrom'];
			$edate = $arrPost['gendtr_dateto'];
			$empid = $arrPost['txtgendtr_empnum'];
			# dtr details
			$in_am = date('h:i:s',strtotime($arrPost['gendtr_timefrom']));
			$out_am = date('h:i:s',strtotime('12:00:00'));
			$in_pm = date('h:i:s',strtotime('12:00:01'));
			$out_pm = date('h:i:s',strtotime($arrPost['gendtr_timeto']));

			$empdtr = $this->Attendance_summary_model->getEmployee_dtr($empid,$sdate,$edate);
			# get all weekdays
			$this->load->helper('dtr_helper');
			$weekdays = get_weekdays($sdate,$edate);
			# get all holidays, regular holidays
			$this->load->model('libraries/Holiday_model');
			$holidays = $this->Holiday_model->getAllHolidates($empid,$sdate,$edate);
			
			# foreach working days
			foreach($weekdays as $wkday):
				# check if holiday
				if(!in_array($wkday,$holidays)):
					# check if empdtr is not null
					if(count($empdtr) < 1):
						# add timein and time out
						$arrData = array('empNumber' => $empid,
										 'dtrDate' 	 => $wkday,
										 'inAM' 	 => $in_am,
										 'outAM' 	 => $out_am,
										 'inPM' 	 => $in_pm,
										 'outPM' 	 => $out_pm,
										 'OT' 	 	 => 0,
										 'name' 	 => $this->session->userdata('sessName').' (override)',
										 'ip'		 => $this->input->ip_address(),
										 'editdate'	 => date('Y-m-d h:i:s A'));
						$this->Attendance_summary_model->add_dtr($arrData);
					else:
						# check if have record in dtr
						if(!in_array($wkday,array_column($empdtr,'dtrDate'))):
							# add timein and time out
							$arrData = array('empNumber' => $empid,
											 'dtrDate' 	 => $wkday,
											 'inAM' 	 => $in_am,
										 	 'outAM' 	 => $out_am,
										 	 'inPM' 	 => $in_pm,
										 	 'outPM' 	 => $out_pm,
											 'OT' 	 	 => 0,
											 'name' 	 => $this->session->userdata('sessName').' (override)',
											 'ip'		 => $this->input->ip_address(),
											 'editdate'	 => date('Y-m-d h:i:s A'));
							$this->Attendance_summary_model->add_dtr($arrData);
						else:
							# search the dtr id and update
							$dtrkey = array_search($wkday, array_column($empdtr, 'dtrDate'));
							# update timein and time out
							$arrData = array('empNumber' => $empid,
											 'dtrDate' 	 => $wkday,
											 'inAM' 	 => $in_am,
										 	 'outAM' 	 => $out_am,
										 	 'inPM' 	 => $in_pm,
										 	 'outPM' 	 => $out_pm,
											 'OT' 	 	 => 0,
											 'name' 	 => $empdtr[$dtrkey]['name'].';'.$this->session->userdata('sessName').' (override)',
											 'ip'		 => $empdtr[$dtrkey]['ip'].';'.$this->input->ip_address(),
											 'editdate'	 => $empdtr[$dtrkey]['editdate'].';'.date('Y-m-d h:i:s A'),
											 'oldValue'	 => $empdtr[$dtrkey]['oldValue'].';inAM='.$in_am.', outAM='.$out_am.', inPM='.$in_am.', outPM='.$out_pm.', inOT=00:00:00, outOT=00:00:00');

							$this->Attendance_summary_model->edit_dtr($arrData, $empdtr[$dtrkey]['id']);
						endif;
					endif;

				endif;
			endforeach;

			$this->session->set_flashdata('strSuccessMsg','DTR generated successfully.');
			redirect('hr/attendance/override/generate_dtr');
		endif;
	}

	public function generate_dtr_allemp()
	{
		$arrexecdtr_data = $this->Override_model->get_override_excdtr($this->uri->segment(5));
		$this->arrData['arrexecdtr_data'] = $arrexecdtr_data;
		$this->arrData['arrGroups'] = $this->Org_structure_model->getData_allgroups();
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrEmployees'] = $this->Hr_model->getData_byGroup('N');

		$arrPost = $this->input->post();
		$override_id = $this->uri->segment(5);
		if(!empty($arrPost)):
			$sdate = $arrPost['datefrom'];
			$edate = $arrPost['dateto'];
			foreach($arrPost['selemps'] as $emps):
				$empid = $emps;

				$empdtr = $this->Attendance_summary_model->getEmployee_dtr($empid,$sdate,$edate);
				# get all weekdays
				$this->load->helper('dtr_helper');
				$weekdays = get_weekdays($sdate,$edate);
				# get all holidays, regular holidays
				$this->load->model('libraries/Holiday_model');
				$holidays = $this->Holiday_model->getAllHolidates($empid,$sdate,$edate);
				
				# foreach working days
				foreach($weekdays as $wkday):
					# check if holiday
					if(!in_array($wkday,$holidays)):
						# check if empdtr is not null
						if(count($empdtr) < 1):
							# add timein and time out
							$arrData = array('empNumber' => $empid,
											 'dtrDate' 	 => $wkday,
											 'inAM' 	 => date('h:i:s',strtotime($arrPost['timefrom'])),
											 'outAM' 	 => date('h:i:s',strtotime('12:00:00')),
											 'inPM' 	 => date('h:i:s',strtotime('12:00:01')),
											 'outPM' 	 => date('h:i:s',strtotime($arrPost['timeto'])),
											 'OT' 	 	 => 0,
											 'name' 	 => 'override');
							$this->Attendance_summary_model->add_dtr($arrData);
						else:
							# check if have record in dtr
							if(!in_array($wkday,array_column($empdtr,'dtrDate'))):
								# add timein and time out
								$arrData = array('empNumber' => $empid,
												 'dtrDate' 	 => $wkday,
												 'inAM' 	 => date('h:i:s',strtotime($arrPost['timefrom'])),
												 'outAM' 	 => date('h:i:s',strtotime('12:00:00')),
												 'inPM' 	 => date('h:i:s',strtotime('12:00:01')),
												 'outPM' 	 => date('h:i:s',strtotime($arrPost['timeto'])),
												 'OT' 	 	 => 0,
												 'name' 	 => 'override');
								$this->Attendance_summary_model->add_dtr($arrData);
							else:
								# search the dtr id and update
								$dtrkey = array_search($wkday, array_column($empdtr, 'dtrDate'));
								# update timein and time out
								$arrData = array('empNumber' => $empid,
												 'dtrDate' 	 => $wkday,
												 'inAM' 	 => date('h:i:s',strtotime($arrPost['timefrom'])),
												 'outAM' 	 => date('h:i:s',strtotime('12:00:00')),
												 'inPM' 	 => date('h:i:s',strtotime('12:00:01')),
												 'outPM' 	 => date('h:i:s',strtotime($arrPost['timeto'])),
												 'OT' 	 	 => 0,
												 'name' 	 => 'override');

								$this->Attendance_summary_model->edit_dtr($arrData, $empdtr[$dtrkey]['id']);
							endif;
						endif;
					endif;
				endforeach;
			endforeach;
			
			$this->session->set_flashdata('strSuccessMsg','DTR generated successfully.');
			redirect('hr/attendance/override/generate_dtr');
		endif;

		$this->template->load('template/template_view','attendance/override/override',$this->arrData);
	}


}


