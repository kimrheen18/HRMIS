function numberformat(num) {
    num = parseFloat(Math.round(num * 100) / 100).toFixed(2);
    var parts = num.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if(parts.length == 1){
        parts[1] = "00";
    }
    return parts.join(".");
}
$(document).ready(function() {
	$('.loading-image').hide();
	$('#div-body').show();
    // $('.i-required').hide();

    // /* BEGIN PROCESSS 1 */
    // $('button#btn_step1').on('click', function(e) {
    //     var step2 = 0;
    //     if(validate_bsselect($('select#selemployment'))){
    //         step2 = 1;
    //     }else{
    //         if($('select#selemployment').val() == 'P'){
    //             if(validate_bsselect($('select#data_fr_mon')) && validate_bsselect($('select#data_fr_yr'))){
    //                 step2 = 1;
    //             }else{
    //                 step2 = 0;
    //             }
    //         }else{
    //             if(validate_text($('#txt_dtfrom')) && validate_text($('#txt_dtto'))){
    //                 step2 = 1;
    //             }else{
    //                 step2 = 0;
    //             }
    //         }
    //     }

    //     if(step2){
    //         e.preventDefault();
    //     }else{
    //         $('.loading-fade').show();
    //     }
    // });

    // $('.div-date').hide();
    // $('select#selemployment').on('changed.bs.select', function (e) {
    //     var employment = e.target.value;
    //     if(employment != 'P'){
    //         $('#frmprocess').attr('action', 'compute_benefits');

    //         $('.div-datause').hide();
    //         $('.div-date').show();
    //     }else{
    //         $('#frmprocess').attr('action', 'select_benefits');

    //         $('.div-datause').show();
    //         $('.div-date').hide();
    //     }
    // });

    // $('select#selmon').on('changed.bs.select', function (e) {
    //     var selmonth = e.target.value;
    //     var selyr = $('select#selyr').val();
    //     if(selmonth == 1){
    //         selmonth = 13;
    //         $('select#data_fr_yr').selectpicker('val',(selyr-1));
    //     }else{
    //         $('select#data_fr_yr').selectpicker('val',(selyr));
    //     }
    //     $('select#data_fr_mon').selectpicker('val',(selmonth-1));
    // });

    // $('.date-picker').datepicker({autoclose: true});
    // /* END PROCESSS 1 */

    // begin manage check boxes
    $('div.col-md-3').on('click', 'label.checkbox', function() {
    	var checker = $(this).find('div.checker > span');
    	if(checker.attr('class') == ''){
    		checker.addClass('checked');
    		return false;
    	}else{
    		checker.removeClass('checked');
    		return false;
    	}
    });

    // $('#chkall-benefit').click(function() {
    // 	if($(this).prop('checked')){
    // 		$('div#div-benefit > div.col-md-3 > label.checkbox').find('div.checker > span').addClass('checked');
    // 	}else{
    // 		$('div#div-benefit > div.col-md-3 > label.checkbox').find('div.checker > span').removeClass('checked');
    // 	}
    // });

    $('#chkall-bonus').click(function() {
    	if($(this).prop('checked')){
    		$('div#div-bonus > div.col-md-3 > label.checkbox').find('div.checker > span').addClass('checked');
    	}else{
    		$('div#div-bonus > div.col-md-3 > label.checkbox').find('div.checker > span').removeClass('checked');
    	}
    });

    $('#chkall-income').click(function() {
    	if($(this).prop('checked')){
    		$('div#div-income > div.col-md-3 > label.checkbox').find('div.checker > span').addClass('checked');
    	}else{
    		$('div#div-income > div.col-md-3 > label.checkbox').find('div.checker > span').removeClass('checked');
    	}
    });

    $('#chkall-loan').click(function() {
    	if($(this).prop('checked')){
    		$('div#div-loan > div.portlet > div.portlet-body').find('div.col-md-6 > label.checkbox > div.checker > span').addClass('checked');
    	}else{
    		$('div#div-loan > div.portlet > div.portlet-body').find('div.col-md-6 > label.checkbox > div.checker > span').removeClass('checked');
    	}
    });

    $('#chkall-cont').click(function() {
    	if($(this).prop('checked')){
    		$('div#div-cont > div.portlet > div.portlet-body').find('div.col-md-6 > label.checkbox > div.checker > span').addClass('checked');
    	}else{
    		$('div#div-cont > div.portlet > div.portlet-body').find('div.col-md-6 > label.checkbox > div.checker > span').removeClass('checked');
    	}
    });

    $('#chkall-othr').click(function() {
    	if($(this).prop('checked')){
    		$('div#div-othr > div.portlet > div.portlet-body').find('div.col-md-6 > label.checkbox > div.checker > span').addClass('checked');
    	}else{
    		$('div#div-othr > div.portlet > div.portlet-body').find('div.col-md-6 > label.checkbox > div.checker > span').removeClass('checked');
    	}
    });


    $('div.col-md-6').on('click', 'label.checkbox', function() {
    	var checker = $(this).find('div.checker > span');
    	if(checker.attr('class') == ''){
    		checker.addClass('checked');
    		return false;
    	}else{
    		checker.removeClass('checked');
    		return false;
    	}
    });

    // button compute benefit
    $('#btn-computeBenefit').click(function(e) {
        $('#tblPayrollProcess').DataTable().destroy();
        $('#tblPayrollProcess >tbody').hide();
        $('#tblPayrollProcess > tbody').empty();
        
        $.ajax ({type : 'GET', url: "Payrollupdate/getListofEmployee",
                data: {'selemployment': $('#selemployment').val(), 'selmon': $('#selmon').val(), 'selyr': $('#selyr').val()}, dataType: 'json',
                success: function(res){
                    $('#spnappt').html(res['appt']);
                    var data = res['arrEmployees'];
                    var table = $('#tblPayrollProcess').DataTable({"scrollX": true});
                    if(data!='') {
                        $.each(data, function(i, item) {
                            console.log(item);
                            mid = item['middleInitial'] != '' && item['middleInitial'] != null ? item['middleInitial'] : '';
                            mid_ini = mid!='' || mid!=null ? mid.replace('.', '') : item['middlename'][0];
                            mid_ini = mid_ini!='' ? mid_ini+'.' : '';
                            fullname = item['surname']+', '+item['firstname']+' '+mid_ini;
                            table.row.add([ fullname,
                                            numberformat(item['salary']),
                                            item['workingDays'],
                                            item['nodaysPresent'],
                                            item['nodaysAbsent'],
                                            item['hazardCode'],
                                            item['hpFactor'],
                                            numberformat(item['hazard']),
                                            item['ctr_8h'],
                                            item['ctr_6h'],
                                            item['ctr_5h'],
                                            item['ctr_4h'],
                                            numberformat(item['ctr_diem']),
                                            item['subsisCode'],
                                            numberformat(item['subsistence']),
                                            item['laundryCode'],
                                            item['ctr_laundry'],
                                            numberformat(item['laundry']),
                                            numberformat(item['longi']),
                                            item['taPercent'],
                                            numberformat(item['ta']),
                                            numberformat(item['hazard']+item['subsistence']+item['laundry']+item['longi']+item['ra']+item['ta'])]);
                        });
                        table.draw();
                        $('#tblPayrollProcess >tbody').show();
                    }else{
                        table.row.add(['No Data Available','','','','','','','','','','','','','','','','','','','','','']);
                        table.draw();
                        $('td:eq(0)').attr('colspan', 23).attr('align', 'center');
                        for (i = 1; i < 23; i++) { $('td:eq('+i+')').hide();}
                    }
                }
            });
    });
    // end manage check boxes


});