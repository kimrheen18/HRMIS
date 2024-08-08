<?=load_plugin('css', array('profile-2'))?>
<div class="tab-pane active" id="tab_1_1">
    <div class="row">
        <div class="col-md-12" style="border-top:1px solid #eef1f5;margin-bottom: 10px;"></div>
        <div class="col-md-2">
            <ul class="list-unstyled profile-nav">
                <li>
                    <?php
                    $strImageUrl = 'uploads/employees/'.$arrData['empNumber'].'.jpg';
                        if(file_exists($strImageUrl))
                        {
                            $strImage = base_url('uploads/employees/'.$arrData['empNumber'].'.jpg');
                        }
                        else 
                        {
                            $strImage = base_url('assets/images/logo.png');
                        }?>
                    <img src="<?=$strImage?>" class="img-responsive pic-bordered" width="200px" alt="" />
                    <?php if(check_module() == 'hr'): ?>
                        <a href="<?=base_url('hr/edit_image/'.$arrData['empNumber'])?>" class="btn dark btn-sm">
                                <i class="icon-ban"> </i> Edit Image</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12 profile-info">
                    <h1 class="font-green sbold uppercase"><?=fix_fullname($arrData['firstname'],$arrData['surname'],$arrData['middlename'],$arrData['middleInitial'],$arrData['nameExtension'])?></h1>
                    <div class="row">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td width="20%"><b>Employee Number</b></td>
                                    <td width="35%"><?=$arrData['empNumber']?></td>
                                    <td width="15%"><b>Pay Ending</b></td>
                                    <td width="35%"><?=date('F Y')?></td>
                                </tr>
                                <tr>
                                    <td><b>Office</b></td>
                                    <td colspan="3"><?=office_name(employee_office($arrData['empNumber']))?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 profile-info">
                    <div class="row">
                        <br>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td><b>Date(s) Absent</b></td>
                                    <td style="width: 75%;">
                                        <?php
                                            foreach($arrattendance['days_absent'] as $absent):
                                                echo date('d', strtotime($absent)).' ';
                                            endforeach;
                                            if(count($arrattendance['days_absent']) > 0):
                                                echo '&nbsp;<a class="btn btn-xs default" data-toggle="modal" data-backdrop="static" data-keyboard="false" href="#absents-modal"> ...</a>';
                                            endif;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Offset Balance</b></td>
                                    <td style="width: 75%;"><?=date('H:i', mktime(0, ($arrattendance['total_ot_wkdays'] + $arrattendance['total_ot_holidays'])))?></td>
                                </tr>
                                <tr>
                                    <td><b>Total Undertime</b></td>
                                    <td style="width: 75%;"><?=date('H:i', mktime(0, $arrattendance['total_undertime']))?></td>
                                </tr>
                                <tr>
                                    <td><b>Total Late</b></td>
                                    <td style="width: 75%;"><?=date('H:i', mktime(0, $arrattendance['total_late']))?></td>
                                </tr>
                                <tr>
                                    <td><b>Total Overtime Weekdays</b></td>
                                    <td style="width: 75%;"><?=date('H:i', mktime(0, $arrattendance['total_ot_wkdays']))?></td>
                                </tr>
                                <tr>
                                    <td nowrap><b>Total Overtime Weekends / Holidays</b></td>
                                    <td style="width: 75%;"><?=date('H:i', mktime(0, $arrattendance['total_ot_holidays']))?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if(count($arrleaves) > 0): ?>
                            <p>
                                <i><small>As of <?=date('F', mktime(0, 0, 0, $arrleaves['periodMonth'], 10)).' '.$arrleaves['periodYear']?></small></i>
                            </p>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td><b>Vacation Leave Left</b></td>
                                        <td style="width: 75%;"><?=count($arrleaves) > 0 ? $arrleaves['vlBalance'] : ''?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sick Leave Left</b></td>
                                        <td style="width: 75%;"><?=count($arrleaves) > 0 ? $arrleaves['slBalance'] : ''?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Special Leave Left</b></td>
                                        <td style="width: 75%;"><?=count($arrleaves) > 0 ? number_format($arrleaves['plBalance'],3,".","") : ''?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Forced Leave Left</b></td>
                                        <td style="width: 75%;"><?=count($arrleaves) > 0 ? number_format($arrleaves['flBalance'],3,".","") : ''?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('modals/_att_summary_modal'); ?>