<?php
echo load_plugin('css', array('datatables'));
switch ($this->uri->segment(3)) {
    case 'compute_benefits_nonperm_trc':
        $form='finance/payroll_update/select_deduction_nonperm_trc'; break;
    default:
        $form='finance/payroll_update/select_deductions_nonperm'; break;
}
echo form_open($form, array('class' => 'form-horizontal', 'method' => 'post'))?>
<div class="tab-content">
    <div class="loading-fade" style="display: none;width: 80%;height: 100%;top: 150px;">
        <center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center>
    </div>
    <div class="tab-pane active">
        <div class="block">
            <h3 style="display: inline-block;">Compute Benefits</h3>
            <a href="javascript:;" class="btn green btn-refresh pull-right" style="top: 20px;position: relative;">
                <i class="fa fa-refresh"></i> Recompute </a>
        </div>
        <div class="block" style="margin-bottom: 10px;">
            <small style="margin-left: 10px;">
                Payroll Date: <?=$payroll_date?> (<?=ordinal($period)?> Half) || For <?=$employment_type?> Employees || Total Calendar days: <?=$employment_type == 'JO' ? $process_data_datediff : $curr_period_workingdays?>
            </small>
        </div>
        <div class="row">
            <div class="col-md-12 scroll">
                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                <table class="table table-striped table-bordered order-column" id="tblemployees" style="visibility: hidden;">
                    <thead>
                        <tr>
                            <th style="text-align: center;vertical-align: middle;"> Employee Name </th>
                            <th style="text-align: center;vertical-align: middle;"> Employee number </th>
                            <th style="text-align: center;vertical-align: middle;"> Basic Salary </th>
                            <th style="text-align: center;vertical-align: middle;"> Days Present </th>
                            <th style="text-align: center;vertical-align: middle;"> Days Absent </th>
                            <th style="text-align: center;vertical-align: middle;"> Total <br>Late and Undertime </th>
                            <th style="text-align: center;vertical-align: middle;"> Deduction Amount </th>
                            <th style="text-align: center;vertical-align: middle;"> Period Salary </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($arrEmployees as $emp): ?>
                            <tr>
                                <td><?=getfullname($emp['emp_detail']['firstname'],$emp['emp_detail']['surname'],$emp['emp_detail']['middlename'],$emp['emp_detail']['middleInitial'])?></td>
                                <td style="text-align: center"><?=$emp['emp_detail']['empNumber']?></td>
                                <td style="text-align: center"><?=number_format($emp['emp_detail']['actualSalary'], 2)?></td>
                                <td style="text-align: center"><?=$emp['actual_days_present']?></td>
                                <td style="text-align: center"><?=$emp['actual_days_absent']?></td>
                                <td style="text-align: center"><?=date('H:i', mktime(0, $emp['total_late'] + $emp['total_ut']))?></td>
                                <td style="text-align: center"><?=number_format($emp['total_deduct'], 2)?></td>
                                <td style="text-align: center"><?=number_format($emp['period_salary'], 2)?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
        <br><br>

    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <textarea name="txtjson_computations" hidden><?=isset($arrEmployees) ? fixJson($arrEmployees) : ''?></textarea>
            <input type="hidden" name="txtprocess" value='<?=isset($_POST['txtprocess']) ? fixJson($_POST['txtprocess']) : ''?>'>
            <input type="hidden" name="chkbenefit" value='<?=isset($_POST['chkbenefit']) ? fixJson($_POST['chkbenefit']) : ''?>'>
            <input type="hidden" name="chksalary" value='<?=isset($_POST['chksalary']) ? fixJson($_POST['chksalary']) : ''?>'>
            <input type="hidden" name="chkbonus" value='<?=isset($_POST['chkbonus']) ? fixJson($_POST['chkbonus']) : ''?>'>
            <input type="hidden" name="working_days" value='<?=isset($curr_period_workingdays) ? $curr_period_workingdays : ''?>'>
            <input type="hidden" name="date_diff" value='<?=isset($process_data_datediff) ? $process_data_datediff : ''?>'>
            <a href="javascript:;" class="btn default btn-previous"> <i class="fa fa-angle-left"></i> Back </a>
            <button class="btn blue btn-submit"> Save and Continue <i class="fa fa-angle-right"></i></button>
        </div>
    </div>
</div>
<?=form_close()?>
<?=load_plugin('js', array('datatables'))?>
<script src="<?=base_url('assets/js/custom/payroll-compute_benefits.js')?>"></script>
<script>
    $(document).ready(function() {
        $('#tblemployees').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tblemployees').css('visibility', 'visible');
            }} );
        $('a.btn-refresh').on('click', function() {
            $('.loading-fade').show();
            location.reload();
        });
    });
</script>