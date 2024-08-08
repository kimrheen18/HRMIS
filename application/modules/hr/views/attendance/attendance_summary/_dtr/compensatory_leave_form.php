<?=load_plugin('css', array('datetimepicker','timepicker','datepicker'))?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <?=$action?> Compensatory Time Off</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <small><b>Total CTO : </b></small> <u><?=date('H:i', mktime(0, $total_ot))?></u>
                        </div>
                    </div>
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?php 
                        $form = $action == 'add' ? '' : 'hr/attendance_summary/dtr/dtr_add_compensatory_leave/'.$this->uri->segment(5).'?id='.$_GET['id'];
                        echo form_open($form, array('method' => 'post', 'id' => 'frmcompenleave'))?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"><b>Date</b> <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-calendar"></i>
                                        <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" 
                                                name="txtcompen_date" id="txtcompen_date" type="text"
                                                value="<?=set_value('txtcompen_date', '')?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group div_am_time">
                                    <label class="control-label"><b>Time </b> <label>
                                    </label>
                                        <br>From <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-clock-o"></i>
                                        <input type="text" class="form-control timepicker form-required timepicker-default" name="txtcl_timefrom" id="txtcl_timefrom"
                                                value="<?=set_value('txtcl_timefrom','08:00 AM')?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group div_am_time">
                                    <label class="control-label">
                                        <br>To <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-clock-o"></i>
                                        <input type="text" class="form-control timepicker form-required timepicker-default" name="txtcl_timeto" id="txtcl_timeto"
                                                value="<?=set_value('txtcl_timeto','05:00 PM')?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="btn green" type="submit" id="btn_compen_leave" <?=$total_ot == 0 ? 'disabled' : ''?>>
                                        <i class="fa fa-plus"></i> <?=ucfirst($action)?> </button>
                                    <a href="<?=base_url('hr/attendance_summary/dtr/compensatory_leave/').$arrData['empNumber']?>" class="btn blue">
                                        <i class="icon-ban"></i> Cancel</a>
                                </div>
                            </div>
                        </div>

                        </div>
                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="confirm-modal-cl" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title bold">Attendance - Compensatory Time Off</h5>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Dates may contain entry, are you sure you want to override the data?</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit-dtrcl" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<?=load_plugin('js',array('datetimepicker','timepicker','datepicker'));?>

<script>
    $(document).ready(function() {
        $('.timepicker').timepicker({
            timeFormat: 'HH:mm A',
            disableFocus: true,
            showInputs: false,
            showSeconds: false,
            showMeridian: true,
            autoclose: true,
        });
        $('.date-picker').datepicker();
        $('.date-picker').on('changeDate', function(){
            $(this).datepicker('hide');
        });

        /*Begin CTO Date*/
        $('#txtcompen_date').on('keyup keypress change',function() {
            $('#txtcompen_date').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtcompen_date').val() != ''){
                $('#txtcompen_date').closest('div.form-group').removeClass('has-error');
                $('#txtcompen_date').closest('div.form-group').addClass('has-success');
                $('#txtcompen_date').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtcompen_date').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtcompen_date'));
            }else{
                $('#txtcompen_date').closest('div.form-group').addClass('has-error');
                $('#txtcompen_date').closest('div.form-group').removeClass('has-success');
                $('#txtcompen_date').closest('div.form-group').find('i.fa-check').remove();
                $('#txtcompen_date').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtcompen_date'));
            }
        });
        /*End CTO Date*/

        /*Begin Time*/
        $('#txtcl_timefrom,#txtcl_timeto').bind("change keyup keypress", function() {
            $('#txtcl_timefrom').closest('div.form-group').find('i.fa-clock-o').remove();
            $('#txtcl_timeto').closest('div.form-group').find('i.fa-clock-o').remove();
            am_timein  = $('#txtcl_timefrom').val();
            am_timeout = $('#txtcl_timeto').val();
            if(am_timein != '' && am_timeout != ''){
                $('.div_am_time').addClass('has-success');
                $('.div_am_time').removeClass('has-error');
                $('#txtcl_timefrom,#txtcl_timeto').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtcl_timefrom,#txtcl_timeto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtcl_timefrom'));
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtcl_timeto'));
            }else{
                $('.div_am_time').addClass('has-error');
                $('.div_am_time').removeClass('has-success');
                $('#txtcl_timefrom,#txtcl_timeto').closest('div.form-group').find('i.fa-check').remove();
                $('#txtcl_timefrom,#txtcl_timeto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Morning Time must not be empty."></i>').tooltip().insertBefore($('#txtcl_timefrom'));
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Morning Time must not be empty."></i>').tooltip().insertBefore($('#txtcl_timeto'));
            }
        });
        /*End Time*/

        $("#btn_compen_leave").click(function(e) {
            e.preventDefault();
            var arrerror= [];
            /* Begin cto date */
            $('#txtcompen_date').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtcompen_date').val() != ''){
                $('#txtcompen_date').closest('div.form-group').removeClass('has-error');
                $('#txtcompen_date').closest('div.form-group').addClass('has-success');
                $('#txtcompen_date').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtcompen_date').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtcompen_date'));
            }else{
                $('#txtcompen_date').closest('div.form-group').addClass('has-error');
                $('#txtcompen_date').closest('div.form-group').removeClass('has-success');
                $('#txtcompen_date').closest('div.form-group').find('i.fa-check').remove();
                $('#txtcompen_date').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtcompen_date'));
                arrerror.push(1);
            }
            /* End cto date */

            /*Begin cto AM*/
            $('#txtcl_am_timefrom').closest('div.form-group').find('i.fa-clock-o').remove();
            $('#txtcl_am_timeto').closest('div.form-group').find('i.fa-clock-o').remove();
            am_timein  = $('#txtcl_am_timefrom').val();
            am_timeout = $('#txtcl_am_timeto').val();
            if(am_timein != '' && am_timeout != ''){
                $('.div_am_time').addClass('has-success');
                $('.div_am_time').removeClass('has-error');
                $('#txtcl_am_timefrom,#txtcl_am_timeto').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtcl_am_timefrom,#txtcl_am_timeto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtcl_am_timefrom'));
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtcl_am_timeto'));
            }else{
                $('.div_am_time').addClass('has-error');
                $('.div_am_time').removeClass('has-success');
                $('#txtcl_am_timefrom,#txtcl_am_timeto').closest('div.form-group').find('i.fa-check').remove();
                $('#txtcl_am_timefrom,#txtcl_am_timeto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Morning Time must not be empty."></i>').tooltip().insertBefore($('#txtcl_am_timefrom'));
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Morning Time must not be empty."></i>').tooltip().insertBefore($('#txtcl_am_timeto'));
                arrerror.push(1);
            }
            /*End cto AM*/

            /*Begin cto PM*/
            $('#txtcl_pm_timefrom').closest('div.form-group').find('i.fa-clock-o').remove();
            $('#txtcl_pm_timeto').closest('div.form-group').find('i.fa-clock-o').remove();
            pm_timein  = $('#txtcl_pm_timefrom').val();
            pm_timeout = $('#txtcl_pm_timeto').val();
            if(pm_timein != '' && pm_timeout != ''){
                $('.div_pm_time').addClass('has-success');
                $('.div_pm_time').removeClass('has-error');
                $('#txtcl_pm_timefrom,#txtcl_pm_timeto').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtcl_pm_timefrom,#txtcl_pm_timeto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtcl_pm_timefrom'));
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtcl_pm_timeto'));
            }else{
                $('.div_pm_time').addClass('has-error');
                $('.div_pm_time').removeClass('has-success');
                $('#txtcl_pm_timefrom,#txtcl_pm_timeto').closest('div.form-group').find('i.fa-check').remove();
                $('#txtcl_pm_timefrom,#txtcl_pm_timeto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Afternoon Time must not be empty."></i>').tooltip().insertBefore($('#txtcl_pm_timefrom'));
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Afternoon Time must not be empty."></i>').tooltip().insertBefore($('#txtcl_pm_timeto'));
                arrerror.push(1);
            }
            /*End cto PM*/

            if(jQuery.inArray(1,arrerror) !== -1){
            }else{
                $("#confirm-modal-cl").modal('show');
                $('#submit-dtrcl').click(function() {$('#frmcompenleave').submit();});
            }
            
        });
    });
</script>