<?=load_plugin('css', array('datatables','select2','select'))?>
<div class="tab-pane active" id="tab_1_4">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <br>
            <center>
                <?=form_open('', array('class' => 'form-inline', 'method' => 'get'))?>
                    <div class="form-group" style="display: inline-flex;">
                        <label class="bold" style="padding: 6px;"> Adjustment:</label>
                        <label style="padding: 6px;"> Month</label>
                        <select class="bs-select form-control" name="month">
                            <option value="all">All</option>
                            <?php foreach (range(1, 12) as $m): ?>
                                <option value="<?=sprintf('%02d', $m)?>"
                                    <?php 
                                        if(isset($_GET['month'])):
                                            echo $_GET['month'] == $m ? 'selected' : '';
                                        else:
                                            echo $m == 'all' ? 'selected' : '';
                                        endif;
                                        ?> >
                                    <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="display: inline-flex;margin-left: 10px;">
                        <label style="padding: 6px;"> Year</label>
                        <select class="bs-select form-control" name="yr">
                            <option value="all">All</option>
                            <?php foreach (getYear() as $yr): ?>
                                <option value="<?=$yr?>"
                                    <?php 
                                        if(isset($_GET['yr'])):
                                            echo $_GET['yr'] == $yr ? 'selected' : '';
                                        else:
                                            echo $yr == 'all' ? 'selected' : '';
                                        endif;
                                        ?> >  
                                <?=$yr?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="display: inline-flex;margin-left: 10px;">
                        <label style="padding: 6px;"> Period </label>
                        <select class="bs-select form-control" name="period">
                            <option value="all">All</option>
                            <?php $ctr = 0; foreach(setPeriods($empPayrollProcess) as $period): $ctr++?>
                                    <option value="<?=$ctr?>"
                                    <?php 
                                        if(isset($_GET['period'])):
                                            echo $_GET['period'] == $ctr ? 'selected' : '';
                                        else:
                                            echo $ctr == 'all' ? 'selected' : '';
                                        endif;
                                        ?> >  
                                    <?=$period?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    &nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary" style="margin-top: -3px;">Search</button>
                <?=form_close()?>
            </center>
            <br><br>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <span class="caption-subject bold uppercase"> Income</span>
                                </div>
                                <button class="btn btn-sm blue pull-right" id="btnaddIncome_adj"><i class="fa fa-plus"></i> Add</button>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="tabbable-line tabbable-full-width col-md-12">
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-adj-income" >
                                            <thead>
                                                <tr>
                                                   <th style="text-align: center;vertical-align: middle;"> No </th>
                                                    <th style="text-align: left;vertical-align: middle;"> Income </th>
                                                    <th style="text-align: center;vertical-align: middle;"> Amount </th>
                                                    <th style="text-align: center;vertical-align: middle;"> Type </th>
                                                    <th style="text-align: center;"> Adjustment Date <br>(Month / Year) </th>
                                                    <th style="text-align: center;"> Income Date <br>(Month / Year) </th>
                                                    <th style="text-align: center;vertical-align: middle;"> Period </th>
                                                    <th style="text-align: center;vertical-align: middle;"> Actions </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($arrDataIncome as $adjincome): ?>
                                                <tr class="odd gradeX">
                                                    <td align="center"><?=$no++?></td>
                                                    <td><?=$adjincome['incomeDesc']?></td>
                                                    <td align="center"><?=$adjincome['incomeAmount']?></td>
                                                    <td align="center"><?=adjustmentType($adjincome['type'])?></td>
                                                    <td align="center"><?=date('M', mktime(0, 0, 0, $adjincome['adjustMonth'], 10))?> <?=$adjincome['adjustYear']?></td>
                                                    <td align="center"><?=date('M', mktime(0, 0, 0, $adjincome['incomeMonth'], 10))?> <?=$adjincome['incomeYear']?></td>
                                                    <td align="center"><?=$adjincome['adjustPeriod']?></td>
                                                    <td align="center" style="width: 170px;" nowrap>
                                                        <button class="btn btn-xs green" data-toggle="modal" href="#incomeAdjustments" id="btneditIncome_adj" data-json='<?=json_encode($adjincome)?>'>
                                                            <i class="fa fa-edit"></i> Edit</button>
                                                        <button class="btn btn-xs red" data-toggle="modal" href="#delete_adjustment" id="btndeleteIncome_adj" data-id='<?=$adjincome['code']?>'>
                                                            <i class="fa fa-trash"></i> Delete</button>
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

                    <div class="col-md-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <span class="caption-subject bold uppercase"> Deduction </span>
                                </div>
                                <button class="btn btn-sm blue pull-right" id="btnaddDeduct_adj"> <i class="fa fa-plus"></i> Add</button>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="tabbable-line tabbable-full-width col-md-12">
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-adj-deductions" >
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;vertical-align: middle;"> No </th>
                                                    <th style="text-align: left;vertical-align: middle;"> Deduction </th>
                                                    <th style="text-align: center;vertical-align: middle;"> Amount </th>
                                                    <th style="text-align: center;vertical-align: middle;"> Type </th>
                                                    <th style="text-align: center;"> Adjustment Date <br>(Month / Year) </th>
                                                    <th style="text-align: center;"> Deduction Date <br>(Month / Year) </th>
                                                    <th style="text-align: center;vertical-align: middle;"> Period </th>
                                                    <th style="text-align: center;vertical-align: middle;"> Actions </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($arrDataDeduct as $adjdeduct): ?>
                                                <tr class="odd gradeX">
                                                    <td align="center"><?=$no++?></td>
                                                    <td> <?=$adjdeduct['deductionDesc']?></td>
                                                    <td align="center"><?=$adjdeduct['deductAmount']?></td>
                                                    <td align="center"><?=adjustmentType($adjdeduct['type'])?></td>
                                                    <td align="center"><?=date('M', mktime(0, 0, 0, $adjdeduct['adjustMonth'], 10))?> <?=$adjdeduct['adjustYear']?></td>
                                                    <td align="center"><?=date('M', mktime(0, 0, 0, $adjdeduct['deductMonth'], 10))?> <?=$adjdeduct['deductYear']?></td>
                                                    <td align="center"><?=$adjdeduct['adjustPeriod']?></td>
                                                    <td align="center" style="width: 170px;" nowrap>
                                                        <button class="btn btn-xs green" data-toggle="modal" href="#deductAdjustments" id="btneditdeduct_adj" data-json='<?=json_encode($adjdeduct)?>'>
                                                            <i class="fa fa-edit"></i> Edit</button>
                                                        <button class="btn btn-xs red" data-toggle="modal" href="#delete_adjustment" id="btndeletededuct_adj" data-id='<?=$adjdeduct['code']?>'>
                                                            <i class="fa fa-trash"></i> Delete</button>
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
            </div>
        </div>
    </div>
</div>
<?php include('modals/_modal_adjustments.php'); ?>
<?=load_plugin('js', array('datatables','form_validation','select2','select'))?>