<?=load_plugin('css',array('datatables'));?>
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
            <span>Organizational Structure</span>
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
        <div class="tab-content portlet light bordered">
            <div class="tabbable tabbable-tabdrop">
                <ul class="nav nav-tabs">
                    <li class="<?=isset($_GET['tab']) ? '' : 'active'?>">
                           <a href="#tab_executive" data-toggle="tab">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <?php if ($_ENV['Group1']!='')
                                { ?>
                                <span class="caption-subject bold uppercase"> <?=$_ENV['Group1']?></span>
                                <?php } ?>
                            </div>
                        </a>
                    </li>
                    <li class="<?=isset($_GET['tab']) ? 'active' : ''?>">
                         <a href="#tab_service" data-toggle="tab">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <?php if ($_ENV['Group2']!='')
                                { ?>
                                <span class="caption-subject bold uppercase"> <?=$_ENV['Group2']?> </span>
                                <?php } ?>
                            </div>
                        </a>
                    </li>
                    <li class="<?=isset($_GET['tab']) ? 'active' : ''?>">
                        <a href="#tab_division" data-toggle="tab">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <?php if ($_ENV['Group3']!='')
                                { ?>
                                <span class="caption-subject bold uppercase"> <?=$_ENV['Group3']?> </span>
                                <?php } ?>
                            </div>
                        </a>
                    </li>
                    <li class="<?=isset($_GET['tab']) ? 'active' : ''?>">
                        <a href="#tab_section" data-toggle="tab">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <?php if ($_ENV['Group4']!='')
                                { ?>
                                <span class="caption-subject bold uppercase"> <?=$_ENV['Group4']?> </span>
                                <?php } ?>
                            </div>
                        </a>
                    </li>
                    <?php if ($_ENV['Group5']!='')
                    { ?>
                        <li class="<?=isset($_GET['tab']) ? 'active' : ''?>">
                            <a href="#tab_department" data-toggle="tab">
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <?php if ($_ENV['Group5']!='')
                                    { ?>
                                    <span class="caption-subject bold uppercase"> <?=$_ENV['Group5']?> </span>
                                    <?php } ?>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div id="tab_executive" class="tab-pane <?=isset($_GET['tab']) ? '' : 'active'?>" v-cloak>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?=base_url('libraries/org_structure/add_exec')?>" id="sample_editable_1_new" class="btn sbold blue"><i class="fa fa-plus"></i> Add New </a>
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn green btn-outline dropdown-toggle" data-toggle="dropdown">  <i class="fa fa-angle-down"></i> </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                  <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_executive">
                                    <thead>
                                        <tr>
                                            <th style="width: 85px;text-align:center;"> No. </th>
                                            <th> <?=$_ENV['Group1']?> Code </th>
                                            <th> <?=$_ENV['Group1']?> Name </th>
                                            <th> <?=$_ENV['Group1']?> Head Title </th>
                                            <th> <?=$_ENV['Group1']?> Head </th>
                                            <th class="no-sort" style="width: 180px;text-align:center;"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($arrOrganization as $org):?>
                                        <tr class="odd gradeX">
                                            <td> <?=$i?> </td>
                                            <td> <?=$org['group1Code']?> </td>
                                            <td> <?=$org['group1Name']?> </td>   
                                            <td> <?=$org['group1HeadTitle']?> </td>   
                                            <td> <?=$org['surname'].', '.$org['firstname']?> </td>                 
                                            <td style="width: 200px;text-align:center;" style="white-space: nowrap;">
                                                <a href="<?=base_url('libraries/org_structure/edit_exec/'.$org['group1Code'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                                <a href="<?=base_url('libraries/org_structure/delete_exec/'.$org['group1Code'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-edit" title="Delete"></span> Delete</button></a>
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
            </div>
            <div id="tab_service" class="tab-pane <?=isset($_GET['tab']) == 'agency' ? '' : '' ?>">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?=base_url('libraries/org_structure/add_service')?>" id="sample_editable_1_new" class="btn sbold blue"> <i class="fa fa-plus"></i> Add New </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                 <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_service">
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                            <th> <?=$_ENV['Group1']?> Code </th>
                                            <th> <?=$_ENV['Group2']?> Code </th>
                                            <th> <?=$_ENV['Group2']?> Name </th>
                                            <th> <?=$_ENV['Group2']?> Head Title </th>
                                            <th> <?=$_ENV['Group2']?> Head </th>
                                            <th class="no-sort" style="text-align: center;"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($arrService as $service):?>
                                        <tr class="odd gradeX">
                                            <td> <?=$i?> </td>
                                            <td> <?=$service['group1Code']?> </td>
                                            <td> <?=$service['group2Code']?> </td>   
                                            <td> <?=$service['group2Name']?> </td>   
                                            <td> <?=$service['group2HeadTitle']?> </td>   
                                            <td> <?=$service['surname'].', '.$service['firstname']?> </td>                 
                                            <td style="width: 200px;text-align:center;" style="white-space: nowrap;">
                                                <a href="<?=base_url('libraries/org_structure/edit_service/'.$service['group2Code'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                                <a href="<?=base_url('libraries/org_structure/delete_service/'.$service['group2Code'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-edit" title="Delete"></span> Delete</button></a>
                                               
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
            </div>
            <div id="tab_division" class="tab-pane <?=isset($_GET['tab']) ? '' : ''?>" v-cloak>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?=base_url('libraries/org_structure/add_division')?>" id="sample_editable_1_new" class="btn sbold blue"><i class="fa fa-plus"></i> Add New </a>
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn green btn-outline dropdown-toggle" data-toggle="dropdown">  <i class="fa fa-angle-down"></i> </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                  <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_division"">
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                            <th> <?=$_ENV['Group1']?> Code </th>
                                            <th> <?=$_ENV['Group2']?> Code </th>
                                            <th> <?=$_ENV['Group3']?> Code </th>
                                            <th> <?=$_ENV['Group3']?> Name </th>
                                            <th> <?=$_ENV['Group3']?> Head Title</th>
                                            <th> <?=$_ENV['Group3']?> Head </th>
                                            <th class="no-sort" style="text-align: center;"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($arrDivision as $div):?>
                                        <tr class="odd gradeX">
                                            <td> <?=$i?> </td>
                                            <td> <?=$div['group1Code']?> </td>
                                            <td> <?=$div['group2Code']?> </td>   
                                            <td> <?=$div['group3Code']?> </td>   
                                            <td> <?=$div['group3Name']?> </td>   
                                            <td> <?=$div['group3HeadTitle']?> </td>   
                                            <td> <?=$div['surname'].' '.$div['firstname']?> </td>                            
                                            <td style="width: 200px;text-align:center;" style="white-space: nowrap;">
                                                <a href="<?=base_url('libraries/org_structure/edit_division/'.$div['group3Code'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                                <a href="<?=base_url('libraries/org_structure/delete_division/'.$div['group3Code'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-edit" title="Delete"></span> Delete</button></a>
                                            
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
            </div>
            <div id="tab_section" class="tab-pane <?=isset($_GET['tab']) ? '' : ''?>" v-cloak>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?=base_url('libraries/org_structure/add_section')?>" id="sample_editable_1_new" class="btn sbold blue"><i class="fa fa-plus"></i> Add New </a>
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn green btn-outline dropdown-toggle" data-toggle="dropdown">  <i class="fa fa-angle-down"></i> </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_section">
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                            <th> <?=$_ENV['Group1']?> Code </th>
                                            <th> <?=$_ENV['Group2']?> Code </th>
                                            <th> <?=$_ENV['Group3']?> Code </th>
                                            <th> <?=$_ENV['Group4']?> Code </th>
                                            <th> <?=$_ENV['Group4']?> Name </th>
                                            <th> <?=$_ENV['Group4']?> Head Title</th>
                                            <th> <?=$_ENV['Group4']?> Head </th>
                                            <th class="no-sort" style="text-align: center;"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($arrSection as $section):?>
                                        <tr class="odd gradeX">
                                            <td> <?=$i?> </td>
                                            <td> <?=$section['group1Code']?> </td>
                                            <td> <?=$section['group2Code']?> </td> 
                                            <td> <?=$section['group3Code']?> </td>   
                                            <td> <?=$section['group4Code']?> </td>   
                                            <td> <?=$section['group4Name']?> </td>   
                                            <td> <?=$section['group4HeadTitle']?> </td>   
                                            <td> <?=$section['surname'].' '.$section['firstname']?> </td>                                        
                                            <td style="width: 200px;text-align:center;" style="white-space: nowrap;">
                                                <a href="<?=base_url('libraries/org_structure/edit_section/'.$section['group4Code'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                                <a href="<?=base_url('libraries/org_structure/delete_section/'.$section['group4Code'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-edit" title="Delete"></span> Delete</button></a>
                                             
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
            </div>
            <div id="tab_department" class="tab-pane <?=isset($_GET['tab']) ? '' : ''?>" v-cloak>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?=base_url('libraries/org_structure/add_department')?>" id="sample_editable_1_new" class="btn sbold blue"><i class="fa fa-plus"></i> Add New </a>
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn green btn-outline dropdown-toggle" data-toggle="dropdown">  <i class="fa fa-angle-down"></i> </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_department">
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                            <th> <?=$_ENV['Group1']?> Code </th>
                                            <th> <?=$_ENV['Group2']?> Code </th>
                                            <th> <?=$_ENV['Group3']?> Code </th>
                                            <th> <?=$_ENV['Group4']?> Code </th>
                                            <th> <?=$_ENV['Group5']?> Code </th>
                                            <th> <?=$_ENV['Group5']?> Name </th>
                                            <th> <?=$_ENV['Group5']?> Head Title</th>
                                            <th> <?=$_ENV['Group5']?> Head </th>
                                            <th class="no-sort" style="text-align: center;"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $i=1;
                                    foreach($arrDepartment as $department):?>
                                        <tr class="odd gradeX">
                                            <td> <?=$i?> </td>
                                            <td> <?=$department['group1Code']?> </td>
                                            <td> <?=$department['group2Code']?> </td> 
                                            <td> <?=$department['group3Code']?> </td>   
                                            <td> <?=$department['group4Code']?> </td>   
                                            <td> <?=$department['group5Code']?> </td> 
                                            <td> <?=$department['group5Name']?> </td>   
                                            <td> <?=$department['group5HeadTitle']?> </td>   
                                            <td> <?=$department['surname'].' '.$department['firstname']?> </td>                                        
                                            <td style="width: 200px;text-align:center;" style="white-space: nowrap;">
                                                <a href="<?=base_url('libraries/org_structure/edit_department/'.$department['group5Code'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                                <a href="<?=base_url('libraries/org_structure/delete_department/'.$department['group5Code'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-edit" title="Delete"></span> Delete</button></a>
                                             
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
            </div>
        </div>
    </div>
    <!--end col-md-9-->
</div>


<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table_executive').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table_executive').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });

        $('#table_division').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table_division').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });
         $('#table_service').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table_service').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });
          $('#table_section').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table_section').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });
          $('#table_department').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table_department').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });

    });
</script>
