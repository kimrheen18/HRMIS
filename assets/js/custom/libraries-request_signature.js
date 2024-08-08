$(document).ready(function() {
    $('.loading-image').hide();
    $('#div-body').css('visibility', 'visible');

	$('#request_type').on('keyup keypress change',function() {
		if($('#request_type').val() != null){
            $('#request_type').closest('div.form-group').removeClass('has-error');
            $('#request_type').closest('div.form-group').addClass('has-success');
            $('#request_type').closest('div.form-group').find('i.fa-warning').remove();
            $('#request_type').closest('div.form-group').find('i.fa-check').remove();
            $('<i class="fa fa-check tooltips"></i>').insertBefore($('#request_type'));
        }else{
            $('#request_type').closest('div.form-group').addClass('has-error');
            $('#request_type').closest('div.form-group').removeClass('has-success');
            $('#request_type').closest('div.form-group').find('i.fa-check').remove();
            $('#request_type').closest('div.form-group').find('i.fa-warning').remove();
            $('<i class="fa fa-warning tooltips font-red" data-original-title="Type of Request not be empty."></i>').tooltip().insertBefore($('#request_type'));
        }
	});

	$('#app_type').on('keyup keypress change',function() {
		check_null('#app_type','Type of Applicant not be empty.');
	});

	$('#sigfinal_action').on('keyup keypress change',function() {
		check_null('#sigfinal_action','Signatory not be empty.');
	});

	$('#sigfinal_officer').on('keyup keypress change',function() {
		check_null_select2('#sigfinal_officer','Officer not be empty.');
	});

    $('#btn_submit_signature').click(function(e) {
        var total_error = 0;

        if($('#request_type').val() != null){
            $('#request_type').closest('div.form-group').removeClass('has-error');
            $('#request_type').closest('div.form-group').addClass('has-success');
            $('#request_type').closest('div.form-group').find('i.fa-warning').remove();
            $('#request_type').closest('div.form-group').find('i.fa-check').remove();
            $('<i class="fa fa-check tooltips"></i>').insertBefore($('#request_type'));
        }else{
            $('#request_type').closest('div.form-group').addClass('has-error');
            $('#request_type').closest('div.form-group').removeClass('has-success');
            $('#request_type').closest('div.form-group').find('i.fa-check').remove();
            $('#request_type').closest('div.form-group').find('i.fa-warning').remove();
            $('<i class="fa fa-warning tooltips font-red" data-original-title="Type of Request not be empty."></i>').tooltip().insertBefore($('#request_type'));
            total_error = total_error + 1 ;
        }
        total_error = total_error + check_null('#app_type','Type of Applicant not be empty.');

        total_error = total_error + check_null('#sigfinal_action','Signatory not be empty.');
        total_error = total_error + check_null_select2('#sigfinal_officer','Officer not be empty.');

        if(total_error > 0){
            e.preventDefault();
        }
    });

    $('#btn_delete-request').on('click', function() {
        $('#delete-request').modal('show');
    });

});
