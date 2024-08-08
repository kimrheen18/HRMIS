<?=load_plugin('css', array('datetimepicker','timepicker','datepicker'))?>
<!-- begin employee include in dtr -->
<div class="modal fade" id="modal-inc-dtr" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Include in DTR</h4>
            </div>
            <?=form_open('hr/override/override_inc_dtr', array('method' => 'post', 'id' => 'frminc_dtr','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtempinc_id" id="txtempinc_id">
                <div class="modal-body"> Are you sure you want to include <b><span id="empname"></span></b> in DTR? </div>
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
<!-- end employee include in dtr -->

<!-- begin generate dtr -->
<div class="modal fade" id="modal-gen-dtr" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Generate DTR</h4>
            </div>
            <?=form_open('hr/override/override_gen_dtr', array('method' => 'post', 'id' => 'frminc_dtr','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtgendtr_empnum" id="txtgendtr_empnum">
                <div class="modal-body">
                    <h5 class="bold" id="empname_gen"></h5>
                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label class="control-label">Date <span class="required"> * </span></label>
                                        <div class="input-group input-daterange" data-date="2003">
                                            <input type="text" class="form-control form-required date-picker"
                                                name="gendtr_datefrom" data-date-format="yyyy-mm-dd">
                                            <span class="input-group-addon"> to </span>
                                            <input type="text" class="form-control form-required date-picker"
                                                name="gendtr_dateto" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">Time From <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker form-required timepicker-default"
                                                name="gendtr_timefrom" value="07:00:00 AM">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">Time To <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker form-required timepicker-default"
                                                name="gendtr_timeto" value="04:00:00 PM">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btndelete" class="btn btn-sm green">
                        <i class="icon-check"> </i> Generate</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                        <i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end generate dtr -->
<?=load_plugin('js', array('datetimepicker','timepicker','datepicker'))?>
<script>
    $(document).ready(function() {
        $('.timepicker').timepicker({
            timeFormat: 'HH:mm:ss A',
            disableFocus: true,
            showInputs: false,
            showSeconds: true,
            showMeridian: true,
        });
        $('.date-picker').datepicker();
        $('.date-picker').on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
</script>