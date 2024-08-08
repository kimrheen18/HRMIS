<?php 
/** 
Purpose of file:    Controller for Official Business
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
defined('BASEPATH') OR exit('No direct script access allowed');

class Official_business extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('employee/official_business_model'));
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

		$arrob_request = $this->official_business_model->getall_request($_SESSION['sessEmpNo']);
		if(isset($_GET['status'])):
			if(strtolower($_GET['status'])!='all'):
				$ob_request = array();
				foreach($arrob_request as $ob):
					if(strtolower($_GET['status']) == strtolower($ob['requestStatus'])):
						$ob_request[] = $ob;
					endif;
				endforeach;
				$arrob_request = $ob_request;
			endif;
		endif;
		$this->arrData['arrob_request'] = $arrob_request;
		$this->template->load('template/template_view', 'employee/official_business/official_business_list', $this->arrData);
	}

	public function add()
	{
		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view', 'employee/official_business/official_business_view', $this->arrData);
	}

	public function edit()
	{
		$this->arrData['action'] = 'edit';
		$arrob = $this->official_business_model->getData($_GET['req_id']);
		$this->arrData['arrob'] = $arrob;

		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$strEmpNum 		  = $_SESSION['sessEmpNo'];
			$strOBtype		  = $arrPost['strOBtype'];
			$dtmOBrequestdate = $arrPost['dtmOBrequestdate'];
			$dtmOBdatefrom	  = $arrPost['dtmOBdatefrom'];
			$dtmOBdateto	  = $arrPost['dtmOBdateto'];
			$dtmTimeFrom	  = $arrPost['dtmTimeFrom'];
			$dtmTimeTo		  = $arrPost['dtmTimeTo'];
			$strDestination	  = $arrPost['strDestination'];
			$strMeal		  = isset($arrPost['strMeal']) ? $arrPost['strMeal'] : '';
			$strPurpose		  = $arrPost['strPurpose'];
			$strStatus		  = $arrPost['strStatus'];
			$strCode		  = $arrPost['strCode'];

			if(!empty($strOBtype)):
				if(count($this->official_business_model->checkExist($strOBtype, $dtmOBrequestdate))==0):
					$attachments = $arrob['file_location']!='' ? json_decode($arrob['file_location'],true) : array();
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
							'requestDetails' => $strOBtype.';'.$dtmOBrequestdate.';'.$dtmOBdatefrom.';'.$dtmOBdateto.';'.$dtmTimeFrom.';'.$dtmTimeTo.';'.$strDestination.';'.$strPurpose.';'.$strMeal,
							'requestDate'	 => $dtmOBrequestdate,
							'requestStatus'  => $strStatus,
							'requestCode'	 => $strCode,
							'file_location'	 => json_encode($attachments));
					
					$blnReturn  = $this->official_business_model->save($arrData,$_GET['req_id']);

					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Update '.$strOBtype.' Official Business',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Your request has been submitted.');
					endif;
					redirect('employee/official_business');

				else:	
					$this->session->set_flashdata('strErrorMsg','Request already exists.');
					redirect('employee/official_business');
				endif;
			endif;
		endif;

		$this->template->load('template/template_view', 'employee/official_business/official_business_view', $this->arrData);
	}

	public function cancel()
	{
		$arrData = array('requestStatus' => 'Cancelled');
		$blnReturn = $this->official_business_model->save($arrData,$_POST['txtob_req_id']);
		if(count($blnReturn)>0):
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Cancel request id = '.$_POST['txtob_req_id'].' Official Business',implode(';',$arrData),'');
			$this->session->set_flashdata('strSuccessMsg','Your request has been cancelled.');
		endif;
		redirect('employee/official_business');
	}

	public function delete()
	{
		$fileid = $this->input->post('txtob_attach_id');
		$ob = $this->official_business_model->getData($_GET['req_id']);
		$ob_filelocation = $ob['file_location']!='' ? json_decode($ob['file_location'],true) : array();
		
		foreach($ob_filelocation as $key=>$detail):
			if($detail['fileid']==$fileid):
				unset($ob_filelocation[$key]);
			endif;
		endforeach;
		
		$arrData = array('file_location' => json_encode($ob_filelocation));
		$this->official_business_model->save($arrData,$_GET['req_id']);

		log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Remove Attachment in '.$_GET['req_id'].' Official Business',implode(';',$arrData),'');
		$this->session->set_flashdata('strSuccessMsg','File removed successfully.');

		redirect('employee/official_business/edit?req_id='.$_GET['req_id']);
	}
	
	public function submit()
    {
    	$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$strEmpNum 		  = $_SESSION['sessEmpNo'];
			$strOBtype		  = $arrPost['strOBtype'];
			$dtmOBrequestdate = $arrPost['dtmOBrequestdate'];
			$dtmOBdatefrom	  = $arrPost['dtmOBdatefrom'];
			$dtmOBdateto	  = $arrPost['dtmOBdateto'];
			$dtmTimeFrom	  = $arrPost['dtmTimeFrom'];
			$dtmTimeTo		  = $arrPost['dtmTimeTo'];
			$strDestination	  = $arrPost['strDestination'];
			$strMeal		  = isset($arrPost['strMeal']) ? $arrPost['strMeal'] : '';
			$strPurpose		  = $arrPost['strPurpose'];
			$strStatus		  = $arrPost['strStatus'];
			$strCode		  = $arrPost['strCode'];

			if(!empty($strOBtype)):
				if(count($this->official_business_model->checkExist($strOBtype, $dtmOBrequestdate))==0):
					
					$attachments = array();
					if($_FILES['userfile']['name'][0]!=''):
						$total = count($_FILES['userfile']['name']);

						for($i=0; $i < $total; $i++):
							if($_FILES['userfile']['name'] != ''):
								$path_parts = pathinfo($_FILES['userfile']['name'][$i]);
								$tmp_file = $_FILES['userfile']['tmp_name'][$i];
								$config['upload_path']   = 'uploads/employees/attachments/officialbusiness/'.$strEmpNum.'/';
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
							'requestDetails' => $strOBtype.';'.$dtmOBrequestdate.';'.$dtmOBdatefrom.';'.$dtmOBdateto.';'.$dtmTimeFrom.';'.$dtmTimeTo.';'.$strDestination.';'.$strPurpose.';'.$strMeal,
							'requestDate'	 => $dtmOBrequestdate,
							'requestStatus'  => $strStatus,
							'requestCode'	 => $strCode,
							'empNumber'		 => $_SESSION['sessEmpNo'],
							'file_location'	 => json_encode($attachments));
					$blnReturn  = $this->official_business_model->submit($arrData);

					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strOBtype.' Official Business',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Your request has been submitted.');
					endif;
					redirect('employee/official_business');

				else:	
					$this->session->set_flashdata('strErrorMsg','Request already exists.');
					redirect('employee/official_business');
				endif;
			endif;

		endif;

    	$this->template->load('template/template_view','employee/official_business/official_business_view',$this->arrData);
    }	

}
