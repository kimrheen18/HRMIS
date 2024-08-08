<?php 
/** 
Purpose of file:    Leave Monetization View
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
$arrBalance['vlBalance'] = isset($arrBalance['vlBalance']) ? $arrBalance['vlBalance'] : 0;
$arrBalance['slBalance'] = isset($arrBalance['slBalance']) ? $arrBalance['slBalance'] : 0;
$arrBalance['periodMonth'] = isset($arrBalance['periodMonth']) ? $arrBalance['periodMonth'] : '';
$arrBalance['periodYear'] = isset($arrBalance['periodYear']) ? $arrBalance['periodYear'] : '';

$mone_details = isset($arrmone) ? explode(';',$arrmone['requestDetails']) : array();
$form_action = $action=='add' ? 'employee/leave_monetization/submit' : 'employee/leave_monetization/edit?req_id='.$_GET['req_id'];
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
            <span><?=ucwords($hrmodule ? 'view' : $action)?> Leave Monetization</span>
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
                    <span class="caption-subject bold uppercase">Leave Monetization</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?php $permonth = date("F Y", strtotime("last day of previous month")); ?>
                        <p><b>Leave Credits Available as of <?=$permonth?></b></p>
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="width: 25%;">Vacation Leave</td>
                                    <td style="width: 25%;"><?=number_format($arrBalance['vlBalance'],3)?></td>
                                    <td style="width: 25%;">Projected Vacation Leave</td>
                                    <td style="width: 25%;"><?=number_format($arrBalance['vlBalance'],3)?></td>
                                </tr>
                                <tr>
                                    <td>Sick Leave</td>
                                    <td><?=number_format($arrBalance['slBalance'],3)?></td>
                                    <td>Projected Sick Leaves</td>
                                    <td><?=number_format($arrBalance['slBalance'],3)?></td>
                                </tr>
                                <tr>
                                    <td>Total Leave Credits</td>
                                    <td colspan="3"><?=number_format(($arrBalance['vlBalance']+ $arrBalance['slBalance']), 3)?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-heading-1 border-blue m-bordered small" style="position: static;display: block;line-height: 1.8;">
                            Projected Leave = Actual Leave - Approved Leave <br>
                            <b>Approved Leaves from Jan to Nov</b><br>
                                "Monetization of 50% or more of all your accumulated leave credit may be allowable for valid and justifiable reasons subject to the discretion of the agency head and the availability of funds." <br>
                                "Sick leave credits may be monetized if an employee has no available vacation leave credits. Vacation leave credits must be exhausted first before sick leave credits maybe used." <br>
                                Five (5) days must be left at Vacation Leaves credits after monetization. <br>
                        </div>
                    </div>
                </div>
                <hr>
                <?=form_open(base_url($form_action), array('method' => 'post', 'id' => 'frmTO'))?>
                    <input type="hidden" name="txtvlBalance" value="<?=$arrBalance['vlBalance']?>">
                    <input type="hidden" name="txtslBalance" value="<?=$arrBalance['slBalance']?>">
                    <input type="hidden" name="txtperiodMonth" value="<?=$arrBalance['periodMonth']?>">
                    <input type="hidden" name="txtperiodYear" value="<?=$arrBalance['periodYear']?>">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><input type="checkbox" value="1" name="commutation" id="commutation" <?=$hrmodule ? 'disabled' : ''?> /><b> Commutation</b></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-sm-6"># of Leave Credits to be Monetized on Vacation Leave :</label>
                                <div class="col-sm-4">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="MonetizedVL" id="MonetizedVL" <?=$hrmodule ? 'disabled' : ''?>
                                            value="<?=isset($arrmone) ? $mone_details[0] : (isset($arrBalance['vlBalance'])?$arrBalance['vlBalance']:'')?>">
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-sm-6"># of Leave Credits to be Monetized on Sick Leave :</label>
                                <div class="col-sm-4">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control" name="MonetizedSL" id="MonetizedSL" <?=$hrmodule ? 'disabled' : ''?>
                                            value="<?=isset($arrmone) ? $mone_details[1] : (isset($arrBalance['slBalance'])?$arrBalance['slBalance']:'')?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div></br>
                    <div class="row div-reason">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Reason :</label>
                                <div class="col-sm-8">
                                    <div class="input-icon right">
                                        <textarea class="form-control" name="strReason" id="strReason" <?=$hrmodule ? 'disabled' : ''?>><?=isset($arrBalance['strReason'])?$arrBalance['strReason']:''?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row"><div class="col-sm-10"><hr></div> </div>
                    <div class="row">
                        <div class="col-sm-12"><input class="hidden" name="strStatus" value="Filed Request">
                            <?php if(!$hrmodule): ?>
                                <button type="submit" class="btn btn-success" id="btn-request-leave"> <i class="icon-check"></i> <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
                            <?php else: ?>
                                <a href="<?=base_url('hr/request?request=mone')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>

<?=load_plugin('js',array('form_validation'));?>

<script>
$(document).ready(function() {
    $('.div-reason').hide();

    $('#commutation').on('change', function(){
        this.value = $('#commutation').is(":checked") ? 1 : 0;

        if(this.checked) {
            $('.div-reason').show();

        }else{
            $('.div-reason').hide();
        }
    });

    $('#MonetizedVL').on('keyup keypress change',function() {
        check_null('#MonetizedVL','Leave Credits to be Monetized on Vacation Leave must not be empty.');
    });

    $('#MonetizedSL').on('keyup keypress change',function() {
        check_null('#MonetizedSL','Leave Credits to be Monetized on Sick Leave must not be empty.');
    });

    $('#strReason').on('keyup keypress change',function() {
        check_null('#strReason','Reason must not be empty.');
    });

    $('#btn-request-leave').click(function(e) {
        var total_error = 0;

        total_error = total_error + check_null('#MonetizedVL','Leave Credits to be Monetized on Vacation Leave must not be empty.');
        total_error = total_error + check_null('#MonetizedSL','Leave Credits to be Monetized on Sick Leave must not be empty.');

        if($('#commutation').is(":checked")){
            total_error = total_error + check_null('#strReason','Reason must not be empty.');
        }

        if(total_error > 0){
            e.preventDefault();
        }
    });

}); 
</script>