<?php 
    $status = isset($_GET['status']) ? $_GET['status']!='' ? '&status='.$_GET['status'] : '&status=All' : '';
    $code = isset($_GET['code']) ? $_GET['code']!='' ? '&code='.$_GET['code'] : '&code=all' : '';
 ?>
<!-- BGEIN MODAL LEAVE -->
<div id="request_leave" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <?=form_open('hr/request/leave_request?month='.currmo().'&yr='.curryr().$status.$code, array('class' => 'form-horizontal', 'method' => 'post'))?>
                <div class="modal-body">
                    <div class="form-body">
                        <input type="hidden" name="txtleave_json" id="txtleave_json">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Request ID</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreqid" name="txtreqid" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee Number</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreq_empno" name="txtreq_empno" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreq_empname" name="txtreq_empname" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Type of Leave</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreq_leave_type" name="txtreq_leave_type" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date From</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreq_dfrom" name="txtreq_dfrom" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date To</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreq_dto" name="txtreq_dto" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Reason</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtreq_reason" name="txtreq_reason" disabled></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group txtreq_patient">
                            <label class="col-md-3 control-label">Out/In Patient</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreq_patient" name="txtreq_patient">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group txtreq_location">
                            <label class="col-md-3 control-label">Location</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreq_location" name="txtreq_location">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Commutation</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtreq_comm" name="txtreq_comm">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status of Request</label>
                            <div class="col-md-8">
                                <select class="bs-select form-control" name="selreq_stat" id="selreq_stat"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Remarks</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtreq_remarks" name="txtreq_remarks"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btncertify" class="btn btn-sm green"><i class="icon-check"> </i> Certify</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- END MODAL LEAVE -->

<div id="request_ob" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <?=form_open('hr/request/ob_request?month='.currmo().'&yr='.curryr().$status.$code, array('class' => 'form-horizontal'))?>
                <div class="modal-body">
                    <input type="hidden" name="txtob_json" id="txtob_json">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Request ID</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_id" name="txtob_id" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee Number</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_empno" name="txtob_empno" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_empname" name="txtob_empname" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Official Business</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_type" name="txtob_type" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Place</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_place" name="txtob_place" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Purpose </label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtob_purpose" name="txtob_purpose" disabled></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" style="line-height: 5px;">With Meal</label>
                            <div class="col-md-8">
                                <label><input type="checkbox" id="txtob_wmeal" name="txtob_wmeal" disabled></label>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date From</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_dfrom" name="txtob_dfrom" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date To</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_dto" name="txtob_dto" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Time in</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_time_in" name="txtob_time_in" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Time out</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtob_time_out" name="txtob_time_out" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status of Request</label>
                            <div class="col-md-8">
                                <select class="bs-select form-control" name="selob_stat" id="selob_stat"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Remarks</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtob_remarks" name="txtob_remarks"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnobcertify" class="btn btn-sm green"><i class="icon-check"> </i> Certify</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<!-- request dtr -->

<div id="request_dtr" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <?=form_open('hr/request/dtr_request', array('class' => 'form-horizontal'))?>
                <div class="modal-body">
                    <div class="form-body">
                        <input type="hidden" name="txtdtr_json" id="txtdtr_json">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Request ID</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_id" name="txtdtr_id" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee Number</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_empno" name="txtdtr_empno" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_empname" name="txtdtr_empname" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Dtr Date </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_date" name="txtdtr_date" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Time in (AM) </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_old_amin" name="txtdtr_old_amin" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Time out (AM) </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_old_amout" name="txtdtr_old_amout" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Time in (PM) </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_old_pmin" name="txtdtr_old_pmin" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Time out (PM) </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_old_pmout" name="txtdtr_old_pmout" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Overtime in </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_old_otin" name="txtdtr_old_otin" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Overtime out </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_old_otout" name="txtdtr_old_otout" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">New Time in (AM) </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_new_amin" name="txtdtr_new_amin" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">New Time out (AM) </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_new_amout" name="txtdtr_new_amout" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">New Time in (PM) </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_new_pmin" name="txtdtr_new_pmin" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">New Time out (PM) </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_new_pmout" name="txtdtr_new_pmout" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">New Overtime in </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_new_otin" name="txtdtr_new_otin" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">New Overtime out </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtdtr_new_otout" name="txtdtr_new_otout" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Reason</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtdtr_reason" name="txtdtr_reason" disabled></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Supporting Evidence</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtdtr_evi" name="txtdtr_evi" disabled></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status of Request</label>
                            <div class="col-md-8">
                                <select class="bs-select form-control" name="seldtr_stat" id="seldtr_stat"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Remarks</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtdtr_remarks" name="txtdtr_remarks"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btndtrcertify" class="btn btn-sm green"><i class="icon-check"> </i> Certify</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<div id="request_to" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <?=form_open('hr/request/to_request?month='.currmo().'&yr='.curryr().$status.$code, array('class' => 'form-horizontal'))?>
                <input type="hidden" name="txtto_json" id="txtto_json">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Request ID</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtto_id" name="txtto_id" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee Number</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtto_empno" name="txtto_empno" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtto_empname" name="txtto_empname" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Destination </label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtto_desti" name="txtto_desti" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date From</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtto_dfrom" name="txtto_dfrom" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date To</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="txtto_dto" name="txtto_dto" disabled>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Purpose </label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtto_purpose" name="txtto_purpose" disabled></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" style="line-height: 5px;">With Meal</label>
                            <div class="col-md-8">
                                <label><input type="checkbox" id="txtto_wmeal" name="txtto_wmeal" disabled></label>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Status of Request</label>
                            <div class="col-md-8">
                                <select class="bs-select form-control" name="selto_stat" id="selto_stat"></select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Remarks</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="txtto_remarks" name="txtto_remarks"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btntocertify" class="btn btn-sm green"><i class="icon-check"> </i> Certify</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>