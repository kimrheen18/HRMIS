<?=load_plugin('css',array('datatables'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?=$this->session->userdata('sessUserLevel')==1 ? 'HR' : 'Finance'?> Module</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Update</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>OR Remittances</span>
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
                            <span class="caption-subject bold uppercase"> OR Remittances</span>
                        </div>
                    </div>
                
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?=base_url('finance/payroll_update/update_or?mode=add')?>" class="btn sbold blue"> <i class="fa fa-plus"></i> Add OR Remittance </a>
                                </div>
                            </div>
                        </div>
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-signatory" style="display: none">
                            <thead>
                                <tr>
                                    <tr>
                                        <th style="text-align: center; width: 75px;"> No. </th>
                                        <th style="text-align: center;"> Date </th>
                                        <th style="text-align: left;"> Deduction </th>
                                        <th style="text-align: left;"> OR Number </th>
                                        <th style="text-align: center;"> OR Date </th>
                                        <th style="text-align: center;width:170px;" class="no-sort"> Actions </th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arr_orlist as $data): ?>
                                    <tr class="odd gradeX">
                                        <td><?=$no++?> </td>
                                        <td align="center"><?=date('M', mktime(0, 0, 0, $data['deductMonth'], 10)).' '.$data['deductYear']?></td>
                                        <td> &nbsp; <?=$data['deductionDesc']?></td>
                                        <td> &nbsp; <?=$data['orNumber']?></td>
                                        <td align="center"><?=$data['orDate']?></td>
                                        <td align="center" nowrap>
                                            <a href="<?=base_url('finance/payroll_update/update_or?remitt_id='.$data['remitt_id'].'&mode=edit')?>" class="btn btn-sm green">
                                                <span class="fa fa-edit" title="Edit"></span> Edit</a>
                                            <a class="btn btn-sm btn-danger" id="btnDelRemitt" data-code="<?=$data['remitt_id']?>">
                                                <span class="fa fa-trash" title="Delete"></span> Delete</a>
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
<div class="modal fade" id="delete" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <?=form_open('finance/payroll_update/payrollupdate/or_delete', array('method' => 'post'))?>
            <input type="hidden" name="txtremitt_id" id="txtremitt_id">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete OR Remittance</h4>
            </div>
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

<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-signatory').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-signatory').show();
            },"columnDefs" : [{ "orderable": false, "target": 'no-sort'}]
        });

        var code = '';
        $('#table-signatory').on('click', 'tr > td > a#btnDelRemitt', function () {
            code = $(this).data('code');
            $('#txtremitt_id').val(code);
            $('#delete').modal('show');
        });

    });
</script>