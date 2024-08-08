<?=load_plugin('css',array('datatables'));?>
<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">APPOINTMENT ISSUED
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" id="btnadd_emp_appt" data-toggle="modal" href="#add_appointment_issued"> <i class="fa fa-plus"></i> Add Appointment Issued </a>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <td>
                <table class="table table-striped table-bordered table-hover" id="tblAppointment" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Position</th>
                            <th>Date Issued</th>
                            <th>Date Published</th>
                            <th>Place Issued</th>
                            <th>Relevant Experience</th>
                            <th>Relevant Training</th>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <th></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($arrEmpAppointment as $appt): ?>
                        <tr>
                            <td align="center"><?=$no++?></td>
                            <td><?=$appt['positionDesc']?></td>
                            <td><?=$appt['dateIssued']?></td>
                            <td><?=$appt['datePublished']?></td>
                            <td><?=$appt['placePublished']?></td>
                            <td><?=$appt['relevantExperience']?></td>
                            <td><?=$appt['relevantTraining']?></td>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <td style="width: 200px;" nowrap>
                                    <center>
                                        <a class="btn green btn-xs btnedit_emp_appt" data-json='<?=json_encode($appt)?>'>
                                            <i class="fa fa-pencil"></i> Edit </a>
                                        <a class="btn red btn-xs btndelete_emp_appt" data-toggle="modal" href="#delete_emp_appointment" data-apptid="<?=$appt['appointmentissuedcode']?>">
                                            <i class="fa fa-trash"></i> Delete </a>
                                    </center>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>
<?=load_plugin('js',array('datatables'));?>

<?php require 'modal/_appointment_issue_info.php'; ?>

<script>
    $(document).ready(function() {
        $('#tblAppointment').dataTable( {pageLength: 5} );

        $('#btnview-legal-info').click(function() {
            $('div.radio-list, .btnlegal_info-save').hide();
        });

        $('#btnedit-legal-info').click(function() {
            $('div.radio-list, .btnlegal_info-save').show();
        });

        $('a#btnadd_emp_appt').click(function() {
            $('#frmappointment_issued').attr("action","<?=base_url('pds/add_appointment_issue/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            
            $('#sel_appt_pos').select2("val", '');
            $('#txt_appt_issueddate').val('');
            $('#txt_appt_publisheddate').val('');
            $('#txt_appt_issuedplace').val('');
            $('#txt_appt_relxp').val('');
            $('#txt_appt_reltraining').val('');

            $('#txtappt_id').val('');
        });

        $('#tblAppointment').on('click','a.btnedit_emp_appt',function() {
            var jsondata = $(this).data('json');
            $('#frmappointment_issued').attr("action","<?=base_url('pds/edit_appointment_issue/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('#add_appointment_issued').modal('show');
            
            $('#sel_appt_pos').select2("val", jsondata.positionCode);
            $('#txt_appt_issueddate').val(jsondata.dateIssued);
            $('#txt_appt_publisheddate').val(jsondata.datePublished);
            $('#txt_appt_issuedplace').val(jsondata.placePublished);
            $('#txt_appt_relxp').val(jsondata.relevantExperience);
            $('#txt_appt_reltraining').val(jsondata.relevantTraining);

            $('#txtappt_id').val(jsondata.appointmentissuedcode);
        });

        $('#tblAppointment').on('click','a.btndelete_emp_appt',function() {
            $('#txtdel_appt').val($(this).data('apptid'));
        });

    });
</script>

