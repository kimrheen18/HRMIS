<?=load_plugin('css', array('select2','datatables'))?>
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
            <span>Employee Loan Balance</span>
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
                    <span class="caption-subject bold uppercase"> EMPLOYEE LOANS</span>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-body" style="display: none">
                <div class="portlet light bordered">
                    <div class="col-md-9">
                        <form class="form-horizontal" action="<?=base_url('finance/reports/loanbalance')?>" method="get">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Employee Loans</label>
                                <div class="col-md-9">
                                    <select class="form-control select2 form-required" name="selpayrollGrp" placeholder="">
                                        <option value="null">-- SELECT EMPLOYEE LOANS --</option>
                                        <?php foreach($arrLoans as $loan): ?>
                                            <option value="<?=$loan['deductionCode']?>"><?=$loan['deductionDesc']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form><br>
                    </div>

                    <div class="portlet-title"></div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="tabbable-line tabbable-full-width col-md-12">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tblloan_balance" >
                                    <thead>
                                        <tr>
                                            <th> No </th>
                                            <th> Employee Number </th>
                                            <th> Name </th>
                                            <th> Code </th>
                                            <th> Date Granted </th>
                                            <th> Amount </th>
                                            <th> Actions </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=load_plugin('js', array('select2','datatables'))?>
<script>
    $('select.select2').select2({
        minimumResultsForSearch: -1,
        placeholder: function(){
            $(this).data('placeholder');
        }
    });
    $(document).ready(function() {
        $('.loading-image').hide();
        $('#div-body').show();
        $('#tblloan_balance').dataTable();
    });
</script>