function getrequest_status(stat)
{
    if(stat.toLowerCase() == "recommended" || stat.toLowerCase() == "recommend"){
        return "Recommend";
    }else if(stat.toLowerCase() == 'certified'){
        return 'Certify';
    }
}

$(document).ready(function() {
    $('#table-notif').dataTable( {
        "initComplete": function(settings, json) {
            $('.loading-image').hide();
            $('#table-notif').css('visibility', 'visible');
        },"columnDefs": [{ "orderable":false, "targets":'no-sort' }]} );

    $('#table-notif').on('click', 'a#btnview-details', function() {
        var data = $(this).data('json');
        var status = data['req_nextsign'].split(';');
        var details = data['req_details'].split(';');
        
        console.log(data);
        console.log(status[0]);
        console.log(details);
        $('.modal-title').html('<b>'+data['req_code']+'</b>');
        if(data['req_code'] == "Leave") {
            $('.txtreq_patient').hide();
            $('.txtreq_location').show();

            if(details[0] == 'SL'){
                $('.txtreq_patient').show();
            }

            if($.inArray(details[0],['PTL','FL','PL','SL','STL','MTL']) != -1){
                $('.txtreq_location').hide();
            }

            $('#txtreqid').val(data['req_id']);
            $('#txtreq_empno').val(data['req_emp']);
            $('#txtreq_empname').val(data['req_empname']);
            $('#txtreq_leave_type').val(details[0]);
            $('#txtreq_dfrom').val(details[2]);
            $('#txtreq_dto').val(details[3]);
            $('#txtreq_reason').val(details[4]);
            $('#txtreq_patient').val(details[0] == 'SL' ? (details[5].toLowerCase() == 'out' ? 'Out' : 'In') + ' Patient' : '');
            $('#txtreq_location').val(details[0] == 'VL' ? details[6] == 'local' ? 'Within-the-country' : 'Abroad' : '');


            $('select#selreq_stat').empty().append('<option value="'+status[0]+'">'+getrequest_status(status[0])+'</option>');
            $('select#selreq_stat').append('<option value="Disapproved">Disapprove</option>');
            $('select#selreq_stat').selectpicker('refresh');
            
            if(data['req_status'] == 'Cancelled'){
                $('#btncertify').hide();
                $('select#selreq_stat,#txtreq_location,#txtreq_comm,#txtreq_remarks').attr('disabled','disabled');
            }else{
                $('#btncertify').show();
                $('select#selreq_stat,#txtreq_location,#txtreq_comm,#txtreq_remarks').removeAttr('disabled');
                $('select#selreq_stat').selectpicker('refresh');
            }
            $('#txtleave_json').val(JSON.stringify(data));
            $('#request_leave').modal('show');
        }

        if(data['req_code'] == "OB") {
            $('#txtob_id').val(data['req_id']);
            $('#txtob_empno').val(data['req_emp']);
            $('#txtob_empname').val(data['req_empname']);
            $('#txtob_type').val(details[0]);
            $('#txtob_place').val(details[6]);
            $('#txtob_purpose').val(details[7]);
            if(details[9] == 'Y'){
                $('#txtob_wmeal').prop('checked',true);
            }else{
                $('#txtob_wmeal').prop('checked',false);
            }
            $('#txtob_dfrom').val(details[2]);
            $('#txtob_dto').val(details[3]);
            $('#txtob_time_in').val(details[4]);
            $('#txtob_time_out').val(details[5]);
            $('select#selob_stat').empty().append('<option value="'+status[0]+'">'+getrequest_status(status[0])+'</option>');
            $('select#selob_stat').append('<option value="Disapproved">Disapprove</option>');
            $('select#selob_stat').selectpicker('refresh');
            $('#txtob_json').val(JSON.stringify(data));
            $('#request_ob').modal('show');

            if(data['req_status'] == 'Cancelled'){
                $('#btnobcertify').hide();
                $('select#selob_stat,#txtreq_remarks').attr('disabled','disabled');
            }else{
                $('#btnobcertify').show();
                $('select#selob_stat,#txtreq_remarks').removeAttr('disabled');
                $('select#selob_stat').selectpicker('refresh');
            }
        }
        if(data['req_code'] == "DTR") {
            console.log(data);
            $('#txtdtr_id').val(data['req_id']);
            $('#txtdtr_empno').val(data['req_emp']);
            $('#txtdtr_empname').val(data['req_empname']);
            $('#txtdtr_json').val(JSON.stringify(data));

            $('#txtdtr_date').val(details[0]);
            $('#txtdtr_old_amin').val(details[2]);
            $('#txtdtr_old_amout').val(details[3]);
            $('#txtdtr_old_pmin').val(details[4]);
            $('#txtdtr_old_pmout').val(details[5]);
            $('#txtdtr_old_otin').val(details[6]);
            $('#txtdtr_old_otout').val(details[7]);
            $('#txtdtr_new_amin').val(details[8]);
            $('#txtdtr_new_amout').val(details[9]);
            $('#txtdtr_new_pmin').val(details[10]);
            $('#txtdtr_new_pmout').val(details[11]);
            $('#txtdtr_new_otin').val(details[12]);
            $('#txtdtr_new_otout').val(details[13]);

            $('#txtdtr_reason').val(details[14]);
            $('#txtdtr_evi').val(details[15]);

            $('select#seldtr_stat').empty().append('<option value="'+status[0]+'">'+getrequest_status(status[0])+'</option>');
            $('select#seldtr_stat').append('<option value="Disapproved">Disapprove</option>');
            $('select#seldtr_stat').selectpicker('refresh');

            $('#request_dtr').modal('show');
        }

        if(data['req_code'] == "TO") {
            $('#txtto_json').val(JSON.stringify(data));
            $('#txtto_id').val(data['req_id']);
            $('#txtto_empno').val(data['req_emp']);
            $('#txtto_empname').val(data['req_empname']);
            $('#txtto_desti').val(details[0]);
            $('#txtto_purpose').val(details[3]);
            if(details[7] == 'Y'){
                $('#txtto_wmeal').prop('checked',true);
            }else{
                $('#txtto_wmeal').prop('checked',false);
            }
            $('#txtto_dfrom').val(details[1]);
            $('#txtto_dto').val(details[2]);
            $('select#selto_stat').empty().append('<option value="'+status[0]+'">'+getrequest_status(status[0])+'</option>');
            $('select#selto_stat').append('<option value="Disapproved">Disapprove</option>');
            $('select#selto_stat').selectpicker('refresh');

            $('#request_to').modal('show');
        }

    });

});