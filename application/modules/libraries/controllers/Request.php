<?php 
/** 
Purpose of file:    Controller for Request Signatories Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/request_model','hr/hr_model','employee/leave_model'));
    }

	public function index()
	{
		$arrRequest = array();
		$all_requests = $this->request_model->getData();
		
		foreach($all_requests as $key => $request):
			$requestDesc = array();
			foreach(explode(';',$request['RequestType']) as $rtype):
				$arr_reqtype = $this->request_model->getRequestType($rtype);
				if(count($arr_reqtype) > 0):
					$rrtype = $arr_reqtype['requestDesc'];
				else:
					$rrtype = $rtype;
				endif;
				$requestDesc[] = $rrtype;
			endforeach;
			$all_requests[$key]['requestDesc'] = implode('; ',$requestDesc);

			$first_sign = explode(';',$request['Signatory1']);
			$first_signatory = count($first_sign) > 1 ? $first_sign[1]!=''?$this->request_model->getSignatory($first_sign[1]) : array() : array();
			$all_requests[$key]['first_signatory'] = count($first_sign) > 1 ? array($first_sign[0],count($first_signatory) > 0 ? $first_signatory[0]['Signatory'] : '',count($first_sign) > 1 ? employee_name($first_sign[2]) : '') : array();

			$second_sign = explode(';',$request['Signatory2']);
			$second_signatory = count($second_sign) > 1 ? $second_sign[1]!=''?$this->request_model->getSignatory($second_sign[1]) : array() : array();
			$all_requests[$key]['second_signatory'] = count($second_sign) > 1 ? array($second_sign[0],count($second_signatory) > 0 ? $second_signatory[0]['Signatory'] : '',count($second_sign) > 1 ? employee_name($second_sign[2]) : '') : array();

			$third_sign = explode(';',$request['Signatory3']);
			$third_signatory = count($third_sign) > 1 ? $third_sign[1]!=''?$this->request_model->getSignatory($third_sign[1]) : array() : array();
			$all_requests[$key]['third_signatory'] = count($third_sign) > 1 ? array($third_sign[0],count($third_signatory) > 0 ? $third_signatory[0]['Signatory'] : '',count($third_sign) > 1 ? employee_name($third_sign[2]) : '') : array();

			$fourth_sign = explode(';',$request['Signatory4']);
			$fourth_signatory = count($fourth_sign) > 1 ? $fourth_sign[1]!=''?$this->request_model->getSignatory($fourth_sign[1]) : array() : array();
			$all_requests[$key]['fourth_signatory'] = count($fourth_sign) > 1 ? array($fourth_sign[0],count($fourth_signatory) > 0 ? $fourth_signatory[0]['Signatory'] : '',count($fourth_sign) > 1 ? employee_name($fourth_sign[2]) : '') : array();

			$final_sign = explode(';',$request['SignatoryFin']);
			$final_signatory = count($final_sign) > 1 ? $final_sign[1]!=''?$this->request_model->getSignatory($final_sign[1]) : array() : array();
			$all_requests[$key]['final_signatory'] = count($final_sign) > 1 ? array($final_sign[0],count($final_signatory) > 0 ? $final_signatory[0]['Signatory'] : '',count($final_sign) > 1 ? employee_name($final_sign[2]) : '') : array();
		endforeach;
		
		$this->arrData['arrRequest'] = $all_requests;
		$this->template->load('template/template_view', 'libraries/request/list_view', $this->arrData);
	}
	
	public function add()
    {
    	$arrPost = $this->input->post();

		if(!empty($arrPost)):
			$request_type = implode(';',$arrPost['request_type']);
			$applicant = implode(';',array($arrPost['app_type'],$arrPost['app_office'],$arrPost['app_employee']));
			$arrData = array(
				'RequestType' => $request_type,
				'Applicant'	  => $applicant,
				'Signatory1'  => implode(';',array($arrPost['sig1_action'],$arrPost['sig1_signatory'],$arrPost['sig1_officer']=='0'?'':$arrPost['sig1_officer'])),
				'Signatory2'  => implode(';',array($arrPost['sig2_action'],$arrPost['sig2_signatory'],$arrPost['sig2_officer']=='0'?'':$arrPost['sig2_officer'])),
				'Signatory3'  => implode(';',array($arrPost['sig3_action'],$arrPost['sig3_signatory'],$arrPost['sig3_officer']=='0'?'':$arrPost['sig3_officer'])),
				'Signatory4'  => implode(';',array($arrPost['sig4_action'],$arrPost['sig4_signatory'],$arrPost['sig4_officer']=='0'?'':$arrPost['sig4_officer'])),
				'SignatoryFin'=> implode(';',array($arrPost['sigfinal_action'],$arrPost['sigfinal_signatory'],$arrPost['sigfinal_officer']=='0'?'':$arrPost['sigfinal_officer'])));

			if($this->request_model->check_request_flow($request_type,$applicant)):
				$this->session->set_flashdata('strErrorMsg','Request already exists.');
			else:
				$blnReturn  = $this->request_model->add($arrData);
				if(count($blnReturn)>0)
				{	
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblRequestflow','Added '.$request_type.' Request',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Request signatory added successfully.'); 
				}
			endif;
			redirect('libraries/request');
		endif;

		$this->arrData['arrRequestType'] = $this->request_model->getRequestType();
		$this->arrData['arrApplicant'] = $this->request_model->getApplicant();
		$this->arrData['arrEmployees'] = $this->hr_model->getData();
		$this->arrData['arrAction'] = $this->request_model->getAction();
		$this->arrData['arrSignatory'] = $this->request_model->getSignatory();
		$this->arrData['action'] = 'add';

		$this->template->load('template/template_view','libraries/request/add_view',$this->arrData);
    }

    public function edit()
	{
		$req_id = $this->uri->segment(4);

		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$request_type = implode(';',$arrPost['request_type']);
			//$applicant = implode(';',array($arrPost['app_type'],$arrPost['app_office'],$arrPost['app_employee']));
			$applicant = implode(';',array($arrPost['app_type'],$arrPost['app_office'],$arrPost['app_employee']));
			$arrData = array(
				'RequestType' => $request_type,
				'Applicant'	  => $applicant,
				'Signatory1'  => implode(';',array($arrPost['sig1_action'],$arrPost['sig1_signatory'],$arrPost['sig1_officer']=='0'?'':$arrPost['sig1_officer'])),
				'Signatory2'  => implode(';',array($arrPost['sig2_action'],$arrPost['sig2_signatory'],$arrPost['sig2_officer']=='0'?'':$arrPost['sig2_officer'])),
				'Signatory3'  => implode(';',array($arrPost['sig3_action'],$arrPost['sig3_signatory'],$arrPost['sig3_officer']=='0'?'':$arrPost['sig3_officer'])),
				'Signatory4'  => implode(';',array($arrPost['sig4_action'],$arrPost['sig4_signatory'],$arrPost['sig4_officer']=='0'?'':$arrPost['sig4_officer'])),
				'SignatoryFin'=> implode(';',array($arrPost['sigfinal_action'],$arrPost['sigfinal_signatory'],$arrPost['sigfinal_officer']=='0'?'':$arrPost['sigfinal_officer'])));

			$blnReturn = $this->request_model->save($arrData, $req_id);
			if(count($blnReturn)>0)
			{	
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblRequestflow','Update '.$request_type.' Request',implode(';',$arrData),'');
				$this->session->set_flashdata('strSuccessMsg','Request signatory updated successfully.'); 
			}
			redirect('libraries/request');
		endif;

		$this->arrData['action'] = 'edit';
		$this->arrData['request_flow'] = $this->request_model->getData($req_id);

		$this->arrData['arrRequestType'] = $this->request_model->getRequestType();
		$this->arrData['arrApplicant'] = $this->request_model->getApplicant();
		$this->arrData['arrEmployees'] = $this->hr_model->getData();
		$this->arrData['arrAction'] = $this->request_model->getAction();
		$this->arrData['arrSignatory'] = $this->request_model->getSignatory();
		$this->template->load('template/template_view','libraries/request/add_view',$this->arrData);
	}

	public function delete()
	{
		$req_id = $this->uri->segment(4);

		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array('isactive' => 0);

			$blnReturn = $this->request_model->save($arrData, $req_id);
			if(count($blnReturn)>0)
			{	
				log_action($this->session->userdata('sessEmpNo'),'HR Module','tblRequestflow','delete Request',implode(';',$arrData),'');
				$this->session->set_flashdata('strSuccessMsg','Request signatory updated successfully.'); 
			}
			redirect('libraries/request');
		endif;

		$this->arrData['action'] = 'delete';
		$this->arrData['request_flow'] = $this->request_model->getData($req_id);

		$this->arrData['arrRequestType'] = $this->request_model->getRequestType();
		$this->arrData['arrApplicant'] = $this->request_model->getApplicant();
		$this->arrData['arrEmployees'] = $this->hr_model->getData();
		$this->arrData['arrAction'] = $this->request_model->getAction();
		$this->arrData['arrSignatory'] = $this->request_model->getSignatory();
		$this->template->load('template/template_view','libraries/request/add_view',$this->arrData);
		
	}
}
