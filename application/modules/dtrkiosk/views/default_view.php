<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>HRMIS | DTR </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link href="<?=base_url('assets/css/fonts.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/plugins/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/plugins/simple-line-icons/simple-line-icons.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/plugins/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
            
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?=base_url('assets/global/plugins/datatables/datatables.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->

        <link href="<?=base_url('assets/css/components.min.css')?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?=base_url('assets/css/plugins.min.css')?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?=base_url('assets/css/login.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/css/custom-dtr.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/plugins/bootstrap-toastr/toastr.min.css')?>" rel="stylesheet" type="text/css" />

        <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.ico')?>" /> </head>
        <link href="<?=base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css')?>" rel="stylesheet" type="text/css" />
    
        <body onload="startTime()" class=" login">

            <style type="text/css">
                #canvas{
                    width: 100%;
                }
                a.btn-lg {
                    border: 2px solid #d1d1d1;
                    border-radius: 20px !important;
                    margin-left: 40px;
                }
                a.btn-lg:hover {
                    border: 2px solid #fff;
                    background-color: #42638e;
                }
                h1 {
                    color: #32c5d2;
                }
                .tooltip {
                    font-size: 18px !important;
                }
                .logo {
                    margin: 0 !important;
                }
                .toast-message{ font-size: 20px !important; }


                input.form-control.form-required.txtdtpckr {
                    background-color: #fff !important;
                }
                .well {
                    line-height: 4px;
                    padding: 15px;
                }
                .btn-group.bootstrap-select.form-control.bs-select.form-required {
                    padding: 0 !important;
                }

                .has-error .bootstrap-select .btn {
                    border-color: #e73d4a !important;
                }
                .right {
                    text-align: right;
                }

                input[type="text"]::placeholder, input[type="password"]::placeholder { /* Firefox, Chrome, Opera */ 
                    color: #e73d4a; 
                    opacity: .4;
                } 
            </style>
            
            <div class="menu-toggler sidebar-toggler"></div>
            <div class="logo"></div>

            <div class="container">
                <!-- begin logo -->
                <div class="col-md-12" style="padding-left: 10%; padding-bottom: 2% ">
                    <br><img style="height: 70px;" src="<?=base_url('assets/images/logo.png')?>" alt="" />
                    <h1 class="hrmisLogo" style="color: #fff!important;">HRMIS </h1>
                    <div class="small" style="color: #fff!important;">Human Resource Management Information System</div>
                </div>
                <!-- end logo -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6 col-lg-6 col-xl-6">
                            <div class="content">
                                <canvas id="canvas" width="400" height="400" style="background-color:#333"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-6">
                            <div class="content" >
                                <div class="datenow"></div>
                                <div class="daynow"></div>
                                <div class="clock" id="txtclock"></div>
                                <br><br>
                                <h4 class="form-title font-green pull-left bold">Daily Time Record</h4>
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button>
                                    <span> Enter any username and password. </span>
                                </div>
                                <?=form_open('dtr', array('method' => 'post', 'id' =>'dtr_form'))?>
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">Username</label>
                                        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="strUsername" /> 
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label visible-ie8 visible-ie9">Password</label>
                                        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="strPassword" /> 
                                    </div>
                                    <!-- <div class="form-group row">

                                        <input id="wfh-toggle" checked type="checkbox">WFH
                                    </div> -->
                                    <div class="form-group row">
                                        <div class='ot-t' <?= $hw==1 ? 'style="display: none"' : '' ?>>
                                            <label class="col-form-label col-lg-1 col-sm-12 bold font-green">OT</label>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <input id="ot-toggle" type="checkbox" name="ot-toggle">
                                                <input type="text" name="txthw" id="txthw" hidden value=<?= $hw; ?>>
                                            </div>
                                        </div>
                                        <div class='wfh-t' <?= $hw==0 ? 'style="display: none"' : '' ?>>
                                            <!-- <label class="col-form-label col-lg-1 col-sm-12 bold font-green">WFH</label> -->
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <input id="wfh-toggle" type="checkbox" name="wfh-toggle" checked="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions" style="border: none;text-align: right;">
                                        
                                        <input type="text" name="txttime" id="txttime" hidden>
                                        <button type="button" onclick="hcdForm()" class="btn green uppercase" >Submit</button>
                                        <!-- <button type="button" onclick="deleteDTR()" class="btn red uppercase" >Delete DTR today</button> -->
                                    </div> 
                                <?=form_close()?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer">
                    <center>
                        <div class="col-md-12" style="padding-bottom: 30px;" hidden>
                            <a href="javascript:;" id="btn-present" class="btn btn-lg" data-toggle="tooltip" data-placement="top" title="List of Present Employees">
                                <h1><i class="fa fa-check"></i> <i class="fa fa-user"></i></h1>
                            </a>
                            <a href="javascript:;" id="btn-absent" class="btn btn-lg" data-toggle="tooltip" data-placement="top" title="List of Absent Employees">
                                <h1><i class="fa fa-remove"></i> <i class="fa fa-user"></i></h1>
                            </a>
                            <a href="javascript:;" id="btn-ob" class="btn btn-lg" data-toggle="tooltip" data-placement="top" title="List of On Official Business Employees">
                                <h1><i class="fa fa-subway"></i> <i class="fa fa-user"></i></h1>
                            </a>
                            <a href="javascript:;" id="btn-leave" class="btn btn-lg" data-toggle="tooltip" data-placement="top" title="List of On Leave Employees">
                                <h1><i class="fa fa-plane"></i> <i class="fa fa-user"></i></h1>
                            </a>
                        </div>
                        <?php include('_dtr_modal.php'); ?>
                        <?php include('_hcd_modal.php'); ?>
                    </center>

                    <?php if(isset($_SESSION['empNumber']) && !empty($_SESSION['empNumber'])) : ?>
                        <center>
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover" id="tbldtr-emp" style="background-color: white">
                                        <tr> 
                                            <th>Employee Name</th> 
                                            <th>Time In</th> 
                                            <th>Time Out</th> 
                                            <th>Time In</th> 
                                            <th>Time Out</th> 
                                        </tr>
                                        <tr> 
                                            <td><?=$_SESSION['empNumber']?></td> 
                                            <td><?=$_SESSION['inAM']?></td>
                                            <td><?=$_SESSION['outAM']?></td>
                                            <td><?=$_SESSION['inPM']?></td>
                                            <td><?=$_SESSION['outPM']?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </center>
                    <?php endif; ?>
                   
                    <div class="copyright"> 
                        <em>Note: The DATE and TIME of this Daily Time Record is sychronized with the HRMIS server.</em>
                        <br><br>2018 © DOST ITD. 
                    </div>
                </div>
            </div>

            <script>

                var canvas = document.getElementById("canvas");
                var ctx = canvas.getContext("2d");
                var radius = canvas.height / 2;
                ctx.translate(radius, radius);
                radius = radius * 0.90
                setInterval(drawClock, 1000);

                function drawClock() {
                  drawFace(ctx, radius);
                  drawNumbers(ctx, radius);
                  drawTime(ctx, radius);

                    $('#txttime').val($('.datenow').text() +" "+$('#txtclock').text());
                    if($('#txtclock').text() == "12:00:00 AM")
                        location.reload(true);
                }

                function drawFace(ctx, radius) {
                  var grad;
                  ctx.beginPath();
                  ctx.arc(0, 0, radius, 0, 2*Math.PI);
                  ctx.fillStyle = 'white';
                  ctx.fill();
                  grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
                  grad.addColorStop(0, '#333');
                  grad.addColorStop(0.5, 'white');
                  grad.addColorStop(1, '#333');
                  ctx.strokeStyle = grad;
                  ctx.lineWidth = radius*0.1;
                  ctx.stroke();
                  ctx.beginPath();
                  ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
                  ctx.fillStyle = '#333';
                  ctx.fill();
                }

                function drawNumbers(ctx, radius) {
                  var ang;
                  var num;
                  ctx.font = radius*0.15 + "px arial";
                  ctx.textBaseline="middle";
                  ctx.textAlign="center";
                  for(num = 1; num < 13; num++){
                    ang = num * Math.PI / 6;
                    ctx.rotate(ang);
                    ctx.translate(0, -radius*0.85);
                    ctx.rotate(-ang);
                    ctx.fillText(num.toString(), 0, 0);
                    ctx.rotate(ang);
                    ctx.translate(0, radius*0.85);
                    ctx.rotate(-ang);
                  }
                }

                function drawTime(ctx, radius){
                    var now = new Date();

                    // var hour = now.getHours();
                    // var minute = now.getMinutes();
                    // var second = now.getSeconds();
                    var hour = h;
                    var minute = m;
                    var second = s;
                    var timeOfDay = (hour < 12) ? "AM" : "PM";

                    // Convert the hours our of 24-hour time
                    hour = (hour > 12) ? hour - 12 : hour;
                    hour = (hour == 0) ? 12 : hour;

                    // document.getElementById('txtclock').innerHTML = ('0' + hour).slice(-2) + ":" + ('0' + minute).slice(-2) + ":" + ('0' + second).slice(-2) + " " + timeOfDay;
                    hour=hour%12;
                    hour=(hour*Math.PI/6)+
                    (minute*Math.PI/(6*60))+
                    (second*Math.PI/(360*60));
                    drawHand(ctx, hour, radius*0.5, radius*0.07);
                    minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
                    drawHand(ctx, minute, radius*0.8, radius*0.07);
                    second=(second*Math.PI/30);
                    drawHand(ctx, second, radius*0.9, radius*0.02);
                }

                function drawHand(ctx, pos, length, width) {
                    ctx.beginPath();
                    ctx.lineWidth = width;
                    ctx.lineCap = "round";
                    ctx.moveTo(0,0);
                    ctx.rotate(pos);
                    ctx.lineTo(0, -length);
                    ctx.stroke();
                    ctx.rotate(-pos);
                }

                function pad(num, size) {
                    var s = num+"";
                    while (s.length < size) s = "0" + s;
                    return s;
                }

            </script>
            <!-- BEGIN CORE PLUGINS -->
            <script src="<?=base_url('assets/global/plugins/jquery.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/js.cookie.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/jquery.blockui.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/uniform/jquery.uniform.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')?>" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="<?=base_url('assets/global/plugins/jquery.pulsate.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/jquery-bootpag/jquery.bootpag.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/holder.js')?>" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="<?=base_url('assets/global/scripts/datatable.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/datatables/datatables.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')?>" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <script src="<?=base_url('assets/plugins/bootstrap-toastr/toastr.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/js/ui-toastr.js')?>" type="text/javascript"></script>
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="<?=base_url('assets/global/scripts/app.min.js')?>" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="<?=base_url('assets/pages/scripts/table-datatables-scroller.min.js')?>" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            <script src="<?=base_url('assets/pages/scripts/ui-general.min.js')?>" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="<?=base_url('assets/layouts/layout/scripts/layout.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/layouts/layout/scripts/demo.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/layouts/global/scripts/quick-sidebar.min.js')?>" type="text/javascript"></script>
            <!-- END THEME LAYOUT SCRIPTS -->
            <script src="<?=base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>" type="text/javascript"></script>

            <script src="<?=base_url('assets/js/custom-dtr.js')?>"></script>
            <script src="<?=base_url('assets/js/custom-dtr-hcd.js')?>"></script>

            <script src="<?=base_url('assets/plugins/jspdf/jspdf.min.js')?>"></script>
            <script src="<?=base_url('assets/plugins/jspdf/jspdf-autotable.js')?>"></script>
            <script src="<?=base_url('assets/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js')?>"></script>

            <script src="<?=base_url('assets/plugins/FileSaver.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/plugins/sheetjs/xlsx.full.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/plugins/sheetjs/xlsx.core.min.js')?>" type="text/javascript"></script>
            <script src="<?=base_url('assets/plugins/sheetjs/cpexcel.js')?>" type="text/javascript"></script>
            

            <script>
                $(document).ready(function(){
                    toastr.options = {
                      "closeButton": true,
                      "debug": false,
                      "positionClass": "toast-top-right",
                      "onclick": null,
                      "showDuration": "10000",
                      "hideDuration": "10000",
                      "timeOut": "10000",
                      "extendedTimeOut": "10000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                    /* Set flash message */
                    <?php if($this->session->flashdata('strMsg')!=''):?>
                        toastr.warning('<?=$this->session->flashdata('strMsg')?>')
                    <?php endif;?>

                    <?php if($this->session->flashdata('strSuccessMsg')!=''):?>
                        toastr.success('<?=$this->session->flashdata('strSuccessMsg')?>', 'Success')
                    <?php endif;?>

                    <?php if($this->session->flashdata('strErrorMsg')!=''):?>
                        toastr.error('<?=$this->session->flashdata('strErrorMsg')?>')
                    <?php endif;?>
                    /* set session timeout */
                    // $.sessionTimeout({
                    //     title: 'Session Timeout Notification',
                    //     message: 'Your session is about to expire.',
                    //     keepAliveUrl: '<?=base_url('login/timeoutkeepalive')?>',
                    //     redirUrl: '<?=base_url('logout')?>',
                    //     logoutUrl: '<?=base_url('logout')?>',
                    //     warnAfter: 600000, //warn after 5 seconds
                    //     redirAfter: 700000, //redirect after 10 secons, (1500/second)
                    //     ignoreUserActivity: true,
                    //     countdownMessage: 'Redirecting in {timer} seconds.',
                    //     countdownBar: true
                    // });

                    // setTimeout(function() {
                    //     $(".alert").alert('close');
                    // }, 20000);

                    const monthNames = ["January", "February", "March", "April", "May", "June",
                      "July", "August", "September", "October", "November", "December"
                    ];
                    const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                    const d = new Date();
                    $('.datenow').text(monthNames[d.getMonth()] + " " + String(d.getDate()).padStart(2, '0') + ", " + d.getFullYear());
                    $('.daynow').text(dayNames[d.getDay()]);

                    $('#wfh-toggle').bootstrapToggle({
                        on: 'WFH', 
                        off: 'Office'
                    });

                    $('#ot-toggle').bootstrapToggle({
                        on: 'Yes', 
                        off: 'No'
                    });

                    var url = "<?php echo base_url() ?>dtrkiosk/dtr_kiosk/dtr_time";
                    var _h = 0;
                    var _m = 0;
                    var _s = 0;
                    // console.log(url);
                    $.ajax({ 
                        url: url,
                        type: 'GET',
                        dataType: 'JSON', 
                        success: function(res) {
                            var timer = setInterval(jam_server,1000);
                            console.log(res);
                            
                            function jam_server(){
                                h = parseInt(res.hour)+_h;
                                m = parseInt(res.minute)+_m;
                                s = parseInt(res.second)+_s;
                                if (s>59){                  
                                    s=s-60;
                                    _s=_s-60;                   
                                }
                                if(s==59){
                                    _m++;   
                                }
                                if (m>59){
                                    m=m-60;
                                    _m=_m-60;                   
                                }
                                if(m==59&&s==59){
                                    _h++;   
                                }   
                                _s++;
                                $('#txtclock').html(append_zero(h)+':'+append_zero(m)+':'+append_zero(s)+' '+res.ampm);                
                                
                            }
                            function append_zero(n){
                                if(n<10){
                                    return '0'+n;
                                }
                                else
                                    return n;
                            }
                            
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr.statusText + "\r\n" + xhr.responseText);            
                        }
                    });

                    setTimeout(function(){
                       location.reload(true);
                    }, 360*60000);
                });  
            </script>
        </body>

</html>