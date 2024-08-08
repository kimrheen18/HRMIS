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
            <span>Signatory</span>
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
                            <span class="caption-subject bold uppercase"> Signatory</span>
                        </div>
                    </div>
                
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?=base_url('finance/libraries/signatory/add')?>" class="btn sbold blue"> <i class="fa fa-plus"></i> Add New </a>
                                </div>
                            </div>
                        </div>
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-signatory" style="display: none">
                            <thead>
                                <tr>
                                    <tr>
                                        <th style="text-align: center; width: 75px;"> No. </th>
                                        <th style="text-align: center;"> Signatory </th>
                                        <th style="text-align: center;"> Position </th>
                                        <th style="text-align: center;width:170px;" class="no-sort"> Actions </th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($signatories as $data): ?>
                                    <tr class="odd gradeX">
                                        <td><?=$no++?> </td>
                                        <td><?=$data['signatory']?></td>
                                        <td><?=$data['signatoryPosition']?></td>
                                        <td align="center" nowrap>
                                            <a href="<?=base_url('finance/libraries/signatory/edit/'.$data['signatoryId'])?>" class="btn btn-sm green">
                                                <span class="fa fa-edit" title="Edit"></span> Edit</a>
                                            <a href="<?=base_url('finance/libraries/signatory/delete_signatory/'.$data['signatoryId'])?>" class="btn btn-sm btn-danger"><span class="fa fa-trash" title="Delete"></span> Delete</a>
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
        $('#table-signatory').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-signatory').show();
            },"columnDefs" : [{ "orderable": false, "target": 'no-sort'}]
        });
    });
</script>