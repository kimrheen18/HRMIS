<?php 
/** 
Purpose of file:    Controller for Compensatory Time Off
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compensatory_leave extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('employee/compensatory_leave_model','hr/hr_model'));
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

    	$arrcl_request = $this->compensatory_leave_model->getall_request($_SESSION['sessEmpNo']);
    	if(isset($_GET['status'])):
    		if(strtolower($_GET['status'])!='all'):
    			$cl_request = array();
    			foreach($arrcl_request as $cl):
    				if(strtolower($_GET['status']) == strtolower($cl['requestStatus'])):
    					$cl_request[] = $cl;
    				endif;
    			endforeach;
    			$arrcl_request = $cl_request;
    		endif;
    	endif;
    	$this->arrData['arrcl_request'] = $arrcl_request;
    	$this->template->load('template/template_view', 'employee/compensatory_leave/cl_list', $this->arrData);
    }

	public function add()
	{
		$this->arrData['arrEmployees'] = $this->hr_model->getData();
		$this->arrData['arrLB'] = $this->compensatory_leave_model->getOffsetBal();
		$this->template->load('template/template_view', 'employee/compensatory_leave/compensatory_leave_view', $this->arrData);
	}
	
	public function submit()
    {
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$dtmComLeave	 = $arrPost['dtmComLeave'];
			$dtmMorningIn	 = $arrPost['dtmMorningIn'];
			$dtmMorningOut	 = $arrPost['dtmMorningOut'];
			$dtmAfternoonIn	 = $arrPost['dtmAfternoonIn'];
			$dtmAfternoonOut = $arrPost['dtmAfternoonOut'];
			$strPurpose		 = $arrPost['strPurpose'];
			$strRecommend 	 = $arrPost['strRecommend'] == '0' ? '' : $arrPost['strRecommend'];
			$strApproval 	 = $arrPost['strApproval'] == '0' ? '' : $arrPost['strApproval'];
			$strStatus		 = $arrPost['strStatus'];
			$strCode 		 = $arrPost['strCode'];
			if(!empty($dtmComLeave))
			{	
				if( count($this->compensatory_leave_model->checkExist($dtmComLeave))==0 )
				{
					$arrData = array(
						'requestDetails'=>$dtmComLeave.';'.$dtmMorningIn.';'.$dtmMorningOut.';'.$dtmAfternoonIn.';'.$dtmAfternoonOut.';'.$strPurpose,
						'signatory'=>$strRecommend.';'.$strApproval,
						'requestDate'=>date('Y-m-d'),
						'requestStatus'=>$strStatus,
						'requestCode'=>$strCode,
						'empNumber'=>$_SESSION['sessEmpNo']
					
					);
					$blnReturn  = $this->compensatory_leave_model->submit($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$dtmComLeave.' Official Business',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
					}
					redirect('employee/compensatory_leave');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Request already exists.');
					//$this->session->set_flashdata('strOBtype',$strOBtype);
					redirect('employee/compensatory_leave');
				}
			}
		}
    	$this->template->load('template/template_view','employee/compensatory_leave/compensatory_leave_view',$this->arrData);
    }

    public function certify_offset()
    {
    	$this->load->model(array('hr/Attendance_summary_model'));
    	$arrPost = $this->input->post();
    	$dtr_update = 0;
    	$allcertified_id = explode(';',$arrPost['txtallcertified_id']);
    	$arrPost['certified_ot'] = array_merge($arrPost['certified_ot'],$allcertified_id);
    	
    	foreach(json_decode($arrPost['txtot_id'],1) as $cto):
    		$dtr = $this->Attendance_summary_model->getData($cto);

    		$arrData = array();
    		if($dtr['OT'] == 1):
    			if(isset($arrPost['certified_ot'])):
	    			if(!in_array($cto,$arrPost['certified_ot'])):
	    				$arrData = array('OT' => 0, 'name' => $dtr['name'].';'.$_SESSION['sessName'], 'ip' => $dtr['ip'].';'.$this->input->ip_address(), 'editdate' => $dtr['editdate'].';'.date('Y-m-d H:i:s A'));
	    			endif;
	    		endif;
    		else:
    			if(isset($arrPost['certified_ot'])):
					if(in_array($cto,$arrPost['certified_ot'])):
						$arrData = array('OT' => 1, 'name' => $dtr['name'].';'.$_SESSION['sessName'], 'ip' => $dtr['ip'].';'.$this->input->ip_address(), 'editdate' => $dtr['editdate'].';'.date('Y-m-d H:i:s A'));
					endif;    			
				endif;
    		endif;
    		if(!empty($arrData)):
    			$this->Attendance_summary_model->edit_dtr($arrData, $cto);
    			$dtr_update++;
    		endif;
    	endforeach;
    	
    	if($dtr_update > 0):
    		$this->session->set_flashdata('strSuccessMsg','Certify offset successfully saved.');
    		redirect('hr/attendance_summary/dtr/'.$this->uri->segment(4).'?datefrom='.currdfrom().'&dateto='.currdto());
    	else:
    		$this->session->set_flashdata('strErrorMsg','All offset has been certified.');
    		redirect('hr/attendance_summary/dtr/certify_offset/'.$this->uri->segment(4).'?datefrom='.currdfrom().'&dateto='.currdto());
    	endif;
    }

    public function cancel()
    {
        $arrData = array('requestStatus' => 'Cancelled');
        $blnReturn = $this->compensatory_leave_model->save($arrData,$_POST['txtcto_req_id']);
        if(count($blnReturn)>0):
            log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Cancel request id = '.$_POST['txtcto_req_id'].' Compensatory Time Off ',implode(';',$arrData),'');
            $this->session->set_flashdata('strSuccessMsg','Your request has been cancelled.');
        endif;
        redirect('employee/compensatory_leave');
    }



}
