<?=load_plugin('css',array('select','select2'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Libraries</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?=ucfirst($action)?> Payroll Process</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
       &nbsp;
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> <?=$action?> Payroll Process</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div class="portlet-body" id="div-body" style="display: none">
                        <div class="table-toolbar">
                            <?=form_open($action == 'edit' ? 'finance/libraries/payrollprocess/edit/'.$this->uri->segment(5) : '', array('method' => 'post'))?>
                                <input type="hidden" id='txtcode' value="<?=$this->uri->segment(4)?>" />
                                <div class="form-group <?=isset($err) ? 'has-error' : ''?>">
                                    <label class="control-label">Appointment Name <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips <?=isset($err) ? '' : 'hidden'?>" <?=isset($err) ? 'data-original-title="'.$err.'"' : ''?>></i>
                                        <select class="form-control select2 form-required" name="selappointment" id="selappointment" <?=$action=='edit' || $action=='delete' ? 'disabled' : ''?>>
                                            <option value="">-- SELECT APPOINTMENT --</option>
                                            <?php foreach($arrAppointments as $appointment): ?>
                                                <option value="<?=$appointment['appointmentCode']?>" <?=isset($arrData) ? $appointment['appointmentCode'] == $arrData['appointmentCode'] ? 'selected' : '' : $appointment['appointmentCode'] == set_value('selappointment') ? 'selected' : ''?>>
                                                    <?=$appointment['appointmentDesc']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Process With <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple form-required" multiple placeholder="" id="selprocesswith" name="selprocesswith[]" <?=$action=='delete' ? 'disabled' : ''?>>
                                            <?php 
                                                if(isset($arrData)):
                                                    foreach(explode(',', $arrData['processWith']) as $procwith):
                                                        foreach($arrAppointments as $appointment): ?>
                                                            <option value="<?=$appointment['appointmentCode']?>" <?=isset($arrData) ? $appointment['appointmentCode'] == $procwith ? 'selected' : '' : in_array($appointment['appointmentCode'], set_value('selprocesswith')) ? 'selected' : ''?>>
                                                                <?=$appointment['appointmentDesc']?></option>
                                            <?php       endforeach;
                                                    endforeach;
                                                else:
                                                    foreach($arrAppointments as $appointment): ?>
                                                        <option value="<?=$appointment['appointmentCode']?>" ><?=$appointment['appointmentDesc']?></option>
                                            <?php   endforeach;
                                                endif;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Salary <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="form-control bs-select form-required" id="selsalary" name="selsalary" <?=$action=='delete' ? 'disabled' : ''?>>
                                            <option value="">-- SELECT SALARY --</option>
                                            <?php foreach(salaryPeriod() as $period): ?>
                                                <option value="<?=$period?>" <?=isset($arrData) ? $period == $arrData['computation'] ? 'selected' : '' : $period == set_value('selsalary') ? 'selected' : ''?>>
                                                    <?=$period?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php if($action=='delete'): $code = isset($arrData) ? $arrData['appointmentCode'] : '';?>
                                                    <a href="<?=base_url('finance/libraries/payrollprocess/delete/'.$this->uri->segment(5)).'?code='.$code?>" class="btn red"><i class="icon-trash"></i> Delete</a>
                                            <?php else: ?>
                                                    <button class="btn green" type="submit" id="btn_add_process"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                            <?php endif; ?>
                                            <a href="<?=base_url('finance/libraries/payrollprocess')?>" class="btn blue">
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
</div>
<?=load_plugin('js',array('select','select2','form_validation'));?>

<script>
    $('select.select2').select2({
        minimumResultsForSearch: -1,
        placeholder: function(){
            $(this).data('placeholder');
        }
    });
    $(document).ready(function() {
        $('.loading-image').hide();
        $('#div-body').show();
        $('#selprocesswith').select2({
            placeholder: "-- SELECT MULTIPLE PROCESS WITH --",
            allowClear: true
        });

        $('#selappointment').on('keyup keypress change', function() {
            check_null('#selappointment','Appointment Name must not be empty.');
        });
        $('#selprocesswith').on("select2:select", function(e) { 
           $('#selprocesswith').closest('div.form-group').find('i.fa-calendar').remove();
           if($('#selprocesswith').val() != null){
               $('#selprocesswith').closest('div.form-group').removeClass('has-error');
               $('#selprocesswith').closest('div.form-group').addClass('has-success');
               $('#selprocesswith').closest('div.form-group').find('i.fa-warning').remove();
               $('#selprocesswith').closest('div.form-group').find('i.fa-check').remove();
               $('<i class="fa fa-check tooltips"></i>').insertBefore($('#selprocesswith'));
           }else{
               $('#selprocesswith').closest('div.form-group').addClass('has-error');
               $('#selprocesswith').closest('div.form-group').removeClass('has-success');
               $('#selprocesswith').closest('div.form-group').find('i.fa-check').remove();
               $('#selprocesswith').closest('div.form-group').find('i.fa-warning').remove();
               $('<i class="fa fa-warning tooltips font-red" data-original-title="Process With must not be empty."></i>').tooltip().insertBefore($('#selprocesswith'));
           }
        });
        $('#selsalary').on('keyup keypress change', function() {
            check_null('#selsalary','Salary must not be empty.');
        });

        $('#btn_add_process').on('click', function(e) {
            var total_error = 0;
            total_error = total_error + check_null('#selappointment','Appointment Name must not be empty.');
            total_error = total_error + check_null('#selsalary','Salary must not be empty.');

            $('#selprocesswith').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#selprocesswith').val() != null){
                $('#selprocesswith').closest('div.form-group').removeClass('has-error');
                $('#selprocesswith').closest('div.form-group').addClass('has-success');
                $('#selprocesswith').closest('div.form-group').find('i.fa-warning').remove();
                $('#selprocesswith').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#selprocesswith'));
            }else{
                $('#selprocesswith').closest('div.form-group').addClass('has-error');
                $('#selprocesswith').closest('div.form-group').removeClass('has-success');
                $('#selprocesswith').closest('div.form-group').find('i.fa-check').remove();
                $('#selprocesswith').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips font-red" data-original-title="Process With must not be empty."></i>').tooltip().insertBefore($('#selprocesswith'));
                total_error = total_error + 1;
            }

            if(total_error > 0){
                e.preventDefault();
            }
        });
    });
</script>