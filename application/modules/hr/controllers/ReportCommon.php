<?php
/**
 * SystemName: Human Resoruce Management System
 * 
 * Author: Louie Carl R. Mandapat
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportCommon extends MY_Controller {

	var $arrData;
	
	function __construct() {
        parent::__construct();
        //$this->load->model(array('Hr_model'));
    }

    function comboYear($strName="intYear")
    {
    	$str = '<select name="'.$strName.'" class="form-control">';
    	for($i=date('Y');$i>=2003;$i--)
    	{
    		$str .= '<option value="'.$i.'">'.$i.'</option>';
    	}
    	$str .= '</select>';
    	return $str;
    }

    function comboMonth($strName="intMonth")
    {
    	$str = '<select name="'.$strName.'" class="form-control">';
    	for($i=1;$i<=12;$i++)
    	{
    		$str .= '<option value="'.$i.'" '.(date('n')==$i?'selected="selected"':'').'>'.date('F',strtotime(date('Y-'.$i.'-d'))).'</option>';
    	}
    	$str .= '</select>';
    	return $str;
    }

    function comboDay($strName="intDay",$intMaxDay=31)
    {
    	
    	$str = '<select name="'.$strName.'" class="form-control">';
    	for($i=1;$i<=$intMaxDay;$i++)
    	{
    		$str .= '<option value="'.$i.'" '.(date('j')==$i?'selected="selected"':'').'>'.$i.'</option>';
    	}
    	$str .= '</select>';
    	return $str;
    }

    

}


