<?=load_plugin('css', array('select2','datepicker'))?>
<!-- begin modal update/add employee appointment info -->
<div class="modal fade in" id="add_appointment_issued" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b><span class="action"></span> Appointment Issued Information</b></h5>
            </div>
            <?=form_open('', array('method' => 'post', 'id' => 'frmappointment_issued','class' => 'form-horizontal'))?>
            <input type="hidden" name="txtappt_id" id="txtappt_id">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Position</label>
                    <div class="col-md-8">
                        <select class="form-control select2" name="sel_appt_pos" id="sel_appt_pos">
                            <option value=""> </option>
                            <?php foreach($arrpositions as $position):
                                    echo '<option value="'.$position['positionCode'].'">'.$position['positionDesc'].' ('.$position['positionAbb'].')</option>';
                                  endforeach; ?>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Date Issued</label>
                    <div class="col-md-8">
                        <input type="text" name="txt_appt_issueddate" id="txt_appt_issueddate" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Date Published</label>
                    <div class="col-md-8">
                        <input type="text" name="txt_appt_publisheddate" id="txt_appt_publisheddate" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Place Issued</label>
                    <div class="col-md-8">
                        <textarea name="txt_appt_issuedplace" id="txt_appt_issuedplace" class="form-control"></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Relevant Experience</label>
                    <div class="col-md-8">
                        <textarea name="txt_appt_relxp" id="txt_appt_relxp" class="form-control"></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Relevant Training</label>
                    <div class="col-md-8">
                        <textarea name="txt_appt_reltraining" id="txt_appt_reltraining" class="form-control"></textarea>
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
<!-- end modal update/add employee appointment info -->

<!-- begin delete employee appointment -->
<div class="modal fade" id="delete_emp_appointment" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete</h4>
            </div>
            <?=form_open('pds/del_appointment_issue/'.$this->uri->segment(3), array('method' => 'post', 'id' => 'frmdelappt','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdel_appt" id="txtdel_appt">
                <div class="modal-body"> Are you sure you want to delete this data? </div>
                <div class="modal-footer">
                    <button type="submit" id="btndelete" class="btn btn-sm green">
                        <i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                        <i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end delete employee appointment -->
<?=load_plugin('js',array('select2','datepicker'));?>

<script>
    $(document).ready(function() {
        $('.date-picker').datepicker();
    });
</script>