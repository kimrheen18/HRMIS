/* settings:
	<div class="form-group">
		<label class="control-label">Label<span class="required"> * </span></label>
		<div class="input-icon right">
			<i class="fa fa-warning tooltips i-required"></i>
			<input type="text" class="form-control form-required">
		</div>
	</div>
	<div class="form-group">
        <label class="control-label">Label</label>
        <div class="radio-list radio-required">
            <label class="radio-inline">
                <input type="radio" name="radgender1"> Female </label>
        </div>
    </div>
**/
function checkElement(e,obj='',value=0)
{
	console.log(value);
	if(value == 'NULL'){
		value = '';
	}
	var res = 1;
	if(obj=='radio'){
		if(value == 1){
			e.parent().removeClass('has-error');
			res = 0;
		}else{
			e.parent().addClass('has-error');
			res = 0;
		}
	}else{
		if(e.val() == ''){
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
	return res;
}

$(document).ready(function() {
	console.log(1);
	// $('.i-required').hide();
	// if($('.loading-image').length > 0){
	// 	$('.loading-image').hide();
	//     $('.portlet-body').show();
	// }

	// $('form [type="text"].form-required').keyup(function(e) {
	// 	checkElement($(this), 'text');
	// });

	$('form select.form-required').change(function(e) {
		checkElement($(this));
	});

	// if($('form [type="radio"]').length > 0){
	// 	$('.radio-required').click(function() {
	// 		checkElement($(this), 'radio', $(this).find("input:radio:checked").length);
	// 	});
	// }

	$('form').submit(function(e) {
		e.preventDefault();
		// var resval = [];
		// $('[type="text"].form-required').each(function() {
		// 	resval.push(checkElement($(this), 'text'));
		// });

		// $('select.form-required').each(function() {
		// 	resval.push(checkElement($(this)));
		// });

		// $('.radio-required').each(function() {	
		// 	resval.push(checkElement($(this), 'radio', $(this).find("input:radio:checked").length));
		// });

		// resval = resval.slice(1);
		// if(resval.includes(1)){
		// 	console.log(resval);
		// 	e.preventDefault();
		// }
	});
});