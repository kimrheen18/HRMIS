<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getSignatories'))
{
	function getSignatories($empno="")
    {
    	$CI =& get_instance();
    	$CI->db->Select('signatory,signatoryPosition,signatoryId');
    	if($empno!='')
    		$CI->db->where('signatoryId',$empno);
    	$objQuery = $CI->db->get('tblSignatory');
    	$rs = $objQuery->result_array();
		if(count($rs)>0)
		{
			return $rs;
		}
    }
}  

if ( ! function_exists('getAppStatus'))
{
	function getAppStatus($appstatus="")
    {
    	$CI =& get_instance();
    	$CI->db->Select('appointmentCode,appointmentDesc');
    	if($appstatus!='')
    		$CI->db->where('appointmentCode',$appstatus);
    	$CI->db->order_by('appointmentDesc');
    	$objQuery = $CI->db->get('tblAppointment');
    	$rs = $objQuery->result_array();
		if(count($rs)>0)
		{
			return $rs;
		}
    }
}

if ( ! function_exists('getPosition'))
{
    function getPosition($position="")
    {
        $CI =& get_instance();
        $CI->db->Select('positionCode,positionDesc');
        if($position!='')
            $CI->db->where('positionCode',$position);
        $CI->db->order_by('positionDesc');
        $objQuery = $CI->db->get('tblPosition');
        $rs = $objQuery->result_array();
        if(count($rs)>0)
        {
            return $rs;
        }
    }
}

if ( ! function_exists('getPermanentGroup'))
{
    function getPermanentGroup()
    {
        $CI =& get_instance();
        $CI->db->Select('processWith');
        $CI->db->where('appointmentCode','P');
        $objQuery = $CI->db->get('tblPayrollProcess');
        $rs = $objQuery->result_array();
        if(count($rs)>0)
        {
            return $rs;
        }
    }
}

if ( ! function_exists('getAgencyName'))
{
	function getAgencyName()
    {
    	$CI =& get_instance();
    	$CI->db->Select('agencyName');
    	$objQuery = $CI->db->get('tblAgency');
    	$rs = $objQuery->result_array();
		if(count($rs)>0)
		{
			foreach($rs as $row):
				return $row['agencyName'];
			endforeach;
		}
		else
			return false;
    }
}  

if ( ! function_exists('getSalutation'))
{    
    function getSalutation($t_strGender)
    {
        if($t_strGender == 'F')
        {
            return "Madam";
        }
        else
        {
            return "Sir";
        }   
    }
}

if ( ! function_exists('pronoun'))
{    
    function pronoun($t_strGender)
    {
        if($t_strGender == 'F')
        {
            return "Her";
        }
        else
        {
            return"Him";
        }   
    }
}

if ( ! function_exists('pronoun2'))
{
    function pronoun2($t_strGender)
    {
        if($t_strGender == 'F')
        {
            return "Her";
        }
        else
        {
            return"His";
        }   
    }
}

if ( ! function_exists('titleOfCourtesy'))
{
    function titleOfCourtesy($t_strGender)
    {
        if($t_strGender == 'F')
        {
            return "Ms.";
        }
        else
        {
            return"Mr.";
        }
    }
}

if ( ! function_exists('numOrder'))
{    
    function numOrder($numYears)
    {
    	$arr=array(1=>"First",2=>"Second",3=>"Third",4=>"Fourth",
               5=>"Fifth",6=>"Sixth",7=>"Seventh",8=>"Eighth",
               9=>"Ninth",10=>"Tenth",11=>"Eleventh",12=>"Twelfth",
               13=>"Thirteenth",14=>"Fourteenth");
    	return $arr["$numYears"];
    }
}

if ( ! function_exists('intToBuwan'))
{    
    function intToBuwan($t_intMonth)
    {
        $arrMonths = array(1=>"Enero", 2=>"Pebrero", 3=>"Marso", 
                        4=>"Abril", 5=>"Mayo", 6=>"Hunyo", 
                        7=>"Hulyo", 8=>"Agosto", 9=>"Septembre", 
                        10=>"Oktubre", 11=>"Nobyembre", 12=>"Disyembre");
        return $arrMonths[$t_intMonth];
    }
}

if ( ! function_exists('comboYear'))
{    
    function comboYear($strName="intYear")
    {
        $str =load_plugin('css',array('select'));
    	$str .= '<select name="'.$strName.'" class="form-control bs-select">';
    	for($i=date('Y');$i>=2003;$i--)
    	{
    		$str .= '<option value="'.$i.'">'.$i.'</option>';
    	}
    	$str .= '</select>';
        $str .=load_plugin('js',array('select'));
    	return $str;
    }
}

if ( ! function_exists('comboMonth'))
{    
    function comboMonth($strName="intMonth")
    {
        $str =load_plugin('css',array('select'));
    	$str .= '<select name="'.$strName.'" class="form-control bs-select">';
    	for($i=1;$i<=12;$i++)
    	{
    		$str .= '<option value="'.$i.'" '.(date('n')==$i?'selected="selected"':'').'>'.date('F',strtotime(date('Y-'.$i.'-d'))).'</option>';
    	}
    	$str .= '</select>';
        $str .=load_plugin('js',array('select'));
    	return $str;
    }
}

if ( ! function_exists('comboDay'))
{    
    function comboDay($strName="intDay",$intMaxDay=31)
    {
    	$str =load_plugin('css',array('select'));
    	$str .= '<select name="'.$strName.'" class="form-control bs-select">';
    	for($i=1;$i<=$intMaxDay;$i++)
    	{
    		$str .= '<option value="'.$i.'" '.(date('j')==$i?'selected="selected"':'').'>'.$i.'</option>';
    	}
    	$str .= '</select>';
        $str .=load_plugin('js',array('select'));
    	return $str;
    }
}

if ( ! function_exists('comboSignatory'))
{    
    function comboSignatory($strName="intSignatory")
    {
    	$str =load_plugin('css',array('select2'));
    	$str .= '<select name="'.$strName.'" class="form-control select2">';
    	$rs = getSignatories();
    	foreach($rs as $row)
    	{
    		$str .= '<option value="'.$row['signatoryId'].'" >'.$row['signatory'].'</option>';
    	}
    	$str .= '</select>';
        $str .=load_plugin('js',array('select2'));
    	return $str;
    }
}

if ( ! function_exists('comboAppStatus'))
{    
    function comboAppStatus($strName="strAppStatus")
    {
    	
    	$str = '<select name="'.$strName.'" class="form-control">';
    	$rs = getAppStatus();
    	$str .= '<option></option>';
    	foreach($rs as $row)
    	{
    		$str .= '<option value="'.$row['appointmentCode'].'" >'.$row['appointmentDesc'].'</option>';
    	}
    	$str .= '</select>';
    	return $str;
    }
}

if ( ! function_exists('comboPosition'))
{    
    function comboPosition($strName="strPosition")
    {
        
        $str = '<select name="'.$strName.'" class="form-control">';
        $rs = getPosition();
        $str .= '<option></option>';
        foreach($rs as $row)
        {
            $str .= '<option value="'.$row['positionCode'].'" >'.$row['positionDesc'].'</option>';
        }
        $str .= '</select>';
        return $str;
    }
}

if (! function_exists('daySuffix'))
{
	function daySuffix($day)
	{
		
		if($day==1 || $day==21 || $day==31)	
			$day = $day.'st';
		elseif($day==2 || $day==22)	
			$day = $day.'nd';
		elseif($day==3 || $day==23)	
			$day = $day.'rd';
		elseif($day>=4 && $day<=20)	
			$day = $day.'th';
		elseif($day>=24 && $day<=30)	
			$day = $day.'th';		
			
		return $day;
	}
}

if (! function_exists('intToMonthName'))
{
	function intToMonthName($t_intMonth)
	{
		$arrMonths = array(1=>"Jan", 2=>"Feb", 3=>"Mar", 
						4=>"Apr", 5=>"May", 6=>"Jun", 
						7=>"Jul", 8=>"Aug", 9=>"Sep", 
						10=>"Oct", 11=>"Nov", 12=>"Dec");
		return $arrMonths[$t_intMonth];
	}
}

if (! function_exists('intToMonthFull'))
{
	function intToMonthFull($t_intMonth)
	{
		$arrMonths = array(1=>"January", 2=>"February", 3=>"March", 
						4=>"April", 5=>"May", 6=>"June", 
						7=>"July", 8=>"August", 9=>"September", 
						10=>"October", 11=>"November", 12=>"December");
		return $arrMonths[$t_intMonth];
	}
}

if (! function_exists('mi'))
{
    function mi($strMI)
    {
        return $strMI!=""?str_replace('.','',substr($strMI,0,1)).'. ':'';
    }
}