function check_income_amount(el_a,el_b,el_c,el_d,el_e)
{
	var total_error = 0;
	total_error = total_error + check_number(el_a);
	total_error = total_error + check_number(el_b);
	total_error = total_error + check_number(el_c);
	total_error = total_error + check_number(el_d);
	total_error = total_error + check_number(el_e);

	if(total_error < 1)
	{
		totalamt = parseFloat($(el_a).val().replace(/[^\d\.]/g, ""));
		period1 = parseFloat($(el_b).val().replace(/[^\d\.]/g, ""));
		period2 = parseFloat($(el_c).val().replace(/[^\d\.]/g, ""));
		period3 = parseFloat($(el_d).val().replace(/[^\d\.]/g, ""));
		period4 = parseFloat($(el_e).val().replace(/[^\d\.]/g, ""));

		if(Math.round(totalamt) != Math.round(period1 + period2 + period3 + period4))
		{
			$([el_a,el_b,el_c,el_d,el_e].join()).closest('div.form-group').addClass('has-error');
			$([el_a,el_b,el_c,el_d,el_e].join()).closest('div.form-group').removeClass('has-success');
			$([el_a,el_b,el_c,el_d,el_e].join()).closest('div.form-group').find('i.fa-check').remove();
			$([el_a,el_b,el_c,el_d,el_e].join()).closest('div.form-group').find('i.fa-warning').remove();
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Monthly amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_a));
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Monthly amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_b));
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Monthly amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_c));
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Monthly amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_d));
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Monthly amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_e));
			return 1;
		}else{
		    $([el_a,el_b,el_c,el_d,el_e].join()).closest('div.form-group').removeClass('has-error');
		    $([el_a,el_b,el_c,el_d,el_e].join()).closest('div.form-group').addClass('has-success');
		    $([el_a,el_b,el_c,el_d,el_e].join()).closest('div.form-group').find('i.fa-warning').remove();
		    $([el_a,el_b,el_c,el_d,el_e].join()).closest('div.form-group').find('i.fa-check').remove();
		    $('<i class="fa fa-check tooltips"></i>').insertBefore($(el_a));
		    $('<i class="fa fa-check tooltips"></i>').insertBefore($(el_b));
		    $('<i class="fa fa-check tooltips"></i>').insertBefore($(el_c));
		    $('<i class="fa fa-check tooltips"></i>').insertBefore($(el_d));
		    $('<i class="fa fa-check tooltips"></i>').insertBefore($(el_e));
		    return 0;
		}
	}
}

$(document).ready(function() {
	$('.date-picker').datepicker();
	$('.date-picker').on('changeDate', function(){
	    $(this).datepicker('hide');
	});

	$('#table-mloans').dataTable( {
	    "initComplete": function(settings, json) {
	        $('.loading-image').hide();
	        $('#table-mloans').show();
	    }});

	$('#table-mloans').on('click','tbody > tr > td > a#btnupdatemloans', function() {
	    data = $(this).data('params');
	    $('#loan-title').html(data['deductionCode']);
	    $('#txtid').val(data['deductCode']);
	    $('#txtdateGranted').val(data['dateGranted']);
	    $('#selsdate_mon').val(data.actualStartMonth).selectpicker('refresh');
	    $('#selsdate_yr').val(data.actualStartYear).selectpicker('refresh');
	    $('#seledate_mon').val(data.actualEndMonth).selectpicker('refresh');
	    $('#seledate_yr').val(data.actualEndYear).selectpicker('refresh');
	    $('#txtamtGranted').val(numberformat(data['amountGranted']));
	    $('#txtmonthly').val(numberformat(data['monthly']));
	    $('#txtperiod1').val(numberformat(data['period1']));
	    $('#txtperiod2').val(numberformat(data['period2']));
	    $('#txtperiod3').val(numberformat(data['period3']));
	    $('#txtperiod4').val(numberformat(data['period4']));
	    $('#selstatus').val(data.status).selectpicker('refresh');
	});

	$('#txtdateGranted').on('keyup keypress change',function() {
		check_date('#txtdateGranted','Date Granted must not be empty.');
	});

	$('#selsdate_mon,#selsdate_yr').on('keyup keypress change',function() {
		var sdate_error = 0;
		sdate_error = sdate_error + check_null('#selsdate_mon','Start date must not be empty.');
	    sdate_error = sdate_error + check_null('#selsdate_yr','Start date must not be empty.');
	    if(sdate_error > 0){
	    	$('.div-sdate').addClass('font-red');
	    }else{
	    	$('.div-sdate').removeClass('font-red');
	    }
	});

	$('#seledate_mon,#seledate_yr').on('keyup keypress change',function() {
		var edate_error = 0;
		edate_error = edate_error + check_null('#seledate_mon','Start date must not be empty.');
	    edate_error = edate_error + check_null('#seledate_yr','Start date must not be empty.');
	    if(edate_error > 0){
	    	$('.div-sdate').addClass('font-red');
	    }else{
	    	$('.div-sdate').removeClass('font-red');
	    }
	});

	$('#txtmonthly').on('keyup keypress change',function() {
		check_number('#txtmonthly','Monthly must not be empty.');
	});

	$('#txtamtGranted').on('keyup keypress change',function() {
		check_number('#txtamtGranted','Amount Granted must not be empty.');
	});

	$('#txtperiod1').on('keyup keypress change',function() {
		check_income_amount('#txtmonthly','#txtperiod1','#txtperiod2','#txtperiod3','#txtperiod4');
	});

	$('#txtperiod2').on('keyup keypress change',function() {
		check_income_amount('#txtmonthly','#txtperiod1','#txtperiod2','#txtperiod3','#txtperiod4');
	});

	$('#txtperiod3').on('keyup keypress change',function() {
		check_income_amount('#txtmonthly','#txtperiod1','#txtperiod2','#txtperiod3','#txtperiod4');
	});

	$('#txtperiod4').on('keyup keypress change',function() {
		check_income_amount('#txtmonthly','#txtperiod1','#txtperiod2','#txtperiod3','#txtperiod4');
	});

	$('#selstatus').on('keyup keypress change',function() {
		check_null('#selstatus','Status must not be empty.');
	});

	$('#btnsubmit-matureloans').click(function(e) {
	    var total_error = 0;

	    total_error = total_error + check_date('#txtdateGranted','Date Granted must not be empty.');
	    
	    var sdate_error = 0;
		sdate_error = sdate_error + check_null('#selsdate_mon','Start date must not be empty.');
	    sdate_error = sdate_error + check_null('#selsdate_yr','Start date must not be empty.');
	    if(sdate_error > 0){
	    	$('.div-sdate').addClass('font-red');
	    }else{
	    	$('.div-sdate').removeClass('font-red');
	    }

	    var edate_error = 0;
		edate_error = edate_error + check_null('#seledate_mon','End date must not be empty.');
	    edate_error = edate_error + check_null('#seledate_yr','End date must not be empty.');
	    if(edate_error > 0){
	    	$('.div-edate').addClass('font-red');
	    }else{
	    	$('.div-edate').removeClass('font-red');
	    }

	    total_error = total_error + check_number('#txtamtGranted','Amount Granted must not be empty.');
	    total_error = total_error + check_number('#txtmonthly','Monthly must not be empty.');
	    total_error = total_error + check_number('#txtperiod1','Period 1 must not be empty.');
	    total_error = total_error + check_number('#txtperiod2','Period 2 must not be empty.');
	    total_error = total_error + check_number('#txtperiod3','Period 3 must not be empty.');
	    total_error = total_error + check_number('#txtperiod4','Period 4 must not be empty.');
	    total_error = total_error + check_null('#selstatus','Status must not be empty.');
	    total_error = total_error + check_income_amount('#txtmonthly','#txtperiod1','#txtperiod2','#txtperiod3','#txtperiod4');

	    if(total_error > 0){
	        e.preventDefault();
	    }
	});

});