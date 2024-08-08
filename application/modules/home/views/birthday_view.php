<?php 
/** 
Purpose of file:    Default View for 201
Author:             Louie Carl R. Mandapat
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?=load_plugin('css',array('datatables'));?>
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
                    <span class="caption-subject bold uppercase"> Birthday Celebrants for <?=date('F Y')?></span>
                </div>
                
            </div>
            <div class="portlet-body">
               
                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tblemployees"  style="display: none">
                    <thead>
                        <tr>
                            <th style="width: 75px;"> No. </th>
                            <th> Name of Celebrator </th>
                            <th> Office </th>
                            <th style="width: 120px;text-align: center;"> Day of Birth </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($arrData as $row):?>
                            <tr class="odd gradeX">
                                <td> <?=$i++?> </td>
                                <td> <a href="<?=base_url('hr/profile').'/'.$row['empNumber']?>"><?=$row['surname'].', '.$row['firstname'].' '.$row['middleInitial']?><?=strpos($row['middleInitial'], '.') !== false?'':'.'?></a></td>
                                <td> <?=employee_office($row['empNumber'])?> </td>
                                <td align="center"> <?=date('j',strtotime($row['birthday']))?></td>
                            </tr>
                        <?php endforeach;?>
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


