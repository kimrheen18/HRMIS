$(document).ready(function() {
	$('#table-adj-deductions, #table-adj-income').dataTable({"pageLength": 5});

	$('#btnaddIncome_adj').click(function() {
	    $('.modal-action').html('Add');
	    $('#txtaction').val('add');
	    $('#txtinc_id, #txtinc_amt').val('');
	    $('#selinc_type, #selinc_month, #selinc_yr').val('null');
	    $('#selincome').select2('val','null');
	    $('.form-group').removeClass('has-error');
	    $('.input-icon').find("i").hide();
	    $('#incomeAdjustments').modal('show');
	});

	$('#table-adj-income').on('click', 'tbody > tr #btneditIncome_adj', function () {
	    $('.modal-action').html('Update');
	    $('#txtaction').val('edit');

	    var data = $(this).data('json');
	    $('#txtinc_id').val(data.code);
	    $('#seladjmon').val(data.adjustMonth).selectpicker('refresh');
	    $('#seladjyr').val(data.adjustYear).selectpicker('refresh');
	    $('#seladjper').val(data.adjustPeriod).selectpicker('refresh');

	    $('#selincome').select2().select2('val',data.incomeCode);
	    $('#selincome').closest('div.form-group').find('i.fa-check').remove();
	    $('#selincome').closest('div.form-group').removeClass('has-success');
	    $('#txtinc_amt').val(data.incomeAmount);

	    $('#selinc_type').val(data.type).selectpicker('refresh');

	    $('#selinc_month').val(data.incomeMonth).selectpicker('refresh');
	    $('#selinc_yr').val(data.incomeYear).selectpicker('refresh');
	});

	$('#btnaddDeduct_adj').click(function() {
	    $('.modal-action').html('Add');
	    $('#txtded_action').val('add');
	    $('#txtded_id, #txtded_amt').val('');
	    $('#selded_type, #selded_month, #selded_yr').val('null');
	    $('#seldeduct').select2('val','null');
	    $('.form-group').removeClass('has-error');
	    $('.input-icon').find("i").hide();
	    $('#deductAdjustments').modal('show');
	});

	/* Income Adjustment */
	$('#seladjmon,#seladjyr,#seladjper').on('keyup keypress change',function() {
		var period_error = 0;
		period_error = period_error + check_null('#seladjmon','Payroll month must not be empty.');
		period_error = period_error + check_null('#seladjyr','Payroll year must not be empty.');
		period_error = period_error + check_null('#seladjper','Payroll period must not be empty.');
		if(period_error > 0){
			$('.div-payrolldate').addClass('font-red');
		}else{
			$('.div-payrolldate').removeClass('font-red');
		}
	});

	$('#selincome').on('keyup keypress change',function() {
		check_null('#selincome','Income period must not be empty.');
	});

	$('#selinc_type').on('keyup keypress change',function() {
		check_null('#selinc_type','Type must not be empty.');
	});

	$('#txtinc_amt').on('keyup keypress change',function() {
		check_number('#txtinc_amt','Income must not be empty.');
	});

	$('#selinc_month,#selinc_yr').on('keyup keypress change',function() {
		var adjdate_error = 0;
		adjdate_error = adjdate_error + check_null('#selinc_month','Adjustment month must not be empty.');
		adjdate_error = adjdate_error + check_null('#selinc_yr','Adjustment year must not be empty.');
		if(adjdate_error > 0){
			$('.div-adjdate').addClass('font-red');
		}else{
			$('.div-adjdate').removeClass('font-red');
		}
	});

	$('#btnsubmit-adj-income').click(function(e) {
		var total_error = 0;
		var period_error = 0;

		period_error = period_error + check_null('#seladjmon','Payroll month must not be empty.');
		period_error = period_error + check_null('#seladjyr','Payroll year must not be empty.');
		period_error = period_error + check_null('#seladjper','Payroll period must not be empty.');
		total_error = total_error + period_error;
		if(period_error > 0){
			$('.div-payrolldate').addClass('font-red');
		}else{
			$('.div-payrolldate').removeClass('font-red');
		}

		total_error = total_error + check_null('#selinc_type','Type must not be empty.');
		total_error = total_error + check_null('#selincome','Amount must not be empty.');
		total_error = total_error + check_number('#txtinc_amt','Income must not be empty.');
		total_error = total_error + check_null('#selinc_type','Type must not be empty.');

		var adjdate_error = 0;
		adjdate_error = adjdate_error + check_null('#selinc_month','Adjustment month must not be empty.');
		adjdate_error = adjdate_error + check_null('#selinc_yr','Adjustment year must not be empty.');
		total_error = total_error + adjdate_error;
		if(adjdate_error > 0){
			$('.div-adjdate').addClass('font-red');
		}else{
			$('.div-adjdate').removeClass('font-red');
		}

		if(total_error > 0){
		    e.preventDefault();
		}
	});

	$('#table-adj-income').on('click', 'tbody > tr #btndeleteIncome_adj', function () {
	    $('#txtdel_action').val('income');
	    $('#txtdel_id').val($(this).data('id'));
	});

	/* Deduction Adjustment */
	$('#seladjmon-deduct,#seladjyr-deduct,#seladjper-deduct').on('keyup keypress change',function() {
		var period_error = 0;
		period_error = period_error + check_null('#seladjmon-deduct','Payroll month must not be empty.');
		period_error = period_error + check_null('#seladjyr-deduct','Payroll year must not be empty.');
		period_error = period_error + check_null('#seladjper-deduct','Payroll period must not be empty.');
		if(period_error > 0){
			$('.div-deduct-date').addClass('font-red');
		}else{
			$('.div-deduct-date').removeClass('font-red');
		}
	});

	$('#seldeduct').on('keyup keypress change',function() {
		check_null('#seldeduct','Deduction must not be empty.');
	});

	$('#txtded_amt').on('keyup keypress change',function() {
		check_number('#txtded_amt','Amount must not be empty.');
	});

	$('#selded_type').on('keyup keypress change',function() {
		check_null('#selded_type','Type must not be empty.');
	});

	$('#seladj_month,#seladj_yr').on('keyup keypress change',function() {
		var adjdate_error = 0;
		adjdate_error = adjdate_error + check_null('#seladj_month','Adjustment month must not be empty.');
		adjdate_error = adjdate_error + check_null('#seladj_yr','Adjustment year must not be empty.');
		if(adjdate_error > 0){
			$('.div-adj-deduct-date').addClass('font-red');
		}else{
			$('.div-adj-deduct-date').removeClass('font-red');
		}
	});

	$('#btnsubmit-adj-deduction').click(function(e) {
		var total_error = 0;
		var period_error = 0;

		period_error = period_error + check_null('#seladjmon-deduct','Payroll month must not be empty.');
		period_error = period_error + check_null('#seladjyr-deduct','Payroll year must not be empty.');
		period_error = period_error + check_null('#seladjper-deduct','Payroll period must not be empty.');
		total_error = total_error + period_error;
		if(period_error > 0){
			$('.div-deduct-date').addClass('font-red');
		}else{
			$('.div-deduct-date').removeClass('font-red');
		}

		total_error = total_error + check_null('#seldeduct','Deduction must not be empty.');
		total_error = total_error + check_number('#txtded_amt','Amount must not be empty.');
		total_error = total_error + check_null('#selded_type','Type must not be empty.');

		var adjdate_error = 0;
		adjdate_error = adjdate_error + check_null('#seladj_month','Adjustment month must not be empty.');
		adjdate_error = adjdate_error + check_null('#seladj_yr','Adjustment year must not be empty.');
		total_error = total_error + adjdate_error;
		if(adjdate_error > 0){
			$('.div-adj-deduct-date').addClass('font-red');
		}else{
			$('.div-adj-deduct-date').removeClass('font-red');
		}

		if(total_error > 0){
		    e.preventDefault();
		}
	});

	$('#table-adj-deductions').on('click', 'tbody > tr #btneditdeduct_adj', function () {
	    $('.modal-action').html('Update');
	    $('#txtded_action').val('edit');
	    var data = $(this).data('json');
	    $('#txtded_id').val(data.code);
	    $('#seladjmon-deduct').val(data.adjustMonth).selectpicker('refresh');
	    $('#seladjyr-deduct').val(data.adjustYear).selectpicker('refresh');
	    $('#seladjper-deduct').val(data.adjustPeriod).selectpicker('refresh');

	    $('#seldeduct').select2("val", data.deductionCode);
	    $('#seldeduct').closest('div.form-group').find('i.fa-check').remove();
	    $('#seldeduct').closest('div.form-group').removeClass('has-success');

	    $('#txtded_amt').val(data.deductAmount);
	    $('#selded_type').val(data.type).selectpicker('refresh');
	    $('#seladj_month').val(data.deductMonth).selectpicker('refresh');
	    $('#seladj_yr').val(data.deductYear).selectpicker('refresh');
	});

	$('#table-adj-deductions').on('click', 'tbody > tr #btndeletededuct_adj', function () {
	    $('#txtdel_action').val('deduction');
	    $('#txtdel_id').val($(this).data('id'));
	});

});