<?=load_plugin('css', array('datetimepicker','timepicker','datepicker'))?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <?=$action?> Travel Order</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?php 
                        $form = $action == 'add' ? '' : 'hr/attendance_summary/dtr/to_edit/'.$this->uri->segment(5).'?id='.$_GET['id'];
                        echo form_open($form, array('method' => 'post', 'id' => 'frmto'))?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Destination <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtdestination" id="txtdestination"
                                            value="<?=isset($arrempto) ? $arrempto['destination'] : ''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Date <span class="required"> * </span></label>
                                    <div class="input-group input-daterange">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control form-required date-picker" data-date-format="yyyy-mm-dd"
                                                 name="dtfrom" id="dtfrom" value="<?=isset($arrempto) ? $arrempto['toDateFrom'] : ''?>">
                                        </div>
                                        <span class="input-group-addon"> to </span>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control form-required date-picker" data-date-format="yyyy-mm-dd"
                                                 name="dtto" id="dtto" value="<?=isset($arrempto) ? $arrempto['toDateTo'] : ''?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Purpose <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <textarea class="form-control form-required" name="txtpurpose" id="txtpurpose"><?=isset($arrempto) ? $arrempto['purpose'] : ''?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Source of Fund <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <select class="bs-select form-control form-required" name="selfund" id="selfund">
                                            <option value="">-- SELECT FUND SOURCE --</option>
                                            <?php 
                                                foreach(array('Fund 101', 'Fund 102') as $fund):
                                                    $selected = isset($arrempto) ? $fund == $arrempto['fund'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$fund.'" '.$selected.'>'.$fund.'</option>';
                                                endforeach;
                                             ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Transportation <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <select class="bs-select form-control form-required" name="seltranspo" id="seltranspo">
                                            <option value="">-- SELECT TRANSPORTATION --</option>
                                            <?php 
                                                foreach(array('Official Vehicle','Non-agency','Personal') as $transpo):
                                                    $selected = isset($arrempto) ? $transpo == $arrempto['transportation'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$transpo.'" '.$selected.'>'.$transpo.'</option>';
                                                endforeach;
                                             ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <label class="control-label col-md-3">Will Claim Perdiem <span class="required"> * </span></label>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="radperdiem" id="optionsRadios25" value="Y"
                                            <?=isset($arrempto) ? $arrempto['perdiem'] == 'Y' ? 'checked' : '' : ''?>> Yes </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radperdiem" id="optionsRadios26" value="N"
                                            <?=isset($arrempto) ? $arrempto['perdiem'] == 'N' ? 'checked' : '' : 'checked'?>> No </label>
                                </div>
                            </div>
                            <br><br>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <label class="control-label col-md-3">With Meal <span class="required"> * </span></label>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="radwmeal" id="optionsRadios25" value="Y"
                                            <?=isset($arrempto) ? $arrempto['wmeal'] == 'Y' ? 'checked' : '' : ''?>> Yes </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radwmeal" id="optionsRadios26" value="N"
                                            <?=isset($arrempto) ? $arrempto['wmeal'] == 'N' ? 'checked' : '' : 'checked'?>> No </label>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="btn green" type="submit" id="btn_to"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                    <a href="<?=base_url('hr/attendance_summary/dtr/to/').$arrData['empNumber']?>" class="btn blue">
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
        $('.date-picker').on('changeDate', function(){
            $(this).datepicker('hide');
        });

        $('#txtdestination').on('keyup keypress change',function() {
            $('#txtdestination').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtdestination').val() != ''){
                $('#txtdestination').closest('div.form-group').removeClass('has-error');
                $('#txtdestination').closest('div.form-group').addClass('has-success');
                $('#txtdestination').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtdestination').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtdestination'));
            }else{
                $('#txtdestination').closest('div.form-group').addClass('has-error');
                $('#txtdestination').closest('div.form-group').removeClass('has-success');
                $('#txtdestination').closest('div.form-group').find('i.fa-check').remove();
                $('#txtdestination').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtdestination'));
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

        $('#txtpurpose').on('keyup keypress change',function() {
            $('#txtpurpose').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtpurpose').val() != ''){
                $('#txtpurpose').closest('div.form-group').removeClass('has-error');
                $('#txtpurpose').closest('div.form-group').addClass('has-success');
                $('#txtpurpose').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtpurpose').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtpurpose'));
            }else{
                $('#txtpurpose').closest('div.form-group').addClass('has-error');
                $('#txtpurpose').closest('div.form-group').removeClass('has-success');
                $('#txtpurpose').closest('div.form-group').find('i.fa-check').remove();
                $('#txtpurpose').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#txtpurpose'));
            }
        });

        $('#selfund').on('keyup keypress change',function() {
            $('#selfund').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#selfund').val() != ''){
                $('#selfund').closest('div.form-group').removeClass('has-error');
                $('#selfund').closest('div.form-group').addClass('has-success');
                $('#selfund').closest('div.form-group').find('i.fa-warning').remove();
                $('#selfund').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#selfund'));
            }else{
                $('#selfund').closest('div.form-group').addClass('has-error');
                $('#selfund').closest('div.form-group').removeClass('has-success');
                $('#selfund').closest('div.form-group').find('i.fa-check').remove();
                $('#selfund').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#selfund'));
            }
        });

        $('#seltranspo').on('keyup keypress change',function() {
            $('#seltranspo').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#seltranspo').val() != ''){
                $('#seltranspo').closest('div.form-group').removeClass('has-error');
                $('#seltranspo').closest('div.form-group').addClass('has-success');
                $('#seltranspo').closest('div.form-group').find('i.fa-warning').remove();
                $('#seltranspo').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#seltranspo'));
            }else{
                $('#seltranspo').closest('div.form-group').addClass('has-error');
                $('#seltranspo').closest('div.form-group').removeClass('has-success');
                $('#seltranspo').closest('div.form-group').find('i.fa-check').remove();
                $('#seltranspo').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#seltranspo'));
            }
        });

        $('#dtfrom,#dtto').on('keyup keypress change',function() {
            $('#dtto').closest('div.form-group').find('i.fa-calendar').remove();
            otdate_from  = $('#dtfrom').val();
            otdate_to = $('#dtto').val();
            if(otdate_from != '' && otdate_to != ''){
                $('#dtto').closest('div.form-group').removeClass('has-error');
                $('#dtto').closest('div.form-group').addClass('has-success');
                $('#dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('#dtto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#dtto'));
            }else{
                $('#dtto').closest('div.form-group').addClass('has-error');
                $('#dtto').closest('div.form-group').removeClass('has-success');
                $('#dtto').closest('div.form-group').find('i.fa-check').remove();
                $('#dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Travel Date must not be empty."></i>').tooltip().insertBefore($('#dtto'));
            }
        });

        $("#btn_to").click(function(e) {
            var arrerror = [];

            $('#txtdestination').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtdestination').val() != ''){
                $('#txtdestination').closest('div.form-group').removeClass('has-error');
                $('#txtdestination').closest('div.form-group').addClass('has-success');
                $('#txtdestination').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtdestination').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtdestination'));
            }else{
                $('#txtdestination').closest('div.form-group').addClass('has-error');
                $('#txtdestination').closest('div.form-group').removeClass('has-success');
                $('#txtdestination').closest('div.form-group').find('i.fa-check').remove();
                $('#txtdestination').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Destination must not be empty."></i>').tooltip().insertBefore($('#txtdestination'));
                arrerror.push(1);
            }

            $('#dtto').closest('div.form-group').find('i.fa-calendar').remove();
            otdate_from  = $('#dtfrom').val();
            otdate_to = $('#dtto').val();
            if(otdate_from != '' && otdate_to != ''){
                $('#dtto').closest('div.form-group').removeClass('has-error');
                $('#dtto').closest('div.form-group').addClass('has-success');
                $('#dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('#dtto').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#dtto'));
            }else{
                $('#dtto').closest('div.form-group').addClass('has-error');
                $('#dtto').closest('div.form-group').removeClass('has-success');
                $('#dtto').closest('div.form-group').find('i.fa-check').remove();
                $('#dtto').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Travel Date must not be empty."></i>').tooltip().insertBefore($('#dtto'));
                arrerror.push(1);
            }

            $('#txtpurpose').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#txtpurpose').val() != ''){
                $('#txtpurpose').closest('div.form-group').removeClass('has-error');
                $('#txtpurpose').closest('div.form-group').addClass('has-success');
                $('#txtpurpose').closest('div.form-group').find('i.fa-warning').remove();
                $('#txtpurpose').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#txtpurpose'));
            }else{
                $('#txtpurpose').closest('div.form-group').addClass('has-error');
                $('#txtpurpose').closest('div.form-group').removeClass('has-success');
                $('#txtpurpose').closest('div.form-group').find('i.fa-check').remove();
                $('#txtpurpose').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Purpose must not be empty."></i>').tooltip().insertBefore($('#txtpurpose'));
                arrerror.push(1);
            }

            $('#selfund').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#selfund').val() != ''){
                $('#selfund').closest('div.form-group').removeClass('has-error');
                $('#selfund').closest('div.form-group').addClass('has-success');
                $('#selfund').closest('div.form-group').find('i.fa-warning').remove();
                $('#selfund').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#selfund'));
            }else{
                $('#selfund').closest('div.form-group').addClass('has-error');
                $('#selfund').closest('div.form-group').removeClass('has-success');
                $('#selfund').closest('div.form-group').find('i.fa-check').remove();
                $('#selfund').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Source of fund must not be empty."></i>').tooltip().insertBefore($('#selfund'));
                arrerror.push(1);
            }

            $('#seltranspo').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#seltranspo').val() != ''){
                $('#seltranspo').closest('div.form-group').removeClass('has-error');
                $('#seltranspo').closest('div.form-group').addClass('has-success');
                $('#seltranspo').closest('div.form-group').find('i.fa-warning').remove();
                $('#seltranspo').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#seltranspo'));
            }else{
                $('#seltranspo').closest('div.form-group').addClass('has-error');
                $('#seltranspo').closest('div.form-group').removeClass('has-success');
                $('#seltranspo').closest('div.form-group').find('i.fa-check').remove();
                $('#seltranspo').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Transportation must not be empty."></i>').tooltip().insertBefore($('#seltranspo'));
                arrerror.push(1);
            }

            if(jQuery.inArray(1,arrerror) !== -1){
                e.preventDefault();
            }

        });
            
    });
</script>