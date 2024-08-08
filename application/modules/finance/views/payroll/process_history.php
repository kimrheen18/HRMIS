<style type="text/css">
    th { text-align: center; }
</style>
<?=load_plugin('css', array('select','datatables'))?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Reports</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Process History</span>
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
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Process History</span>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-body" style="visibility: hidden;">
                <div class="portlet light bordered">
                    <div class="col-md-12" style="margin-bottom: 20px;">
                        <center>
                            <?=form_open('', array('class' => 'form-inline', 'method' => 'get'))?>
                                <div class="form-group" style="display: inline-flex;">
                                    <label style="padding: 6px;">Month</label>
                                    <select class="bs-select form-control" name="month">
                                        <option value="all">All</option>
                                        <?php foreach (range(1, 12) as $m): ?>
                                            <option value="<?=sprintf('%02d', $m)?>"
                                                <?php 
                                                    if(isset($_GET['month'])):
                                                        echo $_GET['month'] == $m ? 'selected' : '';
                                                    else:
                                                        echo $m == sprintf('%02d', date('n')) ? 'selected' : '';
                                                    endif;
                                                    ?> >
                                                <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group" style="display: inline-flex;margin-left: 10px;">
                                    <label style="padding: 6px;">Year</label>
                                    <select class="bs-select form-control" name="yr">
                                        <?php foreach (getYear() as $yr): ?>
                                            <option value="<?=$yr?>"
                                                <?php 
                                                    if(isset($_GET['yr'])):
                                                        echo $_GET['yr'] == $yr ? 'selected' : '';
                                                    else:
                                                        echo $yr == date('Y') ? 'selected' : '';
                                                    endif;
                                                    ?> >  
                                            <?=$yr?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" style="margin-top: -3px;">Search</button>
                            <?=form_close()?>
                        </center>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered order-column" id="tblprocess-history" style="visibility: hidden;">
                            <thead>
                                <tr>
                                    <th width="50px"> No </th>
                                    <th> Process </th>
                                    <th> Employee </th>
                                    <th> Month </th>
                                    <th> Year </th>
                                    <th> Date Processed </th>
                                    <th> Details </th>
                                    <th> Processed By </th>
                                    <th class="no-sort"> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;foreach($arrprocess as $process): ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td align="center"><?=$process['processCode']?></td>
                                    <td align="center"><?=$process['appointmentDesc']?></td>
                                    <td align="center"><?=date('F', mktime(0, 0, 0, $process['processMonth'], 10))?></td>
                                    <td align="center"><?=$process['processYear']?></td>
                                    <td align="center"><?=$process['processDate']?></td>
                                    <td>
                                        <?php if(strlen($process['details']) > 50): ?>
                                            <span class="ellipsis"><?=substr($process['details'], 0, 50)?> ...</span>
                                            <span class="fulltext" style="display: none;"><?=$process['details']?></span>&nbsp;&nbsp;
                                            <a class="showmore small" href="javascript:;"><u>show more</u></a>
                                            <a class="showless small" href="javascript:;" style="display: none;"><u>show less</u></a>
                                        <?php else: ?>
                                            <?=$process['details']?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?=employee_name($process['empNumber'])?></td>
                                    <td style="width: 250px; white-space: nowrap;">
                                        <a href="javascript:;" class="btn btn-sm blue" id="btnreprocess"
                                            data-procid="<?=$process['processID']?>" data-periodmon="<?=$process['processMonth']?>"
                                            data-periodyr="<?=$process['processYear']?>" data-appt="<?=$process['employeeAppoint']?>" data-period="<?=$process['period']?>">
                                            <i class="fa fa-refresh"></i> Reprocess</a>
                                        <!-- <a href="<?=base_url('finance/reports/monthly')?>" class="btn btn-sm grey-cascade" id="btnreprocess">
                                            <i class="fa fa-file-o"></i> Reports</a> -->
                                        <?php if($process['publish'] == 1): ?>
                                            <a href="javascript:;" class="btn btn-sm green-meadow" id="btnunpublish" data-procid="<?=$process['processID']?>">
                                                <i class="fa fa-check"></i> Unpublish</a>
                                        <?php else: ?>
                                            <a href="javascript:;" class="btn btn-sm green" id="btnpublish" data-procid="<?=$process['processID']?>">
                                                <i class="fa fa-check"></i> Publish</a>
                                        <?php endif; ?>
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

<?php include 'modals/process_history_modal.php'; ?>

<?=load_plugin('js', array('select','datatables'))?>

<script>
    $(document).ready(function() {
        $('#tblprocess-history').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tblprocess-history').css('visibility', 'visible');
                $('#div-body').css('visibility', 'visible');},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        } );

        $('#tblprocess-history').on('click', 'a#btnunpublish', function() {
            $('.modal-title').html('<b>Unpublish Process</b>');
            $('#txtprocess_id').val($(this).data('procid'));
            $('#txtpublish_val').val(0);
            $('#spanpublish').html('unpublish');
            $('#publish_process').modal('show');
        });

        $('#tblprocess-history').on('click', 'a#btnpublish', function() {
            $('.modal-title').html('<b>Publish Process</b>');
            $('#txtprocess_id').val($(this).data('procid'));
            $('#txtpublish_val').val(1);
            $('#spanpublish').html('publish');
            $('#publish_process').modal('show');
        });

        $('#tblprocess-history').on('click', 'a#btnreprocess', function() {
            $('#txtreprocess_id').val($(this).data('procid'));
            $('#txtperiodmon').val($(this).data('periodmon'));
            $('#txtperiodyr').val($(this).data('periodyr'));
            $('#txtappt').val($(this).data('appt'));
            $('#txtperiod').val($(this).data('period'));
            $('#reprocess_confirm').modal('show');
        });

        /* ellipsis*/
        $('#tblprocess-history').on('click', 'a.showmore', function() {
            $(this).closest('td').find('.fulltext,a.showless').show();
            $(this).prev().prev('.ellipsis').hide();
            $(this).hide();
        });
        $('#tblprocess-history').on('click', 'a.showless', function() {
            $(this).closest('td').find('.ellipsis,a.showmore').show();
            $(this).closest('td').find('.fulltext').hide();
            $(this).hide();
        });


    });
</script>
