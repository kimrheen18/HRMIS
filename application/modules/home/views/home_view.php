<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Dashboard</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12">
	<h3 class="page-title"> Welcome,
	    <strong><i><?=$this->session->userdata('sessName')?></i></strong>
	</h3>
	</div>
</div>
<div class="clearfix"></div>
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-birthday-cake"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$intBirthday?>">0</span>
                </div>
                <div class="desc"> Birthday</div>
            </div>
            <a class="more" href="<?=base_url('home/birthdays')?>"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat red">
            <div class="visual">
                <i class="fa fa-child"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$intVacant?>">0</span> </div>
                <div class="desc"> Vacant Position </div>
            </div>
            <a class="more" href="<?=base_url('home/vacantpositions')?>"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-gift"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$intRetiree?>">0</span>
                </div>
                <div class="desc"> Retiree </div>
            </div>
            <a class="more" href="<?=base_url('home/retirees')?>"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <!--div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple">
            <div class="visual">
                <i class="fa fa-user-plus"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="11"></span> </div>
                <div class="desc"> Step Increment </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div-->
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS -->
<!-- BEGIN APPOINTMENT STATS -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue-sharp">
            <div class="visual">
                <i class="fa fa-group"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$intP?>">0</span>
                </div>
                <div class="desc"> Permanent</div>
            </div>
            <a class="more" href="<?=base_url('home/employees/p')?>"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat red-pink">
            <div class="visual">
                <i class="fa fa-group"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$intCas?>">0</span> 
                </div>
                <div class="desc"> Casual </div>
            </div>
            <a class="more" href="<?=base_url('home/employees/Cas')?>"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat green-meadow">
            <div class="visual">
                <i class="fa fa-group"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?=$intCONT?>">0</span>
                </div>
                <div class="desc"> Contractual </div>
            </div>
            <a class="more" href="<?=base_url('home/employees/CONT')?>"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <!--div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple-plum">
            <div class="visual">
                <i class="fa fa-group"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="0"></span> </div>
                <div class="desc"> Others </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div-->
</div>
<div class="row">
    <div class="portlet-title">
        <div class="caption">
            <span class="col-lg-8 col-sm-12 caption-subject font-purple bold uppercase" style="font-size: 16px" >Health Declaration</span>
        </div>
    </div>
</div>
<div class="row">
    <label class="col-form-label col-lg-1 col-sm-12">Date filter:</label>
    <div class="col-lg-7 col-md-4 col-sm-6 col-xs-12">
        <input type="text" class="form-control form-control-sm date-picker form-required " id="txtdate" name="txtdate" value="<?=date('Y-m-d')?>" data-date-format="yyyy-mm-dd">
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple-plum">
            <div class="visual">
                <i class="fa fa-group"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span id="txttemp" data-counter="counterup" data-value="<?=$intTemp?>">0</span></div>
                <div class="desc"> No. of Personnel w/ temperature above 37.5 </div>
            </div>
            <div id="atemp">
                <!-- href="<?=base_url('home/withhightemps')?>" -->
                <a class="more" > View more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="dashboard-stat purple-plum">
            <div class="visual">
                <i class="fa fa-group"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span id="txtsymp" data-counter="counterup" data-value="<?=$intSymptoms?>">0</span></div>
                <div class="desc"> No. of Personnel experiencing any symptoms </div>

            </div>
            <div id="asymp">
                <!-- href="<?=base_url('home/withsymptoms')?>" -->
                <a class="more"> View more
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
    </div>
</div>  
<div class="clearfix"></div>
<!-- END APPOINTMENT STATS -->


<div class="row">
    <div class="col-md-6 col-sm-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Plantilla Positions</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="chart_plantilla"></div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
    <div class="col-md-6 col-sm-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-share font-red-sunglo hide"></i>
                    <span class="caption-subject font-red-sunglo bold uppercase">Gender</span>                
                </div>
            </div>
            <div class="portlet-body">
                <?php //print_r($arrGenderChart);
                //echo "<br><br>";
                //print_r($arrAS);
                //echo "<br><br>";
                $str = 'data: [';$i=0;//$intTotalMale=0;
                foreach($arrASFull as $row):
                    $strAppCode = $arrGenderChart[$row]['M']['appCode'];
                    $arrGenderAS[$strAppCode]['M'] = 0;
                    $arrGenderAS[$strAppCode]['F'] = 0;
                endforeach;
                foreach($arrASFull as $row):
                    $intTotalMale = $arrGenderChart[$row]['M'][0]['total'];
                    $intTotalFemale = $arrGenderChart[$row]['F'][0]['total'];
                    $strAppCode = $arrGenderChart[$row]['M']['appCode'];
                    //echo $row."<br>";
                    //echo $row.'=>'.$strAppCode.'=>M('.$intTotalMale.") F(".$intTotalFemale.")<br><br>";
                   // echo $arrGenderChart[]
                    $arrGenderAS[$strAppCode]['M']+=$intTotalMale;
                    $arrGenderAS[$strAppCode]['F']+=$intTotalFemale;
                        //$intTotalMale += $arrGenderChart[$row]['M'][0]['total'];
                        //echo $arrGenderChart[$row]['M'][0]['total']."<br>";
                        $str .= $i>0?',':'';
                        $str .= 'data: ['.$arrGenderAS[$strAppCode]['M'].', 105, 85, 70]';
                endforeach;

                $str .= ']';
                //echo $intTotalMale;
                //echo $str;
                //print_r($arrGenderAS);
                //echo "<br>";
                ?>
                <div id="chart_gender">
                    
                </div>
                
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
<?=load_plugin('js',array('datatables','highcharts'));?>

<script>
    $(document).ready(function() {
        $('#tblemployees').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tblemployees').show();
            }, pageLength: 5,} );

        // Build the chart
        $('#chart_plantilla').highcharts({
            chart: {
                height:250,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>';//: '+ this.percentage +' %
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Plantilla Positions',
                data: [
                    ['Filled',   <?=$intFilled?>],
                    ['Vacant',   <?=$intVacant?>]
                ]
            }]
        });

        $('#chart_gender').highcharts({       
            chart: {                
                height:250
            },
            title: {
                text: ''
            },
            xAxis: {
                <?php 
                $str = "categories: [";$i=0;
                foreach($arrAS as $row):
                    $str .= ($i>0?',':'')."'".appstatus_name($row)."'";
                    $i++;
                endforeach;
                $str .= "]";
                echo $str;
                ?>
                // categories: ['Contractual','Job Order','Permanent']
            },
            tooltip: {
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' ';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y;
                    }
                    return s;
                }
            },
            yAxis: {
                title: {
                    text: 'Employees'
                }
            },
            labels: {
                items: [{
                    html: ' ',
                    style: {
                        left: '40px',
                        top: '8px',
                        color: 'black'
                    }
                }]
            },
            series: [{
                type: 'column',
                name: 'Male',
                /*data: [<? for($i=0;$i<count($categories);$i++){
                        echo ($maledata[$i]=="")?0:$maledata[$i];
                        $totalmale+=$maledata[$i];
                        if($i<count($categories)-1) echo ",";
                    }?>]
                    */
                <?php 
                    $str = 'data: [';
                    $i=0;
                    foreach($arrAS as $row):
                        $strAppCode = $arrGenderChart[$row]['M']['appCode'];
                        $arrGenderAS[$strAppCode]['M']+=$intTotalMale;
                        $arrGenderAS[$strAppCode]['F']+=$intTotalFemale;
                        $str .= $i>0?',':'';
                        $str .= $arrGenderAS[$strAppCode]['M'];
                        $i++;
                    endforeach; 
                    $str .= ']';
                    echo $str;
                ?>
                // data: [0,0,0,0] 
                //data: [110, 105, 85, 93, 80]
            }, {
                type: 'column',
                name: 'Female',
                /*data: [<? for($i=0;$i<count($categories);$i++){
                        echo ($femaledata[$i]=="")?0:$femaledata[$i];
                        $totalfemale+=$femaledata[$i];
                        if($i<count($categories)-1) echo ",";
                    }?>]
                    */
                <?php 
                    $str = 'data: [';
                    $i=0;
                    foreach($arrAS as $row):
                        $strAppCode = $arrGenderChart[$row]['F']['appCode'];

                        $arrGenderAS[$strAppCode]['F']+=$intTotalFemale;
                        $str .= $i>0?',':'';
                        $str .= $arrGenderAS[$strAppCode]['F'];
                        $i++;
                    endforeach; 
                    $str .= ']';
                    echo $str;
                ?>
                // data: [0,0,0,0]     
                //data: [145, 122, 90, 106, 98]
            }, //{
                //type: 'spline',
                //name: 'Average',
                /*
                data: [<? for($i=0;$i<count($categories);$i++){
                        echo number_format((($maledata[$i]+$femaledata[$i])/2),2);
                        if($i<count($categories)-1) echo ",";
                    }?>]
                */
                       
                //data: [127.5, 113.5, 87.5, 99.5, 89]
            //}, 
        {
                type: 'pie',
                name: 'Total',
                data: [{
                    name: 'Male',
                    y: <?=$arrGender['intTotalMale']?>,
                    color: Highcharts.getOptions().colors[0]  // Male color
                }, {
                    name: 'Female',
                    y: <?=$arrGender['intTotalFemale']?>,
                    color: Highcharts.getOptions().colors[1] // Female color
                }],
                center: [50, 30],
                size: 75,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });

        $('#txtdate').change(function() {
            var oldURL = window.location.toString();
            var index = 0;
            var newURL = oldURL;
            index = oldURL.indexOf('home');
            if(index == -1){
                index = oldURL.indexOf('?');
            }
            if(index != -1){
                newURL = oldURL.substring(0, index);
            }
            
            $.ajax({
                type: "GET",
                dataType: "json",
                data: {'dtrDate': this.value},
                url: newURL+"home/change_hcddate/",
                success: function (data) {
                    $('#txttemp').html(data.temp);
                    $('#txtsymp').html(data.symp);
                }
            }).fail(function () {
                toastr.error("An error has occurred. Please try again later.");
            });
        });

        $("#atemp a").click(function() {
            var _href = "<?=base_url('home/withhightemp')?>";
            window.location.href = _href + '/' + $('#txtdate').val();
        });

        $("#asymp a").click(function() {
            var _href = "<?=base_url('home/withsymptoms')?>";
            window.location.href = _href + '/' + $('#txtdate').val();
        });

        var dt = $('.date-picker').datepicker({autoclose: true, });
  });//end document ready
</script>
<script src="<?=base_url('assets/plugins/counterup/jquery.waypoints.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/plugins/counterup/jquery.counterup.min.js')?>" type="text/javascript"></script>
<link href="<?=base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>" type="text/javascript"></script>