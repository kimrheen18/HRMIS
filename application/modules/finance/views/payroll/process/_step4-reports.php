<div class="tab-content">
    <div class="tab-pane active">
        <h4 class="block">Reports</h4>
        <div class="row">
            <div class="col-md-12 scroll">
                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                <center>
                    <table class="table table-striped table-bordered order-column" id="tblreports" style="visibility: hidden;width: 70%;">
                        <tr>
                            <td>Payslip</td>
                            <td style="text-align: center;">
                                <a href="<?=base_url('finance/reports/MonthlyReports/payslip')?>" target="_blank" class="btn green btn-xs btn-circle">
                                    <i class="fa fa-money"></i> First Half</a>
                            </td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                        <tr>
                            <td>Payroll Register</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                        <tr>
                            <td>Funding Requirements</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Monthly</button></td>
                            <td style="text-align: center;"></td>
                        </tr>
                        <tr>
                            <td>MC Benefit Register</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                        <tr>
                            <td>Deduction Register</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                        <tr>
                            <td>Summary of Deductions</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                        <tr>
                            <td>Lates/Abs Deductions</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                        <tr>
                            <td>Overtime -> Payroll Register</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                            <tr>
                            <td><?=str_repeat('&nbsp;', 10)?>Funding Requirements</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                        <tr>
                            <td>Generate PACS</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                        <tr>
                            <td>Generate FINDES</td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> First Half</button></td>
                            <td style="text-align: center;"><button type="button" class="btn green btn-xs btn-circle"><i class="fa fa-money"></i> Second Half</button></td>
                        </tr>
                    </table>
                </center>
            </div>
        </div>
        <br><br>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('.loading-image').hide();
        $('#tblreports').css('visibility', 'visible');
    });
</script>