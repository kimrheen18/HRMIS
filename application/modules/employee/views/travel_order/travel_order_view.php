<?php 
/** 
Purpose of file:    Travel Order View
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
$to_details = isset($arrto) ? explode(';',$arrto['requestDetails']) : array();
$form_action = $action=='add' ? 'employee/travel_order/submit' : 'employee/travel_order/edit?req_id='.$_GET['req_id'];
$hrmodule = isset($_GET['module']) ? $_GET['module'] == 'hr' ? 1 : 0 : 0;
?>
<!-- BEGIN PAGE BAR -->
<?=load_plugin('css', array('datepicker','timepicker'))?>

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
            <span><?=ucwords($hrmodule ? 'view' : $action)?> Travel Order</span>
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
                    <span class="caption-subject bold uppercase">Travel Order</span>
                </div>
            </div>
            <div class="portlet-body">
                <?=form_open_multipart($form_action, array('method' => 'post', 'id' => 'frmTO'))?>
                <input class="hidden" name="strStatus" value="Filed Request">
                <input class="hidden" name="strCode" value="TO">
                <input type="hidden" id="txtfilesize" name="txtfilesize">
                <input type="hidden" id="txtdgstorage" name="txtdgstorage">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Destination :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea class="form-control" rows="2" name="strDestination" id="strDestination" type="text" maxlength="1000" <?=$hrmodule ? 'disabled' : ''?>><?=count($to_details) > 0 ? urldecode($to_details[0]) : '' ?></textarea>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Date From :  <span class="required"> * </span></label>
                            <div class="input-icon right">
                                <i class="fa"></i>
                               <input type="text" class="form-control date-picker" name="dtmTOdatefrom" id="dtmTOdatefrom" value="<?=count($to_details) > 0 ? $to_details[1] : '' ?>" data-date-format="yyyy-mm-dd" autocomplete="off" <?=$hrmodule ? 'disabled' : ''?>>   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Date To :  <span class="required"> * </span></label>
                            <div class="input-icon right">
                                <i class="fa"></i>
                               <input type="text" class="form-control date-picker" name="dtmTOdateto" id="dtmTOdateto" value="<?=count($to_details) > 0 ? $to_details[2] : '' ?>" data-date-format="yyyy-mm-dd" autocomplete="off" <?=$hrmodule ? 'disabled' : ''?>>   
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Purpose :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea class="form-control" rows="2" name="strPurpose" id="strPurpose" type="text" maxlength="1000" <?=$hrmodule ? 'disabled' : ''?>><?=count($to_details) > 0 ? urldecode($to_details[3]) : '' ?></textarea>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                           <label  class="control-label" class="mt-checkbox mt-checkbox-outline"> With Meal :
                                <input type="checkbox" value="Y" name="strMeal" id="strMeal" <?=$hrmodule ? 'disabled' : ''?> <?=count($to_details) > 0 ? strtolower($to_details[4]) == 'y' ? 'checked' : '' : '' ?> />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Source of funds :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="bs-select form-control" name="sFunds" id="sFunds">
                                        <option value="GMS-100000100001000" >General Management and Supervision - 100000100001000</options>
                                        <option value="HRD-100000100002000">Human Resource Development - 100000100002000</option>
                                        <option value="DM-200000100001000">Data Management - 200000100001000</option>
                                        <option value="P&D-200000100002000">Production and Dissemination - 200000100002000</option>
                                        <option value="LS-200000100003000">Legal Services - 200000100003000</option>
                                        <option value="CSS-200000100004000">Conduct of Special Studies - 200000100004000</option>
                                        <option value="F&M-200000100005000">Formulation and Monitoring - 200000100005000</option>
                                        <option value="NRM-310100100001000v">Natural Resources Management - 310100100001000v</option>
                                        <option value="OIE-310100100002000">Operations against illegal environment - 310100100002000</option>
                                        <option value="PADM-310201100001000">Protected Areas Development and Management - 310201100001000</option>
                                        <option value="PCW-310202100001000">Protection and Conservation Wildlife - 310202100001000</option>
                                        <option value="MCMR-310203100001000">Management of Coastal and Marine Resources - 310203100001000</option>
                                        <option value="LSDRM-310204100001000">Land Survey, Disposition and Records Management - 310204100001000</option>
                                        <option value="FD-310205100001000">Forest Development - 310205100001000</option>
                                        <option value="SCWM-310205100002000">Soil Conservation and Watershed Management - 310205100002000</option>
                                        <option value="NRA-320300100001000">Natural Resources Assessment - 320300100001000</option>
                                        <option>Others</options>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>

                

                <!--<div class="row" id="attachments" <?=$hrmodule?'hidden':''?>>
                    <br>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <a class='btn blue-madison' href='javascript:;'>
                                <i class="fa fa-upload"></i> Attach File
                                <input type="file" name ="userfile[]" id= "userfile" multiple 
                                    style='left: 16px !important;width: 108px;height: 34px;position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'
                                    name="file_source" size="40">
                            </a>
                        </div>
                    </div>
                </div>-->



                <div class="row">
                    <div class="col-sm-8">
                        <div id="upload-file-info">
                            <?php
                                if(isset($arrto)): if($arrto['file_location']!=''):
                                    foreach(json_decode($arrto['file_location'], true) as $attach):
                                        $ext = explode('.',$attach['filename']);
                                        $ext = $ext[count($ext)-1];
                                        echo '<span><i></i>
                                                    <a href="'.base_url($attach['filepath']).'" target="_blank"><i class="'.check_icon($ext).'"></i> '.$attach['filename'].'</a>';
                                        if(!$hrmodule):
                                            echo '<a href="javascript:;" id="btn-attach" data-id="'.$attach['fileid'].'" class="font-red"><i class="fa fa-remove"></i></a>
                                                    </span>';
                                        endif;
                                        echo '<br>';
                                    endforeach;
                                endif; endif;
                             ?>
                        </div>
                        <span id="upload-size" class="small bold"></span><br>
                        <span id="upload-error" class="font-red small">Maximum upload must be 100MB.</span>
                    </div>
                </div>
                <div class="row"><div class="col-sm-8"><hr></div></div>
                <div class="row">
                    <div class="col-sm-8">
                        <?php if(!$hrmodule): ?>
                            <button type="submit" class="btn btn-success" id="btn-request-to">
                                <i class="icon-check"></i>
                                <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
                            <a href="<?=base_url('employee/travel_order')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
                        <?php else: ?>
                            <a href="<?=base_url('hr/request?request=to')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
                        <?php endif; ?>
                        <button type="button" id="printreport" value="reportOB" class="btn grey-cascade pull-right"><i class="icon-magnifier"></i> Print/Preview</button>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>

<!-- begin to form modal -->
<div id="to-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Travel Order</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed src="" id="to-embed" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="to-embed-fullview" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end to form modal -->

<!-- begin delete attachment -->
<div id="delete-attachment" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Attachment</h4>
            </div>
            <?php $reqid = isset($_GET['req_id'])?$_GET['req_id']:''; ?>
            <?=form_open('employee/travel_order/delete?req_id='.$reqid, array('id' => 'frmob_attach'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtto_attach_id" id="txtto_attach_id">
                            <div class="form-group">
                                <label>Are you sure you want to delete this data?</label>
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
<!-- end delete attachment -->

<?=load_plugin('js',array('form_validation','datepicker'));?>

<script>
$(document).ready(function() {
    $('#upload-error').hide();
    $('.date-picker').datepicker();
    $('.date-picker').on('changeDate', function(){
        $(this).datepicker('hide');
    });

    $('a#btn-attach').on('click',function() {
        var id = $(this).data('id');
        $('#txtto_attach_id').val(id);
        $('#delete-attachment').modal('show');
    });

    $('#strDestination').on('keyup keypress change',function() {
        check_null('#strDestination','Destination must not be empty.');
    });

    $('#dtmTOdatefrom').on('keyup keypress change',function() {
        check_null('#dtmTOdatefrom','Date From must not be empty.');
    });

    $('#dtmTOdateto').on('keyup keypress change',function() {
        check_null('#dtmTOdateto','Date To must not be empty.');
    });

    $('#strPurpose').on('keyup keypress change',function() {
        check_null('#strPurpose','Purpose must not be empty.');
    });

    $('#userfile').on('keyup keypress change',function() {
        $('#upload-error').hide();
        $('#upload-file-info').html('');

        var fnames = '<ul>';
        var total_size = 0;
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            fnames = fnames + '<li>' + $(this).get(0).files[i].name + '</li>';
            total_size = total_size + $(this).get(0).files[i].size;
        }

        if(total_size < 1000000){
            $('#txtfilesize').val(Math.floor(total_size/1000));
            $('#txtdgstorage').val('KB');
            $('#upload-size').html('Total Filesize: '+Math.floor(total_size/1000)+' KB');
        }else{
            $('#txtfilesize').val(Math.floor(total_size/1000000));
            $('#txtdgstorage').val('MB');
            $('#upload-size').html('Total Filesize: '+Math.floor(total_size/1000000)+' MB');
        }
        $('#upload-file-info').html(fnames+'</ul>');

        if($('#txtdgstorage').val() == 'MB' || $('#txtdgstorage').val() == 'KB') {
            if($('#txtdgstorage').val() == 'MB') {
                if($('#txtfilesize').val() > 100){
                    $('#upload-error').show();
                }
            }
        }else{
            $('#upload-error').show();
        }

    });

    $('#btn-request-to').click(function(e) {
        var total_error = 0;

        total_error = total_error + check_null('#strDestination','Destination must not be empty.');
        total_error = total_error + check_null('#dtmTOdatefrom','Date From must not be empty.');
        total_error = total_error + check_null('#dtmTOdateto','Date To must not be empty.');
        total_error = total_error + check_null('#strPurpose','Purpose must not be empty.');
        if($('#txtdgstorage').val()!='' && $('#txtdgstorage').val()!=''){
            if($('#txtdgstorage').val() == 'MB' || $('#txtdgstorage').val() == 'KB') {
                if($('#txtdgstorage').val() == 'MB') {
                    if($('#txtfilesize').val() > 100){
                        total_error = total_error + 1;
                        $('#upload-error').show();
                    }
                }
            }else{
                total_error = total_error + 1;
                $('#upload-error').show();
            }
        }

        if(total_error > 0){
            e.preventDefault();
        }
    });

    $('#printreport').click(function() {
        var desti       = $('#strDestination').val();
        var todatefrom  = $('#dtmTOdatefrom').val();
        var todateto    = $('#dtmTOdateto').val();
        var purpose     = $('#strPurpose').val();
        var meal        = $('#strMeal').val();
        var sFunds      = $('#sFunds').val();

        var link = "<?=base_url('employee/reports/generate/?rpt=reportTO')?>"+"&desti="+desti+"&todatefrom="+todatefrom+"&todateto="+todateto+"&purpose="+purpose+"&meal="+meal+"&sFunds="+sFunds;
        $('#to-embed').attr('src',link);
        $('#to-embed-fullview').attr('href',link);
        $('#to-form').modal('show');
        
    });
});
</script>
