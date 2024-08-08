<div id="update_table-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Update Tables</b></h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Are you sure you want to alter your current database?
                                <br>If you wish to do it manually, the updated database sql schema is added to <i>schema/hrmisv10/hrmis-schema-upt_001.sql</i> Click Okay to continue.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn-update-tables" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="fix_datetime_fields-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Fix Conflict Fields</b></h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Are you sure you want to alter your current database?
                                <br>If you wish to do it manually, the updated database sql schema is added to <i>schema/hrmisv10/hrmis-schema-upt_002.sql</i> Click Okay to continue.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn-fix-date-fields" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="update_fields-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Update Fields</b></h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Are you sure you want to alter your current database?
                                <br>If you wish to do it manually, the updated database sql schema is added to <i>schema/hrmisv10/hrmis-schema-upt_003.sql</i> Click Okay to continue.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn-update-fields" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="update_data_type-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Update Field Data Type</b></h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Are you sure you want to alter your current database?
                                <br>If you wish to do it manually, the updated database sql schema is added to <i>schema/hrmisv10/hrmis-schema-upt_004.sql</i> Click Okay to continue.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn-update-data-type" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><b>Update Database</b></h4>
            </div>
            <?=form_open('dbmigrate/migrate/update_database', array('id' => 'confirm'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Are you sure you want to alter your current database?
                                    <br>If you wish to do it manually, the updated database sql schema is added to <i>schema/hrmisv10/hrmis-schema-upt.sql</i></label>
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