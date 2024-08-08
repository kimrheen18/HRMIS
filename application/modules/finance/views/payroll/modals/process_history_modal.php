<!-- modal for publish and unpublish process -->
<div id="publish_process" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <?=form_open('finance/payroll_update/payrollupdate/publish_process/'.$this->uri->segment(5).'?month='.currmo().'&yr='.curryr(), array('id' => 'frmpayroll_update'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtprocess_id" id="txtprocess_id">
                            <input type="hidden" name="txtpublish_val" id="txtpublish_val">
                            <div class="form-group">
                                <label>Are you sure you want to <span id="spanpublish"></span> this process?</label>
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

<!-- modal for reprocess confirmation -->
<div id="reprocess_confirm" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Reprocess</h4>
            </div>
            <?=form_open('finance/payroll_update/reprocess', array('id' => 'frmpayroll_reprocess'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtreprocess_id" id="txtreprocess_id">
                            <input type="hidden" name="txtperiodmon" id="txtperiodmon">
                            <input type="hidden" name="txtperiodyr" id="txtperiodyr">
                            <input type="hidden" name="txtappt" id="txtappt">
                            <input type="hidden" name="txtperiod" id="txtperiod">
                            <div class="form-group">
                                <label>Are you sure you want to reprocess this data?</label>
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