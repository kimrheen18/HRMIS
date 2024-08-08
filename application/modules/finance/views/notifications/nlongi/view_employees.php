<?php load_plugin('css',array('datatables'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Notifications</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Increase in Longevity factor</span>
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
                            <span class="caption-subject bold uppercase"> INCREASE IN LONGEVITY FACTOR</span>
                        </div>
                    </div>
                
                    <div class="portlet-body">
                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table-nlongi" style="display: none">
                            <thead>
                                <tr>
                                    <tr>
                                        <th style="text-align: center; width: 50px;"> No. </th>
                                        <th> Employee Number </th>
                                        <th> Name </th>
                                        <th style="text-align: center;"> Old Longevity Factor </th>
                                        <th style="text-align: center;"> New Longevity Factor </th>
                                        <th style="text-align: center;"> Date of Effectivity </th>
                                        <th style="text-align: center;"> Actions </th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($arrEmployees as $employee): ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$employee['empNumber']?></td>
                                        <td><?=getfullname($employee['firstname'], $employee['surname'], $employee['middlename'], $employee['middleInitial'], $employee['nameExtension'])?></td>
                                        <td style="text-align: center;"><?=$employee['longiFactor']?>%</td>
                                        <td style="text-align: center;"><?=$employee['difYear']?>%</td>
                                        <td style="text-align: center;"><?=$employee['dateofIncrease']?></td>
                                        <td style="text-align: center;" nowrap>
                                            <a href="<?=base_url('finance/compensation/personnel_profile/employee').'/'.$employee['empNumber']?>" class="btn btn-sm blue">
                                                <i class="fa fa-eye"></i>  View</a>
                                            <a data-toggle="modal" href="#updateLongevity" id="btnupdateLongevity" class="btn btn-sm green"
                                                data-longefactor="<?=$employee['difYear']?>"
                                                data-empnumber="<?=$employee['empNumber']?>">
                                                <i class="fa fa-credit-card"></i>  Update Factor</a>
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

<div id="updateLongevity" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Update Factor Longevity</h4>
            </div>
            <?=form_open('finance/notifications/notifications/updateLongevityFactor', array('id' => 'frmchangelongevity', 'method' => 'post'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtempnumber" id="txtempnumber">
                            <input type="hidden" name="txtlongefactor" id="txtlongefactor">
                            <div class="form-group">
                                <label>Are you sure you want to change longevity factor?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsubmit-payrollDetails" class="btn btn-sm green"><i class="icon-check"> </i> Yes</button>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>

<?php load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-nlongi').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-nlongi').show();
            }} );

        $('#table-nlongi').on('click','tbody > tr > td > a#btnupdateLongevity', function() {
            $('#txtlongefactor').val($(this).data('longefactor'));
            $('#txtempnumber').val($(this).data('empnumber'));
        });

    });
</script>