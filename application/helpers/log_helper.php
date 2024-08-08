<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('log_action'))
{
    function log_action($strEmpNo,$strModule,$strTableName,$strDescription,$strData,$strData2)
    {
		$CI =& get_instance();
		$arrLogData = array(
			'empNumber' 	=> $strEmpNo,
			'module'		=> $strModule,
			'tablename' 	=> $strTableName,
			'date_time' 	=> date('Y-m-d H:i:s'),
			'description'	=> $strDescription,
			'data'			=> $strData,
			'data2'			=> $strData2,
			'ip'			=> $CI->input->ip_address()
			);
		$CI->db->insert('tblChangeLog', $arrLogData);
		return $CI->db->insert_id();	
	}
}