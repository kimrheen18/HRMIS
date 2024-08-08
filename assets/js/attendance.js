$(document).ready(function(){
	$('div#div-fixed,div#div-sliding,div#scheme_desc,div#checkbox').hide();

	$('#strSchemeType').on('keyup keypress change',function() {
		$('div#scheme_desc,div#checkbox').show();
		var type = $(this).val().toLowerCase();
		if(type == 'fixed'){
			$('div#div-fixed').show();
			$('div#div-sliding').hide();
		}else if(type == 'sliding'){
			$('div#div-sliding').show();
			$('div#div-fixed').hide();
		}else{
			$('div#div-fixed,div#div-sliding,div#scheme_desc,div#checkbox').hide();
		}
	});

	$('#strSchemeCode').on('keyup keypress change',function() {
		check_null('#strSchemeCode','Scheme Code must not be empty.');
	});

	$('#btn-add-attscheme').click(function(e) {
		// e.preventDefault(); 
	    var total_error = 0;

	    total_error = total_error + check_null('#strSchemeType','Scheme Type must not be empty.');
	    total_error = total_error + check_null('#strSchemeCode','Scheme Code must not be empty.');
	    total_error = total_error + check_null('#strSchemeName','Scheme Name must not be empty.');

	    // fixed
	    total_error = total_error + check_null('#dtmFtimeIn','Fixed Time In must not be empty.');
	    total_error = total_error + check_null('#dtmFtimeOutFrom','Time-Out From (noon) must not be empty.');
	    total_error = total_error + check_null('#dtmFtimeOutTo','Time-Out To (noon) must not be empty.');
	    total_error = total_error + check_null('#dtmFtimeInFrom','Time-In From (noon) must not be empty.');
	    total_error = total_error + check_null('#dtmFtimeInTo','Time-In To (noon) must not be empty.');
	    total_error = total_error + check_null('#dtmFtimeOut','Time-Out must not be empty.');

	  	// sliding
	    total_error = total_error + check_null('#dtmStimeInFrom','Sliding Time In From must not be empty.');
	    total_error = total_error + check_null('#dtmStimeInTo','Time In To must not be empty.');
	    total_error = total_error + check_null('#dtmStimeOutFromNN','Time-Out From (noon) must not be empty.');
	    total_error = total_error + check_null('#dtmStimeOutToNN','Time-Out To (noon) must not be empty.');
	    total_error = total_error + check_null('#dtmStimeInFromNN','Time-In From (noon) must not be empty.');
	    total_error = total_error + check_null('#dtmStimeInToNN','Time-In To (noon) must not be empty.');
	    total_error = total_error + check_null('#dtmStimeOutFrom','Time Out From must not be empty.');
	    total_error = total_error + check_null('#dtmStimeOutTo','Time Out To must not be empty.');
	
	    if(total_error > 0){
	        e.preventDefault();
	    }
	});

});