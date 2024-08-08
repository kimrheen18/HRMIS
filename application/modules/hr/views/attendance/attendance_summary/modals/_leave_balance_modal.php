<?=load_plugin('css', array('attendance-css','datepicker'))?>

<div id="modal-edit-leave-balance" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit [Vacation] Leave</h4>
            </div>
            <?=form_open('finance/compensation/personnel_profile/edit_payrollDetails/'.$this->uri->segment(5), array('id' => 'frmedit-vl'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <div class="portlet light bordered">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- begin input elements -->
                                            <div class="form-group">
                                                <label class="control-label">Date</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips i-required"></i>
                                                    <input type="text" class="form-control" id="txtvl-date" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Earned<span class="required"> * </span></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips i-required"></i>
                                                    <input type="text" class="form-control form-required" name="txtvl-earned" id="txtvl-earned">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Abs.Und.W/Pay<span class="required"> * </span></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips i-required"></i>
                                                    <input type="text" class="form-control form-required" name="txtvl-wpay" id="txtvl-wpay">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Current Balance</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips i-required"></i>
                                                    <input type="text" class="form-control" id="txtvl-currbal" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Previous Balance</label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips i-required"></i>
                                                    <input type="text" class="form-control" id="txtvl-prevbal" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Abs.Und.W/o Pay<span class="required"> * </span></label>
                                                <div class="input-icon right">
                                                    <i class="fa fa-warning tooltips i-required"></i>
                                                    <input type="text" class="form-control form-required" name="txtvl-wopay" id="txtvl-wopay">
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
                    <button type="submit" class="btn green"><i class="icon-check"> </i> Submit</button>
                    <button type="button" class="btn blue" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<div id="modal-view-info" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Note</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <label>If the employee reach the compulsory retirement age of 65 but the service has been extended, the employee will <b>NO LONGER EARN</b> leave credits.</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey-cascade btn-sm" data-dismiss="modal"><i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
