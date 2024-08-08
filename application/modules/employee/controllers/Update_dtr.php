<?php 
/** 
Purpose of file:    Controller for DTR update
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_dtr extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('employee/update_dtr_model','libraries/user_account_model','hr/hr_model'));
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

    	$arrdtr_request = $this->update_dtr_model->getall_request($_SESSION['sessEmpNo']);
    	if(isset($_GET['status'])):
    		if(strtolower($_GET['status'])!='all'):
    			$dtr_request = array();
    			foreach($arrdtr_request as $dtr):
    				if(strtolower($_GET['status']) == strtolower($dtr['requestStatus'])):
    					$dtr_request[] = $dtr;
    				endif;
    			endforeach;
    			$arrdtr_request = $dtr_request;
    		endif;
    	endif;
    	$this->arrData['arrdtr_request'] = $arrdtr_request;
    	$this->template->load('template/template_view', 'employee/dtr_update/dtr_list', $this->arrData);
    }

	public function add()
	{
		$this->arrData['arrEmployees'] = $this->hr_model->getData();
		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view', 'employee/dtr_update/dtr_update_view', $this->arrData);
	}

	public function edit()
	{
		$this->arrData['arrEmployees'] = $this->hr_model->getData();
		$arrdtr = $this->update_dtr_model->getData($_GET['req_id']);
		$new_dtr_details = isset($arrdtr) ? explode(';',$arrdtr['requestDetails']) : array();
		$this->arrData['new_dtr_details'] = $new_dtr_details;
		$this->arrData['old_dtr_details'] = isset($arrdtr) || isset($new_dtr_details) ? $this->update_dtr_model->getemployee_dtr($arrdtr['empNumber'],$new_dtr_details[1]) : array();
		$this->arrData['action'] = 'edit';

		$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$dtmDTRupdate = $arrPost['dtmDTRupdate'];
			$strReason   = $arrPost['strReason'];
			// $dtmMonthOf  = $arrPost['dtmMonthOf'];
			// $strEvidence = "";
			// $strSignatory= $arrPost['strSignatory']==0?'':$arrPost['strSignatory'];
			$strSignatory= $arrPost['strSignatory'];

			$dtr_am_in  = $arrPost['dtmMorningIn']!='' ? explode(':',$arrPost['dtmMorningIn']) : explode(':','00:00:00');
			$dtr_am_out = $arrPost['dtmMorningOut']!='' ? explode(':',$arrPost['dtmMorningOut']) : explode(':','00:00:00');
			$dtr_pm_in  = $arrPost['dtmAfternoonIn']!='' ? explode(':',$arrPost['dtmAfternoonIn']) : explode(':','00:00:00');
			$dtr_pm_out = $arrPost['dtmAfternoonOut']!='' ? explode(':',$arrPost['dtmAfternoonOut']) : explode(':','00:00:00');
			$dtr_ot_in  = $arrPost['dtmOvertimeIn']!='' ? explode(':',$arrPost['dtmOvertimeIn']) : explode(':','00:00:00');
			$dtr_ot_out = $arrPost['dtmOvertimeOut']!='' ? explode(':',$arrPost['dtmOvertimeOut']) : explode(':','00:00:00');
			$arrdetails = array('DTR',
								$arrPost['dtmDTRupdate'],
								$arrPost['strOldMorningIn'],
								$arrPost['strOldMorningOut'],
								$arrPost['strOldAfternoonIn'],
								$arrPost['strOldAfternoonOut'],
								$arrPost['strOldOvertimeIn'],
								$arrPost['strOldOvertimeOut'],

								$arrPost['dtmMorningIn'],
								$arrPost['dtmMorningOut'],
								$arrPost['dtmAfternoonIn'],
								$arrPost['dtmAfternoonOut'],
								$arrPost['dtmOvertimeIn'],
								$arrPost['dtmOvertimeOut'],
								
								urlencode($strReason),
								$strSignatory);

			$arrData = array(
						'requestDetails'	=> implode(';',$arrdetails),
						'requestDate'		=> date('Y-m-d'),
						'requestStatus'		=> 'Filed Request',
						'requestCode'		=> 'DTR',
						'empNumber'			=> $_SESSION['sessEmpNo'],
						'signatory'			=> $strSignatory
					);

			$blnReturn  = $this->update_dtr_model->save($arrData, $_GET['req_id']);

			if(count($blnReturn)>0)
			{	
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$dtmDTRupdate.' DTR Update',implode(';',$arrData),'');
				$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
			}
			redirect('employee/update_dtr');
		}
		$this->template->load('template/template_view', 'employee/dtr_update/dtr_update_view', $this->arrData);
	}
	
	public function submit()
    {
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$dtmDTRupdate= $arrPost['dtmDTRupdate'];
			$strReason   = $arrPost['strReason'];
			// $dtmMonthOf  = $arrPost['dtmMonthOf'];
			// $strEvidence = "";
			$strSignatory = $arrPost['strSignatory'];

			$dtr_am_in  = $arrPost['dtmMorningIn']!='' ? explode(':',$arrPost['dtmMorningIn']) : explode(':','00:00:00');
			$dtr_am_out = $arrPost['dtmMorningOut']!='' ? explode(':',$arrPost['dtmMorningOut']) : explode(':','00:00:00');
			$dtr_pm_in  = $arrPost['dtmAfternoonIn']!='' ? explode(':',$arrPost['dtmAfternoonIn']) : explode(':','00:00:00');
			$dtr_pm_out = $arrPost['dtmAfternoonOut']!='' ? explode(':',$arrPost['dtmAfternoonOut']) : explode(':','00:00:00');
			$dtr_ot_in  = $arrPost['dtmOvertimeIn']!='' ? explode(':',$arrPost['dtmOvertimeIn']) : explode(':','00:00:00');
			$dtr_ot_out = $arrPost['dtmOvertimeOut']!='' ? explode(':',$arrPost['dtmOvertimeOut']) : explode(':','00:00:00');
			$arrdetails = array('DTR',
								$arrPost['dtmDTRupdate'],
								$arrPost['strOldMorningIn'],
								$arrPost['strOldMorningOut'],
								$arrPost['strOldAfternoonIn'],
								$arrPost['strOldAfternoonOut'],
								$arrPost['strOldOvertimeIn'],
								$arrPost['strOldOvertimeOut'],

								$arrPost['dtmMorningIn'],
								$arrPost['dtmMorningOut'],
								$arrPost['dtmAfternoonIn'],
								$arrPost['dtmAfternoonOut'],
								$arrPost['dtmOvertimeIn'],
								$arrPost['dtmOvertimeOut'],

								urlencode($strReason),
								$strSignatory);

			if(!empty($dtmDTRupdate))
			{	
				if( count($this->update_dtr_model->checkExist($dtmDTRupdate))==0 )
				{
					$arrData = array(
						'requestDetails'	=> implode(';',$arrdetails),
						'requestDate'		=> date('Y-m-d'),
						'requestStatus'		=> 'Filed Request',
						'requestCode'		=> 'DTR',
						'empNumber'			=> $_SESSION['sessEmpNo'],
						'signatory'			=> $strSignatory
					);

					$blnReturn  = $this->update_dtr_model->submit($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$dtmDTRupdate.' DTR Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
					}
					redirect('employee/update_dtr');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Request already exists.');
					//$this->session->set_flashdata('strOBtype',$strOBtype);
					redirect('employee/update_dtr');
				}
			}
		}
    	$this->template->load('template/template_view','employee/update_dtr/dtr_update_view',$this->arrData);
    }

    public function getinout()
    {
	    $date=$_GET['date'];
	    //$sql= "SELECT inAM,outAM,inPM,outPM,inOT,outOT FROM tblEmpDTR
	     //           WHERE empNumber='".$_SESSION['strEmpNo']."' AND dtrDate='".$year."-".$month."-".$day."' LIMIT 0,1";
		$rsDTR = $this->db->select('inAM,outBreak,inBreak,outPM,inOvertime,outOvertime')->where('empNumber',$_SESSION['sessEmpNo'])->where('dtrDate',$date)->get('tblEmpQRScan')->result_array();
	    //$empdtr=mysql_query($sql);
	    
	    //while($emp=mysql_fetch_array($empdtr)){
		foreach($rsDTR as $emp)
		{
			$inAM = ($emp['inAM'] != null) ? date("g:i A", strtotime($emp['inAM'])) : "";
			$outBreak = ($emp['outBreak'] != null) ? date("g:i A", strtotime($emp['outBreak'])) : "";
			$inBreak = ($emp['inBreak'] != null) ? date("g:i A", strtotime($emp['inBreak'])) : "";
			$outPM = ($emp['outPM'] != null) ? date("g:i A", strtotime($emp['outPM'])) : "";
			$inOvertime = ($emp['inOvertime'] != null) ? date("g:i A", strtotime($emp['inOvertime'])) : "";
			$outOvertime = ($emp['outOvertime'] != null) ? date("g:i A", strtotime($emp['outOvertime'])) : "";

	        echo $inAM.';'.$outBreak.';'.$inBreak.';'.$outPM.';'.$inOvertime.';'.$outOvertime;
	    }
    }

    public function cancel()
    {
    	$arrData = array('requestStatus' => 'Cancelled');
    	$blnReturn = $this->update_dtr_model->save($arrData,$_POST['txtdtr_req_id']);
    	if(count($blnReturn)>0):
    		log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Cancel request id = '.$_POST['txtdtr_req_id'].' Travel Order ',implode(';',$arrData),'');
    		$this->session->set_flashdata('strSuccessMsg','Your request has been cancelled.');
    	endif;
    	redirect('employee/update_dtr');
    }


}
