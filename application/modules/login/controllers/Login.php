<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index()
	{
		$session = isset($_SESSION['sessBoolLoggedIn']) ? 1 : 0;
		$session = $session ? $_SESSION['sessBoolLoggedIn'] : 0;

		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			if($arrPost['strUsername']=='' || $arrPost['strPassword'] ==''):
				$this->session->set_flashdata('strErrorMsg','Please enter Username/Password.');
				$this->load->view('login_view');
			else:
				$this->load->model('login_model');
				$arrUser = $this->login_model->authenticate($arrPost['strUsername'],$arrPost['strPassword']);
				if(!empty($arrUser)):
					
					$this->set_session_login_data($arrUser[0]['empNumber'],$arrUser[0]['userLevel'],$arrUser[0]['userPermission'],$arrUser[0]['accessPermission'],$arrUser[0]['userName'],$arrUser[0]['userPassword'],$arrUser[0]['firstname'].' '.$arrUser[0]['surname'],$arrUser[0]['assignedGroup'],$arrUser[0]['is_assistant']);
					redirect('home/index');
				else:
					$this->session->set_flashdata('strErrorMsg','Invalid username/password.');
					$this->load->view('login_view');
				endif;
			endif;
		else:
			if(!$session):
				$this->load->view('login_view');
			else:
				redirect('home');
			endif;
		endif;
	}

	function set_session_login_data($strEmpno,$strLevel,$strUserPermission,$strAccessPermission,$strUsername,$strPassword,$strName,$strGroup,$strAssistant)
	{
		$sessData = array(
			 'sessEmpNo'			=> $strEmpno,
			 'sessUserLevel'  		=> $strLevel,
			 'sessUserPermission'  	=> $strUserPermission,
			 'sessUserName'  		=> $strUsername,
			 'sessUserPassword' 	=> $strPassword,
			 'sessName'  			=> $strName,
			 'sessAccessPermission'	=> $strAccessPermission,
			 'sessAssignedGroup'	=> $strGroup,
			 'sessIsAssistant'		=> $strAssistant,
			 'sessBoolLoggedIn' 	=> TRUE,
			);
		
		$this->session->set_userdata($sessData);
	}

	function timeoutkeepalive()
	{
		
	}
	
}
