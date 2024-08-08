<div id="request_leave" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <?=form_open('employee/requests/cancel_request', array('class' => 'form-horizontal'))?>
                <div class="modal-body">
                    <div class="form-body">
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

<div id="request_ob" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <?=form_open('employee/requests/cancel_request', array('class' => 'form-horizontal'))?>
                <div class="modal-body">
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

<div id="request_to" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
            </div>
            <?=form_open('employee/requests/cancel_request', array('class' => 'form-horizontal'))?>
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