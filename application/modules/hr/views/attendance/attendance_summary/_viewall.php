<?php
    $_GET['status'] = isset($_GET['status']) ? $_GET['status'] : 'all-employees';
    load_plugin('css',array('datatables', 'datepicker'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Attendance</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Attendance Summary</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>List of Employees</span>
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
                            <i class="icon-users font-dark"></i>
                            <span class="caption-subject bold uppercase"> List of Employees</span>
                        </div>
                        <div class="page-toolbar">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> <?=ucwords(str_replace('-',' ',strtolower($_GET['status'])))?>
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a href="<?=base_url('hr/attendance/view_all?status=all-employees')?>"> All Employees</a>
                                    </li>
                                    <?php foreach($arrStatus as $status): if($status!='' && strtolower(str_replace(' ','-',$status)) != $_GET['status']): ?>
                                        <li>
                                            <a href="<?=base_url('hr/attendance/view_all?status='.strtolower(str_replace(' ','-',$status)))?>"> <?=ucwords(str_replace('-',' ',strtolower($status)))?></a>
                                        </li>
                                    <?php endif; endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row" style="padding-bottom: 25px;">
                            <div class="col-md-12">
                                <a href="<?=base_url('hr/attendance/dtrlogs')?>" class="btn btn-md blue">
                                    DTR Logs</a>&nbsp;&nbsp;
                                <a href="<?=base_url('hr/attendance/flag_ceremony')?>" class="btn btn-md blue">
                                    Flag Ceremony</a>&nbsp;&nbsp;
                                <a href="<?=base_url('hr/attendance/employees_inc_dtr')?>" class="btn btn-md blue">
                                    Employees with Incomplete Attendance</a>&nbsp;&nbsp;
                                <a href="<?=base_url('hr/attendance/employees_leave_balance')?>" class="btn btn-md blue">
                                    Leave Balance</a>
                                <a href="javascript:;" data-toggle="modal" data-target="#dtr-logs-excel" class="btn btn-md blue">
                                    DTR Logs Excel</a>
                            </div>
                        </div>
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-employees" style="display: none">
                            <thead>
                                <tr>
                                    <th> No. </th>
                                    <th> Employee Number </th>
                                    <th> Name </th>
                                    <th> Status </th>
                                    <th> Office </th>
                                    <th> Position </th>
                                    <th style="text-align: center;"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php   $no=1;
                                        foreach($arrEmployees as $row):

                                            if((strtolower(str_replace(' ','-',$row['statusOfAppointment'])) == strtolower(str_replace(' ','-',$_GET['status']))) || $_GET['status'] == 'all-employees'): ?>
                                                <tr class="odd gradeX ">
                                                    <td><?=$no++?> </td>
                                                    <td> <?=$row['empNumber']?></a> </td>
                                                    <td> <?=getfullname($row['firstname'],$row['surname'],$row['middlename'],$row['middleInitial'],$row['nameExtension'])?> </td>
                                                    <td> <?=$row['statusOfAppointment']?> </td>
                                                    <td> <?=employee_office($row['empNumber'])?> </td>
                                                    <td> <?=$row['positionDesc']?></td>
                                                    <td style="text-align: center;"> <a href="<?=base_url('hr/attendance_summary/index').'/'.$row['empNumber']?>" class="btn btn-sm blue"> <i class="fa fa-eye"></i>  View</a></td>
                                                </tr>
                                <?php
                                            endif;
                                        endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dtr-logs-excel" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
               <h4> <b>DTR Logs Export Excel</b> </h4>
            </div>
            <div class="modal-body">
                <div id="sandbox-container">
                    <?=form_open('hr/attendance/generateExcel', array('method' => 'post'))?>
                        <input type="text" name="date" class="form-control" placeholder="Select Date">
                        <br>
                        <button class="btn btn-success" type="submit"> Export </button>
                    <?=form_close()?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php load_plugin('js',array('datatables', 'datepicker'));?>

<script>
    $(document).ready(function() {
        $('#table-employees').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-employees').show();
            }} );

            $('#sandbox-container input').datepicker({});
    });
</script>