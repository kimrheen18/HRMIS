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
            <span>Income</span>
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
                            <span class="caption-subject bold uppercase"> Income</span>
                        </div>
                    </div>
                
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?=base_url('finance/libraries/income/add')?>" id="sample_editable_1_new" class="btn sbold blue">
                                        <i class="fa fa-plus"></i> Add New </a>
                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn green btn-outline dropdown-toggle" data-toggle="dropdown"> <?=$status[0][0]?> <i class="fa fa-angle-down"></i> </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li> <a href="<?=base_url('finance/libraries/income/'.$status[1][1])?>"> <?=$status[1][0]?></a> </li>
                                            <li> <a href="<?=base_url('finance/libraries/income/'.$status[2][1])?>"> <?=$status[2][0]?></a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-income" style="display: none">
                            <thead>
                                <tr>
                                    <tr>
                                        <th> No. </th>
                                        <th> Income Code </th>
                                        <th> Income Description </th>
                                        <th> Income Type </th>
                                        <th> Status </th>
                                        <th style="text-align: center;width:170px;" class="no-sort"> Actions </th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($income as $data): ?>
                                    <tr class="odd gradeX <?=$data['hidden'] == 1 ? 'inactive' : ''?>">
                                        <td><?=$no++?> </td>
                                        <td><?=$data['incomeCode']?> </td>
                                        <td><?=$data['incomeDesc']?> </td>
                                        <td><?=$data['incomeType']?> </td>
                                        <td><?=$data['hidden'] == 1 ? 'Inactive' : 'Active' ?> </td>
                                        <td align="center" nowrap>
                                            <a href="<?=base_url('finance/libraries/income/edit/'.$data['incomeCode'].'?stat='.$data['hidden'])?>" class="btn btn-sm green">
                                                <span class="fa fa-edit" title="Edit"></span> Edit</a>
                                            <a href="<?=base_url('finance/libraries/income/delete_income/'.$data['income_id'])?>" class="btn btn-sm btn-danger"><span class="fa fa-trash" title="Delete"></span> Delete</a>
                                        </td>
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

<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-income').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-income').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });
    });
</script>