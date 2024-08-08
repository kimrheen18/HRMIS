<?php load_plugin('css', array('datepicker')) ?>
<div id="regularDeductions" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Deduction Update</h4>
                <small>
                    <b id="modal-title"></b>
                    <br><i>Income Type : </i><i id="sub-title"></i>
                </small>
            </div>
            <?=form_open('finance/compensation/personnel_profile/edit_deduction/'.$this->uri->segment(5), array('id' => 'frmBenefit'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <input type="hidden" name="txtdeductcode" id="txtdeductcode">
                        <input type="hidden" name="txtdeductioncode" id="txtdeductioncode">
                        <input type="hidden" name="txtdeductionType" id="txtdeductionType">
                        <input type="hidden" name="txtstat" id="txtstat-loan">
                        <input type="hidden" class="form-required" id="txtperiodcheck" value="1">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Monthly<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtamount" id="txtamount-loan">
                                </div>
                            </div>
                            <div class="form-group" <?=in_array('Period 1', setPeriods($empPayrollProcess)) ? '' : 'hidden'?>>
                                <label class="control-label">Period 1<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="txtperiod1" id="txtperiod1-loan">
                                </div>
                            </div>
                            <div class="form-group" <?=in_array('Period 2', setPeriods($empPayrollProcess)) ? '' : 'hidden'?>>
                                <label class="control-label">Period 2<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="txtperiod2" id="txtperiod2-loan">
                                </div>
                            </div>
                            <div class="form-group" <?=in_array('Period 3', setPeriods($empPayrollProcess)) ? '' : 'hidden'?>>
                                <label class="control-label">Period 3<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="txtperiod3" id="txtperiod3-loan">
                                </div>
                            </div>
                            <div class="form-group" <?=in_array('Period 4', setPeriods($empPayrollProcess)) ? '' : 'hidden'?>>
                                <label class="control-label">Period 4<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="txtperiod4" id="txtperiod4-loan">
                                </div>
                            </div>
                            <div class="div-deduction">
                                <div class="form-group">
                                    <label class="control-label">Start Year<span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="form-control bs-select form-required" name="selsyear" id="selsyr-loan">
                                            <?php foreach (getYear() as $yr): ?>
                                                <option value="<?=$yr?>"
                                                    <?php 
                                                        if(isset($_GET['yr'])):
                                                            echo $_GET['yr'] == $yr ? 'selected' : '';
                                                        else:
                                                            echo $yr == date('Y') ? 'selected' : '';
                                                        endif;
                                                        ?> >  
                                                <?=$yr?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Start Month<span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="form-control bs-select form-required" name="selsmonth" id="selsmonth-loan">
                                            <option value="">SELECT MONTH</option>
                                            <?php foreach (range(1, 12) as $m): ?>
                                                <option value="<?=sprintf('%02d', $m)?>"
                                                    <?php 
                                                        if(isset($_GET['month'])):
                                                            echo $_GET['month'] == $m ? 'selected' : '';
                                                        else:
                                                            echo $m == sprintf('%02d', date('n')) ? 'selected' : '';
                                                        endif;
                                                        ?> >
                                                    <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">End Year<span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="form-control bs-select form-required" name="seleyr" id="seleyr-loan">
                                            <?php foreach (getYear() as $yr): ?>
                                                <option value="<?=$yr?>"
                                                    <?php 
                                                        if(isset($_GET['yr'])):
                                                            echo $_GET['yr'] == $yr ? 'selected' : '';
                                                        else:
                                                            echo $yr == date('Y') ? 'selected' : '';
                                                        endif;
                                                        ?> >  
                                                <?=$yr?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">End Month<span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="form-control bs-select form-required" name="selemonth" id="selemonth-loan">
                                            <option value="">SELECT MONTH</option>
                                            <?php foreach (range(1, 12) as $m): ?>
                                                <option value="<?=sprintf('%02d', $m)?>"
                                                    <?php 
                                                        if(isset($_GET['month'])):
                                                            echo $_GET['month'] == $m ? 'selected' : '';
                                                        else:
                                                            echo $m == sprintf('%02d', date('n')) ? 'selected' : '';
                                                        endif;
                                                        ?> >
                                                    <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Status<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <select class="form-control bs-select form-required" name="selstatus" id="selstatus-loan">
                                        <option value="">SELECT STATUS</option>
                                        <?php foreach($arrStatus as $id=>$desc): ?>
                                            <option value="<?=$id?>">
                                                <?=$desc?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnupdateallemployee-loan" class="btn green pull-left">
                        <i class="icon-check"> </i> Update All Employee</button>
                    <button type="submit" id="btnsubmit-premloans" class="btn green"><i class="icon-check"> </i> Save</button>
                    <button type="button" class="btn blue" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<div id="deleteLongevity" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Longevity</h4>
            </div>
            <?=form_open('finance/compensation/personnel_profile/actionLongevity/'.$this->uri->segment(5), array('id' => 'frmdellongevity'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtdel_action" id="txtdel_action">
                            <input type="hidden" name="txtdel_longevityid" id="txtdel_longevityid">
                            <div class="form-group">
                                <label>Are you sure you want to delete this data?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-prem_loan" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<!-- begin appointment list -->
<div id="appointmentList-loan" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Select Employees to Update</h4>
            </div>
            <?=form_open('finance/compensation/personnel_profile/updateAllEmployees/'.$this->uri->segment(5).'/loan', array('id' => 'frmupdateEmployees'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <input type="hidden" name="txtdeductcode" id="txtalldeductcode">
                        <input type="hidden" name="txtdeductioncode" id="txtalldeductioncode">
                        <input type="hidden" name="txtdeductionType" id="txtalldeductionType">
                        <input type="hidden" name="txtamount" id="txtallamount">
                        <input type="hidden" name="txtperiod1" id="txtallperiod1">
                        <input type="hidden" name="txtperiod2" id="txtallperiod2">
                        <input type="hidden" name="txtperiod3" id="txtallperiod3">
                        <input type="hidden" name="txtperiod4" id="txtallperiod4">
                        <input type="hidden" name="selemonth" id="selallemonth">
                        <input type="hidden" name="selsmonth" id="selallsmonth">
                        <input type="hidden" name="seleyr" id="selalleyr">
                        <input type="hidden" name="selsyear" id="selallsyr">
                        <input type="hidden" name="selstatus" id="selallstatus">
                        <input type="hidden" name="txtstat" id="txtallstat-loan">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><input type="checkbox" id="chkall" value="all" name="chkappnt[]"> Check All</label>
                                <div class="checkbox-list">
                                    <?php foreach(array_slice($arrAppointments, 0, $arrAppointments_by2) as $chkappointment): ?>
                                        <label alt="Double click to uncheck">
                                            <input type="checkbox" class="check chkappnt" value="<?=$chkappointment['appointmentCode']?>" name="chkappnt[]">
                                            <?=$chkappointment['appointmentDesc']?> </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="checkbox-list">
                                    <?php foreach(array_slice($arrAppointments, $arrAppointments_by2, count($arrAppointments)) as $chkappointment): ?>
                                        <label alt="Double click to uncheck">
                                            <input type="checkbox" class="check chkappnt" value="<?=$chkappointment['appointmentCode']?>" name="chkappnt[]">
                                            <?=$chkappointment['appointmentDesc']?> </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-payrollDetails" class="btn green"><i class="icon-check"> </i> Save</button>
                    <button type="button" class="btn btn btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<?php load_plugin('js', array('select2','datepicker','form_validation')) ?>
<script>
    function numberformat(num) {
        var parts = num.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if(parts.length == 1){
            parts[1] = "00";
        }
        return parts.join(".");
    }
</script>
