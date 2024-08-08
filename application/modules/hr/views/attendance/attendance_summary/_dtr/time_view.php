<?php load_plugin('css',array('datatables'));?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Time</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <a href="<?=base_url('hr/attendance_summary/dtr/').$arrData['empNumber'].'/?datefrom='.currdfrom().'&dateto='.currdto()?>" class="btn grey-cascade">
                            <i class="icon-calendar"></i> DTR </a>
                        <a class="btn blue" href="<?=base_url('hr/attendance_summary/dtr/time_add/').$arrData['empNumber']?>">
                            <i class="fa fa-plus"></i> Add Time</a>
                        <br><br>
                        
                        <table class="table table-striped table-bordered table-hover" id="table-dtrtime">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center;">No</th>
                                    <th rowspan="2" style="text-align: center;">Date</th>
                                    <th colspan="2" style="text-align: center;">Morning</th>
                                    <th colspan="2" style="text-align: center;">Afternoon</th>
                                    <th colspan="2" style="text-align: center;">Overtime</th>
                                    <th rowspan="2" style="text-align: center;">Last Updated<br>By</th>
                                    <th rowspan="2" style="text-align: center;">Last Updated<br>Date</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">Time in</th>
                                    <th style="text-align: center;">Time out</th>
                                    <th style="text-align: center;">Time in</th>
                                    <th style="text-align: center;">Time out</th>
                                    <th style="text-align: center;">Time in</th>
                                    <th style="text-align: center;">Time out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no=1;
                                foreach($arrdtrTime as $dtr):
                                    $editby = explode(';',$dtr['name']);
                                    $editdate = explode(';',$dtr['editdate']);
                                    $in_am = $dtr['inAM']  == '' || $dtr['inAM']  == '00:00:00' ? '' : date('h:i',strtotime($dtr['inAM']));
                                    $out_am= $dtr['outAM'] == '' || $dtr['outAM'] == '00:00:00' ? '' : date('h:i',strtotime($dtr['outAM']));
                                    $in_pm = $dtr['inPM']  == '' || $dtr['inPM']  == '00:00:00' ? '' : date('h:i',strtotime($dtr['inPM']));
                                    $out_pm= $dtr['outPM'] == '' || $dtr['outPM'] == '00:00:00' ? '' : date('h:i',strtotime($dtr['outPM']));
                                    $ot_in = $dtr['inOT']  == '' || $dtr['inOT']  == '00:00:00' ? '' : date('h:i',strtotime($dtr['inOT']));
                                    $ot_out= $dtr['outOT'] == '' || $dtr['outOT'] == '00:00:00' ? '' : date('h:i',strtotime($dtr['outOT']));
                                    ?>
                                <tr>
                                    <td align="center"><?=$no++?></td>
                                    <td align="center"><?=$dtr['dtrDate']?></td>
                                    <td align="center"><?=$in_am?></td>
                                    <td align="center"><?=$out_am?></td>
                                    <td align="center"><?=$in_pm?></td>
                                    <td align="center"><?=$out_pm?></td>
                                    <td align="center"><?=$ot_in?></td>
                                    <td align="center"><?=$ot_out?></td>
                                    <td><?=$editby[count($editby)-1]?></td>
                                    <td><?=$editdate[count($editdate)-1]?></td>
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

<div id="modal-deleteTime" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Time</h4>
            </div>
            <?=form_open('finance/compensation/personnel_profile/actionLongevity/'.$this->uri->segment(5), array('id' => 'frmrollback'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-12">
                            <input type="hidden" name="txtdel_action" id="txtdel_action">
                            <div class="form-group">
                                <label>Are you sure you want to Delete this data?</label>
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
        $('#table-dtrtime').dataTable();
        $('#table-dtrtime').on('click', 'button.btn-delete', function() {
            $('#txtdel_action').val($(this).data('id'));
            $('#modal-deleteHoliday').modal('show');
        });
    });
</script>