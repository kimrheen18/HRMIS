<?php 
/** 
Purpose of file:    Delete page for User Account Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/

$key = array_search($arrData['assignedGroup'], array_column($arrGroups, 'payrollGroupId'));
?>

<!-- BEGIN PAGE BAR -->
<style type="text/css">
    select.bs-select-hidden, select.selectpicker { display: block !important; }
    select#strAccessLevel { position: absolute; }
</style>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?=base_url('libraries/agency_profile')?>">Libraries</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Delete User Account</span>
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
                    <span class="caption-subject bold uppercase"> Delete User Account</span>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" style="display: none">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group col-md-12" style="padding: 0 !important;">
                                <label class="control-label col-md-12" style="padding: 0 !important;">Access Level<span class="required"> * </span></label>
                                <div class="input-icon right col-md-6" style="padding: 0 !important;">
                                    <input type="text" class="form-control" name="strUsername" id="strUsername"
                                        value="<?=strtoupper(userlevel($arrData['userLevel'])).' Account User'?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- start of HR Officer access-->
                    <div class="hr-officer" <?=count($arrData) > 0 ? $arrData['userLevel'] == 1 ? '' : 'style="display:none;"' : 'style="display:none;"'?>>
                        <div class="row" id="HR1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><input type="radio" name="hrmodule" id="chkassistant" value="hrassistant"
                                                <?=count($arrData) > 0 ? $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> Assistant</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="HR2" <?=count($arrData) > 0 ? $arrData['is_assistant'] == '1' ? '' : 'style="display:none;"' : ''?>>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkNotif" value="1"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '1') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=hrPermission(1,1)?> </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkAttdnce" value="3"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '3') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=hrPermission(3,1)?> </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkLib" value="5"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '5') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=hrPermission(5,1)?> </label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chk201" value="2"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '2') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=hrPermission(2,1)?> </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkReports" value="4"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '4') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=hrPermission(4,1)?> </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkCompen" value="6"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '6') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=hrPermission(6,1)?> </label>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                        </div>
                        <div class="row" id="HR8">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><input type="radio" name="hrmodule" id="chkhrmo" value="hr"
                                                <?=count($arrData) > 0 ? $arrData['is_assistant'] == 0 ? 'checked' : '' : ''?> disabled> <?=hrPermission(-1,1)?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of HR Officer access-->

                    <!-- start of Finance Officer access-->
                    <div class="finance-officer" <?=count($arrData) > 0 ? $arrData['userLevel'] == 2 ? '' : 'style="display:none;"' : 'style="display:none;"'?>>
                        <div class="row" id="Finance1">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><input type="radio" name="financemodule" id="chkfoass" value="fassistant"
                                                <?=count($arrData) > 0 ? $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> Assistant</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="Finance2" <?=count($arrData) > 0 ? $arrData['is_assistant'] == '1' ? '' : 'style="display:none;"' : ''?>>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkNotif2" value="0"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '0') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=financePermission(0,1)?> </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkCompen2" value="1"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '1') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=financePermission(1,1)?> </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkUpdate" value="2"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '2') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=financePermission(2,1)?> </label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-md-9">
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkReports2" value="3"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '3') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=financePermission(3,1)?> </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="chkLib2" value="4"
                                                <?=count($arrData) > 0 ? (strpos($arrData['accessPermission'], '4') !== false) && $arrData['is_assistant'] == '1' ? 'checked' : '' : ''?> disabled> <?=financePermission(4,1)?> </label>
                                    </div>
                                    <div class="col-md-3">&nbsp;</div>
                                </div>
                            </div>
                            <br><br>

                            <div class="form-group">
                                <div class="col-md-9">
                                    <div class="col-md-8" style="margin-bottom: 20px;">
                                        <label>Assigned Payroll Group </label>
                                        <input type="text" class="form-control" name="strUsername" id="strUsername"
                                            value="<?=$arrGroups[$key]['payrollGroupName']?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" id="Finance8">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><input type="radio" name="financemodule" id="chkfoall" value="f"
                                                <?=count($arrData) > 0 ? $arrData['is_assistant'] == 0 ? 'checked' : '' : ''?> disabled> <?=financePermission(-1,1)?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of Finance Module access-->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group col-md-12" style="padding: 0 !important;">
                                <label class="control-label col-md-12" style="padding: 0 !important;">Employee Name<span class="required"> * </span></label>
                                <div class="input-icon right col-md-6" style="padding: 0 !important;">
                                    <input type="text" class="form-control" name="strUsername" id="strUsername"
                                        value="<?=employee_name($arrData['empNumber'])?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group col-md-12" style="padding: 0 !important;">
                                <label class="control-label col-md-12" style="padding: 0 !important;">Username<span class="required"> * </span></label>
                                <div class="input-icon right col-md-6" style="padding: 0 !important;">
                                    <input type="text" class="form-control" name="strUsername" id="strUsername"
                                        value="<?=count($arrData) > 0 ? $arrData['userName'] : ''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="intEmpNumber" value="<?=isset($arrData[0]['empNumber'])?$arrData[0]['empNumber']:''?>">
                                <button class="btn btn-danger" id="btndelete"><i class="icon-trash"></i> Delete</button>
                                <a href="<?=base_url('libraries/user_account')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin delete duties and resposibilities reference -->
<div class="modal fade" id="delete_user-account" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Delete User Account</b></h4>
            </div>
            <?=form_open(base_url('libraries/user_account/delete/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmUserAccount'))?>
                <div class="modal-body"> Are you sure you want to delete this data? </div>
                <input type="hidden" name="strtoken">
                <div class="modal-footer">
                    <button type="submit" id="btndelete" class="btn btn-sm green">
                        <i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                        <i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end delete duties and resposibilities reference -->

<script>
    $(document).ready(function() { 
        $('.portlet-body').show();
        $('.loading-image').hide();

        $('#btndelete').click(function() {
            $('#delete_user-account').modal('show');
        });
    });
</script>