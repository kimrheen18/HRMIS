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
            <span>Official Business</span>
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
                    <span class="caption-subject bold uppercase"> Official Business</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn green dropdown-toggle" href="<?=base_url('employee/official_business?status=All')?>" data-toggle="dropdown">
                            <i class="fa fa-<?=$notif_icon[$active_menu]?>"></i> &nbsp;<?=$active_menu == 'All' ? 'All Requests' : $active_menu?> <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <?php foreach($arrNotif_menu as $notif):?>
                                    <li>
                                        <a href="<?=base_url('employee/official_business?status='.$notif)?>">
                                            <i class="fa fa-<?=$notif_icon[$notif]?>"></i> <?=$notif == 'All' ? 'All Requests' : $notif?> </a>
                                    </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-ob_request" style="display: none">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="<?=base_url('employee/official_business/add')?>"><button class="btn sbold blue"> <i class="fa fa-plus"></i> Add New Request
                                </button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-ob">
                    <thead>
                        <tr>
                            <th style="width: 100px;text-align:center;"> No. </th>
                            <th style="text-align: center;"> Request Date </th>
                            <th style="text-align: center;"> Request Status </th>
                            <th style="text-align: center;"> OB Date </th>
                            <th style="text-align: center;"> OB Time </th>
                            <th> Destination </th>
                            <th> Purpose </th>
                            <th class="no-sort" style="text-align: center;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; foreach($arrob_request as $row): $req_details = explode(';',$row['requestDetails']);?>
                        <tr class="odd gradeX">
                            <td align="center"> <?=$i++?> </td>
                            <td align="center"> <?=$row['requestDate']?> </td>
                            <td align="center"> <?=$row['requestStatus']?> </td>
                            <td align="center" nowrap>
                                <?php
                                    if($req_details[2]!='' && $req_details[3]!=''):
                                        echo date('M. d, Y',strtotime($req_details[2])).' <b>to</b> '.date('M. d, Y',strtotime($req_details[3]));
                                    else:
                                        echo $req_details[2]!=''?date('M. d, Y',strtotime($req_details[2])):'';
                                        echo $req_details[3]!=''?date('M. d, Y',strtotime($req_details[3])):'';
                                    endif;
                                ?></td>
                            <td align="center" nowrap>
                                <?php
                                    if($req_details[4]!='' && $req_details[5]!=''):
                                        echo date('h:i A',strtotime($req_details[4])).' <b>to</b> '.date('h:i A',strtotime($req_details[5]));
                                    else:
                                        echo $req_details[4]!=''?date('h:i A',strtotime($req_details[4])):'';
                                        echo $req_details[5]!=''?date('h:i A',strtotime($req_details[5])):'';
                                    endif;
                                ?></td>
                            <td>
                                <?php
                                    if(strlen($req_details[5]) > 30):
                                        echo '<span class="ellipsis">'.substr($req_details[5], 0, 30).' ...</span>
                                              <span class="fulltext" style="display: none;">'.$req_details[5].'</span>&nbsp;&nbsp;
                                              <a class="showmore small" href="javascript:;"><u>show more</u></a>
                                              <a class="showless small" href="javascript:;" style="display: none;"><u>show less</u></a>';
                                    else:
                                        echo $req_details[5];
                                    endif; ?></td>
                            <td>
                                <?php
                                    if(strlen($req_details[7]) > 30):
                                        echo '<span class="ellipsis">'.substr($req_details[7], 0, 30).' ...</span>
                                              <span class="fulltext" style="display: none;">'.$req_details[7].'</span>&nbsp;&nbsp;
                                              <a class="showmore small" href="javascript:;"><u>show more</u></a>
                                              <a class="showless small" href="javascript:;" style="display: none;"><u>show less</u></a>';
                                    else:
                                        echo $req_details[7];
                                    endif; ?></td>
                            <td width="150px" style="white-space: nowrap;text-align: center;">
                                <a class="btn btn-sm grey-cascade" id="printreport" data-rdate="<?=$row['requestDate']?>"
                                    data-rdetails='<?=json_encode($req_details)?>' data-rattach='<?=$row['file_location']?>'>
                                    <span class="icon-magnifier" title="View"></span> Print Preview</a>
                                <?php if(strtolower($row['requestStatus']) == 'filed request'): ?>
                                    <a class="btn btn-sm green" href="<?=base_url('employee/official_business/edit?req_id='.$row['requestID'])?>">
                                        <span class="fa fa-edit" title="Edit"></span> Edit</a>
                                    <a class="btn btn-sm btn-danger ob-cancel" data-id="<?=$row['requestID']?>">
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
<div id="ob-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Personnel Travel Pass</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed src="" id="ob-embed" frameborder="0" width="100%" height="500px">
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
                <a href="" id="ob-embed-fullview" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end ob travel pass modal -->

<!-- begin ob cancel modal -->
<div id="ob-cancel" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Attachment</h4>
            </div>
            <?=form_open('employee/official_business/cancel', array('id' => 'frmob_attach'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtob_req_id" id="txtob_req_id">
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
        $('#table-ob').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#div-ob_request').show();
            }} );

        /* ellipsis*/
        $('#table-ob').on('click', 'a.showmore', function() {
            $(this).closest('td').find('.fulltext,a.showless').show();
            $(this).prev().prev('.ellipsis').hide();
            $(this).hide();
        });
        $('#table-ob').on('click', 'a.showless', function() {
            $(this).closest('td').find('.ellipsis,a.showmore').show();
            $(this).closest('td').find('.fulltext').hide();
            $(this).hide();
        });

        $('#table-ob').on('click','a#printreport',function(){
            var req_details = $(this).data('rdetails');
            var obtype      = req_details[0];
            var reqdate     = $(this).data('rdate');
            var obdatefrom  = req_details[1];
            var obdateto    = req_details[2];
            var obtimefrom  = req_details[3];
            var obtimeto    = req_details[4];
            var desti       = req_details[5];
            var meal        = req_details[6];
            var purpose     = req_details[7];

            var link = "<?=base_url('employee/reports/generate/?rpt=reportOB')?>"+"&obtype="+obtype+"&reqdate="+reqdate+"&obdatefrom="+obdatefrom+"&obdateto="+obdateto+"&obtimefrom="+obtimefrom+"&obtimeto="+obtimeto+"&desti="+desti+"&meal="+meal+"&purpose="+purpose;
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
            $('#ob-form').modal('show');
        });

        $('#table-ob').on('click', 'a.ob-cancel', function() {
            $('#txtob_req_id').val($(this).data('id'));
            $('#ob-cancel').modal('show');
        });
    });
</script>