<?php 
/** 
Purpose of file:    Controller for Leave_monetization
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_monetization extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('employee/leave_monetization_model','leave_model'));
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

    	$arrmone_request = $this->leave_monetization_model->getall_request($_SESSION['sessEmpNo']);
    	if(isset($_GET['status'])):
    		if(strtolower($_GET['status'])!='all'):
    			$mone_request = array();
    			foreach($arrmone_request as $mone):
    				if(strtolower($_GET['status']) == strtolower($mone['requestStatus'])):
    					$mone_request[] = $mone;
    				endif;
    			endforeach;
    			$arrmone_request = $mone_request;
    		endif;
    	endif;
    	$this->arrData['arrmone_request'] = $arrmone_request;
    	$this->template->load('template/template_view', 'employee/leave_monetization/leave_monetization_list', $this->arrData);
    }

	public function add()
	{
		$this->arrData['action'] = 'add';
        $this->arrData['arrData'] = $this->leave_monetization_model->getData();
		$this->arrData['arrBalance'] = $this->leave_model->getLatestBalance($_SESSION['sessEmpNo']);
		$this->template->load('template/template_view', 'employee/leave_monetization/leave_monetization_view', $this->arrData);
	}

    public function edit()
    {
        $this->arrData['action'] = 'edit';
        $this->arrData['arrmone'] = $this->leave_monetization_model->getrequest($_GET['req_id']);
        $this->arrData['arrData'] = $this->leave_monetization_model->getData();
        $this->arrData['arrBalance'] = $this->leave_model->getLatestBalance($_SESSION['sessEmpNo']);

        $arrPost = $this->input->post();
        if(!empty($arrPost)):

            $MonetizedVL=$arrPost['MonetizedVL'];
            $MonetizedSL=$arrPost['MonetizedSL'];
            $strStatus=$arrPost['strStatus'];
            $strCode=$arrPost['strCode'];
            $commutation=$arrPost['commutation'];
            $strReason=$arrPost['strReason'];
            $arrData = array(
                        'requestDetails'=>$MonetizedVL.';'.$MonetizedSL.';'.$commutation.';'.$strReason,
                        'requestDate'=>date('Y-m-d'),
                        'requestStatus'=>$strStatus,
                        'requestCode'=>$strCode,
                        'empNumber'=>$_SESSION['sessEmpNo']
                        // 'requestStatus'=>
                    );
            $blnReturn  = $this->leave_monetization_model->save($arrData,$_GET['req_id']);

            log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpLeaveMonetization','Updated '.$strCode.' Leave Monetization',implode(';',$arrData),'');
            $this->session->set_flashdata('strSuccessMsg','Your Request has been updated.');

            redirect('employee/leave_monetization');
        endif;

        $this->template->load('template/template_view', 'employee/leave_monetization/leave_monetization_view', $this->arrData);
    }
	
	public function submit()
    {
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$MonetizedVL     = $arrPost['MonetizedVL'];
			$MonetizedSL     = $arrPost['MonetizedSL'];
			$strStatus       = $arrPost['strStatus'];
			$strCode         = $arrPost['strCode'];
			$strvlBalance    = $arrPost['txtvlBalance'];
            $strslBalance    = $arrPost['txtslBalance'];
            $strperiodMonth  = $arrPost['txtperiodMonth'];
            $strperiodYear   = $arrPost['txtperiodYear'];
            $commutation     = $arrPost['commutation'];
			$strReason       = $arrPost['strReason'];
            $strDetails      = implode(';',array($MonetizedVL,$MonetizedSL,$strvlBalance,$strslBalance,$strperiodMonth,$strperiodYear,$commutation,$strReason));


			if(!empty($MonetizedVL) && !empty($MonetizedSL))
			{	
                if(count($this->leave_monetization_model->checkExist($strDetails))==0)
				{
					$arrData = array(
						'requestDetails'  => $strDetails,
						'requestDate'     => date('Y-m-d'),
						'requestStatus'   => $strStatus,
						'requestCode'     => 'Monetization',
						'empNumber'       => $_SESSION['sessEmpNo'],
						'requestStatus'   => 'Filed Request'
					);
					$blnReturn  = $this->leave_monetization_model->submit($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpLeaveMonetization','Added '.$strCode.' Leave Monetization',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Your Request has been submitted.');
					}
					redirect('employee/leave_monetization');
				}
				else
				{	
					$this->session->set_flashdata('strMsg','Request already exists.');
					redirect('employee/leave_monetization');
				}
			}
		}
    	$this->template->load('template/template_view','employee/leave_monetization/leave_monetization_view',$this->arrData);
    }

    # HR Leave Monetization
    public function monetized_leave()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(4);
    	if(!empty($arrPost)):

    		$arrData=array(
    			'empNumber' 	=> $empid,
    			'vlMonetize'	=> $arrPost['txtvl'],
    			'slMonetize'	=> $arrPost['txtsl'],
    			'processMonth'	=> date('m'),
    			'processYear' 	=> date('Y'),
    			'monetizeMonth'	=> $arrPost['txtperiodmo'],
    			'monetizeYear' 	=> $arrPost['txtperiodyr'],
    			'monetizeAmount'=> str_replace(',','',$arrPost['txtmone_amt']),
    			'processBy'		=> $_SESSION['sessName'],
    			'ip'	    	=> $this->input->ip_address(),
    			'processDate'	=> date('Y-m-d h:i:s A'));
    			
    		$this->leave_monetization_model->addemp_monetized($arrData);
    		$this->session->set_flashdata('strSuccessMsg','Monetized Leave added successfully.');
    		redirect('hr/attendance_summary/leave_monetization/'.$empid.'?month='.date('m').'&yr='.date('Y'));
    	endif;
    }

	# HR Leave Monetization
    public function monetized_rollback()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(4);
    	if(!empty($arrPost)):
    		$this->leave_monetization_model->delete_monetized($arrPost['txt_monid']);
    		$this->session->set_flashdata('strSuccessMsg','Monetized Leave rollback successfully.');
    		redirect('hr/attendance_summary/leave_monetization/'.$empid.'?month='.date('m').'&yr='.date('Y'));
    	endif;
    }

    public function cancel()
    {
        $arrData = array('requestStatus' => 'Cancelled');
        $blnReturn = $this->leave_monetization_model->save($arrData,$_POST['txtmone_req_id']);
        if(count($blnReturn)>0):
            log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Cancel request id = '.$_POST['txtmone_req_id'].' Leave Monetization ',implode(';',$arrData),'');
            $this->session->set_flashdata('strSuccessMsg','Your request has been cancelled.');
        endif;
        redirect('employee/leave_monetization');
    }
    


}
