$(document).ready(function(){
	/* Reason */
	$('#txtleave_reason').on('keyup keypress change',function() {
		if($(this).val() != ''){
			$(this).closest('div.form-group').removeClass('has-error');
			$(this).closest('div.form-group').addClass('has-success');
			$(this).closest('div.form-group').find('i.fa-warning').remove();
			$(this).closest('div.form-group').find('i.fa-check').remove();
			$('<i class="fa fa-check tooltips"></i>').insertBefore($(this));
		}else{
			$(this).closest('div.form-group').addClass('has-error');
			$(this).closest('div.form-group').removeClass('has-success');
			$(this).closest('div.form-group').find('i.fa-check').remove();
			$(this).closest('div.form-group').find('i.fa-warning').remove();
			$('<i class="fa fa-warning tooltips" data-original-title="Reason must not be empty."></i>').tooltip().insertBefore($(this));
		}
	});
	
});