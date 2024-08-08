function format_number(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function isValid(n) {
    var intRegex = /^\d+$/;
    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

    if(intRegex.test(n) || floatRegex.test(n)) {
       return true;
    }else{
        return false;
    }
}

$(document).ready(function() {
    $('#txtvl,#txtsl').on('keyup',function() {
        var vl = $('#txtvl').val() == '' ? 0 : $('#txtvl').val();
        var sl = $('#txtsl').val() == '' ? 0 : $('#txtsl').val();
        var amt_monetize = $('#txtamt_mone').val();
        var actual_sal = $('#txtactual_sal').val();
        var name = $(this).attr('name');

        amount_monetized = (parseFloat(vl) + parseFloat(sl)) * amt_monetize * actual_sal;
        $('#txtmone_amt').val(isNaN(amount_monetized) ? 'Invalid Leave Credits' : format_number(amount_monetized.toFixed(2)));

        var actual_vl = parseFloat($('#txtactual_vl').val());
        var actual_sl = parseFloat($('#txtactual_sl').val());
        var leave_valid = false;

        if(name == 'txtvl'){
            if(parseFloat($('#txtvl').val()) <= actual_vl){
                leave_valid = true;
            }else{
                leave_valid = false;
            }
        }else{
            if(parseFloat($('#txtsl').val()) <= actual_sl){
                leave_valid = true;
            }else{
                leave_valid = false;
            }
        }

        if($(this).val() != '' && isValid($(this).val()) && leave_valid == true){
            $(this).closest('div.form-group').removeClass('has-error');
            $(this).closest('div.form-group').addClass('has-success');
            $(this).closest('div.form-group').find('i.fa-warning').hide();
            $(this).closest('div.form-group').find('i.fa-check').show();
        }else{
            $(this).closest('div.form-group').addClass('has-error');
            $(this).closest('div.form-group').removeClass('has-success');
            $(this).closest('div.form-group').find('i.fa-warning').show();
            $(this).closest('div.form-group').find('i.fa-check').hide();
        }
    });

    $('#btnmonetized').on('click', function(e) {
        var arrerror= [];
        var actual_vl = parseFloat($('#txtactual_vl').val());
        var actual_sl = parseFloat($('#txtactual_sl').val());

        /* Check vl */
        if($('#txtvl').val() != '' && isValid($('#txtvl').val()) && parseFloat($('#txtvl').val()) <= actual_vl ){
            $('#txtvl').closest('div.form-group').removeClass('has-error');
            $('#txtvl').closest('div.form-group').addClass('has-success');
            $('#txtvl').closest('div.form-group').find('i.fa-warning').hide();
            $('#txtvl').closest('div.form-group').find('i.fa-check').show();
        }else{
            $('#txtvl').closest('div.form-group').addClass('has-error');
            $('#txtvl').closest('div.form-group').removeClass('has-success');
            $('#txtvl').closest('div.form-group').find('i.fa-warning').show();
            $('#txtvl').closest('div.form-group').find('i.fa-check').hide();
            arrerror.push(1);
        }

        /* Check sl */
        if($('#txtsl').val() != '' && isValid($('#txtsl').val()) && parseFloat($('#txtsl').val()) <= actual_sl ){
            $('#txtsl').closest('div.form-group').removeClass('has-error');
            $('#txtsl').closest('div.form-group').addClass('has-success');
            $('#txtsl').closest('div.form-group').find('i.fa-warning').hide();
            $('#txtsl').closest('div.form-group').find('i.fa-check').show();
        }else{
            $('#txtsl').closest('div.form-group').addClass('has-error');
            $('#txtsl').closest('div.form-group').removeClass('has-success');
            $('#txtsl').closest('div.form-group').find('i.fa-warning').show();
            $('#txtsl').closest('div.form-group').find('i.fa-check').hide();
            arrerror.push(1);
        }

        
        if(jQuery.inArray(1,arrerror) !== -1){
            e.preventDefault();
        }

    });

});