<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DTR_Controller extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->database();
		$this->load->model('DTR_Model');

	}

	public function index()
	{
		$empid = $this->session->userdata('sessEmpNo');
		//echo $empid;
		if($empid == 'HRMIS-QRSCANNER'):
			$this->session->sess_expiration = '32140800'; //~ one year
    		$this->session->sess_expire_on_close = 'false';
			$this -> load -> view('DTR_View');
		else:
			redirect('login');
		endif;
	}


	// Controller for saving data
	// After fetching the needed data, the controller calls the model
	// Then returns a 200 status code after inserting
	public function saveData(){
		$code = $this->uri->segment(4);

		// If the qr code exist
		if($this->DTR_Model->qrCheckExist($code)){

			$schemeType = $this->DTR_Model->getSchemeType($code);

			if($this->DTR_Model->checkExistData($code)){
				$this->DTR_Model->save($code);	
			}

			// When it is monday
			//if($this->DTR_Model->isMonday()) {
			//	$this->DTR_Model->updateTimeFix($code, "8:00 AM", "5:00 PM");
			//} else {
				if($schemeType == "Sliding"){
					$this->DTR_Model->updateTimeSliding($code);
				} else if ($schemeType == "Fixed"){
					$this->DTR_Model->updateTimeFix($code);
				}
			//}
			echo json_encode(array(
				"statusCode"=>200,
				"statusSched"=>$this->DTR_Model->returnStatus()
				//"scheme"=> $this->DTR_Model->isMonday() ? "true" : "false"
			));
			
		} else {
			echo json_encode(array(
				"statusCode"=>404,
			));
		}
		
	}
}

?>