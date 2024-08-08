<?php 
/** 
Purpose of file:    Controller for Travel Order
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
defined('BASEPATH') OR exit('No direct script access allowed');

class Travel_order extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('employee/travel_order_model'));
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

    	$arrto_request = $this->travel_order_model->getall_request($_SESSION['sessEmpNo']);
    	if(isset($_GET['status'])):
    		if(strtolower($_GET['status'])!='all'):
    			$leave_request = array();
    			foreach($arrto_request as $leave):
    				if(strtolower($_GET['status']) == strtolower($leave['requestStatus'])):
    					$leave_request[] = $leave;
    				endif;
    			endforeach;
    			$arrto_request = $leave_request;
    		endif;
    	endif;
    	$this->arrData['arrto_request'] = $arrto_request;
    	$this->template->load('template/template_view', 'employee/travel_order/to_list', $this->arrData);
    }

	public function add()
	{
		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view', 'employee/travel_order/travel_order_view', $this->arrData);
	}
	
	public function submit()
    {
    	$arrPost = $this->input->post();
		if(!empty($arrPost)):
		
			$strDestination	= urlencode($arrPost['strDestination']);
			$dtmTOdatefrom	= $arrPost['dtmTOdatefrom'];
			$dtmTOdateto	= $arrPost['dtmTOdateto'];
			$strPurpose		= urlencode($arrPost['strPurpose']);
			$strMeal		= $arrPost['strMeal'];
			$sFunds			= $arrPost['sFunds'];
			$strStatus		= $arrPost['strStatus'];
			$strCode		= $arrPost['strCode'];
			$str_details	= $strDestination.';'.$dtmTOdatefrom.';'.$dtmTOdateto.';'.$strPurpose.';'.$strMeal;

			if(!empty($strDestination) && !empty($dtmTOdatefrom)):	
				//if(count($this->travel_order_model->checkExist($str_details))==0):

					$attachments = array();
					if($_FILES['userfile']['name'][0]!=''):
						$total = count($_FILES['userfile']['name']);

						for($i=0; $i < $total; $i++):
							if($_FILES['userfile']['name'] != ''):
								$path_parts = pathinfo($_FILES['userfile']['name'][$i]);
								$tmp_file = $_FILES['userfile']['tmp_name'][$i];
								$config['upload_path']   = 'uploads/employees/attachments/travel_order/'.$arrPost['txtempno'].'/';
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
							'requestDetails'=>$str_details,
							'requestDate'=>date('Y-m-d'),
							'requestStatus'=>$strStatus,
							'requestCode'=>$strCode,
							'empNumber'=>$_SESSION['sessEmpNo'],
							'file_location'	 => json_encode($attachments),
							'sourceFunds' => $sFunds);

					$blnReturn  = $this->travel_order_model->submit($arrData);

					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strDestination.' Travel Order',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
					endif;
					redirect('employee/travel_order');
				// else:	
				// 	$this->session->set_flashdata('strErrorMsg','Request already exists.');
				// 	redirect('employee/travel_order');
				// endif;
			endif;

		endif;
    	$this->template->load('template/template_view','employee/travel_order/travel_order_view',$this->arrData);
    }

    public function edit()
    {
    	$arrto = $this->travel_order_model->getData($_GET['req_id']);
    	$this->arrData['arrto'] = $arrto;
    	$arrPost = $this->input->post();
		if(!empty($arrPost)):
		
			$strDestination	= urlencode($arrPost['strDestination']);
			$dtmTOdatefrom	= $arrPost['dtmTOdatefrom'];
			$dtmTOdateto	= $arrPost['dtmTOdateto'];
			$strPurpose		= urlencode($arrPost['strPurpose']);
			$strMeal		= $arrPost['strMeal'];
			$strStatus		= $arrPost['strStatus'];
			$strCode		= $arrPost['strCode'];
			$sFunds         = $arrPost['sFunds'];
			$str_details	= $strDestination.';'.$dtmTOdatefrom.';'.$dtmTOdateto.';'.$strPurpose.';'.$strMeal;

			if(!empty($strDestination) && !empty($dtmTOdatefrom)):
				$attachments = array();
				$attachments = $arrto['file_location']!='' ? json_decode($arrto['file_location'],true) : array();
				$attachment_id = count($attachments) > 0 ? max(array_column($attachments,'fileid')) : 0;
				$total = count($_FILES['userfile']['name']);

				if($_FILES['userfile']['name'][0]!=''):
					for($i=0; $i < $total; $i++):
						if($_FILES['userfile']['name'] != ''):
							$path_parts = pathinfo($_FILES['userfile']['name'][$i]);
							$tmp_file = $_FILES['userfile']['tmp_name'][$i];
							$config['upload_path']   = 'uploads/employees/attachments/travel_order/'.$strEmpNum.'/';
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
						'requestDetails'=>$str_details,
						'requestDate'=>date('Y-m-d'),
						'requestStatus'=>$strStatus,
						'requestCode'=>$strCode,
						'empNumber'=>$_SESSION['sessEmpNo'],
						'sourceFunds'=>$sFunds,
						'file_location'	 => json_encode($attachments));
				$blnReturn  = $this->travel_order_model->save($arrData,$_GET['req_id']);

				if(count($blnReturn)>0):
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strDestination.' Travel Order ',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
				endif;
				redirect('employee/travel_order');
			endif;

		endif;

		$this->arrData['action'] = 'edit';
    	$this->template->load('template/template_view', 'employee/travel_order/travel_order_view', $this->arrData);
    }

    public function delete()
    {
    	$fileid = $this->input->post('txtto_attach_id');
    	$to = $this->travel_order_model->getData($_GET['req_id']);
    	$to_filelocation = $to['file_location']!='' ? json_decode($to['file_location'],true) : array();
    	
    	foreach($to_filelocation as $key=>$detail):
    		if($detail['fileid']==$fileid):
    			unset($to_filelocation[$key]);
    		endif;
    	endforeach;
    	
    	$arrData = array('file_location' => json_encode($to_filelocation));
    	$this->travel_order_model->save($arrData,$_GET['req_id']);

    	log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Remove Attachment in '.$_GET['req_id'].' Travel Order',implode(';',$arrData),'');
    	$this->session->set_flashdata('strSuccessMsg','File removed successfully.');

    	redirect('employee/travel_order/edit?req_id='.$_GET['req_id']);
    }

    public function cancel()
    {
    	$arrData = array('requestStatus' => 'Cancelled');
    	$blnReturn = $this->travel_order_model->save($arrData,$_POST['txtto_req_id']);
    	if(count($blnReturn)>0):
    		log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Cancel request id = '.$_POST['txtto_req_id'].' Travel Order ',implode(';',$arrData),'');
    		$this->session->set_flashdata('strSuccessMsg','Your request has been cancelled.');
    	endif;
    	redirect('employee/travel_order');
    }



}
