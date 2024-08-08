<?php 
/** 
Purpose of file:    List page for User Account Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php load_plugin('css',array('datatables'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="javascript:;">Request</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>DTR Update</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
       &nbsp;
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> DTR Update</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn green dropdown-toggle" href="<?=base_url('employee/travel_order?status=All')?>" data-toggle="dropdown">
                            <i class="fa fa-<?=$notif_icon[$active_menu]?>"></i> &nbsp;<?=$active_menu == 'All' ? 'All Requests' : $active_menu?> <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <?php foreach($arrNotif_menu as $notif):?>
                                    <li>
                                        <a href="<?=base_url('employee/travel_order?status='.$notif)?>">
                                            <i class="fa fa-<?=$notif_icon[$notif]?>"></i> <?=$notif == 'All' ? 'All Requests' : $notif?> </a>
                                    </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-ob_request" style="display: none">
                <div class="table-dtrolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="<?=base_url('employee/update_dtr/add')?>"><button class="btn sbold blue"> <i class="fa fa-plus"></i> Add New Request
                                </button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-dtr">
                    <thead>
                        <tr>
                            <th style="width: 100px;text-align:center;"> No. </th>
                            <th style="text-align: center;"> Request Date </th>
                            <th style="text-align: center;"> Request Status </th>
                            <!-- <th style="text-align: center;"> Update Month </th> -->
                            <th class="no-sort" style="text-align: center;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach($arrdtr_request as $row): $req_details = explode(';',$row['requestDetails']);?>
                        <tr class="odd gradeX">
                            <td align="center"> <?=$i++?> </td>
                            <td align="center"> <?=$row['requestDate']?> </td>
                            <td align="center"> <?=$row['requestStatus']?> </td>
                            <!-- <td align="center"> <?=isset($req_details[33]) ? date('F', mktime(0, 0, 0, $req_details[33], 10)) : ''?> </td> -->
                            <td width="150px" style="white-space: nowrap;text-align: center;">
                                <a class="btn btn-sm grey-cascade" id="printreport" data-rdate="<?=$row['requestDate']?>"
                                    data-rdetails='<?=json_encode($req_details)?>' data-rattach='<?=$row['file_location']?>'>
                                    <span class="icon-magnifier" title="View"></span> Print Preview</a>
                                <?php if(strtolower($row['requestStatus']) == 'filed request'): ?>
                                    <a class="btn btn-sm green" href="<?=base_url('employee/update_dtr/edit?req_id='.$row['requestID'])?>">
                                        <span class="fa fa-edit" title="Edit"></span> Edit</a>
                                    <a class="btn btn-sm btn-danger leave-cancel" data-id="<?=$row['requestID']?>">
                                        <span class="icon-close" title="Cancel"></span> Cancel</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<!-- begin ob travel pass modal -->
<div id="dtr-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Confirmation Slip</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed src="" id="dtr-embed" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="attachments"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="dtr-embed-fullview" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end ob travel pass modal -->

<!-- begin ob cancel modal -->
<div id="leave-cancel" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Cancel Request</h4>
            </div>
            <?=form_open('employee/update_dtr/cancel', array('id' => 'frmdtr_attach'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtdtr_req_id" id="txtdtr_req_id">
                            <div class="form-group">
                                <label>Are you sure you want to cancel this request?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-adj-delete" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end ob cancel modal -->

<?php load_plugin('js',array('form_validation','datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-dtr').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#div-ob_request').show();
            }} );

        $('#table-dtr').on('click','a#printreport',function(){
            var req_details = $(this).data('rdetails');
            for (var i = req_details.length - 1; i >= 0; i--) {
                req_details[i] = req_details[i].replace(" AM", "");
            }
            var dtrupdate = req_details.length > 1 ? req_details[1] : '';
            var oldmorin  = req_details.length > 2 ? req_details[2] : '';
            var oldmorout = req_details.length > 3 ? req_details[3] : '';
            var oldafin   = req_details.length > 4 ? req_details[4] : '';
            var oldaftout = req_details.length > 5 ? req_details[5] : '';
            var oldOTin   = req_details.length > 6 ? req_details[6] : '';
            var oldOTout  = req_details.length > 7 ? req_details[7] : '';
            var morningin = req_details.length > 11 ? [req_details[8],req_details[9],req_details[10],req_details[11]].join(':') : '';
            var morningout= req_details.length > 15 ? [req_details[12],req_details[13],req_details[14],req_details[15]].join(':') : '';
            var aftnoonin = req_details.length > 19 ? [req_details[16],req_details[17],req_details[18],req_details[19]].join(':') : '';
            var aftnoonout= req_details.length > 23 ? [req_details[20],req_details[21],req_details[22],req_details[23]].join(':') : '';
            var OTtimein  = req_details.length > 27 ? [req_details[24],req_details[25],req_details[26],req_details[27]].join(':') : '';
            var OTtimeout = req_details.length > 31 ? [req_details[28],req_details[29],req_details[30],req_details[31]].join(':') : '';
            var reason    = req_details.length > 32 ? req_details[32] : '';
            var month     = req_details.length > 33 ? req_details[33] : '';
            var evidence  = req_details.length > 34 ? req_details[34] : '';
            var signatory = req_details.length > 35 ? req_details[35] : '';
            
            var link = "<?=base_url('employee/reports/generate/?rpt=reportDTRupdate')?>"+"&dtrupdate="+dtrupdate+"&oldmorin="+oldmorin+"&oldmorout="+oldmorout+"&oldafin="+oldafin+"&oldaftout="+oldaftout+"&oldOTin="+oldOTin+"&oldOTout="+oldOTout+"&morningin="+morningin+"&morningout="+morningout+"&aftnoonin="+aftnoonin+"&aftnoonout="+aftnoonout+"&OTtimein="+OTtimein+"&OTtimeout="+OTtimeout+"&month="+month+"&evidence="+evidence+"&reason="+reason+"&signatory="+signatory;
            $('#dtr-embed').attr('src',link);
            $('#dtr-embed-fullview').attr('href',link);
            $('#dtr-form').modal('show');
        });

        $('#table-dtr').on('click', 'a.leave-cancel', function() {
            $('#txtdtr_req_id').val($(this).data('id'));
            $('#leave-cancel').modal('show');
        });
    });
</script>