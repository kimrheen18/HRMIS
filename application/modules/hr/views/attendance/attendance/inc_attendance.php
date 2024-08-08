<?php
    load_plugin('css', array('datatables','select','select2'));
    $position = isset($_GET['position']) ? $_GET['position'] : 'all';
    
    $month = isset($_GET['month']) ? $_GET['month'] == '' ? date('m') : $_GET['month'] : date('m');
    $yr = isset($_GET['yr']) ? $_GET['yr'] == '' ? date('Y') : $_GET['yr'] : date('Y');

    $datefrom = $yr.'-'.$month.'-01';
    $dateto = $yr.'-'.$month.'-'.cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));?>

<style>
    table, tr, td, th {
        text-align: center;
    }
    .select2 {
        width: 175px !important;
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
            <span>Employees with Incomplete Attendance</span>
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
                            <span class="caption-subject bold uppercase"> Employees with Incomplete Attendance</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="portlet-body"  id="dtrlogs">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                        <?=form_open('', array('class' => 'form-inline', 'method' => 'get'))?>
                                            <div class="form-group" style="display: inline-flex;">
                                                <label style="padding: 6px;">Month</label>
                                                <select class="bs-select form-control" name="month">
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
                                            &nbsp;
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
                                            &nbsp;
                                            <div class="form-group" style="display: inline-flex;">
                                                <label style="padding: 6px;">Appointment Description</label>
                                                <select class="select2" name="position">
                                                    <option value="all"> -- Select --</option>
                                                    <?php foreach($arrAppointments as $app): $selected = $app['appointmentCode'] == $position ? 'selected' : ''?>
                                                        <option value="<?=$app['appointmentCode']?>" <?=$selected?>><?=$app['appointmentDesc']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            &nbsp;
                                            <button type="submit" class="btn btn-primary" style="margin-top: -3px;">Search</button>
                                        <?=form_close()?>
                                    </center>
                                    <br>
                                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                                    <table class="table table-striped table-bordered table-hover" id="table-atts" style="display: none">
                                        <thead>
                                            <th style="width: 40px;">No</th>
                                            <th style="text-align: left;">Employee</th>
                                            <th style="width: 175px;"></th>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; foreach($arremployees as $emp): ?>
                                                <tr>
                                                    <td><?=$no++?></td>
                                                    <td style="text-align: left;"><?=$emp['name']?></td>
                                                    <td><a href="<?=base_url('hr/attendance_summary/dtr/'.$emp['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto)?>" class="btn btn-sm grey-cascade"> <i class="icon-calendar"></i>&nbsp; View DTR </a></td>
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
<?php load_plugin('js',array('datatables','select','select2'));?>

<script>
    $(document).ready(function() {
        $('#table-atts').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-atts').show();},
            "columnDefs": [{ "orderable":false, "targets":'no-sort' }]
        });

        // $('.date-picker').datepicker();
        // $('.date-picker').on('changeDate', function(){
        //     $(this).datepicker('hide');
        // });
    });
</script>