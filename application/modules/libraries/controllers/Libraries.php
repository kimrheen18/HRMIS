<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Libraries extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();

    }

  //   public function country()
  //   {
  //   	$this->load->module('libraries/country');
		// $this->country->index();
  //   }

	// public function index()
	// {
	// 	$this->load->model(array('libraries/courses_model'));
	// 	$this->arrData['arrCourses']=$this->courses_model->getData();
	// 	$this->template->load('template/template_view','libraries/libraries_view',$this->arrData);
	// }

	

	// public function course()
	// {
	// 	//$this->load->module('libraries/course');
	// 	//$this->course->index();
	// 	// if($strView=="add"):
	// 	// 	//$this->template->load('template/template_view','libraries/course/add_view',$this->arrData);
	// 	// else:
	// 	// 	$this->load->module('libraries/course');
	// 	// 	$this->course->index();
	// 	// endif;
	// }
}
