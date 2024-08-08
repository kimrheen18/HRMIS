function checkElement(e,obj='',value=0)
{
	var res = 1;
	if(obj=='radio'){
		if(value == 1){
			e.parent().removeClass('has-error');
			res = 0;
		}else{
			e.parent().addClass('has-error');
			res = 1;
		}
	}else{
		if(obj == 'select2-multiple'){
			if(e.val() == null){
				e.parent().parent().addClass('has-error');
				e.prev("i").attr('data-original-title', "This field is required.");
				e.prev("i").show();
				res = 1;	
			}else{
				e.prev("i").hide();
				e.parent().parent().removeClass('has-error');
				res = 0;
			}
		}else{

			if(e.val() == '' || e.val() == null || e.val().toLowerCase() == 'null'){
				e.parent().parent().addClass('has-error');
				e.prev("i").attr('data-original-title', "This field is required.");
				e.prev("i").show();
				res = 1;
			}else{
				if(obj == 'text'){
					if(!e.val().replace(/\s/g, '').length){
						e.parent().parent().addClass('has-error');
						e.prev("i").attr('data-original-title', "Invalid input.");
						e.prev("i").show();
						res = 1;
					}else{
						e.prev("i").hide();
						e.parent().parent().removeClass('has-error');
						res = 0;
					}
				}else{
					e.prev("i").hide();
					e.parent().parent().removeClass('has-error');
					res = 0;
				}
			}

		}

	}
	return res;
}

$(document).ready(function() {
	$('.i-required').hide();
	if($('.loading-image').length > 0){
		$('.loading-image').hide();
	    $('.portlet-body').show();
	}

	$('form [type="text"].form-required').keyup(function(e) {
		checkElement($(this), 'text');
	});

	$('form select.form-required:not(select.select2-multiple)').change(function(e) {
		checkElement($(this));
	});

	$('form select.select2-multiple.form-required').change(function(e) {
		checkElement($(this),'select2-multiple');
	});

	if($('form [type="radio"]').length > 0){
		$('.radio-required').click(function() {
			checkElement($(this), 'radio', $(this).find("input:radio:checked").length);
		});
	}

	// $('.date-picker').on('change', function(ev){
	//     // console.log($('form [type="text"].form-required.txtdtpckr').val());
	//     var inputs = $('form [type="text"].form-required.txtdtpckr');
	//     for(var i = 0; i < inputs.length; i++){
	//         console.log($(inputs[i]).val());
	//     }
	// });

	// $('.date-picker').on("change", function(dateText) {
	// 	console.log($(this));
	// });

	// $('.date-picker').datepicker({
	//     dateFormat: 'dd-mm-yy',
	//     onSelect: function(dateText, inst) {
	//       alert(dateText);
	//     }
	//   });

	$('form').on('submit', function (e) {
		frmname = typeof($(this).attr('id')) != "undefined" && $(this).attr('id') !== null ? '#'+$(this).attr('id') : '';

		var resval = [];
		$(frmname+' [type="text"].form-required').each(function() {
			resval.push(checkElement($(this), 'text'));
		});

		$(frmname+' select.form-required:not(select.select2-multiple)').each(function() {
			console.log($(this));
			resval.push(checkElement($(this)));
		});

		$(frmname+' select.select2-multiple.form-required').each(function() {
			console.log($(this));
			resval.push(checkElement($(this),'select2-multiple'));
		});

		$(frmname+' .radio-required').each(function() {	
			resval.push(checkElement($(this), 'radio', $(this).find("input:radio:checked").length));
		});

		console.log(resval);
		if(resval.includes(1)){
			e.preventDefault();
		}
	});
});