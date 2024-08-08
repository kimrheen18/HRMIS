<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/Request_model','employee/Notification_model'));
    }

	public function index()
	{
		$arrRequest = array();
		$forhr_requests = array();
		
		# Notification Menu
		$active_menu = isset($_GET['status']) ? $_GET['status']=='' ? 'All' : $_GET['status'] : 'All';
		$menu = array('All','Filed Request','Certified','Cancelled','Disapproved');
		unset($menu[array_search($active_menu, $menu)]);
		$notif_icon = array('All' => 'list', 'Filed Request' => 'file-text-o', 'Certified' => 'check', 'Cancelled' => 'ban', 'Disapproved' => 'remove');

		# Request Type Menu
		$active_code = isset($_GET['code']) ? $_GET['code']=='' ? 'all' : $_GET['code'] : 'all';
		$codes = $this->Request_model->request_code();
		$codes[count($codes)] = array('requestCode' => 'all');
		unset($codes[array_search($active_code, array_column($codes, 'requestCode'))]);

		# HR Notification
		if($this->session->userdata('sessUserLevel') == 1):
			$requestFlow = $this->Request_model->getRequestFlow('HR');
			$emp_requests = $this->Request_model->employee_request(curryr(),currmo(),0,$active_menu == 'All' ? '' : $active_menu, $active_code);
			$arrRequest = $this->Notification_model->check_request_flow_and_signatories($requestFlow,$emp_requests);
			
			foreach($arrRequest as $req):
				$req['req_desti'] = $this->Notification_model->getDestination($req['req_nextsign']);
				$req['req_empname'] = employee_name($req['req_emp']);
				array_push($forhr_requests,$req);
			endforeach;
			// $forhr_requests = $this->Notification_model->gethr_requestflow($requests);
		endif;
		
		$this->arrData['request_codes'] = $codes;
		$this->arrData['active_code'] = isset($_GET['code']) ? $_GET['code']=='' ? 'all' : $_GET['code'] : 'all';

		$this->arrData['arrRequest'] = $forhr_requests;
		$this->arrData['arrNotif_menu'] = $menu;
		$this->arrData['active_menu'] = $active_menu;
		$this->arrData['notif_icon'] = $notif_icon;

		$this->template->load('template/template_view', 'hr/notification/notification_view', $this->arrData);
	}


}
