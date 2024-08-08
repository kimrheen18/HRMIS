<?=load_plugin('css', array('select','select2','datepicker'))?>
<!-- begin modal update/add training info -->
<div class="modal fade in" id="add_training" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
            <?=form_open('', array('method' => 'post', 'id' => 'frmtraining','class' => 'form-horizontal'))?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b><span class="action"></span> Training Information</b></h5>
            </div>
            
            <input type="hidden" name="txttraid" id="txttraid">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Title of Learning and Dev./Training Programs<span class="required"> * </span></label>
                        <div class="col-md-8">
                            <input type="text" name="txttra_name" id="txttra_name" class="form-control">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Number of Hours<span class="required"> * </span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="txttra_hrs" name="txttra_hrs">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Venue<span class="required"> * </span></label>
                        <div class="col-md-8">
                            <textarea name="txttra_venue" id="txttra_venue" class="form-control"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Type of LD (Administrative / Managerial / Supervisory / Technical)</label>
                        <div class="col-md-8">
                            <select class="form-control bs-select" name="seltra_typeld" id="seltra_typeld">
                                <option value=""> </option>
                                <?php foreach(ld_type() as $type):
                                        echo '<option value="'.$type.'">'.$type.'</option>';
                                      endforeach; ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Conducted/Sponsored By</label>
                        <div class="col-md-8">
                            <input type="text" name="txttra_sponsored" id="txttra_sponsored" class="form-control">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Cost</label>
                        <div class="col-md-8">
                            <input type="text" name="txttra_cost" id="txttra_cost" class="form-control">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Contract Date</label>
                        <div class="col-md-8">
                            <input type="text" name="txttra_contract" id="txttra_contract" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Start Date<span class="required"> * </span></label>
                        <div class="col-md-8">
                            <input type="text" name="txttra_sdate" id="txttra_sdate" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-md-3 control-label">End Date<span class="required"> * </span></label>
                        <div class="col-md-8">
                            <input type="text" name="txttra_edate" id="txttra_edate" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                            <span class="help-block"></span>
                        </div>
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
<!-- end modal update/add training info -->
<!-- begin delete training -->
<div class="modal fade" id="delete_training" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Training</h4>
            </div>
            <?=form_open('pds/del_training/'.$this->uri->segment(3), array('method' => 'post', 'id' => 'frmdeltra','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdel_tra" id="txtdel_tra">
                    <div class="modal-body"> Are you sure you want to delete this data? </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm green">
                        <i class="icon-check"> </i> Yes</button>
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                        <i class="icon-ban"> </i> Cancel</button>
                    </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end delete training -->
<?=load_plugin('js',array('select','select2','datepicker'));?>

<script>
    $(document).ready(function() {
        $('.date-picker').datepicker();
    });
</script>