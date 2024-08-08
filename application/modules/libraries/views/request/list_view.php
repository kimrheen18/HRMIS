<?php 
/** 
Purpose of file:    List page for Request Signatories Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php load_plugin('css',array('datepicker','datatables'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?=base_url('libraries/agency_profile')?>">Libraries</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Request</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
       &nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> REQUEST</span>
                </div>
                
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-request" style="display: none">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="<?=base_url('libraries/request/add')?>"><button id="sample_editable_1_new" class="btn sbold btn-primary"> <i class="fa fa-plus"></i> Add New
                                    
                                </button></a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="libraries_request">
                    <thead>
                        <tr>
                            <th style="width: 100px;text-align:center;"> No. </th>
                            <th> Type of Request </th>
                            <th> Applicant </th>
                            <th> 1st Signatory </th>
                            <th> 2nd Signatory </th>
                            <th> 3rd Signatory </th>
                            <th> 4th Signatory </th>
                            <th> Final Signatory </th>
                            <th class="no-sort" style="text-align: center;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1;foreach($arrRequest as $request): ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$request['requestDesc']?> </td>
                                <td><?=$request['Applicant']?> </td>
                                <td nowrap>
                                    <?=strlen(implode($request['first_signatory'])) == 0 ? '' : implode(' <i class="fa fa-long-arrow-right"></i> ',$request['first_signatory'])?></td>
                                <td nowrap>
                                    <?=strlen(implode($request['second_signatory'])) == 0 ? '' : implode(' <i class="fa fa-long-arrow-right"></i> ',$request['second_signatory'])?></td>
                                <td nowrap>
                                    <?=strlen(implode($request['third_signatory'])) == 0 ? '' : implode(' <i class="fa fa-long-arrow-right"></i> ',$request['third_signatory'])?></td>
                                <td nowrap>
                                    <?=strlen(implode($request['fourth_signatory'])) == 0 ? '' : implode(' <i class="fa fa-long-arrow-right"></i> ',$request['fourth_signatory'])?></td>
                                <td nowrap>
                                    <?=strlen(implode($request['final_signatory'])) == 0 ? '' : implode(' <i class="fa fa-long-arrow-right"></i> ',$request['final_signatory'])?></td>
                                <td width="150px" style="white-space: nowrap;">
                                    <a class="btn btn-sm btn-success" href="<?=base_url('libraries/request/edit/'.$request['reqID'])?>">
                                        <i class="fa fa-edit" title="Edit"></i> Edit</a>
                                    <a class="btn btn-sm btn-danger" href="<?=base_url('libraries/request/delete/'.$request['reqID'])?>">
                                        <i class="fa fa-trash" title="Delete"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php load_plugin('js',array('datatables'));?>


<script>
    $(document).ready(function() {
        $('#libraries_request').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#div-request').show();
            }} );
    });
</script>