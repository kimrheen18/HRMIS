function viewPassword() {
	var x = document.getElementById("txtpass");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}
}

function viewIniPassword() {
	var x = document.getElementById("txtinipass");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}
}

function divset_bottom() {
	var objDiv = $(".code");
	$('div#loading-text').remove();
	var h = objDiv.get(0).scrollHeight;
	objDiv.animate({scrollTop: h});
}

$(document).ready(function(){
	/* Initial Password */
	$('#txtinipass').hide();
	$('input#chkinipass').change(function() {
	    if (this.checked) {
	        $('#txtinipass').show();
	        $('#txtinipass').prop('required',true);
	        $('#div-inipass').show();
	    } else {
	        $('#txtinipass').hide();
	        $('#txtinipass').removeAttr('required');
	        $('#div-inipass').hide();
	    }
	});

	/* Check host */
	$('#txthost').on('keyup keypress change',function() {
		if($(this).val() != ''){
			$('#txthost').closest('div.form-group').removeClass('has-error');
			$('#txthost').closest('div.form-group').addClass('has-success');
			$('#txthost').closest('div.form-group').find('i.fa-warning').hide();
			$('#txthost').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txthost').closest('div.form-group').addClass('has-error');
			$('#txthost').closest('div.form-group').removeClass('has-success');
			$('#txthost').closest('div.form-group').find('i.fa-warning').show();
			$('#txthost').closest('div.form-group').find('i.fa-check').hide();
		}
	});

	/* Check Database Name */
	$('#txtdbname').on('keyup keypress',function() {
		if($(this).val() != ''){
			$('#txtdbname').closest('div.form-group').removeClass('has-error');
			$('#txtdbname').closest('div.form-group').addClass('has-success');
			$('#txtdbname').closest('div.form-group').find('i.fa-warning').hide();
			$('#txtdbname').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txtdbname').closest('div.form-group').addClass('has-error');
			$('#txtdbname').closest('div.form-group').removeClass('has-success');
			$('#txtdbname').closest('div.form-group').find('i.fa-warning').show();
			$('#txtdbname').closest('div.form-group').find('i.fa-check').hide();
		}
	});

	/* Check Database username */
	$('#txtuname').on('keyup keypress',function() {
		if($(this).val() != ''){
			$('#txtuname').closest('div.form-group').removeClass('has-error');
			$('#txtuname').closest('div.form-group').addClass('has-success');
			$('#txtuname').closest('div.form-group').find('i.fa-warning').hide();
			$('#txtuname').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txtuname').closest('div.form-group').addClass('has-error');
			$('#txtuname').closest('div.form-group').removeClass('has-success');
			$('#txtuname').closest('div.form-group').find('i.fa-warning').show();
			$('#txtuname').closest('div.form-group').find('i.fa-check').hide();
		}
	});

	/* Check Database password */
	$('#txtpass').on('keyup keypress',function() {
		if($(this).val() != ''){
			$('#txtpass').closest('div.form-group').removeClass('has-error');
			$('#txtpass').closest('div.form-group').addClass('has-success');
			$('#txtpass').closest('div.form-group').find('i.fa-warning').hide();
			$('#txtpass').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txtpass').closest('div.form-group').addClass('has-error');
			$('#txtpass').closest('div.form-group').removeClass('has-success');
			$('#txtpass').closest('div.form-group').find('i.fa-warning').show();
			$('#txtpass').closest('div.form-group').find('i.fa-check').hide();
		}
	});

	/* Check Initial password */
	$('#txtinipass').on('keyup keypress',function() {
		if($(this).val() != ''){
			$('#txtinipass').closest('div.form-group').removeClass('has-error');
			$('#txtinipass').closest('div.form-group').addClass('has-success');
			$('#txtinipass').closest('div.form-group').find('i.fa-warning').hide();
			$('#txtinipass').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txtinipass').closest('div.form-group').addClass('has-error');
			$('#txtinipass').closest('div.form-group').removeClass('has-success');
			$('#txtinipass').closest('div.form-group').find('i.fa-warning').show();
			$('#txtinipass').closest('div.form-group').find('i.fa-check').hide();
		}
	});

	$('#btnmigrate').click(function() {
		var arrerror= [];
		var host 	= $('#txthost').val();
		var dbname 	= $('#txtdbname').val();
		var uname 	= $('#txtuname').val();
		var pass 	= $('#txtpass').val();
		pass = pass.replace(/\&/g,'^amp;');
		pass = pass.replace(/\*/g,'^atrsk;');
		pass = pass.replace(/\+/g,'^pls;');
		pass = pass.replace(/\+/g,'^pls;');
		pass = pass.replace(/\#/g,'^hash;');

		var inipass	= $('#txtinipass').val();
		inipass = inipass.replace(/\&/g,'^amp;');
		inipass = inipass.replace(/\*/g,'^atrsk;');
		inipass = inipass.replace(/\+/g,'^pls;');
		inipass = inipass.replace(/\+/g,'^pls;');
		inipass = inipass.replace(/\#/g,'^hash;');
		// check "" and ''
		
		/* Check host */
		if(host != ''){
			$('#txthost').closest('div.form-group').removeClass('has-error');
			$('#txthost').closest('div.form-group').addClass('has-success');
			$('#txthost').closest('div.form-group').find('i.fa-warning').hide();
			$('#txthost').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txthost').closest('div.form-group').addClass('has-error');
			$('#txthost').closest('div.form-group').removeClass('has-success');
			$('#txthost').closest('div.form-group').find('i.fa-warning').show();
			$('#txthost').closest('div.form-group').find('i.fa-check').hide();
			arrerror.push(1);
		}

		/* Check dbname */
		if(dbname != ''){
			$('#txtdbname').closest('div.form-group').removeClass('has-error');
			$('#txtdbname').closest('div.form-group').addClass('has-success');
			$('#txtdbname').closest('div.form-group').find('i.fa-warning').hide();
			$('#txtdbname').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txtdbname').closest('div.form-group').addClass('has-error');
			$('#txtdbname').closest('div.form-group').removeClass('has-success');
			$('#txtdbname').closest('div.form-group').find('i.fa-warning').show();
			$('#txtdbname').closest('div.form-group').find('i.fa-check').hide();
			arrerror.push(1);
		}

		/* Check uname */
		if(uname != ''){
			$('#txtuname').closest('div.form-group').removeClass('has-error');
			$('#txtuname').closest('div.form-group').addClass('has-success');
			$('#txtuname').closest('div.form-group').find('i.fa-warning').hide();
			$('#txtuname').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txtuname').closest('div.form-group').addClass('has-error');
			$('#txtuname').closest('div.form-group').removeClass('has-success');
			$('#txtuname').closest('div.form-group').find('i.fa-warning').show();
			$('#txtuname').closest('div.form-group').find('i.fa-check').hide();
			arrerror.push(1);
		}

		/* Check pass */
		if(pass != ''){
			$('#txtpass').closest('div.form-group').removeClass('has-error');
			$('#txtpass').closest('div.form-group').addClass('has-success');
			$('#txtpass').closest('div.form-group').find('i.fa-warning').hide();
			$('#txtpass').closest('div.form-group').find('i.fa-check').show();
		}else{
			$('#txtpass').closest('div.form-group').addClass('has-error');
			$('#txtpass').closest('div.form-group').removeClass('has-success');
			$('#txtpass').closest('div.form-group').find('i.fa-warning').show();
			$('#txtpass').closest('div.form-group').find('i.fa-check').hide();
			arrerror.push(1);
		}

		/* Initial Password */
		if($("#chkinipass").is(':checked')){
			if(inipass != ''){
				$('#txtinipass').closest('div.form-group').removeClass('has-error');
				$('#txtinipass').closest('div.form-group').addClass('has-success');
				$('#txtinipass').closest('div.form-group').find('i.fa-warning').hide();
				$('#txtinipass').closest('div.form-group').find('i.fa-check').show();
			}else{
				$('#txtinipass').closest('div.form-group').addClass('has-error');
				$('#txtinipass').closest('div.form-group').removeClass('has-success');
				$('#txtinipass').closest('div.form-group').find('i.fa-warning').show();
				$('#txtinipass').closest('div.form-group').find('i.fa-check').hide();
				arrerror.push(1);
			}
		}

		if(jQuery.inArray(1,arrerror) !== -1){
			console.log('Error');
		}else{
			divset_bottom();
			$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
			$('.code').show();

			/* STEP 1*/
			$('.code').append($("<div>").load(encodeURI("dbmigrate/migrate/comparing_tables?host="+host+"&dbname="+dbname+"&uname="+uname+"&pass="+pass+"&inipass="+inipass), function() {
				$('#update_table-modal').modal({'backdrop':'static','keyboard':'false'});
				$('#update_table-modal').modal({},'show');
			}));
		}

	});

	$('#btn-update-tables').click(function(e) {
		divset_bottom();
		$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
		e.preventDefault();
		$('#update_table-modal').modal('hide');

		/* STEP 2; Fix Date*/
		$('.code').append($("<div>").load("dbmigrate/migrate/fix_datetime_fields", function() { 
			divset_bottom();
			$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
			/* STEP 3; Fix Time*/
			$('.code').append($("<div>").load("dbmigrate/migrate/fix_time", function() { 
				divset_bottom();
				$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
				/* STEP 4; fix DateTime field in table tblEmpDTR*/
				$('.code').append($("<div>").load("dbmigrate/migrate/fix_dtr_datetime_field", function() {
					divset_bottom();
					$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
					$('#fix_datetime_fields-modal').modal({'backdrop':'static','keyboard':'false'});
					$('#fix_datetime_fields-modal').modal('show');
				}));
			}));
		}));
	});

	/* STEP */
	$('#btn-fix-date-fields').click(function(e) {
		divset_bottom();
		$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
		e.preventDefault();
		$('#fix_datetime_fields-modal').modal('hide');
		$('.code').append($("<div>").load("dbmigrate/migrate/update_fields", function() { 
			divset_bottom();
			$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
			/* STEP 5; Change inPM to Military Time*/
			$('.code').append($("<div>").load("dbmigrate/migrate/fix_dtr_inpm_military_time", function() {
				divset_bottom();
				$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
				/* STEP 6; Change outPM to Military Time*/
				$('.code').append($("<div>").load("dbmigrate/migrate/fix_dtr_outpm_military_time", function() {
					divset_bottom();
					$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
					// /* STEP 7; Change inOT to Military Time*/
					$('.code').append($("<div>").load("dbmigrate/migrate/fix_dtr_inot_military_time", function() {
						divset_bottom();
						$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
						/* STEP 8; Change outOT to Military Time*/
						$('.code').append($("<div>").load("dbmigrate/migrate/fix_dtr_outot_military_time", function() {
							divset_bottom();
							$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
							/* STEP 9; Drop old field with old data */
							$('.code').append($("<div>").load("dbmigrate/migrate/fix_dtr_drop_old_field", function() {
								divset_bottom();
								$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
								$('#update_fields-modal').modal({'backdrop':'static','keyboard':'false'});
								$('#update_fields-modal').modal('show');
							}));
						}));
					}));
				}));
			}));
		}));
	});

	$('#btn-update-fields').click(function(e) {
		divset_bottom();
		$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
		e.preventDefault();
		$('#update_fields-modal').modal('hide');
		$('.code').append($("<div>").load("dbmigrate/migrate/update_data_type", function() {
			divset_bottom();
			$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
			$('#update_data_type-modal').modal({'backdrop':'static','keyboard':'false'});
			$('#update_data_type-modal').modal('show');
		}));
	});

	$('#btn-update-data-type').click(function(e) {
		divset_bottom();
		$(".code").append('<div id="loading-text"><b>Loading</b> <img src="assets/images/loading-text.gif" width="35px"/></div>');
		e.preventDefault();
		$('#update_data_type-modal').modal('hide');
		$('.code').append($("<div>").load("dbmigrate/migrate/update_database", function() {
			divset_bottom();
		}));
	});



});

