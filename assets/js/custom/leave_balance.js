$(document).ready(function() {
	$('.loading-image').hide();
	$('#div-body').show();

    $('td#tdn-or').show();
    $('td#tdor').hide();

    $('button#btnupdate_lb').on('click', function(e){
        if($('#txt_isoverride').val() == 'override') {
            var total_error = 0;

            total_error = total_error + check_str($('#txtauwp_vl')) + check_str($('#txtauwp_sl')) + check_str($('#txtperiod_vl')) + check_str($('#txtperiod_sl')) + check_str($('#txtauwop_vl')) + check_str($('#txtauwop_sl'));
            total_error = total_error + check_str($('#txtspe_curr')) + check_str($('#txtfl_curr')) + check_str($('#txtsdl_curr')) + check_str($('#txtmtl_curr')) + check_str($('#txtptl_curr'));
            total_error = total_error + check_str($('#txtlaundry')) + check_str($('#txtsubs_8hrs')) + check_str($('#txtsubs_6hrs')) + check_str($('#txtsubs_5hrs')) + check_str($('#txtsubs_4hrs')) + check_str($('#txtwith_meal')) + check_str($('#txtamt_training'));
            total_error = total_error + check_str($('#txtlate_ut_days')) + check_str($('#txtdays_awol')) + check_str($('#txtdays_present')) + check_str($('#txtdays_absent'));
            total_error = total_error + check_time($('#txtlate_ut_hhmm'))  + check_time($('#txtbalance')) + check_time($('#txtgain')) + check_time($('#txtused'));

            if(total_error > 0){
                e.preventDefault();
            }
        }
    });

    $('#tblleave-balance').on('click','#btn-leavebal,#btn-leavebal-override', function(e){
        $('#txt_isoverride').val('override');
        $('td#tdn-or,button#btnupdate_lb').show();
        $('td#tdor').hide(); 

        var action = $(this).data('action');
        var lb_data = $(this).data('json');
        var leave_earned = $(this).data('leave_earned');
        
        $('#updatedby').html(lb_data['process_by']+'  &nbsp;&nbsp;<b>Updated Date: </b>'+(lb_data['processDate']!=null?lb_data['processDate']:''));
        if(action == 'override'){
            $('td#tdn-or').hide();
            $('td#tdor').show();
        }else{
            $('button#btnupdate_lb').hide();
        }

        $('#txtprev_month').html('<b>'+ number_to_month(lb_data['periodMonth'],1) + ' ' + lb_data['periodYear']);

        /* Previous Month Balance */
        $('.prev_vl').html(lb_data['vlPreBalance']);
        $('.prev_sl').html(lb_data['slPreBalance']);
        /* Earned for the month */
        $('.earned_vl').html(leave_earned);
        $('.earned_sl').html(leave_earned);
        /* Abs. Und. W/ Pay */
        $('.auwp_vl').html(lb_data['vlAbsUndWPay']);
        $('.auwp_sl').html(lb_data['slAbsUndWPay']);
        $('#txtauwp_vl').val(lb_data['vlAbsUndWPay']);
        $('#txtauwp_sl').val(lb_data['slAbsUndWPay']);
        /* Month Year Balance */
        $('.period_date_bal').html('<b>'+ number_to_month(lb_data['periodMonth']) + ' ' + lb_data['periodYear'] + '</b> Balance');
        $('.period_vl').html(lb_data['vlBalance']);
        $('.period_sl').html(lb_data['slBalance']);
        $('#txtperiod_vl').val(lb_data['vlBalance']);
        $('#txtperiod_sl').val(lb_data['slBalance']);
        /* Abs. Und. W/o Pay */
        $('.auwop_vl').html(lb_data['vlAbsUndWoPay']);
        $('.auwop_sl').html(lb_data['slAbsUndWoPay']);
        $('#txtauwop_vl').val(lb_data['vlAbsUndWoPay']);
        $('#txtauwop_sl').val(lb_data['slAbsUndWoPay']);
        /* Leave Type */
        /* Special Leave */
        $('.spe_prev').html(lb_data['plPreBalance']);
        $('.spe_filed').html(lb_data['filed_spl']);
        $('.spe_curr').html(lb_data['plBalance']);
        $('#txtspe_curr').val(lb_data['plBalance']);
        /* Force Leave */
        $('.fl_prev').html(lb_data['flPreBalance']);
        $('.fl_filed').html(lb_data['filed_fl']);
        $('.fl_curr').html(lb_data['flBalance']);
        $('#txtfl_curr').val(lb_data['flBalance']);
        /* Study Leave */
        $('.sdl_prev').html(lb_data['stlPreBalance']);
        $('.sdl_filed').html(lb_data['filed_stl']);
        $('.sdl_curr').html(lb_data['stlBalance']);
        $('#txtsdl_curr').val(lb_data['stlBalance']);
        /* Paternity Leave */
        $('.ptl_prev').html(lb_data['ptlPreBalance']);
        $('.ptl_filed').html(lb_data['filed_ptl']);
        $('.ptl_curr').html(lb_data['ptlBalance']);
        $('#txtptl_curr').val(lb_data['ptlBalance']);
        /* Maternity Leave */
        $('.mtl_prev').html(lb_data['mtlPreBalance']);
        $('.mtl_filed').html(lb_data['filed_mtl']);
        $('.mtl_curr').html(lb_data['mtlBalance']);
        $('#txtmtl_curr').val(lb_data['mtlBalance']);

        /* COC */
        $('.coc_balance').html(lb_data['off_bal_w']);
        $('#txtbalance').val(mins_to_time(lb_data['off_bal']));
        $('.coc_gain').html(lb_data['off_gain_w']);
        $('#txtgain').val(mins_to_time(lb_data['off_gain']));
        $('.coc_used').html(lb_data['off_used_w']);
        $('#txtused').val(mins_to_time(lb_data['off_used']));

        /* Attendance Summary */
        $('.late_ut_days').html(lb_data['trut_notimes']);
        $('.late_ut_hhmm').html(lb_data['trut_totalminutes']);
        $('.days_awol').html(lb_data['nodays_awol']);
        $('.days_present').html(lb_data['nodays_present']);
        $('.days_absent').html(lb_data['nodays_absent']);
        $('#txtlate_ut_days').val(lb_data['trut_notimes']);
        $('#txtlate_ut_hhmm').val(lb_data['trut_totalminutes']);
        $('#txtdays_awol').val(lb_data['nodays_awol']);
        $('#txtdays_present').val(lb_data['nodays_present']);
        $('#txtdays_absent').val(lb_data['nodays_absent']);

        /* MC Benefits */
        $('#txtlaundry').val(lb_data['ctr_laundry']);
        $('#txtsubs_8hrs').val(lb_data['ctr_8h']);
        $('#txtsubs_6hrs').val(lb_data['ctr_6h']);
        $('#txtsubs_5hrs').val(lb_data['ctr_5h']);
        $('#txtsubs_4hrs').val(lb_data['ctr_4h']);
        $('#txtwith_meal').val(lb_data['ctr_wmeal']);
        $('#txtamt_training').val(lb_data['ctr_diem']);
        $('.laundry').html(lb_data['ctr_laundry']);
        $('.subs_8hrs').html(lb_data['ctr_8h']);
        $('.subs_6hrs').html(lb_data['ctr_6h']);
        $('.subs_5hrs').html(lb_data['ctr_5h']);
        $('.subs_4hrs').html(lb_data['ctr_4h']);
        $('.with_meal').html(lb_data['ctr_wmeal']);
        $('.amt_training').html(lb_data['ctr_diem']);

        $('#txtoverride_id').val(lb_data['lb_id']);
        $('#txtleave_data').val(JSON.stringify([lb_data,leave_earned]));

        $('#frmupdate_leavebalance').attr('action','../leave_balance_override/'+$('#txtget_data').val());
        $('#modal-view-leave-balance').modal('show');

    });

    $('#btn-update-leavebal').click(function(e) {
        $('#txt_isoverride').val('update');
        $('td#tdn-or').show();
        $('td#tdor').hide();

        // var lb_data = $(this).data('json');
        var leave_earned = $(this).data('leave_earned');
        var latest_lb = $(this).data('latest_lb');
        var att_summ = $(this).data('att_summ');
        var mon_yr = check_year(latest_lb['lb']['periodMonth'],latest_lb['lb']['periodYear']);
        
        $('#txtprev_month').html('<b>'+ number_to_month(mon_yr[0],1) + ' ' + mon_yr[1]);
        $('#updatedby').html(latest_lb['lb_updatedby']+'  &nbsp;&nbsp;<b>Updated Date: </b>'+(latest_lb['process_date']!=null?latest_lb['process_date']:''));
        /* Previous Month Balance */
        $('.prev_vl').html(latest_lb['lb']['vlBalance']);
        $('.prev_sl').html(latest_lb['lb']['slBalance']);
        $('#txtprev_vlbal').val(latest_lb['lb']['vlBalance']);
        $('#txtprev_slbal').val(latest_lb['lb']['slBalance']);
        /* Earned for the month */
        $('.earned_vl').html(leave_earned);
        $('.earned_sl').html(leave_earned);
        /* Abs. Und. W/ Pay */
        $('.auwp_vl').html(latest_lb['vl_abswpay']);
        $('.auwp_sl').html(latest_lb['filed_sl']);
        $('#txtauwp_vl').val(latest_lb['vl_abswpay']);
        $('#txtauwp_sl').val(latest_lb['filed_sl']);
        /* Month Year Balance */
        $('.period_date_bal').html('<b>'+ number_to_month(mon_yr[0]) + ' ' + mon_yr[1] + '</b> Balance');
        $('.period_vl').html(latest_lb['curr_vl']);
        $('.period_sl').html(latest_lb['curr_sl']);
        $('#txtperiod_vl').val(latest_lb['curr_vl']);
        $('#txtperiod_sl').val(latest_lb['curr_sl']);
        /* Abs. Und. W/o Pay */
        $('.auwop_vl').html(latest_lb['vl_abswopay']);
        $('.auwop_sl').html(latest_lb['sl_abswopay']);
        $('#txtauwop_vl').val(latest_lb['vl_abswopay']);
        $('#txtauwop_sl').val(latest_lb['sl_abswopay']);
        /* Leave Type */
        /* Special Leave */
        $('.spe_prev').html(latest_lb['lb']['plBalance']);
        $('.spe_filed').html(latest_lb['filed_spl']);
        $('.spe_curr').html(parseFloat(latest_lb['lb']['plBalance']) - parseFloat(latest_lb['filed_spl']));
        $('#txtspe_curr').val(parseFloat(latest_lb['lb']['plBalance']) - parseFloat(latest_lb['filed_spl']));
        /* Force Leave */
        $('.fl_prev').html(latest_lb['lb']['flBalance']);
        $('.fl_filed').html(latest_lb['filed_fl']);
        $('.fl_curr').html(parseFloat(latest_lb['lb']['flBalance']) - parseFloat(latest_lb['filed_fl']));
        $('#txtfl_curr').val(parseFloat(latest_lb['lb']['flBalance']) - parseFloat(latest_lb['filed_fl']));
        /* Study Leave */
        $('.sdl_prev').html(latest_lb['lb']['stlBalance']);
        $('.sdl_filed').html(latest_lb['filed_stl']);
        $('.sdl_curr').html(parseFloat(latest_lb['lb']['stlBalance']) - parseFloat(latest_lb['filed_stl']));
        $('#txtsdl_curr').val(parseFloat(latest_lb['lb']['stlBalance']) - parseFloat(latest_lb['filed_stl']));
        /* Paternity Leave */
        $('.ptl_prev').html(latest_lb['lb']['ptlBalance']);
        $('.ptl_filed').html(latest_lb['filed_ptl']);
        $('.ptl_curr').html(parseFloat(latest_lb['lb']['ptlBalance']) - parseFloat(latest_lb['filed_ptl']));
        $('#txtptl_curr').val(parseFloat(latest_lb['lb']['ptlBalance']) - parseFloat(latest_lb['filed_ptl']));
        /* Maternity Leave */
        $('.mtl_prev').html(latest_lb['lb']['mtlBalance']);
        $('.mtl_filed').html(latest_lb['filed_mtl']);
        $('.mtl_curr').html(parseFloat(latest_lb['lb']['mtlBalance']) - parseFloat(latest_lb['filed_mtl']));
        $('#txtmtl_curr').val(parseFloat(latest_lb['lb']['mtlBalance']) - parseFloat(latest_lb['filed_mtl']));
        /* COC */
        $('.coc_balance').html(latest_lb['off_bal']);
        $('#txtbalance').val(latest_lb['off_bal']);
        $('.coc_gain').html(att_summ['off_gain']);
        $('#txtgain').val(att_summ['off_gain']);
        $('.coc_used').html(att_summ['total_hrs_cto']);
        $('#txtused').val(att_summ['total_hrs_cto']);

        /* Attendance Summary */
        $('.late_ut_days').html(att_summ['dates_ut_lates']);
        $('.late_ut_hhmm').html(att_summ['total_late_ut']);
        $('.days_awol').html(att_summ['days_awol']);
        $('.days_present').html(att_summ['working_days'] - (att_summ['days_awol'] + att_summ['days_leave']));
        $('.days_absent').html(att_summ['days_awol'] + att_summ['days_leave']);
        $('#txtlate_ut_days').val(att_summ['dates_ut_lates']);
        $('#txtlate_ut_hhmm').val(att_summ['total_late_ut']);
        $('#txtdays_awol').val(att_summ['days_awol']);
        $('#txtdays_present').val(att_summ['working_days'] - (att_summ['days_awol'] + att_summ['days_leave']));
        $('#txtdays_absent').val(att_summ['days_awol'] + att_summ['days_leave']);

        /* MC Benefits */
        $('.laundry').html(att_summ['days_awol'] + att_summ['days_leave']);
        $('.subs_8hrs').html(latest_lb['arr_subs_allowance']['ctr_8h']);
        $('.subs_6hrs').html(latest_lb['arr_subs_allowance']['ctr_6h']);
        $('.subs_5hrs').html(latest_lb['arr_subs_allowance']['ctr_5h']);
        $('.subs_4hrs').html(latest_lb['arr_subs_allowance']['ctr_4h']);
        $('.with_meal').html(att_summ['total_wmeal']);
        $('.amt_training').html(att_summ['total_perdiem']);
        $('#txtlaundry').val(att_summ['days_awol'] + att_summ['days_leave']);
        $('#txtsubs_8hrs').val(latest_lb['arr_subs_allowance']['ctr_8h']);
        $('#txtsubs_6hrs').val(latest_lb['arr_subs_allowance']['ctr_6h']);
        $('#txtsubs_5hrs').val(latest_lb['arr_subs_allowance']['ctr_5h']);
        $('#txtsubs_4hrs').val(latest_lb['arr_subs_allowance']['ctr_4h']);
        $('#txtwith_meal').val(att_summ['total_wmeal']);
        $('#txtamt_training').val(att_summ['total_perdiem']);
        $('#txtperiodMonth').val(mon_yr[0]);
        $('#txtperiodYr').val(mon_yr[1]);
        $('#frmupdate_leavebalance').attr('action',$('#frmupdate_leavebalance').attr('action')+'hr/attendance/leave_balance_save/'+$('#txtget_data').val());

        $('#modal-view-leave-balance').modal('show');
    });
    
    /* validation in set starting balance*/
    $('#vl_start').on('keyup keypress change', function() {
        check_str('#vl_start');
    });
    $('#vl_ut_wpay').on('keyup keypress change', function() {
        check_str('#vl_ut_wpay');
    });
    $('#vl_ut_wopay').on('keyup keypress change', function() {
        check_str('#vl_ut_wopay');
    });

    $('#sl_start').on('keyup keypress change', function() {
        check_str('#sl_start');
    });
    $('#sl_ut_wpay').on('keyup keypress change', function() {
        check_str('#sl_ut_wpay');
    });
    $('#sl_ut_wopay').on('keyup keypress change', function() {
        check_str('#sl_ut_wopay');
    });

    $('#off_bal').on('keyup keypress change', function() {
        check_str('#off_bal');
    });
    $('#fl_bal').on('keyup keypress change', function() {
        check_str('#fl_bal');
    });
    $('#pl_bal').on('keyup keypress change', function() {
        check_str('#pl_bal');
    });

    $('#btn-set-balance').click(function(e) {
        var total_error = 0;

        total_error = total_error + check_str($('#vl_start'));
        total_error = total_error + check_str($('#vl_ut_wpay'));
        total_error = total_error + check_str($('#vl_ut_wopay'));

        total_error = total_error + check_str($('#sl_start'));
        total_error = total_error + check_str($('#sl_ut_wpay'));
        total_error = total_error + check_str($('#sl_ut_wopay'));

        total_error = total_error + check_str($('#off_bal'));
        total_error = total_error + check_str($('#fl_bal'));
        total_error = total_error + check_str($('#pl_bal'));

        if(total_error > 0){
            e.preventDefault();
        }
    });

});