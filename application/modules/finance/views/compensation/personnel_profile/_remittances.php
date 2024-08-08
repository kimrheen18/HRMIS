<?=load_plugin('css', array('profile-2','datepicker','datatables','select2'))?>
<div class="tab-pane active" id="tab_1_4">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="col-md-9">
                <?=form_open('finance/compensation/personnel_profile/remittances/'.$this->uri->segment(5), array('method' => 'get', 'class' => 'form-horizontal'))?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Select Remittance</label>
                        <div class="col-md-9">
                            <select class="form-control select2 form-required" name="selpayrollGrp">
                                <option value="null">-- SELECT REMITTANCE --</option>
                                <?php foreach($arrDeductions as $deduct): ?>
                                    <option value="<?=$deduct['deductionCode']?>" <?=count($_GET) > 0 ? $_GET['selpayrollGrp'] == $deduct['deductionCode'] ? 'selected' : '' : '' ?>>
                                        <?=$deduct['deductionDesc']?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Year</label>
                        <div class="col-md-9">
                            <div class="input-group input-large date-picker input-daterange" data-date="2003" data-date-format="yyyy" data-date-viewmode="years" id="dateRange">
                                <input type="text" class="form-control" name="from" value="<?=count($_GET) > 0 ? $_GET['from'] : ''?>">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="to" value="<?=count($_GET) > 0 ? $_GET['to'] : ''?>">
                            </div>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="<?=current_url()?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>
                <?=form_close()?>
                <br>
            </div>
            <div class="portlet-title"></div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-hazards" >
                            <thead>
                                <tr>
                                    <th style="text-align: center;"> No </th>
                                    <th style="text-align: center;"> Deduction </th>
                                    <th style="text-align: center;"> OR </th>
                                    <th style="text-align: center;"> Month </th>
                                    <th style="text-align: center;"> Year </th>
                                    <th style="text-align: right;"> Amount </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; $totalRemittance = 0;
                                if(isset($arrRemittances)):
                                    foreach($arrRemittances as $remit):
                                        $totalRemittance = $totalRemittance + ($remit['period1'] + $remit['period2'] + $remit['period3'] + $remit['period4']); ?>
                                        <tr class="odd gradeX">
                                            <td style="text-align: center;"><?=$no++?></td>
                                            <td style="text-align: center;"><?=$remit['deductionDesc']?></td>
                                            <td style="text-align: center;"><?=$remit['orNumber']?></td>
                                            <td style="text-align: center;"><?=date('F', mktime(0, 0, 0, $remit['deductMonth'], 10));?></td>
                                            <td style="text-align: center;"><?=$remit['deductYear']?></td>
                                            <td style="text-align: right;"><?=number_format(($remit['period1'] + $remit['period2'] + $remit['period3'] + $remit['period4']), 2)?></td>
                                        </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align:right">Grand Total: &nbsp;</td>
                                    <td style="padding-left: 6px;"><?=number_format($totalRemittance, 2)?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=load_plugin('js', array('datepicker','datatables','select2'))?>
<script>
    $(document).ready(function() {
        $('#table-hazards').dataTable();
        $('#dateRange').datepicker( {
            format: ' yyyy',
            viewMode: 'years',
            minViewMode: 'years'
          });
    });
</script>