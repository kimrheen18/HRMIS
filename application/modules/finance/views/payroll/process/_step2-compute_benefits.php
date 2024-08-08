<?=load_plugin('css', array('datatables'))?>
<?php
$page = $this->uri->segment(3);
$form = $page == 'compute_benefits_perm' ? 'finance/payroll_update/save_benefits_perm' : 'finance/payroll_update/process/save_benefits';
echo form_open($form, array('class' => 'form-horizontal', 'method' => 'post','id'=>'frmsavebenefits'));?>
<input type="hidden" name="txtprocess" value='<?=$_POST['txtprocess']?>'>
<input type="hidden" name="chkbenefit" value='<?=$page == 'compute_benefits_perm' ? $_POST['chkbenefit'] : json_encode($_POST['chkbenefit'])?>'>
<div class="tab-content">
    <div class="loading-fade" style="display: none;width: 80%;height: 100%;top: 150px;">
        <center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center>
    </div>
    <div class="tab-pane active">
        <div class="block">
            <h3 style="display: inline-block;">Compute Benefits</h3>
            <?php if($page == 'save_benefits'): ?>
                <button type="submit" class="btn green btn-refresh pull-right" style="top: 20px;position: relative;">
                    <i class="fa fa-refresh"></i> Recompute </button>
            <?php else: ?>
                <a href="javascript:;" class="btn green btn-refresh pull-right" style="top: 20px;position: relative;">
                    <i class="fa fa-refresh"></i> Recompute </a>
            <?php endif; ?>
        </div>
        <div class="block" style="margin-bottom: 10px;">
            <small style="margin-left: 10px;">
                Payroll Date: <b><?=$payroll_date?></b> || Total Working days: <?=$curr_period_workingdays?> for Subsistence Allowance and RATA For Permanent Employees.
                Use data from <b><?=$process_data_date?></b> || working days <?=$process_data_workingdays?>
            </small>
        </div>
        <div class="row">
            <div class="col-md-12 scroll">
                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                <!-- Pls be careful in using colspan and colrow, table details will be use in saving payroll process in json form -->
                <table class="table table-striped table-bordered order-column" id="tblemployee-list" style="visibility: hidden;">
                    <thead>
                        <tr>
                            <th> Employee Name </th>
                            <th style="text-align: center"> Salary </th>
                            <th style="text-align: center"> Working Days </th>
                            <th style="text-align: center"> Actual Days Present </th>
                            <th style="text-align: center"> Absences </th>
                            <th style="text-align: center"> HP % </th>
                            <th style="text-align: center"> HP </th>
                            <th style="text-align: center"> 8 hrs </th>
                            <th style="text-align: center"> 6 hrs </th>
                            <th style="text-align: center"> 5 hrs </th>
                            <th style="text-align: center"> 4 hrs </th>
                            <th style="text-align: center"> Total per diem </th>
                            <th style="text-align: center"> Subsistence </th>
                            <th style="text-align: center"> Days w/o Laundry</th>
                            <th style="text-align: center"> Laundry </th>
                            <th style="text-align: center"> LP </th>
                            <th style="text-align: center"> RA % </th>
                            <th style="text-align: center"> RA </th>
                            <th style="text-align: center"> days w/ vehicle</th>
                            <th style="text-align: center"> TA % </th>
                            <th style="text-align: center"> TA </th>
                            <th style="text-align: center"> Total </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $arremp_less5k = array();
                            $less5k_amt = 0;
                            foreach(fixArray($arrEmployees) as $emp):
                                if($emp['total_income'] < 5000){
                                    $less5k_amt++;
                                    array_push($arremp_less5k,$emp['emp_detail']['empNumber']);
                                }  ?>
                                <tr class="<?=$emp['total_income'] < 5000 ? 'danger' : ''?>">
                                    <td><?=getfullname($emp['emp_detail']['firstname'],$emp['emp_detail']['surname'],$emp['emp_detail']['middlename'],$emp['emp_detail']['middleInitial'])?></td>
                                    <td style="text-align: center"><?=number_format($emp['emp_detail']['actualSalary'], 2)?></td>
                                    <td style="text-align: center"><?=$curr_period_workingdays?></td>
                                    <td style="text-align: center"><?=$emp['actual_days_present']?></td>
                                    <td style="text-align: center"><?=$emp['actual_days_absent']?></td>
                                    <td style="text-align: center"><?=$emp['emp_detail']['hpFactor']?> %</td>
                                    <td style="text-align: center"><?=number_format($emp['hp'], 2)?></td>
                                    <?php if(count($emp['emp_leavebal']) > 0): ?>
                                        <td style="text-align: center"><?=$emp['emp_leavebal']['ctr_8h']?></td>
                                        <td style="text-align: center"><?=$emp['emp_leavebal']['ctr_6h']?></td>
                                        <td style="text-align: center"><?=$emp['emp_leavebal']['ctr_5h']?></td>
                                        <td style="text-align: center"><?=$emp['emp_leavebal']['ctr_4h']?></td>
                                        <td style="text-align: center"><?=$emp['emp_leavebal']['ctr_diem']?></td>
                                    <?php else:?>
                                        <td style="text-align: center" colspan="5">No Leave Balance</td>
                                        <td hidden></td>
                                        <td hidden></td>
                                        <td hidden></td>
                                        <td hidden></td>
                                    <?php endif; ?>
                                    <td style="text-align: center"><?=number_format($emp['subsis'], 2)?></td>
                                    <td style="text-align: center"><?=$emp['actual_days_absent']?></td>
                                    <td style="text-align: center"><?=number_format($emp['laundry'], 2)?></td>
                                    <td style="text-align: center"><?=number_format($emp['longevity'], 2)?></td>
                                    <td style="text-align: center"><?=$emp['rata']['ra_percent']?> %</td>
                                    <td style="text-align: center"><?=number_format($emp['rata']['ra_amount'], 2)?></td>
                                    <td style="text-align: center"><?=$emp['rata']['days_w_vehicle']?></td>
                                    <td style="text-align: center"><?=$emp['rata']['ta_percent']?> %</td>
                                    <td style="text-align: center"><?=number_format($emp['rata']['ta_amount'], 2)?></td>
                                    <td style="text-align: center"><?=number_format($emp['total_income'], 2)?></td>
                                </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php 
                    if($no_empty_lb > 0):
                        echo 'Employee with no leave balance = '.$no_empty_lb;
                    endif;
                 ?>

                <div class="alert alert-danger" <?=$less5k_amt > 0 ? '' : 'hidden'?>>
                    <strong>Warning!</strong><br>
                    <?php 
                        if($less5k_amt > 0):
                            echo 'Employees with Less Than P5000 Total Benefits:<br><br>';
                            echo '<small>'.implode(', ',$arremp_less5k).'</small>';
                        endif;
                     ?>
                </div>
            </div>
        </div>
        <br><br>
        <textarea id="txtjson" name="txtjson" hidden><?=fixJson($arrEmployees)?></textarea>
        <input type="hidden" value="<?=$process_data_workingdays?>" name="txtdata_wdays">
        <input type="hidden" value="<?=$curr_period_workingdays?>" name="txtper_wdays">
        <input type="hidden" value="<?=$no_empty_lb?>" name="txtno_empty_lb">
    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <a href="javascript:;" class="btn default btn-previous">
                <i class="fa fa-angle-left"></i> Back </a>
            <?php if($this->uri->segment(3) == 'save_benefits_perm'): ?>
                <button type="submit" id="btnprocess" class="btn blue btn-submit"> Proceed and Continue
                <i class="fa fa-angle-right"></i> </button>
            <?php else: ?>
                <button type="submit" id="btnsavecont" class="btn blue btn-submit"> Save
                <i class="fa fa-angle-right"></i> </button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?=form_close()?>
<?=load_plugin('js', array('datatables'))?>
<script src="<?=base_url('assets/js/custom/payroll-compute_benefits.js')?>"></script>