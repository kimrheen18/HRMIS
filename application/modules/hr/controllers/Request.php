<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends MY_Controller {

	var $arrData;

	function __construct()
	{
        parent::__construct();
        $this->load->model(array('libraries/Request_model','employee/Notification_model','employee/Leave_model','hr/Attendance_summary_model','hr/Hr_model','employee/official_business_model','employee/leave_model','employee/travel_order_model','employee/leave_monetization_model','employee/update_pds_model','finance/dtr_model','employee/compensatory_leave_model'));
    }

    public function index()
	{
		$active_menu = isset($_GET['status']) ? $_GET['status']=='' ? 'Filed Request' : $_GET['status'] : 'Filed Request';
		$_GET['status'] = $active_menu;
		$menu = array('All','Filed Request','Certified','Cancelled','Disapproved');
		unset($menu[array_search($active_menu, $menu)]);
		$notif_icon = array('All' => 'list', 'Filed Request' => 'file-text-o', 'Certified' => 'check', 'Cancelled' => 'ban', 'Disapproved' => 'remove');

		$this->arrData['active_code'] = isset($_GET['code']) ? $_GET['code']=='' ? 'all' : $_GET['code'] : 'all';
		$this->arrData['arrNotif_menu'] = $menu;
		$this->arrData['active_menu'] = $active_menu;
		$this->arrData['notif_icon'] = $notif_icon;

		$request_type = $_GET['request'];

		if($request_type == 'ob'):
			# begin OB
			$arrob_request = $this->official_business_model->getall_request();

			if(isset($_GET['status'])):
				if(strtolower($_GET['status'])!='all'):
					$ob_request = array();
					foreach($arrob_request as $key=>$ob):
						$next_signatory = $this->Request_model->get_next_signatory($ob,'OB');
						$ob['next_signatory'] = $next_signatory;
						if(strtolower($_GET['status']) == strtolower($ob['requestStatus'])):
							if($active_menu == 'Filed Request'):
								if($ob['next_signatory']['display'] == 1):
									$ob_request[] = $ob;
								endif;
							else:
								$ob_request[] = $ob;
							endif;
						endif;
					endforeach;
					$arrob_request = $ob_request;
				else:
					foreach($arrob_request as $key=>$ob):
						$next_signatory = $this->Request_model->get_next_signatory($ob,'OB');
						$ob['next_signatory'] = $next_signatory;
						$ob_request[] = $ob;
					endforeach;
					$arrob_request = $ob_request;
				endif;
			endif;
			$this->arrData['arrob_request'] = $arrob_request;
			# end OB
		endif;

		if($request_type == 'leave'):
			# begin leave
			$arrleave_request = $this->leave_model->getall_request();

			if(isset($_GET['status'])):
				if(strtolower($_GET['status'])!='all'):
					$leave_request = array();
					foreach($arrleave_request as $key=>$leave):
						if($leave['requestDetails'] != ''):
							$requestDetails = explode(';',$leave['requestDetails']);
							$next_signatory = $this->Request_model->get_next_signatory($leave,strtoupper($requestDetails[0]));
							$leave['next_signatory'] = $next_signatory;
							if(strtolower($_GET['status']) == strtolower($leave['requestStatus'])):
								if($active_menu == 'Filed Request'):
									if($leave['next_signatory']['display'] == 1):
										$leave_request[] = $leave;
									endif;
								else:
									$leave_request[] = $leave;
								endif;
							endif;
						endif;
					endforeach;
					$arrleave_request = $leave_request;
				else:
					foreach($arrleave_request as $key=>$leave):
						if($leave['requestDetails'] != ''):
							$requestDetails = explode(';',$leave['requestDetails']);
							$next_signatory = $this->Request_model->get_next_signatory($leave,strtoupper($requestDetails[0]));
							$leave['next_signatory'] = $next_signatory;
							$leave_request[] = $leave;
						endif;
					endforeach;
					$arrleave_request = $leave_request;
				endif;
			endif;
			$this->arrData['arrleave_request'] = $arrleave_request;
			# end leave
		endif;

		if($request_type == 'to'):
			# begin TO
			$arrto_request = $this->travel_order_model->getall_request();

			if(isset($_GET['status'])):
				if(strtolower($_GET['status'])!='all'):
					$to_request = array();
					foreach($arrto_request as $key=>$to):
						$section = $this->travel_order_model->getemp_section($to['empNumber']);
						if($section['sectionCode'] != ''){
							$next_signatory = $this->Request_model->get_next_signatory($to,'TO',$section['sectionCode']);
						}else{
							$next_signatory = $this->Request_model->get_next_signatory($to,'TO',$section['divisionCode']);
						}
						//$next_signatory = $this->Request_model->get_next_signatory($to,'TO');
						$to['next_signatory'] = $next_signatory;
						if(strtolower($_GET['status']) == strtolower($to['requestStatus'])):
							if($active_menu == 'Filed Request'):
								if($to['next_signatory']['display'] == 1):
									$to_request[] = $to;
								endif;
							else:
								$to_request[] = $to;
							endif;
						endif;
					endforeach;
					$arrto_request = $to_request;
				else:
					foreach($arrto_request as $key=>$to):
						$section = $this->travel_order_model->getemp_section($to['empNumber']);
						$next_signatory = $this->Request_model->get_next_signatory($to,'TO',$section['sectionCode']);
						$to['next_signatory'] = $next_signatory;
						$to_request[] = $to;
					endforeach;
					$arrto_request = $to_request;
				endif;
			endif;
			$this->arrData['arrto_request'] = $arrto_request;
			# end TO
		endif;

		if($request_type == 'pds'):
			# begin PDS
			$arrpds_request = $this->update_pds_model->getall_request();

			if(isset($_GET['status'])):
				if(strtolower($_GET['status'])!='all'):
					$pds_request = array();
					foreach($arrpds_request as $key=>$pds):
						$next_signatory = $this->Request_model->get_next_signatory($pds,'201');
						$pds['next_signatory'] = $next_signatory;
						if(strtolower($_GET['status']) == strtolower($pds['requestStatus'])):
							if($active_menu == 'Filed Request'):
								if($pds['next_signatory']['display'] == 1):
									$pds_request[] = $pds;
								endif;
							else:
								$pds_request[] = $pds;
							endif;
						endif;
					endforeach;
					$arrpds_request = $pds_request;
				else:
					foreach($arrpds_request as $key=>$pds):
						$next_signatory = $this->Request_model->get_next_signatory($pds,'201');
						$pds['next_signatory'] = $next_signatory;
						$pds_request[] = $pds;
					endforeach;
					$arrpds_request = $pds_request;
				endif;
			endif;
			$this->arrData['arrpds_request'] = $arrpds_request;
			# end PDS
		endif;

		if($request_type == 'mone'):
			# begin Monetization
			$arrmone_request = $this->leave_monetization_model->getall_request();

			if(isset($_GET['status'])):
				if(strtolower($_GET['status'])!='all'):
					$mone_request = array();
					foreach($arrmone_request as $key=>$mone):
						$next_signatory = $this->Request_model->get_next_signatory($mone,'Monetization');
						$mone['next_signatory'] = $next_signatory;
						if(strtolower($_GET['status']) == strtolower($mone['requestStatus'])):
							if($active_menu == 'Filed Request'):
								if($mone['next_signatory']['display'] == 1):
									$mone_request[] = $mone;
								endif;
							else:
								$mone_request[] = $mone;
							endif;
						endif;
					endforeach;
					$arrmone_request = $mone_request;
				else:
					foreach($arrmone_request as $key=>$mone):
						$next_signatory = $this->Request_model->get_next_signatory($mone,'Monetization');
						$mone['next_signatory'] = $next_signatory;
						$mone_request[] = $mone;
					endforeach;
					$arrmone_request = $mone_request;
				endif;
			endif;
			$this->arrData['arrmone_request'] = $arrmone_request;
			# end Monetization
		endif;

		if($request_type == 'dtr'):
			# begin DTR
			$arrdtr_request = $this->dtr_model->getall_request();

			if(isset($_GET['status'])):
				if(strtolower($_GET['status'])!='all'):
					$dtr_request = array();
					foreach($arrdtr_request as $key=>$dtr):
						//$next_signatory = $this->Request_model->get_next_signatory($dtr,'DTR');
						$display = ($dtr['signatory'] == $_SESSION['sessEmpNo']) ? 1 : 0;
						$next_signatory = array("next_sign" => $dtr['signatory'], "display" => $display );
						$dtr['next_signatory'] = $next_signatory;
						echo("<script>console.log('PHP: " . $display . "');</script>");
						
						if(strtolower($_GET['status']) == strtolower($dtr['requestStatus'])):
							if($active_menu == 'Filed Request'):
								if($dtr['next_signatory']['display'] == 1):
									$dtr_request[] = $dtr;
								endif;
							else:
								$dtr_request[] = $dtr;
							endif;
						endif;
					endforeach;
					$arrdtr_request = $dtr_request;
				else:
					foreach($arrdtr_request as $key=>$dtr):
						if($dtr['requestStatus'] != 'Filed Request' || $dtr['signatory'] == $_SESSION['sessEmpNo'] ){
							//$next_signatory = $this->Request_model->get_next_signatory($dtr,'DTR');
							$display = ($dtr['signatory'] == $_SESSION['sessEmpNo']) ? 1 : 0;
							$next_signatory = array("next_sign" => $dtr['signatory'], "display" => $display );
							$dtr['next_signatory'] = $next_signatory;
							$dtr_request[] = $dtr;
							echo("<script>console.log('PHP: " . json_encode($dtr_request) . "');</script>");
						}
					endforeach;
					$arrdtr_request = $dtr_request;
				endif;
			endif;
			$this->arrData['arrdtr_request'] = $arrdtr_request;
			# end DTR
		endif;

		if($request_type == 'cto'):
			# begin CTO
			$arrcto_request = $this->compensatory_leave_model->getall_request();

			if(isset($_GET['status'])):
				if(strtolower($_GET['status'])!='all'):
					$cto_request = array();
					foreach($arrcto_request as $key=>$cto):
						$next_signatory = $this->Request_model->get_next_signatory($cto,'CTO');
						$cto['next_signatory'] = $next_signatory;
						if(strtolower($_GET['status']) == strtolower($cto['requestStatus'])):
							if($active_menu == 'Filed Request'):
								if($cto['next_signatory']['display'] == 1):
									$cto_request[] = $cto;
								endif;
							else:
								$cto_request[] = $cto;
							endif;
						endif;
					endforeach;
					$arrcto_request = $cto_request;
				else:
					foreach($arrcto_request as $key=>$cto):
						$next_signatory = $this->Request_model->get_next_signatory($cto,'CTO');
						$cto['next_signatory'] = $next_signatory;
						$cto_request[] = $cto;
					endforeach;
					$arrcto_request = $cto_request;
				endif;
			endif;
			$this->arrData['arrcto_request'] = $arrcto_request;
			# end CTO
		endif;


		$this->template->load('template/template_view', 'hr/request/view_list', $this->arrData);
	}

	public function update_ob()
	{
		$arrPost = $this->input->post();

		$optstatus = isset($_GET['status']) ? $_GET['status'] : '';
		$txtremarks = '';
		if(!empty($arrPost)):
			$optstatus = $arrPost['optstatus'];
			$txtremarks = $arrPost['txtremarks'];
		endif;

		$req_id = $_GET['req_id'];
		$arrob = $this->official_business_model->getData($_GET['req_id']);
		$ob_details = explode(';',$arrob['requestDetails']);
			
		# signatories
		$arremp_signature = $this->Request_model->get_signature($arrob['requestCode']);
		if(strtoupper($optstatus) == 'CERTIFIED'):
			$arrob_data = array(
				'dateFiled'		=> $ob_details[1],
				'empNumber'		=> $arrob['empNumber'],
				'requestID'		=> $arrob['requestID'],
				'obDateFrom'	=> $ob_details[2],
				'obDateTo'		=> $ob_details[3],
				'obTimeFrom'	=> $ob_details[4],
				'obTimeTo'		=> $ob_details[5],
				'obPlace'		=> $ob_details[6],
				'obMeal'		=> $ob_details[8]==''?'N':$ob_details[8],
				'purpose'		=> $ob_details[7],
				'official'		=> strtolower($ob_details[0]) == 'official' ? 'Y' : '',
				'approveRequest'=> '',
				'approveChief'	=> '',
				'approveHR'		=> check_module()=='hr' ? strtolower($optstatus) == 'certified' ? 'Y' : '' : '',
				'is_override'	=> '',
				'override_id'	=> ''
			);

			$addreturn = $this->Official_business_model->add($arrob_data);
			if(count($addreturn)>0):
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Add Official Business',json_encode($arrob_data),'');
			endif;
		endif;

		$arrob_signatory = array(
			'requestStatus'	=> strtoupper($optstatus),
			'statusDate'	=> date('Y-m-d'),
			'remarks'		=> $txtremarks,
			'signatory'		=> $_SESSION['sessEmpNo']
		);

		$arrob_signatory = array_merge($arrob_signatory,$arremp_signature);
		$update_employeeRequest = $this->Request_model->update_employeeRequest($arrob_signatory, $arrob['requestID']);
		if(count($update_employeeRequest)>0):
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Update request',json_encode($arrob_signatory),'');
			$this->session->set_flashdata('strSuccessMsg','Request successfully '.strtolower($optstatus).'.');
		endif;

		redirect('hr/request?request=ob');
	}

	public function update_leave()
	{
		$arrPost = $this->input->post();

		$optstatus = isset($_GET['status']) ? $_GET['status'] : '';

		$txtremarks = '';
		if(!empty($arrPost)):
			$optstatus = $arrPost['opt_leave_stat'];
			$txtremarks = $arrPost['txtremarks'];
		endif;


		$req_id = $_GET['req_id'];
		$arrleave = $this->leave_model->getData($_GET['req_id']);
		$leave_details = explode(';',$arrleave['requestDetails']);
		
		# signatories
		$arremp_signature = $this->Request_model->get_signature($leave_details[0]);
		if(strtoupper($optstatus) == 'CERTIFIED'):
			$arrleave_data = array(
				'dateFiled'		=> $arrleave['requestDate'],
				'empNumber'		=> $arrleave['empNumber'],
				'requestID'		=> $arrleave['requestID'],
				'leaveCode'		=> strtoupper($leave_details[0]),
				'specificLeave'	=> $leave_details[7],
				'reason'		=> $leave_details[6],
				'leaveFrom'		=> $leave_details[1],
				'leaveTo'		=> $leave_details[2],
				'certifyHR'		=> 'Y',
				'approveRequest'=> 'Y'
			);

			$addreturn = $this->leave_model->add_employeeLeave($arrleave_data);
			if(count($addreturn)>0):
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Add Leave',json_encode($arrob_data),'');
			endif;
		endif;

		$arrleave_signatory = array(
			'requestStatus'	=> strtoupper($optstatus),
			'statusDate'	=> date('Y-m-d'),
			'remarks'		=> $txtremarks,
			'signatory'		=> $_SESSION['sessEmpNo']
		);

		$arrleave_signatory = array_merge($arrleave_signatory,$arremp_signature);
		$update_employeeRequest = $this->Request_model->update_employeeRequest($arrleave_signatory, $arrleave['requestID']);
		if(count($update_employeeRequest)>0):
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Update request',json_encode($arrleave_signatory),'');
			$this->session->set_flashdata('strSuccessMsg','Request successfully '.strtolower($optstatus).'.');
		endif;

		redirect('hr/request?request=leave');
	}

	public function update_to()
	{
		$arrPost = $this->input->post();

		$optstatus = isset($_GET['status']) ? $_GET['status'] : '';

		$txtremarks = '';
		if(!empty($arrPost)):
			$optstatus = $arrPost['opt_to_stat'];
			$txtremarks = $arrPost['txtremarks'];
		endif;

		$req_id = $_GET['req_id'];
		$arrto = $this->travel_order_model->getData($_GET['req_id']);
		$section = $this->travel_order_model->getemp_section($arrto['empNumber']);
		$section_code = $section['sectionCode'];
		$to_details = explode(';',$arrto['requestDetails']);
		
		# signatories
		$arremp_signature = $this->Request_model->get_signature('TO',$section_code);
		if(strtoupper($optstatus) == 'CERTIFIED'):
			$arrto_data = array(
				'dateFiled'		=> $arrto['requestDate'],
				'empNumber'		=> $arrto['empNumber'],
				'toDateFrom'	=> $to_details[1],
				'toDateTo'		=> $to_details[2],
				'destination'	=> $to_details[0],
				'purpose'		=> $to_details[3],
				'wmeal'			=> $to_details[4]
			);
			
			$addreturn = $this->travel_order_model->add($arrto_data);
			if(count($addreturn)>0):
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Add TO ',json_encode($arrto_data),'');
			endif;
		endif;

		$arrto_signatory = array(
			'requestStatus'	=> strtoupper($optstatus),
			'statusDate'	=> date('Y-m-d'),
			'remarks'		=> $txtremarks,
			'signatory'		=> $_SESSION['sessEmpNo']
		);

		$arrto_signatory = array_merge($arrto_signatory,$arremp_signature);
		$update_employeeRequest = $this->Request_model->update_employeeRequest($arrto_signatory, $arrto['requestID']);
		if(count($update_employeeRequest)>0):
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Update request',json_encode($arrleave_signatory),'');
			$this->session->set_flashdata('strSuccessMsg','Request successfully '.strtolower($optstatus).'.');
		endif;

		redirect('hr/request?request=to');
	}

	public function update_mone()
	{
		$arrPost = $this->input->post();

		$optstatus = isset($_GET['status']) ? $_GET['status'] : '';

		$txtremarks = '';
		if(!empty($arrPost)):
			$optstatus = $arrPost['opt_mone_stat'];
			$txtremarks = $arrPost['txtremarks'];
		endif;
		
		$req_id = $_GET['req_id'];
		$arrmone = $this->leave_monetization_model->getrequest($_GET['req_id']);
		$mone_details = explode(';',$arrmone['requestDetails']);
		
		# signatories
		$arremp_signature = $this->Request_model->get_signature('TO');
		if(strtoupper($optstatus) == 'CERTIFIED'):
			$employee_details = employee_details($arrmone['empNumber']);
			$monetize_amt = ($mone_details[2] + $mone_details[3]) * AMT_MONETIZATION * $employee_details[0]['actualSalary'];
			$arrmone_data = array(
				'empNumber'		=> $arrmone['empNumber'],
				'vlMonetize'	=> isset($mone_details[2]) ? $mone_details[2] : '',
				'slMonetize'	=> isset($mone_details[3]) ? $mone_details[3] : '',
				'processMonth'	=> date('n'),
				'processYear'	=> date('Y'),
				'monetizeMonth'	=> isset($mone_details[4]) ? $mone_details[4] : '',
				'monetizeYear'	=> isset($mone_details[5]) ? $mone_details[5] : '',
				'monetizeAmount'=> $monetize_amt,
				'processBy'		=> $this->session->userdata('sessEmpNo'),
				'ip'			=> $this->input->ip_address(),
				'processDate'	=> date('Y-m-d h:i:s A')
			);

			$addreturn = $this->leave_monetization_model->addemp_monetized($arrmone_data);
			if(count($addreturn)>0):
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Add Leave Monetization ',json_encode($arrmone_data),'');
			endif;
		endif;

		$arrmone_signatory = array(
			'requestStatus'	=> strtoupper($optstatus),
			'statusDate'	=> date('Y-m-d'),
			'remarks'		=> $txtremarks,
			'signatory'		=> $_SESSION['sessEmpNo']
		);

		$arrmone_signatory = array_merge($arrmone_signatory,$arremp_signature);
		$update_employeeRequest = $this->Request_model->update_employeeRequest($arrmone_signatory, $arrmone['requestID']);
		if(count($update_employeeRequest)>0):
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Update request',json_encode($arrleave_signatory),'');
			$this->session->set_flashdata('strSuccessMsg','Request successfully '.strtolower($optstatus).'.');
		endif;

		redirect('hr/request?request=mone');
	}

	public function update_dtr()
	{
		$arrPost = $this->input->post();

		$optstatus = isset($_GET['status']) ? $_GET['status'] : '';

		$txtremarks = '';
		if(!empty($arrPost)):
			$optstatus = $arrPost['opt_dtr_stat'];
			$txtremarks = $arrPost['txtremarks'];
		endif;
		
		$req_id = $_GET['req_id'];
		$arrdtr = $this->dtr_model->getrequest($_GET['req_id']);
		$dtr_details = explode(';',$arrdtr['requestDetails']);
		$arremp_dtr = $this->dtr_model->getData($arrdtr['empNumber'],0,0,$dtr_details[1],$dtr_details[1]);

		# signatories
		$arremp_signature = $this->Request_model->get_signature('DTR');
		if(strtoupper($optstatus) == 'CERTIFIED'):
			$in_am  = $dtr_details[8].':'.$dtr_details[9].':'.$dtr_details[10];
			$out_am = $dtr_details[12].':'.$dtr_details[13].':'.$dtr_details[14];
			$in_pm  = $dtr_details[16].':'.$dtr_details[17].':'.$dtr_details[18];
			$out_pm = $dtr_details[20].':'.$dtr_details[21].':'.$dtr_details[22];
			$in_ot  = $dtr_details[24].':'.$dtr_details[25].':'.$dtr_details[26];
			$out_ot = $dtr_details[28].':'.$dtr_details[29].':'.$dtr_details[30];

			$arrdtr_data = array(
				'empNumber'	=> $arrdtr['empNumber'],
				'dtrDate'	=> isset($dtr_details[1]) ? $dtr_details[1] : '',
				'inAM'		=> $in_am,
				'outAM'		=> $out_am,
				'inPM'		=> $in_pm,
				'outPM'		=> $out_pm,
				'inOT'		=> $in_ot,
				'outOT'		=> $out_ot,
				'DTRreason' => $dtr_details[32],
				'remarks'   => $dtr_details[34],
				'name'		=> (count($arremp_dtr) > 0 ? $arremp_dtr[0]['name'] :'').';'.$this->session->userdata('sessName'),
				'ip'		=> (count($arremp_dtr) > 0 ? $arremp_dtr[0]['ip'] :'').';'.$this->input->ip_address(),
				'editdate'	=> (count($arremp_dtr) > 0 ? $arremp_dtr[0]['editdate'] :'').';'.date('Y-m-d h:i:s A')
			);

			if(count($arremp_dtr) > 0):
				$addreturn = $this->dtr_model->save($arrdtr_data, $arremp_dtr[0]['id']);
			else:
				$addreturn = $this->dtr_model->submit($arrdtr_data);
			endif;

			if(count($addreturn)>0):
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Add Leave Monetization ',json_encode($arrmone_data),'');
			endif;
		endif;

		$arrdtr_signatory = array(
			'requestStatus'	=> strtoupper($optstatus),
			'statusDate'	=> date('Y-m-d'),
			'remarks'		=> $txtremarks,
			'signatory'		=> $_SESSION['sessEmpNo']
		);

		$arrdtr_signatory = array_merge($arrdtr_signatory,$arremp_signature);
		$update_employeeRequest = $this->Request_model->update_employeeRequest($arrdtr_signatory, $arrdtr['requestID']);
		if(count($update_employeeRequest)>0):
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Update request',json_encode($arrleave_signatory),'');
			$this->session->set_flashdata('strSuccessMsg','Request successfully '.strtolower($optstatus).'.');
		endif;

		redirect('hr/request?request=dtr');
	}

	public function update_cto()
	{
		$arrPost = $this->input->post();

		$optstatus = isset($_GET['status']) ? $_GET['status'] : '';

		$txtremarks = '';
		if(!empty($arrPost)):
			$optstatus = $arrPost['opt_cto_stat'];
			$txtremarks = $arrPost['txtremarks'];
		endif;
		
		$req_id = $_GET['req_id'];
		$arrdtr = $this->compensatory_leave_model->getrequest($_GET['req_id']);
		$dtr_details = explode(';',$arrdtr['requestDetails']);
		$arremp_dtr = $this->dtr_model->getData($arrdtr['empNumber'],0,0,$dtr_details[1],$dtr_details[1]);
		
		# signatories
		$arremp_signature = $this->Request_model->get_signature('CTO');
		if(strtoupper($optstatus) == 'CERTIFIED'):
			$in_am  = $dtr_details[1];
			$out_am = $dtr_details[2];
			$in_pm  = $dtr_details[3];
			$out_pm = $dtr_details[4];
			
			$arrdtr_data = array(
				'empNumber'	=> $arrdtr['empNumber'],
				'dtrDate'	=> isset($dtr_details[1]) ? $dtr_details[1] : '',
				'inAM'		=> $in_am,
				'outAM'		=> $out_am,
				'inPM'		=> $in_pm,
				'outPM'		=> $out_pm,
				'inOT'		=> '00:00:00',
				'outOT'		=> '00:00:00',
				'DTRreason' => '',
				'remarks'   => 'CL',
				'name'		=> (count($arremp_dtr) > 0 ? $arremp_dtr[0]['name'] :'').';'.$this->session->userdata('sessName'),
				'ip'		=> (count($arremp_dtr) > 0 ? $arremp_dtr[0]['ip'] :'').';'.$this->input->ip_address(),
				'editdate'	=> (count($arremp_dtr) > 0 ? $arremp_dtr[0]['editdate'] :'').';'.date('Y-m-d h:i:s A')
			);

			if(count($arremp_dtr) > 0):
				$addreturn = $this->dtr_model->save($arrdtr_data, $arremp_dtr[0]['id']);
			else:
				$addreturn = $this->dtr_model->submit($arrdtr_data);
			endif;

			if(count($addreturn)>0):
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Add Compensatory Time Off ',json_encode($arrmone_data),'');
			endif;
		endif;

		$arrdtr_signatory = array(
			'requestStatus'	=> strtoupper($optstatus),
			'statusDate'	=> date('Y-m-d'),
			'remarks'		=> $txtremarks,
			'signatory'		=> $_SESSION['sessEmpNo']
		);
		
		$arrdtr_signatory = array_merge($arrdtr_signatory,$arremp_signature);
		$update_employeeRequest = $this->Request_model->update_employeeRequest($arrdtr_signatory, $arrdtr['requestID']);
		if(count($update_employeeRequest)>0):
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Update request',json_encode($arrleave_signatory),'');
			$this->session->set_flashdata('strSuccessMsg','Request successfully '.strtolower($optstatus).'.');
		endif;

		redirect('hr/request?request=cto');
	}

	// public function leave_request()
	// {
	// 	$emp_session = $_SESSION;
	// 	$arrPost = $this->input->post();

	// 	if(!empty($arrPost)):
	// 		$leave_details = json_decode($arrPost['txtleave_json'],true);
	// 		$request_details = explode(';',$leave_details['req_details']);

	// 		$arrLeave_details = array(
	// 						'dateFiled'	 	=> $leave_details['req_date'],
	// 						'empNumber'	 	=> $leave_details['req_emp'],
	// 						'requestID' 	=> $leave_details['req_id'],
	// 						'leaveCode' 	=> $leave_details['req_type'],
	// 						'specificLeave' => $arrPost['txtreq_patient'],
	// 						'reason'		=> $request_details[4],
	// 						'leaveFrom' 	=> $request_details[2],
	// 						'leaveTo' 		=> $request_details[3],
	// 						'certifyHR' 	=> (strpos($leave_details['req_nextsign'], 'HR') !== false) ? 'Y' : '',
	// 						'remarks' 		=> $leave_details['req_remarks'],
	// 						'inoutpatient'	=> $arrPost['txtreq_patient'],
	// 						'vllocation'	=> $request_details[9],
	// 						'commutation'	=> $request_details[10]);
	// 		# add in empleave
	// 		$this->Leave_model->add_employeeLeave($arrLeave_details);

	// 		$arrsignatory = array(
	// 						'SignatoryFin'	 => $arrPost['selreq_stat'].';'.$emp_session['sessName'].';'.employee_office($emp_session['sessEmpNo']).';'.$emp_session['sessEmpNo'], # action;name;divion;empnumber
	// 						'requestStatus' => $arrPost['selreq_stat'],
	// 						'SigFinDateTime' => date('Y-m-d H:i:s'));
	// 		# update request
	// 		$this->Leave_model->save($arrsignatory, $leave_details['req_id']);

	// 		$this->session->set_flashdata('strSuccessMsg','Employee request has been '.strtolower($arrPost['selreq_stat']));
	// 		redirect('hr/notification?month='.currmo().'&yr='.curryr().'&status='.$_GET['status'].'&code='.$_GET['code']);
	// 	endif;
	// }

	public function ob_request()
	{
		$emp_session = $_SESSION;
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$request_details = fixArray($arrPost['txtob_json']);
			$ob_details = explode(';',$request_details['req_details']);
			$arrData=array(
				'dateFiled' 	 => date('Y-m-d'),
				'empNumber'	  	 => $request_details['req_emp'],
				'requestID' 	 => $request_details['req_id'],
				'obDateFrom' 	 => $ob_details[1],
				'obDateTo' 		 => $ob_details[2],
				'obTimeFrom' 	 => $ob_details[3],
				'obTimeTo' 		 => $ob_details[4],
				'obPlace' 		 => $ob_details[5],
				'obMeal' 		 => $ob_details[6] == '' ? 'Y' : 'N',
				'purpose' 		 => $ob_details[7],
				'official' 		 => $ob_details[0],
				'approveRequest' => 'Y',
				'approveChief' 	 => 'Y',
				'approveHR' 	 => 'Y');
			
			$this->Attendance_summary_model->add_ob($arrData);
			$arrsignatory = array(
							'SignatoryFin' => $arrPost['selob_stat'].';'.$emp_session['sessName'].';'.employee_office($emp_session['sessEmpNo']).';'.$emp_session['sessEmpNo'], # action;name;divion;empnumber
							'requestStatus' => $arrPost['selob_stat'],
							'SigFinDateTime' => date('Y-m-d H:i:s'));
			# update request

			$this->Leave_model->save($arrsignatory, $request_details['req_id']);
			$this->session->set_flashdata('strSuccessMsg','Employee request has been '.strtolower($arrPost['selob_stat']));
		endif;
		redirect('hr/notification?month='.currmo().'&yr='.curryr().'&status='.$_GET['status'].'&code='.$_GET['code']);
	}

	public function to_request()
	{
		// echo '<pre>';
		$emp_session = $_SESSION;
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			// print_r($arrPost);
			// $request_details = fixArray($arrPost['txtto_json']);
			// print_r($request_details);
			// $to_details = explode(';',$request_details['req_details']);
			// print_r($to_details);
			// $arrData=array(
			// 	'empNumber'	  	 => $request_details['req_emp'],
			// 	'dateFiled' 	 => $request_details['req_id'],
			// 	'toDateFrom' 	 => $ob_details[1],
			// 	'toDateTo' 		 => $ob_details[2],
			// 	'destination' 	 => $ob_details[3],
			// 	'purpose' 		 => $ob_details[4],
			// 	'obPlace' 		 => $ob_details[5],
			// 	'obMeal' 		 => $ob_details[6] == '' ? 'Y' : 'N',
			// 	'purpose' 		 => $ob_details[7],
			// 	'official' 		 => $ob_details[0],
			// 	'approveRequest' => 'Y',
			// 	'approveChief' 	 => 'Y',
			// 	'approveHR' 	 => 'Y');
			
			// $this->Attendance_summary_model->add_ob($arrData);
			// $arrsignatory = array(
			// 				'SignatoryFin' => $arrPost['selob_stat'].';'.$emp_session['sessName'].';'.employee_office($emp_session['sessEmpNo']).';'.$emp_session['sessEmpNo'], # action;name;divion;empnumber
			// 				'requestStatus' => $arrPost['selob_stat'],
			// 				'SigFinDateTime' => date('Y-m-d H:i:s'));
			// # update request

			// $this->Leave_model->save($arrsignatory, $request_details['req_id']);
			// $this->session->set_flashdata('strSuccessMsg','Employee request has been '.strtolower($arrPost['selob_stat']));
		endif;
		// die();
		redirect('hr/notification?month='.currmo().'&yr='.curryr().'&status='.$_GET['status'].'&code='.$_GET['code']);
	}

	public function dtr_request()
	{
		$emp_session = $_SESSION;
		$arrPost = $this->input->post();
		
		if(!empty($arrPost)):
			$request_details = fixArray($arrPost['txtdtr_json']);
			$dtr_details = explode(';',$request_details['req_details']);
			$empdtr = $this->Attendance_summary_model->getEmployee_dtr($request_details['req_emp'],$dtr_details[0],$dtr_details[0]);

			$arrData = array('empNumber'	=> $request_details['req_emp'],
							 'dtrDate'		=> $request_details['req_date'],
							 'inAM' 		=> $dtr_details[8],
							 'outAM' 		=> $dtr_details[9],
							 'inPM' 		=> $dtr_details[10],
							 'outPM' 		=> $dtr_details[11],
							 'inOT' 		=> $dtr_details[12],
							 'outOT' 		=> $dtr_details[13],
							 // TODO:: FIND PREVIOUS DATA
							 'name' 		=> $emp_session['sessEmpNo'],
							 'ip'			=> $this->input->ip_address(),
							 'editdate'		=> date('Y-m-d h:i:s A'),
							 'oldValue' 	=> '');
			
			if(count($empdtr) > 0):
				$this->Attendance_summary_model->edit_dtr($arrData, $request_details['req_emp']);
			else:
				$this->Attendance_summary_model->add_dtr($arrData);
			endif;

			$arrsignatory = array(
							'SignatoryFin' => $arrPost['seldtr_stat'].';'.$emp_session['sessName'].';'.employee_office($emp_session['sessEmpNo']).';'.$emp_session['sessEmpNo'], # action;name;divion;empnumber
							'requestStatus' => $arrPost['seldtr_stat'],
							'SigFinDateTime' => date('Y-m-d H:i:s'));
			# update request

			$this->Leave_model->save($arrsignatory, $request_details['req_id']);
			$this->session->set_flashdata('strSuccessMsg','Employee request has been '.strtolower($arrPost['selob_stat']));
		endif;
		redirect('hr/notification');
	}

	// Certify PDS
	public function certify_pds()
	{
		$reqid = $_GET['req_id'];
		$arrrequest = $this->update_pds_model->getpds_request($_GET['req_id']);
		$pds_details = isset($arrrequest) ? explode(';',$arrrequest['requestDetails']) : array();
		
		if($_GET['status'] == 'profile'):
			$arr_personal = array(
							'surname' => 	$pds_details[1],
							'firstname' => 	$pds_details[2],
							'middlename' => 	$pds_details[3],
							'nameExtension' => 	$pds_details[4],
							'birthday' => 	$pds_details[5],
							'birthPlace' => 	$pds_details[6],
							'civilStatus' => 	$pds_details[7],
							'weight' => 	$pds_details[8],
							'height' => 	$pds_details[9],
							'bloodType' => 	$pds_details[10],
							'gsisNumber' => 	$pds_details[11],
							'businessPartnerNumber' => 	$pds_details[12],
							'pagibigNumber' => 	$pds_details[13],
							'philHealthNumber' => 	$pds_details[14],
							'tin' => 	$pds_details[15],
							'lot1' => 	$pds_details[16],
							'street1' => 	$pds_details[17],
							'subdivision1' => 	$pds_details[18],
							'barangay1' => 	$pds_details[19],
							'city1' => 	$pds_details[20],
							'province1' => 	$pds_details[21],
							'zipCode1' => 	$pds_details[22],
							'telephone1' => 	$pds_details[23],
							'lot2' => 	$pds_details[24],
							'street2' => 	$pds_details[25],
							'subdivision2' => 	$pds_details[26],
							'barangay2' => 	$pds_details[27],
							'city2' => 	$pds_details[28],
							'province2' => 	$pds_details[29],
							'zipCode2' => 	$pds_details[30],
							'telephone2' => 	$pds_details[31],
							'email' => 	$pds_details[32],
							'mobile' => 	$pds_details[33]);

			$this->update_pds_model->save_personal($arr_personal,$arrrequest['empNumber']);
		endif;

		if($_GET['status'] == 'family'):
			$arr_personal = array(
							'spouseSurname' => 	$pds_details[1],
							'spouseFirstname' => 	$pds_details[2],
							'spouseMiddlename' => 	$pds_details[3],
							'spousenameExtension' => 	$pds_details[4],
							'spouseWork' => 	$pds_details[5],
							'spouseBusName' => 	$pds_details[6],
							'spouseBusAddress' => 	$pds_details[7],
							'spouseTelephone' => 	$pds_details[8],
							'fatherSurname' => 	$pds_details[9],
							'fatherFirstname' => 	$pds_details[10],
							'fatherMiddlename' => 	$pds_details[11],
							'fathernameExtension' => 	$pds_details[12],
							'motherSurname' => 	$pds_details[13],
							'motherFirstname' => 	$pds_details[14],
							'motherMiddlename' => 	$pds_details[15],
							'parentAddress' => 	$pds_details[16]);

			$this->update_pds_model->save_personal($arr_personal,$arrrequest['empNumber']);
		endif;

		if($_GET['status'] == 'educ'):
			
			$arr_educ = array(
							'empNumber'		=>  $arrrequest['empNumber'],
							'levelCode' 	=> 	$pds_details[1],
							'schoolName' 	=> 	$pds_details[2],
							'courseCode' 	=> 	$pds_details[3],
							'schoolFromDate'=> 	$pds_details[4],
							'schoolToDate' 	=> 	$pds_details[5],
							'units' 		=> 	$pds_details[6],
							'ScholarshipCode'=>	$pds_details[7],
							'honors' 		=> 	$pds_details[8],
							'licensed' 		=> 	$pds_details[9],
							'graduated' 	=> 	$pds_details[10],
							'yearGraduated' => 	$pds_details[11]);
			if($pds_details[12] == ''):
				$this->update_pds_model->save_school($arr_educ);
			else:
				$this->update_pds_model->update_school($arr_educ, $pds_details[12]);
			endif;
		endif;

		if($_GET['status'] == 'training'):
			$arr_training = array(
							'empNumber'			=>  $arrrequest['empNumber'],
							'trainingTitle'		=> 	$pds_details[1],
							'trainingStartDate'	=> 	($pds_details[2] == '' ? NULL : $pds_details[2]),
							'trainingEndDate'	=> 	($pds_details[3] == '' ? NULL : $pds_details[3]),
							'trainingHours'		=> 	$pds_details[4],
							'trainingTypeofLD'	=> 	$pds_details[5],
							'trainingConductedBy'	=> 	$pds_details[6],
							'trainingVenue'		=>	$pds_details[7],
							'trainingCost'		=> 	$pds_details[8],
							'trainingContractDate'	=> 	($pds_details[9] == '' ? NULL : $pds_details[9]));

			if($pds_details[10] == ''):
				$this->update_pds_model->save_training($arr_training);
			else:
				$this->update_pds_model->update_training($arr_training, $pds_details[10]);
			endif;
		endif;

		if($_GET['status'] == 'exam'):
			$arr_exam = array(
							'empNumber'		=>  $arrrequest['empNumber'],
							'examCode'		=> 	$pds_details[1],
							'examRating'	=> 	$pds_details[2],
							'examDate'		=> 	($pds_details[3] == '' ? NULL : $pds_details[3]),
							'examPlace'		=> 	$pds_details[4],
							'licenseNumber'	=> 	$pds_details[5],
							'dateRelease'	=> 	$pds_details[6]);

			if($pds_details[7] == ''):
				$this->update_pds_model->save_eligibility($arr_exam);
			else:
				$this->update_pds_model->update_eligibility($arr_exam, $pds_details[7]);
			endif;
		endif;

		if($_GET['status'] == 'child'):
			$arr_children = array(
							'empNumber'		=>  $arrrequest['empNumber'],
							'childName'		=> 	$pds_details[1],
							'childBirthDate'=> 	($pds_details[2] == '' ? NULL : $pds_details[2]));

			if($pds_details[3] == ''):
				$this->update_pds_model->save_children($arr_children);
			else:
				$this->update_pds_model->update_children($arr_children, $pds_details[3]);
			endif;
		endif;

		if($_GET['status'] == 'tax'):
			$arr_personal = array(
							'comTaxNumber' 	=> 	$pds_details[1],
							'issuedAt'		=> 	$pds_details[2],
							'issuedOn' 		=> 	$pds_details[3]);

			$this->update_pds_model->save_personal($arr_personal,$arrrequest['empNumber']);
		endif;

		if($_GET['status'] == 'ref'):
			$arr_refs = array(
							'empNumber'		=>  $arrrequest['empNumber'],
							'refName'		=> 	$pds_details[1],
							'refAddress'	=> 	$pds_details[2],
							'refTelephone'	=> 	$pds_details[3]);

			if($pds_details[4] == ''):
				$this->update_pds_model->save_reference($arr_refs);
			else:
				$this->update_pds_model->update_reference($arr_refs, $pds_details[4]);
			endif;
		endif;

		if($_GET['status'] == 'vol'):
			$arr_vols = array(
							'empNumber'		=>  $arrrequest['empNumber'],
							'vwName'		=> 	$pds_details[1],
							'vwAddress'		=> 	$pds_details[2],
							'vwDateFrom'	=> 	$pds_details[3],
							'vwDateTo'		=> 	$pds_details[4],
							'vwHours'		=> 	$pds_details[5],
							'vwPosition'	=> 	$pds_details[6]);

			if($pds_details[7] == ''):
				$this->update_pds_model->save_voluntary($arr_vols);
			else:
				$this->update_pds_model->update_voluntary($arr_vols, $pds_details[7]);
			endif;
		endif;

		if($_GET['status'] == 'wxp'):
			$arr_xps = array(
							'empNumber'		=>  $arrrequest['empNumber'],
							'serviceFromDate' => $pds_details[1],
							'serviceToDate' => $pds_details[2],
							'positionDesc' 	=> $pds_details[3],
							'stationAgency' => $pds_details[4],
							'salary' 		=> $pds_details[5],
							'salaryPer' 	=> $pds_details[6],
							'currency' 		=> $pds_details[7],
							'salaryGrade' 	=> $pds_details[8],
							'appointmentCode' => $pds_details[9],
							'governService' => $pds_details[10],
							'branch' 		=> $pds_details[11],
							'serviceRecID' => $pds_details[12],
							'separationDate' => $pds_details[13],
							'lwop' 			 => $pds_details[14]);

			if($pds_details[15] == ''):
				$this->update_pds_model->save_workxp($arr_xps);
			else:
				$this->update_pds_model->update_workxp($arr_xps, $pds_details[15]);
			endif;
		endif;

		$arrto_signatory = array(
			'requestStatus'	=> 'Certified',
			'statusDate'	=> date('Y-m-d'),
			'remarks'		=> $txtremarks,
			'signatory'		=> $_SESSION['sessEmpNo']
		);
		
		$arremp_signature = $this->Request_model->get_signature($arrrequest['requestCode']);
		$arrto_signatory = array_merge($arrto_signatory,$arremp_signature);
		$update_employeeRequest = $this->Request_model->update_employeeRequest($arrto_signatory, $arrrequest['requestID']);
		if(count($update_employeeRequest)>0):
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Update request',json_encode($arr_personal),'');
			$this->session->set_flashdata('strSuccessMsg','Request successfully certify.');
		endif;

		redirect('hr/request?request=pds');
	}



}
