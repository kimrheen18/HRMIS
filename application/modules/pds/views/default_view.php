<?php 
/** 
Purpose of file:    Default View for 201
Author:             Louie Carl R. Mandapat
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
    $_GET['status'] = isset($_GET['status']) ? $_GET['status'] : 'all-employees';
    load_plugin('css',array('datatables'));?>
<!-- BREADCRUMB -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
      <!--   <li>
            <span>HR Module</span>
            <i class="fa fa-circle"></i>
        </li> -->
        <li>
            <span>201 File</span>
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
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-user font-dark"></i>
                    <span class="caption-subject bold uppercase"> List of Employees</span>
                </div>
                <div class="page-toolbar">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> <?=ucwords(str_replace('-',' ',strtolower($_GET['status'])))?>
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <a href="<?=base_url('pds?status=all-employees')?>"> All Employees</a>
                            </li>
                            <?php foreach($arrStatus as $status): if($status!='' && strtolower(str_replace(' ','-',$status)) != $_GET['status']): ?>
                                <li>
                                    <a href="<?=base_url('pds?status='.strtolower(str_replace(' ','-',$status)))?>"> <?=ucwords(str_replace('-',' ',strtolower($status)))?></a>
                                </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="<?=base_url('hr/add_employee')?>" class="btn blue"><i class="fa fa-plus"></i> Add Employee</a>&nbsp;
                                
                            </div>
                            <div class="btn-group">
                                <input type="submit" class="btn blue" name="Submit" value="PRINT PDS CS-212 Form" onclick="openPrint()" />
                                <!-- <a href="//base_url('pds/print')" class="btn blue"><i class="fa fa-print"></i> Print PDS</a> -->
                            </div>
                        </div>  
                    </div>
                </div>

                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tblemployees"  style="display: none">
                    <thead>
                        <tr>
                            <th> No. </th>
                            <th> Employee Number </th>
                            <th> Name </th>
                            <th> Office </th>
                            <th> Position </th>
                            <th> Appointment Desc </th>
                            <th> Status </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                        foreach($arrEmployees as $row):
                            if((strtolower(str_replace(' ','-',$row['statusOfAppointment'])) == strtolower(str_replace(' ','-',$_GET['status']))) || $_GET['status'] == 'all-employees'): ?>
                                <tr class="odd gradeX">
                                    <td> <?=$i++?> </td>
                                    <td> <?=$row['empNumber']?></a> </td>
                                    <?php if($row['middleInitial']=="") 
                                    {
                                        echo '<td>'.$row['surname'].', '.$row['firstname'].'</td>'; ?>
                                    <?php } else {
                                         echo '<td>'.$row['surname'].', '.$row['firstname'].' '.$row['middleInitial']?><?=strpos($row['middleInitial'], '.') !== false?'':'.'.' '.$row['nameExtension'].'</td>'; ?>
                                    <?php } ?>
                                   <!--  <td> //employee_office($row['empNumber']) </td> -->
                                    <td> <?=$row['officecode']?> </td>
                                    <td> <?=$row['positionDesc']?></td>
                                    <td> <?=$row['appointmentDesc']?></td>
                                    <td> <?=$row['statusOfAppointment']?></td>
                                    <td style="text-align: center;">
                                        <a href="<?=base_url('hr/profile').'/'.$row['empNumber']?>" class="btn btn-sm blue"> <i class="fa fa-eye"></i>  View</a>
                                    </td>
                                </tr>
                            <?php 
                            endif;
                        endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#tblemployees').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tblemployees').show();
            }} );
    });
</script>


<!-- Print CS Form 212  -->
<script>
function openPrint()
{
    
    window.open('uploads/pds/PersonalDataSheet.xlsx');
    
}
</script>

