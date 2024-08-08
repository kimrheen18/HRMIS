<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "modules/libraries/controllers/Libraries.php";
class Backup extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/backup_model'));
    }

    public function index()
	{
		 $backups = $this->backup_model->getData();
		// $xml = $this->User_model->getHRMIS_users();
		 $xml ="";
		 $json = json_decode($xml,true);

  
		 $this->template->load('template/template_view','libraries/backup/backup_view',$this->arrData);
		
	}

	
   public function export_database()
    {
        $db_name = 'hrmis' . date("Y-m-d-H-i-s") . '.zip';
         $arrData = array(
                    'time_last_run' => date('Y-m-d H:i:s'),
                    'added_by_id' => $this->session->userdata('sessEmpNo'),
                    'added_by_ip' => $_SERVER['REMOTE_ADDR']);
        	
			        // $this->backup_model->add($arrData);

			        $this->load->dbutil();
			        $prefs = array(
			            'format' => 'zip',
			            'filename' => 'hrmis.sql'
        		);

        $backup = $this->dbutil->backup($prefs);
        
        $save = 'uploads/backup/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        $this->load->helper('download');
        force_download($db_name, $backup);
    }


	
}
