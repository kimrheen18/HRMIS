<?php
    /* 
    File updated by Loreto G. Gabawa Jr.
    10/26/2021
    loreto.gabawa.jr@gmail.com        
    */
?>

<div class="pull-right" style="margin-top: -15px;margin-bottom: 15px;">
    <div class="btn-group">
        <a class="btn green dropdown-toggle" href="<?=base_url('hr/request?status=All'.'&request='.$_GET['request'])?>" data-toggle="dropdown">
            <i class="fa fa-<?=$notif_icon[$active_menu]?>"></i> &nbsp;
                <?php 
                    if($active_menu == 'All'):
                        echo 'All Requests';
                    elseif($active_menu == 'Certified'):
                        echo 'Approved';
                    else:
                        echo $active_menu;
                    endif;
                ?>
            <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu pull-right">
            <?php foreach($arrNotif_menu as $notif):?>
                    <li>
                        <a href="<?=base_url('hr/request?status='.$notif.'&request='.$_GET['request'])?>">
                            <i class="fa fa-<?=$notif_icon[$notif]?>"> </i> 
                            <?php 
                                if($notif == 'All'):
                                    echo 'All Requests';
                                elseif($notif == 'Certified'):
                                    echo 'Approved';
                                else:
                                    echo $notif;
                                endif;
                            ?>    
                        </a>
                    </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php if($active_menu == 'Certified'): ?>
        <div class="btn-group">
            <a class="btn green" id="export-excel"> Export Excel</a>
        </div>
    <?php endif?>

</div>
<table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-to">
    <thead>
        <tr>
            <th style="width: 100px;text-align:center;"> No. </th>
            <th style="text-align: center;"> Employee </th>
            <th style="text-align: center;"> Request Date </th>
            <th style="text-align: center;"> Request Status </th>
            <?php if(isset($_GET['status'])): if($_GET['status']=='Disapproved'): ?>
                <th style="text-align: center;"> Remarks </th>
            <?php endif; endif; ?>
            <th style="text-align: center;"> For Approval By </th>
            <th style="text-align: center;"> Duration of Travel </th>
            <th class="no-sort" style="text-align: center;"> Actions </th>

            <!-- Hidden Column (For Exporting in Excel when Approve Only) -->
            <th style="text-align: center; display:none;"> TO Number </th>
            <th style="text-align: center; display:none;"> Date of Approval </th>
            <th style="text-align: center; display:none;"> Destination </th>
            <th style="text-align: center; display:none;"> Office </th>
        </tr>
    </thead>
    <tbody>
        
    <?php $i=1; foreach($arrto_request as $row): $req_details = explode(';',$row['requestDetails']); $sec_code = $this->Hr_model->get_employee_position($row['empNumber']);?>
        <tr class="odd gradeX">
            <td align="center"> <?=$i++?> </td>
            <td> <?=employee_name($row['empNumber'])?> </td>
            <td align="center"> <?=$row['requestDate']?> </td>
            <td align="center"> 
                <?php
                    $req_status = $row['requestStatus'];
                    if($req_status == "CERTIFIED" || $req_status == "Certified" || $req_status == "certified" ):
                        echo "Approved";
                    else:
                        echo $req_status;
                    endif;
                ?>
            </td>
            <?php if(isset($_GET['status'])): if($_GET['status']=='Disapproved'): ?>
                <td align="center"> <?=$row['remarks']?> </td>
            <?php endif; endif; ?>
            <td align="center"> 
                <?php
                    // Uses Regex to change the word certification to approval
                    $next_sign = $row['next_signatory']['next_sign'];
                    $pattern = "/Certification/i";
                    echo preg_replace($pattern, "Approval", $next_sign);
                    
                    if($next_sign == ""){
                        if($req_status == "CERTIFIED" || $req_status == "Certified" || $req_status == "certified" ){
                            echo "Request has been <b>completed</b>";
                        }elseif($req_status == "Filed Request"){
                            echo "Request is being <b>processed</b>";
                        }else{
                            echo "Request has been <b>cancelled</b>";
                        }
                    }


                ?>
            </td>
            <td align="center" nowrap>
                <?php
                    if($req_details[1]!='' && $req_details[2]!=''):
                        echo date('M. d, Y',strtotime($req_details[1])).' <b>to</b> '.date('M. d, Y',strtotime($req_details[2]));
                    else:
                        echo $req_details[1]!=''?date('M. d, Y',strtotime($req_details[1])):'';
                        echo $req_details[2]!=''?date('M. d, Y',strtotime($req_details[2])):'';
                    endif;
                ?></td>
            <td width="200px" style="white-space: nowrap;text-align: center;">
                <?php
                    /* RECOMMEND/APPROVE/CERTIFY buttton will appear if request is not fully approved */
                ?>
                <?php if( $row['requestStatus'] != "CERTIFIED" && $row['next_signatory']['display'] != 0 ) : ?>
                <a class="btn btn-sm blue" id="btncertify" data-id="<?=$row['requestID']?>" data-status="<?= $row['next_signatory'][ 'action' ] ?>"><span class="icon-check"></span> 
                    <?php                         
                        if( $row['next_signatory'][ 'action' ] == "RECOMMENDED" ) {
                            echo "Recommend";
                        } elseif( $row['next_signatory'][ 'action' ] == "APPROVED" ) {
                            echo "Approve";
                        } elseif( $row['next_signatory'][ 'action' ] == "CERTIFIED" ) {
                            echo "Certify";
                        }
                    ?>
                </a>
                <?php endif; ?>
                
                <?php 
                if($row['SigFinDateTime'] != "0000-00-00 00:00:00"):      
                    $newDate = date("m-d-Y", strtotime($row['SigFinDateTime'])); 
                else:
                    $newDate = "Processing";
                endif;
                ?>

                <a class="btn btn-sm grey-cascade" id="printreport" data-rdate="<?=$row['requestDate']?>" data-id="<?=$row['requestID']?>"
                    data-rdetails='<?=json_encode($req_details)?>' data-endate="<?=$newDate ?>" data-empno="<?=$row['empNumber']?>" data-rattach='<?=$row['file_location']?>' data-sFunds='<?=$row['sourceFunds']?>'>
                    <span class="icon-magnifier" title="View"></span> Print Preview</a>
                <?php if(strtolower($row['requestStatus']) == 'filed request'): ?>
                    <?php /*<a class="btn btn-sm blue" id="btncertify" data-id="<?=$row['requestID']?>"><span class="icon-check"></span> Certify</a>*/ ?>
                    <a class="btn btn-sm btn-danger" id="btndisapproved" data-id="<?=$row['requestID']?>"><span class="icon-close" title="Cancel"></span> Disapprove</a>
                <?php endif; ?>                
            </td>

            <!-- Hidden Column (For Exporting in Excel when Approve Only) -->
            <td style="display:none;"> <?='DENR6-2022-'.$row['requestID']?> </td>
            <td style="display:none"> <?=date("m-d-Y", strtotime($row['SigFinDateTime']))?> </td>
            <td style="display:none;"> <?=$req_details[0]?> </td>
            <td style="display:none;"> <?=$sec_code[0]['sectionCode']?> </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

<!-- begin to pass modal -->
<div id="to-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Travel Order Form</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed src="" id="to-embed" frameborder="0" width="100%" height="500px">
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
                <a href="javascript:;" id="to-open-request" class="btn green btn-sm"> <i class="icon-doc"> </i> Open Request</a>
                <a href="javascript:;" id="to-embed-fullview" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end to pass modal -->

<!-- begin to certify modal -->
<div id="modal-update-to" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="to-title"></h4>
            </div>
            <?=form_open('', array('id' => 'frmupdate_to'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="opt_to_stat" id="opt_to_stat">
                            <div class="form-group">
                                <label id="lbl-to-request">Are you sure you want to certify this request?</label>
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
<!-- end to certify modal -->

<script>
    $(document).ready(function() {
        $('#table-to').dataTable( {
            // "columnDefs": [
            //     {
            //         "targets": [ 7, 8, 9, 10 ],
            //         "visible": false,
            //         "searchable": false
            //     }
            // ],

            buttons: [
                { 
                    extend: 'excel',
                    exportOptions: {
                        columns: [ 0, 7, 1, 2, 3, 4, 5, 8, 9, 10 ]
                    }
                }
            ],
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#request_view').show();
            }
        });

        $('#export-excel').on('click', function() {
             $('#table-to').DataTable().buttons(0,0).trigger();
        }); 
    });
</script>