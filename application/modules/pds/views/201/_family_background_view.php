<?=load_plugin('css', array('datepicker','timepicker'));$arrData = $arrData[0];?>

<!-- begin spouse information -->
<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">SPOUSE INFORMATION
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn green btn-sm pull-right" data-toggle="modal" href="#edit_spouse_modal"> <i class="icon-pencil"></i> Edit </a>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <th>Name of Spouse</th>
            <td><?=getfullname($arrData['spouseFirstname'],$arrData['spouseSurname'],$arrData['spouseMiddlename'],'',$arrData['spousenameExtension'])?></td>
            <th>Occupation</th>
            <td><?=$arrData['spouseWork']?></td>
        </tr>
        <tr>
            <th>Employer/Business Name</th>
            <td><?=$arrData['spouseBusName']?></td>
            <th>Telephone Number</th>
            <td><?=$arrData['spouseTelephone']?></td>
        </tr>
        <tr>
            <th>Business Address</th>
            <td colspan="3"><?=$arrData['spouseBusAddress']?></td>
        </tr>
    </table>
</div>
<?php require 'modal/_spouse_info.php'; ?>
<!-- end spouse information -->

<!-- begin parents information -->
<div class="col-md-12">
    <table class="table table-bordered">
        <tr class="active">
            <th style="line-height: 2;" colspan="4">PARENT'S INFORMATION
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn green btn-sm pull-right" data-toggle="modal" href="#edit_parents_modal"> <i class="icon-pencil"></i> Edit </a>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <th nowrap>Name of Father</th>
            <td width="35%"><?=getfullname($arrData['fatherFirstname'],$arrData['fatherSurname'],$arrData['fatherMiddlename'],'',$arrData['fathernameExtension'])?></td>
            <th nowrap>Name of Mother</th>
            <td width="35%"><?=getfullname($arrData['motherFirstname'],$arrData['motherSurname'],$arrData['motherMiddlename'],'','')?></td>
        </tr>
        <tr>
            <th nowrap>Parents Address</th>
            <td colspan="3"><?=$arrData['parentAddress']?></td>
        </tr>
    </table>
</div>
<?php require 'modal/_parents_info.php'; ?>
<!-- end parents information -->

<!-- begin child information -->
<div class="col-md-12">
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="active">
                <th style="line-height: 2;" colspan="4"><b>CHILDREN INFORMATION</b>
                    <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                        <a class="btn blue btn-sm pull-right" href="javascript:;" id="btnadd_child"> <i class="fa fa-plus"></i> Add Child </a>
                    <?php endif; ?>
                </th>
            </tr>
            <tr>
                <th><b>Name of Children</b></th>
                <th style="text-align: center;"><b>Date of Birth</b></th>
                <th <?=check_module() == 'hr' ? '' : 'hidden'?>></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($arrChild as $row):?>
                <tr>
                    <td><?=$row['childName']?></td>
                    <td style="text-align: center;"><?=$row['childBirthDate']?></td>
                    <td style="width: 200px;" nowrap <?=check_module() == 'hr' ? '' : 'hidden'?>>
                        <center>
                            <a class="btn green btn-xs btnedit_child" data-chilid="<?=$row['childCode']?>">
                                <i class="fa fa-pencil"></i> Edit </a>
                            <a class="btn red btn-xs btndelete_child" data-chilid="<?=$row['childCode']?>">
                                <i class="fa fa-trash"></i> Delete </a>
                        </center>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require 'modal/_child_info.php'; ?>
<!-- end child information -->

<script>
    $(document).ready(function() {
        $('.date-picker').datepicker();
        $('.date-picker').on('changeDate', function(){
            $(this).datepicker('hide');
        });

        $('a#btnadd_child').click(function() {
            $('#frmchild').attr("action","<?=base_url('pds/add_child/').$this->uri->segment(3)?>");
            $('span.action').html('Add ');
            $('#add_child_modal').modal('show');
        });

        $('a.btnedit_child').click(function() {
            $('#frmchild').attr("action","<?=base_url('pds/edit_child/').$this->uri->segment(3)?>");
            $('span.action').html('Edit ');
            $('#add_child_modal').modal('show');
            $('#txtchildcode').val($(this).data('chilid'));
            
            var tr=$(this).closest('tr');
            $('#txtchildname').val(tr.children('td:first').text());
            $('#txtchildbday').val(tr.children('td:nth-child(2)').text());
        });

        $('a.btndelete_child').click(function() {
            $('#txtdelchild').val($(this).data('chilid'));
            $('#delete_child').modal('show');
        });


    });
</script>