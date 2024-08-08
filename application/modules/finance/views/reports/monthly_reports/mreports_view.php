<?=load_plugin('css', array('select2','select','datepicker'))?>
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
                    <span class="caption-subject bold uppercase"> MONTHLY REPORTS</span>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-body" style="display: none">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <?=form_open('', array('id' => 'frmpprocess', 'class'=>'form-horizontal', 'method'=>'get'))?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Payroll Process</label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <select class="form-control select2 form-required" name="appt" id="selappt">
                                                <option value="">-- SELECT PAYROLL PROCESS --</option>
                                                <?php foreach ($arrProcess as $process): ?>
                                                    <option value="<?=$process['employeeAppoint']?>" data-processid="<?=$process['processID']?>"
                                                        data-period="<?=$process['period']?>" data-json='<?=json_encode($process)?>'
                                                        <?=isset($_GET['processid']) ? $_GET['processid'] == $process['processID'] ? 'selected' : '' : ''?>>
                                                        <?=$process['appointmentDesc']?> - (<?=$process['processCode']?> <?=$process['employeeAppoint'] != 'P' ? $process['period'] : ''?>)</option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Year</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control input-large date-picker" name="yr" id="selyr"
                                            data-date="2003" data-date-format="yyyy" data-date-viewmode="years" value="<?=curryr()?>">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Month</label>
                                    <div class="col-md-3" style="width: 23% !important;">
                                        <select class="bs-select form-control" name="mon" id="selmon">
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
                            </div>
                        <?=form_close();?>
                    </div>
                    <div class="portlet-body" <?=$_GET['appt']==''?'hidden':''?>>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <?php if(isset($_GET['appt'])): $periods = setPeriods(salary_schedule()); ?>
                                <table class="table table-bordered" id="tblmreports" >
                                    <tr>
                                        <th>Payslip</th>
                                        <?php foreach($periods as $pk => $period): ?>
                                            <td style="text-align: center;" class="half<?=($pk+1)?>">
                                                <a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="<?=($pk+1)?>" data-link="<?=base_url('finance/reports/MonthlyReports/all_payslip')?>" data-title="Payslip">
                                                    <i class="fa fa-money"></i> <?=$period?></a>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <th>Payroll Register</th>
                                        <?php foreach($periods as $pk => $period): ?>
                                            <td style="text-align: center;" class="half<?=($pk+1)?>">
                                                <a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="<?=($pk+1)?>" data-link="<?=base_url('finance/reports/MonthlyReports/payroll_register')?>" data-title="Payroll Register">
                                                    <i class="fa fa-money"></i> <?=$period?></a>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <th>Funding Requirements</th>
                                        <td style="text-align: center;" colspan="2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Monthly</a></td>
                                    </tr>
                                    <tr>
                                        <th>MC Benefit Register</th>
                                        <td style="text-align: center;" class="half1"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="1" data-link="<?=base_url()?>"><i class="fa fa-money"></i> First Half</a></td>
                                        <td style="text-align: center;" class="half2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="2" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Second Half</a></td>
                                    </tr>
                                    <tr>
                                        <th>Deduction Register</th>
                                        <td style="text-align: center;" class="half1"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="1" data-link="<?=base_url()?>"><i class="fa fa-money"></i> First Half</a></td>
                                        <td style="text-align: center;" class="half2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="2" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Second Half</a></td>
                                    </tr>
                                    <tr>
                                        <th>Summary of Deductions</th>
                                        <td style="text-align: center;" class="half1"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="1" data-link="<?=base_url()?>"><i class="fa fa-money"></i> First Half</a></td>
                                        <td style="text-align: center;" class="half2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="2" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Second Half</a></td>
                                    </tr>
                                    <tr>
                                        <th>Lates/Abs Deductions</th>
                                        <td style="text-align: center;" class="half1"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="1" data-link="<?=base_url()?>"><i class="fa fa-money"></i> First Half</a></td>
                                        <td style="text-align: center;" class="half2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="2" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Second Half</a></td>
                                    </tr>
                                    <tr>
                                        <th>Overtime -> Payroll Register</th>
                                        <td style="text-align: center;" class="half1"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="1" data-link="<?=base_url()?>"><i class="fa fa-money"></i> First Half</a></td>
                                        <td style="text-align: center;" class="half2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="2" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Second Half</a></td>
                                    </tr>
                                     <tr>
                                        <th><?=str_repeat('&nbsp;', 10)?>Funding Requirements</th>
                                        <td style="text-align: center;" class="half1"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="1" data-link="<?=base_url()?>"><i class="fa fa-money"></i> First Half</a></td>
                                        <td style="text-align: center;" class="half2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="2" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Second Half</a></td>
                                    </tr>
                                    <tr>
                                        <th>Generate PACS</th>
                                        <td style="text-align: center;" class="half1"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="1" data-link="<?=base_url()?>"><i class="fa fa-money"></i> First Half</a></td>
                                        <td style="text-align: center;" class="half2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="2" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Second Half</a></td>
                                    </tr>
                                    <tr>
                                        <th>Generate FINDES</th>
                                        <td style="text-align: center;" class="half1"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="1" data-link="<?=base_url()?>"><i class="fa fa-money"></i> First Half</a></td>
                                        <td style="text-align: center;" class="half2"><a class="btn green btn-sm btn-circle areport" href="javascript:;" data-linkper="2" data-link="<?=base_url()?>"><i class="fa fa-money"></i> Second Half</a></td>
                                    </tr>
                                </table>
                                <?php endif; ?>
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

<?=load_plugin('js', array('select2','select','form_validation','datepicker'))?>
<script src="<?=base_url('assets/js/custom/monthly-reports.js')?>"></script>
<script>
$(document).ready(function() {

    if("<?=isset($_GET['appt']) ? 1 : 0?>" == "1"){
        if("<?=$_GET['appt'] != 'P' ? 1 : 0?>" == "1"){
            $('td.half1,td.half2').hide();
        }
    }

    if("<?=isset($_GET['period']) ? $_GET['period'] : ''?>" == 1){
        $('td.half1').show();
        $('td.half2').hide();
    }

    if("<?=isset($_GET['period']) ? $_GET['period'] : ''?>" == 2){
        $('td.half2').show();
        $('td.half1').hide();
    }

});
</script>