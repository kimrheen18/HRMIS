<?=load_plugin('css',array('datatables'));?>
<!-- begin education information -->
<style>th {vertical-align: middle !important;text-align: center;}</style>

<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">
                CAREER SERVICE / RA 1080 (BOARD / BAR) UNDER SPECIAL LAWS / CES / CSEE
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_exam"> <i class="icon-pencil"></i> Add Eligibility </a>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <table class="table table-striped table-bordered table-hover" id="tblexam" style="width: 50% !important;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Exam Description</th>
                        <th>Rating</th>
                        <th>Date of Examination / Conferment</th>
                        <th>Place of Examination / Conferment</th>
                        <th>License Number</th>
                        <th>Date of Validity</th>
                        <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                            <th></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($arrExam as $exam):?>
                        <tr>
                            <td align="center"><?=$no++?></td>
                            <td style="text-align: center;"><?=$exam['examDesc']?></td>
                            <td style="text-align: center;"><?=$exam['examRating']?></td>
                            <td style="text-align: center;"><?=$exam['examDate'] == '0000-00-00' ? '' : $exam['examDate']?></td>
                            <td style="text-align: center;"><?=$exam['examPlace']?></td>
                            <td style="text-align: center;"><?=$exam['licenseNumber']?></td>
                            <td style="text-align: center;"><?=$exam['dateRelease'] == '0000-00-00' ? '' : $exam['dateRelease']?></td>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <td style="width: 150px;" nowrap>
                                    <center>
                                        <a class="btn green btn-xs btnedit_exam" data-json='<?=json_encode($exam)?>'>
                                            <i class="fa fa-pencil"></i> Edit </a>
                                        <a class="btn red btn-xs btndelete_exam" data-toggle="modal" href="#delete_exam" data-examid="<?=$exam['ExamIndex']?>">
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
<?php require 'modal/_examination_info.php'; ?>
<!-- end education information -->
<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#tblexam').dataTable( {pageLength: 5} );

        $('a#btnadd_exam').click(function() {
            $('#frmexam').attr("action","<?=base_url('pds/add_exam/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('#add_exam').modal('show');
            $('#exam_desc').select2('val', '');
            $('#txtrating').val('');
            $('#txtplace_exam').val('');
            $('#txtdate_exam').val('');
            $('#txtlicense').val('');
            $('#txtvalidity').val('');
            $('#txtverifier').val('');
            $('#txtreviewer').val('');

            $('#txtexamid').val('');
        });

        $('#tblexam').on('click','a.btnedit_exam',function() {
            var jsondata = $(this).data('json');
            $('#frmexam').attr("action","<?=base_url('pds/edit_exam/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('#add_exam').modal('show');
            $('#exam_desc').select2('val', jsondata.examCode);
            $('#txtrating').val(jsondata.examRating);
            $('#txtplace_exam').val(jsondata.examPlace);
            $('#txtdate_exam').val(jsondata.examDate);
            $('#txtlicense').val(jsondata.licenseNumber);
            $('#txtvalidity').val(jsondata.dateRelease);
            $('#txtverifier').val(jsondata.verifier);
            $('#txtreviewer').val(jsondata.reviewer);

            $('#txtexamid').val(jsondata.ExamIndex);
        });

        $('#tblexam').on('click','a.btndelete_exam',function() {
            $('#txtdel_exam').val($(this).data('examid'));
        });
    });
</script>