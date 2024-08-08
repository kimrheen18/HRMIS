<?php 
/** 
Purpose of file:    Model for Reports update
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports_model extends CI_Model {
	
	var $table = 'tblReports';
	var $tableid = 'reportCode';


	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}
	
	function reports($arrData)
	{
		$this->db->insert($this->table, $arrData);
		return $this->db->insert_id();		
	}
	
	function getData($strReportCode = '', $intModule = 1)
	{		
		if($strReportCode != "")
		{
			$this->db->where('reportCode',$strReportCode);
		}
		$this->db->order_by('reportDesc');
		$this->db->where('reportModule',$intModule);
		$this->db->where('reportStatus',1);
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}
}
/* End of file Reports_model.php */
/* Location: ./application/modules/employees/models/Reports_model.php */