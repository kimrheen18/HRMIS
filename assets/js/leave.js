function hide_all() {
	$('#wholeday_textbox,#leavefrom_textbox,#leaveto_textbox,#daysapplied_textbox,#signatory1_textbox,#signatory2_textbox,#attachments,#reason_textbox,#incaseSL_textbox,#incaseVL_textbox').hide();
}

function compute_leave_days() {
	var leave_from = $('#dtmLeavefrom').val();
	var leave_to = $('#dtmLeaveto').val();
	var total_days = 0;

	if(leave_from!='' && leave_to!='') {
		$.ajax({
			type : 'get',
			url : 'leave/getworking_days?empid='+$('#txtempno').val()+'&datefrom='+leave_from+'&dateto='+leave_to,
        	dataType : 'json',
	        success : function(data){
	        	$('#intDaysApplied').val(data.length);
	        	$('#intDaysApplied_val').val(data.length);
	        }
        });
	}else{
		$('#intDaysApplied').val('0');
		$('#intDaysApplied_val').val('0');
	}
}

$(document).ready(function() {
	$('.date-picker').datepicker();
    $('.date-picker').on('changeDate', function(){
        $(this).datepicker('hide');
    });


	$('#strLeavetype').on('change', function() {
		hide_all();

	    var leave_type = $(this).val().toLowerCase();
	    var form_action = '';

	    $('#wholeday_textbox,#leavefrom_textbox,#leaveto_textbox,#daysapplied_textbox,#signatory1_textbox,#signatory2_textbox,#attachments,#reason_textbox,.div-actions').show();
	    
	    switch(leave_type) {
	        case "fl":
	        	$('#reason_textbox').hide();
	            break;
	        case "sl":
	        	$('#incaseSL_textbox').show();
	            break;
	        case "vl":
	        	$('#incaseVL_textbox').show();
	            break;
	        case "":
	        	hide_all();
	        	break;
	    }
	    $('#txttype').val(leave_type);
	});

	$('#dtmLeavefrom').on('keyup keypress change',function() {
    	check_null('#dtmLeavefrom','Leave from must not be empty.');
    	compute_leave_days();
    });

    $('#dtmLeaveto').on('keyup keypress change',function() {
    	check_null('#dtmLeaveto','Leave to must not be empty.');
    	compute_leave_days();
    });

});
