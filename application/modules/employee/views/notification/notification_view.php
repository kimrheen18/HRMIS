<?php load_plugin('css',array('datatables'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?=strtolower($this->uri->segment(1)) == 'employee' ? 'Employee' : 'HR' ?> Module</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Notification</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<br>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <i class="icon-bell"></i> Notification</span>
                </div>
            </div>
            
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <div style="display: inline-flex;">
                            <div class="legend-def1">
                                <div class="legend-dd1" style="background-color: #ffffb0;"></div> &nbsp;<small style="margin-left: 10px;">Disapproved</small> &nbsp;&nbsp;</div>
                            <div class="legend-def1">
                                <div class="legend-dd1" style="background-color: #ffc0cb;"></div> &nbsp;<small style="margin-left: 10px;">Cancelled</small> &nbsp;&nbsp;</div>
                        </div>
                        <br><br>
                        <table class="table table-striped table-bordered table-hover" id="table-notif" style="visibility: hidden;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;width:50px;">No</th>
                                    <th style="text-align: center;width:150px;"> Request Date </th>
                                    <th style="text-align: center;width:100px;"> Request Type </th>
                                    <th style="text-align: center;width:150px;"> Request Status </th>
                                    <th style="text-align: center;"> Remarks </th>
                                    <th> Destination </th>
                                    <th style="width:50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrRequest as $request): ?>
                                    <tr class="<?=strtolower($request['req_status']) == 'cancelled'? 'cancelled':''?> <?=strtolower($request['req_status']) == 'disapproved'? 'disapproved':''?>">
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$request['req_date']?></td>
                                        <td align="center"><?=$request['req_type']?></td>
                                        <td align="center"><?=$request['req_status']?></td>
                                        <td align="center"><?=$request['req_remarks']?></td>
                                        <td><?=$request['req_nextsign']?></td>
                                        <td nowrap style="vertical-align: middle;text-align: left;">
                                            <a href="javascript:;" class="btn btn-sm blue" id="btnview"
                                                data-type="<?=$request['req_type']?>" data-json='<?=json_encode($request)?>'>
                                                <i class="icon-magnifier"></i> View </a>
                                            <?php if(!in_array(strtolower($request['req_status']), array('cancelled', 'disapproved','certified'))): ?>
                                                <button data-id="<?=$request['req_id']?>" class="btn btn-sm red btn-cancel"> <i class="icon-close"></i> Cancel </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="modal-cancelRequest" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Cancel Request</h4>
            </div>
            <?=form_open('employee/requests/cancel_request', array('id' => 'frmcancel_request'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtreqid" id="txtreqid">
                            <div class="form-group">
                                <label>Are you sure you want to cancel this request?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-payrollDetails" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<!-- begin print-preview modal -->
<div id="print-request-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" value="<?=base_url()?>" id="txtbaseurl">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed id="embed-pdf" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="link-fullsize" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end print-preview modal -->

<?php load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        var replink = "";

        $('#table-notif').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-notif').css('visibility', 'visible');
            }} );
        $('#table-notif').on('click', 'button.btn-cancel', function() {
            $('#txtreqid').val($(this).data('id'));
            $('#modal-cancelRequest').modal('show');
        });

        $('#table-notif').on('click', 'a#btnview', function() {
            json = $(this).data('json');
            console.log(json);
            type = $(this).data('type');
            if(json.req_code=='OB'){
                ob_details = json.req_details.split(';');
                replink = 'employee/reports/generate/?rpt=reportOB&obtype='+ ob_details[0] +'&reqdate='+ json.req_date +'&obdatefrom='+ ob_details[2] +'&obdateto='+ ob_details[3] +'&obtimefrom='+ ob_details[4] +'&obtimeto='+ ob_details[5] +'&desti='+ ob_details[6] +'&meal='+ ob_details[9] +'&purpose='+ ob_details[7];
            }
            if(json.req_code=='TO'){
                to_details = json.req_details.split(';');
                replink = 'employee/reports/generate/?rpt=reportTO&desti='+ to_details[0] +'&todatefrom='+ json.req_date +'&todateto='+ to_details[2] +'&purpose='+ to_details[3] +'&strMeal='+ to_details[4] +'&meal='+ to_details[5];
            }
            if(json.req_code=='Leave'){
                leave_details = json.req_details.split(';');
                replink = 'employee/reports/generate/?rpt=reportLeave&leavetype='+ leave_details[0] +'&day='+ leave_details[8] +'&leavefrom='+ leave_details[2] +'&leaveto='+ leave_details[3] +'&daysapplied=&signatory=&signatory2=0315-CO0-2012&empname=undefined&reason='+ leave_details[4] +'&incaseSL=&incaseVL=&intVL='+ leave_details[9] +'&intSL='+ leave_details[10] +'';
            }
            if(json.req_code=='DTR'){
                dtr_details = json.req_details.split(';');
                replink = 'employee/reports/generate/?rpt=reportDTRupdate&dtrupdate='+ dtr_details[1] +'&oldmorin='+ dtr_details[2] +'&oldmorout='+ dtr_details[3] +'&oldafin='+ dtr_details[4] +'&oldaftout='+ dtr_details[5] +'&oldOTin='+ dtr_details[6] +'&oldOTout='+ dtr_details[7] +'&morningin=&morningout=&aftnoonin=&aftnoonout=&OTtimein=&OTtimeout=&month=sdf&evidence=asdf&reason='+ dtr_details[32] +'&signatory=JO-06-2016';
            }
            if(json.req_code=='CL'){
                cl_details = json.req_details.split(';');
                replink = 'employee/reports/generate/?rpt=reportCL&comleave='+ cl_details[1] +'&morningin='+ cl_details[2] +'&morningout='+ cl_details[3] +'&aftrnoonin='+ cl_details[4] +'&aftrnoonout='+ cl_details[5] +'&purpose='+ cl_details[6] +'&reco='+ cl_details[7] +'&approval='+ cl_details[8];
            }


            $('.modal-title').html(type);
            $('#print-request-modal').modal('show');
            $('#embed-pdf,#link-fullsize').attr('src',$('#txtbaseurl').val()+replink);
        });

        $('#link-fullsize').click(function() {
            window.open($(this).attr('src'));
        });
    });
</script>

<script>
$(document).ready(function() {

    // $('#btnprint-reports').click(function() {
    //     var reptype = $('#selrep_type').val();
    //     var replink = "";
    //     var getdata = "empno=" + $('#selname').val() + "&rtype=2" + "&remitt=" + $('#remitType').val() + "&month=" + "&ps_yr=" + "&remit_fr=" + $('#remityrfrom').val() + "&remit_to=" + $('#remityrto').val() + "&pgroup=" + "&file_gen=" + $('#selgen').val() + "&period=" + "&sign=" + "&appt=" + $('#selAppoint').val();
    //     replink = "finance/reports/monthlyreports/remittances?"+getdata;
    //     $('.modal-title').html('Remittance');
    //     $('#print-preview-modal').modal('show');
    //     $('#embed-pdf,#link-fullsize').attr('src',$('#txtbaseurl').val()+replink);
    // });

    // $('#link-fullsize').click(function() {
    //     window.open($(this).attr('src'));
    // });

});
</script>