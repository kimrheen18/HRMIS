<?php 
/** 
Purpose of file:    Model for Request Signatories Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Request_model extends CI_Model {

	var $table = 'tblRequestFlow';
	var $tableid = 'reqID';

	var $table2 = 'tblEmpRequest';
	var $tableid2 = 'empNumber';

	var $table3 = 'tblRequestType';
	var $tableid3 = 'requestCode';

	var $table4 = 'tblRequestApplicant';
	var $tableid4 = 'AppliCode';

	var $table5 = 'tblgroup1';
	var $tableid5 = 'group1Code';
	
	var $table6 = 'tblRequestSignatoryAction';
	var $tableid6 = 'ID';

	var $table7 = 'tblRequestSignatory';
	var $tableid7 = 'SignCode';
	
	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getData($req_id='')
	{		
		if($req_id!=''):
			$res = $this->db->get_where($this->table,array('reqID' => $req_id))->result_array();
			return count($res) > 0 ? $res[0] : array();
		endif;

		$this->db->order_by('reqID');
		return $this->db->get_where($this->table,array('isactive' => 1))->result_array();	
	}

	function getEmpDetails($intEmpNumber = '')
	{		
	    if($intEmpNumber != "")
		{
			$this->db->where('empNumber',$intEmpNumber);
		}
		$this->db->join('tblEmpPersonal','tblEmpAccount.empNumber = tblEmpPersonal.empNumber','left');
		
		$objQuery = $this->db->get('tblEmpAccount');
		return $objQuery->result_array();	
	}

	function getRequestType($req_code='')
	{
		$leaves = $this->db->get('tblLeave')->result_array();
		$request_types = $this->db->get($this->table3)->result_array();
		$request_types[] = array('requestCode' => 'Monetization','requestDesc' => 'Monetization');
		unset($request_types[array_search('leave', array_column($request_types, 'requestCode'))]);

		foreach($leaves as $key => $leave):
			$request_types[] = array('requestCode' => $leave['leaveCode'],'requestDesc' => $leave['leaveType']);
		endforeach;

		$request_types = array_sort($request_types, 'requestDesc', SORT_ASC);
		if($req_code!=''):
			foreach($request_types as $rt): if($rt['requestCode'] == $req_code): return $rt; endif; endforeach;
		else:
			return $request_types;
		endif;
	}

	function getApplicant($strAppliCode = '')
	{		
		if($strAppliCode != "")
		{
			$this->db->where($this->tableid4,$strAppliCode);
		}
		$objQuery = $this->db->get($this->table4);
		return $objQuery->result_array();	
	}

	function getOfficeName($intLevel, $strGroupCode = '')
	{		
		$this->db->select('*');
		$where='';
		if($strGroupCode != "")
		{
			$this->db->where('group'.($intLevel-1).'Code',$strGroupCode);
		}
		$this->db->order_by('group'.($intLevel).'Name','asc');
		$objQuery = $this->db->get('tblGroup'.$intLevel);
		return $objQuery->result_array();	
	}

	function check_request_flow($request_type,$applicant)
	{
		$res = $this->db->get_where('tblRequestFlow',array('RequestType' => $request_type, 'Applicant' => $applicant))->result_array();
		return count($res) > 0 ? 1 : 0;
	}

	function getAction($strAction = '')
	{		
		if($strAction != "")
		{
			$this->db->where($this->tableid6,$strAction);
		}
		
		$objQuery = $this->db->get($this->table6);
		return $objQuery->result_array();	
	}

	function getSignatory($strSignatory = '')
	{		
		if($strSignatory != "")
		{
			$this->db->where($this->tableid7,$strSignatory);
		}
		
		$objQuery = $this->db->get($this->table7);
		return $objQuery->result_array();	
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}

	function checkExist($strReqType = '', $strGenApplicant = '', $str1stOfficer='',$str2ndOfficer='',$str3rdOfficer='',$str4thOfficer='')
	{		
		$this->db->where('RequestType',$strReqType);
		$this->db->where('Applicant', $strGenApplicant);
		$this->db->where('Signatory1', $str1stOfficer);	
		$this->db->where('Signatory2', $str2ndOfficer);	
		$this->db->where('Signatory3', $str3rdOfficer);	
		$this->db->where('SignatoryFin', $str4thOfficer);			
		// echo $this->db->last_query();
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function save($arrData, $intReqId)
	{
		$this->db->where($this->tableid, $intReqId);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intReqId)
	{
		$this->db->where($this->tableid, $intReqId);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function update_employeeRequest($arrData, $requestid)
	{
		$this->db->where('requestID', $requestid);
		$this->db->update('tblEmpRequest', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function get_signature($request_code)
	{
		$this->load->model('Request_model');
		$signatories = $this->Request_model->request_signatories_bytype($request_code);
		$arremp_signature = array();
		if(count($signatories) > 0):
			$arremp_signature = array();
			if($signatories['Signatory1'] != ''):
				$signatory = explode(';',$signatories['Signatory1']);
				if(count($signatory) > 2):
					if($signatory[2] == $_SESSION['sessEmpNo']):
						$arremp_signature = array('Signatory1' => $_SESSION['sessEmpNo'], 'Sig1DateTime' =>date('Y-m-d'));
					endif;
				endif;
			endif;

			if($signatories['Signatory2'] != ''):
				$signatory = explode(';',$signatories['Signatory2']);
				if(count($signatory) > 2):
					if($signatory[2] == $_SESSION['sessEmpNo']):
						$arremp_signature = array('Signatory2' => $_SESSION['sessEmpNo'], 'Sig2DateTime' =>date('Y-m-d'));
					endif;
				endif;
			endif;

			if($signatories['Signatory3'] != ''):
				$signatory = explode(';',$signatories['Signatory3']);
				if(count($signatory) > 2):
					if($signatory[2] == $_SESSION['sessEmpNo']):
						$arremp_signature = array('Signatory3' => $_SESSION['sessEmpNo'], 'Sig3DateTime' =>date('Y-m-d'));
					endif;
				endif;
			endif;

			if($signatories['SignatoryFin'] != ''):
				$signatory = explode(';',$signatories['SignatoryFin']);
				if(count($signatory) > 2):
					if($signatory[2] == $_SESSION['sessEmpNo']):
						$arremp_signature = array('SignatoryFin' => $_SESSION['sessEmpNo'], 'SigFinDateTime' =>date('Y-m-d'));
					endif;
				endif;
			endif;
		endif;

		return $arremp_signature;
	}

	function get_next_signatory($ob,$type)
	{
		$this->load->helper('config_helper');

		$this->load->model('Request_model');
		$signatories = $this->Request_model->request_signatories_bytype($type);
		if(count($signatories) > 0):
			
			$rflowsign_1 = $signatories['Signatory1'] != '' ? explode(';',$signatories['Signatory1']) : array('','','');
			$rflowsign_2 = $signatories['Signatory2'] != '' ? explode(';',$signatories['Signatory2']) : array('','','');
			$rflowsign_3 = $signatories['Signatory3'] != '' ? explode(';',$signatories['Signatory3']) : array('','','');
			$rflowsign_fin = $signatories['SignatoryFin'] != '' ? explode(';',$signatories['SignatoryFin']) : array('','','');
			if(strtolower($ob['requestStatus']) == 'filed request'):
				# BEGIN SIGNATORY 1
				# check if ob_signatory1 is null
				if($ob['Signatory1'] == ''):
					# check if flow_sign1 is null
					if($rflowsign_1[2] == ''):
						# check if flow_sign2 is null
						if($rflowsign_2[2] == ''):
							# check if flow_sign3 is null
							if($rflowsign_3[2] == ''):
								$display = $rflowsign_fin[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
								return array('next_sign' => getDestination($signatories['SignatoryFin']), 'display' => $display);
							else:
								$display = $rflowsign_3[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
								return array('next_sign' => getDestination($signatories['Signatory3']), 'display' => $display);
							endif;
						else:
							$display = $rflowsign_2[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
							return array('next_sign' => getDestination($signatories['Signatory2']), 'display' => $display);
						endif;
					else:
						$display = $rflowsign_1[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
						return array('next_sign' => getDestination($signatories['Signatory1']), 'display' => $display);
					endif;
				else:
					# BEGIN SIGNATORY 2
					# check if ob_signatory2 is null
					if($ob['Signatory2'] == ''):
						# check if flow_sign2 is null
						if($rflowsign_2[2] == ''):
							# check if flow_sign3 is null
							if($rflowsign_3[2] == ''):
								$display = $rflowsign_fin[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
								return array('next_sign' => getDestination($signatories['SignatoryFin']), 'display' => $display);
							else:
								$display = $rflowsign_3[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
								return array('next_sign' => getDestination($signatories['Signatory3']), 'display' => $display);
							endif;
						else:
							$display = $rflowsign_2[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
							return array('next_sign' => getDestination($signatories['Signatory2']), 'display' => $display);
						endif;
					else:
						# BEGIN SIGNATORY 3
						# check if ob_signatory3 is null
						if($ob['Signatory3'] == ''):
							if($rflowsign_3[2] == ''):
								$display = $rflowsign_fin[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
								return array('next_sign' => getDestination($signatories['SignatoryFin']), 'display' => $display);
							else:
								$display = $rflowsign_3[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
								return array('next_sign' => getDestination($signatories['Signatory3']), 'display' => $display);
							endif;
						else:
							# BEGIN FINAL SIGNATORY
							if($ob['SignatoryFin'] == ''):
								$display = $rflowsign_fin[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
								return array('next_sign' => getDestination($signatories['SignatoryFin']), 'display' => $display);
							else:
								$display = $rflowsign_fin[2] == $_SESSION['sessEmpNo'] ? 1 : 0;
								return array('next_sign' => '', 'display' => $display);
							endif;
							# END FINAL SIGNATORY
						endif;
						# END SIGNATORY 3
					endif;
					# END SIGNATORY 2
				endif;
				# END SIGNATORY 1
			else:
				$arr_signs = array($rflowsign_1[2],$rflowsign_2[2],$rflowsign_3[2],$rflowsign_fin[2]);
				if(in_array($_SESSION['sessEmpNo'], $arr_signs)):
					return array('next_sign' => '', 'display' => 1);
				endif;
			endif;
		endif;
		return array('next_sign' => '', 'display' => 0);
	}

	# Request Flow
	function getRequestFlow($app='')
	{
		if($app!=''):
			$this->db->or_like('Applicant', $app, 'before', false);
			$this->db->or_like('Applicant', $app, 'after', false);
			$this->db->or_like('Applicant', $app, 'both', false);
			if(check_module() == 'hr') {
				$this->db->or_where('Applicant','ALLEMP');
			}
			$res = $this->db->get('tblRequestFlow')->result_array();
		else:
			$res = $this->db->get('tblRequestFlow')->result_array();
		endif;
		
		return $res;
	}

	function request_signatories_bytype($request_type)
	{
		$res = $this->db->get_where('tblRequestFlow',array('RequestType' => $request_type))->result_array();
		// ,'isactive' => 1
		return count($res) > 0 ? $res[0] : array();
	}

	function getEmployeeRequest($empnumber,$yr='',$month='')
	{
		$this->db->order_by('requestDate', 'desc');
		if($yr!='' && $month!=''):
			if($month=='all'):
				$this->db->like('requestDate', $yr.'-', 'after', false);
			else:
				$this->db->like('requestDate', $yr.'-'.$month, 'after', false);
			endif;
		endif;

		if(gettype($empnumber) == 'array'):
			$this->db->where_in('empNumber', $empnumber);
			$res = $this->db->get('tblEmpRequest')->result_array();
		else:
			$res = $this->db->get_where('tblEmpRequest', array('empNumber' => $empnumber))->result_array();
		endif;
		
		return $res;
	}

	function getEmpFiledRequest($empNumber,$arrcode=null)
	{
		$smonth = currmo() == 'all' ? '01' : currmo();
		$emonth = currmo() == 'all' ? '12' : currmo();
		$this->db->order_by('requestDate', 'desc');
		$this->db->where('empNumber', $empNumber);
		$this->db->where_in('requestCode', $arrcode);
		$this->db->where('(requestDate >= \''.curryr().'-'.$smonth.'-01\' and requestDate <= LAST_DAY(\''.curryr().'-'.$emonth.'-01\'))');
		if(in_array('201',$arrcode)){
			$this->db->or_like('requestCode','201','after',false);
		}
		// $this->db->where('requestStatus!=','Cancelled');
		$res = $this->db->get_where('tblEmpRequest')->result_array();
		
		return $res;
	}

	function request_type()
	{
		return $this->db->get_where('tblRequestType')->result_array();
	}

	function employee_request($yr='',$month='',$iscancel=0,$status='',$code='')
	{
		if($month == 'all'):
			if($yr != 'all'):
				$this->db->where('(requestDate >= \''.$yr.'-01-01\' and requestDate <= LAST_DAY(\''.$yr.'-12-01\'))');
			endif;
		else:
			if($yr == 'all'):
				$this->db->where("(requestDate like '%".sprintf('%02d', $month)."%'");
			else:
				$this->db->where('(requestDate >= \''.$yr.'-'.$month.'-01\' and requestDate <= LAST_DAY(\''.$yr.'-'.$month.'-01\'))');
			endif;
		endif;

		if($code!=''):
			if($code!='all'):
				if(strpos($code, '201') !== false):
					$this->db->like('requestCode', $code, 'after', false);
				else:
					$this->db->where('requestCode',$code);
				endif;
			endif;
		endif;

		if($iscancel) { $this->db->where('requestStatus!=','Cancelled'); }
		if($status!='') { $this->db->where('requestStatus',$status); }

		$this->db->where('SignatoryFin=','');
		$res = $this->db->get('tblEmpRequest')->result_array();
		
		return $res;
	}

	function notification_request()
	{
		$this->db->where('(requestDate >= \''.date('Y').'-01-01\' and requestDate <= LAST_DAY(\''.date('Y').'-12-01\'))');
		$this->db->where('requestStatus!=','Cancelled');
		$this->db->where('SignatoryFin=','');
		$res = $this->db->get('tblEmpRequest')->result_array();
		
		return $res;
	}

	function request_code()
	{
		$this->db->select('requestCode');
		$this->db->group_by('requestCode');
		$res = $this->db->get('tblEmpRequest')->result_array();
		
		return $res;
	}

	
		
}
