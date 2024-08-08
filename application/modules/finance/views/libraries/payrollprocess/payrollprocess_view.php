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
            <span>Payroll Process</span>
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
                            <span class="caption-subject bold uppercase"> Payroll Process</span>
                        </div>
                    </div>
                
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?=base_url('finance/libraries/payrollprocess/add')?>" class="btn sbold blue">
                                        <i class="fa fa-plus"></i> Add New </a>
                                </div>
                            </div>
                        </div>
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-pprocess" style="display: none">
                            <thead>
                                <tr>
                                    <tr>
                                        <th style="text-align: center;width:70px;"> No </th>
                                        <th> Appointment </th>
                                        <th> Process With </th>
                                        <th> Salary </th>
                                        <th style="text-align: center;width:170px;" class="no-sort"> Actions </th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrPayrollProc as $proc): ?>
                                    <tr class="odd gradeX">
                                        <td><?=$no++?></td>
                                        <td><?=$proc['appointmentDesc']?></td>
                                        <td><?php 
                                                $processwith = explode(',',$proc['processWith']);
                                                foreach($processwith as $pw):
                                                    $key = array_search($pw, array_column($arrAppointments, 'appointmentCode'));
                                                    echo '<li>'.$arrAppointments[$key]['appointmentDesc'].'</li>';
                                                endforeach;
                                             ?>
                                        </td>
                                        <td><?=$proc['computation']?></td>
                                        <td align="center" nowrap>
                                            <a href="<?=base_url('finance/libraries/payrollprocess/edit/'.$proc['process_id'])?>" class="btn btn-sm green">
                                                <span class="fa fa-edit" title="Edit"></span> Edit</a>
                                             <a href="<?=base_url('finance/libraries/payrollprocess/delete_process/'.$proc['process_id'])?>" class="btn btn-sm btn-danger"><span class="fa fa-trash" title="Delete"></span> Delete</a>
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
        $('#table-pprocess').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-pprocess').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });
    });
</script>