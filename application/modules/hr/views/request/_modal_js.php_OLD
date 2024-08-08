<script>
    $(document).ready(function() {
        $('#table-ob').on('click','a#printreport',function(){
            var req_details = $(this).data('rdetails');
            var obtype      = req_details[0];
            var reqdate     = $(this).data('rdate');
            var obdatefrom  = req_details[2];
            var obdateto    = req_details[3];
            var obtimefrom  = req_details[4];
            var obtimeto    = req_details[5];
            var desti       = req_details[6];
            var meal        = req_details[8];
            var purpose     = req_details[7];
            var empnum      = $(this).data('empnum');
            
            var link = "<?=base_url('employee/reports/generate/?rpt=reportOB')?>"+"&obtype="+obtype+"&reqdate="+reqdate+"&obdatefrom="+obdatefrom+"&obdateto="+obdateto+"&obtimefrom="+obtimefrom+"&obtimeto="+obtimeto+"&desti="+desti+"&meal="+meal+"&purpose="+purpose+"&empnum="+empnum;
            $('div#attachments').html('');
            var json_file = $(this).data('rattach');
            $('div#attachments').append('<ul>');
            if(json_file!=''){
                $.each( $(this).data('rattach'), function(i,file) {
                    var floc = "<?=base_url('"+ file.filepath +"')?>";
                    var fname = file.filename;
                    var ext = fname.split('.');
                    ext = ext[ext.length-1];
                    $('div#attachments').append('<li><a target="_blank" href="'+floc+'"><i class="fa fa-'+check_icon(ext)+'"> </i>&nbsp;'+ellipsisChar(fname, 30)+'</a></li>');
                });
            }
            $('div#attachments').append('</ul>');
                
            $('#ob-embed').attr('src',link);
            $('#ob-embed-fullview').attr('href',link);
            $('#ob-open-request').attr('href',"<?=base_url('employee/official_business/edit?module=hr&req_id=')?>"+$(this).data('id'));
            $('#ob-form').modal('show');
        });

        $('#table-ob').on('click', 'a#btncertify', function() {
            $('#upt-title').html('<b>Certify</b>');
            $('#frmupdate_ob').attr('action',"<?=base_url('hr/request/update_ob?req_id=')?>"+$(this).data('id'));
            $('#optstatus').val('CERTIFIED');
            $('#modal-update-ob').modal('show');
        });

        $('#table-ob').on('click', 'a#btndisapproved', function() {
            $('#upt-title').html('<b>DISAPPROVED</b>');
            $('#frmupdate_ob').attr('action',"<?=base_url('hr/request/update_ob?req_id=')?>"+$(this).data('id'));
            $('#optstatus').val('Disapproved');
            $('#modal-update-ob').modal('show');
        });
        
        // LEAVE
        $('#table-leave').on('click','a#printreport',function(){
            var req_details = $(this).data('rdetails');
            var leavetype      = req_details[0];
            var leavefrom  = req_details[1];
            var leaveto    = req_details[2];
            var day     = req_details[3];
            var signatory     = req_details[4];
            var signatory2     = req_details[5];
            var reason     = req_details[6];
            var incaseSL     = req_details[7];
            var incaseVL     = req_details[8];
            var daysapplied     = req_details[9];
            var intVL     = req_details[10];
            var intSL     = req_details[11];

            var link = "<?=base_url('employee/reports/generate/?rpt=reportLeave')?>"+"&leavetype="+leavetype+"&day="+day+"&leavefrom="+leavefrom+"&leaveto="+leaveto+"&daysapplied="+daysapplied+"&signatory="+signatory+"&signatory2="+signatory2+"&reason="+reason+"&incaseSL="+incaseSL+"&incaseVL="+incaseVL+"&intVL="+intVL+"&intSL="+intSL;

            $('div#attachments').html('');
            var json_file = $(this).data('rattach');
            $('div#attachments').append('<ul>');
            if(json_file!=''){
                $.each( $(this).data('rattach'), function(i,file) {
                    var floc = "<?=base_url('"+ file.filepath +"')?>";
                    var fname = file.filename;
                    var ext = fname.split('.');
                    ext = ext[ext.length-1];
                    $('div#attachments').append('<li><a target="_blank" href="'+floc+'"><i class="fa fa-'+check_icon(ext)+'"> </i>&nbsp;'+ellipsisChar(fname, 30)+'</a></li>');
                });
            }
            $('div#attachments').append('</ul>');
                
            $('#leave-embed').attr('src',link);
            $('#leave-embed-fullview').attr('href',link);
            $('#leave-open-request').attr('href',"<?=base_url('employee/leave/edit?module=hr&req_id=')?>"+$(this).data('id'));
            $('#leave-form').modal('show');
        });

        $('#table-leave').on('click', 'a#btncertify', function() {
            $('.div-remarks').hide();
            $('#leave-title').html('<b>Certify</b>');
            $('#lbl-leave-request').text('Are you sure you want to certify this request?');
            $('#frmupdate_leave').attr('action',"<?=base_url('hr/request/update_leave?req_id=')?>"+$(this).data('id'));
            $('#opt_leave_stat').val('CERTIFIED');
            $('#modal-update-leave').modal('show');
        });

        $('#table-leave').on('click', 'a#btndisapproved', function() {
            $('.div-remarks').show();
            $('#leave-title').html('<b>DISAPPROVED</b>');
            $('#lbl-leave-request').text('Are you sure you want to disapprove this request?');
            $('#frmupdate_leave').attr('action',"<?=base_url('hr/request/update_leave?req_id=')?>"+$(this).data('id'));
            $('#opt_leave_stat').val('Disapproved');
            $('#modal-update-leave').modal('show');
        });

        // TO
        $('#table-to').on('click','a#printreport',function(){
            var req_details = $(this).data('rdetails');
            var desti      = req_details[0];
            var todatefrom  = req_details[1];
            var todateto    = req_details[2];
            var purpose     = req_details[3];
            var meal     = req_details[4];
            var empno        = $(this).data('empno');


            var link = "";
            link = "<?=base_url('employee/reports/generate/?rpt=reportTO')?>"+"&desti="+desti+"&todatefrom="+todatefrom+"&todateto="+todateto+"&purpose="+purpose+"&meal="+meal+"&empno="+empno;

            $('div#attachments').html('');
            var json_file = $(this).data('rattach');
            $('div#attachments').append('<ul>');
            if(json_file!=''){
                $.each( $(this).data('rattach'), function(i,file) {
                    var floc = "<?=base_url('"+ file.filepath +"')?>";
                    var fname = file.filename;
                    var ext = fname.split('.');
                    ext = ext[ext.length-1];
                    $('div#attachments').append('<li><a target="_blank" href="'+floc+'"><i class="fa fa-'+check_icon(ext)+'"> </i>&nbsp;'+ellipsisChar(fname, 30)+'</a></li>');
                });
            }
            $('div#attachments').append('</ul>');

            $('#to-embed').attr('src',link);
            $('#to-embed-fullview').attr('href',link);

            $('#to-open-request').attr('href',"<?=base_url('employee/travel_order/edit?module=hr&req_id=')?>"+$(this).data('id'));
            $('#to-form').modal('show');
        });

        $("#to-form").on("hidden.bs.modal", function () {
            location.reload();
        });

        $('#table-to').on('click', 'a#btncertify', function() {
            $('.div-remarks').hide();
            $('#to-title').html('<b>Certify</b>');
            $('#lbl-to-request').text('Are you sure you want to certify this request?');
            $('#frmupdate_to').attr('action',"<?=base_url('hr/request/update_to?req_id=')?>"+$(this).data('id'));
            $('#opt_to_stat').val('CERTIFIED');
            $('#modal-update-to').modal('show');
        });

        $('#table-to').on('click', 'a#btndisapproved', function() {
            $('.div-remarks').show();
            $('#to-title').html('<b>DISAPPROVED</b>');
            $('#lbl-to-request').text('Are you sure you want to disapprove this request?');
            $('#frmupdate_to').attr('action',"<?=base_url('hr/request/update_to?req_id=')?>"+$(this).data('id'));
            $('#opt_to_stat').val('Disapproved');
            $('#modal-update-to').modal('show');
        });

        // PDS
        $('#table-pds').on('click','a#printreport',function(){
            var req_details = $(this).data('rdetails');
            var desti      = req_details[0];
            var todatefrom  = req_details[1];
            var todateto    = req_details[2];
            var purpose     = req_details[3];
            var meal     = req_details[4];

            var link = "<?=base_url('employee/reports/generate/?rpt=reportTO')?>"+"&desti="+desti+"&todatefrom="+todatefrom+"&todateto="+todateto+"&purpose="+purpose+"&meal="+meal;

            $('div#attachments').html('');
            var json_file = $(this).data('rattach');
            $('div#attachments').append('<ul>');
            if(json_file!=''){
                $.each( $(this).data('rattach'), function(i,file) {
                    var floc = "<?=base_url('"+ file.filepath +"')?>";
                    var fname = file.filename;
                    var ext = fname.split('.');
                    ext = ext[ext.length-1];
                    $('div#attachments').append('<li><a target="_blank" href="'+floc+'"><i class="fa fa-'+check_icon(ext)+'"> </i>&nbsp;'+ellipsisChar(fname, 30)+'</a></li>');
                });
            }
            $('div#attachments').append('</ul>');
            
            $('#pds-embed').attr('src',link);
            $('#pds-embed-fullview').attr('href',link);

            $('#pds-open-request').attr('href',"<?=base_url('employee/travel_order/edit?module=hr&req_id=')?>"+$(this).data('id'));
            $('#pds-form').modal('show');
        });

        // Monetization
        $('#table-mone').on('click','a#printreport',function(){

            var req_empno = $(this).data('empno');
            var link = "<?=base_url('employee/reports/generate/')?>"+req_empno+"?rpt=reportLeave&leavetype=monetization&day=Whole%20day&leavefrom=&leaveto=&daysapplied=&signatory=&empname=&reason=&incaseSL=&incaseVL=&signatory2=&intVL=&intSL=";

            $('#mone-embed').attr('src',link);
            $('#mone-embed-fullview').attr('href',link);

            $('#mone-open-request').attr('href',"<?=base_url('employee/leave_monetization/edit?module=hr&req_id=')?>"+$(this).data('id'));
            $('#mone-form').modal('show');
        });

        $('#table-mone').on('click', 'a#btncertify', function() {
            $('.div-remarks').hide();
            $('#mone-title').html('<b>Certify</b>');
            $('#lbl-mone-request').text('Are you sure you want to certify this request?');
            $('#frmupdate_mone').attr('action',"<?=base_url('hr/request/update_mone?req_id=')?>"+$(this).data('id'));
            $('#opt_mone_stat').val('CERTIFIED');
            $('#modal-update-mone').modal('show');
        });

        $('#table-mone').on('click', 'a#btndisapproved', function() {
            $('.div-remarks').show();
            $('#mone-title').html('<b>DISAPPROVED</b>');
            $('#lbl-mone-request').text('Are you sure you want to disapprove this request?');
            $('#frmupdate_mone').attr('action',"<?=base_url('hr/request/update_mone?req_id=')?>"+$(this).data('id'));
            $('#opt_mone_stat').val('Disapproved');
            $('#modal-update-mone').modal('show');
        });

        // DTR
        $('#table-dtr').on('click','a#printreport',function(){
            var req_details = $(this).data('rdetails');
            var req_empno = $(this).data('empno');
            var dtrupdate = req_details[1];
            var oldmorin  = req_details[2];
            var oldmorout = req_details[3];
            var oldafin   = req_details[4];
            var oldaftout = req_details[5];
            var oldOTin   = req_details[6];
            var oldOTout  = req_details[7];
            var morningin = req_details[8] +':'+req_details[9] +':'+req_details[10]+' '+req_details[11];
            var morningout= req_details[12]+':'+req_details[13]+':'+req_details[14]+' '+req_details[15];
            var aftnoonin = req_details[16]+':'+req_details[17]+':'+req_details[18]+' '+req_details[19];
            var aftnoonout= req_details[20]+':'+req_details[21]+':'+req_details[22]+' '+req_details[23];
            var OTtimein  = req_details[24]+':'+req_details[25]+':'+req_details[26]+' '+req_details[27];
            var OTtimeout = req_details[28]+':'+req_details[29]+':'+req_details[30]+' '+req_details[31];
            var month     = req_details[33];
            var evidence  = req_details[32];
            var reason    = req_details[34];
            var signatory = req_details[35];
            
            var link = "<?=base_url('employee/reports/generate/')?>"+req_empno+"?rpt=reportDTRupdate&dtrupdate="+dtrupdate+"&oldmorin="+oldmorin+"&oldmorout="+oldmorout+"&oldafin="+oldafin+"&oldaftout="+oldaftout+"&oldOTin="+oldOTin+"&oldOTout="+oldOTout+"&morningin="+morningin+"&morningout="+morningout+"&aftnoonin="+aftnoonin+"&aftnoonout="+aftnoonout+"&OTtimein="+OTtimein+"&OTtimeout="+OTtimeout+"&month="+month+"&evidence="+evidence+"&reason="+reason+"&signatory="+signatory;

            $('#dtr-embed').attr('src',link);
            $('#dtr-embed-fullview').attr('href',link);

            $('#dtr-open-request').attr('href',"<?=base_url('employee/update_dtr/edit?module=hr&req_id=')?>"+$(this).data('id'));
            $('#dtr-form').modal('show');
        });

        $('#table-dtr').on('click', 'a#btncertify', function() {
            $('.div-remarks').hide();
            $('#dtr-title').html('<b>Certify</b>');
            $('#lbl-dtr-request').text('Are you sure you want to certify this request?');
            $('#frmupdate_dtr').attr('action',"<?=base_url('hr/request/update_dtr?req_id=')?>"+$(this).data('id'));
            $('#opt_dtr_stat').val('CERTIFIED');
            $('#modal-update-dtr').modal('show');
        });

        $('#table-dtr').on('click', 'a#btndisapproved', function() {
            $('.div-remarks').show();
            $('#dtr-title').html('<b>DISAPPROVED</b>');
            $('#lbl-dtr-request').text('Are you sure you want to disapprove this request?');
            $('#frmupdate_dtr').attr('action',"<?=base_url('hr/request/update_dtr?req_id=')?>"+$(this).data('id'));
            $('#opt_dtr_stat').val('Disapproved');
            $('#modal-update-dtr').modal('show');
        });

        // CTO
        $('#table-cto').on('click','a#printreport',function(){
            var req_details = $(this).data('rdetails');
            var comleave = req_details[0];
            var am_in  = req_details[1];
            var am_out = req_details[2];
            var pm_in  = req_details[3];
            var pm_out = req_details[4];
            var purpose = req_details[5];
            
            var link = "<?=base_url('employee/reports/generate/')?>"+"?rpt=reportCL&comleave="+comleave+"&oldmorin="+am_in+"&oldmorout="+am_out+"&oldafin="+pm_in+"&oldafout="+pm_out+"&morningin="+"&morningout="+"&aftrnoonin="+"&aftrnoonout="+"&purpose="+purpose+"&reco="+"&approval=";

            $('#cto-embed').attr('src',link);
            $('#cto-embed-fullview').attr('href',link);
            $('#cto-form').modal('show');
        });

        $('#table-cto').on('click', 'a#btncertify', function() {
            $('.div-remarks').hide();
            $('#cto-title').html('<b>Certify</b>');
            $('#lbl-cto-request').text('Are you sure you want to certify this request?');
            $('#frmupdate_cto').attr('action',"<?=base_url('hr/request/update_cto?req_id=')?>"+$(this).data('id'));
            $('#opt_cto_stat').val('CERTIFIED');
            $('#modal-update-cto').modal('show');
        });

        $('#table-cto').on('click', 'a#btndisapproved', function() {
            $('.div-remarks').show();
            $('#cto-title').html('<b>DISAPPROVED</b>');
            $('#lbl-cto-request').text('Are you sure you want to disapprove this request?');
            $('#frmupdate_cto').attr('action',"<?=base_url('hr/request/update_cto?req_id=')?>"+$(this).data('id'));
            $('#opt_cto_stat').val('Disapproved');
            $('#modal-update-cto').modal('show');
        });
        
    });
</script>