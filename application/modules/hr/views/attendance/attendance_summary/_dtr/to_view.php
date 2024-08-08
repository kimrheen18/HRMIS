<?php load_plugin('css',array('datatables'));?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Travel Order</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <a href="<?=base_url('hr/attendance_summary/dtr/').$arrData['empNumber'].'/?datefrom='.currdfrom().'&dateto='.currdto()?>" class="btn grey-cascade">
                            <i class="icon-calendar"></i> DTR </a>
                        <a class="btn blue" href="<?=base_url('hr/attendance_summary/dtr/to_add/').$arrData['empNumber']?>">
                            <i class="fa fa-plus"></i> Add TO</a>
                        <br><br>
                        <table class="table table-striped table-bordered table-hover" id="table-to">
                            <thead>
                                <tr>
                                    <th width="30px;">No</th>
                                    <th>Destination</th>
                                    <th>Date</th>
                                    <th>Purpose</th>
                                    <th>Source of Fund</th>
                                    <th>Transportation</th>
                                    <th>Will Claim Perdiem</th>
                                    <th>With Meal</th>
                                    <th width="150px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrempTo as $to): ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td><?=$to['destination']?></td>
                                    <td><?=$to['toDateFrom']?> &nbsp;<i>to</i>&nbsp; <?=$to['toDateTo']?></td>
                                    <td><?=$to['purpose']?></td>
                                    <td><?=$to['fund']?></td>
                                    <td><?=$to['transportation']?></td>
                                    <td align="center"><?=$to['perdiem'] == 'Y' ? 'Yes' : 'No'?></td>
                                    <td align="center"><?=$to['wmeal'] == 'Y' ? 'Yes' : 'No'?></td>
                                    <td align="center">
                                        <a href="<?=base_url('hr/attendance_summary/dtr/to_edit/'.$this->uri->segment(5).'?id='.$to['toID'])?>" class="btn green btn-sm"> <i class="fa fa-pencil"></i> Edit</a>
                                        <button class="btn red btn-sm btn-delete" data-id="<?=$to['toID']?>">
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

<div id="modal-deleteTo" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Travel Order</h4>
            </div>
            <?=form_open('hr/attendance/dtr_delete_to/'.$this->uri->segment(5), array('id' => 'frmdelete'))?>
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
        $('#table-to').dataTable();
        $('#table-to').on('click', 'button.btn-delete', function() {
            $('#txtdel_action').val($(this).data('id'));
            $('#modal-deleteTo').modal('show');
        });
    });
</script>