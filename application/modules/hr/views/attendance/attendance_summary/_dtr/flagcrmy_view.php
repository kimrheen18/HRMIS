<?php load_plugin('css',array('datatables'));?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Flag Ceremony</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <a href="<?=base_url('hr/attendance_summary/dtr/').$arrData['empNumber'].'/?datefrom='.currdfrom().'&dateto='.currdto()?>" class="btn grey-cascade">
                            <i class="icon-calendar"></i> DTR </a>
                        <a class="btn blue" href="<?=base_url('hr/attendance_summary/dtr/flagcrmy_add/').$arrData['empNumber']?>">
                            <i class="fa fa-plus"></i> Add Entry</a>
                        <br><br>
                        <table class="table table-striped table-bordered table-hover" id="table-fc">
                            <thead>
                                <tr>
                                    <th width="30px;">No</th>
                                    <th>Date</th>
                                    <th>Time in</th>
                                    <th>Last Updated By</th>
                                    <th>Last Updated Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrflgcrmy as $fc): $editby = explode(';',$fc['name']); $editdate = explode(';',$fc['editdate']); ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td><?=$fc['dtrDate']?></td>
                                    <td><?=$fc['inAM']?></td>
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
        $('#table-fc').dataTable();
    });
</script>