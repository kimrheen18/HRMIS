<?=load_plugin('css',array('datatables'));?>
<?php
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $yr = isset($_GET['yr']) ? $_GET['yr'] : date('Y');
    $tab = isset($_GET['tab']) ? $_GET['tab'] : '';?>

<div class="tab-pane active" id="tab_1_2">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> <i class="fa fa-file-o"></i> Filed Request</span>&nbsp;
                </div>
            </div>
            
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <!-- <li class="<?=$tab=='comm' || $tab==''? 'active' : ''?>">
                            <a data-value="comm" href="#tab-comm" class="filed_req" data-toggle="tab"> Commutation </a>
                        </li> -->
                        <li class="<?=$tab=='ob'|| $tab==''? 'active' : ''?>">
                            <a data-value="ob" href="#tab-ob" class="filed_req" data-toggle="tab"> Official Business </a>
                        </li>
                        <li class="<?=$tab=='leave'? 'active' : ''?>">
                            <a data-value="leave" href="#tab-leave" class="filed_req" data-toggle="tab"> Leave </a>
                        </li>
                        <li class="<?=$tab=='to'? 'active' : ''?>">
                            <a data-value="to" href="#tab-to" class="filed_req" data-toggle="tab"> Travel Order </a>
                        </li>
                         <li class="<?=$tab=='pds_update'? 'active' : ''?>">
                            <a data-value="pds_update" href="#tab-pds_update" class="filed_req" data-toggle="tab"> PDS Update </a>
                        </li>
                        <li class="<?=$tab=='mone'? 'active' : ''?>">
                            <a data-value="mone" href="#tab-mone" class="filed_req" data-toggle="tab"> Monetization </a>
                        </li>
                        <li class="<?=$tab=='dtr'? 'active' : ''?>">
                            <a data-value="dtr" href="#tab-dtr" class="filed_req" data-toggle="tab"> DTR Update </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- begin commutation order -->
                        <div class="tab-pane <?=$tab=='comm' || $tab==''? 'active' : ''?>" id="tab-comm">
                            <table class="table table-bordered table-hover" id="tbl-comm">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 50px;">No</th>
                                        <th style="text-align: center;">Date File</th>
                                        <th style="text-align: center;">Date Request</th>
                                        <th style="text-align: center;">Purpose</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($arrcomm as $commutation): if(count($commutation) > 0): $rdate = explode(';', $commutation['requestDetails']); ?>
                                    <tr>
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$commutation['requestDate']?></td>
                                        <td align="center"><?=join('-',array($rdate[3],$rdate[2],$rdate[1] == '' ? $rdate[0] : $rdate[1] ))?></td>
                                        <td align="center"><?=$rdate[4]?></td>
                                        <td align="center"><?=$commutation['requestStatus']?></td>
                                    </tr>
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end commutation order -->

                        <!-- begin dtr -->
                        <div class="tab-pane <?=$tab=='dtr'? 'active' : ''?>" id="tab-dtr">
                            <table class="table table-bordered table-hover" id="tbl-dtr">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 50px;">No</th>
                                        <th style="text-align: center;">Date Filed</th>
                                        <th style="text-align: center;">Date</th>
                                        <th style="text-align: center;width: 250px;">Time</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($arrdtr as $rdtr): if(count($rdtr) > 0): $rdate = explode(';', $rdtr['requestDetails']); ?>
                                    <tr>
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$rdtr['requestDate']?></td>
                                        <td align="center"><?=$rdate[0]?></td>
                                        <td><small>
                                           <?php //$rdate[12].' : '.$rdate[13].' : '.$rdate[14].' - '.$rdate[15]
                                            echo '<b>Morning:</b> '.$rdate[8].' : '.$rdate[9].' : '.$rdate[10].' - '.$rdate[11].'<br>';
                                            echo '<b>Afternoon:</b> '.$rdate[20].' : '.$rdate[21].' : '.$rdate[22].' - '.$rdate[23];?></small>
                                        </td>
                                        <td align="center"><?=$rdtr['requestStatus']?></td>
                                    </tr>
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end dtr -->

                        <!-- begin leave -->
                        <div class="tab-pane <?=$tab=='leave'? 'active' : ''?>" id="tab-leave">
                            <table class="table table-bordered table-hover" id="tbl-leave">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 50px;">No</th>
                                        <th style="text-align: center;">Date Filed</th>
                                        <th style="text-align: center;">Leave Type</th>
                                        <th style="text-align: center;">Date From</th>
                                        <th style="text-align: center;">Date To</th>
                                        <th style="text-align: center;">Reason</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($arrleave as $rleave): if(count($rleave) > 0): $rdate = explode(';', $rleave['requestDetails']); ?>
                                    <tr>
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$rleave['requestDate']?></td>
                                        <td align="center"><?=$rdate[0]?></td>
                                        <td align="center"><?=$rdate[2]?></td>
                                        <td align="center"><?=$rdate[3]?></td>
                                        <td align="center"><?=$rdate[1]?></td>
                                        <td align="center"><?=$rleave['requestStatus']?></td>
                                    </tr>
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end leave -->

                        <!-- begin monetization order -->
                        <div class="tab-pane <?=$tab=='mone'? 'active' : ''?>" id="tab-mone">
                            <table class="table table-bordered table-hover" id="tbl-mone">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 50px;">No</th>
                                        <th style="text-align: center;">Date Filed</th>
                                        <th style="text-align: center;">Monetized on VL</th>
                                        <th style="text-align: center;">Monetized on SL</th>
                                        <th style="text-align: center;">Month / Year</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($arrmonetize as $monetize): if(count($monetize) > 0): $rdate = explode(';', $monetize['requestDetails']); ?>
                                    <tr>
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$monetize['requestDate']?></td>
                                        <td align="center"><?=$rdate[0]?></td>
                                        <td align="center"><?=$rdate[1]?></td>
                                        <td align="center"><?=date('F', mktime(0, 0, 0, $rdate[2], 10))?> <?=$rdate[3]?></td>
                                        <td align="center"><?=$monetize['requestStatus']?></td>
                                    </tr>
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end monetization order -->

                        <!-- begin official business -->
                        <div class="tab-pane <?=$tab=='ob'? 'active' : ''?>" id="tab-ob">
                            <table class="table table-bordered table-hover" id="tbl-ob">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 50px;">No</th>
                                        <th style="text-align: center;">Date Filed</th>
                                        <th style="text-align: left;">Place</th>
                                        <th style="text-align: left;">Purpose</th>
                                        <th style="text-align: left;">From</th>
                                        <th style="text-align: left;">To</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($arrob as $ob): if(count($ob) > 0): $rdate = explode(';', $ob['requestDetails']); ?>
                                    <tr>
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$ob['requestDate']?></td>
                                        <td align="left"><?=$rdate[6]?></td>
                                        <td align="left"><?=$rdate[7]?></td>
                                        <td align="left"><?=$rdate[2]?> <?=$rdate[4]?></td>
                                        <td align="left"><?=$rdate[3]?> <?=$rdate[5]?></td>
                                        <td align="center"><?=$ob['requestStatus']?></td>
                                    </tr>
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end official business -->

                        <!-- begin travel order -->
                        <div class="tab-pane <?=$tab=='to'? 'active' : ''?>" id="tab-to">
                            <table class="table table-bordered table-hover" id="tbl-to">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 50px;">No</th>
                                        <th style="text-align: center;">Date Filed</th>
                                        <th style="text-align: left;">Place</th>
                                        <th style="text-align: left;">Purpose</th>
                                        <th style="text-align: left;">From</th>
                                        <th style="text-align: left;">To</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($arrto as $to): if(count($to) > 0): $rdate = explode(';', $to['requestDetails']); ?>
                                    <tr>
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$to['requestDate']?></td>
                                        <td align="left"><?=$rdate[0]?></td>
                                        <td align="left"><?=$rdate[3]?></td>
                                        <td align="left"><?=$rdate[1]?></td>
                                        <td align="left"><?=$rdate[2]?></td>
                                        <td align="center"><?=$to['requestStatus']?></td>
                                    </tr>
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end travel order -->

                        <!-- begin pds update -->
                        <div class="tab-pane <?=$tab=='pds_update'? 'active' : ''?>" id="tab-pds_update">
                            <table class="table table-bordered table-hover" id="tbl-pds_update">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 50px;">No</th>
                                        <th style="text-align: center;">Request Date</th>
                                        <th style="text-align: center;">Type of Profile</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($arrpds as $pds): if(count($pds) > 0): $pds_details = explode(';', $pds['requestDetails']); ?>
                                    <tr>
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$pds['requestDate']?></td>
                                        <td align="center"><?=$pds_details[0]?></td>
                                        <td align="center"><?=$pds['requestStatus']?></td>
                                    </tr>
                                    <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end pds update -->
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#tbl-comm,#tbl-dtr,#tbl-leave,#tbl-mone,#tbl-ob,#tbl-to,#tbl-pds_update').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#employee_view').show();
            }, "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
        });

        $('.filed_req').click(function() {
            $('#txttab').val($(this).data('value'));
        });
    });
</script>