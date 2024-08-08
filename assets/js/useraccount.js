$(document).ready(function() {
    // FormValidation.init();
    // $('div.hr-officer,div.finance-officer').css('display','none');
    // $('#HR2,#Finance2').hide();

    $('#strAccessLevel').on('change',function() {
    	var select_access = $(this).val();
        console.log(select_access);
        $('div.hr-officer,div.finance-officer').css('display','none');
        $('#HR2').hide();

        if(select_access == 1){
            $('div.hr-officer').show();
        }

        if(select_access == 2){
            $('div.finance-officer').show();
        }
    });

    $('#chkhrmo').click(function() {
        $('#HR2').hide();
    });

    $('#chkassistant').click(function() {
        $('#HR2').show();
    });

    $('#chkfoall').click(function() {
        $('#Finance2').hide();
    });

    $('#chkfoass').click(function() {
        $('#Finance2').show();
    });

    $('#chkchangePassword').click(function(e) {
        if($(this).prop('checked')){
            $('#divchangePassword').css('display','block');
            $('#strPassword').attr('required', 'required');
        }else{
            $('#divchangePassword').css('display','none');
            $('#strPassword').removeAttr('required');
        }
    });

});