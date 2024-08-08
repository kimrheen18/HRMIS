<?php 
/** 
Purpose of file:    Model for Compensatory Time Off
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Compensatory_leave_model extends CI_Model {

	var $table = 'tblEmpRequest';
	var $tableid = 'requestID';

	function __construct()
	{
		$this->load->database();
		$this->db->initialize();	
	}
	
	function getall_request($empno='')
	{
		if($empno!=''):
			$this->db->where('empNumber',$empno);
		endif;
		$this->db->order_by('requestDate','DESC');
		$this->db->where('requestCode','CL');
		$this->db->or_where('requestCode','CTO');
		return $this->db->get('tblEmpRequest')->result_array();
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
	
	function getData($intReqId = '')
	{		
		$strWhere = '';
		if($intReqId != "")
			$strWhere .= " AND requestID = '".$intReqId."'";
		
		$strSQL = " SELECT * FROM tblEmpRequest					
					WHERE 1=1 
					$strWhere
					ORDER BY requestDate
					";
			
		$objQuery = $this->db->query($strSQL);
		//print_r($objQuery->result_array());
		return $objQuery->result_array();	
	}

	function getOffsetBal($intLBId = '')
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

	function submit($arrData)
	{
		$this->db->insert('tblEmpRequest', $arrData);
		return $this->db->insert_id();		
	}

	function add_cto($arrData)
	{
		$this->db->insert('tblcompensatory_timeoff', $arrData);
		return $this->db->insert_id();		
	}
	
	function checkExist($dtmComLeave = '')
	{		
		$strSQL = " SELECT * FROM tblEmpRequest					
					WHERE  
					requestDetails ='$dtmComLeave'				
					";
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

	function get_cto_used($empid)
	{
		return $this->db->get_where('tblEmpRequest', array('empNumber' => $empid, 'requestCode' => 'CL', 'requestStatus' => 'CERTIFIED'))->result_array();
	}

	function get_emp_cto($dtr_id)
	{
		return $this->db->get_where('tblcompensatory_timeoff', array('dtr_id' => $dtr_id))->result_array();
	}

	function get_all_overtime($empid)
	{
		$this->load->model(array('hr/Attendance_summary_model','libraries/Attendance_scheme_model'));
		$att_scheme = $this->Attendance_scheme_model->getAttendanceScheme($empid);
		$sc_nn_timein_from = date('H:i',strtotime($att_scheme['nnTimeinFrom'].' PM'));
		$sc_nn_timeout_from = date('H:i',strtotime($att_scheme['nnTimeoutFrom'].' PM'));

		$all_ots = $this->db->get_where('tblEmpDTR', array('empNumber' => $empid, 'OT' => 1))->result_array();

		$total_ot = 0;
		foreach($all_ots as $dtr):
			$new_date = date('Y-m-d', strtotime("+1 year +1 month", strtotime($dtr['dtrDate'])));
			$dtrdate = $dtr['dtrDate'];

			if($new_date >= date('Y-m-d')){
				$emp_dtr = $this->Attendance_summary_model->getemp_dtr($empid, $dtrdate, $dtrdate);
				$total_ot = $total_ot + $emp_dtr[0]['ot'];
			}
		endforeach;

		$all_cto = $this->db->get_where('tblcompensatory_timeoff', array('empnumber' => $empid))->result_array();
		$total_cto = 0;
		$new_dtr[] = array();
		foreach($all_cto as $key=>$cto):
			$cto_timefrom = $cto['cto_timefrom'];
			$cto_timeto   = $cto['cto_timeto'];
			$new_dtr[$key]['inAM']  = '';
			$new_dtr[$key]['outAM'] = '';
			$new_dtr[$key]['inPM']  = '';
			$new_dtr[$key]['outPM'] = '';
			$new_dtr[$key]['dtrDate'] = $cto['cto_date'];

			if($cto_timefrom < $sc_nn_timein_from) {
				$new_dtr[$key]['inAM'] = $cto_timefrom;	
			}else{
				$new_dtr[$key]['inPM'] = $cto_timefrom;	
			}
			if($cto_timeto < $sc_nn_timeout_from){
				$new_dtr[$key]['outAM'] = $cto_timeto;
			}else{
				$new_dtr[$key]['outPM'] = $cto_timeto;
			}

			$total_cto = $total_cto + $this->Attendance_summary_model->compute_working_hours($att_scheme,$new_dtr[$key]);
		endforeach;

		$valid_cto = $total_ot - $total_cto;

		return $valid_cto > 0 ? $valid_cto : 0;
	}

		
}
