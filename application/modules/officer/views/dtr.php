<?php
    load_plugin('css',array('datatables'));
    $datefrom = date('Y-m').'-01';
    $dateto = date('Y-m').'-'.cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Attendance</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Employees' DTR</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<br>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Employees' DTR</span>
                </div>
            </div>
            
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <table class="table table-striped table-bordered table-hover" id="table-employees">
                            <thead>
                                <th width="50px;">No</th>
                                <th>Employee</th>
                                <th>Dates with Incomplete Attendance</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arremployees as $employee): ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td><?=getfullname($employee['empdetails']['firstname'], $employee['empdetails']['surname'], $employee['empdetails']['middlename'], $employee['empdetails']['middleInitial'])?></td>
                                    <td style="width: 75%;">
                                        <?php
                                            foreach($employee['absents'] as $absent):
                                                echo date('d', strtotime($absent)).' ';
                                            endforeach;
                                            if(count($employee['absents']) > 0):
                                                echo '&nbsp;&nbsp;<a class="btn btn-xs default" data-toggle="modal" data-backdrop="static" data-keyboard="false" href="#absents-modal"> ...</a>';
                                            endif;
                                        ?>
                                    </td>
                                    <td><center>
                                        <a href="<?=base_url('hr/attendance_summary/dtr/').$employee['empdetails']['empNumber'].'?mode=employee&month='.(currmo() == 'all' ? date('m') : currmo()).'&yr='.curryr()?>"
                                            class="btn btn-sm grey-cascade"> <i class="icon-calendar"></i>&nbsp; View DTR </a>
                                    </center></td>
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

<!-- begin absents modal -->
<div id="absents-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Date(s) Absent</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <ul>
                                <?php
                                    foreach($employee['absents'] as $absent):
                                        echo '<li>'.date('M d, Y (D)', strtotime($absent)).'</li>';
                                    endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php 
                    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
                    $yr = isset($_GET['yr']) ? $_GET['yr'] : date('Y');
                 ?>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"><i class="icon-close"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end absents modal -->

<?php load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-employees').dataTable();
    });
</script>