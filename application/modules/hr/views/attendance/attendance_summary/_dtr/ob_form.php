<?=load_plugin('css', array('datetimepicker','timepicker','datepicker'))?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <?=$action?> OB</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?php 
                        $form = $action == 'add' ? '' : 'hr/attendance_summary/dtr/ob_edit/'.$this->uri->segment(5).'?id='.$_GET['id'];
                        echo form_open($form, array('method' => 'post', 'id' => 'frmob'))?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Official Business? <span class="required"> * </span></label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radob" value="1" <?=isset($arrem_ob) ? $arrem_ob['official'] == 'Y' ? 'checked' : '' : 'checked'?>> Yes </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radob" value="0" <?=isset($arrem_ob) ? $arrem_ob['official'] == 'N' ? 'checked' : '' : ''?>> No </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Date From <span class="required"> * </span></label>
                                    <div class="input-group date-picker input-daterange" data-date="2003" data-date-format="yyyy-mm-dd" data-date-viewmode="years" id="dateRange">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control form-required" name="txtob_dtfrom" id="txtob_dtfrom"
                                                value="<?=isset($arrem_ob) ? $arrem_ob['obDateFrom'] : ''?>">
                                        </div>
                                        <span class="input-group-addon"> to </span>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control form-required" name="txtob_dtto" id="txtob_dtto"
                                                value="<?=isset($arrem_ob) ? $arrem_ob['obDateTo'] : ''?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label class="control-label">Time From <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control timepicker form-required timepicker-default" name="txtob_tmin"
                                            id="txtob_tmin" value="<?=isset($arrem_ob) ? $arrem_ob['obTimeFrom'] : '08:00:00 AM'?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">Time To <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control timepicker form-required timepicker-default" name="txtob_tmout"
                                            id="txtob_tmout" value="<?=isset($arrem_ob) ? $arrem_ob['obTimeTo'] : '05:00:00 PM'?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label class="control-label">Place <span class="required"> * </span></label>
                            <div class="input-icon right">
                                <textarea class="form-control form-required" name="txtob_place" id="txtob_place"><?=isset($arrem_ob) ? $arrem_ob['obPlace'] : ''?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">With Meal? <span class="required"> * </span></label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radob_wmeal" value="1" <?=isset($arrem_ob) ? $arrem_ob['obMeal'] == 'Y' ? 'checked' : '' : ''?>> Yes </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radob_wmeal" value="0" <?=isset($arrem_ob) ? $arrem_ob['obMeal'] == 'N' ? 'checked' : '' : 'checked'?>> No </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Purpose <span class="required"> * </span></label>
                            <div class="input-icon right">
                                <textarea class="form-control form-required" name="txtob_purpose" id="txtob_purpose"><?=isset($arrem_ob) ? $arrem_ob['purpose'] : ''?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="btn green" type="submit" id="btn_ob"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                    <a href="<?=base_url('hr/attendance_summary/dtr/ob/').$arrData['empNumber']?>" class="btn blue">
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

        $('#txtob_dtfrom,#txtob_dtto').on('keyup keypress change',function() {
            $('#txtob_dtto').closest('div.form-group').find('i.fa-calendar').remove();
            obdate_from  = $('#txtob_dtfrom').val();
            obdate_to = $('#txtob_dtto').val();
            if(obdate_from != '' && obdate_to != ''){
                $('#txtob_dtto').closest('div.form-group').removeClass('has-error');
                $('#txtob_dtto').closest('div.form-group').addClass('has-success');
                $('#txtob_dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtob_dtto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtob_dtto'));
            }else{
                $('#txtob_dtto').closest('div.form-group').addClass('has-error');
                $('#txtob_dtto').closest('div.form-group').removeClass('has-success');
                $('#txtob_dtto').closest('div.form-group').find('i.fa-check').remove();
                $('#txtob_dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtob_dtto'));
            }
        });

        $('#txtob_tmin,#txtob_tmout').on('keyup keypress change',function() {
            $('#txtob_tmout').closest('div.form-group').find('i.fa-calendar').remove();
            obtime_from  = $('#txtob_tmin').val();
            obtime_to = $('#txtob_tmout').val();
            if(obtime_from != '' && obtime_to != ''){
                $('#txtob_tmout').closest('div.form-group').removeClass('has-error');
                $('#txtob_tmout').closest('div.form-group').addClass('has-success');
                $('#txtob_tmout').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtob_tmout').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtob_tmout'));
            }else{
                $('#txtob_tmout').closest('div.form-group').addClass('has-error');
                $('#txtob_tmout').closest('div.form-group').removeClass('has-success');
                $('#txtob_tmout').closest('div.form-group').find('i.fa-check').remove();
                $('#txtob_tmout').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtob_tmout'));
            }
        });

        $('#txtob_purpose').on('keyup keypress change',function() {
            $('#txtob_purpose').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtob_purpose').val() != ''){
                $('#txtob_purpose').closest('div.form-group').removeClass('has-error');
                $('#txtob_purpose').closest('div.form-group').addClass('has-success');
                $('#txtob_purpose').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtob_purpose').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtob_purpose'));
            }else{
                $('#txtob_purpose').closest('div.form-group').addClass('has-error');
                $('#txtob_purpose').closest('div.form-group').removeClass('has-success');
                $('#txtob_purpose').closest('div.form-group').find('i.fa-check').remove();
                $('#txtob_purpose').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtob_purpose'));
            }
        });

        $('#txtob_place').on('keyup keypress change',function() {
            $('#txtob_place').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtob_place').val() != ''){
                $('#txtob_place').closest('div.form-group').removeClass('has-error');
                $('#txtob_place').closest('div.form-group').addClass('has-success');
                $('#txtob_place').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtob_place').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtob_place'));
            }else{
                $('#txtob_place').closest('div.form-group').addClass('has-error');
                $('#txtob_place').closest('div.form-group').removeClass('has-success');
                $('#txtob_place').closest('div.form-group').find('i.fa-check').remove();
                $('#txtob_place').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtob_place'));
            }
        });


        $("#btn_ob").click(function(e) {
            var arrerror = [];

            /*Begin Date From*/
            $('#txtob_dtto').closest('div.form-group').find('i.fa-calendar').remove();
            obdate_from  = $('#txtob_dtfrom').val();
            obdate_to = $('#txtob_dtto').val();
            if(obdate_from != '' && obdate_to != ''){
                $('#txtob_dtto').closest('div.form-group').removeClass('has-error');
                $('#txtob_dtto').closest('div.form-group').addClass('has-success');
                $('#txtob_dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtob_dtto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtob_dtto'));
            }else{
                $('#txtob_dtto').closest('div.form-group').addClass('has-error');
                $('#txtob_dtto').closest('div.form-group').removeClass('has-success');
                $('#txtob_dtto').closest('div.form-group').find('i.fa-check').remove();
                $('#txtob_dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtob_dtto'));
                arrerror.push(1);
            }
            /*End Date To*/

            /*Begin Time From*/
            $('#txtob_tmout').closest('div.form-group').find('i.fa-calendar').remove();
            obtime_from  = $('#txtob_tmin').val();
            obtime_to = $('#txtob_tmout').val();
            if(obtime_from != '' && obtime_to != ''){
                $('#txtob_tmout').closest('div.form-group').removeClass('has-error');
                $('#txtob_tmout').closest('div.form-group').addClass('has-success');
                $('#txtob_tmout').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtob_tmout').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtob_tmout'));
            }else{
                $('#txtob_tmout').closest('div.form-group').addClass('has-error');
                $('#txtob_tmout').closest('div.form-group').removeClass('has-success');
                $('#txtob_tmout').closest('div.form-group').find('i.fa-check').remove();
                $('#txtob_tmout').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtob_tmout'));
                arrerror.push(1);
            }
            /*End Time To*/

            /* Begin place */
            $('#txtob_place').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtob_place').val() != ''){
                $('#txtob_place').closest('div.form-group').removeClass('has-error');
                $('#txtob_place').closest('div.form-group').addClass('has-success');
                $('#txtob_place').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtob_place').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtob_place'));
            }else{
                $('#txtob_place').closest('div.form-group').addClass('has-error');
                $('#txtob_place').closest('div.form-group').removeClass('has-success');
                $('#txtob_place').closest('div.form-group').find('i.fa-check').remove();
                $('#txtob_place').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtob_place'));
                arrerror.push(1);
            }
            /* End place */

            /* Begin purpose */
            $('#txtob_purpose').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtob_purpose').val() != ''){
                $('#txtob_purpose').closest('div.form-group').removeClass('has-error');
                $('#txtob_purpose').closest('div.form-group').addClass('has-success');
                $('#txtob_purpose').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtob_purpose').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtob_purpose'));
            }else{
                $('#txtob_purpose').closest('div.form-group').addClass('has-error');
                $('#txtob_purpose').closest('div.form-group').removeClass('has-success');
                $('#txtob_purpose').closest('div.form-group').find('i.fa-check').remove();
                $('#txtob_purpose').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtob_purpose'));
                arrerror.push(1);
            }
            /* End purpose */


            if(jQuery.inArray(1,arrerror) !== -1){
                e.preventDefault();
            }
            
        });

    });
</script>