<?=load_plugin('css', array('select','select2','datepicker'))?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Reports</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Monthly Report</span>
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
<div class="row profile-account">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Update OR Remittances </span>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-body" style="display: none">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <div class="row">
                            <div class="col-md-7">
                                <?php if(count($arrmsg) > 0): ?>
                                    <div class="alert alert-danger">
                                        <strong>Error!</strong>
                                        <p>Employee<?=count($arrmsg) > 0 ? 's' : ''?> does not exists.</p><br>
                                        <?php foreach($arrmsg as $e): echo '<li>'.employee_name($e).'</li>'; endforeach;?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?=form_open('finance/payroll_update/update_or?month='.currmo().'&yr='.curryr().'&mode=add', array('method' => 'post', 'id' => 'frmto'))?>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Process Date <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <select class="bs-select form-control form-required" name="selproc_mon" id="selproc_mon">
                                                <?php foreach (range(1, 12) as $m): ?>
                                                    <option value="<?=sprintf('%02d', $m)?>"
                                                        <?php 
                                                            if(isset($_GET['month'])):
                                                                echo $_GET['month'] == $m ? 'selected' : '';
                                                            else:
                                                                if(count($arr_remitt) > 0):
                                                                    echo $m == $arr_remitt['deductMonth'] ? 'selected' : '';
                                                                else:
                                                                    echo $m == sprintf('%02d', date('n')) ? 'selected' : '';
                                                                endif;
                                                            endif;
                                                            ?> >
                                                        <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">&nbsp;</label>
                                        <div class="input-icon right">
                                            <select class="bs-select form-control form-required" name="selproc_yr" id="selproc_yr">
                                                <?php foreach (getYear() as $yr): ?>
                                                    <option value="<?=$yr?>"
                                                        <?php 
                                                            if(isset($_GET['yr'])):
                                                                echo $_GET['yr'] == $yr ? 'selected' : '';
                                                            else:
                                                                if(count($arr_remitt) > 0):
                                                                    echo $yr == $arr_remitt['deductYear'] ? 'selected' : '';
                                                                else:
                                                                    echo $yr == date('Y') ? 'selected' : '';
                                                                endif;
                                                            endif;
                                                            ?> >  
                                                    <?=$yr?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="control-label">Payroll Salary <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="bs-select form-control form-required" name="selproc_sal" id="selproc_sal">
                                            <option value=""> </option>
                                            <?php 
                                                foreach($arrpayroll as $payroll):
                                                    $selected = count($arr_remitt) > 0 ? $arr_remitt['processID'] == $payroll['processID'] ? 'selected' : '' : '';
                                                    $period = $payroll['employeeAppoint'] != 'P' ? ' - Period '.$payroll['period'] : '';
                                                    echo '<option value="'.$payroll['processID'].'" '.$selected.'>'.$payroll['processCode'].$period.' ('.$payroll['employeeAppoint'].')'.'</option>';
                                                endforeach;
                                             ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="control-label">Employee name <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple form-required" multiple name="selproc_emp[]" id="selproc_emp">
                                            <option value="">  </option>
                                            <?php 
                                                foreach($arremployees as $emp):
                                                    $selected = count($arr_remitt) > 0 ? $arr_remitt['empNumber'] == $emp['empNumber'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$emp['empNumber'].'" '.$selected.'>'.getfullname($emp['firstname'],$emp['surname'],$emp['middlename'],$emp['middleInitial'],$emp['nameExtension']).'</option>';
                                                endforeach;
                                             ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="control-label">Deduction List <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="select2 form-control form-required" name="selproc_deduction" id="selproc_deduction">
                                            <option value="">-- SELECT FUND SOURCE --</option>
                                            <?php 
                                                foreach($deduction_list as $deduction):
                                                    $selected = count($arr_remitt) > 0 ? $arr_remitt['deductionCode'] == $deduction['deductionCode'] ? 'selected' : '' : '';
                                                    echo '<option value="'.$deduction['deductionCode'].'" '.$selected.'>'.$deduction['deductionDesc'].'</option>';
                                                endforeach;
                                             ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="control-label">OR No. / TRA <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control" name="txtorno" id="txtorno"
                                                value="<?=count($arr_remitt) > 0 ? $arr_remitt['orNumber'] : ''?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="control-label">OR Date <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" 
                                                name="txtordate" id="txtordate" type="text"
                                                value="<?=count($arr_remitt) > 0 ? $arr_remitt['orDate'] : ''?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="btn green" type="submit" id="btn_add_remittance">
                                        <i class="fa fa-<?=$_GET['mode']=='add'?'plus':'check'?>"></i> <?=$_GET['mode']=='add'?'Add':'Edit'?> </button>
                                    <a href="<?=base_url('finance/payroll_update/view_or')?>" class="btn blue">
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

<?=load_plugin('js', array('select','select2','datepicker','form_validation'))?>
<script>
    $(document).ready(function() {
        $('.loading-image').hide();
        $('#div-body').show();

        $('.date-picker').datepicker();
        $('.date-picker').on('changeDate', function(){
            $(this).datepicker('hide');
        });

        $('#selproc_emp').select2({
            placeholder: "-- SELECT MULTIPLE EMPLOYEES --",
            allowClear: true
        });

        $('#selproc_mon,#selproc_yr').on('keyup keypress change', function() {
            var mon = $('#selproc_mon').val();
            var yr = $('#selproc_yr').val();
            var mode = "<?=$_GET['mode']?>";
            window.location = "<?=base_url('finance/payroll_update/update_or?month=')?>" + mon + "&yr=" + yr + "&mode=" + mode;
        });

        $('#selproc_sal').on('keyup keypress change', function() {
            check_null('#selproc_sal','Payroll Salary must not be empty.');
        });
        $('#selproc_emp').on("select2:select", function(e) { 
           $('#selproc_emp').closest('div.form-group').find('i.fa-calendar').remove();
           if($('#selproc_emp').val() != null){
               $('#selproc_emp').closest('div.form-group').removeClass('has-error');
               $('#selproc_emp').closest('div.form-group').addClass('has-success');
               $('#selproc_emp').closest('div.form-group').find('i.fa-warning').remove();
               $('#selproc_emp').closest('div.form-group').find('i.fa-check').remove();
               $('<i class="fa fa-check tooltips"></i>').insertBefore($('#selproc_emp'));
           }else{
               $('#selproc_emp').closest('div.form-group').addClass('has-error');
               $('#selproc_emp').closest('div.form-group').removeClass('has-success');
               $('#selproc_emp').closest('div.form-group').find('i.fa-check').remove();
               $('#selproc_emp').closest('div.form-group').find('i.fa-warning').remove();
               $('<i class="fa fa-warning tooltips font-red" data-original-title="Employee name must not be empty."></i>').tooltip().insertBefore($('#selproc_emp'));
           }
        });
        $('#selproc_deduction').on('keyup keypress change', function() {
            check_null('#selproc_deduction','Deduction List must not be empty.');
        });
        $('#txtorno').on('keyup keypress change', function() {
            check_null('#txtorno','OR No. / TRA must not be empty.');
        });
        $('#txtordate').on('keyup keypress change', function() {
            check_null('#txtordate','OR Date must not be empty.');
        });

        $('#btn_add_remittance').on('click', function(e) {
            var total_error = 0;

            $('#selproc_emp').closest('div.form-group').find('i.fa-calendar').remove();
            if($('#selproc_emp').val() != null){
                $('#selproc_emp').closest('div.form-group').removeClass('has-error');
                $('#selproc_emp').closest('div.form-group').addClass('has-success');
                $('#selproc_emp').closest('div.form-group').find('i.fa-warning').remove();
                $('#selproc_emp').closest('div.form-group').find('i.fa-check').remove();
                $('<i class="fa fa-check tooltips"></i>').insertBefore($('#selproc_emp'));
            }else{
                $('#selproc_emp').closest('div.form-group').addClass('has-error');
                $('#selproc_emp').closest('div.form-group').removeClass('has-success');
                $('#selproc_emp').closest('div.form-group').find('i.fa-check').remove();
                $('#selproc_emp').closest('div.form-group').find('i.fa-warning').remove();
                $('<i class="fa fa-warning tooltips font-red" data-original-title="Employee name must not be empty."></i>').tooltip().insertBefore($('#selproc_emp'));
                total_error = total_error + 1;
            }
            total_error = total_error + check_null('#selproc_sal','Payroll Salary must not be empty.');
            total_error = total_error + check_null('#selproc_deduction','Deduction List must not be empty.');
            total_error = total_error + check_null('#txtorno','OR No. / TRA must not be empty.');
            total_error = total_error + check_null('#txtordate','OR Date must not be empty.');
            
            if(total_error > 0){
                e.preventDefault();
            }
        });

    });
</script>