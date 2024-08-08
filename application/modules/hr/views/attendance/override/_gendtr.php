<?=load_plugin('css', array('datatables'))?>
<?php 
    $datefrom = date('Y-m').'-01';
    $dateto = date('Y-m').'-'.cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
 ?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Generate DTR</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <a class="btn blue" href="<?=base_url('hr/attendance/override/generate_dtr_allemp')?>">
                            <i class="fa fa-refresh"></i> Generate Employee DTR</a>
                        <br><br>
                        <table class="table table-striped table-bordered table-hover" id="tbloverride_gendtr">
                            <thead>
                                <th style="text-align: center;width:15%;">No</th>
                                <th style="text-align: center;width:25%;">Employee Number</th>
                                <th style="text-align: center;">Employee</th>
                                <td></td>
                            </thead>
                            <tbody>
                                <?php $no=1;foreach($arrEmployees as $emp): $empname = getfullname($emp['firstname'], $emp['surname'], $emp['middlename'], $emp['middleInitial'],'');?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td><?=$emp['empNumber']?></td>
                                    <td style="white-space:nowrap;"><?=$empname?></td>
                                    <td width="150px" style='white-space:nowrap;'>
                                        <center>
                                            <a href="<?=base_url('hr/attendance_summary/dtr/'.$emp['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto)?>" class="btn btn-sm grey-cascade"> <i class="icon-calendar"></i>&nbsp; View DTR </a>
                                            <a class="btn blue btn-sm btngen_dtr" data-toggle="modal" href="#modal-gen-dtr"
                                                data-empid="<?=$emp['empNumber']?>"
                                                data-empname="<?=$empname?>">
                                                <i class="fa fa-refresh"></i> Generate DTR</a>
                                            <a class="btn green btn-sm btninc_dtr" data-toggle="modal" href="#modal-inc-dtr"
                                                data-empid="<?=$emp['empNumber']?>"
                                                data-empname="<?=$empname?>">
                                                <i class="fa fa-check"></i> Include in DTR</a>
                                        </center>
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
<?=load_plugin('js', array('datatables'))?>
<?php require 'modal/_gendtr_modal.php'; ?>

<script>
    $(document).ready(function() {
        $('#tbloverride_gendtr').dataTable();

        $('#tbloverride_gendtr').on('click','a.btninc_dtr',function() {
            $('#txtempinc_id').val($(this).data('empid'));
            $('#empname').html($(this).data('empname'));
        });

        $('#tbloverride_gendtr').on('click','a.btngen_dtr',function() {
            $('#txtgendtr_empnum').val($(this).data('empid'));
            $('#empname_gen').html($(this).data('empname'));
        });
    });
</script>