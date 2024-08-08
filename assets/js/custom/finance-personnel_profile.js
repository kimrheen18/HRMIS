function check_null(el,msg)
{
    $(el).closest('div.form-group').find('i.fa-calendar').remove();
    if($(el).val() != ''){
        $(el).closest('div.form-group').removeClass('has-error');
        $(el).closest('div.form-group').addClass('has-success');
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $('<i class="fa fa-check tooltips"></i>').insertBefore($(el));
        return 0;
    }else{
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="'+msg+'"></i>').tooltip().insertBefore($(el));
        return 1;
    }
}

function check_number(el)
{
    $(el).closest('div.form-group').find('i.fa-calendar').remove();
    if(isNaN($(el).val()) == false && $(el).val() != ''){
        $(el).closest('div.form-group').removeClass('has-error');
        $(el).closest('div.form-group').addClass('has-success');
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $('<i class="fa fa-check tooltips"></i>').insertBefore($(el));
        return 0;
    }else{
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="Invalid input."></i>').tooltip().insertBefore($(el));
        return 1;
    }
}

$(document).ready(function() {
    $('#selpayrollGrp').on('keyup keypress change',function() {
        check_null('#selpayrollGrp','Payroll Group must not be empty.');
    });

    $('#selattScheme').on('keyup keypress change',function() {
        check_null('#selattScheme','Attendance Scheme must not be empty.');
    });

    $('#txtacctNumber').on('keyup keypress change',function() {
        check_null('#txtacctNumber','Account Number must not be empty.');
    });

    $('#seltaxStatus').on('keyup keypress change',function() {
        check_null('#seltaxStatus','Tax Status must not be empty.');
    });

    $('#txtnodependents').on('keyup keypress change',function() {
        check_number('#txtnodependents');
    });

    $('#txttxtRate').on('keyup keypress change',function() {
        check_number('#txttxtRate');
    });

    $('#txthazardPay').on('keyup keypress change',function() {
        check_number('#txthazardPay');
    });

    $('#btnsubmit-payrollDetails').on('click', function(e) {
        var total_error = 0;
        total_error = check_null('#selpayrollGrp','Payroll Group must not be empty.') + check_null('#selattScheme','Attendance Scheme must not be empty.') + check_null('#txtacctNumber','Account Number must not be empty.') + check_null('#seltaxStatus','Tax Status must not be empty.') + check_number('#txtnodependents') + check_number('#txttxtRate') + check_number('#txthazardPay');
        
        if(total_error > 0){
            e.preventDefault();
        }
    });

    
    $('#selappointment').on('keyup keypress change', function() {
        check_null('#selappointment','Appointment Desc must not be empty.');
    });
    
    $('#selitem').on('keyup keypress change', function() {
        check_null('#selitem','Item Number must not be empty.');
    });
    
    $('#txtactual_salary').on('keyup keypress change', function() {
        check_number('#txtactual_salary','Actual Salary must not be empty.');
    });
    
    $('#txtauth_salary').on('keyup keypress change', function() {
        check_number('#txtauth_salary','Authorize Salary must not be empty.');
    });
    
    $('#selmodeofseparation').on('keyup keypress change', function() {
        check_null('#selmodeofseparation','Employment Status must not be empty.');
    });
    
    $('#txtsalaryGrade').on('keyup keypress change', function() {
        check_number('#txtsalaryGrade','Salary Grade must not be empty.');
    });
    
    $('#selStep_number').on('keyup keypress change', function() {
        check_number('#selStep_number','Step Number must not be empty.');
    });

    $('#btnsubmit-positionDetails').on('click', function(e) {
        var total_error = 0;

        total_error = total_error + check_null('#selappointment','Appointment Desc must not be empty.');
        total_error = total_error + check_null('#selitem','Item Number must not be empty.');
        total_error = total_error + check_number('#txtactual_salary','Actual Salary must not be empty.');
        total_error = total_error + check_number('#txtauth_salary','Authorize Salary must not be empty.');
        total_error = total_error + check_null('#selmodeofseparation','Employment Status must not be empty.');
        total_error = total_error + check_number('#txtsalaryGrade','Salary Grade must not be empty.');
        total_error = total_error + check_number('#selStep_number','Step Number must not be empty.');

        if(total_error > 0){
            e.preventDefault();
        }
    });

});