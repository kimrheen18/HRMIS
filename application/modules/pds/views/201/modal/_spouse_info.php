<!-- begin modal update spouse info -->
<div class="modal fade in" id="edit_spouse_modal" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog-lg" style="width: 75%;margin: 5% auto;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title uppercase"><b>Edit Spouse Information</b></h4>
            </div>
            <?=form_open('pds/edit_spouse/'.$this->uri->segment(3), array('method' => 'post', 'name' => 'employeeform','class' => 'form-horizontal'))?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">First name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtspouseFname" class="form-control" value="<?=isset($arrData) ? $arrData['spouseFirstname'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Middle name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtspouseMname" class="form-control" value="<?=isset($arrData) ? $arrData['spouseMiddlename'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Last name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtspouseLname" class="form-control" value="<?=isset($arrData) ? $arrData['spouseSurname'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-md-3 control-label">Extension name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtspouseExt" class="form-control" value="<?=isset($arrData) ? $arrData['spousenameExtension'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Occupation</label>
                    <div class="col-md-8">
                        <input type="text" name="txtspouseWork" class="form-control" value="<?=isset($arrData) ? $arrData['spouseWork'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Employer/Business Name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtspouseBusName" class="form-control" value="<?=isset($arrData) ? $arrData['spouseBusName'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Telephone Number</label>
                    <div class="col-md-8">
                        <input type="text" name="txtspouseTelephone" class="form-control" value="<?=isset($arrData) ? $arrData['spouseTelephone'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Business Address</label>
                    <div class="col-md-8">
                        <input type="text" name="txtspouseBusAddress" class="form-control" value="<?=isset($arrData) ? $arrData['spouseBusAddress'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save</button>
            </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end modal update spouse info -->
