<style type="text/css">
    div#ms-selemps {
        width: 100% !important;
    }
</style>

<?=load_plugin('css', array('select2','multi-select'))?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <span id="spnaction"><?=$action?></span> Employee to Exclude in DTR</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?php $form = $action=='add'?'hr/attendance/override/exclude_dtr_add':'hr/attendance/override/exclude_dtr_edit/'.$arrexecdtr_data['excdtr']['override_id']?>
                        <?=form_open($form, array('method' => 'post', 'id' => 'frmaddsched'))?>
                        <input type="hidden" id="txtoffice" name="txtoffice" value="<?=isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office'] : ''?>">
                        <div class="row">
                            <div class="col-md-4 div-type">
                                <div class="form-group">
                                    <label class="control-label">Select Type <span class="required"> * </span></label>
                                    <select class="bs-select form-control" id="seltype" name="seltype">
                                        <option value="">&nbsp;</option>
                                        <option value="AllEmployees" <?=isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office_type'] == 'AllEmployees' ? 'selected' : '' : ''?>>
                                            All Employees</option>
                                        <?php
                                            foreach(range(1, 5) as $grpno):
                                                $selected = isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office_type'] == $grpno ? 'selected' : '' : '';
                                                if($_ENV['Group'.$grpno]!=''):
                                                    echo '<option value="'.$grpno.'" '.$selected.'>Per '.$_ENV['Group'.$grpno].'</option>';
                                                endif;
                                            endforeach;
                                            ?>
                                            
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 div-group" <?=isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office_type'] == '' || $arrexecdtr_data['excdtr']['office_type'] == 'AllEmployees' ? 'hidden' : '' : ''?>>
                                <div class="form-group div-group1" <?=$_ENV['Group1']!=''? isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office_type'] == 1 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group1'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup1" id="selgroup1">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup1']) > 0):
                                                foreach($arrGroups['arrGroup1'] as $grp1):
                                                    $selected = isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office'] == $grp1['group1Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp1['group1Code'].'" '.$selected.'>'.$grp1['group1Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="form-group div-group2" <?=$_ENV['Group2']!=''? isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office_type'] == 2 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group2'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup2" id="selgroup2">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup2']) > 0):
                                                foreach($arrGroups['arrGroup2'] as $grp2):
                                                    $selected = isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office'] == $grp2['group2Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp2['group2Code'].'" '.$selected.'>'.$grp2['group2Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="form-group div-group3" <?=$_ENV['Group3']!=''? isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office_type'] == 3 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group3'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup3" id="selgroup3">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup3']) > 0):
                                                foreach($arrGroups['arrGroup3'] as $grp3):
                                                    $selected = isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office'] == $grp3['group3Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp3['group3Code'].'" '.$selected.'>'.$grp3['group3Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="form-group div-group4" <?=$_ENV['Group4']!=''? isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office_type'] == 4 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group4'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup4" id="selgroup4">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup4']) > 0):
                                                foreach($arrGroups['arrGroup4'] as $grp4):
                                                    $selected = isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office'] == $grp4['group4Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp4['group4Code'].'" '.$selected.'>'.$grp4['group4Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="form-group div-group5" <?=$_ENV['Group5']!=''? isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office_type'] == 5 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group5'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup5" id="selgroup5">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup5']) > 0):
                                                foreach($arrGroups['arrGroup5'] as $grp5):
                                                    $selected = isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['office'] == $grp5['group5Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp5['group5Code'].'" '.$selected.'>'.$grp5['group5Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 div-apptstatus">
                                <div class="form-group">
                                    <label class="control-label">Appointment Status <span class="required"> * </span></label>
                                    <select class="select2 form-control" name="selappt" id="selappt">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrAppointments) > 0):
                                                foreach($arrAppointments as $appt):
                                                    $selected = isset($arrexecdtr_data) ? $arrexecdtr_data['excdtr']['appt_status'] == $appt['appointmentCode'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$appt['appointmentCode'].'" '.$selected.'>'.$appt['appointmentDesc'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="control-label">Employees <span class="required"> * </span></label>
                                    <select multiple="multiple" class="multi-select form-control" id="selemps" name="selemps[]">
                                        <optgroup label="SELECT ALL">
                                        <?php
                                            foreach($arrEmployees as $emp):
                                                $selected = isset($arrexecdtr_data) ? in_array($emp['empNumber'], array_column($arrexecdtr_data['emps'],'empNumber')) ? 'selected' : '' : '';
                                                echo '<option data-grp1="'.$emp['group1'].'"
                                                              data-grp2="'.$emp['group2'].'"
                                                              data-grp3="'.$emp['group3'].'"
                                                              data-grp4="'.$emp['group4'].'"
                                                              data-grp5="'.$emp['group5'].'"
                                                              data-appt="'.$emp['appointmentCode'].'" '.$selected.' value="'.$emp['empNumber'].'">'.
                                                        getfullname($emp['firstname'],$emp['surname'],$emp['middlename'],$emp['middleInitial'],$emp['nameExtension']).'</option>';
                                            endforeach; ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <textarea hidden id="json_employee"><?=json_encode($arrEmployees)?></textarea>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-actions">
                                    <button class="btn green" type="submit" id="btn_add_deduction"><i class="fa fa-plus"></i> <?=ucfirst($action)?> </button>
                                    <a href="<?=base_url('hr/attendance/override/exclude_dtr')?>" class="btn blue">
                                        <i class="icon-ban"></i> Cancel</a>
                                </div>
                            </div>
                        </div>
                        <textarea hidden id="txtemp_ob" name="txtemp_ob"><?=isset($arrexecdtr_data) ? json_encode(array_column($arrexecdtr_data['emps'], 'empNumber')) : ''?></textarea>
                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?=load_plugin('js',array('select2','multi-select'));?>

<script src="<?=base_url('assets/js/custom/override-js_excdtr.js')?>"></script>