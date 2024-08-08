<?=load_plugin('css', array('select2','datepicker'))?>
<!-- begin modal update/add child info -->
<div class="modal fade in" id="add_exam" aria-hidden="true">
    <div class="modal-dialog" style="width: 68%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b><span class="action"></span> Eligibility Information</b></h5>
            </div>
            <?=form_open('', array('method' => 'post', 'id' => 'frmexam','class' => 'form-horizontal'))?>
            <input type="hidden" name="txtexamid" id="txtexamid">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Exam Description</label>
                    <div class="col-md-8">
                        <select class="form-control select2" name="exam_desc" id="exam_desc">
                            <option value=""> </option>
                            <?php foreach($arrExamType as $type):
                                    echo '<option value="'.$type['examCode'].'">'.$type['examDesc'].'</option>';
                                  endforeach; ?>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Rating</label>
                    <div class="col-md-8">
                        <input type="text" name="txtrating" id="txtrating" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Place of Exam / Conferment</label>
                    <div class="col-md-8">
                        <input type="text" name="txtplace_exam" id="txtplace_exam" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Date of Exam / Conferment</label>
                    <div class="col-md-8">
                        <input type="text" name="txtdate_exam" id="txtdate_exam" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">License No. (<i>if applicable</i>)</label>
                    <div class="col-md-8">
                        <input type="text" name="txtlicense" id="txtlicense" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Date of Validity</label>
                    <div class="col-md-8">
                        <input type="text" name="txtvalidity" id="txtvalidity" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Verifier</label>
                    <div class="col-md-8">
                        <input type="text" name="txtverifier" id="txtverifier" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Reviewer</label>
                    <div class="col-md-8">
                        <input type="text" name="txtreviewer" id="txtreviewer" class="form-control">
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
<!-- end modal update/add child info -->    

<!-- begin delete child -->
<div class="modal fade" id="delete_exam" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Eligibility</h4>
            </div>
            <?=form_open('pds/delete_exam/'.$this->uri->segment(3), array('method' => 'post', 'id' => 'frmdelexam','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdel_exam" id="txtdel_exam">
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
<!-- end delete child -->
<?=load_plugin('js',array('select2','datepicker'));?>

<script>
    $(document).ready(function() {
        $('.date-picker').datepicker();
    });
</script>