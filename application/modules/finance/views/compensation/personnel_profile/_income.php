<?=load_plugin('css', array('profile-2','datatables'))?>
<div class="tab-pane active" id="tab_1_2">
    <div class="col-md-6">
        <div class="portlet light bordered" style="height: 514px;">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Benefit List</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-benefitList" data-title="Benefit">
                            <thead>
                                <tr>
                                    <th> Benefit </th>
                                    <th> Monthly </th>
                                    <?php 
                                        foreach(setPeriods($empPayrollProcess) as $period):
                                            echo '<th> '.$period.' </th>';
                                        endforeach; ?>
                                    <th> Status </th>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <th style="text-align: center;"> Action </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($benefitList as $benefit): $isremove = isset($benefit['arrbenefits']) ? $benefit['arrbenefits']['status'] == 0 ? True : False : '';?>
                                <tr class="odd gradeX <?=$isremove ? 'danger' : ''?>">
                                    <td style="text-align: left; padding-left: 7px;"><b><?=$benefit['incomeDesc']?></b></td>
                                    <td><?=isset($benefit['arrbenefits']) ? 
                                            number_format($benefit['arrbenefits']['incomeAmount'], 2) : '0.00'?></td>
                                    <?php 
                                        if(isset($benefit['arrbenefits'])):
                                            foreach(range(1, count(setPeriods($empPayrollProcess))) as $p):
                                                echo '<td>'.number_format($benefit['arrbenefits']['period'.$p], 2).'</td>';
                                            endforeach;
                                        else:
                                            foreach(range(1, count(setPeriods($empPayrollProcess))) as $p):
                                                echo '<td>0.00</td>';
                                            endforeach;
                                        endif;
                                        ?>
                                    <td><?=isset($benefit['arrbenefits']) ? 
                                            getincome_status($benefit['arrbenefits']['status']) : ''?></td>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <td align="center">
                                            <button class="btn btn-xs green" data-toggle="modal" href="#benefitList" id="btn-modal-benefitList"
                                                    data-period1="<?=isset($benefit['arrbenefits']) ? $benefit['arrbenefits']['period1'] == '' ? '0.00' : $benefit['arrbenefits']['period1'] : '0.00'?>"
                                                    data-period2="<?=isset($benefit['arrbenefits']) ? $benefit['arrbenefits']['period2'] == '' ? '0.00' : $benefit['arrbenefits']['period2'] : '0.00'?>"
                                                    data-period3="<?=isset($benefit['arrbenefits']) ? $benefit['arrbenefits']['period3'] == '' ? '0.00' : $benefit['arrbenefits']['period3'] : '0.00'?>"
                                                    data-period4="<?=isset($benefit['arrbenefits']) ? $benefit['arrbenefits']['period4'] == '' ? '0.00' : $benefit['arrbenefits']['period4'] : '0.00'?>"

                                                    data-incomecode="<?=$benefit['incomeCode']?>" data-stat="benefit"
                                                    data-benefitcode="<?=isset($benefit['arrbenefits']) ? $benefit['arrbenefits']['benefitCode'] : ''?>"
                                                    data-tax="<?=isset($benefit['arrbenefits']) ? $benefit['arrbenefits']['ITW'] : '0.00'?>"
                                                    data-statusval="<?=isset($benefit['arrbenefits']) ? $benefit['arrbenefits']['status'] : "null"?>">

                                                <i class="fa fa-edit"></i> Edit</button>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Longevity Pay</span>
                </div>
                <?php if(check_module() == 'finance'): ?>
                    <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" href="#longevityModal" id="btn-add-longevity" data-title="Longevity Pay">
                        <i class="fa fa-plus"></i> Add New</button>
                <?php endif; ?>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-longevityPay" >
                            <thead>
                                <tr>
                                    <th style="width: 120px;"> Longevity Date </th>
                                    <th> Salary </th>
                                    <th> Percent </th>
                                    <th> LP </th>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <th style="text-align: center;"> Actions </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $totalLP = 0; foreach($arrLongevity as $longe): $totalLP = $totalLP + $longe['longiPay']; ?>
                                <tr class="odd gradeX">
                                    <td><?=$longe['longiDate']?></td>
                                    <td><?=number_format($longe['longiAmount'], 2)?></td>
                                    <td><?=$longe['longiPercent']?></td>
                                    <td><?=number_format($longe['longiPay'], 2)?></td>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <td align="center" nowrap>
                                            <button class="btn btn-xs green" data-toggle="modal" href="#longevityModal" id="btn-modal-longevity"
                                                data-longeid="<?=$longe['id']?>" >
                                                <i class="fa fa-edit"></i> Edit</button>
                                            <button data-toggle="modal" href="#deleteLongevity" class="btn btn-xs red" id="btn-del-longevity"
                                                data-longeid="<?=$longe['id']?>" >
                                                <i class="fa fa-trash"></i> Delete</button>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:right">Longevity Pay: &nbsp;</td>
                                    <td style="padding-left: 6px;"><?=number_format($totalLP, 2)?></td>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?><td></td><?php endif; ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="portlet light bordered" style="height: 514px;">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Bonus List</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-bonusList" data-title="Bonus">
                            <thead>
                                <tr>
                                    <th style="width:120px;"> Benefit </th>
                                    <th> Monthly </th>
                                    <?php 
                                        foreach(setPeriods($empPayrollProcess) as $period):
                                            echo '<th> '.$period.' </th>';
                                        endforeach; ?>
                                    <th> Tax </th>
                                    <th> Status </th>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <th style="text-align: center;"> Actions </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($arrBonuslist as $bonus): $isremove = isset($bonus['arrbenefits']) ? $bonus['arrbenefits']['status'] == 0 ? True : False : '';?>
                                <tr class="odd gradeX <?=$isremove ? 'danger' : ''?>">
                                    <td style="text-align: left; padding-left: 7px;"><b><?=$bonus['incomeDesc']?></b></td>
                                    <td><?=isset($bonus['arrbenefits']) ? 
                                            number_format($bonus['arrbenefits']['incomeAmount'], 2) : '0.00'?></td>
                                    <?php 
                                        if(isset($bonus['arrbenefits'])):
                                            foreach(range(1, count(setPeriods($empPayrollProcess))) as $p):
                                                echo '<td>'.number_format($bonus['arrbenefits']['period'.$p], 2).'</td>';
                                            endforeach;
                                        else:
                                            foreach(range(1, count(setPeriods($empPayrollProcess))) as $p):
                                                echo '<td>0.00</td>';
                                            endforeach;
                                        endif;
                                        ?>
                                    <td><?=isset($bonus['arrbenefits']) ? 
                                            number_format($bonus['arrbenefits']['ITW'], 2) : '0.00'?></td>
                                    <td><?=isset($bonus['arrbenefits']) ? 
                                            getincome_status($bonus['arrbenefits']['status']) : ''?></td>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <td align="center">
                                            <button class="btn btn-xs green" data-toggle="modal" href="#benefitList" id="btn-modal-benefitList"
                                                    data-period1="<?=isset($bonus['arrbenefits']) ? $bonus['arrbenefits']['period1'] == '' ? '0.00' : $bonus['arrbenefits']['period1'] : '0.00'?>"
                                                    data-period2="<?=isset($bonus['arrbenefits']) ? $bonus['arrbenefits']['period2'] == '' ? '0.00' : $bonus['arrbenefits']['period2'] : '0.00'?>"
                                                    data-period3="<?=isset($bonus['arrbenefits']) ? $bonus['arrbenefits']['period3'] == '' ? '0.00' : $bonus['arrbenefits']['period3'] : '0.00'?>"
                                                    data-period4="<?=isset($bonus['arrbenefits']) ? $bonus['arrbenefits']['period4'] == '' ? '0.00' : $bonus['arrbenefits']['period4'] : '0.00'?>"

                                                    data-incomecode="<?=$bonus['incomeCode']?>" data-stat="bonus"
                                                    data-benefitcode="<?=isset($bonus['arrbenefits']) ? $bonus['arrbenefits']['benefitCode'] : ''?>"
                                                    data-tax="<?=isset($bonus['arrbenefits']) ? $bonus['arrbenefits']['ITW'] : '0.00'?>"
                                                    data-statusval="<?=isset($bonus['arrbenefits']) ? $bonus['arrbenefits']['status'] : "null"?>">
                                                <i class="fa fa-edit"></i> Edit</button>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Additional Income List</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-incomeList" data-title="Additional Income" >
                            <thead>
                                <tr>
                                    <th style="width:120px;"> Benefit </th>
                                    <th> Monthly </th>
                                    <?php 
                                        foreach(setPeriods($empPayrollProcess) as $period):
                                            echo '<th> '.$period.' </th>';
                                        endforeach; ?>
                                    <th> Tax </th>
                                    <th> Status </th>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <th style="text-align: center;"> Actions </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($arrAddtlIncome as $addtl): $isremove = isset($addtl['arrbenefits']) ? $addtl['arrbenefits']['status'] == 0 ? True : False : '';?>
                                <tr class="odd gradeX <?=$isremove ? 'danger' : ''?>">
                                    <td style="text-align: left; padding-left: 7px;" nowrap><b><?=$addtl['incomeDesc']?></b></td>
                                    <td><?=isset($addtl['arrbenefits']) ? 
                                            number_format($addtl['arrbenefits']['incomeAmount'], 2) : '0.00'?></td>
                                    <?php 
                                        if(isset($addtl['arrbenefits'])):
                                            foreach(range(1, count(setPeriods($empPayrollProcess))) as $p):
                                                echo '<td>'.number_format($addtl['arrbenefits']['period'.$p], 2).'</td>';
                                            endforeach;
                                        else:
                                            foreach(range(1, count(setPeriods($empPayrollProcess))) as $p):
                                                echo '<td>0.00</td>';
                                            endforeach;
                                        endif;
                                        ?>
                                    <td><?=isset($addtl['arrbenefits']) ? 
                                            number_format($addtl['arrbenefits']['ITW'], 2) : '0.00'?></td>
                                    <td><?=isset($addtl['arrbenefits']) ? 
                                            getincome_status($addtl['arrbenefits']['status']) : ''?></td>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <td align="center">
                                            <button class="btn btn-xs green" data-toggle="modal" href="#benefitList" id="btn-modal-benefitList"
                                                data-period1="<?=isset($addtl['arrbenefits']) ? $addtl['arrbenefits']['period1'] == '' ? '0.00' : $addtl['arrbenefits']['period1'] : '0.00'?>"
                                                data-period2="<?=isset($addtl['arrbenefits']) ? $addtl['arrbenefits']['period2'] == '' ? '0.00' : $addtl['arrbenefits']['period2'] : '0.00'?>"
                                                data-period3="<?=isset($addtl['arrbenefits']) ? $addtl['arrbenefits']['period3'] == '' ? '0.00' : $addtl['arrbenefits']['period3'] : '0.00'?>"
                                                data-period4="<?=isset($addtl['arrbenefits']) ? $addtl['arrbenefits']['period4'] == '' ? '0.00' : $addtl['arrbenefits']['period4'] : '0.00'?>"

                                                data-incomecode="<?=$addtl['incomeCode']?>" data-stat="addtl"
                                                data-benefitcode="<?=isset($addtl['arrbenefits']) ? $addtl['arrbenefits']['benefitCode'] : ''?>"
                                                data-tax="<?=isset($addtl['arrbenefits']) ? $addtl['arrbenefits']['ITW'] : '0.00'?>"
                                                data-statusval="<?=isset($addtl['arrbenefits']) ? $addtl['arrbenefits']['status'] : ""?>">
                                                <i class="fa fa-edit"></i> Edit</button>
                                        </td>
                                    <?php endif; ?>
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

<?php include('modals/_modal_income.php'); ?>
<?php load_plugin('js',array('datatables','form_validation'));?>
<script src="<?=base_url('assets/js/custom/finance-income.js')?>"></script>