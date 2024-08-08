<?=load_plugin('css', array('profile-2','datatables','select2'))?>
<div class="tab-pane active" id="tab_1_4">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=form_open('', array('class' => 'form-inline', 'method' => 'get'))?>
                <div class="col-md-3"></div>
                <div class="form-group" style="display: inline-flex;">
                    <label style="padding: 6px;">Month</label>
                    <select class="bs-select form-control" name="mon">
                        <?php foreach (range(1, 12) as $m): ?>
                            <option value="<?=$m?>" <?=isset($_GET['mon']) ? $_GET['mon'] == $m ? 'selected' : '' : date('n') == $m?>>
                                <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="display: inline-flex;">
                    <label style="padding: 6px;">Year</label>
                    <select class="bs-select form-control" name="yr">
                        <?php foreach (getYear() as $yr): ?>
                            <option value="<?=$yr?>" <?=isset($_GET['yr']) ? $_GET['yr'] == $yr ? 'selected' : '' : date('n') == $yr?>>
                                <?=$yr?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: -3px;">Search</button>
            <?=form_close()?>
            
            <table class="table table-striped table-bordered order-column" id="tbldtr">
                <thead>
                    <tr>
                        <th class="no-sort">DATE</th>
                        <th class="no-sort">IN</th>
                        <th class="no-sort">OUT</th>
                        <th class="no-sort">IN</th>
                        <th class="no-sort">OUT</th>
                        <th class="no-sort">IN</th>
                        <th class="no-sort">OUT</th>
                        <th class="no-sort">REMARKS</th>
                        <th class="no-sort">LATE</th>
                        <th class="no-sort">OT</th>
                        <th class="no-sort">UT</th>
                        <th class="no-sort">LOGS</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($arrDtr as $dtr): ?>
                    <tr class="<?=$dtr['wday'] != 'Saturday' && $dtr['wday'] != 'Sunday' ? '' : 'active'?>">
                        <td><?=$dtr['mday']?></td>
                        <?php if($dtr['data']!=null): ?>
                            <td><?=date('H:i', strtotime($dtr['data']['inAM']))?></td>
                            <td><?=date('H:i', strtotime($dtr['data']['outAM']))?></td>
                            <td><?=date('H:i', strtotime($dtr['data']['inPM']))?></td>
                            <td><?=date('H:i', strtotime($dtr['data']['outPM']))?></td>
                            <td><?=date('H:i', strtotime($dtr['data']['inOT']))?></td>
                            <td><?=date('H:i', strtotime($dtr['data']['outOT']))?></td>
                            <td><?=$dtr['data']['remarks']?>
                                <?=$dtr['ob']?></td>
                            <td><?=$dtr['late']?></td>
                            <td><?=$dtr['overtime']?></td>
                            <td><?=$dtr['undertime']?></td>
                            <td></td>
                        <?php else: ?>
                            <td colspan=11 align="center" class="uppercase sbold center"><?=$dtr['wday'] != 'Saturday' && $dtr['wday'] != 'Sunday' ? $dtr['holiday'] : $dtr['wday']?></td>
                            <?=str_repeat("<td class='hide'></td>",10)?>
                        <?php endif ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?=load_plugin('js', array('datatables','select2','datatables-scroller'))?>
<script>
    $(document).ready(function() {
        $('td.hide').hide();
        $('#tbldtr').dataTable({
            "scrollY": "350px",
            "scrollCollapse": true,
            "paging": false,
            // "scrollX": "100%",
            "bSort": false
        });
        setTimeout(function () { $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();},200);
    });
</script>