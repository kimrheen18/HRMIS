<?=load_plugin('css', array('datetimepicker','timepicker','datepicker'))?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <?=$action?> Time</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?=form_open('', array('method' => 'post', 'id' => 'frmdtrtime'))?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Date From <span class="required"> * </span></label>
                                    <div class="input-group date-picker input-daterange" data-date="2003" data-date-format="yyyy-mm-dd" data-date-viewmode="years" id="dateRange">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control form-required date-picker" data-date-format="yyyy-mm-dd" name="txtdtr_dtfrom" id="txtdtr_dtfrom">
                                        </div>
                                        <span class="input-group-addon"> to </span>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control form-required date-picker" data-date-format="yyyy-mm-dd" name="txtdtr_dtto" id="txtdtr_dtto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <label class="control-label"><b>Morning</b><br>Time From <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtdtr_amtimein" id="txtdtr_amtimein" value="08:00:00 AM">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label"><br>Time To <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtdtr_amtimeout" id="txtdtr_amtimeout" value="12:00:00 PM">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <label class="control-label"><b>Afternoon</b><br>Time From <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtdtr_pmtimein" id="txtdtr_pmtimein" value="12:00:00 PM">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label"><br>Time To <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtdtr_pmtimeout" id="txtdtr_pmtimeout" value="05:00:00 PM">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label"><b>Overtime</b><br>Time From <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtdtr_ottimein" id="txtdtr_ottimein">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label"><br>Time To <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtdtr_ottimeout" id="txtdtr_ottimeout">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="btn green" type="submit" id="btn_time"><i class="fa fa-plus"></i> <?=ucfirst($action)?> </button>
                                    <a href="<?=base_url('hr/attendance_summary/dtr/time/').$arrData['empNumber']?>" class="btn blue">
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

<div id="confirm-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title bold">Attendance - Add Time</h5>
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
                <button type="submit" id="submit-dtrtime" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<?=load_plugin('js',array('datetimepicker','timepicker','datepicker'));?>

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

        $('#txtdtr_dtfrom,#txtdtr_dtto').on('keyup keypress change',function() {
            $('#txtdtr_dtto').closest('div.form-group').find('i.fa-calendar').remove();
            dtrdate_from  = $('#txtdtr_dtfrom').val();
            dtrdate_to = $('#txtdtr_dtto').val();
            if(dtrdate_from != '' && dtrdate_to != ''){
                $('#txtdtr_dtto').closest('div.form-group').removeClass('has-error');
                $('#txtdtr_dtto').closest('div.form-group').addClass('has-success');
                $('#txtdtr_dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtdtr_dtto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtdtr_dtto'));
            }else{
                $('#txtdtr_dtto').closest('div.form-group').addClass('has-error');
                $('#txtdtr_dtto').closest('div.form-group').removeClass('has-success');
                $('#txtdtr_dtto').closest('div.form-group').find('i.fa-check').remove();
                $('#txtdtr_dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtdtr_dtto'));
            }
        });

        $('#txtdtr_amtimein,#txtdtr_amtimeout').on('keyup keypress change',function() {
            $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-calendar').remove();
            dtr_amtimein  = $('#txtdtr_amtimein').val();
            dtr_amtimeout = $('#txtdtr_amtimeout').val();
            if(dtr_amtimein != '' && dtr_amtimeout != ''){
                $('#txtdtr_amtimeout').closest('div.form-group').removeClass('has-error');
                $('#txtdtr_amtimeout').closest('div.form-group').addClass('has-success');
                $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtdtr_amtimeout'));
            }else{
                $('#txtdtr_amtimeout').closest('div.form-group').addClass('has-error');
                $('#txtdtr_amtimeout').closest('div.form-group').removeClass('has-success');
                $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-check').remove();
                $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtdtr_amtimeout'));
                arrerror.push(1);
            }
        });

        $('#txtdtr_pmtimein,#txtdtr_pmtimeout').on('keyup keypress change',function() {
            $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-calendar').remove();
            dtr_pmtimein  = $('#txtdtr_pmtimein').val();
            dtr_pmtimeout = $('#txtdtr_pmtimeout').val();
            if(dtr_pmtimein != '' && dtr_pmtimeout != ''){
                $('#txtdtr_pmtimeout').closest('div.form-group').removeClass('has-error');
                $('#txtdtr_pmtimeout').closest('div.form-group').addClass('has-success');
                $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtdtr_pmtimeout'));
            }else{
                $('#txtdtr_pmtimeout').closest('div.form-group').addClass('has-error');
                $('#txtdtr_pmtimeout').closest('div.form-group').removeClass('has-success');
                $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-check').remove();
                $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtdtr_pmtimeout'));
                arrerror.push(1);
            }
        });


        $("#btn_time").click(function(e) {
            e.preventDefault();
            var arrerror= [];

            dtr_dtfrom = $('#txtdtr_dtfrom').val();
            dtr_dtto   = $('#txtdtr_dtto').val();
            if(dtr_dtfrom != '' && dtr_dtto != ''){
                $('#txtdtr_dtto').closest('div.form-group').removeClass('has-error');
                $('#txtdtr_dtto').closest('div.form-group').addClass('has-success');
                $('#txtdtr_dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtdtr_dtto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtdtr_dtto'));
            }else{
                $('#txtdtr_dtto').closest('div.form-group').addClass('has-error');
                $('#txtdtr_dtto').closest('div.form-group').removeClass('has-success');
                $('#txtdtr_dtto').closest('div.form-group').find('i.fa-check').remove();
                $('#txtdtr_dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtdtr_dtto'));
                arrerror.push(1);
            }

            $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-calendar').remove();
            dtr_amtimein  = $('#txtdtr_amtimein').val();
            dtr_amtimeout = $('#txtdtr_amtimeout').val();
            if(dtr_amtimein != '' && dtr_amtimeout != ''){
                $('#txtdtr_amtimeout').closest('div.form-group').removeClass('has-error');
                $('#txtdtr_amtimeout').closest('div.form-group').addClass('has-success');
                $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtdtr_amtimeout'));
            }else{
                $('#txtdtr_amtimeout').closest('div.form-group').addClass('has-error');
                $('#txtdtr_amtimeout').closest('div.form-group').removeClass('has-success');
                $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-check').remove();
                $('#txtdtr_amtimeout').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtdtr_amtimeout'));
                arrerror.push(1);
            }

            $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-calendar').remove();
            dtr_pmtimein  = $('#txtdtr_pmtimein').val();
            dtr_pmtimeout = $('#txtdtr_pmtimeout').val();
            if(dtr_pmtimein != '' && dtr_pmtimeout != ''){
                $('#txtdtr_pmtimeout').closest('div.form-group').removeClass('has-error');
                $('#txtdtr_pmtimeout').closest('div.form-group').addClass('has-success');
                $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtdtr_pmtimeout'));
            }else{
                $('#txtdtr_pmtimeout').closest('div.form-group').addClass('has-error');
                $('#txtdtr_pmtimeout').closest('div.form-group').removeClass('has-success');
                $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-check').remove();
                $('#txtdtr_pmtimeout').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtdtr_pmtimeout'));
                arrerror.push(1);
            }

            if(jQuery.inArray(1,arrerror) !== -1){
                e.preventDefault();
            }else{
                $("#confirm-modal").modal('show');
                $('#submit-dtrtime').click(function() {$('#frmdtrtime').submit();});
            }
            
        });

    });
</script>