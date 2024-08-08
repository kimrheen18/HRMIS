<?php 
/** 
Purpose of file:    Controller for PDS update
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pds_update extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('employee/update_pds_model','hr/Hr_model'));
    }

    public function index()
    {
    	# Notification Menu
    	$active_menu = isset($_GET['status']) ? $_GET['status']=='' ? 'All' : $_GET['status'] : 'All';
    	$menu = array('All','Filed Request','Certified','Cancelled','Disapproved');
    	unset($menu[array_search($active_menu, $menu)]);
    	$notif_icon = array('All' => 'list', 'Filed Request' => 'file-text-o', 'Certified' => 'check', 'Cancelled' => 'ban', 'Disapproved' => 'remove');

    	$this->arrData['active_code'] = isset($_GET['code']) ? $_GET['code']=='' ? 'all' : $_GET['code'] : 'all';
    	$this->arrData['arrNotif_menu'] = $menu;
    	$this->arrData['active_menu'] = $active_menu;
    	$this->arrData['notif_icon'] = $notif_icon;

    	$arrpds_request = $this->update_pds_model->getall_request($_SESSION['sessEmpNo']);
    	if(isset($_GET['status'])):
    		if(strtolower($_GET['status'])!='all'):
    			$pds_request = array();
    			foreach($arrpds_request as $pds):
    				if(strtolower($_GET['status']) == strtolower($pds['requestStatus'])):
    					$pds_request[] = $pds;
    				endif;
    			endforeach;
    			$arrpds_request = $pds_request;
    		endif;
    	endif;
    	$this->arrData['arrpds_request'] = $arrpds_request;
    	$this->template->load('template/template_view', 'employee/pds_update/pds_list', $this->arrData);
    }

	public function add()
	{
		$strEmpNo =$_SESSION['sessEmpNo'];
		$this->arrData['arrData'] = $this->Hr_model->getData($strEmpNo);
		if(count($this->arrData['arrData'])==0) redirect('pds');

		$this->arrData['arrData'] = $this->update_pds_model->getData($strEmpNo);
		$this->arrData['arrEduc_CMB'] = $this->update_pds_model->getEducData();	
		$this->arrData['arrEduc'] = $this->update_pds_model->getEduc($strEmpNo);		
		$this->arrData['arrCourse'] = $this->update_pds_model->getCourseData();
		$this->arrData['arrScholarship'] = $this->update_pds_model->getScholarshipData();
		$this->arrData['arrSchool'] = $this->update_pds_model->getSchoolData();
		$this->arrData['arrTraining_CMB'] = $this->update_pds_model->getTrainingData();
		$this->arrData['arrTraining'] = $this->update_pds_model->getTraining($strEmpNo);
		$this->arrData['arrExamination_CMB'] = $this->update_pds_model->getExamData();
		$this->arrData['arrExamination'] = $this->update_pds_model->getExamination($strEmpNo);
		$this->arrData['arrReference'] = $this->update_pds_model->getRefData($strEmpNo);
		$this->arrData['arrVoluntary'] = $this->update_pds_model->getVoluntary($strEmpNo);
		$this->arrData['arrExperience_CMB'] = $this->update_pds_model->getExpData();
		$this->arrData['arrExperience'] = $this->update_pds_model->getExperience($strEmpNo);
		$this->arrData['arrAppointment'] = $this->update_pds_model->getAppointData();
		$this->arrData['arrSeparation'] = $this->update_pds_model->getSepCauseData();
		$this->arrData['arrDetails'] = $this->update_pds_model->getDetails();
		$this->arrData['arrChild'] = $this->update_pds_model->getChildren($strEmpNo);
		
		$emp_educ = array();
		if(isset($_GET['educ_id'])){
			$emp_educ = $this->update_pds_model->geteduc_data($_GET['educ_id']);
		}
		$this->arrData['emp_educ'] = $emp_educ;

		$emp_tra = array();
		if(isset($_GET['tra_id'])){
			$emp_tra = $this->update_pds_model->gettra_data($_GET['tra_id']);
		}
		$this->arrData['emp_tra'] = $emp_tra;

		$emp_exam = array();
		if(isset($_GET['exam_id'])){
			$emp_exam = $this->update_pds_model->getexam_data($_GET['exam_id']);
		}
		$this->arrData['emp_exam'] = $emp_exam;

		$emp_child = array();
		if(isset($_GET['child_id'])){
			$emp_child = $this->update_pds_model->getchild_data($_GET['child_id']);
		}
		$this->arrData['emp_child'] = $emp_child;

		$emp_ref = array();
		if(isset($_GET['ref_id'])){
			$emp_ref = $this->update_pds_model->getreference_data($_GET['ref_id']);
		}
		$this->arrData['emp_ref'] = $emp_ref;

		$emp_vol = array();
		if(isset($_GET['vol_id'])){
			$emp_vol = $this->update_pds_model->getvoluntary_data($_GET['vol_id']);
		}
		$this->arrData['emp_vol'] = $emp_vol;

		$emp_wxp = array();
		if(isset($_GET['wxp_id'])){
			$emp_wxp = $this->update_pds_model->getworkxp_data($_GET['wxp_id']);
		}
		$this->arrData['emp_wxp'] = $emp_wxp;
		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view', 'employee/pds_update/pds_update_view', $this->arrData);
	}

	public function view()
	{
		$strEmpNo =$_SESSION['sessEmpNo'];
		$arrrequest = $this->update_pds_model->getpds_request($_GET['req_id']);
		$pds_details = isset($arrrequest) ? explode(';',$arrrequest['requestDetails']) : array();
		
		$emp_educ = array();
		if(end($pds_details) == PDS_EDUC){
			$emp_educ = $this->update_pds_model->geteduc_data($pds_details[12]);
			$emp_educ['arrEduc_CMB'] = $this->update_pds_model->getEducData();
			$emp_educ['arrCourse'] = $this->update_pds_model->getCourseData();
			$emp_educ['arrScholarship'] = $this->update_pds_model->getScholarshipData();
		}
		$this->arrData['emp_educ'] = $emp_educ;

		$emp_tra = array();
		if(end($pds_details) == PDS_TRAIN){
			$emp_tra = $this->update_pds_model->gettra_data($pds_details[11]);
		}
		$this->arrData['emp_tra'] = $emp_tra;

		$emp_exam = array();
		if(end($pds_details) == PDS_ELIGIBILITY){
			$emp_exam = $this->update_pds_model->getexam_data($pds_details[7]);
			$emp_exam['arrExamination_CMB'] = $this->update_pds_model->getExamData();
		}
		$this->arrData['emp_exam'] = $emp_exam;

		$emp_child = array();
		if(end($pds_details) == PDS_CHILD){
			$emp_child = $this->update_pds_model->getchild_data($pds_details[3]);
		}
		$this->arrData['emp_child'] = $emp_child;

		$emp_ref = array();
		if(end($pds_details) == PDS_REF){
			$emp_ref = $this->update_pds_model->getreference_data($pds_details[4]);
		}
		$this->arrData['emp_ref'] = $emp_ref;

		$emp_vol = array();
		if(end($pds_details) == PDS_VOLUNTEER){
			$emp_vol = $this->update_pds_model->getvoluntary_data($pds_details[7]);
		}
		$this->arrData['emp_vol'] = $emp_vol;

		$emp_wxp = array();
		if(end($pds_details) == PDS_WORKXP){
			$emp_wxp = $this->update_pds_model->getworkxp_data($pds_details[15]);
			$emp_wxp['arrAppointment'] = $this->update_pds_model->getAppointData();
		}
		$this->arrData['emp_wxp'] = $emp_wxp;

		$this->arrData['pds_details'] = $pds_details;
		$this->arrData['pds_type'] = end($pds_details);

		$this->arrData['arrData'] = $this->update_pds_model->getData($arrrequest['empNumber']);


		$this->template->load('template/template_view', 'employee/pds_update/pds_update_hr_view', $this->arrData);
	}

	public function edit()
	{
		$strEmpNo =$_SESSION['sessEmpNo'];
		$this->arrData['arrData'] = $this->Hr_model->getData($strEmpNo);
		if(count($this->arrData['arrData'])==0) redirect('pds');

		$this->arrData['arrData'] = $this->update_pds_model->getData($strEmpNo);
		$this->arrData['arrEduc_CMB'] = $this->update_pds_model->getEducData();	
		$this->arrData['arrEduc'] = $this->update_pds_model->getEduc($strEmpNo);		
		$this->arrData['arrCourse'] = $this->update_pds_model->getCourseData();
		$this->arrData['arrScholarship'] = $this->update_pds_model->getScholarshipData();
		$this->arrData['arrSchool'] = $this->update_pds_model->getSchoolData();
		$this->arrData['arrTraining_CMB'] = $this->update_pds_model->getTrainingData();
		$this->arrData['arrTraining'] = $this->update_pds_model->getTraining($strEmpNo);
		$this->arrData['arrExamination_CMB'] = $this->update_pds_model->getExamData();
		$this->arrData['arrExamination'] = $this->update_pds_model->getExamination($strEmpNo);
		$this->arrData['arrReference'] = $this->update_pds_model->getRefData($strEmpNo);
		$this->arrData['arrVoluntary'] = $this->update_pds_model->getVoluntary($strEmpNo);
		$this->arrData['arrExperience_CMB'] = $this->update_pds_model->getExpData();
		$this->arrData['arrExperience'] = $this->update_pds_model->getExperience($strEmpNo);
		$this->arrData['arrAppointment'] = $this->update_pds_model->getAppointData();
		$this->arrData['arrSeparation'] = $this->update_pds_model->getSepCauseData();
		$this->arrData['arrDetails'] = $this->update_pds_model->getDetails();
		$this->arrData['arrChild'] = $this->update_pds_model->getChildren($strEmpNo);
		
		$emp_educ = array();
		if(isset($_GET['educ_id'])){
			$emp_educ = $this->update_pds_model->geteduc_data($_GET['educ_id']);
		}
		$this->arrData['emp_educ'] = $emp_educ;

		$emp_tra = array();
		if(isset($_GET['tra_id'])){
			$emp_tra = $this->update_pds_model->gettra_data($_GET['tra_id']);
		}
		$this->arrData['emp_tra'] = $emp_tra;

		$emp_exam = array();
		if(isset($_GET['exam_id'])){
			$emp_exam = $this->update_pds_model->getexam_data($_GET['exam_id']);
		}
		$this->arrData['emp_exam'] = $emp_exam;

		$emp_child = array();
		if(isset($_GET['child_id'])){
			$emp_child = $this->update_pds_model->getchild_data($_GET['child_id']);
		}
		$this->arrData['emp_child'] = $emp_child;

		$emp_ref = array();
		if(isset($_GET['ref_id'])){
			$emp_ref = $this->update_pds_model->getreference_data($_GET['ref_id']);
		}
		$this->arrData['emp_ref'] = $emp_ref;

		$emp_vol = array();
		if(isset($_GET['vol_id'])){
			$emp_vol = $this->update_pds_model->getvoluntary_data($_GET['vol_id']);
		}
		$this->arrData['emp_vol'] = $emp_vol;

		$emp_wxp = array();
		if(isset($_GET['wxp_id'])){
			$emp_wxp = $this->update_pds_model->getworkxp_data($_GET['wxp_id']);
		}
		$this->arrData['emp_wxp'] = $emp_wxp;

		$this->arrData['arrrequest'] = $this->update_pds_model->getpds_request($_GET['req_id']);
		$this->arrData['action'] = 'edit';
		$this->template->load('template/template_view', 'employee/pds_update/pds_update_view', $this->arrData);
	}
	
	public function submitProfile()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$strSname	  = $arrPost['strSname'];
			$strFname	  = $arrPost['strFname'];
			$strMname	  = $arrPost['strMname'];
			$strExtension = $arrPost['strExtension'];
			$dtmBirthdate = $arrPost['dtmBirthdate'];
			$strBirthplace= $arrPost['strBirthplace'];
			$strCS	  	  = $arrPost['strCS'];
			$intWeight	  = $arrPost['intWeight'];
			$intHeight	  = $arrPost['intHeight'];
			$strBlood	  = $arrPost['strBlood'];
			$intGSIS	  = $arrPost['intGSIS'];
			$strBP	  	  = $arrPost['strBP'];
			$intPagibig	  = $arrPost['intPagibig'];
			$intPhilhealth= $arrPost['intPhilhealth'];
			$intTin	  	  = $arrPost['intTin'];

			$strBlk1	  = $arrPost['strBlk1'];
			$strStreet1	  = $arrPost['strStreet1'];
			$strSubd1	  = $arrPost['strSubd1'];
			$strBrgy1	  = $arrPost['strBrgy1'];
			$strCity1	  = $arrPost['strCity1'];
			$strProv1	  = $arrPost['strProv1'];
			$strZipCode1  = $arrPost['strZipCode1'];
			$strTel1	  = $arrPost['strTel1'];

			$strBlk2	  = $arrPost['strBlk2'];
			$strStreet2	  = $arrPost['strStreet2'];
			$strSubd2	  = $arrPost['strSubd2'];
			$strBrgy2	  = $arrPost['strBrgy2'];
			$strCity2	  = $arrPost['strCity2'];
			$strProv2	  = $arrPost['strProv2'];
			$strZipCode2  = $arrPost['strZipCode2'];
			$intTel2	  = $arrPost['intTel2'];
			$strEmail	  = $arrPost['strEmail'];
			$strCP	  	  = $arrPost['strCP'];
			$strStatus	  = $arrPost['strStatus'];
			$strCode	  = $arrPost['strCode'];

			$arrData = array(
				'requestDetails'  => 'Profile'.';'.$strSname.';'.$strFname.';'.$strMname.';'.$strExtension.';'.$dtmBirthdate.';'.$strBirthplace.';'.$strCS.';'.$intWeight.';'.$intHeight.';'.$strBlood.';'.$strBP.';'.$intGSIS.';'.$intPagibig.';'.$intPhilhealth.';'.$intTin.';'.$strBlk1.';'.$strStreet1.';'.$strSubd1.';'.$strBrgy1.';'.$strCity1.';'.$strProv1.';'.$strZipCode1.';'.$strTel1.';'.$strBlk2.';'.$strStreet2.';'.$strSubd2.';'.$strBrgy2.';'.$strCity2.';'.$strProv2.';'.$strZipCode2.';'.$intTel2.';'.$strEmail.';'.$strCP.';'.$strStatus.';'.$strCode,
				'requestDate'	  => date('Y-m-d'),
				'requestStatus'   => $strStatus,
				'requestCode' 	  => '201',
				'empNumber' 	  => $_SESSION['sessEmpNo']);

			if($action=='add'):
				$blnReturn  = $this->update_pds_model->submit_request($arrData);
				if(count($blnReturn)>0):
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strSname.' PDS Update',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
				endif;
			else:
				$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
				if(count($blnReturn)>0):
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strSname.' PDS Update',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
				endif;
			endif;
			redirect('employee/pds_update');
		}
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function submitFam()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$strSSurname	= $arrPost['strSSurname'];
			$strSFirstname	= $arrPost['strSFirstname'];
			$strSMidname	= $arrPost['strSMidname'];
			$strSNameExt	= $arrPost['strSNameExt'];
			$strSOccupation	= $arrPost['strSOccupation'];
			$strSBusname	= $arrPost['strSBusname'];
			$strSBusadd		= $arrPost['strSBusadd'];
			$strSTel		= $arrPost['strSTel'];
			$strFSurname	= $arrPost['strFSurname'];
			$strFFirstname	= $arrPost['strFFirstname'];
			$strFMidname	= $arrPost['strFMidname'];
			$strFExtension	= $arrPost['strFExtension'];
			$strMSurname	= $arrPost['strMSurname'];
			$strMFirstname	= $arrPost['strMFirstname'];
			$strMMidname	= $arrPost['strMMidname'];
			$strPaddress	= $arrPost['strPaddress'];
			$strStatus		= $arrPost['strStatus'];
			$strCode		= $arrPost['strCode'];

			$arrData = array(
				'requestDetails' => 'Family'.';'.$strSSurname.';'.$strSFirstname.';'.$strSMidname.';'.$strSNameExt.';'.$strSOccupation.';'.$strSBusname.';'.$strSBusadd.';'.$strSTel.';'.$strFSurname.';'.$strFFirstname.';'.$strFMidname.';'.$strFExtension.';'.$strMSurname.';'.$strMFirstname.';'.$strMMidname.';'.$strPaddress.';'.$strCode,
				'requestDate' 	 => date('Y-m-d'),
				'requestStatus'  => $strStatus,
				'requestCode' 	 => '201',
				'empNumber' 	 => $_SESSION['sessEmpNo']);

			if($action=='add'):
				$blnReturn  = $this->update_pds_model->submit_request($arrData);
				if(count($blnReturn)>0):
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strSSurname.' PDS Update',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
				endif;
			else:
				$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
				if(count($blnReturn)>0):
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strSSurname.' PDS Update',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
				endif;
			endif;
			redirect('employee/pds_update');
		}
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function submitEduc()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
    	if(!empty($arrPost)):
    		$arrData = array(
    			'requestDetails' => implode(';',array('Education',$arrPost['strLevelDesc'],$arrPost['strSchName'],$arrPost['strDegree'],$arrPost['dtmFrmYr'],$arrPost['dtmTo'],$arrPost['intUnits'],$arrPost['strScholarship'],$arrPost['strHonors'],$arrPost['strLicensed'],$arrPost['strGraduated'],$arrPost['strYrGraduated'],$arrPost['txteducid'],$arrPost['strCode'])),
    			'requestDate'	 => date('Y-m-d'),
    			'requestStatus'	 => $arrPost['strStatus'],
    			'requestCode'	 => '201',
    			'empNumber'		 => $_SESSION['sessEmpNo']);

    		if($action=='add'):
    			$blnReturn = $this->update_pds_model->submit_request($arrData);
    			if(count($blnReturn)>0):
    				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strLevelDesc.' PDS Update',implode(';',$arrData),'');
    				$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
    			endif;
    		else:
    			$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
    			if(count($blnReturn)>0):
    				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strLevelDesc.' PDS Update',implode(';',$arrData),'');
    				$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
    			endif;
    		endif;

    		redirect('employee/pds_update');
    	endif;
    }

    public function submitTraining()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$strTrainTitle=$arrPost['strTrainTitle'];
			$dtmStartDate=$arrPost['dtmStartDate'];
			$dtmEndDate=$arrPost['dtmEndDate'];
			$dtmHours=$arrPost['dtmHours'];
			$strTypeLD=$arrPost['strTypeLD'];
			$strConduct=$arrPost['strConduct'];
			$strVenue=$arrPost['strVenue'];
			$intCost=$arrPost['intCost'];
			$dtmContract=$arrPost['dtmContract'];
			
			$strStatus=$arrPost['strStatus'];
			$strCode=$arrPost['strCode'];

			$allPost = array('Training',$arrPost['strTrainTitle'],$arrPost['dtmStartDate'],$arrPost['dtmEndDate'],$arrPost['dtmHours'],$arrPost['strTypeLD'],$arrPost['strConduct'],$arrPost['strVenue'],$arrPost['intCost'],$arrPost['dtmContract'],$arrPost['txttraid'],$strCode);

			if(count(array_unique($allPost)) === 1 && end($allPost) === ''):
				$this->session->set_flashdata('strErrorMsg','Request is empty.');
				redirect('employee/pds_update');
			else:
				$arrData = array(
					'requestDetails' => implode(';',$allPost),
					'requestDate'    => date('Y-m-d'),
					'requestStatus'  => $strStatus,
					'requestCode'    => '201',
					'empNumber' 	 => $_SESSION['sessEmpNo']);

				if($action=='add'):
					$blnReturn  = $this->update_pds_model->submit_request($arrData);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strTrainTitle.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
					endif;
				else:
					$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strTrainTitle.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
					endif;
				endif;
				
				redirect('employee/pds_update');
			endif;
		}
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function submitExam()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$arrPost['strExamDesc'] = $arrPost['strExamDesc']=='0'?'':$arrPost['strExamDesc'];
			$strExamDesc  = $arrPost['strExamDesc'];
			$strrating    = $arrPost['strrating'];
			$dtmExamDate  = $arrPost['dtmExamDate'];
			$strPlaceExam = $arrPost['strPlaceExam'];
			$intLicenseNo = $arrPost['intLicenseNo'];
			$dtmRelease   = $arrPost['dtmRelease'];
			$strStatus    = $arrPost['strStatus'];
			$strCode      = $arrPost['strCode'];

			$allPost = array('Examination',$arrPost['strExamDesc'],$arrPost['strrating'],$arrPost['dtmExamDate'],$arrPost['strPlaceExam'],$arrPost['intLicenseNo'],$arrPost['dtmRelease'],$arrPost['txtexamid'],$strCode);

			if(count(array_unique($allPost)) === 1 && end($allPost) === ''):
				$this->session->set_flashdata('strErrorMsg','Request is empty.');
				redirect('employee/pds_update');
			else:
				$arrData = array(
					'requestDetails'=>implode(';',$allPost),
					'requestDate'=>date('Y-m-d'),
					'requestStatus'=>$strStatus,
					'requestCode'=>'201',
					'empNumber'=>$_SESSION['sessEmpNo']);

				if($action=='add'):
					$blnReturn  = $this->update_pds_model->submit_request($arrData);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strExamDesc.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
					endif;
				else:
					$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strExamDesc.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
					endif;
				endif;
				redirect('employee/pds_update');
			endif;
		}
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function submitChild()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$strChildName  = $arrPost['strChildName'];
			$dtmChildBdate = $arrPost['dtmChildBdate'];

			$strStatus 	   = $arrPost['strStatus'];
			$strCode 	   = $arrPost['strCode'];

			$allPost = array('Children',$arrPost['strChildName'],$arrPost['dtmChildBdate'],$arrPost['txtchildid'],$strCode);

			if(count(array_unique($allPost)) === 1 && end($allPost) === ''):
				$this->session->set_flashdata('strErrorMsg','Request is empty.');
				redirect('employee/pds_update');
			else:
				$arrData = array(
							'requestDetails'=>implode(';',$allPost),
							'requestDate'=>date('Y-m-d'),
							'requestStatus'=>$strStatus,
							'requestCode'=>'201',
							'empNumber'=>$_SESSION['sessEmpNo']);

				if($action=='add'):
					$blnReturn  = $this->update_pds_model->submit_request($arrData);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strChildName.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
					endif;
				else:
					$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strChildName.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
					endif;
				endif;
				redirect('employee/pds_update');
			endif;
		}
		
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function submitTax()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$intTaxCert=$arrPost['intTaxCert'];
			$strIssuedAt=$arrPost['strIssuedAt'];
			$dtmIssuedOn=$arrPost['dtmIssuedOn'];

			$strStatus=$arrPost['strStatus'];
			$strCode=$arrPost['strCode'];

			$arrData = array(
						'requestDetails'=>'Tax'.';'.$intTaxCert.';'.$strIssuedAt.';'.$dtmIssuedOn.';'.$strCode,
						'requestDate'=>date('Y-m-d'),
						'requestStatus'=>$strStatus,
						'requestCode'=>'201',
						'empNumber'=>$_SESSION['sessEmpNo']);
			
			if($action=='add'):
				$blnReturn  = $this->update_pds_model->submit_request($arrData);
				if(count($blnReturn)>0):
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$intTaxCert.' PDS Update',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
				endif;
			else:
				$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
				if(count($blnReturn)>0):
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$intTaxCert.' PDS Update',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
				endif;
			endif;
			redirect('employee/pds_update');
		}
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function submitRef()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$strRefName=$arrPost['strRefName'];
			$strRefAdd=$arrPost['strRefAdd'];
			$intRefContact=$arrPost['intRefContact'];

			$strStatus=$arrPost['strStatus'];
			$strCode=$arrPost['strCode'];

			$allPost = array('Reference',$arrPost['strRefName'],$arrPost['strRefAdd'],$arrPost['intRefContact'],$arrPost['txtrefid'],$strCode);
			if(count(array_unique($allPost)) === 1 && end($allPost) === ''):
				$this->session->set_flashdata('strErrorMsg','Request is empty.');
				redirect('employee/pds_update');
			else:
				$arrData = array(
					'requestDetails'=> implode(';',$allPost),
					'requestDate'	=> date('Y-m-d'),
					'requestStatus'	=> $strStatus,
					'requestCode'	=> '201',
					'empNumber'		=> $_SESSION['sessEmpNo']);

					if($action=='add'):
						$blnReturn  = $this->update_pds_model->submit_request($arrData);
						if(count($blnReturn)>0):
							log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strRefName.' PDS Update',implode(';',$arrData),'');
							$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
						endif;
					else:
						$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
						if(count($blnReturn)>0):
							log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strRefName.' PDS Update',implode(';',$arrData),'');
							$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
						endif;
					endif;
					redirect('employee/pds_update');
			endif;
		}
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function submitVol()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$strVolName=$arrPost['strVolName'];
			$strVolAdd=$arrPost['strVolAdd'];
			$dtmVolDateFrom=$arrPost['dtmVolDateFrom'];
			$dtmVolDateTo=$arrPost['dtmVolDateTo'];
			$intVolHours=$arrPost['intVolHours'];
			$strNature=$arrPost['strNature'];

			$strStatus=$arrPost['strStatus'];
			$strCode=$arrPost['strCode'];

			$allPost = array('Voluntary',$arrPost['strVolName'],$arrPost['strVolAdd'],$arrPost['dtmVolDateFrom'],$arrPost['dtmVolDateTo'],$arrPost['intVolHours'],$arrPost['strNature'],$arrPost['txtvolid'],$strCode);
			if(count(array_unique($allPost)) === 1 && end($allPost) === ''):
				$this->session->set_flashdata('strErrorMsg','Request is empty.');
				redirect('employee/pds_update');
			else:
				$arrData = array(
					'requestDetails'=>implode(';',$allPost),
					'requestDate'=>date('Y-m-d'),
					'requestStatus'=>$strStatus,
					'requestCode'=>'201',
					'empNumber'=>$_SESSION['sessEmpNo']);
				
				if($action=='add'):
					$blnReturn  = $this->update_pds_model->submit_request($arrData);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$strVolName.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
					endif;
				else:
					$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$strVolName.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
					endif;
				endif;

				redirect('employee/pds_update');
			endif;
		}
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function submitWorkExp()
    {
    	$action = isset($_GET['action']) ? $_GET['action'] : 'add';
    	$arrPost = $this->input->post();
		if(!empty($arrPost))
		{
			$dtmExpDateFrom=$arrPost['dtmExpDateFrom'];
			$dtmExpDateTo=$arrPost['dtmExpDateTo'];
			$chkpresent=isset($arrPost['chkpresent']) ? 'Present' : '';
			$strPosTitle=$arrPost['strPosTitle'];
			$strExpDept=$arrPost['strExpDept'];
			$strSalary=$arrPost['strSalary'];
			$strExpPer=$arrPost['strExpPer'];
			$strCurrency=$arrPost['strCurrency'];
			$strExpSG=$arrPost['strExpSG'];
			$strAStatus=$arrPost['strAStatus'];
			$strGovn=isset($arrPost['strGovn'])?$arrPost['strGovn']:'N';
			$strBranch=$arrPost['strBranch'];
			$strSepCause=$arrPost['strSepCause'];
			$strSepDate=$arrPost['strSepDate'];
			$strLV=$arrPost['strLV'];

			$strStatus=$arrPost['strStatus'];
			$strCode=$arrPost['strCode'];

			$allPost = array('WorkXP',$arrPost['dtmExpDateFrom'],$arrPost['dtmExpDateTo'],$arrPost['strPosTitle'],$arrPost['strExpDept'],$arrPost['strSalary'],$arrPost['strExpPer'],$arrPost['strCurrency'],$arrPost['strExpSG'],$arrPost['strAStatus'],$strGovn,$arrPost['strBranch'],$arrPost['strSepCause'],$arrPost['strSepDate'],$arrPost['strLV'],$arrPost['txtwxpid'],$strCode);
			if(count(array_unique($allPost)) === 1 && end($allPost) === ''):
				$this->session->set_flashdata('strErrorMsg','Request is empty.');
				redirect('employee/pds_update');
			else:
				$arrData = array(
					// 'requestDetails'=>'WorkXP'.';'.$dtmExpDateFrom.';'.$dtmExpDateTo.';'.$chkpresent.';'.$strPosTitle.';'.$strExpDept.';'.$strSalary.';'.$strExpPer.';'.$strCurrency.';'.$strExpSG.';'.$strAStatus.';'.$strGovn.';'.$strBranch.';'.$strSepCause.';'.$strSepDate.';'.$strLV.';'.$arrPost['txtwxpid'],
					'requestDetails'=>implode(';',$allPost),
					'requestDate'=>date('Y-m-d'),
					'requestStatus'=>$strStatus,
					'requestCode'=>'201',
					'empNumber'=>$_SESSION['sessEmpNo']
				);

				if($action=='add'):
					$blnReturn  = $this->update_pds_model->submit_request($arrData);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Added '.$dtmExpDateFrom.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been submitted.');
					endif;
				else:
					$blnReturn  = $this->update_pds_model->save($arrData, $arrPost['txtreqid']);
					if(count($blnReturn)>0):
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Updated '.$dtmExpDateFrom.' PDS Update',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Request has been updated.');
					endif;
				endif;
				redirect('employee/pds_update');
			endif;
		}
    	$this->template->load('template/template_view','employee/pds_update/pds_update_view',$this->arrData);
    }

    public function cancel()
    {
    	$arrData = array('requestStatus' => 'Cancelled');
    	$blnReturn = $this->update_pds_model->save($arrData,$_POST['txtpds_req_id']);
    	if(count($blnReturn)>0):
    		log_action($this->session->userdata('sessEmpNo'),'HR Module','tblEmpRequest','Cancel request id = '.$_POST['txtpds_req_id'].' PDS Update ',implode(';',$arrData),'');
    		$this->session->set_flashdata('strSuccessMsg','Your request has been cancelled.');
    	endif;
    	redirect('employee/pds_update');
    }



}