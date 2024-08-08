<?=load_plugin('css', array('datatables'))?>
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
                        <a class="btn blue" href="<?=base_url('hr/attendance/override/ob_add')?>">
                            <i class="fa fa-plus"></i> Add OB</a>
                        <br><br>
                        <table class="table table-striped table-bordered table-hover" id="tbloverride_ob">
                            <thead>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Date Filed</th>
                                <th>Place</th>
                                <th>Purpose</th>
                                <th style="text-align: center;">Date From</th>
                                <th style="text-align: center;">Date To</th>
                                <td></td>
                            </thead>
                            <tbody>
                                <?php $no=1;foreach($arr_ob as $ob): ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td align="center"><?=$ob['dateFiled']?></td>
                                    <td><?=$ob['obPlace']?></td>
                                    <td><?=$ob['purpose']?></td>
                                    <td align="center"><?=$ob['obDateFrom']?> <?=date('g:i A', strtotime($ob['obTimeFrom']))?></td>
                                    <td align="center"><?=$ob['obDateTo']?> <?=date('g:i A', strtotime($ob['obTimeTo']))?></td>
                                    <td width="150px" nowrap>
                                        <center>
                                            <a href="<?=base_url('hr/attendance/override/ob_edit/'.$ob['obID'])?>" class="btn green btn-xs">
                                                <i class="fa fa-pencil"></i> Edit</a>
                                            <a class="btn red btn-xs btndelete_overob" data-toggle="modal" data-backdrop="static" data-keyboard="false"
                                                href="#modal-deleteOB" data-oid="<?=$ob['obID']?>">
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
<div class="modal fade" id="modal-deleteOB" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete</h4>
            </div>
            <?=form_open('hr/override/override_ob_delete', array('method' => 'post', 'id' => 'frmdelover_ob','class' => 'form-horizontal'))?>
                <input type="hidden" name="txtdelover_ob" id="txtdelover_ob">
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
        $('#tbloverride_ob').dataTable( {pageLength: 5} );

        $('#tbloverride_ob').on('click','a.btndelete_overob',function() {
            $('#txtdelover_ob').val($(this).data('oid'));
        });
    });
</script>