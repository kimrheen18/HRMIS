<?=load_plugin('css', array('profile-2','datepicker','datatables','select2','select'))?>
<div class="tab-pane active" id="tab_1_4">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <div class="col-md-9">
                            <div class="form-horizontal">
                                <input type="hidden" id="txtempnumber" value="<?=$this->uri->segment(5)?>">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Report Type</label>
                                    <div class="col-md-9">
                                        <select class="form-control bs-select form-required" name="selrep_type" id="selrep_type">
                                            <option value='1'>Payslip</option>
                                            <option value='2'>Remittances</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group div-remittances" hidden>
                                    <label class="col-md-3 control-label">Select remittance</label>
                                    <div class="col-md-9">
                                        <select class="form-control select2 form-required" name="selrep_remitt" id="selrep_remitt">
                                            <option value=""></option>
                                            <?php foreach($arrDeductions as $deduct): ?>
                                                <option value="<?=$deduct['deductionCode']?>" <?=count($_GET) > 0 ? $_GET['selpayrollGrp'] == $deduct['deductionCode'] ? 'selected' : '' : '' ?>>
                                                    <?=$deduct['deductionDesc']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group div-month">
                                    <label class="col-md-3 control-label">Month</label>
                                    <div class="col-md-9">
                                        <select class="bs-select form-control" name="month" id="selmont">
                                            <?php foreach (range(1, 12) as $m): ?>
                                                <option value="<?=sprintf('%02d', $m)?>"
                                                    <?php 
                                                        if(isset($_GET['month'])):
                                                            echo $_GET['month'] == $m ? 'selected' : '';
                                                        else:
                                                            echo $m == sprintf('%02d', date('n')) ? 'selected' : '';
                                                        endif;
                                                     ?> >
                                                    <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group div-yr">
                                    <label class="col-md-3 control-label">Year</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control input-large date-picker" name="txtps_yr" id="txtps_yr"
                                            data-date="2003" data-date-format="yyyy" data-date-viewmode="years" value="<?=date('Y')?>">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group div-yrrange" hidden>
                                    <label class="col-md-3 control-label">Year</label>
                                    <div class="col-md-9">
                                        <div class="input-group input-large date-picker input-daterange" data-date="2003" data-date-format="yyyy" data-date-viewmode="years" id="dateRange">
                                            <input type="text" class="form-control" name="from" id="txtremit_from" value="<?=date('Y')?>">
                                            <span class="input-group-addon"> to </span>
                                            <input type="text" class="form-control" name="to" id="txtremit_to" value="<?=date('Y')?>">
                                        </div>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group div-period">
                                    <label class="col-md-3 control-label">Period</label>
                                    <div class="col-md-9">
                                        <select class="form-control bs-select form-required" name="selpayrollGrp" id="selpayrollGrp">
                                            <?php
                                                if(count($periods) > 0):
                                                    foreach($periods as $period):
                                                        if($period['publish'] == 1):
                                                            if($period['period'] == 4 && $period['employeeAppoint'] == 'P'):
                                                                for($p = 1; $p <= salary_schedule_ctr($period['salarySchedule'],0,1); $p++):
                                                                    echo "<option value='".$period['processID']."' data-period='".$p."'
                                                                            data-appt='".$period['employeeAppoint']."'
                                                                            data-codes='".implode(', ',$period['codes'])."'>".$period['processCode']." - PERIOD ".$p."</option>";
                                                                endfor;
                                                            else:
                                                                echo "<option value='".$period['processID']."' data-period='".$period['period']."'
                                                                        data-appt='".$period['employeeAppoint']."'
                                                                        data-codes='".implode(', ',$period['codes'])."'>".$period['processCode']." - PERIOD ".$period['period']."</option>";
                                                            endif;
                                                        endif;
                                                    endforeach;
                                                else:
                                                    echo '<option value="">NO PUBLISHED PAYROLL FOR THIS MONTH</option>';
                                                endif; ?>
                                        </select>
                                        <span class="help-block small" id="period-codes"></span>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group" <?=check_module()=='payroll'?'':'hidden'?>>
                                    <label class="col-md-3 control-label">Signatory</label>
                                    <div class="col-md-9">
                                        <select class="form-control select2 form-required" name="selsign" id="selsign">
                                            <option value=""></option>
                                            <?php foreach($arrSignatories as $sign): ?>
                                                <option value="<?=$sign['signatoryId']?>"><?=$sign['signatory']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group div-generate" hidden>
                                    <label class="col-md-3 control-label">Generate</label>
                                    <div class="col-md-9">
                                        <select class="form-control bs-select form-required" name="selgen" id="selgen">
                                            <option value=""> </option>
                                            <option value='1'>PDF</option>
                                            <!-- <option value='2'>EXCEL</option> -->
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <a id="btnprint" href="javascript:;" class="btn btn-primary">Print Preview</a>
                                            <a href="<?=current_url()?>" class="btn default">Cancel</a>
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
</div>

<!-- begin print-preview modal -->
<div id="print-preview-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" value="<?=base_url()?>" id="txtbaseurl">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed id="embed-pdf" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="link-fullsize" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end print-preview modal -->

<?=load_plugin('js', array('datepicker','datatables','select2','select'))?>
<script src="<?=base_url('assets/js/custom/compensation-reports.js')?>"></script>