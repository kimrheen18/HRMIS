<?php load_plugin('css',array('datatables'));?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Compensatory Time Off</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <a href="<?=base_url('hr/attendance_summary/dtr/').$arrData['empNumber'].'/?datefrom='.currdfrom().'&dateto='.currdto()?>" class="btn grey-cascade">
                            <i class="icon-calendar"></i> DTR </a>
                        <a class="btn blue" href="<?=base_url('hr/attendance_summary/dtr/compensatory_leave_add/').$arrData['empNumber']?>">
                            <i class="fa fa-plus"></i> Add Compensatory Time Off</a>
                        <br><br>
                        
                        <table class="table table-striped table-bordered table-hover" id="table-comp_leaves">
                            <thead>
                                <th style="width: 50px;">No</th>
                                <th>Date</th>
                                <th>Morning Time</th>
                                <th>Afternoon Time</th>
                                <th>Last Updated By</th>
                                <th>Last Updated Date</th>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrCompLeaves as $compleave): $editby = explode(';',$compleave['name']); $editdate = explode(';',$compleave['editdate']); ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td><?=$compleave['dtrDate']?></td>
                                    <td><?=$compleave['inAM']?> - <?=$compleave['outAM']?></td>
                                    <td><?=$compleave['inPM']?> - <?=$compleave['outPM']?></td>
                                    <td><?=$editby[count($editby)-1]?></td>
                                    <td><?=$editdate[count($editdate)-1]?></td>
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

<?php load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-comp_leaves').dataTable();
    });
</script>