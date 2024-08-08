<?php load_plugin('css',array('datatables','select'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Notification</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<br>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <i class="icon-list"></i> Tasks</span>
                </div>
            </div>
            
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
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

                        <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                        <div style="display: inline-flex;">
                            <div class="legend-def1">
                                <div class="legend-dd1" style="background-color: #ffffb0;"></div> &nbsp;<small style="margin-left: 10px;">Disapproved</small> &nbsp;&nbsp;</div>
                            <div class="legend-def1">
                                <div class="legend-dd1" style="background-color: #ffc0cb;"></div> &nbsp;<small style="margin-left: 10px;">Cancelled</small> &nbsp;&nbsp;</div>
                        </div>
                        <br><br>
                        <table class="table table-striped table-bordered table-hover" id="table-notif" style="visibility: hidden;">
                            <thead>
                                <tr>
                                    <th style="text-align: center;width:50px;">No</th>
                                    <th>Employee</th>
                                    <th style="text-align: center;width:150px;"> Request Date </th>
                                    <th style="text-align: center;width:100px;"> Request Type </th>
                                    <th style="text-align: center;width:150px;"> Request Status </th>
                                    <th style="text-align: center;"> Remarks </th>
                                    <th> Destination </th>
                                    <th style="text-align: center;width:150px;" class="no-sort"> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($allemp_request as $request): ?>
                                    <tr class="<?=strtolower($request['req_status']) == 'cancelled'? 'cancelled':''?> <?=strtolower($request['req_status']) == 'disapproved'? 'disapproved':''?>">
                                        <td align="center"><?=$no++?></td>
                                        <td><?=employee_name($request['req_emp'])?></td>
                                        <td align="center"><?=$request['req_date']?></td>
                                        <td align="center"><?=$request['req_type']?></td>
                                        <td align="center"><?=$request['req_status']?></td>
                                        <td align="center"><?=$request['req_remarks']?></td>
                                        <td><?=$request['req_desti']?></td>
                                        <td nowrap style="vertical-align: middle;text-align: center;">
                                            <a href="javascript:;" id="btnview-details" class="btn btn-sm blue" data-json='<?=json_encode($request)?>'>
                                                <i class="icon-magnifier"></i> View Details </a>
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

<?php include 'modals/_request_details.php' ?>
<?php load_plugin('js',array('datatables','select'));?>

<script src="<?=base_url('assets/js/custom/officer-tasks.js')?>"></script>