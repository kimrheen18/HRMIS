<?=load_plugin('css', array('datepicker'))?>
<!-- begin modal update/add child info -->
<div class="modal fade in" id="add_child_modal" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title uppercase"><b><span class="action"></span> Child Information</b></h4>
            </div>
            <?=form_open('', array('method' => 'post', 'id' => 'frmchild','class' => 'form-horizontal'))?>
            <input type="hidden" name="txtchildcode" id="txtchildcode">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" name="txtchildname" id="txtchildname" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Date of Birth</label>
                    <div class="col-md-8">
                        <div class="input-icon right">
                            <i class="fa fa-calendar"></i>
                            <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" name="txtchildbday" id="txtchildbday" type="text">
                        </div>
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
<div class="modal fade" id="delete_child" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Child Information</h4>
            </div>
            <?=form_open('pds/delete_child/'.$this->uri->segment(3), array('method' => 'post', 'id' => 'frmchild','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdelchild" id="txtdelchild">
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
