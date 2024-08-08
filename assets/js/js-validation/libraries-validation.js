function checkElement(e, obj=""){
	var res = 1;
	console.log(e);
	if(e.val() == ''){
		e.parent().parent().addClass('has-error');
		e.prev("i").attr('data-original-title', "This field is required.");
		e.prev("i").show();
		res = 1;
	}else{
		if(obj == 'input'){
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
	return res;
}

$(document).ready(function() {
	$('.loading-image').hide();
    $('.portlet-body').show();
    
 //    // Deduction Agency
	// var resval = [];

	// $('#agency-code').keyup(function(){
 //        resval['agency-code'] = checkElement($('#agency-code'), 'input');
 //    });

 //    $('#agency-desc').keyup(function(){
 //        resval['agency-desc'] = checkElement($('#agency-desc'), 'input');
 //    });

 //    $('#acct-code').keyup(function(){
 //        resval['acct-code'] = checkElement($('#acct-code'), 'input');
 //    });

	// $('#btn_add_agency').click(function(e) {
	// 	resval['agency-code'] = checkElement($('#agency-code'), 'input');
	// 	resval['agency-desc'] = checkElement($('#agency-desc'), 'input');
	// 	resval['acct-code'] = checkElement($('#acct-code'), 'input');
		
	// 	var cont = 0;
 //        for(var key in resval){ if(resval[key] == 1){ cont = 1; break; }}
 //        if(cont == 1){
 //            e.preventDefault();
 //        }
	// });


	// // Deduction
	// var resdedct = [];

	// $('#selAgency').change(function(){
 //        resdedct['agency'] = checkElement($('#selAgency'), '');
 //    });

 //    $('#txtddcode').keyup(function(){
 //        resdedct['code'] = checkElement($('#txtddcode'), 'input');
 //    });

 //    $('#txtdesc').keyup(function(){
 //        resdedct['desc'] = checkElement($('#txtdesc'), 'input');
 //    });

 //    $('#txtacctcode').keyup(function(){
 //        resdedct['acctCode'] = checkElement($('#txtacctcode'), 'input');
 //    });

 //    $('#seltype').change(function(){
 //        resdedct['type'] = checkElement($('#seltype'), '');
 //    });

 //    $('#btn_add_deduction').click(function(e) {
	// 	resdedct['agency'] = checkElement($('#selAgency'), '');
	// 	resdedct['code'] = checkElement($('#txtddcode'), 'input');
	// 	resdedct['desc'] = checkElement($('#txtdesc'), 'input');
	// 	resdedct['acctCode'] = checkElement($('#txtacctcode'), 'input');
	// 	resdedct['type'] = checkElement($('#seltype'), '');

	// 	var cont = 0;
 //        for(var key in resdedct){ if(resdedct[key] == 1){ cont = 1; break; }}
 //        if(cont == 1){
 //            e.preventDefault();
 //        }
	// });


 //    // Income
 //    var resincome = [];
 //    $('#txtinccode').keyup(function(){
 //        resincome['code'] = checkElement($('#txtinccode'), 'input');
 //    });

 //    $('#txtincdesc').keyup(function(){
 //        resincome['desc'] = checkElement($('#txtincdesc'), 'input');
 //    });

 //    $('#selinctype').change(function(){
 //        resincome['type'] = checkElement($('#selinctype'), '');
 //    });

 //    $('#btn_add_income').click(function(e) {
 //    	resincome['code'] = checkElement($('#txtinccode'), 'input');
 //    	resincome['desc'] = checkElement($('#txtincdesc'), 'input');
 //    	resincome['type'] = checkElement($('#selinctype'), '');

 //    	var cont = 0;
 //        for(var key in resincome){ if(resincome[key] == 1){ cont = 1; break; }}
 //        if(cont == 1){
 //            e.preventDefault();
 //        }
 //    });




    
    $('form').submit(function(e) {
    	var valres = [];
    	e.preventDefault();
    	$('[type="text"].form-control').each(function() {
    		valres.push(checkElement($(this), 'input'));
    	});
    	// valres.push(checkElement($('[type="text"].form-control'), 'input'));
    	console.log(valres);
    	// var cont = 0;
     //    for(var key in valres){ if(valres[key] == 1){ cont = 1; break; }}
     //    if(cont == 1){
            
     //    }	
    });

});