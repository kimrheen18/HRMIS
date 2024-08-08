<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TravelOrder_excel extends MY_Controller {

	function __construct() {
        parent::__construct();
    }

    public function index(){
    	$this->template->load('template/template_view', 'employee/TravelOrder_Excel/travelorder_excel');
    }
}

?>
