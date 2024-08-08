<?=load_plugin('css', array('select','select2','datepicker'))?>
<!-- begin modal update position details info -->
<div class="modal fade in" id="edit_position_details" aria-hidden="true">
    <div class="modal-dialog-lg" style="width: 75%;margin: 5% auto;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b>Edit Position Details</b></h5>
            </div>
            <?=form_open('pds/edit_position_details/'.$this->uri->segment(3), array('method' => 'post', 'name' => 'frmemp_posdetails','class' => 'form-horizontal'))?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Service Code</label>
                                <div class="col-md-8">
                                    <select class="form-control bs-select" name="sel_srvcode">
                                        <option value=""> </option>
                                        <?php foreach($service_code as $srv):
                                                $selected = $srv['serviceCode'] == $arrPosition[0]['service'] ? 'selected' : '';
                                                echo '<option value="'.$srv['serviceCode'].'" '.$selected.'>'.$srv['serviceDesc'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Day Government</label>
                                <div class="col-md-8">
                                <?php if ($arrPosition[0]['firstDayGov']=='0000-00-00')
                                { ?>
                                    <input class="form-control date-picker form-required" name="txt_fday_govt" type="text" data-date-format="yyyy-mm-dd">
                                <?php } else { ?>
                                    <input type="text" name="txt_fday_govt" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?=$arrPosition[0]['firstDayGov']?>">
                                <?php } ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">First Day Agency</label>
                                <div class="col-md-8">
                                 <?php if ($arrPosition[0]['firstDayAgency']=='0000-00-00')
                                { ?>
                                     <input class="form-control date-picker form-required" name="txt_fday_agency" type="text" data-date-format="yyyy-mm-dd">
                                <?php } else { ?>
                                    <input type="text" name="txt_fday_agency" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?=$arrPosition[0]['firstDayAgency']?>">
                                <?php } ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Employment Status<span class="required"> * </span></label>
                                <div class="col-md-8">
                                    <select class="form-control bs-select" name="selmode_separation">
                                        <option value=""> </option>
                                        <?php foreach($mode_separation as $mode):
                                                $selected = $mode['statusOfAppointment'] == $arrPosition[0]['statusOfAppointment'] ? 'selected' : '';
                                                echo '<option value="'.$mode['statusOfAppointment'].'" '.$selected.'>'.$mode['statusOfAppointment'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Separation Date</label>
                                <div class="col-md-8">
                                <?php if ($arrPosition[0]['contractEndDate']=='0000-00-00')
                                { ?>
                                    <input class="form-control date-picker form-required" name="txt_sep_date" type="text" data-date-format="yyyy-mm-dd">
                                <?php } else { ?>
                                    <input type="text" name="txt_sep_date" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?=$arrPosition[0]['contractEndDate']?>">
                                <?php } ?>
                                    <!-- name="txtseparation_date" -->
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Appointment Desc</label>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="selappt_desc">
                                        <option value=""> </option>
                                        <?php foreach($arrAppointments as $appt):
                                                $selected = $appt['appointmentCode'] == $arrPosition[0]['appointmentCode'] ? 'selected' : '';
                                                echo '<option value="'.$appt['appointmentCode'].'" '.$selected.'>'.$appt['appointmentDesc'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Executive Office</label>
                                <div class="col-md-8">
                                    <select class="form-control bs-select" name="selexec">
                                        <option value=""> </option>
                                        <?php foreach($arrOrganization as $exec):
                                                $selected = $exec['group1Code'] == $arrPosition[0]['officecode'] ? 'selected' : '';
                                                echo '<option value="'.$exec['group1Code'].'" '.$selected.'>'.$exec['group1Code'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Service</label>
                                <div class="col-md-8">
                                    <!-- <input type="text" name="selservice" class="form-control" value=""> -->
                                     <select class="form-control bs-select" name="selservice">
                                        <option value=""> </option>
                                        <?php foreach($arrServiceCode as $service):
                                                $selected = $service['group2Code'] == $arrPosition[0]['serviceCode'] ? 'selected' : '';
                                                echo '<option value="'.$service['group2Code'].'" '.$selected.'>'.$service['group2Code'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Division</label>
                                <div class="col-md-8">
                                    <!-- <input type="text" name="seldivision" class="form-control" value=""> -->
                                    <select class="form-control bs-select" name="seldivision">
                                        <option value=""> </option>
                                        <?php foreach($arrDivision as $division):
                                                $selected = $division['group3Code'] == $arrPosition[0]['divisionCode'] ? 'selected' : '';
                                                echo '<option value="'.$division['group3Code'].'" '.$selected.'>'.$division['group3Code'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Section</label>
                                <div class="col-md-8">
                                    <!-- <input type="text" name="" class="form-control" value=""> -->
                                    <select class="form-control bs-select" name="selsection">
                                        <option value=""> </option>
                                        <?php foreach($arrSection as $section):
                                                $selected = $section['group4Code'] == $arrPosition[0]['sectionCode'] ? 'selected' : '';
                                                echo '<option value="'.$section['group4Code'].'" '.$selected.'>'.$section['group4Code'].'</option>';
                                        endforeach; ?>
                                        <?php foreach($arrSection1 as $section1):
                                                $selected1 = $section1['group5Code'] == $arrPosition[0]['sectionCode'] ? 'selected' : '';
                                                echo '<option value="'.$section1['group5Code'].'" '.$selected1.'>'.$section1['group5Code'].'</option>';
                                        endforeach; ?>

                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Department</label>
                                <div class="col-md-8">
                                    <!-- <input type="text" name="" class="form-control" value=""> -->
                                    <select class="form-control bs-select" name="seldepartment">
                                        <option value=""> </option>
                                        <?php foreach($arrDepartment as $department):
                                                $selected = $department['group5Code'] == $arrPosition[0]['deptCode'] ? 'selected' : '';
                                                echo '<option value="'.$department['group5Code'].'" '.$selected.'>'.$department['group5Code'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <?php //print_r($arrProcessWith);
                            $arrPerm = explode(',',$arrProcessWith[0]['processWith']);
                            // print_r($arrPerm);
                            if(in_array($arrPosition[0]['appointmentCode'],$arrPerm)){
                            ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Item Number</label>
                                <input type="hidden" id="txtunique_itemno" name="txtunique_itemno" value="<?=$arrPosition[0]['uniqueItemNumber']?>">
                                <div class="col-md-8">
                                    <select class="form-control select2" id="sel_plantilla" name="sel_plantilla">
                                        <option value=""> </option>
                                        <?php foreach($arrplantilla as $plantilla):
                                                $selected = $plantilla['itemNumber'] == $arrPosition[0]['itemNumber'] ? 'selected' : '';
                                                echo '<option id="'.$plantilla['uniqueItemNumber'].'" value="'.$plantilla['itemNumber'].'" '.$selected.'>'.$plantilla['itemNumber'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <?php } ?>
                            
                             <div class="form-group">
                                <label class="col-md-3 control-label">Actual Salary</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtactual_salary" class="form-control" 
                                        value="<?=isset($arrPosition) ? number_format($arrPosition[0]['actualSalary'],2) : ''?>" >
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Authorize Salary</label>
                                <div class="col-md-8">
                                 <?php if ($arrPosition[0]['appointmentCode']=='P')
                                    { ?>
                                    <input type="text" name="txtauthorized_salary" class="form-control" 
                                        value="<?=isset($arrPosition) ? number_format($arrPosition[0]['authorizeSalary'],2) : ''?>" disabled>
                                    <?php } else { ?>
                                         <input type="text" name="txtauthorized_salary" class="form-control" 
                                        value="<?=isset($arrPosition) ? number_format($arrPosition[0]['authorizeSalary'],2) : ''?>" >
                                    <?php } ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Position</label>
                                <div class="col-md-8">
                                    <select class="form-control bs-select" name="txtplant_pos">
                                        <option value=""> </option>
                                        <?php foreach($arrpositions as $pos):
                                                $selected = $pos['positionCode'] == $arrPosition[0]['positionCode'] ? 'selected' : '';
                                                echo '<option value="'.$pos['positionCode'].'" '.$selected.'>'.$pos['positionDesc'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Position Date</label>
                                <div class="col-md-8">
                                <?php if ($arrPosition[0]['positionDate']=='0000-00-00')
                                { ?>
                                    <input class="form-control date-picker form-required" name="txtposition_date" type="text" data-date-format="yyyy-mm-dd">
                                <?php } else { ?>
                                    <input type="text" name="txtposition_date" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?=$arrPosition[0]['positionDate']?>">
                                <?php } ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Salary Effectivity Date</label>
                                <div class="col-md-8">
                                <?php if ($arrPosition[0]['effectiveDate']=='0000-00-00')
                                { ?>
                                    <input class="form-control date-picker form-required" name="txtsalary_eff_date" type="text" data-date-format="yyyy-mm-dd">
                                <?php } else { ?>
                                    <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" name="txtsalary_eff_date" type="text" value="<?=$arrPosition[0]['effectiveDate']?>">
                                <?php } ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Employment Basis</label>
                                <div class="col-md-8">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="optemp_basis" value="FullTime"
                                                <?=$arrPosition[0]['employmentBasis'] == 'FullTime' ? 'checked' : ''?>> Full Time </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="optemp_basis" value="PartTime"
                                                <?=$arrPosition[0]['employmentBasis'] == 'PartTime' ? 'checked' : ''?>> Part Time </label>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Category Service</label>
                                <div class="col-md-8">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="optcateg_srv" value="Career"
                                                <?=$arrPosition[0]['categoryService'] == 'Career' ? 'checked' : ''?>> Career </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="optcateg_srv" value="Non-Career"
                                                <?=$arrPosition[0]['categoryService'] == 'Non-Career' ? 'checked' : ''?>> Non-Career </label>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Tax Status</label>
                                <div class="col-md-8">
                                    <select class="form-control bs-select" name="sel_tax_stat">
                                        <option value=""> </option>
                                        <?php foreach($tax_stat as $stat):
                                                $selected = $stat['taxStatus'] == $arrPosition[0]['taxStatCode'] ? 'selected' : '';
                                                echo '<option value="'.$stat['taxStatus'].'" '.$selected.'>'.$stat['taxStatus'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">No. of Dependents</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtno_dependents" class="form-control" value="<?=isset($arrPosition) ? $arrPosition[0]['dependents'] : ''?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Place of Assignment</label>
                                <div class="col-md-8">
                                    <!-- <input type="text" name="txtassign_place" value="<?=$arrPosition[0]['assignPlace']?>" class="form-control" value=""> -->

                                    <select name="txtassign_place" value="<?=$arrPosition[0]['assignPlace']?>" class="form-control bs-select"> 
                                        <option value=""> </option>
                                        <option <?php if ($arrPosition[0]['assignPlace'] == 'Detailed to' ) echo 'selected' ; ?> value="Detailed to">Detailed to</option>
                                        <option <?php if ($arrPosition[0]['assignPlace'] == 'Detailed from' ) echo 'selected' ; ?> value="Detailed from">Detailed from</option>
                                        <option <?php if ($arrPosition[0]['assignPlace'] == 'Not Applicable' ) echo 'selected' ; ?> value="Not Applicable">Not Applicable</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Personnel Action</label>
                                <div class="col-md-8">
                                    <select class="form-control bs-select" name="selper_action" value="<?=!empty($arrPosition['personnelAction'])?$arrPosition['personnelAction']:''?>">
                                    <!-- value="<?=$arrPosition[0]['personnelAction']?> -->
                                        <option <?php if ($arrPosition[0]['personnelAction'] == '' ) echo 'selected' ; ?> value=""> </option>
                                        <option <?php if ($arrPosition[0]['personnelAction'] == 'Appointment through certification' ) echo 'selected' ; ?> value="Appointment through certification">Appointment through certification</option>
                                        <option <?php if ($arrPosition[0]['personnelAction'] == 'Promotion' ) echo 'selected' ; ?> value="Promotion">Promotion</option>
                                        <option <?php if ($arrPosition[0]['personnelAction'] == 'Transfer' ) echo 'selected' ; ?> value="Transfer">Transfer</option>
                                        <option <?php if ($arrPosition[0]['personnelAction'] == 'Reinstatement' ) echo 'selected' ; ?> value="Reinstatement">Reinstatement</option>
                                        <option <?php if ($arrPosition[0]['personnelAction'] == 'Reemployment' ) echo 'selected' ; ?> value="Reemployment">Reemployment</option>
                                        <option <?php if ($arrPosition[0]['personnelAction'] == 'Details' ) echo 'selected' ; ?> value="Original">Detail</option>
                                        <option <?php if ($arrPosition[0]['personnelAction'] == 'Reassignment' ) echo 'selected' ; ?> value="Reassignment">Reassignment</option>
                                        <option <?php if ($arrPosition[0]['personnelAction'] == 'Original' ) echo 'selected' ; ?> value="Original">Original</option>
                                        
                                        
                                    </select>
                                         <?php //foreach($personnel_action as $action):
                                        //         $selected = $action['personnelAction'] == $arrPosition[0]['personnelAction'] ? 'selected' : '';
                                        //         echo '<option value="'.$action['personnelAction'].'" '.$selected.'>'.$action['personnelAction'].'</option>';
                                        //       endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Salary Grade</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtsalary_grade" class="form-control" value="<?=$arrPosition[0]['salaryGradeNumber']?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Step Number</label>
                                <div class="col-md-8">
                                    <select class="form-control bs-select" name="selStep_number" >
                                        <option value=""> </option>
                                        <?php foreach (range(1, 8) as $step): ?>
                                            <option value="<?=$step?>" <?=$step == $arrPosition[0]['stepNumber'] ? 'selected' : ''?>>
                                                <?=$step?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Date Increment</label>
                                <div class="col-md-8">
                                <?php if ($arrPosition[0]['dateIncremented']=='0000-00-00')
                                { ?>
                                    <input class="form-control date-picker form-required" name="txt_date_inc" type="text" data-date-format="yyyy-mm-dd">
                                <?php } else { ?>
                                    <input type="text" name="txt_date_inc" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?=$arrPosition[0]['dateIncremented']?>">
                                <?php } ?>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save</button>
            </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end modal update position details info -->

<!-- begin modal update payroll details info -->
<div class="modal fade in" id="edit_payroll_details" aria-hidden="true">
    <div class="modal-dialog-lg" style="width: 75%;margin: 5% auto;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b>Edit Payroll Details</b></h5>
            </div>
            <?=form_open('pds/edit_payroll_details/'.$this->uri->segment(3), array('method' => 'post', 'name' => 'employeeform','class' => 'form-horizontal'))?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Payroll Group</label>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="selpayrollGrp" placeholder="">
                                        <option value=""></option>
                                        <?php foreach($pGroups as $pg): ?>
                                            <option value="<?=$pg['payrollGroupCode']?>" <?=$pg['payrollGroupCode'] == $arrData[0]['payrollGroupCode'] ? 'selected' : ''?>>
                                                (<?=$pg['payrollGroupCode']?>) <?=$pg['payrollGroupName']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Include in DTR?</label>
                                <div class="col-md-8">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_dtr" value="Y"
                                                <?=$arrPosition[0]['dtrSwitch'] == 'Y' ? 'checked' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_dtr" value="N"
                                                <?=$arrPosition[0]['dtrSwitch'] == 'N' ? 'checked' : ''?>> No </label>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Attendance Scheme</label>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="selattScheme" placeholder="">
                                        <option value=""></option>
                                        <?php foreach($arrAttSchemes as $as): ?>
                                            <option value="<?=$as['code']?>" <?=$as['code'] == $arrData[0]['schemeCode'] ? 'selected' : ''?>>
                                                <?=$as['label']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Include in PhilHealth?</label>
                                <div class="col-md-8">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_phealth" value="Y"
                                                <?=$arrPosition[0]['philhealthSwitch'] == 'Y' ? 'checked' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_phealth" value="N"
                                                <?=$arrPosition[0]['philhealthSwitch'] == 'N' ? 'checked' : ''?>> No </label>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Include in Life & Retirement?</label>
                                <div class="col-md-8">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_liferet" value="Y"
                                                <?=$arrPosition[0]['lifeRetSwitch'] == 'Y' ? 'checked' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_liferet" value="N"
                                                <?=$arrPosition[0]['lifeRetSwitch'] == 'N' ? 'checked' : ''?>> No </label>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Include in Payroll?</label>
                                <div class="col-md-8">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_payroll" value="Y"
                                                <?=$arrPosition[0]['payrollSwitch'] == 'Y' ? 'checked' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_payroll" value="N"
                                                <?=$arrPosition[0]['payrollSwitch'] == 'N' ? 'checked' : ''?>> No </label>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Hazard Pay Factor</label>
                                <div class="col-md-8">
                                    <input type="text" name="txthazard" value="<?=$arrPosition[0]['hpFactor']?>" class="form-control" value="">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Include in PAGIBIG?</label>
                                <div class="col-md-8">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_pagibig" value="Y"
                                                <?=$arrPosition[0]['pagibigSwitch'] == 'Y' ? 'checked' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="inc_pagibig" value="N"
                                                <?=$arrPosition[0]['pagibigSwitch'] == 'N' ? 'checked' : ''?>> No </label>
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save</button>
            </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end modal update payroll details info -->

<!-- begin modal update plantilla details info -->
<div class="modal fade in" id="edit_plantilla_details" aria-hidden="true">
    <div class="modal-dialog-lg" style="width: 75%;margin: 5% auto;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b>Edit Plantilla Position Details</b></h5>
            </div>
            <?=form_open('pds/edit_plantilla_details/'.$this->uri->segment(3), array('method' => 'post', 'name' => 'employeeform','class' => 'form-horizontal'))?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <!-- <div class="form-group">
                                <label class="col-md-3 control-label">Item Number</label>
                                <input type="hidden" id="txtunique_itemno" name="txtunique_itemno" value="<?=$arrPosition[0]['uniqueItemNumber']?>">
                                <div class="col-md-8">
                                    <select class="form-control select2" id="sel_plantilla" name="sel_plantilla">
                                        <option value=""> </option>
                                        <?php foreach($arrplantilla as $plantilla):
                                                $selected = $plantilla['itemNumber'] == $arrPosition[0]['itemNumber'] ? 'selected' : '';
                                                echo '<option id="'.$plantilla['uniqueItemNumber'].'" value="'.$plantilla['itemNumber'].'" '.$selected.'>'.$plantilla['itemNumber'].'</option>';
                                              endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Actual Salary</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtactual_salary" class="form-control" 
                                        value="<?=isset($arrPosition) ? number_format($arrPosition[0]['actualSalary'],2) : ''?>" disabled>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Authorize Salary</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtauthorized_salary" class="form-control" 
                                        value="<?=isset($arrPosition) ? number_format($arrPosition[0]['authorizeSalary'],2) : ''?>" disabled>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Position</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtplant_pos" class="form-control" value="<?=$arrData[0]['positionDesc']?>" disabled>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Position Date</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtposition_date" class="form-control date-picker"
                                        value="<?=$arrPosition[0]['positionDate']?>" data-date-format="yyyy-mm-dd">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Salary Grade</label>
                                <div class="col-md-8">
                                    <input type="text" name="txtsalary_grade" class="form-control" value="<?=$arrPosition[0]['salaryGradeNumber']?>">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Step Number</label>
                                <div class="col-md-8">
                                    <select class="form-control bs-select" name="selStep_number" placeholder="">
                                        <option value=""></option>
                                        <?php foreach (range(1, 8) as $step): ?>
                                            <option value="<?=$step?>" <?=$step == $arrPosition[0]['stepNumber'] ? 'selected' : ''?>>
                                                <?=$step?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Date Increment</label>
                                <div class="col-md-8">
                                    <input type="text" name="txt_date_inc" class="form-control date-picker" 
                                        value="<?=$arrPosition[0]['dateIncremented']?>" data-date-format="yyyy-mm-dd">
                                    <span class="help-block"></span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save</button>
            </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end modal update plantilla details info -->

<?=load_plugin('js', array('select2','datepicker'))?>

<script>
    $(document).ready(function() {
        $('#sel_plantilla').on('select2:select',function(e) {
            dataid = $(this).find('option:selected').attr('id');
            $('#txtunique_itemno').val(dataid);
        });
    });
</script>