<?php load_plugin('css',array('datatables','datepicker'));?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <?=$action?> Schedule</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-6">
                        <?php
                            $form = $action == 'add' ? '' : 'hr/attendance_summary/dtr/broken_sched_edit/'.$this->uri->segment(5).'?id='.$_GET['id'];
                            echo form_open($form, array('method' => 'post', 'id' => 'frmaddsched'))?>
                            <div class="form-group">
                                <label class="control-label">Date From <span class="required"> * </span></label>
                                <div class="input-group input-large date-picker input-daterange" data-date="2003" data-date-format="yyyy-mm-dd" data-date-viewmode="years" id="bs_sched_date">
                                    <div class="input-icon right">
                                        <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" 
                                                name="bs_sched_from" id="bs_sched_from" type="text"
                                                value="<?=isset($arrshedule) ? $arrshedule['dateFrom'] : ''?>">
                                    </div>
                                    <span class="input-group-addon"> to </span>
                                    <div class="input-icon right">
                                        <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" 
                                                name="bs_sched_to" id="bs_sched_to" type="text"
                                                value="<?=isset($arrshedule) ? $arrshedule['dateTo'] : ''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Attendance Scheme <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <select class="bs-select form-control form-required" name="selscheme" id="selscheme">
                                        <option value="">-- SELECT ATTENDANCE SCHEME --</option>
                                        <?php foreach($arrAttSchemes as $scheme): ?>
                                            <option value="<?=$scheme['code']?>" <?=isset($arrshedule) ? $scheme['code']==$arrshedule['schemeCode'] ? 'selected' : '' : ''?>>
                                                <?=$scheme['label']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button class="btn green" type="submit" id="btn_broken_sched"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                        <a href="<?=base_url('hr/attendance_summary/dtr/broken_sched/').$arrData['empNumber']?>" class="btn blue">
                                            <i class="icon-ban"></i> Cancel</a>
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

<?php load_plugin('js',array('datatables','datepicker'));?>

<script>
    $(document).ready(function() {
        $('#table-broken_scheds').dataTable();
        $('.date-picker').datepicker();
        $('.date-picker').on('changeDate', function(){
            $(this).datepicker('hide');
        });

        /*Begin broken sched DATE*/
        $('#bs_sched_from,#bs_sched_to').on('keyup keypress change',function() {
            $('#bs_sched_to').closest('div.form-group').find('i.fa-calendar').remove();
            bsdate_from  = $('#bs_sched_from').val();
            bsdate_to = $('#bs_sched_to').val();
            if(bsdate_from != '' && bsdate_to != ''){
                $('#bs_sched_to').closest('div.form-group').removeClass('has-error');
                $('#bs_sched_to').closest('div.form-group').addClass('has-success');
                $('#bs_sched_to').closest('div.form-group').find('i.fa-warning').remove();
                $('#bs_sched_to').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#bs_sched_to'));
            }else{
                $('#bs_sched_to').closest('div.form-group').addClass('has-error');
                $('#bs_sched_to').closest('div.form-group').removeClass('has-success');
                $('#bs_sched_to').closest('div.form-group').find('i.fa-check').remove();
                $('#bs_sched_to').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#bs_sched_to'));
            }
        });
        /*End broken sched DATE*/

        $('#selscheme').on('keyup keypress change',function() {
            $('#selscheme').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#selscheme').val() != ''){
                $('#selscheme').closest('div.form-group').removeClass('has-error');
                $('#selscheme').closest('div.form-group').addClass('has-success');
                $('#selscheme').closest('div.form-group').find('i.fa-warning').remove();
                $('#selscheme').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#selscheme'));
            }else{
                $('#selscheme').closest('div.form-group').addClass('has-error');
                $('#selscheme').closest('div.form-group').removeClass('has-success');
                $('#selscheme').closest('div.form-group').find('i.fa-check').remove();
                $('#selscheme').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#selscheme'));
            }
        });

        $('#btn_broken_sched').click(function(e) {
            var arrerror= [];

            /*Begin broken sched DATE*/
            $('#bs_sched_to').closest('div.form-group').find('i.fa-calendar').remove();
            bsdate_from  = $('#bs_sched_from').val();
            bsdate_to = $('#bs_sched_to').val();
            if(bsdate_from != '' && bsdate_to != ''){
                $('#bs_sched_to').closest('div.form-group').removeClass('has-error');
                $('#bs_sched_to').closest('div.form-group').addClass('has-success');
                $('#bs_sched_to').closest('div.form-group').find('i.fa-warning').remove();
                $('#bs_sched_to').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#bs_sched_to'));
            }else{
                $('#bs_sched_to').closest('div.form-group').addClass('has-error');
                $('#bs_sched_to').closest('div.form-group').removeClass('has-success');
                $('#bs_sched_to').closest('div.form-group').find('i.fa-check').remove();
                $('#bs_sched_to').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#bs_sched_to'));
                arrerror.push(1);
            }
            /*End broken sched DATE*/

            /*Begin broken sched scheme*/
            $('#selscheme').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#selscheme').val() != ''){
                $('#selscheme').closest('div.form-group').removeClass('has-error');
                $('#selscheme').closest('div.form-group').addClass('has-success');
                $('#selscheme').closest('div.form-group').find('i.fa-warning').remove();
                $('#selscheme').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#selscheme'));
            }else{
                $('#selscheme').closest('div.form-group').addClass('has-error');
                $('#selscheme').closest('div.form-group').removeClass('has-success');
                $('#selscheme').closest('div.form-group').find('i.fa-check').remove();
                $('#selscheme').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips" data-original-title="Compensatory Time Off Date must not be empty."></i>').tooltip().insertBefore($('#selscheme'));
                arrerror.push(1);
            }
            /*End broken sched scheme*/

            if(jQuery.inArray(1,arrerror) !== -1){
                e.preventDefault();
            }

        });
        
    });
</script>