<?=load_plugin('css', array('datatables','datepicker'))?>
<style>
    table, tr, td, th {
        text-align: center;
    }
</style>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Attendance</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Attendance Summary</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>DTR Logs</span>
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
                            <i class="glyphicon glyphicon-list font-dark"></i>
                            <span class="caption-subject bold uppercase"> DTR Logs</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="portlet-body"  id="dtrlogs">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <?=form_open('', array('class' => 'form-inline', 'method' => 'get'))?>
                                            <div class="form-group" style="display: inline-flex;">
                                                <label style="padding: 6px;">Date</label>
                                                <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" name="logdate" type="text"
                                                    style="width: 140px !important;" value="<?=isset($_GET['logdate']) ? $_GET['logdate'] == '' ? date('Y-m-d') : $_GET['logdate'] : date('Y-m-d')?>">
                                            </div>
                                            &nbsp;
                                            <button type="submit" class="btn btn-primary" style="margin-top: -3px;">Search</button>
                                        <?=form_close()?>
                                    </center>
                                    <br>
                                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                    <table class="table table-striped table-bordered table-hover" id="table-dtrlogs" style="display: none">
                                        <thead>
                                            <th style="width: 40px;">No</th>
                                            <th style="text-align: left;">Employee</th>
                                            <th>Time</th>
                                            <th>Result</th>
                                        </thead>
                                        <tbody>
                                            <?php $no=1;foreach($dtrlogs as $log): ?>
                                                <tr>
                                                    <td><?=$no++?></td>
                                                    <td style="text-align: left;"><?=employee_name($log['empNumber'])?></td>
                                                    <td><?=date('M. d, Y H:i:s',strtotime($log['log_date']))?></td>
                                                    <td><?=$log['log_notify']?></td>
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
        </div>
    </div>
</div>
<?php load_plugin('js',array('datatables','datepicker'));?>

<script>
    $(document).ready(function() {
        $('#table-dtrlogs').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-dtrlogs').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });

        $('.date-picker').datepicker();
        $('.date-picker').on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
</script>