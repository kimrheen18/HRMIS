<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "modules/libraries/controllers/Libraries.php";
class Course extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/courses_model'));
    }

    public function index()
	{
		$this->arrData['arrCourses']=$this->courses_model->getData();
		//$this->template->load('template/template_view','libraries/course/list_view',$this->arrData);
		$this->template->load('template/template_view','libraries/course/list_view',$this->arrData);
		
	}
	
    public function add()
    {
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$strCode=$arrPost['strCode'];
			$strDescription=$arrPost['strDescription'];
			if(!empty($strCode) && !empty($strDescription))
			{	
				if( count($this->courses_model->checkExist($strCode))==0 )
				{
					$arrData = array(
						'courseCode'=>$strCode,
						'courseDesc'=>$strDescription
					);
					$blnReturn=$this->courses_model->add($arrData);
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblCourse','Added Course',implode(';',$arrData),'');
					
					if(count($blnReturn)>0)
						$this->session->set_flashdata('strSuccessMsg','Course added successfully.');
				
					redirect('libraries/course');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Course already exists.');
					$this->session->set_flashdata('strCode',$strCode);
					$this->session->set_flashdata('strDescription',$strDescription);
					//echo $this->session->flashdata('strErrorMsg');
					redirect('libraries/course/add');
				}
			}
		}
    	
    	$this->template->load('template/template_view','libraries/course/add_view',$this->arrData);
    }

    public function edit()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$intCourseId = urldecode($this->uri->segment(4));
			$this->arrData['arrCourse']=$this->courses_model->getData($intCourseId);
			$this->template->load('template/template_view','libraries/course/edit_view', $this->arrData);
		}
		else
		{
			$intCourseId = $arrPost['intCourseId'];
			$strCode=$arrPost['strCode'];
			$strDescription=$arrPost['strDescription'];
			if(!empty($strDescription)) 
			{
				$arrData = array(
					'courseCode'=>$strCode,
					'courseDesc'=>$strDescription
				);
				$blnReturn = $this->courses_model->save($arrData, $intCourseId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblCourse','Edited '.$strCode.' Course',implode(';',$arrData),'');
					
					$this->session->set_flashdata('strSuccessMsg','Course updated successfully.');
				}
				redirect('libraries/course');
			}
		}
		
	}

	public function delete()
	{
	
		$arrPost = $this->input->post();
		$intCourseId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->courses_model->getData($intCourseId);
			$this->template->load('template/template_view','libraries/course/delete_view', $this->arrData);
			
		}
		else
		{
			$intCourseId = $arrPost['intCourseId'];
			//add condition for checking dependencies from other tables
			if(!empty($intCourseId))
			{
				$arrCourse = $this->courses_model->getData($intCourseId);
				$strCode = $arrCourse[0]['courseCode'];	
				$blnReturn = $this->courses_model->delete($intCourseId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblCourse','Deleted '.$strCode.' Course',implode(';',$arrCourse[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Course deleted successfully.');
				}
				redirect('libraries/course');
			}
		}
		
	}
	// public function edit()
	// {
	// 	$arrPost = $this->input->post();
	// 	if(!empty($arrPost))
	// 	{
	// 		$intCourseId = $arrPost['intCourseId'];
	// 		$strCode = $arrPost['strCode'];
	// 		$strDescription=$arrPost['strDescription'];
	// 		if(!empty($strDescription))
	// 		{
	// 			$arrData = array(
	// 				'courseCode'=>$strCode,
	// 				'courseDesc'=>$strDescription
	// 			);
	// 			$blnReturn=$this->courses_model->save($arrData,$intCourseId);
	// 			if(count($blnReturn)>0)
	// 				$this->session->set_flashdata('strMsg','Course saved successfully.');
	// 			redirect('libraries/course');
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$strCode = urldecode($this->uri->segment(4));
	// 		$this->arrData['arrData']=$this->courses_model->getData($intCourseId);
	// 		$this->template->load('template/template_view','libraries/course/edit_view',$this->arrData);
	// 	}
	// }


	// public function delete()
	// {
	// 	//$strDescription=$arrPost['strDescription'];
	// 	$arrPost = $this->input->post();
	// 	$strCode = $this->uri->segment(4);
	// 	if(!empty($arrPost))
	// 	{
	// 		$strCode = $arrPost['strCode'];
	// 		//add condition for checking dependencies from other tables
	// 		if(!empty($strCode))
	// 		{
	// 			$blnReturn=$this->courses_model->delete($strCode);
	// 			if(count($blnReturn)>0)
	// 				//$this->session->set_flashdata('strMsg','Course deleted successfully.');
	// 			redirect('libraries/course');
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$this->arrData['arrData']=$this->courses_model->getData($strCode);
	// 		$this->template->load('template/template_view','libraries/course/delete_view',$this->arrData);
	// 	}
	// }

	
}
