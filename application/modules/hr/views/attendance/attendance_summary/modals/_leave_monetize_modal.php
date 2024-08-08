<?=load_plugin('css', array('attendance-css'))?>
<div id="modal-leave-monetization-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Leave Monetization</h4>
            </div>
            <?=form_open('employee/Leave_monetization/monetized_leave/'.$this->uri->segment(4).'?month='.currmo().'&yr='.curryr(), array('id' => 'frmmonetize'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <div class="portlet light bordered">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- begin input elements -->
                                            <input type="hidden" name="txtperiodmo" value="<?=count($arrlatest_balance) > 0 ? $arrlatest_balance['periodMonth'] : ''?>">
                                            <input type="hidden" name="txtperiodyr" value="<?=count($arrlatest_balance) > 0 ? $arrlatest_balance['periodYear'] : ''?>">
                                            <input type="hidden" id="txtamt_mone" value="<?=AMT_MONETIZATION?>">
                                            <input type="hidden" id="txtactual_sal" value="<?=$arrData['actualSalary']?>">
                                            <input type="hidden" id="txtactual_vl" value="<?=$vl_monetized?>">
                                            <input type="hidden" id="txtactual_sl" value="<?=$sl_monetized?>">

                                            <div class="form-group col-md-12" style="padding: 0 !important;">
                                                <label class="control-label col-md-12" style="padding: 0 !important;">Date<span class="required"> * </span></label>
                                                <div class="input-icon right col-md-6" style="padding: 0 !important;">
                                                    <select class="form-control form-required bs-select" name="txtadjmon" id="txtadjmon" placeholder="">
                                                        <?php foreach (range(1, 12) as $m): ?>
                                                            <option value="<?=sprintf('%02d', $m)?>" <?=sprintf('%02d', date('n')) == $m ? 'selected' : ''?>>
                                                                <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="input-icon right col-md-6" style="padding: 0 !important;">
                                                    <select class="form-control form-required bs-select" name="txtadjyr" id="txtadjyr" placeholder="">
                                                        <?php foreach (getYear($arrlatest_balance['periodYear']) as $yr): ?>
                                                            <option value="<?=$yr?>" <?=date('Y') == $yr ? 'selected' : ''?>>
                                                                <?=$yr?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"># of Leave Credits to be Monetized on Vacation Leave<span class="required"> * </span></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips" data-original-title="Please Provide Leave Credits to be Monetized on Vacation Leave" style="display: none;"></i>
                                                    <i class="fa fa-check tooltips" style="display: none;"></i>
                                                    <input type="text" class="form-control form-required" name="txtvl" id="txtvl"
                                                        placeholder="<?=count($vl_monetized) > 0 ? $vl_monetized : ''?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"># of Leave Credits to be Monetized on Sick Leave<span class="required"> * </span></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips" data-original-title="Please Provide Valid Leave Credits to be Monetized on Sick Leave" style="display: none;"></i>
                                                    <i class="fa fa-check tooltips" style="display: none;"></i>
                                                    <input type="text" class="form-control form-required" name="txtsl" id="txtsl"
                                                        placeholder="<?=count($sl_monetized) > 0 ? $sl_monetized : ''?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Amount</label>
                                                <div class="input-icon right">
                                                    <input type="text" class="form-control form-required" name="txtmone_amt" id="txtmone_amt" readonly>
                                                </div>
                                            </div>
                                            <!-- end input elements -->
                                        </div>
                                     </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn green" id="btnmonetized"><i class="icon-check"> </i> Submit</button>
                    <button type="button" class="btn blue" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<div id="modal-rollback" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Rollback</h4>
            </div>
            <?=form_open('employee/Leave_monetization/monetized_rollback/'.$this->uri->segment(4), array('id' => 'frmrollback'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txt_monid" id="txt_monid">
                            <div class="form-group">
                                <label>Are you sure you want to Rollback?</label>
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

<!-- begin monetize form modal -->
<div id="monetize-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Application for Leave</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed src="<?=base_url('employee/reports/generate/'.$arrData['empNumber'].'?rpt=reportLeave&leavetype=monetization&day=Whole%20day&leavefrom=&leaveto=&daysapplied=&signatory=&empname=&reason=&incaseSL=&incaseVL=&signatory2=&intVL=&intSL=')?>" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?=base_url('employee/reports/generate/'.$arrData['empNumber'].'?rpt=reportLeave&leavetype=monetization&day=Whole%20day&leavefrom=&leaveto=&daysapplied=&signatory=&empname=&reason=&incaseSL=&incaseVL=&signatory2=&intVL=&intSL=')?>" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end monetize form modal -->

<script src="<?=base_url('assets/js/custom/leave_monetization.js')?>"></script>