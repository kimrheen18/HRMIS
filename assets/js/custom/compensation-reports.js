$(document).ready(function() {
    $('#table-hazards').dataTable();
    $('.date-picker').datepicker( {
        format: 'yyyy',
        viewMode: 'years',
        minViewMode: 'years'
    });

    $('#txtps_yr').on('changeDate', function(){
        window.open('?month='+$('#selmont').val()+'&yr='+$('#txtps_yr').val(),'_self');
        $(this).datepicker('hide');
    });
    $('#selmont').on('change', function(){
        window.open('?month='+$('#selmont').val()+'&yr='+$('#txtps_yr').val(),'_self');
    });
    $('#selpayrollGrp').on('change', function(){
        $('#period-codes').html('');
        if($(this).find(':selected').attr('data-appt') == 'P'){
            $('#period-codes').html($(this).find(':selected').attr('data-codes'));
        }
    });

    $('#selrep_type').on('change',function() {
        var reptype = $(this).val();
        if(reptype == 1){
            // Payslip
            $('.div-remittances,.div-yrrange,.div-generate').hide()
            $('.div-month,.div-yr,.div-period').show()
        }else{
            // Remittances
            $('.div-month,.div-yr,.div-period').hide()
            $('.div-remittances,.div-yrrange,.div-generate').show()
        }
    });

    $('#btnprint').click(function() {
        var reptype = $('#selrep_type').val();
        var replink = "";
        var getdata = "empno=" + $('#txtempnumber').val() + "&rtype=" + $('#selrep_type').val() + "&remitt=" + $('#selrep_remitt').val() + "&month=" + $('#selmont').val() + "&ps_yr=" + $('#txtps_yr').val() + "&remit_fr=" + $('#txtremit_from').val() + "&remit_to=" + $('#txtremit_to').val() + "&pgroup=" + $('#selpayrollGrp').val() + "&file_gen=" + $('#selgen').val() + "&period=" + $('#selpayrollGrp').find(':selected').attr('data-period') + "&sign=" + $('#selsign').val() + "&appt=";
        if(reptype == 1){
            report_name = "Payslip";
            replink = "finance/reports/MonthlyReports/payslip?"+getdata;
        }else if(reptype == 2){
            report_name = "Remittance";
            replink = "finance/reports/MonthlyReports/remittances?"+getdata;
        }
        $('.modal-title').html(report_name);
        if(reptype == 1 || (reptype == 2 && $('#selgen').val() == 1)){
            $('#print-preview-modal').modal('show');
        }else{
            // alert('download excel');
        }
        $('#embed-pdf,#link-fullsize').attr('src',$('#txtbaseurl').val()+replink);
    });

    $('#btnprint-reports').click(function() {
        var reptype = $('#selrep_type').val();
        var replink = "";
        var getdata = "empno=" + $('#selname').val() + "&rtype=2" + "&remitt=" + $('#remitType').val() + "&month=" + "&ps_yr=" + "&remit_fr=" + $('#remityrfrom').val() + "&remit_to=" + $('#remityrto').val() + "&pgroup=" + "&file_gen=" + $('#selgen').val() + "&period=" + "&sign=" + "&appt=" + $('#selAppoint').val();
        replink = "finance/reports/MonthlyReports/remittances?"+getdata;
        $('.modal-title').html('Remittance');
        $('#print-preview-modal').modal('show');
        $('#embed-pdf,#link-fullsize').attr('src',$('#txtbaseurl').val()+replink);
    });

    $('#link-fullsize').click(function() {
        window.open($(this).attr('src'));
    });

});