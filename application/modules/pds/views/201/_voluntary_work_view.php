<?=load_plugin('css',array('datatables'));?>
<!-- begin voluntary information -->
<style>th {vertical-align: middle !important;text-align: center;}</style>

<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">
                VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_vol"> <i class="icon-pencil"></i> Add Voluntary Work </a>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <table class="table table-striped table-bordered table-hover" id="tblvol_work" style="width: 50% !important;">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Name of Organization</th>
                        <th rowspan="2">Address</th>
                        <th colspan="2">Inclusive Dates</th>
                        <th rowspan="2">Number of Hours</th>
                        <th rowspan="2">Position/Nature of work</th>
                        <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                            <th rowspan="2">Action</th> 
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($arrVol as $vol):?>
                        <tr>
                            <td align="center"><?=$no++?></td>
                            <td style="text-align: center;"><?=$vol['vwName']?></td>
                            <td style="text-align: center;"><?=$vol['vwAddress']?></td>
                            <td style="text-align: center;" nowrap><?=$vol['vwDateFrom']?></td>
                            <td style="text-align: center;" nowrap><?=$vol['vwDateTo']?></td>
                            <td style="text-align: center;"><?=$vol['vwHours']?></td>
                            <td style="text-align: center;"><?=$vol['vwPosition']?></td>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <td style="width: 150px;" nowrap>
                                    <center>
                                        <a class="btn green btn-xs btnedit_vol" data-json='<?=json_encode($vol)?>'>
                                            <i class="fa fa-pencil"></i> Edit </a>
                                        <a class="btn red btn-xs btndelete_vol" data-toggle="modal" href="#delete_volwork" data-workid="<?=$vol['VoluntaryIndex']?>">
                                            <i class="fa fa-trash"></i> Delete </a>
                                    </center>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </tr>
    </table>
</div>
<?php require 'modal/_voluntary_work_info.php'; ?>
<!-- end voluntary information -->
<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#tblvol_work').dataTable( {pageLength: 5} );

        $('a#btnadd_vol').click(function() {
            $('#frmvolwork').attr("action","<?=base_url('pds/add_vol_work/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('#add_vol_work').modal('show');
            
            $('#txtorganization').val('');
            $('#txtaddress').val('');
            $('#txtdfrom_vl').val('');
            $('#txtdto_vl').val('');
            $('#txthrs').val('');
            $('#txtwork').val('');

            $('#txtvolid').val('');
        });

        $('#tblvol_work').on('click','a.btnedit_vol',function() {
            var jsondata = $(this).data('json');
            $('#frmvolwork').attr("action","<?=base_url('pds/edit_vol_work/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('#add_vol_work').modal('show');

            $('#txtorganization').val(jsondata.vwName);
            $('#txtaddress').val(jsondata.vwAddress);
            $('#txtdfrom_vl').val(jsondata.vwDateFrom);
            $('#txtdto_vl').val(jsondata.vwDateTo);
            $('#txthrs').val(jsondata.vwHours);
            $('#txtwork').val(jsondata.vwPosition);

            $('#txtvolid').val(jsondata.VoluntaryIndex);
        });

        $('#tblvol_work').on('click','a.btndelete_vol',function() {
            $('#txtdelvolid').val($(this).data('workid'));
        });
    });
</script>