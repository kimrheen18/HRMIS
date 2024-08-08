<?php 
load_plugin('css',array('select2','select'));
$app_type = isset($request_flow) ? explode(';',$request_flow['Applicant']) : array();
$signatory1 = isset($request_flow) ? explode(';',$request_flow['Signatory1']) : array();
$signatory2 = isset($request_flow) ? explode(';',$request_flow['Signatory2']) : array();
$signatory3 = isset($request_flow) ? explode(';',$request_flow['Signatory3']) : array();
$signatory4 = isset($request_flow) ? explode(';',$request_flow['Signatory4']) : array();
$SignatoryFin = isset($request_flow) ? explode(';',$request_flow['SignatoryFin']) : array();?>
<!-- BEGIN PAGE BAR -->
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
            <span>Add Request</span>
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
                    <span class="caption-subject bold uppercase"> <?=$action?> Request</span>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-body" style="visibility: hidden;">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-9">
                        <?php 
                        $form = $action == 'add' ? '' : 'libraries/request/edit/'.$this->uri->segment(4);
                        echo form_open($form, array('method' => 'post', 'id' => 'frmlocalholiday', 'class' => 'form-horizontal'))?>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Type of Request <span class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="select2 form-control form-required" name="request_type[]" id="request_type" multiple <?=$action=='delete'?'disabled':''?>>
                                                    <?php
                                                        foreach($arrRequestType as $type):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                foreach(explode(';',$request_flow['RequestType']) as $rtype):
                                                                    if($type['requestCode'] == $rtype) { $selected = 'selected'; }
                                                                endforeach;
                                                            endif;?>
                                                            <option value="<?=$type['requestCode']?>" <?=$selected?>><?=$type['requestDesc']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3"><b>APPLICANT</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Type <span class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="app_type" id="app_type" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT TYPE OF APPLICANT -- </option>
                                                    <?php foreach($arrApplicant as $applicant):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $app_type[0] == $applicant['AppliCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$applicant['AppliCode']?>" <?=$selected?>><?=$applicant['Applicant']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Office Name</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="select2 form-control form-required" name="app_office" id="app_office" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT OFFICE -- </option>
                                                    <?=getGroupOffice(isset($request_flow) ? $app_type[1] : '')?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="display: none">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Employee Name </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="select2 form-control form-required" name="app_employee" id="app_employee" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT EMPLOYEE -- </option>
                                                    <?php foreach($arrEmployees as $data):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $app_type[2] == $data['empNumber'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$data['empNumber']?>" <?=$selected?>>
                                                            <?=getfullname($data['firstname'],$data['surname'],$data['middlename'],$data['middleInitial'],$data['nameExtension'])?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3"><b>First Signatory</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Action </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sig1_action" id="sig1_action" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT ACTION -- </option>
                                                    <?php foreach($arrAction as $sig_action): if($sig_action['ID']!=1):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory1[0] == $sig_action['ActionCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$sig_action['ActionCode']?>" <?=$selected?>><?=$sig_action['ActionDesc']?></option>
                                                    <?php endif; endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Signatory </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sig1_signatory" id="sig1_signatory" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT SIGNATORY -- </option>
                                                    <?php foreach($arrSignatory as $signatory):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory1[1] == $signatory['SignCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$signatory['SignCode']?>" <?=$selected?>><?=$signatory['Signatory']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Officer </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="select2 form-control form-required" name="sig1_officer" id="sig1_officer" <?=$action=='delete'?'disabled':''?>>
                                                    <option value="0"> -- SELECT EMPLOYEE -- </option>
                                                    <?php foreach($arrEmployees as $data):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory1[2] == $data['empNumber'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$data['empNumber']?>" <?=$selected?>>
                                                            <?=getfullname($data['firstname'],$data['surname'],$data['middlename'],$data['middleInitial'],$data['nameExtension'])?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3"><b>Second Signatory</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Action </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sig2_action" id="sig2_action" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT ACTION -- </option>
                                                    <?php foreach($arrAction as $sig_action): if($sig_action['ID']!=1):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory2[0] == $sig_action['ActionCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$sig_action['ActionCode']?>" <?=$selected?>><?=$sig_action['ActionDesc']?></option>
                                                    <?php endif; endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Signatory </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sig2_signatory" id="sig2_signatory" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT SIGNATORY -- </option>
                                                    <?php foreach($arrSignatory as $signatory):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory2[1] == $signatory['SignCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$signatory['SignCode']?>" <?=$selected?>><?=$signatory['Signatory']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Officer </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="select2 form-control form-required" name="sig2_officer" id="sig2_officer" <?=$action=='delete'?'disabled':''?>>
                                                    <option value="0"> -- SELECT EMPLOYEE -- </option>
                                                    <?php foreach($arrEmployees as $data):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory2[2] == $data['empNumber'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$data['empNumber']?>" <?=$selected?>>
                                                            <?=getfullname($data['firstname'],$data['surname'],$data['middlename'],$data['middleInitial'],$data['nameExtension'])?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3"><b>Third Signatory</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Action </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sig3_action" id="sig3_action" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT ACTION -- </option>
                                                    <?php foreach($arrAction as $sig_action): if($sig_action['ID']!=1):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory3[0] == $sig_action['ActionCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$sig_action['ActionCode']?>" <?=$selected?>><?=$sig_action['ActionDesc']?></option>
                                                    <?php endif; endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Signatory </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sig3_signatory" id="sig3_signatory" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT SIGNATORY -- </option>
                                                    <?php foreach($arrSignatory as $signatory):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory3[1] == $signatory['SignCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$signatory['SignCode']?>" <?=$selected?>><?=$signatory['Signatory']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Officer </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="select2 form-control form-required" name="sig3_officer" id="sig3_officer" <?=$action=='delete'?'disabled':''?>>
                                                    <option value="0"> -- SELECT EMPLOYEE -- </option>
                                                    <?php foreach($arrEmployees as $data):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory3[2] == $data['empNumber'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$data['empNumber']?>" <?=$selected?>>
                                                            <?=getfullname($data['firstname'],$data['surname'],$data['middlename'],$data['middleInitial'],$data['nameExtension'])?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3"><b>Fourth Signatory</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Action <span class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sig4_action" id="sig4_action" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT ACTION -- </option>
                                                    <?php foreach($arrAction as $sig_action): if($sig_action['ID']!=1):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory4[0] == $sig_action['ActionCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$sig_action['ActionCode']?>" <?=$selected?>><?=$sig_action['ActionDesc']?></option>
                                                    <?php endif; endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Signatory </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sig4_signatory" id="sig4_signatory" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT SIGNATORY -- </option>
                                                    <?php foreach($arrSignatory as $signatory):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory4[1] == $signatory['SignCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$signatory['SignCode']?>" <?=$selected?>><?=$signatory['Signatory']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Officer <span class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="select2 form-control form-required" name="sig4_officer" id="sig4_officer" <?=$action=='delete'?'disabled':''?>>
                                                    <option value="0"> -- SELECT EMPLOYEE -- </option>
                                                    <?php foreach($arrEmployees as $data):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $signatory4[2] == $data['empNumber'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$data['empNumber']?>" <?=$selected?>>
                                                            <?=getfullname($data['firstname'],$data['surname'],$data['middlename'],$data['middleInitial'],$data['nameExtension'])?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3"><b>Final Signatory</b></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Action <span class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sigfinal_action" id="sigfinal_action" <?=$action=='delete'?'disabled':''?>>
                                                    <?php foreach($arrAction as $sig_action): if($sig_action['ID']==1):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $SignatoryFin[0] == $sig_action['ActionCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$sig_action['ActionCode']?>" <?=$selected?>><?=$sig_action['ActionDesc']?></option>
                                                    <?php endif; endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Signatory </label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="bs-select form-control form-required" name="sigfinal_signatory" id="sigfinal_signatory" <?=$action=='delete'?'disabled':''?>>
                                                    <option value=""> -- SELECT SIGNATORY -- </option>
                                                    <?php foreach($arrSignatory as $signatory):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $SignatoryFin[1] == $signatory['SignCode'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$signatory['SignCode']?>" <?=$selected?>><?=$signatory['Signatory']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Officer <span class="required"> * </span></label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="select2 form-control form-required" name="sigfinal_officer" id="sigfinal_officer" <?=$action=='delete'?'disabled':''?>>
                                                    <option value="0"> -- SELECT EMPLOYEE -- </option>
                                                    <?php foreach($arrEmployees as $data):
                                                            $selected = '';
                                                            if(isset($request_flow)):
                                                                $selected = $SignatoryFin[2] == $data['empNumber'] ? 'selected' : '';
                                                            endif;?>
                                                            <option value="<?=$data['empNumber']?>" <?=$selected?>>
                                                            <?=getfullname($data['firstname'],$data['surname'],$data['middlename'],$data['middleInitial'],$data['nameExtension'])?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row"><div class="col-sm-12"><hr></div></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="control-label col-md-3">&nbsp;</label>
                                        <?php if($action=='delete'): ?>
                                                <a class="btn red" href="javascript:;" id="btn_delete-request">
                                                    <i class="icon-trash"> &nbsp;</i>Delete</a>
                                        <?php else: ?>
                                                <button type="submit" class="btn btn-success" id="btn_submit_signature">
                                                    <i class="icon-check"></i>
                                                <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
                                        <?php endif; ?>
                                    <a href="<?=base_url('libraries/request')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
                                </div>
                            </div>
                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin delete request flow -->
<div id="delete-request" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Request Flow</h4>
            </div>
            <?=form_open('libraries/request/delete/'.$this->uri->segment(4), array('id' => 'frmdel-request'))?>
                <input type="hidden" name="txtdelid">
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Are you sure you want to Delete this data?</label>
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
<!-- end delete request flow -->

<?php load_plugin('js',array('select2','form_validation','select'));?>
<script src="<?=base_url('assets/js/custom/libraries-request_signature.js')?>"></script>

