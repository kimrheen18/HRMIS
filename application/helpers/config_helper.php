<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# year start
if ( ! function_exists('getyear'))
{
    function getyear($syr=0)
    {
        $syear = $syr == 0 ? 2003 : $syr;
		$arrYears = array();
        foreach(range((date('Y') + 1), $syear, -1) as $yr):
            array_push($arrYears, $yr);
        endforeach;
        return $arrYears;
	}
}

# Get the constant total working hours
if ( ! function_exists('constWorkHrs'))
{
    function constWorkHrs($break='00:00')
    {
    	$hours = (strtotime('09:00') - strtotime($break)) / 3600;
    	return sprintf('%02d', floor($hours)).':00';
	}
}

// # fix monday start
// if ( ! function_exists('fixMondayDate'))
// {
//     function fixMondayDate()
//     {
// 		return array('amTimeinTo' => '08:00:00',
// 					 'nnTimeinTo' => '05:00:00',
// 					 'fixMonDate' => '2017-09-01');
// 	}
// }

# hour before ot
if ( ! function_exists('hrintbeforeOT'))
{
    function hrintbeforeOT()
    {
    	return '01:00';
	}
}

if ( ! function_exists('strdate'))
{
    function strdate($time, $mer=0)
    {
    	if($mer==1):
    		return date('H:i:s a', strtotime($time));
    	else:
			return date('H:i:s', strtotime($time));
		endif;
	}
}

if ( ! function_exists('fixTime'))
{
    function fixTime($time, $med)
    {
		return date('G:i:s', strtotime($time.' '.$med));
	}
}

# restdays
if ( ! function_exists('restdays'))
{
    function restdays()
    {
		return array('Saturday', 'Sunday');
	}
}

# restdays
if ( ! function_exists('longeAppt'))
{
    function longeAppt()
    {
        return 'P';
    }
}

# salary periods
if ( ! function_exists('salaryPeriod'))
{
    function salaryPeriod()
    {
        return array('Monthly','Semimonthly','Weekly','Daily');
    }
}

# salary periods
if ( ! function_exists('setPeriods'))
{
    function setPeriods($strPeriod)
    {
        if(strtolower($strPeriod) == 'monthly'):
            return array('Period 1', 'Period 2');

        elseif(strtolower($strPeriod) == 'semimonthly'):
            return array('Period 1', 'Period 2');

        elseif(strtolower($strPeriod) == 'weekly'):
            return array('Period 1', 'Period 2','Period 3','Period 4');

        elseif(strtolower($strPeriod) == 'daily'):
            return array('Period 1', 'Period 2');
        endif;

    }
}

# userlevel
if ( ! function_exists('userlevel'))
{
    function userlevel($level='')
    {
        $arruserlevel = array(
                array('id' => 1, 'desc' => 'hr'),
                array('id' => 2, 'desc' => 'finance'),
                array('id' => 3, 'desc' => 'officer'),
                array('id' => 4, 'desc' => 'executive'),
                array('id' => 5, 'desc' => 'employee'));

        if($level!=''):
            $key = array_search($level, array_column($arruserlevel, 'id'));
            return $arruserlevel[$key]['desc'];
        else:
            return $arruserlevel;
        endif;

    }
}

# HR Permissions
if ( ! function_exists('hrPermission'))
{
    function hrPermission($permission_id,$desc=0)
    {
        $arrpermissions = array(
                array('id' => 1, 'desc' => 'Notification'),
                array('id' => 2, 'desc' => '201 Section'),
                array('id' => 3, 'desc' => 'Attendance'),
                array('id' => 4, 'desc' => 'Reports'),
                array('id' => 5, 'desc' => 'Libraries'),
                array('id' => 6, 'desc' => 'Compensation'));

        $arruser_permissions = array();

        for($l=1;$l<=strlen($permission_id);$l++):
            $key = array_search($l, array_column($arrpermissions, 'id'));
            array_push($arruser_permissions, $arrpermissions[$key]['desc']);
        endfor;

        if($desc):
            if($permission_id == -1):
                return 'HR Officer (Access All sections)';
            else:
                $key = array_search($permission_id, array_column($arrpermissions, 'id'));
                return $arrpermissions[$key]['desc'];
            endif;
        else:
            if(strlen($permission_id) == count($arrpermissions) || $permission_id == -1):
                return array('HR Officer (Access All sections)');
            else:
                return $arruser_permissions;
            endif;
        endif;

    }
}

# Finance Permissions
if ( ! function_exists('financePermission'))
{
    function financePermission($permission_id,$desc=0)
    {
        $arrpermissions = array(
                array('id' => 0, 'desc' => 'Notification'),
                array('id' => 1, 'desc' => 'Compensation'),
                array('id' => 2, 'desc' => 'Update'),
                array('id' => 3, 'desc' => 'Reports'),
                array('id' => 4, 'desc' => 'Library'));

        $arruser_permissions = array();

        for($l=1;$l<=strlen($permission_id);$l++):
            $key = array_search($l, array_column($arrpermissions, 'id'));
            array_push($arruser_permissions, $arrpermissions[$key]['desc']);
        endfor;

        if($desc):
            if($permission_id == -1):
                return 'Finance Officer (Access All sections)';
            else:
                $key = array_search($permission_id, array_column($arrpermissions, 'id'));
                return $arrpermissions[$key]['desc'];
            endif;
        else:
            if(strlen($permission_id) == count($arrpermissions) || $permission_id == -1):
                return array('Finance Officer (Access All sections)');
            else:
                return $arruser_permissions;
            endif;
        endif;

    }
}


# salary periods
if ( ! function_exists('salary_period'))
{
    function salary_period()
    {
        return array('Day','Hour','Month','Quarter','Year');
    }
}

# Government Branch
if ( ! function_exists('gov_branches'))
{
    function gov_branches($branch='')
    {
        $branches = array('Govt Corp' => 'Government Owned and Controlled Corporation',
                          'National' => 'National Government Agencies',
                          'GFI' => 'Government Financial Institution');

        if($branch!=''):
            return $branches[$branch];
        else:
            return $branches;
        endif;

    }
}

# Type of LD
if ( ! function_exists('ld_type'))
{
    function ld_type()
    {
        return array('Administrative','Managerial','Supervisory','Technical');
    }
}

# Notification
function getDestination($desti)
{
    $desti = explode(';', $desti);
    if(count($desti) > 1):
        $empdesti = employee_name($desti[2]);
        switch ($desti[0]):
            case 'RECOMMENDED':
                return 'for Recommendation by '.$empdesti;
                break;
            case 'APPROVED':
                return 'for Approval by '.$empdesti;
                break;
            case 'CERTIFIED':
                return 'for Certification by '.$empdesti;
                break;
            default:
                return '';
                break;
        endswitch;
    endif;
}