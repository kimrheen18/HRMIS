<?php 
/** 
Purpose of file:    Controller for HR update
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr extends MY_Controller {
	var $arrData;
	function __construct() {
        parent::__construct();
        $this->load->model(array('Hr_model','libraries/Educ_level_model','libraries/Courses_model','libraries/Scholarship_model','libraries/Exam_type_model','hr/Attendance_summary_model','libraries/Appointment_status_model','libraries/Separation_mode_model','libraries/Plantilla_model','libraries/service_code_model','finance/Tax_exempt_model','finance/Payroll_group_model','libraries/Attendance_scheme_model','libraries/Position_model','libraries/Org_structure_model'));
    }

	public function index()
	{
		//$this->template->load('template/template_view','home/home_view');
	}

	public function search()
	{
		$arrPost = $this->input->post();
		if(isset($arrPost)):
			$strSearch = $arrPost['strSearch'];
			$this->arrData['arrData'] = $this->Hr_model->getData('',$strSearch);
		endif;
		$this->template->load('template/template_view','hr/search_view', $this->arrData);
	}

	public function profile()
	{
		$this->load->helper('directory');
	
		$strEmpNo = $this->uri->segment(3);
		
		$this->arrData['arrData'] = $this->Hr_model->getData($strEmpNo,'','all');
		
		$this->arrData['arrdtr'] = $this->Attendance_summary_model->getEmployee_dtr($strEmpNo,date('Y-m-d'),date('Y-m-d'));

		$this->arrData['arrdtr201'] = $this->Attendance_summary_model->getcurrent_dtr201($strEmpNo, date('Y-m-d'));
		
		$this->arrData['arrChild'] = $this->Hr_model->getEmployeeDetails($strEmpNo,'*',TABLE_CHILD);
		// $this->arrData['arrEduc'] = $this->Hr_model->getEmployeeDetails($strEmpNo,'*',TABLE_EDUC);
		$this->arrData['arrEduc'] = $this->Hr_model->getEmployeeEducation($strEmpNo);
		$this->arrData['arrLevel'] = $this->Educ_level_model->getData();
		$this->arrData['arrCourses'] = $this->Courses_model->getData();
		$this->arrData['arrScholarships'] = $this->Scholarship_model->getData();
		# Examination
		$this->arrData['arrExam'] = $this->Hr_model->getExam($strEmpNo);
		$this->arrData['arrExamType'] = $this->Exam_type_model->getData();
		# Work Experience
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		
		$this->arrData['arrOrganization'] = $this->Org_structure_model->getData();
		$this->arrData['arrServiceCode'] = $this->Org_structure_model->getServiceData();
		$this->arrData['arrDivision'] = $this->Org_structure_model->getDivisionData();
		$this->arrData['arrSection'] = $this->Org_structure_model->getSectionData();
		$this->arrData['arrSection1'] = $this->Org_structure_model->getSectionData1();

		$this->arrData['arrSeparation_mode'] = $this->Separation_mode_model->getData();
		# Voluntary Work
		$this->arrData['arrVol'] = $this->Hr_model->getEmployeeDetails($strEmpNo,'*',TABLE_VOLWORK);
		# Work Experiences
		$this->arrData['arrService'] = $this->Hr_model->getEmployeeDetails($strEmpNo,'*',TABLE_SERVICE);
		# Trainings
		$this->arrData['arrTraining'] = $this->Hr_model->getEmployeeDetails($strEmpNo,'*',TABLE_TRAINING);
		# Other Information
		$this->arrData['arrReferences'] = $this->Hr_model->get_character_references($strEmpNo);
		# Position Details
		$this->arrData['arrPosition'] = $this->Hr_model->getEmployeeDetails($strEmpNo,'*',TABLE_POSITION);
		$this->arrData['agencyHead'] = $this->Plantilla_model->get_plantilla_byItemNumber($this->arrData['arrPosition'][0]['itemNumber']);
		$this->arrData['mode_separation'] = $this->Hr_model->get_pos_sepMode();
		$this->arrData['personnel_action'] = $this->Hr_model->get_pos_personnelAction();
		$this->arrData['service_code'] = $this->service_code_model->getData();
		$this->arrData['tax_stat'] = $this->Tax_exempt_model->getData();
		# Payroll Details
		$this->arrData['pGroups'] = $this->Payroll_group_model->getData();
		$this->arrData['arrAttSchemes'] = $this->Attendance_scheme_model->get_att_schemes();
		$this->arrData['arrplantilla'] = $this->Plantilla_model->getAllPlantilla();
		# Duties and Responsibilities
		$this->arrData['position_duties'] = $this->Hr_model->duties_position($this->arrData['arrPosition'][0]['positionCode']);
		$this->arrData['plantilla_duties'] = $this->Hr_model->duties_plantilla($this->arrData['arrPosition'][0]['itemNumber']);
		$this->arrData['actual_duties'] = $this->Hr_model->duties_actual($strEmpNo);
		# Appointment Issued
		$this->arrData['arrpositions'] = $this->Position_model->getData();
		$this->arrData['arrEmpAppointment'] = $this->Appointment_status_model->employee_appointment_byEmpNumber($strEmpNo);
		# Employee Number
		$this->arrData['arrEmpNumbers'] = $this->Hr_model->get_employee_number();
		$this->arrData['arrProcessWith'] = $this->Hr_model->getpayrollprocess();
		// $this->template->load('template/template_view','pds/personal_info_view', $this->arrData);
		$this->template->load('template/template_view','pds/201/view_employee', $this->arrData);
	}

	// public function add_employee()
 //    {
 //    	$arrPost = $this->input->post();
	// 	if(empty($arrPost))
	// 	{	
	// 		$this->template->load('template/template_view','hr/add_employee_view',$this->arrData);	
	// 	}
	// 	else
	// 	{	
	// 		$strEmpID =$arrPost['strEmpID'];
	// 		$strSalutation =$arrPost['strSalutation'];
	// 		$strSurname=$arrPost['strSurname'];
	// 		$strFirstname=$arrPost['strFirstname'];
	// 		$strMiddlename=$arrPost['strMiddlename'];
	// 		$strMidInitial=$arrPost['strMidInitial'];
	// 		$strNameExt=$arrPost['strNameExt'];
	// 		$dtmBday=$arrPost['dtmBday'];
	// 		$strBirthPlace=$arrPost['strBirthPlace'];
	// 		$strSex=$arrPost['strSex'];
	// 		$strCvlStatus=$arrPost['strCvlStatus'];
	// 		$strCitizenship=$arrPost['strCitizenship'];
	// 		$strHeight=$arrPost['strHeight'];
	// 		$strWeight=$arrPost['strWeight'];
	// 		$strBloodType=$arrPost['strBloodType'];
	// 		$intGSIS=$arrPost['intGSIS'];
	// 		$intPagibig=$arrPost['intPagibig'];
	// 		$intPhilhealth=$arrPost['intPhilhealth'];
	// 		$intTin=$arrPost['intTin'];
	// 		$strEmail=$arrPost['strEmail'];
	// 		$intSSS=$arrPost['intSSS'];

	// 		$strLot1=$arrPost['strLot1'];
	// 		$strLot2=$arrPost['strLot2'];
	// 		$strStreet1=$arrPost['strStreet1'];
	// 		$strStreet2=$arrPost['strStreet2'];
	// 		$strSubd1=$arrPost['strSubd1'];
	// 		$strSubd2=$arrPost['strSubd2'];
	// 		$strBrgy1=$arrPost['strBrgy1'];
	// 		$strBrgy2=$arrPost['strBrgy2'];
	// 		$strProv1=$arrPost['strProv1'];
	// 		$strProv2=$arrPost['strProv2'];
	// 		$strCity1=$arrPost['strCity1'];
	// 		$strCity2=$arrPost['strCity2'];
	// 		$intZipCode1=$arrPost['intZipCode1'];
	// 		$intZipCode2=$arrPost['intZipCode2'];
	// 		$intTel1=$arrPost['intTel1'];
	// 		$intTel2=$arrPost['intTel2'];
	// 		$intMobile=$arrPost['intMobile'];
	// 		$intAccount=$arrPost['intAccount'];
		
		
	// 			if(!empty($strEmpID) && !empty($strSurname) && !empty($strFirstname) && !empty($strMiddlename))
	// 			{
	// 				if(count($this->hr_model->checkExist($strEmpID))==0)
	// 				{
	// 				$arrData = array(
	// 					'salutation'=>$strSalutation,
	// 					'empNumber'=>$strEmpID,
	// 					'surname'=>$strSurname,
	// 					'firstname'=>$strFirstname,
	// 					'middlename'=>$strMiddlename,
	// 					'middleInitial'=>$strMidInitial,
	// 					'nameExtension'=>$strNameExt,
	// 					'citizenship'=>$strCitizenship,
	// 					'birthday'=>$dtmBday,
	// 					'birthPlace'=>$strBirthPlace,
	// 					'sex'=>$strSex,
	// 					'civilStatus'=>$strCvlStatus,
	// 					'gsisNumber'=>$intGSIS,
	// 					'weight'=>$strWeight,
	// 					'height'=>$strHeight,
	// 					'tin'=>$intTin,
	// 					'sssNumber'=>$intSSS,
	// 					'bloodType'=>$strBloodType,
	// 					'email'=>$strEmail,
	// 					'pagibigNumber'=>$intPagibig,
	// 					'philHealthNumber'=>$intPhilhealth,

	// 					'lot1'=>$strLot1,
	// 					'lot2'=>$strLot2,
	// 					'street1'=>$strStreet1,
	// 					'street2'=>$strStreet2,
	// 					'subdivision1'=>$strSubd1,
	// 					'subdivision2'=>$strSubd2,
	// 					'barangay1'=>$strBrgy1,
	// 					'barangay2'=>$strBrgy2,
	// 					'city1'=>$strCity1,
	// 					'city2'=>$strCity2,
	// 					'province1'=>$strProv1,
	// 					'province2'=>$strProv2,
	// 					'zipCode1'=>$intZipCode1,
	// 					'zipCode2'=>$intZipCode2,
	// 					'telephone1'=>$intTel1,
	// 					'telephone2'=>$intTel2,
	// 					'Mobile'=>$intMobile,
	// 					'AccountNum'=>$intAccount
						
	// 				);
	// 				$blnReturn  = $this->Hr_model->add_employee($arrData);

	// 				if(count($blnReturn)>0)
	// 				{	
	// 					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpPersonal','Added '.$strSurname.'',implode(';',$arrData),'');
	// 					$this->session->set_flashdata('strMsg','Personal Information added successfully.');
	// 				}
	// 				redirect('hr/add_employee');
	// 			}
	// 			else
	// 			{	
	// 				$this->session->set_flashdata('strErrorMsg','Personal Information already exists.');
	// 				$this->session->set_flashdata('strSurname',$strSurname);
	// 					//echo $this->session->flashdata('strErrorMsg');
	// 				redirect('hr/add_employee');
	// 			}
	// 		}	
	// 	}	
 //    }

    public function add_employee()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','hr/add_employee_view',$this->arrData);	
		}
		else
		{	
			$strEmpID =$arrPost['strEmpID'];
			$strSalutation =$arrPost['strSalutation'];
			$strSurname=$arrPost['strSurname'];
			$strFirstname=$arrPost['strFirstname'];
			$strMiddlename=$arrPost['strMiddlename'];
			$strMidInitial=$arrPost['strMidInitial'];
			$strNameExt=$arrPost['strNameExt'];
			$dtmBday=$arrPost['dtmBday'];
			$strBirthPlace=$arrPost['strBirthPlace'];
			$strSex=$arrPost['strSex'];
			$strCvlStatus=$arrPost['strCvlStatus'];
			$strCitizenship=$arrPost['strCitizenship'];
			$strHeight=$arrPost['strHeight'];
			$strWeight=$arrPost['strWeight'];
			$strBloodType=$arrPost['strBloodType'];
			$intGSIS=$arrPost['intGSIS'];
			$intPagibig=$arrPost['intPagibig'];
			$intPhilhealth=$arrPost['intPhilhealth'];
			$intTin=$arrPost['intTin'];
			$strEmail=$arrPost['strEmail'];
			$intSSS=$arrPost['intSSS'];

			$strLot1=$arrPost['strLot1'];
			$strLot2=$arrPost['strLot2'];
			$strStreet1=$arrPost['strStreet1'];
			$strStreet2=$arrPost['strStreet2'];
			$strSubd1=$arrPost['strSubd1'];
			$strSubd2=$arrPost['strSubd2'];
			$strBrgy1=$arrPost['strBrgy1'];
			$strBrgy2=$arrPost['strBrgy2'];
			$strProv1=$arrPost['strProv1'];
			$strProv2=$arrPost['strProv2'];
			$strCity1=$arrPost['strCity1'];
			$strCity2=$arrPost['strCity2'];
			$intZipCode1=$arrPost['intZipCode1'];
			$intZipCode2=$arrPost['intZipCode2'];
			$intTel1=$arrPost['intTel1'];
			$intTel2=$arrPost['intTel2'];
			$intMobile=$arrPost['intMobile'];
			$intAccount=$arrPost['intAccount'];
			// in-service
			$strStatus=$arrPost['strStatus'];
			
			
			if(!empty($strEmpID))
			{	
				if(count($this->Hr_model->checkExist($strEmpID))==0)
				{
					$arrData = array(
						'empNumber'=>$strEmpID,
						'salutation'=>$strSalutation,
						'surname'=>$strSurname,
						'firstname'=>$strFirstname,
						'middlename'=>$strMiddlename,
						'middleInitial'=>$strMidInitial,
						'nameExtension'=>$strNameExt,
						'citizenship'=>$strCitizenship == null ? "" : $strCitizenship,
						'birthday'=>$dtmBday,
						'birthPlace'=>$strBirthPlace,
						'sex'=>$strSex,
						'civilStatus'=>$strCvlStatus,
						'gsisNumber'=>$intGSIS,
						'weight'=>$strWeight,
						'height'=>$strHeight,
						'tin'=>$intTin,
						'sssNumber'=>$intSSS,
						'bloodType'=>$strBloodType,
						'email'=>$strEmail,
						'pagibigNumber'=>$intPagibig,
						'philHealthNumber'=>$intPhilhealth,

						'lot1'=>$strLot1,
						'lot2'=>$strLot2,
						'street1'=>$strStreet1,
						'street2'=>$strStreet2,
						'subdivision1'=>$strSubd1,
						'subdivision2'=>$strSubd2,
						'barangay1'=>$strBrgy1,
						'barangay2'=>$strBrgy2,
						'city1'=>$strCity1,
						'city2'=>$strCity2,
						'province1'=>$strProv1,
						'province2'=>$strProv2,
						'zipCode1'=>$intZipCode1 == " " ? null : $intZipCode1,
						'zipCode2'=>$intZipCode2 == " " ? null : $intZipCode2,
						'telephone1'=>$intTel1,
						'telephone2'=>$intTel2,
						'Mobile'=>$intMobile,
						'AccountNum'=>$intAccount,
					);
					$blnReturn  = $this->Hr_model->add_employee($arrData);
						$arrData2 = array(
						'empNumber'=>$strEmpID,
						'statusOfAppointment'=>$strStatus
						);
					$blnReturn  = $this->Hr_model->add_employee_status($arrData2);
					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpPersonal','Added '.$strEmpID.' Personal Information',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Personal Information added successfully.');
					}
					redirect('hr/add_employee');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Duplicate data. Employee number already taken.');
					$this->session->set_flashdata('strEmpID',$strEmpID);
					//echo $this->session->flashdata('strErrorMsg');
				redirect('hr/add_employee');
				}
			}
		}
    	
    	
    }

    public function edit_image()
	{
	 	$arrPost = $this->input->post();
	 	$this->arrData['strEmpNum'] = $this->uri->segment(3);
		$this->template->load('template/template_view','hr/edit_image_view', $this->arrData);
	
	}

	public function upload()
	{
		$arrPost = $this->input->post();
		$strEmpNum = $arrPost['EmployeeId'];

		$config['upload_path']          = 'uploads/employees/';
        $config['allowed_types']        = 'jpg';
        
		$config['file_name'] = $strEmpNum.'.jpg';
		$config['overwrite'] = TRUE;
		//print_r($config);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload('userfile'))
		{
			//echo $this->upload->display_errors();
			$error = array('error' => $this->upload->display_errors());
			// print_r($error);
			// exit(1);
			$this->session->set_flashdata('upload_status','Please try again!');
		}
		else
		{
			$data = $this->upload->data();
			//print_r($data);
				$arrEmp = array(
					
				);
			// print_r($data);
			// exit(1);

			$this->session->set_flashdata('upload_status','Upload successfully saved.');
			
		}
		// print_r($error);
		// print_r($data);
		// exit(1);
		redirect('hr/profile/'.$strEmpNum);
		
	}


   
	
}
