<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# HP Factor
if ( ! function_exists('hpfactor'))
{
    function hpfactor($days, $factor)
    {
        $amount = 0;

        if($days >=15 && $factor == 30):
            $amount = 0.30;
        elseif($days >= 15 && $factor == 23):
            $amount = 0.23;
        elseif($days >=15 && $factor == 15):
            $amount = 0.15;
        elseif($days >=15 && $factor == 12):
            $amount = 0.12;
        elseif(($days >=8 && $days <=14) && $factor ==30):
            $amount = 0.23;
        elseif(($days >=8 && $days <=14) && $factor ==23):
            $amount = 0.15;
        elseif(($days >=8 && $days <=14) && $factor ==15):
            $amount = 0.12;
        elseif($days < 8 && $factor ==30):
            $amount = 0.15;
        elseif($days < 8 && $factor ==15):
            $amount = 0.10;
        else:
            $amount = 0.00;
        endif;

        return $amount;
	}
}

# Tax Amount for Non Perm
function amt_tax_nonperm($amount)
{
    $tax_amt = 0;

    if($amount < 10417):
        $tax_amt = 0;
    elseif($amount >= 10417 && $amount < 16667):
        $tax_amt = ($amount - 10417) * 0.2;
    elseif($amount >= 16667 && $amount < 33333):
        $tax_amt = ($amount - 16667) * 0.25 + 1250;
    elseif($amount >= 33333 && $amount < 83333):
        $tax_amt = ($amount - 33333) * 0.3 + 5416.67;
    elseif($amount >= 83333 && $amount < 333333):
        $tax_amt = ($amount - 83333) * 0.32 + 20416.67;
    elseif($amount >= 333333):
        $tax_amt = ($amount - 333333) * 0.35 + 100416.67;
    else:
        $tax_amt = 0;
    endif;

    return $tax_amt;
}

# substistence
if ( ! function_exists('substistence'))
{
    function substistence($wdays_period, $wdays_process, $lb)
    {
        $subs = $wdays_period - $wdays_process;
        $subs = $subs * AMT_SUBSISTENCE;

        $ctr_8h = AMT_CTR_8H * $lb['ctr_8h'];
        $ctr_6h = AMT_CTR_6H * $lb['ctr_6h'];
        $ctr_5h = AMT_CTR_5H * $lb['ctr_5h'];
        $ctr_4h = AMT_CTR_4H * $lb['ctr_4h'];

        $total_subs = ($ctr_8h + $ctr_6h + $ctr_5h + $ctr_4h) - $lb['ctr_diem'] + $subs;
        return $total_subs >= 0 ? $total_subs : 0;
    }
}

# Laundry
if ( ! function_exists('laundry'))
{
    function laundry($ctr_laundry)
    {
        $laundry = $ctr_laundry < 0 ? 0 : $ctr_laundry;
        $laundry = AMT_LAUNDRY - (AMT_CTR_LAUNDRY * $ctr_laundry);

        return $laundry < 0 ? 0 : $laundry;
    }
}

# Rata
if ( ! function_exists('rata'))
{
    function rata($arrrata, $days, $curr_workingdays, $emprata, $emprata_vehicle)
    {
        $arrrata = array_column($arrrata,'RATAAmount','RATACode');
        $emprata = $emprata == '' ? 0 : $arrrata[$emprata];
        
        # RA
        $ra_amount = 0;
        $ra_percent = 0;
        if($emprata > 0):
            if($days >= 1 && $days <= 5):
                $ra_amount = 0.25;
            elseif($days >= 6 && $days <= 11):
                $ra_amount = 0.50;
            elseif($days >= 12 && $days <= 16):
                $ra_amount = 0.75;
            elseif($days >= 17):
                $ra_amount = 1.00;
            else:
                $ra_amount = 0;
            endif;
        endif;
        $ra_percent = $ra_amount * RATA_PERCENT;
        $total_ra = $emprata * $ra_amount;

        # TA
        $days_w_vehicle = 0;
        $ta_percent = 0;
        $ta_amount = 0;
        if($emprata > 0):
            if($emprata_vehicle == 'Y'):
                $ta_amount = 0;
                $ta_percent = 0;
                $days_w_vehicle = $curr_workingdays;
            else:
                $ta_amount = $emprata;
                $ta_percent = RATA_PERCENT;
                $days_w_vehicle = 0;
            endif;
        endif;

        return array('ra_amount' => $total_ra, 'ra_percent' => $ra_percent, 'ta_amount' => $ta_amount, 'ta_percent' => $ta_percent, 'days_w_vehicle' => $days_w_vehicle);

    }
}

if ( ! function_exists('payroll_group'))
{
    function payroll_group($process_code)
    {
        $CI =& get_instance();
        $CI->db->or_like('processWith', $process_code, 'before', false);
        $CI->db->or_like('processWith', $process_code, 'after', false);
        $CI->db->or_like('processWith', $process_code, 'both', false);
        $CI->db->or_where('processWith',$process_code);
        $res = $CI->db->get('tblPayrollProcess')->result_array();
        
        return count($res) > 0 ? $res[0]['computation'] : '';
    }
}

if ( ! function_exists('process_with'))
{
    function process_with($appt)
    {
        $CI =& get_instance();
        $res = $CI->db->get_where('tblPayrollProcess',array('appointmentCode' => $appt))->result_array();
        
        return count($res) > 0 ? explode(',',$res[0]['processWith']) : array();
    }
}

if ( ! function_exists('agency_payroll_process'))
{
    function agency_payroll_process()
    {
        $CI =& get_instance();
        $res = $CI->db->get('tblAgency')->result_array();
        
        return count($res) > 0 ? $res[0]['salarySchedule'] : '';
    }
}

if ( ! function_exists('salary_schedule_ctr'))
{
    function salary_schedule_ctr($sched,$ps_period=0,$period=0)
    {
        $period_name = '';
        $period_no = 0;

        switch ($sched):
         case 'Bi-Monthly':
             $period_name = $ps_period == 1 ? 'period1' : 'period2';
             $period_no = 2;
             break;
         case 'Weekly':
             $period_name = $ps_period == 1 ? 'period1' : $ps_period == 2 ? 'period2' : $ps_period == 3 ? 'period3' : 'period4';
             $period_no = 4;
             break;
         case 'Monthly':
             $period_name = 'period1';
             $period_no = 1;
             break;
        endswitch;

        if($period == 1):
            return $period_no;
        else:
            return $period_name;
        endif;
    }
}

if ( ! function_exists('payroll_date'))
{
    function payroll_date($sched,$period=0)
    {
        $payroll_date = '';

        switch ($sched):
         case 'Bi-Monthly':
             $payroll_date = $period == 1 ? '1 - 15' : '16 - '.cal_days_in_month(CAL_GREGORIAN,currmo(),curryr());
             break;
         case 'Weekly':
             $payroll_date = $period == 1 ? '1st Week' : $period == 2 ? '2nd Week' : $period == 3 ? '3rd Week' : '4th Week' ;
             break;
         case 'Monthly':
             $payroll_date = '1 - '.cal_days_in_month(CAL_GREGORIAN,currmo(),curryr());
             break;
        endswitch;
        
        return $payroll_date;
    }
}

if ( ! function_exists('compute_subsistence_allowance'))
{
    function compute_subsistence_allowance($arr_work_hrs)
    {
        $ctr_8h = 0;
        $ctr_6h = 0;
        $ctr_5h = 0;
        $ctr_4h = 0;

        foreach($arr_work_hrs as $whrs):
            
            if($whrs >= 480):
                $ctr_8h = $ctr_8h + 1;
            elseif($whrs >= 360 && $whrs < 480):
                $ctr_6h = $ctr_6h + 1;
            elseif($whrs >= 300 && $whrs < 360):
                $ctr_5h = $ctr_5h + 1;
            elseif($whrs >= 240 && $whrs < 300):
                $ctr_4h = $ctr_4h + 1;
            endif;

        endforeach;

        return array('ctr_8h' => $ctr_8h,'ctr_6h' => $ctr_6h,'ctr_5h' => $ctr_5h,'ctr_4h' => $ctr_4h);

    }
}


