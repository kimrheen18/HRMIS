<?=load_plugin('css', array('datepicker'))?>
<!-- begin modal update/add child info -->
<div class="modal fade in" id="add_vol_work" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b><span class="action"></span> Voluntary Work Information</b></h5>
            </div>
            <?=form_open('', array('method' => 'post', 'id' => 'frmvolwork','class' => 'form-horizontal'))?>
            <input type="hidden" name="txtvolid" id="txtvolid">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Name of Organization</label>
                    <div class="col-md-8">
                        <input type="text" name="txtorganization" id="txtorganization" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Address </label>
                    <div class="col-md-8">
                        <textarea class="form-control" id="txtaddress" name="txtaddress"></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Inclusive Date From</label>
                    <div class="col-md-8">
                        <input type="text" name="txtdfrom_vl" id="txtdfrom_vl" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Inclusive Date To</label>
                    <div class="col-md-8">
                        <input type="text" name="txtdto_vl" id="txtdto_vl" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Number of Hours</label>
                    <div class="col-md-8">
                        <input type="text" name="txthrs" id="txthrs" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Position / Nature of Work</label>
                    <div class="col-md-8">
                        <input type="text" name="txtwork" id="txtwork" class="form-control">
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
<div class="modal fade" id="delete_volwork" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Voluntary Work</h4>
            </div>
            <?=form_open('pds/del_vol_work/'.$this->uri->segment(3), array('method' => 'post', 'id' => 'frmdelvolwork','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdelvolid" id="txtdelvolid">
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
<?=load_plugin('js',array('datepicker'));?>

<script>
    $(document).ready(function() {
        $('.date-picker').datepicker();
    });
</script>