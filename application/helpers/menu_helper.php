<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


# UPDATE Label for Library menu
if ( ! function_exists('get_libraries'))
{
    function get_libraries()
    {
		$CI =& get_instance();
		/* array('module/controller'=>'Label for Library menu')*/
		return array(
			'agency_profile'=>'Agency Information',
			'appointment_status'=>'Appointment Status',
			'attendance_scheme'=>'Attendance Scheme',
			'backup'=>'Back-up',
			'course'=>'Course',
			'country'=>'Country',
			'duties_responsibilities'=>'Duties and Responsibilities',
			'educ_level'=>'Educational Level',
			'separation_mode'=>'Employment Status',
			'exam_type'=>'Exam Type',
			'holiday'=>'Holiday',
			'leave_type'=>'Leave Type',
			'org_structure'=>'Org Structure',
			'payroll_group'=>'Payroll Group',
			'philhealth_range'=>'Philhealth Range',
			'plantilla'=>'Plantilla',
			'plantilla_group'=>'Plantilla Group',
			'plantilla_duties'=>'Plantilla Duties',
			'position'=>'Position Code',
			'project_code'=>'Project Code',
			'request'=>'Request',
			'salary_sched'=>'Salary Schedule',
			'scholarship'=>'Scholarship',
			'service_code'=>'Service Code',
			'signatories'=>'Signatory',
			'user_account'=>'User Account'
		);
	}
}

if ( ! function_exists('get_request'))
{
	function get_request()
    {
		$CI =& get_instance();

		return array(
			'official_business'=>'Official Business',
			'leave'=>'Leave',
			'travelorder'=>'Travel Order',
			'update_pds'=>'PDS Update',
			'update_dtr'=>'DTR Update',
			'reports'=>'Reports',
			'compensatory_leave'=>'Compensatory Time Off',
			
		);
	}
}

if ( ! function_exists('get_leave'))
{

	function get_leave()
    {
		$CI =& get_instance();

		return array(
			'special_leave'=>'Special Leave',
			'sick_leave'=>'Sick Leave',
			'vacation_leave'=>'Vacation Leave',
			'study_leave'=>'Study Leave',
			'maternity_leave'=>'Maternity Leave',
			'paternity_leave'=>'Paternity Leave',
			'forced_leave'=>'Forced Leave',
			
		);
	}

}

if ( ! function_exists('get_process_code'))
{
	function get_process_code()
    {
		return array(
			array('code' => 'BENEFITS', 'desc'=>'Benefits'),
			array('code' => 'BONUS', 	'desc'=>'Bonus'),
			// array('code' => 'CONTRI', 	'desc'=>'Contribution'),
			// array('code' => 'LOAN', 	'desc'=>'Loan'),
			// array('code' => 'PAYROLL', 	'desc'=>'Payroll'),
			array('code' => 'SALARY', 	'desc'=>'Salary')
		);
	}
}

if ( ! function_exists('deduction_type'))
{
    function deduction_type()
    {
		return array('Regular', 'Contribution', 'Loan', 'Others');
	}

}

if ( ! function_exists('income_type'))
{
    function income_type()
    {
		return array('Additional','Benefit', 'Bonus','Monthly');
	}

}

if ( ! function_exists('pending_notif'))
{
    function pending_notif($strEmpNo,$access_level)
    {
		$CI =& get_instance();
		$arrnotif = array();

		if($access_level == 1):

			$CI->load->model(array('libraries/Request_model','employee/Notification_model'));

			$requestFlow = $CI->Request_model->getRequestFlow('HR');
			$emp_requests = $CI->Request_model->notification_request();
			$requests = $CI->Notification_model->check_request_flow_and_signatories($requestFlow,$emp_requests);

			$arrnotif = $CI->Notification_model->gethr_requestflow($requests);


			// $CI->db->where('(requestDate >= \''.date('Y').'-01-01\' and requestDate <= LAST_DAY(\''.date('Y').'-12-01\'))');
			// $arrnotif = $CI->db->get_where('tblEmpRequest', array('SignatoryFin' => '', 'requestStatus!=' => 'Cancelled'))->result_array();
			// echo $CI->db->last_query();
		elseif($access_level == 5):
			$arrnotif = $CI->db->select('*')->get_where('tblEmpRequest', array('empNumber' => $strEmpNo, 'requestStatus' => 'Filed Request'))->result_array();
		endif;
		
		return $arrnotif;
	}
}

if ( ! function_exists('check_module'))
{
    function check_module()
    {
    	$CI =& get_instance();
    	$useraccess = $CI->session->userdata('sessUserLevel');
    	
    	$module = '';
    	switch ($useraccess):
    		case 1:
    			$module = 'hr'; break;
    		case 2:
    			$module = 'finance'; break;
    		case 3:
    			$module = 'officer'; break;
    		case 4:
    			$module = 'executive'; break;
    		case 5:
    			$module = 'employee'; break;
    	endswitch;
    	return $module;
	}

}
