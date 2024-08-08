<?php load_plugin('css',array('datatables'));?>
<div class="tab-pane active" id="tab_1_3">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Certify Offsets</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <a href="<?=base_url('hr/attendance_summary/dtr/').$arrData['empNumber'].'/?datefrom='.currdfrom().'&dateto='.currdto()?>" class="btn grey-cascade">
                            <i class="icon-calendar"></i> DTR </a>
                        <br><br>
                        <?=form_open('employee/Compensatory_leave/certify_offset/'.$arrData['empNumber'].'?datefrom='.currdfrom().'&dateto='.currdto(), array('method' => 'post', 'id' => 'frmcertif_offset'))?>
                        <table class="table table-striped table-bordered table-hover" id="table-offsets">
                            <thead>
                                <tr>
                                    <th rowspan="2"></th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">Date</th>
                                    <th style="text-align: center;" colspan="2">AM</th>
                                    <th style="text-align: center;" colspan="2">PM</th>
                                    <th style="text-align: center;" colspan="2">OT</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">Remarks</th>
                                    <th style="text-align: center;vertical-align: middle;" rowspan="2">Hrs OT</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">In</th>
                                    <th style="text-align: center;">Out</th>
                                    <th style="text-align: center;">In</th>
                                    <th style="text-align: center;">Out</th>
                                    <th style="text-align: center;">In</th>
                                    <th style="text-align: center;border-right:1px solid #e7ecf1;">Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $arrot_id = array();
                                $allcertified_id = '';
                                foreach($arrots as $ot):
                                    $in_am  = count($ot['dtr']) > 0 ? $ot['dtr']['inAM']  == '00:00:00' || $ot['dtr']['inAM']  == '' ? '00:00' : date('h:i',strtotime($ot['dtr']['inAM']))  : '';
                                    $out_am = count($ot['dtr']) > 0 ? $ot['dtr']['outAM'] == '00:00:00' || $ot['dtr']['outAM'] == '' ? '00:00' : date('h:i',strtotime($ot['dtr']['outAM'])) : '';
                                    $in_pm  = count($ot['dtr']) > 0 ? $ot['dtr']['inPM']  == '00:00:00' || $ot['dtr']['inPM']  == '' ? '00:00' : date('h:i',strtotime($ot['dtr']['inPM']))  : '';
                                    $out_pm = count($ot['dtr']) > 0 ? $ot['dtr']['outPM'] == '00:00:00' || $ot['dtr']['outPM'] == '' ? '00:00' : date('h:i',strtotime($ot['dtr']['outPM'])) : '';
                                    $in_ot  = count($ot['dtr']) > 0 ? $ot['dtr']['inOT'] == '00:00:00' || $ot['dtr']['inOT'] == '' ? '' : date('h:i',strtotime($ot['dtr']['inOT'])) : '';
                                    $out_ot = count($ot['dtr']) > 0 ? $ot['dtr']['outOT'] == '00:00:00' || $ot['dtr']['outOT'] == '' ? '' : date('h:i',strtotime($ot['dtr']['outOT'])) : '';
                                    $certified_ot = 0;
                                    if(count($ot['dtr']) > 0):
                                        if($ot['dtr']['OT'] == 1):
                                            $certified_ot = 1;
                                        endif;
                                    endif;
                                    array_push($arrot_id,$ot['dtr']['id']);?>
                                    <tr>
                                        <td align="center">
                                            <?php if($certified_ot): ?>
                                                <?php $allcertified_id = $allcertified_id.';'.$ot['dtr']['id']; ?>
                                                <input type="checkbox" name="certified_ot[]" class="chkcert" value="<?=$ot['dtr']['id']?>" checked disabled>
                                            <?php else: ?>
                                                <input type="checkbox" name="certified_ot[]" value="<?=$ot['dtr']['id']?>" >
                                            <?php endif; ?>
                                        </td>
                                        <td align="center"><?=$ot['dtrdate']?>
                                        <td align="center"><?=$in_am?></td>
                                        <td align="center"><?=$out_am?></td>
                                        <td align="center"><?=$in_pm?></td>
                                        <td align="center"><?=$out_pm?></td>
                                        <td align="center"><?=$in_ot?></td>
                                        <td align="center"><?=$out_ot?></td>
                                        <td align="center"><?=$ot['dtr']['remarks']?></td>
                                        <td align="center" nowrap>
                                            <?=$ot['ot'] > 0 ? date('H:i', mktime(0, $ot['ot'])) : '';?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="txtot_id" value='<?=json_encode($arrot_id)?>'>
                        <input type="hidden" name="txtoffset" id="txtoffset">
                        <input type="hidden" name="txtallcertified_id" value="<?=$allcertified_id?>"></td>
                        <button class="btn green" type="submit" id="btnoffset">
                            <i class="fa fa-check"></i> Update Offset</button>
                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#table-offsets').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#table-offsets').show();
            }} );

        $('#btnoffset').on('click',function(e) {
            arr = $('#table-offsets').find('[type="checkbox"]:checked').map(function(){
                  return $(this).val();
            }).get();

            $('#txtoffset').val(arr);
        });
    });
</script>