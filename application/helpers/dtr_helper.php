<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# covert time format to total minutes
if ( ! function_exists('toMinutes'))
{
    function toMinutes($time)
    {
        if($time!=''){
    		$t_time = explode(":",$time);
    		return ($t_time[0] * 60) + $t_time[1];
        }else{
            return 0;
        }
	}

}

# get Flag Ceremony Time
if ( ! function_exists('flag_ceremony_time'))
{
    function flag_ceremony_time()
    {
        $CI =& get_instance();
        $res = $CI->db->select('flagTime')->get('tblAgency')->result_array();
        
        return count($res) > 0 ? $res[0]['flagTime'] : '';
    }
}

# get Flag Ceremony Time
if ( ! function_exists('overtime_details'))
{
    function overtime_details()
    {
        $CI =& get_instance();
        $res = $CI->db->select('minOT,maxOT')->get('tblAgency')->result_array();
        
        return count($res) > 0 ? $res[0] : '';
    }
}

# get all weekends in a month
if ( ! function_exists('get_workingdays'))
{
    function get_workingdays($month,$yr,$arrholidays=null,$sdate='',$edate='')
    {
    	$arrworking_days = array();
        if(strpos(json_encode($arrholidays), 'holidayDate') > 0):
    	   $holidays = array_column($arrholidays, 'holidayDate');
        else:
            $holidays = $arrholidays;
        endif;
        
        if($sdate == '' && $edate == ''):
        	foreach(range(1, cal_days_in_month(CAL_GREGORIAN,$month,$yr)) as $day):
        		$ddate = date('Y-m-d',strtotime(implode('-',array($yr,$month,$day))));
        		if(!in_array(date('D',strtotime($ddate)),array('Sat','Sun')) && !in_array($ddate,$holidays)):
        			array_push($arrworking_days,$ddate);
        		endif;
        	endforeach;
        else:
            $date = $sdate;
            while (strtotime($date) <= strtotime($edate))
            {
                $ddate = date('Y-m-d',strtotime($date));
                if(!in_array(date('D',strtotime($ddate)),array('Sat','Sun')) && !in_array($ddate,$holidays)):
                    array_push($arrworking_days,$ddate);
                endif;
                $date = date('Y-m-d', strtotime($date . ' +1 day'));
            }
        endif;
        
    	return $arrworking_days;
	}

}


# get all weekdays between dates
if ( ! function_exists('get_weekdays'))
{
    function get_weekdays($sdate,$edate)
    {
        $arrweekdays = array();
        while (strtotime($sdate) <= strtotime($edate))
        {
            if(!in_array(date('D',strtotime($sdate)),array('Sat','Sun'))):
                array_push($arrweekdays,$sdate);
            endif;
            $sdate = date('Y-m-d', strtotime($sdate . ' +1 day'));

        }
        return $arrweekdays;
    }

}

# convert12 hr time; 24-time required
if ( ! function_exists('convert_12'))
{
    function convert_12($time)
    {
        return date('h:i', strtotime($time));
    }

}

if ( ! function_exists('dateRange'))
{
    function dateRange($datefrom,$dateto)
    {
        $arrdates = array($datefrom);
        while($datefrom < $dateto):
            $datefrom = strtotime($datefrom);
            $datefrom = date('Y-m-d', strtotime('+1 day', $datefrom));
            array_push($arrdates,$datefrom);
        endwhile;

        return $arrdates;
    }

}

# Get all days
if ( ! function_exists('get_day'))
{
    # day: Mon = 1, Tue = 2, Wed = 3, Thu = 4, Fri = 5, Sat = 6, Sun = 0
    function get_day($datefrom,$dateto,$day)
    {
        $arrdates = array($datefrom);
        while($datefrom < $dateto):
            $datefrom = strtotime($datefrom);
            $datefrom = date('Y-m-d', strtotime('+1 day', $datefrom));
            if(date('N',strtotime($datefrom)) == $day):
                array_push($arrdates,$datefrom);
            endif;
        endwhile;

        return $arrdates;
    }
}

if ( ! function_exists('date_sort'))
{
    function date_sort($a,$b)
    {
        return strtotime($a) - strtotime($b);
    }
}

if ( ! function_exists('seconds_to_time'))
{
    function seconds_to_time($int_mins)
    {
        # extract hours
        $hours = floor($int_mins / (60));

        # extract minutes
        $minutes = $int_mins - ($hours * 60);

        # create string
        $str_hr = $hours > 0 ? $hours > 1 ? sprintf('%02d', $hours).' hrs' : sprintf('%02d', $hours).' hr' : '00 hr';
        $str_mins = $minutes > 0 ? $minutes > 1 ? sprintf('%02d', $minutes).' mins' : sprintf('%02d', $minutes).' min' : '00 min';

        return($str_hr.' and '.$str_mins);
    }
}

if ( ! function_exists('required_hrs'))
{
    function required_hrs($empid)
    {
        $CI =& get_instance();
        $att_scheme = $CI->db->join('tblAttendanceScheme', 'tblAttendanceScheme.schemeCode = tblEmpPosition.schemeCode', 'left')
                                ->where('tblEmpPosition.empNumber',$empid)
                                ->get('tblEmpPosition')->result_array();

        if(count($att_scheme) > 0):
            $sc_am_timein_from = date('H:i',strtotime($att_scheme[0]['amTimeinFrom'].' AM'));
            $sc_pm_timeout_from = date('H:i',strtotime($att_scheme[0]['pmTimeoutFrom'].' PM'));
            return toMinutes($sc_pm_timeout_from) - toMinutes($sc_am_timein_from);
        else:
            return 0;
        endif;
    }
}

if ( ! function_exists('breakhhmm'))
{
    function breakhhmm($strtime)
    {
        foreach(array('hr','hrs','and','min','mins',' ') as $str):
            $strtime = str_replace($str,'',$strtime);
        endforeach;
        
        $exltime = explode(':',$strtime);
        $exltime_hr = (int)ltrim($exltime[0],'0');
        $exltime_min = (int)ltrim($exltime[1],'0');
        $exltime_totalminutes = ($exltime_hr * 60) + $exltime_min;

        return $exltime_totalminutes;
    }
}

