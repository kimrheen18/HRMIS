<?php 
/** 
Purpose of file:    List page for Zone Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php load_plugin('css',array('datepicker'));?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> ZONE</span>
                </div>
                
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="<?=base_url('libraries/zone/add')?>"><button id="sample_editable_1_new" class="btn sbold btn-primary"> <i class="fa fa-plus"></i> Add New
                                    
                                </button></a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="libraries_zone">
                    <thead>
                        <tr>
                            <th> No. </th>
                            <th> Zone Code </th>
                            <th> Zone Description </th>
                            <th> Server Name </th>
                            <th> Username </th>
                            <th> Password </th>
                            <th> Database Name </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    foreach($arrZone as $zone):?>
                        <tr class="odd gradeX">
                            <td> <?=$i?> </td>
                            <td> <?=$zone['zonecode']?> </td>
                            <td> <?=$zone['zonedesc']?> </td>
                            <td> <?=$zone['serverName']?> </td>
                            <td> <?=$zone['username']?> </td>
                            <td> <?=$zone['password']?> </td>
                            <td> <?=$zone['databaseName']?> </td>
                            <td>
                                <a href="<?=base_url('libraries/zone/edit/'.$zone['zonecode'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                <a href="<?=base_url('libraries/zone/delete/'.$zone['zonecode'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-trash" title="Delete"></span> Delete</button></a>
                               
                            </td>
                        </tr>
                    <?php 
                    $i++;
                    endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php load_plugin('js',array('datatable'));?>


<script>
    $(document).ready(function() {
        Datatables.init('libraries_zone');
  });
</script>