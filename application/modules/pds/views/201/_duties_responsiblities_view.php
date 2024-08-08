<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">
                EMPLOYEE DUTIES AND RESPONSIBILITIES
            </th>
        </tr>
        <tr class="active">
            <td style="line-height: 2;" colspan="4">
                <b>Duties and Responsibilities of Position</b>
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_pos_dr"> <i class="fa fa-plus"></i> Add </a>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>
                <table class="table table-striped table-bordered table-hover" id="tblpos_duties" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Duties and Responsbilities</th>
                            <th width="20%">Percent of Working Time</th>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <th></th>
                            <?php endif; ?>
                            <th style="visibility: hidden;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($position_duties) > 0): foreach($position_duties as $pos_d):?>
                            <tr>
                                <td align="center"><?=$pos_d['dutyNumber']?></td>
                                <td><?=$pos_d['duties']?></td>
                                <td class="percent1" align="center"><?=number_format($pos_d['percentWork'])?></td>
                                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                    <td style="width: 150px;" nowrap>
                                        <center>
                                            <a class="btn green btn-xs btnedit_pos_dr" data-json='<?=json_encode($pos_d)?>'>
                                                <i class="fa fa-pencil"></i> Edit </a>
                                            <a class="btn red btn-xs btndelete_pos_dr" data-drid="<?=$pos_d['duties_index']?>">
                                                <i class="fa fa-trash"></i> Delete </a>
                                        </center>
                                    </td>
                                <?php endif; ?>
                                <td class="total1" style="visibility: hidden;"></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="4" align="center">Not Yet Defined</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr class="active">
            <td style="line-height: 2;" colspan="4">
                <b>Duties and Responsibilities of Plantilla</b>
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_plan_dr"> <i class="fa fa-plus"></i> Add </a>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>
                <table class="table table-striped table-bordered table-hover" id="tblplan_duties" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Duties and Responsbilities</th>
                            <th width="20%">Percent of Working Time</th>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($plantilla_duties) > 0): foreach($plantilla_duties as $plant_d):?>
                            <tr>
                                <td align="center"><?=$plant_d['dutyNumber']?></td>
                                <td><?=$plant_d['itemDuties']?></td>
                                <td class="percent2" align="center"><?=number_format($plant_d['percentWork'])?></td>
                                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                    <td style="width: 150px;" nowrap>
                                        <center>
                                            <a class="btn green btn-xs btnedit_plan_dr" data-json='<?=json_encode($plant_d)?>'>
                                                <i class="fa fa-pencil"></i> Edit </a>
                                            <a class="btn red btn-xs btndelete_plan_dr" data-drid="<?=$plant_d['plantilla_duties_index']?>">
                                                <i class="fa fa-trash"></i> Delete </a>
                                        </center>
                                    </td>
                                <?php endif; ?>
                                <td class="total2" style="visibility: hidden;"></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="4" align="center">Not Yet Defined</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr class="active">
            <td style="line-height: 2;" colspan="4">
                <b>Actual Duties and Responsibilities</b>
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_actual_dr"> <i class="fa fa-plus"></i> Add </a>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>
                <table class="table table-striped table-bordered table-hover" id="tblactual_duties" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Duties and Responsbilities</th>
                            <th width="20%">Percent of Working Time</th>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($actual_duties) > 0): $no=1; foreach($actual_duties as $actual_d):?>
                            <tr>
                                <td align="center"><?=$no++?></td>
                                <td><?=$actual_d['duties']?></td>
                                <td class="percent3" align="center"><?=number_format($actual_d['percentWork'])?></td>
                                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                    <td style="width: 150px;" nowrap>
                                        <center>
                                            <a class="btn green btn-xs btnedit_actual_dr" data-json='<?=json_encode($actual_d)?>'>
                                                <i class="fa fa-pencil"></i> Edit </a>
                                            <a class="btn red btn-xs btndelete_actual_dr" data-drid="<?=$actual_d['empduties_index']?>">
                                                <i class="fa fa-trash"></i> Delete </a>
                                        </center>
                                    </td>
                                <?php endif; ?>
                                <td class="total3" style="visibility: hidden;"></td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="4" align="center">Not Yet Defined</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>

<?php require 'modal/_duties_responsibilities_info.php'; ?>

<script>
    $(document).ready(function() {
        /* duties position */
        $('a#btnadd_pos_dr').on('click',function() {
            $('#frm_edit_dr').attr("action","<?=base_url('pds/add_position_duties/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('span#info-title').html(' - <i>Duties and Responsibilities of Position</i>')
            $('#edit_duties_responsibilities').modal('show');
            
            $('#txtduties').val('');
            $('#txtper_work').val('');
            $('.duty_number').show();
            $('#txtno_duty').val('');

            $('#duties_index').val('');
        });

        $('#tblpos_duties').on('click','a.btnedit_pos_dr',function() {
            var jsondata = $(this).data('json');
            $('#frm_edit_dr').attr("action","<?=base_url('pds/edit_position_duties/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('span#info-title').html('<i>Duties and Responsibilities of Position</i>')
            $('#edit_duties_responsibilities').modal('show');
            
            $('#txtduties').val(jsondata.duties);
            $('#txtper_work').val(jsondata.percentWork);
            $('.duty_number').show();
            $('#txtno_duty').val(jsondata.dutyNumber);

            $('#txtdr_id').val(jsondata.duties_index);
        });

        $('#tblpos_duties').on('click','a.btndelete_pos_dr',function() {
            $('#frmdel_duties').attr("action","<?=base_url('pds/del_position_duties/').$this->uri->segment(3)?>");
            $('#txtdel_drid').val($(this).data('drid'));
            $('#delete_duties').modal('show');
        });

        /* duties plantilla */
        $('a#btnadd_plan_dr').on('click',function() {
            $('#frm_edit_dr').attr("action","<?=base_url('pds/add_plantilla_duties/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('span#info-title').html(' - <i>Duties and Responsibilities of Plantilla</i>')
            $('#edit_duties_responsibilities').modal('show');
            
            $('#txtduties').val('');
            $('#txtper_work').val('');
            $('.duty_number').show();
            $('#txtno_duty').val('');

            $('#duties_index').val('');
        });

        $('#tblplan_duties').on('click','a.btnedit_plan_dr',function() {
            var jsondata = $(this).data('json');
            $('#frm_edit_dr').attr("action","<?=base_url('pds/edit_plantilla_duties/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('span#info-title').html('<i>Duties and Responsibilities of Plantilla</i>')
            $('#edit_duties_responsibilities').modal('show');
            
            $('#txtduties').val(jsondata.itemDuties);
            $('#txtper_work').val(jsondata.percentWork);
            $('.duty_number').show();
            $('#txtno_duty').val(jsondata.dutyNumber);

            $('#txtdr_id').val(jsondata.plantilla_duties_index);
        });

        $('#tblplan_duties').on('click','a.btndelete_plan_dr',function() {
            $('#frmdel_duties').attr("action","<?=base_url('pds/del_plantilla_duties/').$this->uri->segment(3)?>");
            $('#txtdel_drid').val($(this).data('drid'));
            $('#delete_duties').modal('show');
        });

        /* actual plantilla */
        $('a#btnadd_actual_dr').on('click',function() {
            $('#frm_edit_dr').attr("action","<?=base_url('pds/add_actual_duties/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('span#info-title').html(' - <i>Actual Duties and Responsibilities</i>')
            $('#edit_duties_responsibilities').modal('show');
            
            $('#txtduties').val('');
            $('#txtper_work').val('');
            $('.duty_number').hide();
            $('#txtno_duty').val('');

            $('#duties_index').val('');
        });

        $('#tblactual_duties').on('click','a.btnedit_actual_dr',function() {
            var jsondata = $(this).data('json');
            $('#frm_edit_dr').attr("action","<?=base_url('pds/edit_actual_duties/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('span#info-title').html('<i>Actual Duties and Responsibilities</i>')
            $('#edit_duties_responsibilities').modal('show');
            
            $('#txtduties').val(jsondata.duties);
            $('#txtper_work').val(jsondata.percentWork);
            $('.duty_number').hide();
            $('#txtno_duty').val('');

            $('#txtdr_id').val(jsondata.empduties_index);
        });

        $('#tblactual_duties').on('click','a.btndelete_actual_dr',function() {
            $('#frmdel_duties').attr("action","<?=base_url('pds/del_actual_duties/').$this->uri->segment(3)?>");
            $('#txtdel_drid').val($(this).data('drid'));
            $('#delete_duties').modal('show');
        });

    });
</script>

<script type="text/javascript">
   $('.total1').each(function() {
  var sum = 0;
  $(this).parents('table').find('.percent1').each(function() {
    var floted = parseFloat($(this).text());
    if (!isNaN(floted)) sum += floted;
  });

   if (sum > '100') {
        alert("Percent of Working Time must not exceed 100%");
         e.preventDefault();
    } 
  $(this).html(sum);
 
  
});

   $('.total2').each(function() {
  var sum = 0;
  $(this).parents('table').find('.percent2').each(function() {
    var floted = parseFloat($(this).text());
    if (!isNaN(floted)) sum += floted;
  });

   if (sum > '100') {
        alert("Percent of Working Time must not exceed 100%");
         e.preventDefault();
    } 
  $(this).html(sum);
 
  
});

   $('.total3').each(function() {
  var sum = 0;
  $(this).parents('table').find('.percent3').each(function() {
    var floted = parseFloat($(this).text());
    if (!isNaN(floted)) sum += floted;
  });

   if (sum > '100') {
        alert("Percent of Working Time must not exceed 100%");
         e.preventDefault();
    } 
  $(this).html(sum);
 
  
});
</script>