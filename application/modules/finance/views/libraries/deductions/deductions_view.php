<?=load_plugin('css',array('datatables'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Libraries</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Deduction</span>
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
                        <a href="#tab-deduction" data-toggle="tab">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> Deductions</span>
                            </div>
                        </a>
                    </li>
                    <li class="<?=isset($_GET['tab']) ? 'active' : ''?>">
                        <a href="#tab-agency" data-toggle="tab">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> Agency </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="tab-deduction" class="tab-pane <?=isset($_GET['tab']) ? '' : 'active'?>" v-cloak>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN DEDUCTION -->
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?=base_url('finance/libraries/deductions/add')?>" id="sample_editable_1_new" class="btn sbold blue"><i class="fa fa-plus"></i> Add New </a>
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn green btn-outline dropdown-toggle" data-toggle="dropdown"> <?=ucfirst($allstat[$curr_status])?> <i class="fa fa-angle-down"></i> </button>
                                                <ul class="dropdown-menu pull-right" role="menu">
                                                    <?php foreach($arrstatus as $link => $link_stat): ?>
                                                        <li> <a href="<?=base_url('finance/libraries/deductions/?status='.$link)?>"> Show <?=ucfirst($link_stat)?></a> </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-deductions" style="display: none">
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                            <th> Agency </th>
                                            <th> Code </th>
                                            <th> Description </th>
                                            <th> Account Code </th>
                                            <th> Type </th>
                                            <th> Status </th>
                                            <th style="text-align: center;width:170px;" class="no-sort"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach($deductions as $data): ?>
                                        <tr class="odd gradeX <?=$data['hidden'] == 1 ? 'inactive' : ''?>">
                                            <td><?=$no++?> </td>
                                            <td><?=$data['deductionGroupCode']?> </td>
                                            <td><?=$data['deductionCode']?> </td>
                                            <td><?=$data['deductionDesc']?> </td>
                                            <td><?=$data['deductionAccountCode']?> </td>
                                            <td><?=$data['deductionType']?> </td>
                                            <td><?=$data['hidden'] == 1 ? 'Inactive' : 'Active' ?> </td>
                                            <td align="center" nowrap>
                                                <a href="<?=base_url('finance/libraries/deductions/edit/'.$data['deduction_id'].'?stat='.$data['hidden'])?>"><button class="btn btn-sm green"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                                <a href="<?=base_url('finance/libraries/deductions/delete/'.$data['deduction_id'])?>" class="btn btn-sm btn-danger"><span class="fa fa-trash" title="Delete"></span> Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END DEDUCTION -->
                    </div>
                </div>
            </div>
            <div id="tab-agency" class="tab-pane <?=isset($_GET['tab']) == 'agency' ? 'active' : '' ?>">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?=base_url('finance/libraries/agency/add?tab=agency')?>" id="sample_editable_1_new" class="btn sbold blue"> <i class="fa fa-plus"></i> Add New </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-agency" style="display: none">
                                    <thead>
                                        <tr>
                                            <th> No. </th>
                                            <th> Agency Code </th>
                                            <th> Agency Description </th>
                                            <th> Account Code </th>
                                            <th style="text-align: center;width:170px;" class="no-sort"> Actions </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1; foreach($agency as $data): ?>
                                        <tr class="odd gradeX ">
                                            <td><?=$no++?> </td>
                                            <td><?=$data['deductionGroupCode']?> </td>
                                            <td><?=$data['deductionGroupDesc']?> </td>
                                            <td><?=$data['deductionGroupAccountCode']?> </td>
                                            <td align="center" nowrap>
                                                <a href="<?=base_url('finance/libraries/agency/edit/'.$data['deduct_id'])?>"><button class="btn btn-sm green"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                                <a href="<?=base_url('finance/libraries/agency/delete/'.$data['deduct_id'])?>" class="btn btn-sm btn-danger"><span class="fa fa-trash" title="Delete"></span> Delete</a>
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
            </div>
        </div>
    </div>
    <!--end col-md-9-->
</div>

<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-deductions').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-deductions').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });

        $('#table-agency').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-agency').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });
        
    });
</script>
