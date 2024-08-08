<?=load_plugin('css', array('select','select2','datepicker'))?>
<!-- begin modal update/add education info -->
<div class="modal fade in" id="add_education" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b><span class="action"></span> Education Information</b></h5>
            </div>
            <?=form_open('', array('method' => 'post', 'id' => 'frmeduc','class' => 'form-horizontal'))?>
            <input type="hidden" name="txteducid" id="txteducid">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Level Description</label>
                    <div class="col-md-8">
                        <select class="form-control bs-select" name="sellevel" id="sellevel">
                            <option value=""> </option>
                            <?php foreach($arrLevel as $level):
                                    echo '<option value="'.$level['levelCode'].'">'.$level['levelDesc'].'</option>';
                                  endforeach; ?>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Name of School</label>
                    <div class="col-md-8">
                        <input type="text" name="txtschool" id="txtschool" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Degree / Course</label>
                    <div class="col-md-8">
                        <select class="form-control select2" name="seldegree" id="seldegree" placeholder="">
                            <option value=""></option>
                            <?php foreach($arrCourses as $course):
                                    echo '<option value="'.$course['courseCode'].'">'.$course['courseDesc'].'</option>';
                                  endforeach; ?>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Scholarship</label>
                    <div class="col-md-8">
                        <select class="form-control select2" id="selscholarship" name="selscholarship" placeholder="">
                            <option value=""></option>
                            <?php foreach($arrScholarships as $scholarship):
                                    echo '<option value="'.$scholarship['id'].'">'.$scholarship['description'].'</option>';
                                  endforeach; ?>
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Honors</label>
                    <div class="col-md-8">
                        <input type="text" name="txthonors" id="txthonors" class="form-control">
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Year Graduated</label>
                    <div class="col-md-8">
                            <input type="text" name="txtyrgraduate" id="txtyrgraduate" class="form-control">
                            <span class="help-block"></span>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-md-3 control-label">Period of Attendance </label>
                    <div class="col-md-4">
                            <input type="text" name="txtperiodatt_from" id="txtperiodatt_from" class="form-control" placeholder="From">
                            <span class="help-block"></span>
                    </div>
                    <div class="col-md-4">
                            <input type="text" name="txtperiodatt_to" id="txtperiodatt_to" class="form-control" placeholder="To">
                            <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Highest Level/Units Earned</label>
                    <div class="col-md-8">
                        <input type="number" name="txtunits" id="txtunits" class="form-control" onkeydown="javascript: return event.keyCode == 69 ? false : true" />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Licensed</label>
                    <div class="col-md-8">
                        <div class="radio-list">
                            <label class="radio-inline">
                                <input type="radio" name="optlicense" id="optlicense_y" value="Y"> Yes </label>
                            <label class="radio-inline">
                                <input type="radio" name="optlicense" id="optlicense_n" value="N"> No </label>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Graduated</label>
                    <div class="col-md-8">
                        <div class="radio-list">
                            <label class="radio-inline">
                                <input type="radio" name="optgraduate" id="optgraduate_y" value="Y"> Yes </label>
                            <label class="radio-inline">
                                <input type="radio" name="optgraduate" id="optgraduate_n" value="N"> No </label>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>
                </div>
                     <div class="modal-footer">
                       <div class="col-md-8">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn green">Save</button>
                    </div>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end modal update/add education info -->

<!-- begin education -->
<div class="modal fade" id="delete_education" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Education Information</h4>
            </div>
            <?=form_open('pds/delete_educ/'.$this->uri->segment(3), array('method' => 'post', 'id' => 'frmchild','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdeleduc" id="txtdeleduc">
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
<!-- end education  -->
<?=load_plugin('js',array('select','select2','datepicker'));?>
