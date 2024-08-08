<style type="text/css">.input-sm { text-align: center; }</style>
<?=load_plugin('css', array('attendance-css'))?>
<div id="modal-view-leave-balance" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <?=form_open(base_url(), array('id' => 'frmupdate_leavebalance'))?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title bold">Leave Balance Preview</h4>
                    <small>Leave Balance Info for the Month of <span id="txtprev_month"><?=date('F', mktime(0, 0, 0, $arrLatestBalance['lb']['periodMonth']+1, 10)).' '.(count($arrLatestBalance) > 0 ? $arrLatestBalance['lb']['periodYear'] : date('Y'))?></span></small>
                </div>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <table class="table table-bordered tblmodal">
                                            <thead>
                                                <tr>
                                                    <th style="width: 35%;">Details</th>
                                                    <th style="text-align: center;">Vacation Leave</th>
                                                    <th style="text-align: center;">Sick Leave</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Previous Month Balance  </td>
                                                    <td align="center" class="prev_vl"></td>
                                                    <td align="center" class="prev_sl"></td>
                                                </tr>
                                                <tr>
                                                    <td>Earned for the month</td>
                                                    <td align="center" class="earned_vl"></td>
                                                    <td align="center" class="earned_sl"></td>
                                                </tr>
                                                <tr>
                                                    <td>Abs. Und. W/ Pay</td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" id="txtauwp_vl" name="txtauwp_vl">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="tdn-or" align="center" class="auwp_vl"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" id="txtauwp_sl" name="txtauwp_sl">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="tdn-or" align="center" class="auwp_sl"></td>
                                                </tr>
                                                <tr>
                                                    <td class="period_date_bal"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtperiod_vl" id="txtperiod_vl">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="tdn-or" align="center" class="period_vl"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtperiod_sl" id="txtperiod_sl">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="tdn-or" align="center" class="period_sl"></td>
                                                </tr>
                                                <tr>
                                                    <td>Abs. Und. W/O Pay</td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtauwop_vl" id="txtauwop_vl">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="tdn-or" align="center" class="auwop_vl"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtauwop_sl" id="txtauwop_sl">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="tdn-or" align="center" class="auwop_sl"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered tblmodal">
                                            <thead>
                                                <tr>
                                                    <th style="width: 35%;vertical-align: top;">Leave Type</th>
                                                    <th style="text-align: center;">Previous Month Balance</th>
                                                    <th style="text-align: center;">Filed this Month</th>
                                                    <th style="text-align: center;">Current Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Special Leave</td>
                                                    <td align="center" class="spe_prev"></td>
                                                    <td align="center" class="spe_filed"></td>
                                                    <td id="tdn-or" align="center" class="spe_curr"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtspe_curr" id="txtspe_curr">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Forced Leave</td>
                                                    <td align="center" class="fl_prev"></td>
                                                    <td align="center" class="fl_filed"></td>
                                                    <td id="tdn-or" align="center" class="fl_curr"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtfl_curr" id="txtfl_curr">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Study Leave</td>
                                                    <td align="center" class="sdl_prev"></td>
                                                    <td align="center" class="sdl_filed"></td>
                                                    <td id="tdn-or" align="center" class="sdl_curr"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtsdl_curr" id="txtsdl_curr">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr <?=$employeedata['sex'] == 'F' ? '' : 'hidden';?>>
                                                    <td>Maternity Leave</td>
                                                    <td align="center" class="mtl_prev"></td>
                                                    <td align="center" class="mtl_filed"></td>
                                                    <td id="tdn-or" align="center" class="mtl_curr"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtmtl_curr" id="txtmtl_curr">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr <?=$employeedata['sex'] != 'F' ? '' : 'hidden';?>>
                                                    <td>Paternity Leave</td>
                                                    <td align="center" class="ptl_prev"></td>
                                                    <td align="center" class="ptl_filed"></td>
                                                    <td id="tdn-or" align="center" class="ptl_curr"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtptl_curr" id="txtptl_curr">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered tblmodal">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Compensatory Overtime Credits (COC)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 35%;">Balance</td>
                                                    <td id="tdn-or" class="coc_balance" align="right"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="col-md-6 pull-right" style="margin-right: -4px;">
                                                            <div class="form-group">
                                                                <div class="input-icon right">
                                                                    <input type="text" class="form-control input-sm" style="width: 106%" name="txtbalance" id="txtbalance">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Gain</td>
                                                    <td id="tdn-or" class="coc_gain" align="right"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="col-md-6 pull-right" style="margin-right: -4px;">
                                                            <div class="form-group">
                                                                <div class="input-icon right">
                                                                    <input type="text" class="form-control input-sm" style="width: 106%" name="txtgain" id="txtgain">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Used</td>
                                                    <td id="tdn-or" class="coc_used" align="right"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="col-md-6 pull-right" style="margin-right: -4px;">
                                                            <div class="form-group">
                                                                <div class="input-icon right">
                                                                    <input type="text" class="form-control input-sm" style="width: 106%" name="txtused" id="txtused">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <table class="table table-bordered tblmodal">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Attendance Summary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>No. of Days Undertime/Tardiness</td>
                                                    <td id="tdn-or" style="width: 80px;" align="right" class="late_ut_days"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtlate_ut_days" id="txtlate_ut_days">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Hrs/Min/Sec Undertime/Tardiness (Format: hh:mm)</td>
                                                    <td id="tdn-or" align="right" class="late_ut_hhmm"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtlate_ut_hhmm" id="txtlate_ut_hhmm">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>No. of days AWOL</td>
                                                    <td id="tdn-or" align="right" class="days_awol"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtdays_awol" id="txtdays_awol">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>No. of days PRESENT</td>
                                                    <td id="tdn-or" align="right" class="days_present"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtdays_present" id="txtdays_present">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>No. of days ABSENT</td>
                                                    <td id="tdn-or" align="right" class="days_absent"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtdays_absent" id="txtdays_absent">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered tblmodal">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">For MC Benefits</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Hours of Service</td>
                                                    <td>No. of days</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2">Laundry Allowance (day/s without)</td>
                                                    <td id="tdn-or" align="right" class="laundry"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtlaundry" id="txtlaundry">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Subsistence Allowance</td>
                                                    <td>8 hours (150 * day/s)</td>
                                                    <td id="tdn-or" align="right" class="subs_8hrs"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtsubs_8hrs" id="txtsubs_8hrs">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>6 hrs but less than 8 hrs (125)</td>
                                                    <td id="tdn-or" align="right" class="subs_6hrs"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtsubs_6hrs" id="txtsubs_6hrs">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>5 hrs but less than 6 hrs (100)</td>
                                                    <td id="tdn-or" align="right" class="subs_5hrs"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtsubs_5hrs" id="txtsubs_5hrs">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>4 hrs but less than 5 hrs (75)</td>
                                                    <td id="tdn-or" align="right" class="subs_4hrs"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtsubs_4hrs" id="txtsubs_4hrs">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>OB/TO with meal/s:</td>
                                                    <td id="tdn-or" align="right" class="with_meal"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtwith_meal" id="txtwith_meal">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td><b>Amount</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Seminar-Training Travel/Study (Subsistence - per diem)</td>
                                                    <td id="tdn-or" align="right" class="amt_training"></td>
                                                    <td id="tdor" style="padding-bottom: 0px;">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" class="form-control input-sm" name="txtamt_training" id="txtamt_training">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left"><small>
                        <b>Updated by: </b> <span id="updatedby"></span>
                    </small></div>
                    <input type="hidden" id="txtget_data" name="txtget_data" value="<?=$this->uri->segment(4).'?month='.(isset($_GET['month']) ? $_GET['month'] : date('m')).'&yr='.(isset($_GET['yr']) ? $_GET['yr'] : date('Y'))?>">
                    <input type="hidden" id="txtoverride_id" name="txtoverride_id">
                    <input type="hidden" id="txt_isoverride">
                    <?php 
                        $arrleave_data = array( 'arrLeaveBalance' => $arrLeaveBalance,
                                                'arrLatestBalance' => $arrLatestBalance,
                                                'arrAttendance_summary' => $arrAttendance_summary,
                                                'employeedata' => $employeedata);
                     ?>
                    <input type="hidden" id="txtperiodMonth" name="txtperiodMonth">
                    <input type="hidden" id="txtperiodYr" name="txtperiodYr">
                    <input type="hidden" name="txtprev_vlbal" id="txtprev_vlbal">
                    <input type="hidden" name="txtprev_slbal" id="txtprev_slbal">
                    <input type="hidden" name="txtleave_data" id="txtleave_data" value='<?=json_encode($arrleave_data)?>'>
                    <button type="submit" class="btn green" id="btnupdate_lb"><i class="icon-check"> </i> Update</button>
                    <button type="button" class="btn blue" data-dismiss="modal"><i class="icon-ban"> </i> Close</button>
                </div>
            </div>
        <?=form_close()?>
    </div>
</div>

<div id="modal-rollback" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Rollback</h4>
            </div>
            <?=form_open('hr/attendance/leave_balance_rollback/'.$this->uri->segment(4), array('id' => 'frmrollback'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtlb_id" id="txtlb_id" value="<?=count($arrLatestBalance) > 0 ? $arrLatestBalance['lb']['lb_id'] : ''?>">
                            <div class="form-group">
                                <label>
                                    Are you sure you want to rollback leave balance <b><?=count($arrLatestBalance) > 0 ? date('F', mktime(0, 0, 0, $arrLatestBalance['lb']['periodMonth'], 10)).' '.$arrLatestBalance['lb']['periodYear'] : ''?></b>?
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-payrollDetails" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>