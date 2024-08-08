<?php 
/** 
Purpose of file:    Model for Leave
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Leave_model extends CI_Model {

	var $table = 'tblEmpRequest';
	var $tableid = 'requestID';

	function __construct()
	{
		$this->load->database();
		$this->db->initialize();	
	}
	
	function getData($reqid='')
	{
		if($reqid!=''):
			$res = $this->db->get_where('tblEmpRequest',array('requestID' => $reqid))->result_array();
			return count($res) > 0 ? $res[0] : array();
		else:
			return $this->db->get('tblEmpRequest')->result_array();
		endif;

	}

	function getall_request($empno='')
	{
		if($empno!=''):
			$this->db->where('empNumber',$empno);
		endif;
		return $this->db->order_by('requestDate','DESC')->get_where('tblEmpRequest',array('requestCode' => 'Leave'))->result_array();
	}

	public function getLatestBalance($strEmpNum)
	{
		$this->db->where("empNumber",$strEmpNum);
		$this->db->order_by('periodYear DESC,periodMonth DESC');
		$res = $this->db->get('tblEmpLeaveBalance')->result_array();
		return count($res) > 0 ? $res[0] : array();
	}

	function add_employeeLeave($arrData)
	{
		$this->db->insert('tblEmpLeave', $arrData);
		return $this->db->insert_id();		
	}

	function add_leave_request($arrData)
	{
		$this->db->insert('tblEmpRequest', $arrData);
		return $this->db->insert_id();		
	}

	function getLeaveByCode($code)
	{
		$res = $this->db->get_where('tblLeave',array('leaveCode' => $code))->result_array();
		return count($res) > 0 ? $res[0] : array();
	}
	
	function checkExist($strDay = '')
	{		
		$strSQL = " SELECT * FROM tblEmpRequest					
					WHERE  
					requestDetails ='$strDay' 				
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

	function getleave_balance($empid, $month=0, $yr=0)
	{
		$arrcond = array('empNumber' => $empid);
		if($month != 0) : $arrcond['periodMonth']=$month; endif;
		if($yr != 0) : $arrcond['periodYear']=$yr; endif;

		$this->db->order_by('periodYear,periodMonth' , 'DESC');
		return $this->db->get_where('tblEmpLeaveBalance', $arrcond)->result_array();
	}

	function att_getleave_balance($month,$yr)
	{
		$this->db->where('periodMonth', $month);
		$this->db->where('periodYear', $yr);
		return $this->db->get('tblEmpLeaveBalance')->result_array();
	}

	# get Leaves
	function getleave($empid,$datefrom='',$dateto='')
	{
		$this->db->join('tblLeave','tblLeave.leaveCode = tblEmpLeave.leaveCode');
		$this->db->where('empNumber', $empid);
		if($datefrom!='' && $dateto!=''):
			$this->db->where("(leaveFrom between '".$datefrom."' and '".$dateto."' or leaveTo between '".$datefrom."' and '".$dateto."')");
		endif;
		return $this->db->get('tblEmpLeave')->result_array();
	}

	# add leave
	function addLeaveBalance($arrData)
	{
		$this->db->insert('tblEmpLeaveBalance', $arrData);
		return $this->db->insert_id();
	}

	# update leave balance
	function editLeaveBalance($arrData, $lb_id)
	{
		$this->db->where('lb_id', $lb_id);
		$this->db->update('tblEmpLeaveBalance', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	# delete leave
	function deleteLeaveBalance($lb_id)
	{
		$this->db->where('lb_id', $lb_id);
		$this->db->delete('tblEmpLeaveBalance'); 	
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	# Late undertime equivalent
	function ltut_table_equiv($ltut)
	{
		$arrequiv = array("0"  => 0.000, "1"  => 0.002, "2"  => 0.004,"3"  => 0.006,"4"  => 0.008,"5"  => 0.010,
						  "6"  => 0.012, "7"  => 0.015, "8"  => 0.017,"9"  => 0.019,"10" => 0.021,
						  "11" => 0.023, "12" => 0.025, "13" => 0.027,"14" => 0.029,"15" => 0.031,
						  "16" => 0.033, "17" => 0.035, "18" => 0.037,"19" => 0.040,"20" => 0.042,
						  "21" => 0.044, "22" => 0.046, "23" => 0.048,"24" => 0.050,"25" => 0.052,
						  "26" => 0.054, "27" => 0.056, "28" => 0.058,"29" => 0.060,"30" => 0.062,
						  "31" => 0.065, "32" => 0.067, "33" => 0.069,"34" => 0.071,"35" => 0.073,
						  "36" => 0.075, "37" => 0.077, "38" => 0.079,"39" => 0.081,"40" => 0.083,
						  "41" => 0.085, "42" => 0.087, "43" => 0.090,"44" => 0.092,"45" => 0.094,
						  "46" => 0.096, "47" => 0.098, "48" => 0.100,"49" => 0.102,"50" => 0.104,
						  "51" => 0.106, "52" => 0.108, "53" => 0.110,"54" => 0.112,"55" => 0.115,
						  "56" => 0.117, "57" => 0.119, "58" => 0.121,"59" => 0.123,"60" => 0.125);
		$hrs = 0;
		$mins = 0;
		if($ltut > 0):
			if($ltut>=60){
				$hrs=(int)($ltut/60);
				$mins=($ltut%60);
				$ltut = ($hrs*0.125) + ($arrequiv[$mins]);
			}else{
				$mins=($ltut%60);
				$ltut = $arrequiv[$mins];
			}
		endif;
		return $ltut;
	}

	# Leave Earned
	function leave_earned($absents)
	{
	    $arraycredits = array("0.00"=>1.250,"0.50"=>1.229,"1.00"=>1.208,"1.50"=>1.188,
	                      "2.00"=>1.167,"2.50"=>1.146,"3.00"=>1.125,"3.50"=>1.104,
	                      "4.00"=>1.083,"4.50"=>1.063,"5.00"=>1.042,"5.50"=>1.021,
	                      "6.00"=>1.000,"6.50"=>0.979,"7.00"=>0.958,"7.50"=>0.938,
	                      "8.00"=>0.917,"8.50"=>0.896,"9.00"=>0.875,"9.50"=>0.854,
	                      "10.00"=>0.833,"10.50"=>0.813,"11.00"=>0.792,"11.50"=>0.771,
	                      "12.00"=>0.750,"12.50"=>0.729,"13.00"=>0.708,"13.50"=>0.687,
	                      "14.00"=>0.667,"14.50"=>0.646,"15.00"=>0.625,"15.50"=>0.604,
	                      "16.00"=>0.583,"16.50"=>0.562,"17.00"=>0.542,"17.50"=>0.521,
	                      "18.00"=>0.500,"18.50"=>0.479,"19.00"=>0.458,"19.50"=>0.437,
	                      "20.00"=>0.417,"20.50"=>0.396,"21.00"=>0.375,"21.50"=>0.354,
	                      "22.00"=>0.333,"22.50"=>0.312,"23.00"=>0.292,"23.50"=>0.271,
	                      "24.00"=>0.250,"24.50"=>0.229,"25.00"=>0.208,"25.50"=>0.187,
	                      "26.00"=>0.167,"26.50"=>0.146,"27.00"=>0.125,"27.50"=>0.104,
	                      "28.00"=>0.083,"28.50"=>0.062,"29.00"=>0.042,"29.50"=>0.021,
	                      "30.00"=>0.000);
	    $daysabsent = $absents.".00";
	    
	    return $arraycredits[$daysabsent];
	}

	#Priveledge Leave
	public function getspe_leave($empid, $yr=0)
	{
		$this->db->where("empNumber", $empid);
		$this->db->like("dtrDate", $yr, "after",false);
		$this->db->where("(remarks='PL' OR remarks='SPL')");
		$dtrpl_sl = $this->db->get('tblEmpDTR')->result_array();
		$dtrpl_sl_used = count($dtrpl_sl) > 0 ? count($dtrpl_sl) : 0;
		
		$numdays = $this->db->get_where('tblLeave', array('leaveCode' => 'PL'))->result_array();
		$numdays = count($numdays) > 0 ? $numdays[0]['numOfDays'] : 0;
		
		$spe_leave = $numdays - $dtrpl_sl_used;
		return $spe_leave;
	}

	#Forced Leave
	public function getforce_leave($empid, $yr=0, $month=0)
	{
		$this->db->where("empNumber", $empid);
		$this->db->where("remarks", "FL");
		if($month == 0):
			$this->db->like("dtrDate", $yr,'after',false);
		else:
			$this->db->where("dtrDate >", $yr.'-01-01');
			$this->db->where("dtrDate <", join('-',array($yr,sprintf('%02d', $month+1),'01')));
		endif;
		return $this->db->get('tblEmpDTR')->result_array();
	}

	public function getleave_data($code = '')
	{
		if($code!=''):
			$res = $this->db->get_where('tblLeave', array('leaveCode' => $code))->result_array();
			return count($res) > 0 ? $res[0] : array();
		else:
			return $this->db->get('tblLeave')->result_array();
		endif;
	}

	public function getEmpLeave_balance($empid,$permonth,$peryr)
	{
		$this->db->order_by('periodMonth','ASC');
		if($empid!=''):
			$condition['empNumber'] = $empid;
		endif;
		if($permonth!='all'):
			$condition['periodMonth'] = $permonth;
		endif;
		$condition['periodYear'] = $peryr;

		$res = $this->db->get_where('tblEmpLeaveBalance',$condition)->result_array();
		return $res;
	}

	public function getEmployee_dtr($empno,$mon='',$yr='',$datefrom='',$dateto='')
	{
		if($mon!='' && $yr!=''):
			$this->db->like('dtrdate',$yr.'-'.$mon,'after',false);
		endif;

		if($datefrom!='' && $dateto!=''):
			$this->db->where("dtrDate BETWEEN '".$datefrom."' AND '".$dateto."'");
		endif;

		return $this->db->get_where('tblEmpDTR', array('empNumber' => $empno))->result_array();
	}

	public function filed_vl($empno,$datefrom,$dateto)
	{
		$total_leave = 0;
		$emp_leaves = $this->getEmployee_dtr($empno,'','',$datefrom,$dateto);
		
		foreach($emp_leaves as $leave):
			if(in_array($leave["remarks"],array('HVL','HFL','HPL'))):
				$total_leave = $total_leave + 0.5;
			endif;
			if(in_array($leave["remarks"],array('VL','FL','PL'))):
				$total_leave = $total_leave + 1.0;
			endif;
		endforeach;

		return $total_leave;
	}

	public function filed_sl($empno,$datefrom,$dateto)
	{
		$total_leave = 0;
		$emp_leaves = $this->getEmployee_dtr($empno,'','',$datefrom,$dateto);

		foreach($emp_leaves as $leave):
			if($leave["remarks"]=="HSL"):
				$total_leave = $total_leave + 0.5;
			endif;

			if($leave["remarks"]=="SL"):
				$total_leave = $total_leave + 1.0;
			endif;
		endforeach;
		
		return $total_leave;
	}

	public function filed_leave_others($empno,$datefrom,$dateto,$leave_type)
	{
		$total_leave = 0;
		$emp_leaves = $this->getEmployee_dtr($empno,$mon,$yr);

		# Half Day
		foreach($emp_leaves as $leave):
			if($leave["remarks"]=="H".$leave_type):
				$total_leave = $total_leave + 0.5;
			endif;

			if($leave["remarks"]==$leave_type):
				$total_leave = $total_leave + 1.0;
			endif;
		endforeach;
		
		return $total_leave;
	}

	public function approved_leave($empid,$datefrom,$dateto,$leave_code='')
	{
		$this->db->where('empNumber', $empid);
		$this->db->where("(leaveFrom between '".$datefrom."' and '".$dateto."' or leaveTo between '".$datefrom."' and '".$dateto."')");
		if($leave_code!=''):
			$this->db->where('leaveCode',$leave_code);
		endif;
		$this->db->where('certifyHR','Y');
		$all_leaves = $this->db->get('tblEmpLeave')->result_array();
		$days = 0;

		foreach($all_leaves as $leave):
			$dates = dateRange($leave['leaveFrom'],$leave['leaveTo']);
			$days = $days + count($dates);
		endforeach;
		
		return $days;
	}

	// public function approved_vl($empno,$yr,$mon)
	// {
	// 	$this->db->like('leaveFrom',$this->db->escape_like_str($yr.'-'.$mon),'after',false);
	// 	$emp_leaves = $this->db->get_where('tblEmpLeave', array('empNumber' => $empno, 'leaveCode' => 'VL', 'certifyHR' => 'Y'))->result_array();
	// 	return count($emp_leaves);
	// }
	
	// public function approved_sl($empno,$yr,$mon)
	// {
	// 	$this->db->like('leaveFrom',$this->db->escape_like_str($yr.'-'.$mon),'after',false);
	// 	$emp_leaves = $this->db->get_where('tblEmpLeave', array('empNumber' => $empno, 'leaveCode' => 'SL', 'certifyHR' => 'Y'))->result_array();
	// 	return count($emp_leaves);	
	// }	

}
