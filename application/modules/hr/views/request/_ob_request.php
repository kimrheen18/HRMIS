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
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-ob">
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
            <th style="text-align: center;"> OB Date </th>
            <th style="text-align: center;"> OB Time </th>
            <th> OB Destination </th>
            <th> OB Purpose </th>
            <th class="no-sort" style="text-align: center;"> Actions </th>
        </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($arrob_request as $row): $req_details = explode(';',$row['requestDetails']);?>
        <tr class="odd gradeX">
            <td align="center"> <?=$i++?> </td>
            <td> <?=employee_name($row['empNumber'])?> </td>
            <td align="center"> <?=$row['requestDate']?> </td>
            <td align="center"> <?=$row['requestStatus']?> </td>
            <?php if(isset($_GET['status'])): if($_GET['status']=='Disapproved'): ?>
                <td align="center"> <?=$row['remarks']?> </td>
            <?php endif; endif; ?>
            <td align="center"> <?=$row['next_signatory']['next_sign']?> </td>
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
                    if(strlen($req_details[6]) > 30):
                        echo '<span class="ellipsis">'.substr($req_details[6], 0, 30).' ...</span>
                              <span class="fulltext" style="display: none;">'.$req_details[6].'</span>&nbsp;&nbsp;
                              <a class="showmore small" href="javascript:;"><u>show more</u></a>
                              <a class="showless small" href="javascript:;" style="display: none;"><u>show less</u></a>';
                    else:
                        echo $req_details[6];
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
                <a class="btn btn-sm grey-cascade" id="printreport" data-rdate="<?=$row['requestDate']?>" data-empnum="<?=$row['empNumber']?>" data-id="<?=$row['requestID']?>"
                    data-rdetails='<?=json_encode($req_details)?>' data-rattach='<?=$row['file_location']?>'>
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
                <a href="javascript:;" id="ob-open-request" class="btn green btn-sm"> <i class="icon-doc"> </i> Open Request</a>
                <a href="javascript:;" id="ob-embed-fullview" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end ob travel pass modal -->

<!-- begin ob certify modal -->
<div id="modal-update-ob" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="upt-title"></h4>
            </div>
            <?=form_open('', array('id' => 'frmupdate_ob'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="optstatus" id="optstatus">
                            <div class="form-group">
                                <label>Are you sure you want to certify this request?</label>
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
<!-- end ob certify modal -->

<script>
    $(document).ready(function() {
        $('#table-ob').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#request_view').show();
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
            
    });
</script>