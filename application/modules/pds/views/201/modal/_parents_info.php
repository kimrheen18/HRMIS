<!-- begin modal update parents info -->
<div class="modal fade in" id="edit_parents_modal" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog-lg" style="width: 75%;margin: 5% auto;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title uppercase"><b>Edit Parents Information</b></h4>
            </div>
            <?=form_open('pds/edit_parents/'.$this->uri->segment(3), array('method' => 'post', 'name' => 'employeeform','class' => 'form-horizontal'))?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Father's First name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtfatherFname" class="form-control" value="<?=isset($arrData) ? $arrData['fatherFirstname'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Father's Middle name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtfatherMname" class="form-control" value="<?=isset($arrData) ? $arrData['fatherMiddlename'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Father's Last name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtfatherLname" class="form-control" value="<?=isset($arrData) ? $arrData['fatherSurname'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Father's Extension name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtfatherExt" class="form-control" value="<?=isset($arrData) ? $arrData['fathernameExtension'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Mother's First name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtmotherFname" class="form-control" value="<?=isset($arrData) ? $arrData['motherFirstname'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Mother's Middle name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtmotherMname" class="form-control" value="<?=isset($arrData) ? $arrData['motherMiddlename'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Mother's Last name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtmotherLname" class="form-control" value="<?=isset($arrData) ? $arrData['motherSurname'] : ''?>">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Parent's Address</label>
                    <div class="col-md-8">
                        <textarea name="txtparentsadd" class="form-control"><?=isset($arrData) ? $arrData['parentAddress'] : ''?></textarea>
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
<!-- end modal update parents info -->
