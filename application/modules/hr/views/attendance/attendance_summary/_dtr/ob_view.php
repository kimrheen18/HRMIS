<?php load_plugin('css',array('datatables'));?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Official Business</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <a href="<?=base_url('hr/attendance_summary/dtr/').$arrData['empNumber'].'/?datefrom='.currdfrom().'&dateto='.currdto()?>" class="btn grey-cascade">
                            <i class="icon-calendar"></i> DTR </a>
                        <a class="btn blue" href="<?=base_url('hr/attendance_summary/dtr/ob_add/').$arrData['empNumber']?>">
                            <i class="fa fa-plus"></i> Add OB</a>
                        <br><br>
                        <table class="table table-striped table-bordered table-hover" id="table-ob">
                            <thead>
                                <th>No</th>
                                <th>Date Filed</th>
                                <th>Place</th>
                                <th>Purpose</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <td></td>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrObs as $ob): ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td><?=$ob['dateFiled']?></td>
                                    <td><?=$ob['obPlace']?></td>
                                    <td><?=$ob['purpose']?></td>
                                    <td><?=$ob['obDateFrom']?> <?=$ob['obTimeFrom']?></td>
                                    <td><?=$ob['obDateTo']?> <?=$ob['obTimeTo']?></td>
                                    <td align="center" nowrap>
                                        <a href="<?=base_url('hr/attendance_summary/dtr/ob_edit/'.$this->uri->segment(5).'?id='.$ob['obID'])?>" class="btn green btn-sm"> <i class="fa fa-pencil"></i> Edit</a>
                                        <button class="btn red btn-sm btn-delete" data-id="<?=$ob['obID']?>">
                                            <i class="fa fa-trash"></i> Delete</button>
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

<div id="modal-deleteOB" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete OB</h4>
            </div>
            <?=form_open('hr/attendance/dtr_delete_ob/'.$this->uri->segment(5), array('id' => 'frmdelete'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtdel_action" id="txtdel_action">
                            <div class="form-group">
                                <label>Are you sure you want to Delete this data?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-payrollDetails" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<?php load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-ob').dataTable();
        $('#table-ob').on('click', 'button.btn-delete', function() {
            $('#txtdel_action').val($(this).data('id'));
            $('#modal-deleteOB').modal('show');
        });
    });
</script>