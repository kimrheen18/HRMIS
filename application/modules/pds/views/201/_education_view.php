<?=load_plugin('css',array('datatables'));?>
<!-- begin education information -->
<style>th {vertical-align: middle !important;text-align: center;}</style>

<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">EDUCATION INFORMATION
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_educ"> <i class="icon-pencil"></i> Add Education </a>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <table class="table table-striped table-bordered table-hover" id="tbleduc" style="width: 50% !important;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Level Code</th>
                        <th>Name of School</th>
                        <th>Basic Education /<br> Degree / Course</th>
                        <th>Period of Attendance<br> [From / To]</th>
                        <th>Highest Level /<br> Units Earned</th>
                        <th>Year <br> Graduated</th>
                        <th>Scholarship /<br> Honors Received</th>
                        <th>Graduate</th>
                        <th>Licensed</th>
                        <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                            <th>Action</th>
                        <?php endif; ?>
                            <th>Attachment/s</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1;
                        foreach($arrEduc as $educ): 
                        $schlrship = $educ['description'];
                        $honor = $educ['honors'];
                        $schdatefrom = $educ['schoolFromDate']!='' ? 'From '.$educ['schoolFromDate'] : '';
                        $schdateto = $educ['schoolToDate']!='' ? 'to '.$educ['schoolToDate'] : '';
                        $schl_honor = $schlrship!='' && $honor!='' ? $schlrship.' / '.$honor:'';
                        $schl_dates = $schdatefrom!='' && $schdateto!='' ? $schdatefrom.' '.$schdateto:''; ?>
                        <tr>
                            <td align="center"><?=$no++?></td>
                            <td style="text-align: center;"><?=$educ['levelCode']?></td>
                            <td><?=$educ['schoolName']?></td>
                            <td style="text-align: center;"><?=$educ['course']?></td>
                            <td style="text-align: center;"><?=$schl_dates!= ''?$schl_dates : $schdatefrom.$schdateto?></td>
                            <td style="text-align: center;"><?=$educ['units']?></td>
                            <td style="text-align: center;"><?=$educ['yearGraduated']?></td>
                            <td><?=$schl_honor!= ''?$schl_honor : $schlrship.$honor?></td>
                            <td style="text-align: center;"><?=$educ['graduated']?></td>
                            <td style="text-align: center;"><?=$educ['licensed']?></td>
                            <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                <td style="width: 150px;" nowrap>
                                    <center>
                                        <a class="btn green btn-xs btnedit_educ" data-json='<?=json_encode($educ)?>'>
                                            <i class="fa fa-pencil"></i> Edit </a>
                                        <a class="btn red btn-xs btndelete_educ" data-educid="<?=$educ['SchoolIndex']?>">
                                            <i class="fa fa-trash"></i> Delete </a>
                                    </center>
                                </td>
                                <!-- upload -->
                             <?php endif; ?>
                                <td>
                                <?php 
                                $strFile = 'uploads/employees/attachments/educ/'.$educ['empNumber'].'/'.$educ['SchoolIndex'].'.pdf'; 
                                $name = $educ['SchoolIndex'].'.pdf'; 

                                 if (file_exists($strFile))
                                    {
                                        
                                        echo '<a class="btn blue btn-xs" href="'.base_url($strFile).'" target="new">
                                            <i class="fa fa-file"></i>'.$name.' </a>';
                                    }
                                else 
                                { ?>
                                <?=form_open_multipart(base_url('pds/pds/uploadEduc/'.$this->uri->segment(4)), array('method'=> 'post'))?>
                                    <input type ="hidden" name ="idEduc" id= "idEduc" value="<?=$educ['SchoolIndex']?>">
                                    <input type ="hidden" name ="EmployeeId" id= "EmployeeId" value="<?=$educ['empNumber']?>">
                                    <input type ="file" name ="userfile" id= "userfile" accept="application/pdf">
                                    <button type="submit" name="uploadEduc" class="btn blue start">
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
<?php require 'modal/_education_info.php'; ?>
<!-- end education information -->
<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#tbleduc').dataTable( {pageLength: 5} );

        $('a#btnadd_educ').click(function() {
            $('#frmeduc').attr("action","<?=base_url('pds/add_educ/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('#add_education').modal('show');
        });

        $('#tbleduc').on('click','a.btnedit_educ',function() {
            var jsondata = $(this).data('json');
            $('#frmeduc').attr("action","<?=base_url('pds/edit_educ/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('#add_education').modal('show');
            $('#sellevel').selectpicker('val', jsondata.levelCode);
            $('#txtschool').val(jsondata.schoolName);
            $('#seldegree').select2('val', jsondata.course);
            $('#selscholarship').select2('val', jsondata.ScholarshipCode);
            $('#txthonors').val(jsondata.honors);
            $('#txtyrgraduate').val(jsondata.yearGraduated);
            $('#txtperiodatt_from').val(jsondata.schoolFromDate);
            $('#txtperiodatt_to').val(jsondata.schoolToDate);
            $('#txtunits').val(jsondata.units);

             if(jsondata.licensed == 'Y'){
                $('div.radio-list').find('#optlicense_y').attr('checked', 'checked');
                $('div.radio-list').find('#optlicense_y').parent().addClass('checked');

                $('div.radio-list').find('#optlicense_n').attr('checked', '');
                $('div.radio-list').find('#optlicense_n').parent().removeClass('checked');
            }else{
                $('div.radio-list').find('#optlicense_n').attr('checked', 'checked');
                $('div.radio-list').find('#optlicense_n').parent().addClass('checked');

                $('div.radio-list').find('#optlicense_y').attr('checked', '');
                $('div.radio-list').find('#optlicense_y').parent().removeClass('checked');
            }

            if(jsondata.graduated == 'Y'){
                $('div.radio-list').find('#optgraduate_y').attr('checked', 'checked');
                $('div.radio-list').find('#optgraduate_y').parent().addClass('checked');

                $('div.radio-list').find('#optgraduate_n').attr('checked', '');
                $('div.radio-list').find('#optgraduate_n').parent().removeClass('checked');
            }else{
                $('div.radio-list').find('#optgraduate_n').attr('checked', 'checked');
                $('div.radio-list').find('#optgraduate_n').parent().addClass('checked');

                $('div.radio-list').find('#optgraduate_y').attr('checked', '');
                $('div.radio-list').find('#optgraduate_y').parent().removeClass('checked');
            }

            $('#txteducid').val(jsondata.SchoolIndex);
        });

        $('#tbleduc').on('click','a.btndelete_educ',function() {
            $('#txtdeleduc').val($(this).data('educid'));
            $('#delete_education').modal('show');
        });
    });
</script>