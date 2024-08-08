<?php load_plugin('css', array('select2','datepicker')) ?>
<div id="payrollDetails_modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Payroll Details</h4>
            </div>
            <?=form_open('finance/compensation/personnel_profile/edit_payrollDetails/'.$this->uri->segment(5), array('id' => 'frmpayrollDetails'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Payroll Group<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <select class="form-control select2 form-required" name="selpayrollGrp" id="selpayrollGrp" placeholder="">
                                        <option value="">SELECT PAYROLL GROUP</option>
                                        <?php foreach($pGroups as $pg): ?>
                                            <option value="<?=$pg['payrollGroupCode']?>" <?=$pg['payrollGroupCode'] == $arrData['payrollGroupCode'] ? 'selected' : ''?>>
                                                (<?=$pg['projectDesc']?>) <?=$pg['payrollGroupName']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Included in Payroll<span class="required"> * </span></label>
                                <div class="input-icon">
                                    <div class="radio-list radio-required" style="padding-bottom: 13px;">
                                        <label class="radio-inline">
                                            <input type="radio" name="chkis_incPayroll" value="Y" <?=isset($arrData) ? $arrData['payrollSwitch'] == 'Y' ? 'checked' : '' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="chkis_incPayroll" value="N" <?=isset($arrData) ? $arrData['payrollSwitch'] = 'N' ? 'checked' : '' : 'checked'?>> No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Attendance Scheme<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <select class="form-control select2 form-required" name="selattScheme" id="selattScheme" placeholder="">
                                        <option value="">SELECT ATTENDANCE SCHEME</option>
                                        <?php foreach($arrAttSchemes as $as): ?>
                                            <option value="<?=$as['code']?>" <?=$as['code'] == $arrData['schemeCode'] ? 'selected' : ''?>>
                                                <?=$as['label']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Payroll Account Number<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtacctNumber" id="txtacctNumber" value="<?=isset($arrData) ? $arrData['AccountNum'] : ''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Self Employed Tax Status</label>
                                <div class="input-icon">
                                    <div class="radio-list " style="padding-bottom: 13px;">
                                        <label class="radio-inline">
                                            <input type="radio" name="chkis_selfemployed" value="Y" <?=isset($arrData) ? $arrData['taxSwitch'] == 'Y' ? 'checked' : '' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="chkis_selfemployed" value="N" <?=isset($arrData) ? $arrData['taxSwitch'] != 'Y' ? 'checked' : '' : 'checked'?>> No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">With Government Vehicle<span class="required"> * </span></label>
                                <div class="input-icon">
                                    <div class="radio-list radio-required" style="padding-bottom: 13px;">
                                        <label class="radio-inline">
                                            <input type="radio" name="chkw_govt_vehicle" value="Y" <?=isset($arrData) ? $arrData['RATAVehicle'] == 'Y' ? 'checked' : '' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="chkw_govt_vehicle" value="N" <?=isset($arrData) ? $arrData['RATAVehicle'] != 'Y' ? 'checked' : '' : 'checked'?>> No </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tax Status<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <select class="form-control select2 form-required" name="seltaxStatus" id="seltaxStatus" placeholder="">
                                        <option value="">SELECT TAX STATUS</option>
                                        <?php foreach($tax_status as $tstat): ?>
                                            <option value="<?=$tstat['taxStatus']?>" <?=$tstat['taxStatus'] == $arrData['taxStatCode'] ? 'selected' : ''?>>
                                                <?=$tstat['taxStatus']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">No. of Dependents<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtnodependents" id="txtnodependents" value="<?=isset($arrData) ? $arrData['dependents'] : ''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">With Health Insurance Exemption ?<span class="required"> * </span></label>
                                <div class="input-icon">
                                    <div class="radio-list radio-required" style="padding-bottom: 13px;">
                                        <label class="radio-inline">
                                            <input type="radio" name="chkis_health" value="Y" <?=isset($arrData) ? $arrData['healthProvider'] == 'Y' ? 'checked' : '' : ''?>> Yes </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="chkis_health" value="N" <?=isset($arrData) ? $arrData['healthProvider'] == 'N' ? 'checked' : '' : 'checked'?>> No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tax Rate<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txttxtRate" id="txttxtRate" value="<?=isset($arrData) ? $arrData['taxRate'] : ''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">(Authorize Salary *) Hazard Pay Factor<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" class="form-control" name="txthazardPay" id="txthazardPay" value="<?=isset($arrData) ? $arrData['hpFactor'] : ''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">RATA Code</label>
                                <div class="input-icon right">
                                    <select class="form-control select2" name="selrataCode" id="selrataCode" placeholder="">
                                        <option value="">SELECT RATA CODE</option>
                                        <?php foreach($arrRataCode as $rc): ?>
                                            <option value="<?=$rc['RATACode']?>" <?=$rc['RATACode'] == $arrData['RATACode'] ? 'selected' : ''?>>
                                                <?=$rc['RATACode']?> (<?=$rc['RATAAmount']?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-payrollDetails" class="btn green"><i class="icon-check"> </i> Save</button>
                    <button type="button" class="btn blue" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<div id="positionDetails_modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Position Details</h4>
            </div>
            <?=form_open('finance/compensation/personnel_profile/edit_positionDetails/'.$this->uri->segment(5), array('id' => 'frmpayrolldetails'))?>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Appointment Desc<span class="required"> * </span></label>
                            <div class="input-icon right">
                                <select class="form-control select2 form-required" name="selappointment" id="selappointment" placeholder="">
                                    <option value="">SELECT APPOINTMENT</option>
                                    <?php foreach($arrAppointments as $app): ?>
                                        <option value="<?=$app['appointmentCode']?>" <?=$app['appointmentDesc'] == $arrData['appointmentDesc'] ? 'selected' : ''?>>
                                            <?=$app['appointmentDesc']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Item Number<span class="required"> * </span></label>
                            <div class="input-icon right">
                                <select class="form-control select2" name="selitem" id="selitem" placeholder="">
                                    <option value="NULL">SELECT ITEM NUMBER</option>
                                    <?php foreach($arrPlantillaList as $plantilla): ?>
                                        <option value="<?=$plantilla['itemNumber']?>" <?=$plantilla['itemNumber'] == $arrData['itemNumber'] ? 'selected' : ''?>>
                                            <?=$plantilla['itemNumber']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Actual Salary<span class="required"> * </span></label>
                            <div class="input-icon right">
                                <input type="text" class="form-control form-required" name="txtactual_salary" id="txtactual_salary" value="<?=isset($arrData) ? $arrData['actualSalary'] : ''?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Authorize Salary<span class="required"> * </span></label>
                            <div class="input-icon right">
                                <input type="text" class="form-control form-required" name="txtauth_salary" id="txtauth_salary" value="<?=isset($arrData) ? $arrData['authorizeSalary'] : ''?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Position<span class="required"> * </span></label>
                            <div class="input-icon right">
                                <input type="text" class="form-control" value="<?=isset($arrData) ? $arrData['positionDesc'] : ''?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Position Date</label>
                            <input class="form-control date-picker" data-date="2012-03-01" data-date-format="yyyy-mm-dd" name="txtposdate"
                                id="txtposdate" type="text" value="<?=isset($arrData) ? $arrData['positionDate'] == '0000-00-00' ? '' : $arrData['positionDate'] : ''?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Employment Status<span class="required"> * </span></label>
                            <div class="input-icon right">
                                <select class="form-control select2 form-required" name="selmodeofseparation" id="selmodeofseparation" placeholder="">
                                    <option value="">SELECT STATUS</option>
                                    <option value="In-Service" <?='In-Service' == $arrData['statusOfAppointment'] ? 'selected' : ''?>>
                                    In Service</option>
                                    <?php foreach($arrSeparationModes as $mode): ?>
                                        <option value="<?=$mode['separationCause']?>" <?=$mode['separationCause'] == $arrData['statusOfAppointment'] ? 'selected' : ''?>>
                                            <?=$mode['separationCause']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Salary Grade<span class="required"> * </span></label>
                            <div class="input-icon right">
                                <input type="text" class="form-control form-required" name="txtsalaryGrade" id="txtsalaryGrade" value="<?=isset($arrData) ? $arrData['salaryGradeNumber'] : ''?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Step Number<span class="required"> * </span></label>
                            <div class="input-icon right">
                                <select class="form-control bs-select form-required" name="selStep_number" id="selStep_number" placeholder="select step number">
                                    <option value="">SELECT STEP</option>
                                    <?php foreach (range(1, 8) as $step): ?>
                                        <option value="<?=$step?>" <?=$step == $arrData['stepNumber'] ? 'selected' : ''?>>
                                            <?=$step?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date Increment</label>
                            <input class="form-control date-picker" data-date="2012-03-01" data-date-format="yyyy-mm-dd" name="txtdateincrement"
                                id="txtdateincrement" type="text" value="<?=isset($arrData) ? $arrData['dateIncremented'] == '0000-00-00' ? '' : $arrData['dateIncremented'] : ''?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnsubmit-positionDetails" class="btn green"><i class="icon-check"> </i> Save</button>
                <button type="button" class="btn blue" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
            </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<?php load_plugin('js', array('select2','datepicker','form_validation')) ?>
<script>
    $('select.select2').select2({
        minimumResultsForSearch: -1,
        placeholder: function(){
            $(this).data('placeholder');
        }
    });
    $('#txtposdate, #txtdateincrement').datepicker();
</script>