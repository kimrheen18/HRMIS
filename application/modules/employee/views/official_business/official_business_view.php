<?php 
/** 
Purpose of file:    Official Business View
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
$emp_att_scheme = emp_att_scheme($_SESSION['sessEmpNo']);
$obdetails = isset($arrob) ? explode(';',$arrob['requestDetails']) : array();
$hrmodule = isset($_GET['module']) ? $_GET['module'] == 'hr' ? 1 : 0 : 0;
if($hrmodule):
    $form_action = 'hr/request/update_ob?req_id='.$_GET['req_id'];
else:
    $form_action = $action == 'add' ? 'employee/official_business/submit' : 'employee/official_business/edit?req_id='.$_GET['req_id'];
endif;
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
            <span><?=ucwords($hrmodule ? 'view' : $action)?> OB</span>
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
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Official Business</span>
                </div>
            </div>
            <div class="portlet-body">
                <?=form_open_multipart($form_action, array('method' => 'post', 'id' => 'frmOB'))?>
                    <input type="hidden" name="strStatus" value="Filed Request">
                    <input type="hidden" name="strCode" value="OB">
                    <input type="hidden" id="txtfilesize" name="txtfilesize">
                    <input type="hidden" id="txtdgstorage" name="txtdgstorage">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Official Business: <span class="required"> * </span></label>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="strOBtype" id="strOBtype" value="Official" checked <?=$hrmodule ? 'disabled' : ''?>> Official </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="strOBtype" id="strOBtype" value="Personal" <?=$hrmodule ? 'disabled' : ''?>> Personal </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Request Date :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                   <input type="text" class="form-control date-picker" name="dtmOBrequestdate" id="dtmOBrequestdate" value="<?=count($obdetails)>0 ? $obdetails[1]:date('Y-m-d')?>" data-date-format="yyyy-mm-dd" autocomplete="of" <?=$hrmodule ? 'disabled' : ''?>>   
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
                                   <input type="text" class="form-control date-picker" name="dtmOBdatefrom" id="dtmOBdatefrom"
                                        value="<?=count($obdetails)>0 ? $obdetails[2]:''?>" data-date-format="yyyy-mm-dd" autocomplete="off" <?=$hrmodule ? 'disabled' : ''?>>   
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
                                   <input type="text" class="form-control date-picker" name="dtmOBdateto" id="dtmOBdateto"
                                        value="<?=count($obdetails)>0 ? $obdetails[3]:''?>" data-date-format="yyyy-mm-dd" autocomplete="off" <?=$hrmodule ? 'disabled' : ''?>>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Time From :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                   <input type="text" class="form-control timepicker timepicker-default" name="dtmTimeFrom" id="dtmTimeFrom"
                                        value="<?=count($obdetails)>0 ? $obdetails[4]:date('h:i:s A',strtotime($emp_att_scheme['amTimeinTo']))?>" autocomplete="off" <?=$hrmodule ? 'disabled' : ''?>>   
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Time To :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                   <input type="text" class="form-control timepicker timepicker-default" name="dtmTimeTo" id="dtmTimeTo"
                                        value="<?=count($obdetails)>0 ? $obdetails[5]:date('h:i:s A',strtotime($emp_att_scheme['pmTimeoutTo']))?>" <?=$hrmodule ? 'disabled' : ''?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label">Destination :  <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <textarea class="form-control" rows="2" name="strDestination" id="strDestination" type="text" maxlength="1000" <?=$hrmodule ? 'disabled' : ''?>><?=count($obdetails)>0 ? $obdetails[6]:''?></textarea>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                               <label class="control-label">Purpose : <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <textarea name="strPurpose" id="strPurpose" type="text" size="20" maxlength="100" class="form-control" <?=$hrmodule ? 'disabled' : ''?>><?=count($obdetails)>0 ? $obdetails[7]:''?></textarea>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                               <label  class="control-label" class="mt-checkbox mt-checkbox-outline"> With Meal :
                                    <input type="checkbox" value="Y" name="strMeal" id="strMeal" <?=count($obdetails)>0 ? strtoupper($obdetails[6])=='Y' ? 'checked' : '' :''?> <?=$hrmodule ? 'disabled' : ''?> />
                            </div>
                        </div>
                    </div>
                    <div class="row" <?=$hrmodule ? 'hidden' : ''?>>
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
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div id="upload-file-info">
                                <?php
                                    if(isset($arrob)): if($arrob['file_location']!=''):
                                        foreach(json_decode($arrob['file_location'], true) as $attach):
                                            $ext = explode('.',$attach['filename']);
                                            $ext = $ext[count($ext)-1];
                                            echo '<span><i></i>
                                                        <a href="'.base_url($attach['filepath']).'" target="_blank"><i class="'.check_icon($ext).'"></i> '.$attach['filename'].'</a>
                                                        <a href="javascript:;" id="btn-attach" data-id="'.$attach['fileid'].'" class="font-red"><i class="fa fa-remove"></i></a>
                                                    </span><br>';
                                        endforeach;
                                    endif; endif;
                                 ?>
                            </div>
                            <span id="upload-size" class="small bold"></span><br>
                            <span id="upload-error" class="font-red small">Maximum upload must be 100MB.</span>
                        </div>
                    </div>
                    <div class="row" <?=$hrmodule ? '' : 'hidden'?>>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label"> Remarks</label>
                                <textarea class="form-control" name="txtremarks"></textarea>
                                <br>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="optstatus" value="CERTIFIED" checked> <b>CERTIFY</b> </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optstatus" value="Disapproved"> <b>DISAPPROVE</b> </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-8"><hr></div></div>
                    <div class="row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success" id="btn-request-ob">
                                <i class="icon-check"></i>
                                <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>

                            <a href="<?=base_url($hrmodule ? 'hr/request?request=ob' : 'employee/official_business')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
                            <button type="button" id="printreport" value="reportOB" class="btn grey-cascade pull-right"><i class="icon-magnifier"></i> Print/Preview</button>
                        </div>
                    </div>
                    <?=form_close()?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin ob form modal -->
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
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="ob-embed-fullview" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end ob form modal -->

<!-- begin delete attachment -->
<div id="delete-attachment" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Attachment</h4>
            </div>
            <?php $reqid = isset($_GET['req_id'])?$_GET['req_id']:''; ?>
            <?=form_open('employee/official_business/delete?req_id='.$reqid, array('id' => 'frmob_attach'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="text" name="txtob_attach_id" id="txtob_attach_id">
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


<?=load_plugin('js',array('form_validation','datepicker','timepicker'));?>

<script>
$(document).ready(function() {
    $('#upload-error').hide();
    $('.date-picker').datepicker();
    $('.date-picker').on('changeDate', function(){
        $(this).datepicker('hide');
    });
    
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm:ss A',
        minuteStep: 1,
        secondStep: 1,
        disableFocus: true,
        showInputs: false,
        showSeconds: true,
        showMeridian: true,
        defaultValue: '00:00:00 a'
    });

    $('a#btn-attach').on('click',function() {
        var id = $(this).data('id');
        $('#txtob_attach_id').val(id);
        $('#delete-attachment').modal('show');
    });

    $('#printreport').click(function(){
        var obtype      = $('#strOBtype').val();
        var reqdate     = $('#dtmOBrequestdate').val();
        var obdatefrom  = $('#dtmOBdatefrom').val();
        var obdateto    = $('#dtmOBdateto').val();
        var obtimefrom  = $('#dtmTimeFrom').val();
        var obtimeto    = $('#dtmTimeTo').val();
        var desti       = $('#strDestination').val();
        var meal        = $('#strMeal').val();
        var purpose     = $('#strPurpose').val();

        var link = "<?=base_url('employee/reports/generate/?rpt=reportOB')?>"+"&obtype="+obtype+"&reqdate="+reqdate+"&obdatefrom="+obdatefrom+"&obdateto="+obdateto+"&obtimefrom="+obtimefrom+"&obtimeto="+obtimeto+"&desti="+desti+"&meal="+meal+"&purpose="+purpose;
        $('#ob-embed').attr('src',link);
        $('#ob-embed-fullview').attr('href',link);
        $('#ob-form').modal('show');
    });

    $('#userfile').on('keyup keypress change',function() {
        $('#upload-error').hide();
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

    $('#dtmOBrequestdate').on('keyup keypress change',function() {
        check_null('#dtmOBrequestdate','Request Date must not be empty.');
    });

    $('#dtmOBdatefrom').on('keyup keypress change',function() {
        check_null('#dtmOBdatefrom','Date From must not be empty.');
    });

    $('#dtmOBdateto').on('keyup keypress change',function() {
        check_null('#dtmOBdateto','Date To must not be empty.');
    });

    $('#dtmTimeFrom').on('keyup keypress change',function() {
        check_null('#dtmTimeFrom','Time From must not be empty.');
    });

    $('#dtmTimeTo').on('keyup keypress change',function() {
        check_null('#dtmTimeTo','Time To must not be empty.');
    });

    $('#strDestination').on('keyup keypress change',function() {
        check_null('#strDestination','Destination must not be empty.');
    });

    $('#strPurpose').on('keyup keypress change',function() {
        check_null('#strPurpose','Purpose must not be empty.');
    });

    $('#btn-request-ob').click(function(e) {
        $('#upload-error').hide();
        var total_error = 0;

        total_error = total_error + check_null('#dtmOBrequestdate','Request Date must not be empty.');
        total_error = total_error + check_null('#dtmOBdatefrom','Date From must not be empty.');
        total_error = total_error + check_null('#dtmOBdateto','Date To must not be empty.');
        total_error = total_error + check_null('#dtmTimeFrom','Time From must not be empty.');
        total_error = total_error + check_null('#dtmTimeTo','Time To must not be empty.');
        total_error = total_error + check_null('#strDestination','Destination must not be empty.');
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

});
</script>