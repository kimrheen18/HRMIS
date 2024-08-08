<?php $month = isset($_GET['month']) ? $_GET['month'] : date('m'); $yr = isset($_GET['yr']) ? $_GET['yr'] : date('Y'); ?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Set Starting Leave Balance</span>
                    <a data-toggle="modal" data-backdrop="static" data-keyboard="false" href="#modal-view-info"> <i class="icon-info"></i></a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-6">
                        <?=form_open('', array('method' => 'post', 'id' => 'frmleavebal'))?>
                            <input type="hidden" name="txtyr" value="<?=$yr?>">
                            <input type="hidden" name="txtmonth" value="<?=$month?>">
                            <!-- begin vacation leave -->
                            <div class="form-group">
                                <label class="control-label bold" style="margin-bottom: 10px;">Vacation Leave</label>
                                <br>
                                <label class="control-label">Starting Balance <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="vl_start" id="vl_start" value="0.000" step="any">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Absent Undertime With Pay <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="vl_ut_wpay" id="vl_ut_wpay" value="0.000" step="any">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Absent Undertime Without Pay <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="vl_ut_wopay" id="vl_ut_wopay" value="0.000" step="any">
                                </div>
                            </div>
                            <!-- end vacation leave -->

                            <!-- begin sick leave -->
                            <div class="form-group">
                                <label class="control-label bold" style="margin-bottom: 10px;">Sick Leave</label>
                                <br>
                                <label class="control-label">Starting Balance <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="sl_start" id="sl_start" value="0.000" step="any">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Absent Undertime With Pay <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="sl_ut_wpay" id="sl_ut_wpay" value="0.000" step="any">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Absent Undertime Without Pay <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="sl_ut_wopay" id="sl_ut_wopay" value="0.000" step="any">
                                </div>
                            </div>
                            <!-- end sick leave -->

                            <!-- begin others leave -->
                            <div class="form-group">
                                <label class="control-label bold" style="margin-bottom: 10px;">Others</label>
                                <br>
                                <label class="control-label">Offset Balance <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="off_bal" id="off_bal" value="0" step="any">
                                    <span class="help-block small">in Minutes</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Forced Leave Balance <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="fl_bal" id="fl_bal" value="0" step="any">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Privilege Leave Balance <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" class="form-control" name="pl_bal" id="pl_bal" value="0" step="any">
                                </div>
                            </div>
                            <!-- end others leave -->

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button class="btn green" type="submit" id="btn-set-balance"><i class="fa fa-check"></i> Submit </button>
                                        <a href="<?=base_url('hr/attendance_summary/leave_balance_update/').$this->uri->segment(4).'?month='.$month.'&yr='.$yr?>" class="btn blue">
                                            <i class="icon-ban"></i> Cancel</a>
                                    </div>
                                </div>
                            </div>
                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('modals/_leave_balance_modal'); ?>
<?php load_plugin('js', array('form_validation')) ?>
<script src="<?=base_url('assets/js/custom/leave_balance.js')?>"></script>