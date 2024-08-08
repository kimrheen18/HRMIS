<?php load_plugin('css',array('datatables'));?>
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
            <span>Included in Payroll</span>
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
                            <span class="caption-subject bold uppercase"> Included in Payroll</span>
                        </div>
                    </div>
                
                    <div class="portlet-body">
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-npayroll" style="display: none">
                            <thead>
                                <tr>
                                    <tr>
                                        <th style="text-align: center; width: 50px;"> No. </th>
                                        <th> Employee Number </th>
                                        <th> Name </th>
                                        <th> Position </th>
                                        <th style="text-align: center;"> Actions </th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrEmployees as $employee): ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$employee['empNumber']?></td>
                                        <td><?=getfullname($employee['firstname'], $employee['surname'], $employee['middlename'], $employee['middleInitial'], $employee['nameExtension'])?></td>
                                        <td><?=$employee['positionDesc']?></td>
                                        <td style="text-align: center;"> <a href="<?=base_url('finance/compensation/personnel_profile/employee').'/'.$employee['empNumber']?>" class="btn btn-sm blue"> <i class="fa fa-eye"></i>  View</a></td>
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

<?php load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-npayroll').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-npayroll').show();
            }} );
    });
</script>