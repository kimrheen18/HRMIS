<?=load_plugin('css',array('datatables'));?>
<!-- begin education information -->
<style>th {vertical-align: middle !important;text-align: center;}</style>

<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">WORK EXPERIENCE (Include Private Employment)
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_workxp"> <i class="icon-pencil"></i> Add Work Experience </a>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <table class="table table-striped table-bordered table-hover" id="tblworkxp" style="width: 50% !important;">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th colspan="2">Inclusive Dates</th>
                        <th rowspan="2">Position Title</th>
                        <th rowspan="2">Department / Agency /<br> Office / Company</th>
                        <th rowspan="2">Monthly</th>
                        <th rowspan="2">Salary / <br>Job Pay Grade</th>
                        <th rowspan="2">Status of<br> Appointment</th>
                        <th rowspan="2">Gov. Service <br>(<i>Yes / No</i>)</th>
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
                    <?php $no=1; foreach($arrService as $srvc):?>
                        <tr>
                            <td align="center"><?=$no++?></td>
                            <td style="text-align: center;" nowrap><?=$srvc['serviceFromDate']?></td>
                            <?php if($srvc['serviceToDate']==''  && $srvc['tmpServiceToDate']=='')
                            {
                                echo '<td> 0000-00-00 </td>';
                            }elseif($srvc['serviceToDate']=='' && $srvc['tmpServiceToDate']=='Present')
                            {
                                 echo '<td>Present</td>';
                            }else{?>
                                <td style="text-align: center;" nowrap><?=$srvc['serviceToDate']?></td>
                            <?php } ?>
                            <td style="text-align: center;"><?=$srvc['positionDesc']?></td>
                            <td style="text-align: center;"><?=$srvc['stationAgency']?></td>
                            <td style="text-align: center;"><?=number_format($srvc['salary'],2)?></td>
                            <td style="text-align: center;"><?=$srvc['salaryGrade']?></td>
                            <td style="text-align: center;"><?=$srvc['appointmentCode']?></td>
                            <td style="text-align: center;"><?=$srvc['governService']?></td>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <td style="width: 150px;" nowrap>
                                    <center>
                                        <a class="btn green btn-xs btnedit_srvc" data-json='<?=json_encode($srvc)?>'>
                                            <i class="fa fa-pencil"></i> Edit </a>
                                        <a class="btn red btn-xs btndelete_srvc" data-toggle="modal" href="#delete_service" data-srvid="<?=$srvc['serviceRecID']?>">
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
<?php require 'modal/_workxp_info.php'; ?>
<!-- end education information -->
<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#tblworkxp').dataTable( {pageLength: 5} );

        $('a#btnadd_workxp').click(function() {
            $('#frmxp').attr("action","<?=base_url('pds/add_work_xp/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('#add_work_xp').modal('show');
            
            $('#txtdfrom').val('');
            $('#txtdto').val('');
            
            $('input#chkpresent').prop('checked', false).uniform('refresh');

            $('#txtposition').val('');
            $('#txtoffice').val('');
            $('#txtsalary').val('');
            $('#selperiod').val('');
            $('#txtcurrency').val('');
            $('#txtgrade').val('');
            $('#selappointment').select2('val', '');
            
            $('div.radio-list').find('#optgov_srvc_n').attr('checked', '');
            $('div.radio-list').find('#optgov_srvc_n').parent().removeClass('checked');
            $('div.radio-list').find('#optgov_srvc_y').attr('checked', '');
            $('div.radio-list').find('#optgov_srvc_y').parent().removeClass('checked');

            $('#selbranch').selectpicker('val', '');
            $('#selmode_separation').select2('val', '');
            $('#txtseparation_date').val('');
            $('#txtabs').val('');
            $('#txtremarks').val('');
            $('#txtprocessor').val('');
            $('#txtofficial').val('');

            $('#txtxpid').val('');
        });

        $('#tblworkxp').on('click','a.btnedit_srvc',function() {
            var jsondata = $(this).data('json');
            $('#frmxp').attr("action","<?=base_url('pds/edit_work_xp/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('#add_work_xp').modal('show');

            $('#txtdfrom').val(jsondata.serviceFromDate);
            $('#txtdto').val(jsondata.serviceToDate);
             // console.log(jsondata.tmpServiceToDate);
            if(jsondata.tmpServiceToDate == "Present"){
                console.log('Present');
                $('input#chkpresent').prop('checked', 'checked').uniform('refresh');
            }else{
                console.log('not present');
                $('input#chkpresent').removeAttr('checked').uniform('refresh');
            }

            // if(jsondata.tmpServiceToDate == "Present" && jsondata.serviceToDate == "Present"){
            //     console.log('Present');
            //     $('input#chkpresent').prop('checked', 'checked').uniform('refresh');
            // }else{
            //     console.log('not present');
            //     $('input#chkpresent').removeAttr('checked').uniform('refresh');
            // }
            $('#txtposition').val(jsondata.positionDesc);
            $('#txtoffice').val(jsondata.stationAgency);
            $('#txtsalary').val(jsondata.salary);
            // $('#selperiod').val(jsondata.salaryPer);
            $('#selperiod').selectpicker('val', jsondata.salaryPer);
            $('#txtcurrency').val(jsondata.currency);
            $('#txtgrade').val(jsondata.salaryGrade);
            $('#selappointment').selectpicker('val', jsondata.appointmentCode);
            $('#selbranch').selectpicker('val', jsondata.branch);
            $('#selmode_separation').select2('val', jsondata.separationCause);
            $('#txtseparation_date').val(jsondata.separationDate);
            $('#txtabs').val(jsondata.lwop);
            $('#txtremarks').val(jsondata.remarks);
            $('#txtprocessor').val(jsondata.processor);
            $('#txtofficial').val(jsondata.signee);
            if(jsondata.governService != 'No'){
                $('div.radio-list').find('#optgov_srvc_y').attr('checked', 'checked');
                $('div.radio-list').find('#optgov_srvc_y').parent().addClass('checked');

                $('div.radio-list').find('#optgov_srvc_n').attr('checked', '');
                $('div.radio-list').find('#optgov_srvc_n').parent().removeClass('checked');
            }else{
                $('div.radio-list').find('#optgov_srvc_n').attr('checked', 'checked');
                $('div.radio-list').find('#optgov_srvc_n').parent().addClass('checked');

                $('div.radio-list').find('#optgov_srvc_y').attr('checked', '');
                $('div.radio-list').find('#optgov_srvc_y').parent().removeClass('checked');
            }

            $('#txtxpid').val(jsondata.serviceRecID);
        });

        $('#tblworkxp').on('click','a.btndelete_srvc',function() {
            $('#txtdel_srv').val($(this).data('srvid'));
        });
    });
</script>