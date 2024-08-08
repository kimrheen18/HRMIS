<?=load_plugin('css',array('datatables'));?>
<!-- begin education information -->
<style>th {vertical-align: middle !important;text-align: center;}</style>

<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">TRAINING PROGRAMS / STUDY / SCHOLARSHIP GRANTS
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_training"> <i class="icon-pencil"></i> Add Training </a>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <table class="table table-striped table-bordered table-hover" id="tbltraining" style="width: 50% !important;">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Title of Learning & Dev./<br> Training Programs</th>
                        <th colspan="2">Inclusive Dates of Attendance</th>
                        <th rowspan="2">Number of Hours</th>
                        <th rowspan="2">Type of Leadership</th>
                        <th rowspan="2">Conducted / Sponsored By</th>
                        <th rowspan="2">Training Venue</th>
                        <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                            <th rowspan="2">Action</th>
                        <?php endif; ?>
                        <th rowspan="2">Attachment/s</th>
                    </tr>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($arrTraining as $tra):?>
                        <tr>
                            <td align="center"><?=$no++?></td>
                            <td style="text-align: center;"><?=$tra['trainingDesc']?></td>
                            <td style="text-align: center;" nowrap><?=$tra['trainingStartDate']?></td>
                            <td style="text-align: center;" nowrap><?=$tra['trainingEndDate']?></td>
                            <td style="text-align: center;"><?=$tra['trainingHours']?></td>
                            <td style="text-align: center;"><?=$tra['trainingTypeofLD']?></td>
                            <td><?=$tra['trainingConductedBy']?></td>
                            <td style="text-align: center;"><?=$tra['trainingVenue']?></td>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <td style="width: 150px;" nowrap>
                                    <center>
                                        <a class="btn green btn-xs btnedit_training" data-json='<?=json_encode($tra)?>'>
                                            <i class="fa fa-pencil"></i> Edit </a>
                                        <a class="btn red btn-xs btndelete_tra" data-toggle="modal" href="#delete_training" data-traid="<?=$tra['TrainingIndex']?>">
                                            <i class="fa fa-trash"></i> Delete </a>
                                    </center>
                                </td>
                                <!-- upload -->
                            <?php endif; ?>
                                <td>
                                <?php 
                                // $folder = 'uploads/employees/attachments/trainings/'.$tra['TrainingIndex']; 
                               
                                //  if (is_dir($folder))
                                //     {
                                //         $map=directory_map($folder);
                                //     }
                                // else 
                                $strFile = 'uploads/employees/attachments/trainings/'.$tra['empNumber'].'/'.$tra['TrainingIndex'].'.pdf'; 
                                if (file_exists($strFile))
                                    {
                                        
                                        echo '<a class="btn blue btn-xs" href="'.base_url($strFile).'" target="new">
                                            <i class="fa fa-file"></i>'.' '.$tra['TrainingIndex'].'.pdf'.' </a>';
                                    }
                                else 
                                { ?>
                                <?=form_open_multipart(base_url('pds/pds/uploadTraining/'.$this->uri->segment(4)), array('method'=> 'post'))?>
                                    <input type ="hidden" name ="idTraining" id= "idTraining" value="<?=$tra['TrainingIndex']?>">
                                    <input type ="hidden" name ="EmployeeId" id= "EmployeeId" value="<?=$tra['empNumber']?>">
                                    <input type ="file" name ="userfile" id= "userfile" accept="application/pdf">
                                    <button type="submit" name="uploadTraining" class="btn blue start">
                                        <i class="fa fa-upload"></i>
                                        <span> Start Upload </span>
                                    </button>
                                <?=form_close();} ?>
                                </td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </tr>
    </table>
</div>
<?php require 'modal/_training_info.php'; ?>
<!-- end education information -->
<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#tbltraining').dataTable( {pageLength: 5} );

        $('a#btnadd_training').click(function() {
            $('#frmtraining').attr("action","<?=base_url('pds/add_training/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('#add_training').modal('show');
            
            $('#txttra_name').val('');
            $('#txttra_hrs').val('');
            $('#txttra_venue').val('');
            $('#seltra_typeld').selectpicker('val', '');
            $('#txttra_sponsored').val('');
            $('#txttra_cost').val('');
            $('#txttra_contract').val('');
            $('#txttra_sdate').val('');
            $('#txttra_edate').val('');

            $('#txttraid').val('');
        });

        $('#tbltraining').on('click','a.btnedit_training',function() {
            var jsondata = $(this).data('json');
            $('#frmtraining').attr("action","<?=base_url('pds/edit_training/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('#add_training').modal('show');
            
            $('#txttra_name').val(jsondata.trainingDesc);
            $('#txttra_hrs').val(jsondata.trainingHours);
            $('#txttra_venue').val(jsondata.trainingVenue);
            $('#seltra_typeld').selectpicker('val', jsondata.trainingTypeofLD);
            $('#txttra_sponsored').val(jsondata.trainingConductedBy);
            $('#txttra_cost').val(jsondata.trainingCost);
            $('#txttra_contract').val(jsondata.trainingContractDate);
            $('#txttra_sdate').val(jsondata.trainingStartDate);
            $('#txttra_edate').val(jsondata.trainingEndDate);

            $('#txttraid').val(jsondata.TrainingIndex);
        });

        $('#tbltraining').on('click','a.btndelete_tra',function() {
            $('#txtdel_tra').val($(this).data('traid'));
        });
    });
</script>