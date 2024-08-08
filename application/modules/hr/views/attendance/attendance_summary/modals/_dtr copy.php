<?=load_plugin('css', array('profile-2','datatables'))?>
<?php 
    $month = isset($_GET['month-dtr']) ? $_GET['month-dtr'] :  date('m');
    $year = isset($_GET['year-dtr']) ? $_GET['year-dtr'] :  date('Y');
    $datefrom = date('Y-m-d', strtotime($month."-1-".$year));
    $dateto = date('Y-m-t', strtotime($month."-1-".$year));
    // $datefrom = isset($_GET['datefrom']) ? $_GET['datefrom'] : date('Y-m-d');
    // $dateto = isset($_GET['dateto']) ? $_GET['dateto'] : date('Y-m-d');
    $from = date('Y-m-d', strtotime($year."-".$month."-1"));; // Starting day for print preview (All)
    $to = date('Y-m-t', strtotime($year."-".$month."-1")); ; // Ending day for print preview (All)
    $from_15 = date('Y-m-d', strtotime($year."-".$month."-1"));; // Starting day for print preview (15 days)
    $to_15 = date('Y-m-d', strtotime($year."-".$month."-15")); ; // Ending day for print preview (15days)
    $from_end = date('Y-m-d', strtotime($year."-".$month."-16"));; // Starting day for print preview (End day)
    $to_end = date('Y-m-t', strtotime($year."-".$month."-1")); ; // Ending day for print preview (End day)
    $total_undertime = 0;
    $total_late = 0;
    $days_late_ut = 0;
    $days_absent = 0;
    $days_lwop = 0;
    $in_am  = '';
    $out_am = '';
    $in_pm  = '';
    $out_pm = '';
    $offset_wkdays = 0;
    $offset_wkends = 0;
 ?>

<div class="tab-pane active" id="tab_1_4">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Daily Time Record</span>
                </div>
                <div class="actions">
                    <?php if( $_SESSION['sessUserLevel'] == 1): ?>
                    <div class="btn-group">
                        <a class="btn green" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"
                            style="font-size: 14px;padding: 5px 11px;"> Actions
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/edit_mode').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">Edit Mode</a></li>
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/broken_sched').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">Broken Sched</a></li>
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/local_holiday').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">Local Holiday</a></li>
                            <li class="divider"> </li>
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/ob').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">OB</a></li>
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/leave').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">Leave</a></li>
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/compensatory_leave').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">Compensatory Time Off</a></li>
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/time').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">Time</a></li>
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/flagcrmy').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">Flag Ceremony</a></li>
                            <li>
                                <a href="<?=base_url('hr/attendance_summary/dtr/to').'/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">Travel Order</a></li>
                            <li class="divider"> </li>
                            <li>
                                <a href="javascript:;" data-toggle="modal" data-target="#print-preview-modal"> Preview / Print (All)</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-toggle="modal" data-target="#print-preview-modal-15"> Preview / Print (1-15)</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-toggle="modal" data-target="#print-preview-modal-end"> Preview / Print (16-last)</a>
                            </li>
                        </ul>
                    </div>
                    <?php else: ?>
                        <!-- <a class="btn blue pull-right" data-toggle="modal" data-target="#print-preview-modal">Preview / Print</a> -->
                        <li>
                            <a href="javascript:;" data-toggle="modal" data-target="#print-preview-modal"> Preview / Print (All)</a>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="modal" data-target="#print-preview-modal-15"> Preview / Print (1-15)</a>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="modal" data-target="#print-preview-modal-end"> Preview / Print (16-last)</a>
                        </li>
                    <?php endif; ?>
                </div>
            </div>
            <div style="display: inline-flex;">
                <div class="legend-def1">
                    <div class="legend-dd1" style="background-color: #acd9f7;"></div> &nbsp;<small style="margin-left: 10px;">Weekend</small> &nbsp;&nbsp;</div>
                <div class="legend-def1">
                    <div class="legend-dd1" style="background-color: #ffc0cb;"></div> &nbsp;<small style="margin-left: 10px;">Holiday</small> &nbsp;&nbsp;</div>
                <div class="legend-def1">
                    <i class="fa fa-check-square certified_ot"></i>&nbsp;<small>Certified Overtime</small> &nbsp;&nbsp;</div>
            </div>
            <br><br>
            <style type="text/css">th.no-sort { padding: 15px !important; }</style>
            <table class="table table-striped table-bordered order-column" id="tbldtr">
                <thead>
                    <colgroup span="2"></colgroup>
                    <colgroup span="2"></colgroup>
                    <tr>
                        <th rowspan="2" class="no-sort">Date</th>
                        <th rowspan="2" class="no-sort">Day</th>
                        <th rowspan="2" class="no-sort">In</th>
                        <th colspan="2" scope="colgroup">Break</th>
                        <th rowspan="2" class="no-sort">Out</th>
                        <th colspan="2" scope="colgroup">Overtime</th>
                        <th rowspan="2" class="no-sort">Late<br>(Minutes)</th>
                    </tr>
                    <tr>
                        <!-- <th class="no-sort">Date</th> -->
                        <!-- <th class="no-sort">Day</th> -->
                        <!-- <th class="no-sort">In</th> -->
                        <th class="no-sort">Out</th>
                        <th class="no-sort">In</th>
                        <!-- <th class="no-sort">Out</th> -->
                        <th class="no-sort">In</th>
                        <th class="no-sort">Out</th>
                        <!-- <th class="no-sort">Late</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arremp_dtr as $index => $dtr ):?>
                        <tr class="odd <?=$dtr['day']?> tooltips <?=count($dtr['holiday_name']) > 0 ? 'holiday' : ''?>"
                            data-original-title="<?=date('l', strtotime($dtr['dtrdate']))?>">
                            <td><?=date('M d', strtotime($dtr['dtrdate']))?> </td>
                            <td><?=$dtr['day']?></td>
                            <td><?=($scanqr_dtr[$index]['inAM'] == null) ? "" : date("h:i:s A", strtotime($scanqr_dtr[$index]['inAM']))?></td>
                            <td><?=($scanqr_dtr[$index]['outBreak'] == null) ? "" : date("h:i:s A", strtotime($scanqr_dtr[$index]['outBreak']))?></td>
                            <td><?=($scanqr_dtr[$index]['inBreak'] == null) ? "" : date("h:i:s A", strtotime($scanqr_dtr[$index]['inBreak']))?></td>
                            <td><?=($scanqr_dtr[$index]['outPM'] == null) ? "" : date("h:i:s A", strtotime($scanqr_dtr[$index]['outPM']))?></td>
                            <td><?=($scanqr_dtr[$index]['inOvertime'] == null) ? "" : date("h:i:s A", strtotime($scanqr_dtr[$index]['inOvertime']))?></td>
                            <td><?=($scanqr_dtr[$index]['outOvertime'] == null) ? "" : date("h:i:s A", strtotime($scanqr_dtr[$index]['outOvertime']))?></td>
                            <td><?=$scanqr_dtr[$index]['late']?> </td>
                        </tr>
                        <?php $index++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table class="table" width="100%">
                <tr>
                    <td width="25%"><b>Total Number of Working Days</b></td>
                    <td width="25%"><?=count($working_days)?></td>
                    <td width="25%"><b>Total Days Absent</b></td>
                    <td width="25%"><?=$days_absent?></td>
                </tr>
                <tr>
                    <td><b>Total Undertime</b></td>
                    <td><?=date('H:i', mktime(0, $total_undertime))?></td>
                    <td><b>VL</b></td>
                    <td><?=count($arrLatestBalance) > 0 ? $arrLatestBalance['vlBalance'] : ''?></td>
                </tr>
                <tr>
                    <td><b>Total Late</b></td>
                    <td><?=date('H:i', mktime(0, $total_late))?></td>
                    <td><b>SL</b></td>
                    <td><?=count($arrLatestBalance) > 0 ? $arrLatestBalance['slBalance'] : ''?></td>
                </tr>
                <tr>
                    <td><b>Late / Undertime</b></td>
                    <td><?=date('H:i', mktime(0, ($total_undertime + $total_late)))?></td>
                    <td><b>Offset Balance</b></td>
                    <td><?=count($arrLatestBalance) > 0 ? date('H:i', mktime(0, $arrLatestBalance['off_bal'])) : ''?></td>
                </tr>
                <tr>
                    <td><b>Total Days Late / Undertime</b></td>
                    <td><?=$days_late_ut?></td>
                    <td><b>Offset Gain</b></td>
                    <td><?=($offset_wkdays + $offset_wkends) > 0 ? date('H:i', mktime(0, ($offset_wkdays + $offset_wkends))) : ''?></td>
                </tr>
                <tr>
                    <td><b>Total Days LWOP</b></td>
                    <td><?=$days_lwop?></td>
                    <td><b>Offset Used</b></td>
                    <td><?=count($arrLatestBalance) > 0 ? date('H:i', mktime(0, $arrLatestBalance['off_used'])) : ''?></td>
                </tr>
                <tr>
                    <td><b>Total Offset (Weekdays)</b></td>
                    <td><?=$offset_wkdays > 0 ? date('H:i', mktime(0, $offset_wkdays)) : ''?></td>
                    <td><b>Total Offset (Weekends/Holiday)</b></td>
                    <td><?=$offset_wkends > 0 ? date('H:i', mktime(0, $offset_wkends)) : ''?></td>
                </tr>
            </table>

            <div class="row" <?=$_SESSION['sessUserLevel'] == 1 ? '' : 'hidden'?>>
                <div class="col-md-12">
                    <a href="<?=base_url('hr/attendance_summary/dtr/certify_offset').'/'.$arrData['empNumber'].'?datefrom='.$_GET['datefrom'].'&dateto='.$_GET['dateto']?>" class="btn blue">Certify Offset</a>
                    <small><i>Click here to include/exclude Offset from computation.</i></small>
                    <?=str_repeat('&nbsp;', 6)?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('modals/_dtr_modal.php') ?>

<?=load_plugin('js', array('datatables','datatables-scroller'))?>
<script src="<?=base_url('assets/js/custom/dtr_view-js.js')?>"></script>
<script src="<?=base_url('assets/plugins/jspdf/jspdf.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/jspdf/jspdf-autotable.js')?>"></script>

<script>
    $(document).ready(function() {
        $('td.hide').hide();
        // $('#tbldtr').dataTable({
            // "bPaginate" : false,
            // pageLength: 50
            // "scrollY": "350px",
            // "scrollCollapse": true,
            // "paging": false,
            // "bInfo": false,
            // "bSort": false
        // });
        // setTimeout(function () { $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();},200);
    });
</script>