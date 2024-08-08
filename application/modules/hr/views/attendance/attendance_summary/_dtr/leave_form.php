<?=load_plugin('css', array('datetimepicker','timepicker','datepicker'))?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <?=$action?> Leave</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?php 
                        $form = $action == 'add' ? '' : 'hr/attendance_summary/dtr/leave_edit/'.$this->uri->segment(5).'?id='.$_GET['id'];
                        echo form_open($form, array('method' => 'post', 'id' => 'frmleave'))?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Type of Leave <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="bs-select form-control form-required" name="sel_leavetype" id="sel_leavetype">
                                            <option value="0">-- SELECT LEAVE TYPE --</option>
                                            <?php foreach($arrleaveTypes as $leave): if($leave['system'] == 1): ?>
                                                <option value="<?=$leave['leaveCode']?>" <?=isset($arremp_leave) ? $leave['leaveCode'] == $arremp_leave['leaveCode'] ? 'selected' : '' : ''?>>
                                                    <?=$leave['leaveType']?></option>
                                            <?php endif; endforeach; ?>
                                        </select>
                                    </div>
                                    <span class="font-red" id="span-warning" style="display: none;">
                                    <i class="fa fa-warning tooltips overflow" data-original-title="Type of Leave must not be empty."></i></span>
                                    <span class="font-green" id="span-success" style="display: none;">
                                    <i class="fa fa-check tooltips overflow"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row specific-leave">
                            <div class="col-md-4">
                                <div class="loading-image-small"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                <div class="form-group">
                                    <label class="control-label">Specific Type of Leave <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="bs-select form-control form-required" name="sel_spe_leave" id="sel_spe_leave">
                                            <option value="null">--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" style="margin-left: -22px;">
                                <div class="form-group">
                                    <label class="radio-inline">
                                        <input type="radio" name="radleave" value="1" id="radleave_y" <?=isset($arremp_leave) ? $arremp_leave['leaveCode'] == 'Y' ? 'checked' : '' : 'checked'?>> Whole Day </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radleave" value="0" id="radleave_n" <?=isset($arremp_leave) ? $arremp_leave['leaveCode'] == 'N' ? 'checked' : '' : ''?>> Half Day </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" id="div-date">
                                    <label class="control-label">Date <span class="required"> * </span></label>
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control form-required date-picker" data-date-format="yyyy-mm-dd"
                                            name="txtleave_dtfrom" id="txtleave_dtfrom" value="<?=date('Y-m-d')?>">
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" class="form-control form-required date-picker" data-date-format="yyyy-mm-dd"
                                            name="txtleave_dtto" id="txtleave_dtto" value="<?=date('Y-m-d')?>">
                                    </div>
                                    <span class="font-red" id="span-warning" style="display: none;">
                                        <i class="fa fa-warning tooltips overflow" data-original-title="Date must not be empty."></i></span>
                                    <span class="font-green" id="span-success" style="display: none;">
                                        <i class="fa fa-check tooltips overflow"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">No. of Day(s) applied <span class="required"> * </span><br><small><i>Note : Weekends and holidays not included</i></small></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" value="<?=isset($arremp_leave) ? $noofdays : ''?>" id="txtleave_noofdays" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Specify Reason <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <textarea class="form-control form-required" name="txtleave_reason" id="txtleave_reason"><?=isset($arremp_leave) ? $arremp_leave['reason'] : ''?></textarea>
                                    </div>
                                    <span class="font-red" id="span-warning" style="display: none;">
                                    <i class="fa fa-warning tooltips overflow" data-original-title="Type of Leave must not be empty."></i></span>
                                    <span class="font-green" id="span-success" style="display: none;">
                                    <i class="fa fa-check tooltips overflow"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="btn green" type="submit" id="btn_add_deduction"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                    <a href="<?=base_url('hr/attendance_summary/dtr/leave/').$arrData['empNumber']?>" class="btn blue">
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

        // begin setting specific leave
        $('.loading-image-small,.specific-leave').hide();
        $('#sel_leavetype').change(function() {
            leavetype = $(this).val();
            $('.loading-image-small').show();
            $.get("<?=base_url('hr/attendance/dtr_specific_leave')?>", {type: leavetype==0?null:leavetype}, function(data) {
                data = data.trim();
                // console.log(data);
                if(data != 'empty'){
                    $('#sel_spe_leave').empty();
                    var opts = '';
                    $.each(JSON.parse(data), function(i, opt) { opts = opts + '<option value="'+opt.specifyLeave+'">'+opt.specifyLeave+'</option>';});
                    $('#sel_spe_leave').append(opts);
                    $('.specific-leave').show();
                }else{
                    $('.specific-leave').hide();
                }
                $('#sel_spe_leave').selectpicker('refresh');
                $('.loading-image-small').hide();
            });

            if(leavetype != 0){
                $(this).closest('div.form-group').removeClass('has-error');
                $(this).closest('div.form-group').addClass('has-success');
                // $(this).closest('div.form-group').find('i.fa-warning').remove();
                // $(this).closest('div.form-group').find('i.fa-check').remove();
                // $('<i class="fa fa-check tooltips"></i>').insertBefore($(this));
                $(this).closest('div.form-group').find('#span-success').show();
                $(this).closest('div.form-group').find('#span-warning').hide();
            }else{
                $(this).closest('div.form-group').addClass('has-error');
                $(this).closest('div.form-group').removeClass('has-success');
                // $(this).closest('div.form-group').find('i.fa-check').remove();
                // $(this).closest('div.form-group').find('i.fa-warning').remove();
                // $('<i class="fa fa-warning tooltips" data-original-title="Type of leave is required."></i>').tooltip().insertBefore($(this));
                $(this).closest('div.form-group').find('#span-success').hide();
                $(this).closest('div.form-group').find('#span-warning').show();
            }
        });
        // end setting specific leave

        $('#txtleave_reason').on('keyup keypress change',function() {
            if($(this).val() != ''){
                $(this).closest('div.form-group').removeClass('has-error');
                $(this).closest('div.form-group').addClass('has-success');
                // $(this).closest('div.form-group').find('i.fa-warning').remove();
                // $(this).closest('div.form-group').find('i.fa-check').remove();
                // $('<i class="fa fa-check tooltips"></i>').insertBefore($(this));
                $(this).closest('div.form-group').find('#span-success').show();
                $(this).closest('div.form-group').find('#span-warning').hide();
            }else{
                $(this).closest('div.form-group').addClass('has-error');
                $(this).closest('div.form-group').removeClass('has-success');
                // $(this).closest('div.form-group').find('i.fa-check').remove();
                // $(this).closest('div.form-group').find('i.fa-warning').remove();
                // $('<i class="fa fa-warning tooltips" data-original-title="Reason must not be empty."></i>').tooltip().insertBefore($(this));
                $(this).closest('div.form-group').find('#span-success').hide();
                $(this).closest('div.form-group').find('#span-warning').show();
            }
        });

        // begin getting number of days
        var leavefrom = $('#txtleave_dtfrom').val();
        var leaveto   = $('#txtleave_dtto').val();
        $('#txtleave_dtfrom').on('changeDate keyup keypress', function(ev){
            $(this).datepicker('hide');
            leavefrom = $('#txtleave_dtfrom').val();
            leaveto   = $('#txtleave_dtto').val();
            $.get("<?=base_url('hr/attendance/dtr_no_ofdays')?>", {leavefrom: leavefrom, leaveto: leaveto}, function(data) {
                data = data.trim();
                $('#txtleave_noofdays').val(data);
            });

            if(leaveto != '' && leavefrom != ''){
                $('#div-date').addClass('has-success');
                $('#div-date').removeClass('has-error');
                $(this).closest('div.form-group').find('#span-success').show();
                $(this).closest('div.form-group').find('#span-warning').hide();
            }else{
                $('#txtleave_noofdays').val('0');
                $('#div-date').addClass('has-error');
                $('#div-date').removeClass('has-success');
                $(this).closest('div.form-group').find('#span-success').hide();
                $(this).closest('div.form-group').find('#span-warning').show();
            }
        });

        $('#txtleave_dtto').on('changeDate keyup keypress', function(ev){
            $(this).datepicker('hide');
            leavefrom = $('#txtleave_dtfrom').val();
            leaveto   = $('#txtleave_dtto').val();
            $.get("<?=base_url('hr/attendance/dtr_no_ofdays')?>", {leavefrom: leavefrom, leaveto: leaveto}, function(data) {
                data = data.trim();
                $('#txtleave_noofdays').val(data);
            });

            if(leaveto != '' && leavefrom != ''){
                $('#div-date').addClass('has-success');
                $('#div-date').removeClass('has-error');
                $(this).closest('div.form-group').find('#span-success').show();
                $(this).closest('div.form-group').find('#span-warning').hide();
            }else{
                $('#txtleave_noofdays').val('0');
                $('#div-date').addClass('has-error');
                $('#div-date').removeClass('has-success');
                $(this).closest('div.form-group').find('#span-success').hide();
                $(this).closest('div.form-group').find('#span-warning').show();
            }
        });
        // end getting number of days

        $('#btn_add_deduction').on('click', function(e) {
            var arrerror= [];

            leavefrom = $('#txtleave_dtfrom').val();
            leaveto   = $('#txtleave_dtto').val();
            if(leaveto != '' && leavefrom != ''){
                $('#div-date').addClass('has-success');
                $('#div-date').removeClass('has-error');
                $(this).closest('div.form-group').find('#span-success').show();
                $(this).closest('div.form-group').find('#span-warning').hide();

                $.get("<?=base_url('hr/attendance/dtr_no_ofdays')?>", {leavefrom: leavefrom, leaveto: leaveto}, function(data) {
                    data = data.trim();
                    $('#txtleave_noofdays').val(data);
                });
            }else{
                $('#txtleave_noofdays').val('0');
                $('#div-date').addClass('has-error');
                $('#div-date').removeClass('has-success');
                $(this).closest('div.form-group').find('#span-success').hide();
                $(this).closest('div.form-group').find('#span-warning').show();
                arrerror.push(1);
            }

            if($('#txtleave_reason').val() != ''){
                $('#txtleave_reason').closest('div.form-group').removeClass('has-error');
                $('#txtleave_reason').closest('div.form-group').addClass('has-success');
                // $('#txtleave_reason').closest('div.form-group').find('i.fa-warning').remove();
                // $('#txtleave_reason').closest('div.form-group').find('i.fa-check').remove();
                // $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtleave_reason'));
                $(this).closest('div.form-group').find('#span-success').show();
                $(this).closest('div.form-group').find('#span-warning').hide();
            }else{
                $('#txtleave_reason').closest('div.form-group').addClass('has-error');
                $('#txtleave_reason').closest('div.form-group').removeClass('has-success');
                // $('#txtleave_reason').closest('div.form-group').find('i.fa-check').remove();
                // $('#txtleave_reason').closest('div.form-group').find('i.fa-warning').remove();
                // $('<i class="fa fa-warning tooltips" data-original-title="Reason must not be empty."></i>').tooltip().insertBefore($('#txtleave_reason'));
                $(this).closest('div.form-group').find('#span-success').hide();
                $(this).closest('div.form-group').find('#span-warning').show();
                arrerror.push(1);
            }

            leavetype = $('#sel_leavetype').val();
            if(leavetype != 0){
                $('#sel_leavetype').closest('div.form-group').removeClass('has-error');
                $('#sel_leavetype').closest('div.form-group').addClass('has-success');
                // $('#sel_leavetype').closest('div.form-group').find('i.fa-warning').remove();
                // $('#sel_leavetype').closest('div.form-group').find('i.fa-check').remove();
                // $('<i class="fa fa-check tooltips"></i>').insertBefore($('#sel_leavetype'));
                $(this).closest('div.form-group').find('#span-success').show();
                $(this).closest('div.form-group').find('#span-warning').hide();
            }else{
                $('#sel_leavetype').closest('div.form-group').addClass('has-error');
                $('#sel_leavetype').closest('div.form-group').removeClass('has-success');
                // $('#sel_leavetype').closest('div.form-group').find('i.fa-check').remove();
                // $('#sel_leavetype').closest('div.form-group').find('i.fa-warning').remove();
                // $('<i class="fa fa-warning tooltips" data-original-title="Type of leave is required."></i>').tooltip().insertBefore($('#sel_leavetype'));
                $(this).closest('div.form-group').find('#span-success').hide();
                $(this).closest('div.form-group').find('#span-warning').show();
                arrerror.push(1);
            }

            if(jQuery.inArray(1,arrerror) !== -1){
                e.preventDefault();
            }
        });

    });
</script>