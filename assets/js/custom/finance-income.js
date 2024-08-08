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
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Total amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_a));
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Total amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_b));
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Total amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_c));
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Total amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_d));
			$('<i class="fa fa-warning tooltips font-red" data-original-title="Total amount should be equal to the total of period amount."></i>').tooltip().insertBefore($(el_e));
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

function update_employee()
{
	$('#txtallincomecode').val($('#txtincomecode').val());
	$('#txtallbenefittype').val($('#txtbenefitType').val());
	$('#txtallamount').val($('#txtamount-bl').val());
	$('#txtalltax').val($('#txttax').val());
	$('#txtallperiod1').val($('#txtperiod1-bl').val());
	$('#txtallperiod2').val($('#txtperiod2-bl').val());
	$('#txtallperiod3').val($('#txtperiod3-bl').val());
	$('#txtallperiod4').val($('#txtperiod4-bl').val());
	$('#selallstatus').val($('#selstatus-bl').val());
	$('#appointmentList').modal('show');
}

function update_employee_loans()
{
	$('#txtallamount').val($('#txtamount-loan').val());
	$('#txtallperiod1').val($('#txtperiod1-loan').val());
	$('#txtallperiod2').val($('#txtperiod2-loan').val());
	$('#txtallperiod3').val($('#txtperiod3-loan').val());
	$('#txtallperiod4').val($('#txtperiod4-loan').val());
	$('#selallemonth').val($('#selemonth-loan').val());
	$('#selallsmonth').val($('#selsmonth-loan').val());
	$('#selalleyr').val($('#seleyr-loan').val());
	$('#selallsyr').val($('#seleyr-loan').val());
	$('#selallstatus').val($('#selstatus-loan').val());
	$('#appointmentList-loan').modal('show');
}

$(document).ready(function() {
	$('#el-1, #el-2, #el-3, #el-4').hide();

	$('#table-benefitList, #table-bonusList, #table-longevityPay, #table-incomeList').dataTable({"pageLength": 5});

	$('#table-benefitList, #table-bonusList, #table-incomeList').on('click', 'tbody > tr #btn-modal-benefitList', function () {
	    $('#txtamount-bl,#txtperiod1-bl,#txtperiod2-bl,#txtperiod3-bl,#txtperiod4-bl,#selstatus-bl,#txtincomecode,#txtbenefitcode,#txttax-bl,#txtbenefitType').closest('div.form-group').removeClass('has-error');
	    $('#txtamount-bl,#txtperiod1-bl,#txtperiod2-bl,#txtperiod3-bl,#txtperiod4-bl,#selstatus-bl,#txtincomecode,#txtbenefitcode,#txttax-bl,#txtbenefitType').closest('div.form-group').removeClass('has-success');
	    $('#txtamount-bl,#txtperiod1-bl,#txtperiod2-bl,#txtperiod3-bl,#txtperiod4-bl,#selstatus-bl,#txtincomecode,#txtbenefitcode,#txttax-bl,#txtbenefitType').closest('div.form-group').find('i.fa-check').remove();
	    $('#txtamount-bl,#txtperiod1-bl,#txtperiod2-bl,#txtperiod3-bl,#txtperiod4-bl,#selstatus-bl,#txtincomecode,#txtbenefitcode,#txttax-bl,#txtbenefitType').closest('div.form-group').find('i.fa-warning').remove();

	    var el = $(this);
	    $('#div-tax').hide();
	    $('#sub-title').html(el.closest('table').data('title'));
	    $('#modal-title').html(el.parent().siblings(":first").text());
	    $('#txtamount-bl').val(el.parent().siblings(":eq(1)").text());
	    $('#txtperiod1-bl').val(el.data('period1').toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	    $('#txtperiod2-bl').val(el.data('period2').toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	    $('#txtperiod3-bl').val(el.data('period3').toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	    $('#txtperiod4-bl').val(el.data('period4').toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
	    $('#selstatus-bl').val(el.data("statusval"));
	    $('#selstatus-bl').selectpicker('refresh');

	    $('#txtincomecode').val(el.data("incomecode"));
	    $('#txtbenefitcode').val(el.data("benefitcode"));
	    $('#txttax-bl').val(el.data("tax"));
	    $('#txtbenefitType').val(el.closest('table').data("title"));
	    if(el.data("stat") == 'bonus') { $('#div-tax').show(); }
	});

	$('#table-longevityPay').on('click', 'tbody > tr #btn-modal-longevity', function () {
	    $('#txtlongevitydate-bl,#txtsalary-bl,#txtpercent-bl').closest('div.form-group').removeClass('has-error');
	    $('#txtlongevitydate-bl,#txtsalary-bl,#txtpercent-bl').closest('div.form-group').removeClass('has-success');
	    $('#txtlongevitydate-bl,#txtsalary-bl,#txtpercent-bl').closest('div.form-group').find('i.fa-check').remove();
	    $('#txtlongevitydate-bl,#txtsalary-bl,#txtpercent-bl').closest('div.form-group').find('i.fa-warning').remove();
	    $('#splonge').html('Update');
	    $('#txtlongevityid-bl').val($(this).data('longeid'));
	    $('#txt_upt_action').val('edit');
	    $('#sub-title').html($(this).closest('table').data('title'));
	    $('#txtlongevitydate-bl').val($(this).parent().siblings(":first").text());
	    $('#txtsalary-bl').val($(this).parent().siblings(":eq(1)").text());
	    $('#txtpercent-bl').val($(this).parent().siblings(":eq(2)").text());
	    $('#txtaction').val('edit');
	    $('#txtlongevityid').val($(this).data("longeid"));
	});

	$('#btn-add-longevity').on('click', function () {
	    $('#txtlongevitydate-bl,#txtsalary-bl,#txtpercent-bl').closest('div.form-group').removeClass('has-error');
	    $('#txtlongevitydate-bl,#txtsalary-bl,#txtpercent-bl').closest('div.form-group').removeClass('has-success');
	    $('#txtlongevitydate-bl,#txtsalary-bl,#txtpercent-bl').closest('div.form-group').find('i.fa-check').remove();
	    $('#txtlongevitydate-bl,#txtsalary-bl,#txtpercent-bl').closest('div.form-group').find('i.fa-warning').remove();
	    $('#splonge').html('Add');
	    $('#txtaction').val('add');
	    $('#txt_upt_action').val('add');
	    $('#txtlongevitydate-bl').val('');
	    $('#txtsalary-bl').val('');
	    $('#txtpercent-bl').val('');
	});

	$('#table-longevityPay').on('click', 'tbody > tr #btn-del-longevity', function () {
	    $('#txtdel_action').val('del');
	    $('#txtdel_longevityid').val($(this).data("longeid"));
	});

	$("#chkall").click(function () {
	    if($(this).is(":checked")){
	        $('div.checker span').addClass('checked');
	        $('input.chkappnt').prop('checked', true);
	    }else{
	        $('div.checker span').removeClass('checked');
	        $('input.chkappnt').prop('checked', false);
	    }
	});

	$("input.chkappnt").click(function () {
	    if($(this).is(":checked")){
	        $('div#uniform-chkall span').addClass('checked');
	        $('input#chkall').prop('checked', true);
	    }else{
	        $('div#uniform-chkall span').removeClass('checked');
	        $('input#chkall').prop('checked', false);
	    }
	});
	$('.date-picker').datepicker();

	$('#txtamount-bl').on('keyup keypress change',function() {
		check_income_amount('#txtamount-bl','#txtperiod1-bl','#txtperiod2-bl','#txtperiod3-bl','#txtperiod4-bl');
	});

	$('#txttax-bl').on('keyup keypress change',function() {
		check_number('#txttax-bl','Tax must not be empty.');
	});

	$('#txtperiod1-bl').on('keyup keypress change',function() {
		check_income_amount('#txtamount-bl','#txtperiod1-bl','#txtperiod2-bl','#txtperiod3-bl','#txtperiod4-bl');
	});

	$('#txtperiod2-bl').on('keyup keypress change',function() {
		check_income_amount('#txtamount-bl','#txtperiod1-bl','#txtperiod2-bl','#txtperiod3-bl','#txtperiod4-bl');
	});

	$('#txtperiod3-bl').on('keyup keypress change',function() {
		check_income_amount('#txtamount-bl','#txtperiod1-bl','#txtperiod2-bl','#txtperiod3-bl','#txtperiod4-bl');
	});

	$('#txtperiod4-bl').on('keyup keypress change',function() {
		check_income_amount('#txtamount-bl','#txtperiod1-bl','#txtperiod2-bl','#txtperiod3-bl','#txtperiod4-bl');
	});

	$('#selstatus-bl').on('keyup keypress change',function() {
		check_number('#selstatus-bl','Status must not be empty.');
	});

    $('#btnsubmit-deductDetails').click(function(e) {
        var total_error = 0;

        total_error = total_error + check_number('#txtamount-bl','Amount must not be empty.');
		total_error = total_error + check_number('#txttax-bl','Tax must not be empty.');
		total_error = total_error + check_number('#txtperiod1-bl','Period 1 must not be empty.');
		total_error = total_error + check_number('#txtperiod2-bl','Period 2 must not be empty.');
		total_error = total_error + check_number('#txtperiod3-bl','Period 3 must not be empty.');
		total_error = total_error + check_number('#txtperiod4-bl','Period 4 must not be empty.');
		total_error = total_error + check_number('#selstatus-bl','Status must not be empty.');
		total_error = total_error + check_income_amount('#txtamount-bl','#txtperiod1-bl','#txtperiod2-bl','#txtperiod3-bl','#txtperiod4-bl');

        if(total_error > 0){
            e.preventDefault();
        }else{
        	if(check_income_amount('#txtamount-bl','#txtperiod1-bl','#txtperiod2-bl','#txtperiod3-bl','#txtperiod4-bl') > 0){
        		e.preventDefault()
        	}
        }
    });

    /* Longevity */
    $('#txtlongevitydate-bl').on('changeDate keyup keypress', function(){
    	check_date('#txtlongevitydate-bl','Longevity Date must not be empty.');
    	$(this).datepicker('hide');
    });

    $('#txtsalary-bl').on('keyup keypress change',function() {
    	check_number('#txtsalary-bl','Salary must not be empty.');
    });

    $('#txtpercent-bl').on('keyup keypress change',function() {
    	check_number('#txtpercent-bl','Percent must not be empty.');
    });

    $('#btn-update-longevity').click(function(e) {
    	e.preventDefault();
    	var total_error = 0;
    	
        total_error = total_error + check_date('#txtlongevitydate-bl','Longevity Date must not be empty.');
		total_error = total_error + check_number('#txtsalary-bl','Salary must not be empty.');
		total_error = total_error + check_number('#txtpercent-bl','Percent must not be empty.');

        if(total_error < 1){
        	$('#txt_upt_longevitydate-bl').val($('#txtlongevitydate-bl').val());
			$('#txt_upt_salary-bl').val($('#txtsalary-bl').val());
			$('#txt_upt_percent-bl').val($('#txtpercent-bl').val());
            $('#update_longevity').modal('show');
        }
    });

    /* Update All Employee*/
    $('#btnupdateallemployees').click(function(e) {
    	var total_error = 0;

        total_error = total_error + check_number('#txtamount-bl','Amount must not be empty.');
		total_error = total_error + check_number('#txttax-bl','Tax must not be empty.');
		total_error = total_error + check_number('#txtperiod1-bl','Period 1 must not be empty.');
		total_error = total_error + check_number('#txtperiod2-bl','Period 2 must not be empty.');
		total_error = total_error + check_number('#txtperiod3-bl','Period 3 must not be empty.');
		total_error = total_error + check_number('#txtperiod4-bl','Period 4 must not be empty.');
		total_error = total_error + check_number('#selstatus-bl','Status must not be empty.');

        if(total_error > 0){
            e.preventDefault();
        }else{
        	if(check_income_amount('#txtamount-bl','#txtperiod1-bl','#txtperiod2-bl','#txtperiod3-bl','#txtperiod4-bl') > 0){
        		e.preventDefault()
        	}else{
        		update_employee();
        	}
        }
    });

    $('#btnupdateallemployee-loan').click(function(e) {
    	var total_error = 0;

        total_error = total_error + check_number('#txtamount-loan','Monthly must not be empty.');
        total_error = total_error + check_number('#txtperiod1-loan','Period 1 must not be empty.');
        total_error = total_error + check_number('#txtperiod2-loan','Period 2 must not be empty.');
        total_error = total_error + check_number('#txtperiod3-loan','Period 3 must not be empty.');
        total_error = total_error + check_number('#txtperiod4-loan','Period 4 must not be empty.');
        total_error = total_error + check_null('#selstatus-loan','Status must not be empty.');
        total_error = total_error + check_null('#selsyr-loan','Start year must not be empty.');
        total_error = total_error + check_null('#selsmonth-loan','Start month must not be empty.');
        total_error = total_error + check_null('#seleyr-loan','End year must not be empty.');
        total_error = total_error + check_null('#selemonth-loan','End month must not be empty.');
        total_error = total_error + check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan');

        if(total_error > 0){
            e.preventDefault();
        }else{
        	if(check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan') > 0){
        		e.preventDefault()
        	}else{
        		update_employee_loans();
        	}
        }
    });


    /* PREMIUM LOANS */
    $('#table-regDeductList, #table-loanList, #table-contandDeduct').dataTable({"pageLength": 5});

    $('#table-regDeductList, #table-loanList, #table-contandDeduct').on('click', 'tbody > tr #btn-modal-premloans', function () {
        var el = $(this);

        $('#txtalldeductcode').val(el.data("deductcode"));
        $('#txtalldeductioncode').val(el.data("deductioncode"));
        $('#txtalldeductionType').val(el.closest('table').data("title"));

        $('#sub-title').html(el.closest('table').data('title'));
        $('#modal-title').html(el.parent().siblings(":first").text());
        $('#txtamount-loan').val(el.parent().siblings(":eq(1)").text());

        $('#txtperiod1-loan').val(el.data('period1'));
        $('#txtperiod2-loan').val(el.data('period2'));
        $('#txtperiod3-loan').val(el.data('period3'));
        $('#txtperiod4-loan').val(el.data('period4'));
        $('#selstatus-loan').val(el.data("statusval"));
        $('#selstatus-loan').selectpicker('refresh');

        if(el.data('stat') == 'loan'){
        	$('.div-deduction').show();
	        $('#selsyr-loan').val(el.data("syr")).selectpicker('refresh');
	        $('#selsmonth-loan').val(el.data("smon")).selectpicker('refresh');
	        $('#seleyr-loan').val(el.data("eyr")).selectpicker('refresh');
	        $('#selemonth-loan').val(el.data("emon")).selectpicker('refresh');
	    }else{
	    	$('.div-deduction').hide();
	    }

        $('#txtdeductcode').val(el.data("deductcode"));
        $('#txtdeductioncode').val(el.data("deductioncode"));
        $('#txtdeductionType').val(el.closest('table').data("title"));

        $('#txtstat-loan,#txtallstat-loan').val(el.data('stat'));

        // $('#txtperiod1-bl, #txtperiod2-bl, #txtperiod3-bl, #txtperiod4-bl').prev("i").hide();
        // $('#txtperiod1-bl, #txtperiod2-bl, #txtperiod3-bl, #txtperiod4-bl').parent().parent().removeClass('has-error');
    });

    $('#txtamount-loan').on('keyup keypress change',function() {
    	check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan');
    });

    $('#txtperiod1-loan').on('keyup keypress change',function() {
    	check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan');
    });

    $('#txtperiod2-loan').on('keyup keypress change',function() {
    	check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan');
    });

    $('#txtperiod3-loan').on('keyup keypress change',function() {
    	check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan');
    });

    $('#txtperiod4-loan').on('keyup keypress change',function() {
    	check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan');
    });

    $('#selstatus-loan').on('keyup keypress change',function() {
    	check_number('#selstatus-loan','Start Year must not be empty.');
    });

    $('#selsyr-loan').on('keyup keypress change',function() {
    	check_number('#selsyr-loan','Start Month must not be empty.');
    });

    $('#selsmonth-loan').on('keyup keypress change',function() {
    	check_number('#selsmonth-loan','End Year must not be empty.');
    });

    $('#seleyr-loan').on('keyup keypress change',function() {
    	check_number('#seleyr-loan','End Month must not be empty.');
    });

    $('#selemonth-loan').on('keyup keypress change',function() {
    	check_number('#selemonth-loan','Status must not be empty.');
    });

    $('#btnsubmit-premloans').click(function(e) {
        var total_error = 0;

        total_error = total_error + check_number('#txtamount-loan','Monthly must not be empty.');
        total_error = total_error + check_number('#txtperiod1-loan','Period 1 must not be empty.');
        total_error = total_error + check_number('#txtperiod2-loan','Period 2 must not be empty.');
        total_error = total_error + check_number('#txtperiod3-loan','Period 3 must not be empty.');
        total_error = total_error + check_number('#txtperiod4-loan','Period 4 must not be empty.');
        total_error = total_error + check_null('#selstatus-loan','Status must not be empty.');
        total_error = total_error + check_null('#selsyr-loan','Start year must not be empty.');
        total_error = total_error + check_null('#selsmonth-loan','Start month must not be empty.');
        total_error = total_error + check_null('#seleyr-loan','End year must not be empty.');
        total_error = total_error + check_null('#selemonth-loan','End month must not be empty.');
        total_error = total_error + check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan');

        if(total_error > 0){
            e.preventDefault();
        }else{
        	if(check_income_amount('#txtamount-loan','#txtperiod1-loan','#txtperiod2-loan','#txtperiod3-loan','#txtperiod4-loan') > 0){
        		e.preventDefault()
        	}
        }
    });

});