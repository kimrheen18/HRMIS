<?php 
/** 
Purpose of file:    Model for Notification
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		$this->db->initialize();	
	}

	function getData($intrequestID = '')
	{		
		if($intrequestID != "")
		{
			$this->db->where('requestID',$intrequestID);
		}
		$this->db->join('tblempPersonal','tblempPersonal.empNumber = tblEmpRequest.empNumber','left');
		$objQuery = $this->db->get('tblEmpRequest');
		return $objQuery->result_array();	
	}

	// showing all notifications
	// function getData($intrequestID = '')
	// {		
	// 	if($intrequestID != "")
	// 	{
	// 		$this->db->where('requestID',$intrequestID);
	// 	}
	// 	$this->db->join('tblempPersonal','tblempPersonal.empNumber = tblEmpRequest.empNumber','left');
	// 	$objQuery = $this->db->get('tblEmpRequest');
	// 	return $objQuery->result_array();	
	// }


	function add($arrData)
	{
		$this->db->insert('tblEmpRequest', $arrData);
		return $this->db->insert_id();		
	}
	
	// function checkExist($strAppointmentCode = '', $strAppointmentDesc = '')
	// {		
	// 	$strSQL = " SELECT * FROM tblAppointment					
	// 				WHERE  
	// 				appointmentCode ='$strAppointmentCode' OR
	// 				appointmentDesc ='$strAppointmentDesc'					
	// 				";
	// 	//echo $strSQL;exit(1);
	// 	$objQuery = $this->db->query($strSQL);
	// 	return $objQuery->result_array();	
	// }

				
		
	function save($arrData, $intAppointmentId)
	{
		$this->db->where('appointmentId', $intAppointmentId);
		$this->db->update('tblAppointment', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intAppointmentId)
	{
		$this->db->where('appointmentId', $intAppointmentId);
		$this->db->delete('tblAppointment'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	# BEGIN NOTIFICATION
	function signatoryflow($next_sign, $flow_sign, $req_sign)
	{
		switch ($next_sign):
		    case 'Signatory2':
		        $this->checksignatory2($flow_sign, $req_sign);
		        break;
		    case 'Signatory3':
		        $this->checksignatory3($flow_sign, $req_sign);
		        break;
		    case 'Signatory4':
		        $this->checksignatory4($flow_sign, $req_sign);
		        break;
		    default:
		    	$this->checksignatory1($flow_sign, $req_sign);
		        break;
		endswitch;
	}

	function checksignatory1($flow_sign, $req_sign)
	{
		print_r($flow_sign);
		print_r($req_sign);
		// if($flow_sign['Signatory1'] != ''):
		// 	if($req_sign['Signatory1'] != ''):
		// 		$this->signatoryflow('Signatory2', $flow_sign, $req_sign);
		// 	else:
		// 		return $flow_sign['Signatory1'];
		// 	endif;
		// else:
		// 	$this->signatoryflow('Signatory2', $flow_sign, $req_sign);
		// endif;
	}

	function checksignatory2($flow_sign, $req_sign)
	{
		if($flow_sign['Signatory2'] != ''):
			if($req_sign['Signatory2'] != ''):
				$this->signatoryflow('Signatory3', $flow_sign, $req_sign);
			else:
				return $flow_sign['Signatory2'];
			endif;
		else:
			$this->signatoryflow('Signatory3', $flow_sign, $req_sign);
		endif;
	}

	function checksignatory3($flow_sign, $req_sign)
	{
		if($flow_sign['Signatory3'] != ''):
			if($req_sign['Signatory3'] != ''):
				$this->signatoryflow('Signatory4', $flow_sign, $req_sign);
			else:
				return $flow_sign['Signatory3'];
			endif;
		else:
			$this->signatoryflow('Signatory4', $flow_sign, $req_sign);
		endif;
	}

	function checksignatory4($flow_sign, $req_sign)
	{
		if($flow_sign['SignatoryFin'] != ''):
			if($req_sign['SignatoryFin'] != ''):
				return 'done';
			else:
				return $flow_sign['SignatoryFin'];
			endif;
		else:
			return 'done';
		endif;
	}

	function getDestination($desti)
	{
		$desti = explode(';', $desti);
		if(count($desti) > 1):
			$empdesti = employee_name($desti[2]);
			switch ($desti[0]):
			    case 'RECOMMENDED':
			        return 'for Recommendation by '.$empdesti;
			        echo 'for Recommendation by '.$empdesti;
			        break;
			    case 'APPROVED':
			        return 'for Approval by '.$empdesti;
			        echo 'for Approval by '.$empdesti;
			        break;
			    case 'CERTIFIED':
			        return 'for Certification by '.$empdesti;
			        echo 'for Certification by '.$empdesti;
			        break;
			    default:
			    	return '';
			        break;
			endswitch;
		endif;
	}
	# END NOTIFICATION
	
	function getrequestflow($arrflow, $requestType)
	{
		$arrRequestFlow = array();
		$arr_rflow = array();
		foreach($arrflow as $flow):
			if($flow['RequestType'] == $requestType):
				array_push($arrRequestFlow,$flow);
			endif;
		endforeach;
		if(count($arrRequestFlow) > 1):
			foreach($arrRequestFlow as $rflow):
				if($rflow['Applicant'] != 'ALLEMP'){
					array_push($arr_rflow,$rflow);
				}
			endforeach;
		else:
			if(count($arrRequestFlow) > 0){
				array_push($arr_rflow,$arrRequestFlow[0]);
			}
		endif;
		
		if(count($arr_rflow) > 0){
			return $arr_rflow[0];
		}
	}

	function validate_signature($flow_sign, $req_sign, $field)
	{
		if($flow_sign[$field] != ''):
			if($req_sign[$field] != ''):
				return 1;
			else:
				return 0;
			endif;
		else:
			return 1;
		endif;
	}

	function gethr_requestflow($requests)
	{
		$forhr_requests = array();
		foreach($requests as $req):
			if(strpos($req['req_nextsign'], 'HR') !== false):
				array_push($forhr_requests,$req);
			endif;
		endforeach;

		return $forhr_requests;
		// $arrhr_flow = array();
		// foreach($arrRequestFlow as $rflow):
		// 	$field = '';
		// 	$request = null;
		// 	if(strpos($rflow['Signatory1'], 'HR') !== false){
		// 		$field = 'Signatory1';
		// 		$request = $rflow;
		// 	}
		// 	if(strpos($rflow['Signatory2'], 'HR') !== false){
		// 		$field = 'Signatory2';
		// 		$request = $rflow;
		// 	}
		// 	if(strpos($rflow['Signatory3'], 'HR') !== false){
		// 		$field = 'Signatory3';
		// 		$request = $rflow;
		// 	}
		// 	if(strpos($rflow['SignatoryFin'], 'HR') !== false){
		// 		$field = 'SignatoryFin';
		// 		$request = $rflow;
		// 	}
		// 	if($field!='' && $request!=null){
		// 		$arrhr_flow[] = array('field' => $field, 'request' => $request);
		// 	}
		// endforeach;

		// return $arrhr_flow;
	}

	function check_request_flow_and_signatories($requestFlow,$emp_requests)
	{
		$arrRequest = array();
		foreach($emp_requests as $request):
			$request['code'] = $request['requestCode'];
			if($request['requestCode'] == 'Leave'):
				$reqdetails = explode(';', $request['requestDetails']);
				$request['requestCode'] = $reqdetails[0];
			endif;

			$rflow = $this->Notification_model->getrequestflow($requestFlow, $request['requestCode']);
			$next_sign = '';
			$sign_no = '';
			if($request['SignatoryFin'] == ''):
				# check signatory 1
				$sign1 = $this->Notification_model->validate_signature($rflow, $request, 'Signatory1');
				if($sign1):
					# signatory 1 is done -> check signatory 2
					$sign2 = $this->Notification_model->validate_signature($rflow, $request, 'Signatory2');
					if($sign2):
						# signatory 2 is done -> check signatory 3
						$sign3 = $this->Notification_model->validate_signature($rflow, $request, 'Signatory3');
						if($sign3):
							# signatory 3 is done -> check final signatory
							$sign4 = $this->Notification_model->validate_signature($rflow, $request, 'SignatoryFin');
							if(!$sign4):
								$next_sign = $rflow['SignatoryFin'];
								$sign_no = 'SignatoryFin';
							endif;
						else:
							$next_sign = $rflow['Signatory3'];
							$sign_no = 'Signatory3';
						endif;
					else:
						$next_sign = $rflow['Signatory2'];
						$sign_no = 'Signatory2';
					endif;
				else:
					# next destination is signatory 1
					$next_sign = $rflow['Signatory1'];
					$sign_no = 'Signatory1';
				endif;
			else:
				$next_sign = '';
			endif;

			$request_detail = array('req_id' => $request['requestID'],
								  'req_emp' => $request['empNumber'],
								  'req_date' => $request['requestDate'],
								  'req_code' => $request['code'],
								  'req_type' => $request['requestCode'],
								  'req_status' => $request['requestStatus'],
								  'req_remarks' => $request['remarks'],
								  'req_details' => $request['requestDetails'],
								  'req_nextsign' => $next_sign,
								  'req_sign_no' => $sign_no);

			$arrRequest[] = $request_detail;
		endforeach;

		return $arrRequest;
	}


}
