<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pds extends MY_Controller 
{
	var $arrData;

	function __construct() 
	{
        parent::__construct();
  		$this->load->model(array('hr/Hr_model','hr/chart_model','pds/pds_model'));
    }

	public function index()
	{
		$employees = $this->Hr_model->getData('','','all');
		$this->arrData['arrEmployees'] = $employees;
		$status = array_unique(array_column($employees, 'statusOfAppointment'));
		asort($status);
		$this->arrData['arrStatus'] = $status;
		$this->template->load('template/template_view','pds/default_view',$this->arrData);
	}

    public function edit_personal()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$strEmpNumber = urldecode($this->uri->segment(4));
			$this->arrData['arrData']=$this->pds_model->getData($strEmpNumber);
			$this->template->load('template/template_view','pds/personal_view', $this->arrData);
		}
		else
		{
			$strEmpNumber = $arrPost['strEmpNumber'];
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
			$intGSISBP=$arrPost['intGSISBP'];
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
		
			if(!empty($strSurname))
			{
				$arrData = array(
					'salutation'=>$strSalutation,
					'surname'=>$strSurname,
					'firstname'=>$strFirstname,
					'middlename'=>$strMiddlename,
					'middleInitial'=>$strMidInitial,
					'nameExtension'=>$strNameExt,
					'citizenship'=>$strCitizenship,
					'birthday'=>$dtmBday,
					'birthPlace'=>$strBirthPlace,
					'sex'=>$strSex,
					'civilStatus'=>$strCvlStatus,
					'gsisNumber'=>$intGSIS,
					'businessPartnerNumber'=>$intGSISBP,
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
					'zipCode1'=>$intZipCode1,
					'zipCode2'=>$intZipCode2,
					'telephone1'=>$intTel1,
					'telephone2'=>$intTel2,
					'Mobile'=>$intMobile,
					'AccountNum'=>$intAccount	
				);
				 // echo '='.$strEmpNumber;
				 // exit(1);
				$blnReturn = $this->pds_model->save_personal($arrData, $strEmpNumber);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpPersonal','Edited '.$strSurname.' Personal',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Updated Personal information.');
				}
				redirect('hr/profile/'.$strEmpNumber.'/#personal_info');
			}
		}
		
	}

    public function edit_spouse()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();

		if(!empty($arrPost))
		{
			$arrData = array(
							'spouseSurname'		=> $arrPost['txtspouseLname'],
							'spouseFirstname'	=> $arrPost['txtspouseFname'],
							'spouseMiddlename'	=> $arrPost['txtspouseMname'],
							'spousenameExtension'=>$arrPost['txtspouseExt'],
							'spouseWork'		=> $arrPost['txtspouseWork'],
							'spouseBusName'		=> $arrPost['txtspouseBusName'],
							'spouseBusAddress'	=> $arrPost['txtspouseBusAddress'],
							'spouseTelephone'	=> $arrPost['txtspouseTelephone']);

			$this->pds_model->save_personal($arrData, $empid);
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpPersonal','Edited '.$arrPost['txtspouseLname'].' Personal',implode(';',$arrData),'');
			
			$this->session->set_flashdata('strSuccessMsg','Spouse information updated successfully.');
			redirect('hr/profile/'.$empid.'/#family_background');
		}
	}

    public function edit_parents()
    {
    	$empid = $this->uri->segment(3);
    	$arrPost = $this->input->post();

		if(!empty($arrPost))
		{
			$arrData = array(
							'fatherSurname'		=> $arrPost['txtfatherLname'],
							'fatherFirstname'	=> $arrPost['txtfatherFname'],
							'fatherMiddlename' 	=> $arrPost['txtfatherMname'],
							'fathernameExtension'=>$arrPost['txtfatherExt'],
							'motherFirstname'	=> $arrPost['txtmotherFname'],
							'motherMiddlename'	=> $arrPost['txtmotherMname'],
							'motherSurname'		=> $arrPost['txtmotherLname'],
							'parentAddress'		=> $arrPost['txtparentsadd']);

			$this->pds_model->save_personal($arrData, $empid);
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpPersonal','Edited '.$arrPost['txtfatherLname'].' Personal',implode(';',$arrData),'');
			
			$this->session->set_flashdata('strSuccessMsg','Parents information updated successfully.');
			redirect('hr/profile/'.$empid.'/#family_background');
		}
	}
	
	# BEGIN CHILD
	public function add_child()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$arrData = array(
							'empNumber'		=> $empid,
							'childName'		=> $arrPost['txtchildname'],
							'childBirthDate'=> $arrPost['txtchildbday']);

			$this->pds_model->add_child($arrData);
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpChild','Add Child',implode(';',$arrData),'');
			$this->session->set_flashdata('strSuccessMsg','Child information added successfully.');
			redirect('hr/profile/'.$empid.'/#family_background');
		}
	}

    public function edit_child()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$arrData = array(
							'childName'		=> $arrPost['txtchildname'],
							'childBirthDate'=> $arrPost['txtchildbday']);

			$this->pds_model->save_child($arrData, $arrPost['txtchildcode']);
			log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpChild','Add Child',implode(';',$arrData),'');
			$this->session->set_flashdata('strSuccessMsg','Child information updated successfully.');
			redirect('hr/profile/'.$empid.'/#family_background');
		}
	}

	public function delete_child()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_child($arrPost['txtdelchild']);

			$this->session->set_flashdata('strSuccessMsg','Child information deleted successfully.');
			redirect('hr/profile/'.$empid.'/#family_background');
		}
	}
	# END CHILD

	# BEGIN EDUCATION
	public function add_educ()
	{
		$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);
    	if(!empty($arrPost)):
    		$arrData = array(
    						'empNumber'		=> $empid,
    						'levelCode'		=> $arrPost['sellevel'],
    						'schoolName'	=> $arrPost['txtschool'],
    						'course'		=> $arrPost['seldegree'],
    						'yearGraduated'	=> $arrPost['txtyrgraduate'],
    						'units'			=> $arrPost['txtunits'],
    						'schoolFromDate'=> $arrPost['txtperiodatt_from'],
    						'schoolToDate'	=> $arrPost['txtperiodatt_to'],
    						'ScholarshipCode'=>$arrPost['selscholarship'],
    						'honors'		=> $arrPost['txthonors'],
    						'licensed'		=> isset($arrPost['optlicense']) ? $arrPost['optlicense'] : '',
    						'graduated'		=> isset($arrPost['optgraduate']) ? $arrPost['optgraduate'] : '');
    		$this->pds_model->add_educ($arrData);
    		$this->session->set_flashdata('strSuccessMsg','Education information added successfully.');
    		redirect('hr/profile/'.$empid.'/#education');
    	endif;
	}

	public function edit_educ()
	{
		$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);
    	if(!empty($arrPost)):
    		$arrData = array(
    						'levelCode'		=> $arrPost['sellevel'],
    						'schoolName'	=> $arrPost['txtschool'],
    						'course'		=> $arrPost['seldegree'],
    						'yearGraduated'	=> $arrPost['txtyrgraduate'],
    						'units'			=> $arrPost['txtunits'],
    						'schoolFromDate'=> $arrPost['txtperiodatt_from'],
    						'schoolToDate'	=> $arrPost['txtperiodatt_to'],
    						'ScholarshipCode'=>$arrPost['selscholarship'],
    						'honors'		=> $arrPost['txthonors'],
    						'licensed'		=> isset($arrPost['optlicense']) ? $arrPost['optlicense'] : '',
    						'graduated'		=> isset($arrPost['optgraduate']) ? $arrPost['optgraduate'] : '');
   //  		print_r($arrData);
			// exit(1);
    		$this->pds_model->save_educ($arrData,$arrPost['txteducid']);
    		$this->session->set_flashdata('strSuccessMsg','Education information updated successfully.');
    		redirect('hr/profile/'.$empid.'/#education');
    	endif;
	}

	public function delete_educ()
    {

    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_educ($arrPost['txtdeleduc']);

			$this->session->set_flashdata('strSuccessMsg','Education information deleted successfully.');
			redirect('hr/profile/'.$empid.'/#education');
		}
	}
	# END EDUCATION

	# BEGIN EXAMINATION
	public function add_exam()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'empNumber'		=> $empid,
				'examCode'		=> $arrPost['exam_desc'],
				'examDate'		=> $arrPost['txtdate_exam'],
				'examRating'	=> $arrPost['txtrating'],
				'examPlace'		=> $arrPost['txtplace_exam'],
				'licenseNumber' => $arrPost['txtlicense'],
				'dateRelease'	=> $arrPost['txtvalidity'],
				'verifier'		=> $arrPost['txtverifier'],
				'reviewer'		=> $arrPost['txtreviewer']);

			$this->pds_model->add_exam($arrData);
			$this->session->set_flashdata('strSuccessMsg','Eligibility information added successfully.');

			redirect('hr/profile/'.$empid.'/#examination');
		endif;
	}

	// public function edit_exam()
	// {
	// 	$empid = $this->uri->segment(3);
	// 	$arrPost = $this->input->post();
	// 	if(!empty($arrPost)):
	// 		$arrData = array(
	// 			'examCode'		=> $arrPost['exam_desc'],
	// 			'examDate'		=> $arrPost['txtdate_exam'],
	// 			'examRating'	=> $arrPost['txtrating'],
	// 			'examPlace'		=> $arrPost['txtplace_exam'],
	// 			'licenseNumber' => $arrPost['txtlicense'],
	// 			'dateRelease'	=> $arrPost['txtvalidity'],
	// 			'verifier'		=> $arrPost['txtverifier'],
	// 			'reviewer'		=> $arrPost['txtreviewer']);

	// 		$this->pds_model->save_exam($arrData, $arrPost['txtexamid']);
	// 		$this->session->set_flashdata('strSuccessMsg','Eligibility information updated successfully.');

	// 		redirect('hr/profile/'.$empid);
	// 	endif;
	// }
	public function edit_exam()
    {
    	$empid = $this->uri->segment(3);
    	$arrPost = $this->input->post();

		if(!empty($arrPost))
		{
			$arrData = array(
							'examCode'		=> $arrPost['exam_desc'],
							'examDate'		=> $arrPost['txtdate_exam'],
							'examRating'	=> $arrPost['txtrating'],
							'examPlace'		=> $arrPost['txtplace_exam'],
							'licenseNumber' => $arrPost['txtlicense'],
							'dateRelease'	=> $arrPost['txtvalidity'],
							'verifier'		=> $arrPost['txtverifier'],
							'reviewer'		=> $arrPost['txtreviewer']);

			$this->pds_model->save_exam($arrData,$arrPost['txtexamid']);
			// log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpPersonal','Edited '.$arrPost['txtfatherLname'].' Personal',implode(';',$arrData),'');
			$this->session->set_flashdata('strSuccessMsg','Eligibility information updated successfully.');

			redirect('hr/profile/'.$empid.'/#examination');
		}
	}

	public function delete_exam()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_exam($arrPost['txtdel_exam']);

			$this->session->set_flashdata('strSuccessMsg','Eligibility deleted successfully.');
			redirect('hr/profile/'.$empid.'/#examination');
		}
	}
	# END EXAMINATION

	# BEGIN WORK EXPERIENCE
	public function add_work_xp()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'empNumber' 	  => $empid,
							'serviceFromDate' => $arrPost['txtdfrom'],
							'serviceToDate'   => isset($arrPost['txtdto']) ? $arrPost['txtdto'] : '',
							'tmpServiceToDate'=> isset($arrPost['chkpresent']) ? 'Present' : '',
							// 'serviceToDate'   => $arrPost['txtdto'],
							// 'positionCode' 	  => $arrPost['txtposition_code'],
							'positionDesc' 	  => $arrPost['txtposition'],
							'salary' 		  => $arrPost['txtsalary'],
							'salaryPer' 	  => $arrPost['selperiod'],
							'stationAgency'   => $arrPost['txtoffice'],
							'salaryGrade' 	  => $arrPost['txtgrade'],
							'appointmentCode' => $arrPost['selappointment'],
							'governService'   => isset($arrPost['optgov_srvc']) ? $arrPost['optgov_srvc'] : 'N',
							// 'NCCRA' 		  => $arrPost[''],
							'separationCause' => $arrPost['selmode_separation'],
							'separationDate'  => $arrPost['txtseparation_date'],
							'branch' 		  => $arrPost['selbranch'],
							'currency' 		  => $arrPost['txtcurrency'],
							'remarks' 		  => $arrPost['txtremarks'],
							'lwop' 			  => $arrPost['txtabs'],
							'processor' 	  => $arrPost['txtprocessor'],
							'signee' 		  => $arrPost['txtofficial']);

			$this->pds_model->add_workExp($arrData);
			$this->session->set_flashdata('strSuccessMsg','Work Experience added successfully.');
			redirect('hr/profile/'.$empid.'/#work_experience');
		endif;
	}

	public function edit_work_xp()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'serviceFromDate' => $arrPost['txtdfrom'],
							'serviceToDate'   => isset($arrPost['txtdto']) ? $arrPost['txtdto'] : '',
							'tmpServiceToDate'=> isset($arrPost['chkpresent']) ? 'Present' : '',
							// 'serviceToDate'   => $arrPost['txtdto'],
							// 'positionCode' 	  => $arrPost['txtposition_code'],
							'positionDesc' 	  => $arrPost['txtposition'],
							'salary' 		  => $arrPost['txtsalary'],
							'salaryPer' 	  => $arrPost['selperiod'],
							'stationAgency'   => $arrPost['txtoffice'],
							'salaryGrade' 	  => $arrPost['txtgrade'],
							'appointmentCode' => $arrPost['selappointment'],
							// 'governService'   => isset($arrPost['optgov_srvc']) ? $arrPost['optgov_srvc'] : 'N',
							'governService'	 => $arrPost['optgov_srvc'] == 'Yes' ? $arrPost['optgov_srvc'] : 'No',
							// 'NCCRA' 		  => $arrPost[''],
							'separationCause' => $arrPost['selmode_separation'],
							'separationDate'  => $arrPost['txtseparation_date'],
							'branch' 		  => $arrPost['selbranch'],
							'currency' 		  => $arrPost['txtcurrency'],
							'remarks' 		  => $arrPost['txtremarks'],
							'lwop' 			  => $arrPost['txtabs'],
							'processor' 	  => $arrPost['txtprocessor'],
							'signee' 		  => $arrPost['txtofficial']);

			$this->pds_model->save_workExp($arrData, $arrPost['txtxpid']);
			$this->session->set_flashdata('strSuccessMsg','Work Experience added successfully.');
			redirect('hr/profile/'.$empid.'/#work_experience');
		endif;
	}

	public function delete_work_xp()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_workExp($arrPost['txtdel_srv']);

			$this->session->set_flashdata('strSuccessMsg','Work Experience deleted successfully.');
			redirect('hr/profile/'.$empid.'/#work_experience');
		}
	}
	# END WORK EXPERIENCE

	# BEGIN VOLUNTARY WORK
	public function add_vol_work()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'empNumber' 	  => $empid,
							'vwName' 		  => $arrPost['txtorganization'],
							'vwAddress'   	  => $arrPost['txtaddress'],
							'vwDateFrom' 	  => $arrPost['txtdfrom_vl'],
							'vwDateTo' 		  => $arrPost['txtdto_vl'],
							'vwHours'	 	  => $arrPost['txthrs'],
							'vwPosition'	  => $arrPost['txtwork']);
			$this->pds_model->add_volWorks($arrData);
			$this->session->set_flashdata('strSuccessMsg','Voluntary work added successfully.');
			redirect('hr/profile/'.$empid.'/#voluntary_work');
		endif;
	}

	public function edit_vol_work()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'empNumber' 	  => $empid,
							'vwName' 		  => $arrPost['txtorganization'],
							'vwAddress'   	  => $arrPost['txtaddress'],
							'vwDateFrom' 	  => $arrPost['txtdfrom_vl'],
							'vwDateTo' 		  => $arrPost['txtdto_vl'],
							'vwHours'	 	  => $arrPost['txthrs'],
							'vwPosition'	  => $arrPost['txtwork']);
			$this->pds_model->save_volWorks($arrData,$arrPost['txtvolid']);
			$this->session->set_flashdata('strSuccessMsg','Voluntary work updated successfully.');
			redirect('hr/profile/'.$empid.'/#voluntary_work');
		endif;
	}
	
	public function del_vol_work()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_volWorks($arrPost['txtdelvolid']);

			$this->session->set_flashdata('strSuccessMsg','Voluntary work deleted successfully.');
			redirect('hr/profile/'.$empid.'/#voluntary_work');
		}
	}
	# END VOLUNTARY WORK

	# BEGIN TRAINING
	public function add_training()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'empNumber'			  => $empid,
							'trainingTitle'		  => $arrPost['txttra_name'],
							'trainingContractDate'=> $arrPost['txttra_contract'],
							'trainingStartDate'	  => $arrPost['txttra_sdate'],
							'trainingEndDate'	  => $arrPost['txttra_edate'],
							'trainingHours'		  => $arrPost['txttra_hrs'],
							'trainingTypeofLD'	  => $arrPost['seltra_typeld'],
							'trainingConductedBy' => $arrPost['txttra_sponsored'],
							'trainingVenue'		  => $arrPost['txttra_venue'],
							'trainingCost'		  => $arrPost['txttra_cost'],
							'trainingDesc'		  => $arrPost['txttra_name']); # Same as training title

			$this->pds_model->add_training($arrData);
			$this->session->set_flashdata('strSuccessMsg','Training added successfully.');
			redirect('hr/profile/'.$empid.'/#trainings');
		endif;
	}

	// public function edit_training()
	// {
	// 	$empid = $this->uri->segment(3);
	// 	$arrPost = $this->input->post();
	// 	if(!empty($arrPost)):
	// 		$arrData = array(
	// 						'trainingTitle'		  => $arrPost['txttra_name'],
	// 						'trainingContractDate'=> $arrPost['txttra_contract'],
	// 						'trainingStartDate'	  => $arrPost['txttra_sdate'],
	// 						'trainingEndDate'	  => $arrPost['txttra_edate'],
	// 						'trainingHours'		  => $arrPost['txttra_hrs'],
	// 						'trainingTypeofLD'	  => $arrPost['seltra_typeld'],
	// 						'trainingConductedBy' => $arrPost['txttra_sponsored'],
	// 						'trainingVenue'		  => $arrPost['txttra_venue'],
	// 						'trainingCost'		  => $arrPost['txttra_cost'],
	// 						'trainingDesc'		  => $arrPost['txttra_name']); # Same as training title

	// 		$this->pds_model->save_training($arrData, $arrPost['txttraid']);
	// 		$this->session->set_flashdata('strSuccessMsg','Training updated successfully.');
	// 		redirect('hr/profile/'.$empid);
	// 	endif;	
	// }

	public function edit_training()
    {
    	$empid = $this->uri->segment(3);
    	$arrPost = $this->input->post();

		if(!empty($arrPost))
		{
			$arrData = array(
							'trainingTitle'		  => $arrPost['txttra_name'],
							'trainingContractDate'=> $arrPost['txttra_contract'],
							'trainingStartDate'	  => $arrPost['txttra_sdate'],
							'trainingEndDate'	  => $arrPost['txttra_edate'],
							'trainingHours'		  => $arrPost['txttra_hrs'],
							'trainingTypeofLD'	  => $arrPost['seltra_typeld'],
							'trainingConductedBy' => $arrPost['txttra_sponsored'],
							'trainingVenue'		  => $arrPost['txttra_venue'],
							'trainingCost'		  => $arrPost['txttra_cost'], 
							'trainingDesc'		  => $arrPost['txttra_name']); 
			
			$this->pds_model->save_training($arrData, $arrPost['txttraid']);
			$this->session->set_flashdata('strSuccessMsg','Training updated successfully.');

			redirect('hr/profile/'.$empid.'/#trainings');
		}
	}

	public function del_training()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_training($arrPost['txtdel_tra']);

			$this->session->set_flashdata('strSuccessMsg','Training deleted successfully.');
			redirect('hr/profile/'.$empid.'/#trainings');
		}
	}
	# END TRAINING

	# BEGIN SKILL & LEGAL INFORMATION
	public function edit_skill()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();

		if(!empty($arrPost)):
			$arrData = array(
							'skills'=> $arrPost['txtskills'],
							'nadr'	=> $arrPost['txtrecognition'],
							'miao'	=> $arrPost['txtorganization']);

			$this->pds_model->save_skill($arrData, $empid);
			$this->session->set_flashdata('strSuccessMsg','Other information updated successfully.');
			redirect('hr/profile/'.$empid.'/#other_info');
		endif;
	}

	public function edit_legal_info()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();

		if(!empty($arrPost)):
			$arrData = array(
							'relatedThird'	 => $arrPost['optrelated_third'],
							'relatedDegreeParticularsThird'	=> $arrPost['optrelated_third'] == 'Y' ? $arrPost['ThirdYes'] : '',
							'relatedFourth'	 => $arrPost['optrelated_fourth'],
							'relatedDegreeParticulars' 		=> $arrPost['optviolate_law'] == 'Y' ? $arrPost['FourthYes'] : '',
							'adminCase'		 => $arrPost['optadmincase'],
							'adminCaseParticulars'			=> $arrPost['optviolate_law'] == 'Y' ? $arrPost['adminCaseYes'] : '',
							'formallyCharged'=> $arrPost['optformally_charged'],
							'formallyChargedParticulars' 	=> $arrPost['optviolate_law'] == 'Y' ? $arrPost['formallyChargedYes'] : '',
							'violateLaw'	 => $arrPost['optviolate_law'],
							'violateLawParticulars'			=> $arrPost['optviolate_law'] == 'Y' ? $arrPost['violateLawYes'] : '',
							'forcedResign'	 => $arrPost['optforced_resign'],
							'forcedResignParticulars'		=> $arrPost['optforced_resign'] == 'Y' ? $arrPost['forcedResignYes'] : '',
							'candidate'		 => $arrPost['optcandidate'],
							'candidateParticulars'			=> $arrPost['optcandidate'] == 'Y' ? $arrPost['candidateYes'] : '',
							'campaign'		 => $arrPost['optcampaign'],
							'campaignParticulars'			=> $arrPost['optcampaign'] == 'Y' ? $arrPost['campaignYes'] : '',
							'immigrant'		 => $arrPost['optimmigrant'],
							'immigrantParticulars'			=> $arrPost['optimmigrant'] == 'Y' ? $arrPost['immigrantYes'] : '',

							'indigenous'	 => $arrPost['optindigenous'],
							'disabled'		 => $arrPost['optdisabled'],
							'soloParent'	 => $arrPost['optsolo_parent'],
							'indigenousParticulars'	 => $arrPost['optindigenous'] == 'Y' ? $arrPost['txtindigenous'] : '',
							'disabledParticulars'	 => $arrPost['optdisabled'] == 'Y' ? $arrPost['txtdisabled'] : '',
							'soloParentParticulars'	 => $arrPost['optsolo_parent'] == 'Y' ? $arrPost['txtsoloparent'] : '');

			$this->pds_model->save_skill($arrData, $empid);
			$this->session->set_flashdata('strSuccessMsg','Legal information updated successfully.');
			redirect('hr/profile/'.$empid.'/#other_info');
		endif;
	}
	# END SKILL & LEGAL INFORMATION

	# BEGIN CHARACTER REFS
	public function add_char_reference()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'empNumber'	  => $empid,
							'refName'	  => $arrPost['txtref_name'],
							'refAddress'  => $arrPost['txtref_address'],
							'refTelephone'=> $arrPost['txtref_telno']);

			$this->pds_model->add_char_refs($arrData);
			$this->session->set_flashdata('strSuccessMsg','Character reference added successfully.');
			redirect('hr/profile/'.$empid.'/#other_info');
		endif;
	}

	public function edit_char_reference()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'refName'	  => $arrPost['txtref_name'],
							'refAddress'  => $arrPost['txtref_address'],
							'refTelephone'=> $arrPost['txtref_telno']);

			$this->pds_model->save_char_refs($arrData, $arrPost['txtrefid']);
			$this->session->set_flashdata('strSuccessMsg','Character reference updated successfully.');
			redirect('hr/profile/'.$empid.'/#other_info');
		endif;	
	}

	public function del_char_reference()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_char_refs($arrPost['txtdel_char_ref']);

			$this->session->set_flashdata('strSuccessMsg','Character reference deleted successfully.');
			redirect('hr/profile/'.$empid.'/#other_info');
		}
	}
	# END CHARACTER REFS

	# BEGIN POSITION DETAILS
	public function edit_position_details()
	{
	    $empid = $this->uri->segment(3);
	    $this->arrData['arrPositionDesc']=$this->pds_model->getPosition($strEmpNumber);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'service' 		      => $arrPost['sel_srvcode'],
							'firstDayGov' 		  => $arrPost['txt_fday_govt'],
							'effectiveDate' 	  => $arrPost['txtsalary_eff_date'],
							'firstDayAgency' 	  => $arrPost['txt_fday_agency'],
							'statusOfAppointment' => $arrPost['selmode_separation'],
							'contractEndDate' 	  => $arrPost['txt_sep_date'],
							'appointmentCode' 	  => $arrPost['selappt_desc'],
							'officecode' 		  => $arrPost['selexec'],
							'serviceCode' 		  => $arrPost['selservice'],
							'divisionCode'		  => $arrPost['seldivision'],
							'sectionCode'		  => $arrPost['selsection'],
							// 'deptCode'	  		  => $arrPost['seldepartment'],
							'personnelAction' 	  => $arrPost['selper_action'],
							'assignPlace' 		  => $arrPost['txtassign_place'],
							'employmentBasis' 	  => isset($arrPost['optemp_basis']) ? $arrPost['optemp_basis'] : '',
							'categoryService' 	  => isset($arrPost['optcateg_srv']) ? $arrPost['optcateg_srv'] : '',
							'taxStatCode' 		  => $arrPost['sel_tax_stat'],
							'dependents' 		  => $arrPost['txtno_dependents'],
					// plantilla details							
							'uniqueItemNumber' => $arrPost['txtunique_itemno'],
							'itemNumber' 	   => $arrPost['sel_plantilla'],
							'positionCode' 	   => $arrPost['txtplant_pos'],
							'actualSalary' 	   => floatval(str_replace(',', '', $arrPost['txtactual_salary'])),
							'authorizeSalary'  => floatval(str_replace(',', '', $arrPost['txtauthorized_salary'])),
							'positionDate' 	   => $arrPost['txtposition_date'],
							'salaryGradeNumber'=> $arrPost['txtsalary_grade'],
							'stepNumber' 	   => $arrPost['selStep_number'],
							'dateIncremented'  => $arrPost['txt_date_inc']);
			// print_r($arrData);
			// exit(1);
			$this->pds_model->save_position($arrData, $empid);
			$this->session->set_flashdata('strSuccessMsg','Position details updated successfully.');
			redirect('hr/profile/'.$empid.'/#position_details');
		endif;
	}

	public function edit_payroll_details()
	{
	    $empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'payrollGroupCode' => $arrPost['selpayrollGrp'],
							'dtrSwitch' 	   => isset($arrPost['inc_dtr']) ? $arrPost['inc_dtr'] : '',
							'schemeCode'	   => $arrPost['selattScheme'],
							'philhealthSwitch' => isset($arrPost['inc_phealth']) ? $arrPost['inc_phealth'] : '',
							'lifeRetSwitch'    => isset($arrPost['inc_liferet']) ? $arrPost['inc_liferet'] : '',
							'payrollSwitch'    => isset($arrPost['inc_payroll']) ? $arrPost['inc_payroll'] : '',
							'hpFactor' 		   => $arrPost['txthazard'],
							'pagibigSwitch'	   => isset($arrPost['inc_pagibig']) ? $arrPost['inc_pagibig'] : '');

			$this->pds_model->save_position($arrData, $empid);
			$this->session->set_flashdata('strSuccessMsg','Payroll details updated successfully.');
			redirect('hr/profile/'.$empid.'/#position_details');
		endif;
	}

	// public function edit_plantilla_details()
	// {
	//     $empid = $this->uri->segment(3);
	// 	$arrPost = $this->input->post();
	// 	if(!empty($arrPost)):
	// 		$arrData = array(
	// 						'uniqueItemNumber' => $arrPost['txtunique_itemno'],
	// 						'itemNumber' 	   => $arrPost['sel_plantilla'],
	// 						// 'actualSalary' 	   => $arrPost['txtactual_salary'],
	// 						// 'authorizeSalary'  => $arrPost['txtauthorized_salary'],
	// 						'positionDate' 	   => $arrPost['txtposition_date'],
	// 						'salaryGradeNumber'=> $arrPost['txtsalary_grade'],
	// 						'stepNumber' 	   => $arrPost['selStep_number'],
	// 						'dateIncremented'  => $arrPost['txt_date_inc']);

	// 		$this->pds_model->save_position($arrData, $empid);
	// 		$this->session->set_flashdata('strSuccessMsg','Plantilla details updated successfully.');
	// 		redirect('hr/profile/'.$empid);
	// 	endif;
	// }
	# END POSITION DETAILS

	# BEGIN DUTIES & RESPONSIBILITIES
	#	- For Position
	public function add_position_duties()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'positionCode'=> $arrPost['txtdr_poscode'],
							'duties'   	  => $arrPost['txtduties'],
							'percentWork' => $arrPost['txtper_work'],
							'dutyNumber'  => $arrPost['txtno_duty']);
			$this->pds_model->add_duties_position($arrData);
			$this->session->set_flashdata('strSuccessMsg','Duties and responsibilites for position added successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		endif;
	}

	public function edit_position_duties()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'duties'   	  => $arrPost['txtduties'],
							'percentWork' => $arrPost['txtper_work'],
							'dutyNumber'  => $arrPost['txtno_duty']);
			$this->pds_model->save_duties_position($arrData,$arrPost['txtdr_id']);
			$this->session->set_flashdata('strSuccessMsg','Duties and responsibilites for position updated successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		endif;
	}
	
	public function del_position_duties()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_duties_position($arrPost['txtdel_drid']);

			$this->session->set_flashdata('strSuccessMsg','Duties and responsibilites for position deleted successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		}
	}

	#	- For Plantilla
	public function add_plantilla_duties()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'itemNumber'  => $arrPost['txtdr_itemno'],
							'itemDuties'  => $arrPost['txtduties'],
							'percentWork' => $arrPost['txtper_work'],
							'dutyNumber'  => $arrPost['txtno_duty']);
			$this->pds_model->add_duties_plantilla($arrData);
			$this->session->set_flashdata('strSuccessMsg','Duties and responsibilites for plantilla added successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		endif;
	}

	public function edit_plantilla_duties()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'itemDuties'  => $arrPost['txtduties'],
							'percentWork' => $arrPost['txtper_work'],
							'dutyNumber'  => $arrPost['txtno_duty']);
			$this->pds_model->save_duties_plantilla($arrData,$arrPost['txtdr_id']);
			$this->session->set_flashdata('strSuccessMsg','Duties and responsibilites for plantilla updated successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		endif;
	}
	
	public function del_plantilla_duties()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_duties_plantilla($arrPost['txtdel_drid']);

			$this->session->set_flashdata('strSuccessMsg','Duties and responsibilites for plantilla deleted successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		}
	}

	#	- For Actual Duties
	public function add_actual_duties()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'empNumber'  => $empid,
							'duties'  	 => $arrPost['txtduties'],
							'percentWork'=> $arrPost['txtper_work']);
			$this->pds_model->add_duties_actual($arrData);
			$this->session->set_flashdata('strSuccessMsg','Actual Duties and responsibilites added successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		endif;
	}

	public function edit_actual_duties()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'duties'  	 => $arrPost['txtduties'],
							'percentWork'=> $arrPost['txtper_work']);
			$this->pds_model->save_duties_actual($arrData,$arrPost['txtdr_id']);
			$this->session->set_flashdata('strSuccessMsg','Actual Duties and responsibilites updated successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		endif;
	}
	
	public function del_actual_duties()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_duties_actual($arrPost['txtdel_drid']);

			$this->session->set_flashdata('strSuccessMsg','Actual Duties and responsibilites deleted successfully.');
			redirect('hr/profile/'.$empid.'/#duties');
		}
	}
	# END DUTIES & RESPONSIBILITIES

	# BEGIN APPOINTMENT ISSUE DETAILS
	public function add_appointment_issue()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'empNumber'	  		=> $empid,
							'positionCode'	  	=> $arrPost['sel_appt_pos'],
							'dateIssued'  		=> $arrPost['txt_appt_issueddate'],
							'datePublished'  	=> $arrPost['txt_appt_publisheddate'],
							'placePublished'  	=> $arrPost['txt_appt_issuedplace'],
							'relevantExperience'=> $arrPost['txt_appt_relxp'],
							'relevantTraining'  => $arrPost['txt_appt_reltraining']);

			$this->pds_model->add_apptIssue($arrData);
			$this->session->set_flashdata('strSuccessMsg','Appointment issued added successfully.');
			redirect('hr/profile/'.$empid.'/#appoint_issued');
		endif;
	}

	public function edit_appointment_issue()
	{
		$empid = $this->uri->segment(3);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
							'positionCode'	  	=> $arrPost['sel_appt_pos'],
							'dateIssued'  		=> $arrPost['txt_appt_issueddate'],
							'datePublished'  	=> $arrPost['txt_appt_publisheddate'],
							'placePublished'  	=> $arrPost['txt_appt_issuedplace'],
							'relevantExperience'=> $arrPost['txt_appt_relxp'],
							'relevantTraining'  => $arrPost['txt_appt_reltraining']);

			$this->pds_model->save_apptIssue($arrData, $arrPost['txtappt_id']);
			$this->session->set_flashdata('strSuccessMsg','Appointment issued updated successfully.');
			redirect('hr/profile/'.$empid.'/#appoint_issued');
		endif;	
	}

	public function del_appointment_issue()
    {
    	$arrPost = $this->input->post();
    	$empid = $this->uri->segment(3);

		if(!empty($arrPost))
		{
			$this->pds_model->delete_apptIssue($arrPost['txtdel_appt']);

			$this->session->set_flashdata('strSuccessMsg','Appointment issued deleted successfully.');
			redirect('hr/profile/'.$empid.'/#appoint_issued');
		}
	}
	# END APPOINTMENT ISSUE DETAILS

	# BEGIN EDIT EMPLOYEE NUMBER
	public function edit_empnumber()
	{
		$empid = $this->uri->segment(3);
		$new_empid = $_GET['new_empnumber'];
		if($new_empid!=''):
			$this->pds_model->save_empnumber($empid,$new_empid);
			$this->session->set_flashdata('strSuccessMsg','Employee number updated successfully.');
			redirect('hr/profile/'.$new_empid.'/#emp_number');
		endif;
	}
	# END EDIT EMPLOYEE NUMBER

	public function edit_position()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$strEmpNumber = urldecode($this->uri->segment(4));
			$this->arrData['arrPosition']=$this->pds_model->getData($strEmpNumber);
			// $this->arrData['arrProcesswith']=$this->pds_model->getpayrollprocess($appt);
			$this->template->load('template/template_view','pds/position_details_view', $this->arrData);
		}
		else
		{
			$strEmpNumber=$arrPost['strEmpNumber'];
			$strServiceCode  =$arrPost['strServiceCode'];
			$strPayroll-=$arrPost['strPayroll'];
			$strItemNum-=$arrPost['strItemNum'];
			$dtmGovnDay-=$arrPost['dtmGovnDay'];
			$strIncludeDTR-=$arrPost['strIncludeDTR'];
			$strHead-=$arrPost['strHead'];
			$dtmAgencyDay-=$arrPost['dtmAgencyDay'];
			$strIncludePayroll-=$arrPost['strIncludePayroll'];
			$strActual-=$arrPost['strActual'];
			$intSalaryDate-=$arrPost['intSalaryDate'];
			$strAttendance-=$arrPost['strAttendance'];
			$strEmpBasis-=$arrPost['strEmpBasis'];
			$strHP-=$arrPost['strHP'];
			$strAuthorize-=$arrPost['strAuthorize'];
			$strModeofSep-=$arrPost['strModeofSep'];
			$strIncPHealth-=$arrPost['strIncPHealth'];
			$strStepNum-=$arrPost['strStepNum'];
			$dtmSepDate-=$arrPost['dtmSepDate'];
			$strIncPagibig-=$arrPost['strIncPagibig'];
			$strPosition-=$arrPost['strPosition'];
			$strCatService-=$arrPost['strCatService'];
			$strIncLife-=$arrPost['strIncLife'];
			$dtmDateInc-=$arrPost['dtmDateInc'];
			$strTaxStatus-=$arrPost['strTaxStatus'];
			$strSecondment-=$arrPost['strSecondment'];
			$dtmPosDate-=$arrPost['dtmPosDate'];
			$strAppointmentDesc-=$arrPost['strAppointmentDesc'];
			$intDependents-=$arrPost['intDependents'];
			$strExecOffice-=$arrPost['strExecOffice'];
			$strPersonnel-=$arrPost['strPersonnel'];
			$strService-=$arrPost['strService'];
			$strDivision-=$arrPost['strDivision'];
			$strDepartment-=$arrPost['strDepartment'];
			// $XtrainingCode = $this->uri->segment(4);
			if(!empty($strServiceCode))
			{
				$arrData = array(
					'serviceCode'=>$strServiceCode,
					'payrollGroupCode'=>$strPayroll,
					'uniqueItemNumber'=>$strItemNum,
					'firstDayGov'=>$dtmGovnDay,
					'dtrSwitch'=>$strIncludeDTR,
					'head'=>$strHead,
					'firstDayAgency'=>$dtmAgencyDay,
					'payrollSwitch'=>$strIncludePayroll,
					'actualSalary'=>$strActual,
					'effectiveDate'=>$intSalaryDate,
					'schemeCode'=>$strAttendance,
					'salaryGradeNumber'=>$strSG,
					'employmentBasis'=>$strEmpBasis,			
					'hpFactor'=>$strHP,
					'authorizeSalary'=>$strAuthorize,
					'statusOfAppointment'=>$strModeofSep,
					'philhealthSwitch'=>$strIncPHealth,
					'stepNumber'=>$strStepNum,
					'contractEndDate'=>$dtmSepDate,
					'pagibigSwitch'=>$strIncPagibig,
					'positionCode'=>$strPosition,
					'categoryService'=>$strCatService,
					'lifeRetSwitch'=>$strIncLife,
					'dateIncremented'=>$dtmDateInc,
					'taxStatCode'=>$strTaxStatus,
					'includeSecondment'=>$strSecondment,
					'positionDate'=>$dtmPosDate,
					'appointmentCode'=>$strAppointmentDesc,
					'dependents'=>$intDependents,
					'officeCode'=>$strExecOffice,
					'personnelAction'=>$strPersonnel,
					'service'=>$strService,
					'divisionCode'=>$strDivision,
					// 'deptCode'=>$strDepartment
				);
				 // echo '='.$strEmpNumber;
				 // exit(1);
				$blnReturn = $this->pds_model->save_position($arrData, $strEmpNumber);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpPosition','Edited '.$strServiceCode.' Personal',implode(';',$arrData),'');
					$this->session->set_flashdata('strMsg','Position information updated successfully.');
				}
				redirect('hr/profile/'.$strEmpNumber);
			}
		}		
	}

	public function edit_duties()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$strEmpNumber = urldecode($this->uri->segment(4));
			$this->arrData['arrDuties']=$this->pds_model->getData($strEmpNumber);
			$this->template->load('template/template_view','pds/duties_and_responsibilities_view', $this->arrData);
		}
		else
		{
			$strEmpNumber=$arrPost['strEmpNumber'];
			$strPosDuties=$arrPost['strPosDuties'];
			$intPosPercent=$arrPost['intPosPercent'];
			$strPlantillaDuties=$arrPost['strPlantillaDuties'];
			$intPlantillaPercent=$arrPost['intPlantillaPercent'];
			$strActualDuties=$arrPost['strActualDuties'];
			$intActualPercent=$arrPost['intActualPercent'];
			// $positionCode = $this->uri->segment(4);
			if(!empty($strPosDuties))
			{
				$arrData = array(
					'duties'=>$strPosDuties,
					'percentWork'=>$intPosPercent,
					'itemDuties'=>$strPlantillaDuties,
					'percentWork'=>$intPlantillaPercent,
					'duties'=>$strActualDuties,
					'percentWork'=>$intActualPercent
				);
				 // echo '='.$strEmpNumber;
				 // exit(1);
				$blnReturn = $this->pds_model->save_duties($arrData, $strEmpNumber);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpPosition','Edited '.$strServiceCode.' Personal',implode(';',$arrData),'');
					$this->session->set_flashdata('strMsg','Eligibility information updated successfully.');
				}
				redirect('hr/profile/'.$strEmpNumber.'/#duties');
			}
		}		
	}


	public function uploadTraining()
	{
		$arrPost = $this->input->post();
		$strEmpNum = $arrPost['EmployeeId'];
		$idTraining= $arrPost['idTraining'];
		// $config['upload_path']          = 'uploads/employees/attachments/trainings/'.$idTraining.'/';
		$config['upload_path']          = 'uploads/employees/attachments/trainings/'.$strEmpNum.'/';
        $config['allowed_types']        = 'pdf';
        // $path = $_FILES['image']['userfile'];
		// $newName = "<Whatever name>".".".pathinfo($path, PATHINFO_EXTENSION); 
		$config['file_name'] = $idTraining.".pdf"; 
		$config['overwrite'] = TRUE;
		// print_r($config);
		// exit(1);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if (!is_dir($config['upload_path'])) {
    		mkdir($config['upload_path'], 0777, TRUE);
			}

		if ( ! $this->upload->do_upload('userfile'))
		{
			// echo $this->upload->display_errors();
			$error = array('error' => $this->upload->display_errors());
			// print_r($error);
			// exit(1);
			$this->session->set_flashdata('upload_status','Please try again!');
		}
		else
		{
			$data = $this->upload->data();
			$this->session->set_flashdata('upload_status','Upload successfully saved.');
			//rename($data['full_path'],$data['file_path'].$idTraining.$data['file_ext']);
			// print_r($data);
			// exit(1);
			
		}
		// print_r($error);
		// print_r($data);
		// exit(1);
		redirect('hr/profile/'.$strEmpNum.'/#trainings');
		
	}

	public function uploadEduc()
	{
		$arrPost = $this->input->post();
		$strEmpNum = $arrPost['EmployeeId'];
		$idEduc= $arrPost['idEduc'];

		$config['upload_path']          = 'uploads/employees/attachments/educ/'.$strEmpNum.'/';
        $config['allowed_types']        = 'pdf';
  //       $path = $_FILES['image']['userfile'];
		// $newName = "<Whatever name>".".".pathinfo($path, PATHINFO_EXTENSION); 
		$config['file_name'] = $idEduc.".pdf"; 
		$config['overwrite'] = TRUE;
		// print_r($config);
		// exit(1);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if (!is_dir($config['upload_path'])) {
    		mkdir($config['upload_path'], 0777, TRUE);
			}

		if ( ! $this->upload->do_upload('userfile'))
		{
			//echo $this->upload->display_errors();
			$error = array('error' => $this->upload->display_errors());
			
			$this->session->set_flashdata('upload_status','Please try again!');
		}
		else
		{
			$data = $this->upload->data();
			//rename($data['full_path'],$data['file_path'].$idTraining.$data['file_ext']);
			// print_r($data);
			// exit(1);
			
			$this->session->set_flashdata('upload_status','Upload successfully saved.');
			
		}
		// print_r($error);
		// print_r($data);
		// exit(1);
		redirect('hr/profile/'.$strEmpNum.'/#education');
		
	}
 
 	
   
}
