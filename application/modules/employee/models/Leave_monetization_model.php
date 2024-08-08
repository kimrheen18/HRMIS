<?php 
/** 
Purpose of file:    Model for Leave Monetization
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Leave_monetization_model extends CI_Model {

	var $table = 'tblEmpLeaveBalance';
	var $tableid = 'requestID';

	var $table2 = 'tblEmpLeaveMonetization';
	var $tableid2 = 'requestID';

	function __construct()
	{
		$this->load->database();
		$this->db->initialize();	
	}
	
	function getrequest($reqid='')
	{
		if($reqid!=''):
			$res = $this->db->get_where('tblEmpRequest',array('requestID' => $reqid))->result_array();
			return count($res) > 0 ? $res[0] : array();
		else:
			return $this->db->get('tblEmpRequest')->result_array();
		endif;

	}

	function getData($intLBId = '')
	{		
		$strWhere = '';
		if($intLBId != "")
			$strWhere .= " AND lb_id = '".$intLBId."'";
		
		$strSQL = " SELECT * FROM tblEmpLeaveBalance					
					WHERE 1=1 
					$strWhere
					-- ORDER BY requestDate
					";
			
		$objQuery = $this->db->query($strSQL);
		//print_r($objQuery->result_array());
		return $objQuery->result_array();	
	}

	function getall_request($empno='')
	{
		if($empno!=''):
			$this->db->where('empNumber',$empno);
		endif;
		$this->db->like('requestCode','Monetization');
		return $this->db->order_by('requestDate','DESC')->get('tblEmpRequest')->result_array();
	}

	function submit($arrData)
	{
		$this->db->insert('tblEmpRequest', $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($strCode = '')
	{		
		$strSQL = " SELECT * FROM tblEmpRequest					
					WHERE  
					requestDetails ='$str_details' AND requestCode = 'Monetization'";
		//echo $strSQL;exit(1);
		$objQuery = $this->db->query($strSQL);
		return $objQuery->result_array();	
	}

	function save($arrData, $intReqId)
	{
		$this->db->where('requestID', $intReqId);
		$this->db->update('tblEmpRequest', $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intReqId)
	{
		$this->db->where('requestID', $intReqId);
		$this->db->delete('tblEmpRequest'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function getemp_monetized($empid, $month, $yr)
	{
		return $this->db->get_where('tblEmpMonetization', array('processMonth' => $month,'processYear' => $yr,'empNumber' => $empid))->result_array();
	}

	function getemp_total_monetized($empid, $month, $yr)
	{
		$this->db->select('SUM(vlMonetize) as vlmonetize, SUM(slMonetize) as slmonetize');
		$res = $this->db->get_where('tblEmpMonetization', array('processMonth' => $month,'processYear' => $yr,'empNumber' => $empid))->result_array();
		return count($res) > 0 ? $res[0] : null;
	}
	
	function addemp_monetized($arrData)
	{
		$this->db->insert('tblEmpMonetization', $arrData);
		return $this->db->insert_id();		
	}

	function delete_monetized($monid)
	{
		$this->db->where('mon_id', $monid);
		$this->db->delete('tblEmpMonetization'); 	
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}


}
