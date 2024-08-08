<!-- begin modal duties and responsibilities details info -->
<div class="modal fade in" id="edit_duties_responsibilities" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title"><b><span class="uppercase"><span class="action"></span> Information </span> <span id="info-title"></span></b> </h5>
            </div>
            <?=form_open('', array('method' => 'post', 'id' => 'frm_edit_dr'))?>
            <input type="hidden" id="txtdr_id" name="txtdr_id">
            <input type="hidden" value="<?=$arrPosition[0]['positionCode']?>" name="txtdr_poscode">
            <input type="hidden" value="<?=$arrPosition[0]['itemNumber']?>" name="txtdr_itemno">
            <div class="modal-body">
                <div class="form-group duty_number" style="display: none;">
                    <label>Duty Number</label>
                    <input type="text" class="form-control" id="txtno_duty" name="txtno_duty">
                    <span class="help-block"></span>
                </div>
                <div class="form-group">
                    <label>Duties and Responsbilities</label>
                    <textarea class="form-control" id="txtduties" name="txtduties"></textarea>
                    <span class="help-block"></span>
                </div>
                <div class="form-group">
                    <label>Percent of Working Time</label>
                    <input type="text" class="form-control" id="txtper_work" name="txtper_work">
                    <span class="help-block"></span>
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
<!-- end modal duties and responsibilities details info -->

<!-- begin delete duties and resposibilities reference -->
<div class="modal fade" id="delete_duties" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Duties and Responsibilities</h4>
            </div>
            <?=form_open(''.$this->uri->segment(3), array('method' => 'post', 'id' => 'frmdel_duties','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdel_drid" id="txtdel_drid">
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
<!-- end delete duties and resposibilities reference -->