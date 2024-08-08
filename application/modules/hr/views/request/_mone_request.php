<div class="pull-right" style="margin-top: -15px;margin-bottom: 15px;">
    <div class="btn-group">
        <a class="btn green dropdown-toggle" href="<?=base_url('hr/request?status=All'.'&request='.$_GET['request'])?>" data-toggle="dropdown">
            <i class="fa fa-<?=$notif_icon[$active_menu]?>"></i> &nbsp;<?=$active_menu == 'All' ? 'All Requests' : $active_menu?> <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu pull-right">
            <?php foreach($arrNotif_menu as $notif):?>
                    <li>
                        <a href="<?=base_url('hr/request?status='.$notif.'&request='.$_GET['request'])?>">
                            <i class="fa fa-<?=$notif_icon[$notif]?>"></i> <?=$notif == 'All' ? 'All Requests' : $notif?> </a>
                    </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-mone">
    <thead>
        <tr>
            <th style="width: 100px;text-align:center;"> No. </th>
            <th style="text-align: center;"> Employee </th>
            <th style="text-align: center;"> Request Date </th>
            <th style="text-align: center;"> Request Status </th>
            <?php if(isset($_GET['status'])): if($_GET['status']=='Disapproved'): ?>
                <th style="text-align: center;"> Remarks </th>
            <?php endif; endif; ?>
            <th style="text-align: center;"> Request Destination </th>
            <th class="no-sort" style="text-align: center;"> Actions </th>
        </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($arrmone_request as $row): $req_details = explode(';',$row['requestDetails']);?>
        <tr class="odd gradeX">
            <td align="center"> <?=$i++?> </td>
            <td> <?=employee_name($row['empNumber'])?> </td>
            <td align="center"> <?=$row['requestDate']?> </td>
            <td align="center"> <?=$row['requestStatus']?> </td>
            <?php if(isset($_GET['status'])): if($_GET['status']=='Disapproved'): ?>
                <td align="center"> <?=$row['remarks']?> </td>
            <?php endif; endif; ?>
            <td align="center"> <?=$row['next_signatory']['next_sign']?> </td>
            <td width="150px" style="white-space: nowrap;text-align: center;">
                <a class="btn btn-sm grey-cascade" id="printreport" data-rdate="<?=$row['requestDate']?>" data-id="<?=$row['requestID']?>"
                    data-rdetails='<?=json_encode($req_details)?>' data-empno='<?=$row['empNumber']?>'>
                    <span class="icon-magnifier" title="View"></span> Print Preview</a>
                <?php if(strtolower($row['requestStatus']) == 'filed request'): ?>
                    <a class="btn btn-sm blue" id="btncertify" data-id="<?=$row['requestID']?>"><span class="icon-check"></span> Certify</a>
                    <a class="btn btn-sm btn-danger" id="btndisapproved" data-id="<?=$row['requestID']?>"><span class="icon-close" title="Cancel"></span> Disapprove</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<!-- begin mone pass modal -->
<div id="mone-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Leave Monetization Form</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed src="" id="mone-embed" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" id="mone-open-request" class="btn green btn-sm"> <i class="icon-doc"> </i> Open Request</a>
                <a href="javascript:;" id="mone-embed-fullview" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end mone pass modal -->

<!-- begin mone certify modal -->
<div id="modal-update-mone" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="mone-title"></h4>
            </div>
            <?=form_open('', array('id' => 'frmupdate_mone'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="opt_mone_stat" id="opt_mone_stat">
                            <div class="form-group">
                                <label id="lbl-mone-request">Are you sure you want to certify this request?</label>
                            </div>
                            <div class="form-group div-remarks">
                                <label>Remarks</label>
                                <textarea class="form-control" name="txtremarks"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end mone certify modal -->

<script>
    $(document).ready(function() {
        $('#table-mone').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#request_view').show();
            }} );
    });
</script>