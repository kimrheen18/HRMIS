<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {
	var $arrData;
	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/User_account_model','login/Login_model'));
    }

	public function index()
	{
		$fingerprint = isset($_GET['fingerprint']) ? $_GET['fingerprint'] : '';
		$empid = isset($_GET['empid']) ? $_GET['empid'] : '';
		if($fingerprint=='!7D$0@9'):
			if($empid==''):
				echo json_encode($this->User_account_model->getemployee_forapi());
			else:
				echo json_encode($this->User_account_model->getemployee_forapi($empid));
			endif;
		else:
			echo json_encode('');
		endif;
	}

	public function hrmis_login()
	{
		$fingerprint = isset($_GET['fingerprint']) ? $_GET['fingerprint'] : '';
		$uname = isset($_GET['uname']) ? $_GET['uname'] : '';
		$pass = isset($_GET['pass']) ? $_GET['pass'] : '';
		if($fingerprint=='!7D$0@9'):
			if($uname!='' && $pass!=''):
				$arruser = $this->Login_model->authenticate($uname,$pass);
				if(count($arruser) > 0):
					echo json_encode($this->User_account_model->getemployee_forapi($arruser[0]['empNumber']));
				else:
					echo json_encode(array());
				endif;
			else:
				echo json_encode(array());
			endif;
		else:
			echo json_encode(array());
		endif;
	}

	public function divisions()
	{
		$fingerprint = isset($_GET['fingerprint']) ? $_GET['fingerprint'] : '';
		if($fingerprint=='!7D$0@9'):
			echo json_encode($this->User_account_model->getdivision_forapi());
		else:
			echo json_encode('');
		endif;
	}

	public function groups()
	{
		$fingerprint = isset($_GET['fingerprint']) ? $_GET['fingerprint'] : '';
		if($fingerprint=='!7D$0@9'):
			echo json_encode($this->User_account_model->getgroups_forapi());
		else:
			echo json_encode('');
		endif;
	}
	
}
