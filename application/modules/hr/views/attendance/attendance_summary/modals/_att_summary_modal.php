<!-- begin absents modal -->
<div id="absents-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Date(s) Absent</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <ul>
                                <?php
                                    foreach($arrattendance['days_absent'] as $absent):
                                        echo '<li>'.date('M d, Y (D)', strtotime($absent)).'</li>';
                                    endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php 
                    $datefrom = date('Y-m').'-01';
                    $dateto = date('Y-m').'-'.cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                    
                    $dtrlink = base_url('hr/attendance_summary/dtr/'.$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto);
                 ?>
                <a href="<?=$dtrlink?>" class="btn btn-sm grey-cascade">
                            <i class="icon-calendar"></i> View DTR </a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"><i class="icon-close"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end absents modal -->
