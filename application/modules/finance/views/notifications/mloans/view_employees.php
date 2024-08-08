<?php load_plugin('css',array('datatables','select2','select','datepicker'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Notifications</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Maturing Loans</span>
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
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> Employees with Maturing Loan(s) for the month of <?=date('F')?></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-mloans" style="display: none">
                            <thead>
                                <tr>
                                    <tr>
                                        <th style="text-align: center; width: 50px;"> No. </th>
                                        <th> Employee Number </th>
                                        <th> Name </th>
                                        <th style="text-align: center;"> Loan </th>
                                        <th style="text-align: center;"> Amount </th>
                                        <th style="text-align: center;"> Monthly Deduction </th>
                                        <th style="text-align: center;"> Total Remittance </th>
                                        <th style="text-align: center;"> Balance </th>
                                        <th style="text-align: center;"> Due Date </th>
                                        <th style="text-align: center;"> Actions </th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrEmployees as $employee): $balance = ($employee['amountGranted'] - $employee['total_remit']);?>
                                    <tr>
                                        <td> <?=$no++?> </td>
                                        <td> <?=$employee['empNumber']?> </td>
                                        <td> <?=employee_name($employee['empNumber'])?> </td>
                                        <td> <?=$employee['deductionDesc']?> </td>
                                        <td> <?=number_format($employee['amountGranted'],2)?> </td>
                                        <td> <?=number_format($employee['monthly'],2)?> </td>
                                        <td> <?=number_format($employee['total_remit'],2)?> </td>
                                        <td> <?=$balance >= 0 ? number_format($balance,2) : '('.number_format($balance,2).')'?> </td>
                                        <td> <?=date("F", mktime(0, 0, 0, $employee['actualEndMonth'], 10)).' '.$employee['actualEndYear']?> </td>
                                        <td style="text-align: center;" nowrap>
                                            <a href="<?=base_url('finance/compensation/personnel_profile/employee').'/'.$employee['empNumber']?>" class="btn btn-sm blue">
                                                <i class="fa fa-eye"></i>  View</a>
                                            <a data-toggle="modal" href="#editmaturingLoan" id="btnupdatemloans" class="btn btn-sm green"
                                                data-params=<?="'".json_encode($employee)."'"?>>
                                                <i class="fa fa-edit"></i>  Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editmaturingLoan" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="bold modal-title">Deduction update</h4>
                <label class="control-label" id="loan-title"></label>
            </div>
            <?=form_open('finance/notifications/notifications/updatematuringLoans', array('id' => 'frmmloans', 'method' => 'post'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtid" id="txtid">
                            <h4>Loan Details</h4>
                            <div class="form-group">
                                <label class="control-label">Date Granted<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input class="form-control date-picker form-required" data-date="2012-03-01" data-date-format="yyyy-mm-dd"
                                        id="txtdateGranted" name="txtdateGranted" type="text" >
                                </div>
                            </div>
                            <label class="control-label col-md-12 div-sdate" style="padding: 0 !important;">Start Date<span class="required"> * </span></label>
                            <div class="form-group col-md-6" style="padding: 0 !important;">
                                <div class="input-icon right" style="padding: 0 !important;">
                                    <select class="form-control form-required bs-select" name="selsdate_mon" id="selsdate_mon" placeholder="">
                                        <option value="">SELECT MONTH</option>
                                        <?php foreach (range(1, 12) as $m): ?>
                                            <option value="<?=$m?>"><?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6" style="padding: 0 !important;">
                                <div class="input-icon right" style="padding: 0 !important;">
                                    <select class="form-control form-required bs-select" name="selsdate_yr" id="selsdate_yr" placeholder="">
                                        <option value="">SELECT YEAR</option>
                                        <?php foreach (getYear() as $yr): ?>
                                            <option value="<?=$yr?>"><?=$yr?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <label class="control-label col-md-12 div-edate" style="padding: 0 !important;">End Date<span class="required"> * </span></label>
                            <div class="form-group col-md-6" style="padding: 0 !important;">
                                <div class="input-icon right" style="padding: 0 !important;">
                                    <select class="form-control form-required bs-select" name="seledate_mon" id="seledate_mon" placeholder="">
                                        <option value="">SELECT MONTH</option>
                                        <?php foreach (range(1, 12) as $m): ?>
                                            <option value="<?=$m?>"><?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6" style="padding: 0 !important;">
                                <div class="input-icon right" style="padding: 0 !important;">
                                    <select class="form-control form-required bs-select" name="seledate_yr" id="seledate_yr" placeholder="">
                                        <option value="">SELECT YEAR</option>
                                        <?php foreach (getYear() as $yr): ?>
                                            <option value="<?=$yr?>"><?=$yr?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Amount Granted<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtamtGranted" id="txtamtGranted">
                                </div>
                            </div>

                            <hr/>
                            <div class="form-group">
                                <label class="control-label">Monthly<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtmonthly" id="txtmonthly">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Period 1<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtperiod1" id="txtperiod1">
                                </div>
                            </div>
                            <div class="form-group" <?=in_array(salary_schedule(),array('semimonthly'))?'':'hidden' ?>>
                                <label class="control-label">Period 2<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtperiod2" id="txtperiod2">
                                </div>
                            </div>
                            <div class="form-group" <?=in_array(salary_schedule(),array('weekly'))?'':'hidden' ?>>
                                <label class="control-label">Period 3<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtperiod3" id="txtperiod3" value=0>
                                </div>
                            </div>
                            <div class="form-group" <?=in_array(salary_schedule(),array('weekly'))?'':'hidden' ?>>
                                <label class="control-label">Period 4<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-required" name="txtperiod4" id="txtperiod4" value=0>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Status<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <select class="form-control bs-select form-required" name="selstatus" id="selstatus">
                                        <option value="">SELECT STATUS</option>
                                        <?php foreach(array('1' => 'On-going','2' => 'Paused','0' => 'Finished') as $id=>$desc): ?>
                                            <option value="<?=$id?>">
                                                <?=$desc?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-matureloans" class="btn btn-sm green"><i class="icon-check"> </i> Save</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<?php load_plugin('js', array('datatables','select2','select','datepicker','form_validation')) ?>
<script src="<?=base_url('assets/js/custom/finance-maturing_loan.js')?>"></script>
