<style type="text/css">
    th { text-align: center; }
    tr td { vertical-align: middle !important; }
    .tdedit { border: 1px solid #acd9f7 !important; width: 100% !important; padding: 3px 0px; }
    a {color: black}
</style>
<?=load_plugin('css', array('datetimepicker','timepicker'))?>
<?php 
    $yr = isset($_GET['year-dtr']) ? $_GET['year-dtr'] : date('Y');
    $mn = isset($_GET['month-dtr']) ? $_GET['month-dtr'] : date('m');
 ?>

<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Daily Time Record</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <div class="alert alert-danger alert-dismissable" >
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Invalid input. </div>
                        <a href="<?=base_url('hr/attendance_summary/dtr/'.$arrData['empNumber'].'?month-dtr='.$mn.'&year-dtr='.$yr)?>" class="btn grey-cascade">
                            <i class="icon-calendar"></i> DTR </a>
                        <br><br>
                        <table class="table table-bordered dtr-edit" id="tbldtr">
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
                                <th rowspan="2" class="no-sort">Under Time<br>(Minutes)</th>
                            </tr>
                            <tr>
                                <th class="no-sort">Out</th>
                                <th class="no-sort">In</th>
                                <th class="no-sort">In</th>
                                <th class="no-sort">Out</th>
                            </tr>
                                <!-- <tr>
                                    <th>DATE</th>
                                    <th>IN</th>
                                    <th>OUT</th>
                                    <th>IN</th>
                                    <th>OUT</th>
                                    <th>IN</th>
                                    <th>OUT</th>
                                    <th>REMARKS</th>
                                    <th>LOGS</th>
                                    <td hidden></td>
                                </tr> -->
                            </thead>
                            <tbody>
                                <?php foreach($arremp_dtr as $index => $dtr):

                                    $inAm = ($scanqr_dtr[$index]['inAM'] == null) ? "00:00" : date("h:i A", strtotime($scanqr_dtr[$index]['inAM']));

                                    $outBreak = ($scanqr_dtr[$index]['outBreak'] == null) ? "00:00" : date("h:i A", strtotime($scanqr_dtr[$index]['outBreak']));

                                    $inBreak = ($scanqr_dtr[$index]['inBreak'] == null) ? "00:00" : date("h:i A", strtotime($scanqr_dtr[$index]['inBreak']));

                                    $outPM = ($scanqr_dtr[$index]['outPM'] == null) ? "00:00" : date("h:i A", strtotime($scanqr_dtr[$index]['outPM']));

                                    $inOvertime = ($scanqr_dtr[$index]['inOvertime'] == null) ? "00:00" : date("h:i A", strtotime($scanqr_dtr[$index]['inOvertime']));

                                    $outOvertime = ($scanqr_dtr[$index]['outOvertime'] == null) ? "00:00" : date("h:i A", strtotime($scanqr_dtr[$index]['outOvertime']));

                                    $late = ($scanqr_dtr[$index]['late'] == null) ? "0" : $scanqr_dtr[$index]['late'];

                                    $underTime = ($scanqr_dtr[$index]['underTime'] == null) ? "0" : $scanqr_dtr[$index]['underTime'];

                                    ?>
                                   
                                    <tr class="odd <?=$dtr['day']?>  <?=count($dtr['holiday_name']) > 0 ? 'holiday' : ''?>"
                                        data-original-title="<?=date('l', strtotime($dtr['dtrdate']))?>">

                                        <td><?=date('M d', strtotime($dtr['dtrdate']))?></td>
                                        <td> <?=$dtr['day']?></td>
                                        <td>
                                            <a href="javascript:;" class="open-edit" data-toggle="modal" data-target="#edit-dtr" data-col="inAM" data-date="<?=date('Y-m-d', strtotime($dtr['dtrdate']))?>" data-time="<?=$inAm?>" >
                                                <button class="btn <?=($scanqr_dtr[$index]['inAM'] != null) ? "btn-primary" : "" ?>"  > <?=$inAm?></button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="open-edit" data-toggle="modal" data-target="#edit-dtr" data-col="outBreak" data-date="<?=date('Y-m-d', strtotime($dtr['dtrdate']))?>" data-time="<?=$outBreak?>">
                                                <button class="btn <?=($scanqr_dtr[$index]['outBreak'] != null) ? "btn-primary" : "" ?> " > <?=$outBreak?></button>
                                            </a>  
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="open-edit" data-toggle="modal" data-target="#edit-dtr" data-col="inBreak" data-date="<?=date('Y-m-d', strtotime($dtr['dtrdate']))?>" data-time="<?=$inBreak?>">
                                                <button class="btn <?=($scanqr_dtr[$index]['inBreak'] != null) ? "btn-primary" : "" ?> "><?=$inBreak?></button>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="open-edit" data-toggle="modal" data-target="#edit-dtr" data-col="outPM" data-date="<?=date('Y-m-d', strtotime($dtr['dtrdate']))?>" data-time="<?=$outPM?>">
                                                <button class="btn <?=($scanqr_dtr[$index]['outPM'] != null) ? "btn-primary" : "" ?>"><?=$outPM?></button>
                                            </a> 
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="open-edit" data-toggle="modal" data-target="#edit-dtr" data-col="inOvertime" data-date="<?=date('Y-m-d', strtotime($dtr['dtrdate']))?>" data-time="<?=$inOvertime?>">
                                                <button class="btn <?=($scanqr_dtr[$index]['inOvertime'] != null) ? "btn-primary" : "" ?> "><?=$inOvertime?></button>
                                            </a>  
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="open-edit" data-toggle="modal" data-target="#edit-dtr" data-col="outOvertime" data-date="<?=date('Y-m-d', strtotime($dtr['dtrdate']))?>" data-time="<?=$outOvertime?>">
                                                <button class="btn <?=($scanqr_dtr[$index]['outOvertime'] != null) ? "btn-primary" : "" ?>"><?=$outOvertime?></button>
                                            </a>  
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="edit-late" data-toggle="modal" data-target="#edit-dtr-late" data-col="late" data-date="<?=date('Y-m-d', strtotime($dtr['dtrdate']))?>" data-late="<?=$late?>">
                                                <button class="btn <?=($scanqr_dtr[$index]['late'] != null) ? "btn-primary" : "" ?>"><?=$late?></button>
                                            </a>  
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="edit-late" data-toggle="modal" data-target="#edit-dtr-late" data-col="underTime" data-date="<?=date('Y-m-d', strtotime($dtr['dtrdate']))?>" data-late="<?=$underTime?>">
                                                <button class="btn <?=($scanqr_dtr[$index]['underTime'] != null) ? "btn-primary" : "" ?>"><?=$underTime?></button>
                                            </a>  
                                        </td>
                                    </tr>
                                    <?php $index++ ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$this->load->view('modals/_dtr_modal.php')?>
<?=load_plugin('js',array('datetimepicker','timepicker'));?>
<script src="<?=base_url('assets/js/custom/dtr_view-js.js')?>"></script>

<script type="text/javascript">
$(document).ready(function() {
        $('.timepicker').timepicker({
            timeFormat: 'HH:mm:ss A',
            minuteStep: 1,
            secondStep: 1,
            disableFocus: true,
            showInputs: false,
            showSeconds: true,
            showMeridian: true,
            defaultTime: '12:00:00 a'
        });


        $('#dtrEdit1,#dtrEdit2,#dtrEdit3,#dtrEdit4,#dtrEdit5,#dtrEdit6').keyup(function(){
            var limit = parseInt($(this).attr('data-maxlength'));
            var minlimit = parseInt($(this).attr('data-minlength'));
            var text = $(this).html();
            var chars = text.length;
            if(chars >= limit){
                $('#error').show();
                var new_text = text.substr(0,limit);
                $(this).html(new_text);
            }
        });

        // For Time Entry
        $(".open-edit").on("click", function(){
            var getDate = $(this).data('date');
            var getTime = $(this).data('time');
            var getCol = $(this).data('col');
            
            $("#dtr-date").val(getDate);
            $("#edit-time").val(getTime);
            $("#dtr-col").val(getCol);
        });
        
        // For Late Entry
        $(".edit-late").on("click", function(){
            var getLate = $(this).data('late');
            var getDate = $(this).data('date');
            var getCol = $(this).data('col');

            $("#dtr-date-late").val(getDate);
            $("#dtr-col-late").val(getCol);
            $("#edit-late").val(getLate);
        });

});

function Validate(event) {
        var regex = new RegExp("^[0-9-!@#$%&*?:]");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    } 
</script>