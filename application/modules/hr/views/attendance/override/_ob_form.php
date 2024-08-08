<style type="text/css">
    div#ms-selemps {
        width: 100% !important;
    }
</style>

<?=load_plugin('css', array('datetimepicker','timepicker','datepicker','select2','multi-select'))?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <span id="spnaction"><?=$action?></span> OB</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?php $form = $action=='add'?'hr/attendance/override/ob_add':'hr/attendance/override/ob_edit/'.$arrob_data[0]['override_id']?>
                        <?=form_open($form, array('method' => 'post', 'id' => 'frmaddsched'))?>
                        <input type="hidden" id="txtoffice" name="txtoffice" value="<?=isset($arrob_data) ? $arrob_data[0]['office'] : ''?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Official Business <span class="required"> * </span></label>
                                    <label><input type="radio" name="isob" value="Y"
                                                <?=isset($arrob_data) ? $arrob_data[0]['official']=='Y' ? 'checked': '' : ''?>> Yes</label>
                                    <label><input type="radio" name="isob" value="N"
                                                <?=isset($arrob_data) ? $arrob_data[0]['official']=='N' ? 'checked': '' : ''?>> No</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 div-type">
                                <div class="form-group">
                                    <label class="control-label">Select Type <span class="required"> * </span></label>
                                    <select class="bs-select form-control" id="seltype" name="seltype">
                                        <option value="">&nbsp;</option>
                                        <option value="AllEmployees" <?=isset($arrob_data) ? $arrob_data[0]['office_type'] == 'AllEmployees' ? 'selected' : '' : ''?>>
                                            All Employees</option>
                                        <?php
                                            foreach(range(1, 5) as $grpno):
                                                $selected = isset($arrob_data) ? $arrob_data[0]['office_type'] == $grpno ? 'selected' : '' : '';
                                                if($_ENV['Group'.$grpno]!=''):
                                                    echo '<option value="'.$grpno.'" '.$selected.'>Per '.$_ENV['Group'.$grpno].'</option>';
                                                endif;
                                            endforeach;
                                            ?>
                                            
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 div-group" <?=isset($arrob_data) ? $arrob_data[0]['office_type'] == 'AllEmployees' ? 'hidden' : '' : ''?>>
                                <div class="form-group div-group1" <?=$_ENV['Group1']!=''? isset($arrob_data) ? $arrob_data[0]['office_type'] == 1 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group1'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup1" id="selgroup1">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup1']) > 0):
                                                foreach($arrGroups['arrGroup1'] as $grp1):
                                                    $selected = isset($arrob_data) ? $arrob_data[0]['office'] == $grp1['group1Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp1['group1Code'].'" '.$selected.'>'.$grp1['group1Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="form-group div-group2" <?=$_ENV['Group2']!=''? isset($arrob_data) ? $arrob_data[0]['office_type'] == 2 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group2'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup2" id="selgroup2">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup2']) > 0):
                                                foreach($arrGroups['arrGroup2'] as $grp2):
                                                    $selected = isset($arrob_data) ? $arrob_data[0]['office'] == $grp2['group2Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp2['group2Code'].'" '.$selected.'>'.$grp2['group2Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="form-group div-group3" <?=$_ENV['Group3']!=''? isset($arrob_data) ? $arrob_data[0]['office_type'] == 3 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group3'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup3" id="selgroup3">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup3']) > 0):
                                                foreach($arrGroups['arrGroup3'] as $grp3):
                                                    $selected = isset($arrob_data) ? $arrob_data[0]['office'] == $grp3['group3Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp3['group3Code'].'" '.$selected.'>'.$grp3['group3Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="form-group div-group4" <?=$_ENV['Group4']!=''? isset($arrob_data) ? $arrob_data[0]['office_type'] == 4 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group4'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup4" id="selgroup4">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup4']) > 0):
                                                foreach($arrGroups['arrGroup4'] as $grp4):
                                                    $selected = isset($arrob_data) ? $arrob_data[0]['office'] == $grp4['group4Code'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$grp4['group4Code'].'" '.$selected.'>'.$grp4['group4Name'].'</option>';
                                                endforeach;
                                            endif;?>
                                    </select>
                                </div>
                                <div class="form-group div-group5" <?=$_ENV['Group5']!=''? isset($arrob_data) ? $arrob_data[0]['office_type'] == 5 ? '' : 'hidden' : 'hidden' : 'hidden'?>>
                                    <label class="control-label">Select <?=ucfirst($_ENV['Group5'])?> <span class="required"> * </span></label>
                                    <select class="select2 form-control selper" name="selgroup5" id="selgroup5">
                                        <option value="0">ALL</option>
                                        <?php 
                                            if(count($arrGroups['arrGroup5']) > 0):
                                                foreach($arrGroups['arrGroup5'] as $grp5):
                                                    $selected = isset($arrob_data) ? $arrob_data[0]['office'] == $grp5['group5Code'] ? 'selected' : '' : '';
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
                                                    $selected = isset($arrob_data) ? $arrob_data[0]['appt_status'] == $appt['appointmentCode'] ? 'selected' : '' : '';
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
                                                $selected = isset($arrob_data) ? in_array($emp['empNumber'], array_column($arrob_data,'empNumber')) ? 'selected' : '' : '';
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
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label">Date <span class="required"> * </span></label>
                                    <div class="input-group input-daterange" data-date="2003">
                                        <input type="text" class="form-control form-required date-picker"
                                            value="<?=isset($arrob_data) ? $arrob_data[0]['obDateFrom'] : ''?>" name="ob_datefrom" data-date-format="yyyy-mm-dd">
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" class="form-control form-required date-picker"
                                            value="<?=isset($arrob_data) ? $arrob_data[0]['obDateTo'] : ''?>" name="ob_dateto" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Time From <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-clock-o"></i>
                                        <input type="text" class="form-control timepicker form-required timepicker-default"
                                            name="ob_timefrom" id="ob_timefrom" value="<?=isset($arrob_data) ? $arrob_data[0]['obTimeFrom'] : '08:00:00 AM'?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Time To <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-clock-o"></i>
                                        <input type="text" class="form-control timepicker form-required timepicker-default"
                                            name="ob_timeto" id="ob_timeto" value="<?=isset($arrob_data) ? $arrob_data[0]['obTimeTo'] : '05:00:00 PM'?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label">Place <span class="required"> * </span></label>
                                    <input type="text" class="form-control" 
                                        value="<?=isset($arrob_data) ? $arrob_data[0]['obPlace'] : ''?>" name="txtob_place" id="txtob_place">
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label">&nbsp;</label>
                                    <br>
                                    <label><input type="checkbox" name="chk_obmeal" id="chk_obmeal"
                                                <?=isset($arrob_data) ? $arrob_data[0]['obMeal']=='Y' ? 'checked' : '' : ''?>> With Meal</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label">Purpose <span class="required"> * </span></label>
                                    <textarea class="form-control" name="txtob_purpose" id="txtob_purpose"><?=isset($arrob_data) ? $arrob_data[0]['purpose'] : ''?></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-actions">
                                    <?php if($action=='add')
                                    { ?>
                                        <button class="btn green" type="submit" id="btn_add_deduction"><i class="fa fa-plus"></i> Add </button>
                                    <?php } elseif($action=='edit')
                                    { ?>
                                        <button class="btn green" type="submit" id="btn_add_deduction"><i class="fa fa-plus"></i> Save </button>
                                    <?php } ?>
                                    <a href="<?=base_url('hr/attendance/override/ob')?>" class="btn blue">
                                        <i class="icon-ban"></i> Cancel</a>
                                </div>
                            </div>
                        </div>
                        <textarea id="txtobid" name="txtobid" hidden><?=isset($arrob_data) ? json_encode(array_column($arrob_data, 'obID')) : ''?></textarea>
                        <textarea id="txtemp_ob" hidden><?=isset($arrob_data) ? json_encode(array_column($arrob_data, 'empNumber')) : ''?></textarea>
                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?=load_plugin('js',array('datetimepicker','timepicker','datepicker','select2','multi-select'));?>

<script src="<?=base_url('assets/js/custom/override-js_ob.js')?>"></script>