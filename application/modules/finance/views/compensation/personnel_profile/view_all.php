<?=load_plugin('css',array('datatables'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Compensation</span>
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
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> List of Employees</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-employees" style="display: none">
                            <thead>
                                <tr>
                                    <th> No. </th>
                                    <th> Employee Number </th>
                                    <th> Name </th>
                                    <th> Office </th>
                                    <th> Position </th>
                                    <th style="text-align: center;"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrEmployees as $row): ?>
                                    <tr class="odd gradeX ">
                                        <td><?=$no++?> </td>
                                        <td> <?=$row['empNumber']?></a> </td>
                                        <?php if($row['middleInitial']=="") 
                                            {
                                                echo '<td>'.$row['surname'].', '.$row['firstname'].'</td>'; ?>
                                            <?php } else {
                                                 echo '<td>'.$row['surname'].', '.$row['firstname'].' '.$row['middleInitial']?><?=strpos($row['middleInitial'], '.') !== false?'':'.'.' '.$row['nameExtension'].'</td>'; ?>
                                            <?php } ?>
                                        <td> <?=employee_office($row['empNumber'])?> </td>
                                        <td> <?=$row['positionDesc']?></td>
                                        <td style="text-align: center;"> <a href="<?=base_url('finance/compensation/personnel_profile/employee').'/'.$row['empNumber']?>" class="btn btn-sm blue"> <i class="fa fa-eye"></i>  View</a></td>
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
        $('#table-employees').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-employees').show();
            }} );
    });
</script>