<?php 
/** 
Purpose of file:    Controller for Leave
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('employee/leave_model', 'libraries/user_account_model','hr/hr_model'));
    }

    public function index()
    {
    	# Notification Menu
    	$active_menu = isset($_GET['status']) ? $_GET['status']=='' ? 'All' : $_GET['status'] : 'All';
    	$menu = array('All','Filed Request','Certified','Cancelled','Disapproved');
    	unset($menu[array_search($active_menu, $menu)]);
    	$notif_icon = array('All' => 'list', 'Filed Request' => 'file-text-o', 'Certified' => 'check', 'Cancelled' => 'ban', 'Disapproved' => 'remove');

    	$this->arrData['active_code'] = isset($_GET['code']) ? $_GET['code']=='' ? 'all' : $_GET['code'] : 'all';
    	$this->arrData['arrNotif_menu'] = $menu;
    	$this->arrData['active_menu'] = $active_menu;
    	$this->arrData['notif_icon'] = $notif_icon;

    	$arrleave_request = $this->leave_model->getall_request($_SESSION['sessEmpNo']);
    	if(isset($_GET['status'])):
    		if(strtolower($_GET['status'])!='all'):
    			$leave_request = array();
    			foreach($arrleave_request as $leave):
    				if(strtolower($_GET['status']) == strtolower($leave['requestStatus'])):
    					$leave_request[] = $leave;
    				endif;
    			endforeach;
    			$arrleave_request = $leave_request;
    		endif;
    	endif;
    	$this->arrData['arrleave_request'] = $arrleave_request;
    	$this->template->load('template/template_view', 'employee/leave/leave_list', $this->arrData);
    }

	public function add()
	{
		// $this->arrData['arrUser'] = $this->user_account_model->getData();
		$this->arrData['action'] = 'add';
		$this->arrData['arrUser'] = $this->user_account_model->getEmpDetails();
		$this->arrData['arrEmployees'] = $this->hr_model->getData();
		$this->arrData['arrBalance'] = $this->leave_model->getLatestBalance($_SESSION['sessEmpNo']);
		$this->template->load('template/template_view', 'employee/leave/leave_view', $this->arrData);
	}
	
	function getworking_days()
	{
		$this->load->helper('dtr_helper');
		$this->load->model('libraries/Holiday_model');
		
		$empid = $_GET['empid'];
		$datefrom = $_GET['datefrom'];
		$dateto = $_GET['dateto'];
		$holidays = $this->Holiday_model->getAllHolidates($empid,$datefrom,$dateto);
		$working_days = get_workingdays('','',$holidays,$datefrom,$dateto);
		echo json_encode($working_days);
	}
	
    function add_leave()
    {
    	$arrPost = $this->input->post();
		if(!empty($arrPost)) {
			$curr_leave = $this->leave_model->getleave($arrPost['txtempno'],$arrPost['dtmLeavefrom'],$arrPost['dtmLeaveto']);
			if(count($curr_leave) < 1):
				$attachments = array();
				if($_FILES['userfile']['name'][0]!=''):
					$total = count($_FILES['userfile']['name']);

					for($i=0; $i < $total; $i++):
						if($_FILES['userfile']['name'] != ''):
							$path_parts = pathinfo($_FILES['userfile']['name'][$i]);
							$tmp_file = $_FILES['userfile']['tmp_name'][$i];
							$config['upload_path']   = 'uploads/employees/attachments/leave/'.$arrPost['txtempno'].'/';
							$config['allowed_types'] = '*';
							$config['file_name'] = uniqid().'.'.$path_parts['extension']; 
							$config['overwrite'] = TRUE;

							$this->load->library('upload', $config);
							$this->upload->initialize($config);
								
							if(!is_dir($config['upload_path'])):
								mkdir($config['upload_path'], 0777, TRUE);
							endif;

							if(!move_uploaded_file($tmp_file, $config['upload_path'].$config['file_name'])):
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('strErrorMsg','Error in uploading attachment. Please try again!');
							else:
								$data = $this->upload->data();
								$this->session->set_flashdata('strSuccessMsg','Upload successfully saved.');
							endif;
							$attachments[] = array('fileid' => ($i+1),'filepath' => $config['upload_path'].$config['file_name'], 'filename' => $_FILES['userfile']['name'][$i]);
						endif;
					endfor;
				endif;

				$arrData = array(
					'requestDetails' => implode(';',array($arrPost['strLeavetype'],$arrPost['dtmLeavefrom'],$arrPost['dtmLeaveto'],$arrPost['intDaysApplied'],$arrPost['str1stSignatory'],$arrPost['str2ndSignatory'],$arrPost['strReason'],$arrPost['strIncaseSL'],$arrPost['strIncaseVL'],$arrPost['strDay'],$arrPost['intVL'],$arrPost['intSL'])),	
					'requestDate'	 => date('Y-m-d'),
					'requestStatus'  => 'Filed Request',
					'requestCode'	 => 'Leave',
					'empNumber'		 => $arrPost['txtempno'],
					'file_location'	 => json_encode($attachments));
				$this->leave_model->add_leave_request($arrData);

				$this->session->set_flashdata('strSuccessMsg','Leave has been submitted.');

				if(count($blnReturn) > 0):
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$arrPost['strDay'].' Leave',implode(';',$arrData),'');
				endif;
				redirect('employee/leave');
			else:
				$this->session->set_flashdata('strErrorMsg','Leave already exists.');
				redirect('employee/leave');
			endif;
		}
    }

   	function edit()
    {
    	$arrleave = $this->leave_model->getData($_GET['req_id']);
    	$this->arrData['arrleave'] = $arrleave;

    	$arrPost = $this->input->post();
		if(!empty($arrPost)) {

			$attachments = array();
			$attachments = $arrleave['file_location']!='' ? json_decode($arrleave['file_location'],true) : array();
			$attachment_id = count($attachments) > 0 ? max(array_column($attachments,'fileid')) : 0;
			$total = count($_FILES['userfile']['name']);

			if($_FILES['userfile']['name'][0]!=''):

				for($i=0; $i < $total; $i++):
					if($_FILES['userfile']['name'] != ''):
						$path_parts = pathinfo($_FILES['userfile']['name'][$i]);
						$tmp_file = $_FILES['userfile']['tmp_name'][$i];
						$config['upload_path']   = 'uploads/employees/attachments/officialbusiness/'.$strEmpNum.'/';
						$config['allowed_types'] = '*';
						$config['file_name'] = uniqid().'.'.$path_parts['extension']; 
						$config['overwrite'] = TRUE;

						$attachment_id = $attachment_id + 1;
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
							
						if(!is_dir($config['upload_path'])):
							mkdir($config['upload_path'], 0777, TRUE);
						endif;

						if(!move_uploaded_file($tmp_file, $config['upload_path'].$config['file_name'])):
							$error = array('error' => $this->upload->display_errors());
							$this->session->set_flashdata('strErrorMsg','Please try again!');
						else:
							$data = $this->upload->data();
							$this->session->set_flashdata('strSuccessMsg','Upload successfully saved.');
						endif;
						$attachments[] = array('fileid' => $attachment_id,'filepath' => $config['upload_path'].$config['file_name'], 'filename' => $_FILES['userfile']['name'][$i]);
					endif;
				endfor;
			endif;

			$arrData = array(
				'requestDetails' => implode(';',array($arrPost['strLeavetype'],$arrPost['dtmLeavefrom'],$arrPost['dtmLeaveto'],$arrPost['intDaysApplied'],$arrPost['str1stSignatory'],$arrPost['str2ndSignatory'],$arrPost['strReason'],$arrPost['strIncaseSL'],$arrPost['strIncaseVL'],$arrPost['strDay'],$arrPost['intVL'],$arrPost['intSL'])),	
				'requestDate'	 => date('Y-m-d'),
				'requestStatus'  => 'Filed Request',
				'requestCode'	 => 'Leave',
				'empNumber'		 => $arrPost['txtempno'],
				'file_location'	 => json_encode($attachments));
			$this->leave_model->save($arrData,$_GET['req_id']);

			$this->session->set_flashdata('strSuccessMsg','Leave has been updated.');

			if(count($blnReturn) > 0):
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated request id='.$_GET['req_id'].' Leave',implode(';',$arrData),'');
			endif;
			redirect('employee/leave');
		}

		$this->arrData['arrUser'] = $this->user_account_model->getEmpDetails();
		$this->arrData['arrEmployees'] = $this->hr_model->getData();
		$this->arrData['arrBalance'] = $this->leave_model->getLatestBalance($_SESSION['sessEmpNo']);

		$this->arrData['action'] = 'edit';
		$this->template->load('template/template_view', 'employee/leave/leave_view', $this->arrData);
    }

    public function delete()
    {
    	$fileid = $this->input->post('txtleave_attach_id');
    	$leave = $this->leave_model->getData($_GET['req_id']);
    	$leave_filelocation = $leave['file_location']!='' ? json_decode($leave['file_location'],true) : array();
    	
    	foreach($leave_filelocation as $key=>$detail):
    		if($detail['fileid']==$fileid):
    			unset($leave_filelocation[$key]);
    		endif;
    	endforeach;
    	
    	$arrData = array('file_location' => json_encode($leave_filelocation));
    	$this->leave_model->save($arrData,$_GET['req_id']);

    	log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Remove Attachment in '.$_GET['req_id'].' Leave',implode(';',$arrData),'');
    	$this->session->set_flashdata('strSuccessMsg','File removed successfully.');

    	redirect('employee/leave/edit?req_id='.$_GET['req_id']);
    }

    public function cancel()
    {
    	$arrData = array('requestStatus' => 'Cancelled');
    	$blnReturn = $this->leave_model->save($arrData,$_POST['txtleave_req_id']);
    	if(count($blnReturn)>0):
    		log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Cancel request id = '.$_POST['txtleave_req_id'].' Leave ',implode(';',$arrData),'');
    		$this->session->set_flashdata('strSuccessMsg','Your request has been cancelled.');
    	endif;
    	redirect('employee/leave');
    }

    # begin employee leave balance
    public function leave_balance()
    {
    	$empid = $this->uri->segment(3);
    	$yr = isset($_GET['yr']) ? $_GET['yr'] : date('Y');
    	$this->arrData['leave_balance'] = $this->leave_model->getleave($empid, 0, $yr);

    	$this->template->load('template/template_view','employee/leave/leave_employee_view', $this->arrData);
    }
    # end employee leave balance
}
