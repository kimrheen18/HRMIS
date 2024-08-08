<?=load_plugin('css', array('datatables'))?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Exclude in DTR</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <a class="btn blue" href="<?=base_url('hr/attendance/override/exclude_dtr_add')?>">
                            <i class="fa fa-plus"></i> Add Employee Exclude in DTR</a>
                        <br><br>
                        <table class="table table-striped table-bordered table-hover" id="tbloverride_excdtr">
                            <thead>
                                <th style="text-align: center;width:10%;">No</th>
                                <th style="text-align: center;">Employees</th>
                                <th style="text-align: center;">Date Added</th>
                                <th style="text-align: center;">Added By</th>
                                <td></td>
                            </thead>
                            <tbody>
                                <?php $no=1;foreach($arr_excdtr as $excdtr): ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td><?php foreach($excdtr['emps'] as $emp): echo '<li>'.employee_name($emp['empNumber']).'</li>'; endforeach;?></td>
                                    <td align="center"><?=date('Y-m-d',strtotime($excdtr['excdtr']['created_date']))?></td>
                                    <td align="center"><?=employee_name($excdtr['excdtr']['created_by'])?></td>
                                    <td width="150px" nowrap>
                                        <center>
                                            <a href="<?=base_url('hr/attendance/override/exclude_dtr_edit/'.$excdtr['excdtr']['override_id'])?>" class="btn green btn-xs">
                                                <i class="fa fa-pencil"></i> Edit</a>
                                            <a class="btn red btn-xs btndelete_excdtr" data-toggle="modal" data-backdrop="static" data-keyboard="false"
                                                href="#modal-deleteExcdtr" data-eid="<?=$excdtr['excdtr']['override_id']?>">
                                                <i class="fa fa-trash"></i> Delete</a>
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

<!-- begin delete ob -->
<div class="modal fade" id="modal-deleteExcdtr" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete</h4>
            </div>
            <?=form_open('hr/override/override_exec_dtr_delete', array('method' => 'post', 'id' => 'frmdelover_ob','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdel_excdtr" id="txtdel_excdtr">
                <div class="modal-body"> Are you sure you want to delete this data? </div>
                <div class="modal-footer">
                    <button type="submit" id="btndelete" class="btn btn-sm green">
                        <i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                        <i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end delete ob -->

<script>
    $(document).ready(function() {
        $('#tbloverride_excdtr').dataTable( {pageLength: 5} );

        $('#tbloverride_excdtr').on('click','a.btndelete_excdtr',function() {
            $('#txtdel_excdtr').val($(this).data('eid'));
        });
    });
</script>