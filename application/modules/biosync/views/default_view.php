<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>HRMIS | BioSync </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="<?=base_url('assets/css/fonts.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/plugins/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/plugins/simple-line-icons/simple-line-icons.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/plugins/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')?>" rel="stylesheet" type="text/css" />
    
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
        </style>
        
        <div class="menu-toggler sidebar-toggler"></div>
        <div class="logo"></div>

        <div class="container">
            <!-- begin logo -->
            <div class="col-md-12" style="padding-left: 10%; padding-bottom: 2% ">
                <br><img style="height: 70px;" src="<?=base_url('assets/images/logo.png')?>" alt="" />
                <h1 class="hrmisLogo" style="color: #fff!important;">HRMIS</h1>
                <div class="small" style="color: #fff!important;">Human Resource Management Information System</div>
            </div>
            <!-- end logo -->

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6 col-lg-6 col-xl-6" >
                        <div class="content" >
                            <div class="datenow">List of Employees to Sync.</div>
                            <div class="row" style="background-color: white; margin-top: 9%">
                                <div class="col-md-12" id="table-container">
                                    <table class="table table-striped table-bordered table-hover" id="tbldtr-employee">
                                        <thead>
                                            <tr>
                                                <th rowspan="1">Employee Number</th>
                                                <th rowspan="1">DTR Date</th>
                                                <th rowspan="1">DTR Time</th>
                                            </tr> 
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-6 col-xl-6">
                        <div class="content" >
                            <div class="datenow"><?=date('F d, Y')?></div>
                            <div class="clock" id="txtclock"></div>
                            <br><br>
                            <!-- <h4 class="form-title font-green pull-left bold">Daily Time Record</h4> -->
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span> Enter any username and password. </span>
                            </div>
                            <?=form_open('biosync', array('method' => 'post', 'id' => 'formdata'))?>
                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Employee ID</label>
                                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Employee ID" name="txtEmpID" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Date From</label>
                                    <input type="text" class="form-control date-picker" name="txtSyncRecordDatefrom" id="txtSyncRecordDatefrom" value="" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="Date From">
                                </div>
                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Date To</label>
                                    <input type="text" class="form-control date-picker" name="txtSyncRecordDateto" id="txtSyncRecordDateto" value="" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="Date To">
                                </div>
                                <div class="form-group">
                                    <label class="control-label visible-ie8 visible-ie9">Device</label>
                                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Device" name="devicename" />
                                </div>
                                
                                <div class="form-actions" style="border: none;text-align: right;">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <button type="button" onclick="filterData()" class="btn blue uppercase">Filter</button>
                                    <button type="submit" class="btn green uppercase">Sync</button>
                                </div> 
                            <?=form_close()?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div class="copyright"> 2018 © DOST ITD. </div>
            </div>
        </div>

        <script>


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
        <script src="<?=base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>" type="text/javascript"></script>
        
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
        <script src="<?=base_url('assets/js/custom-dtr.js')?>"></script>

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
                $('.date-picker').datepicker();
                $('.date-picker').on('changeDate', function(){
                    $(this).datepicker('hide');
                });

                $('#tbldtr-employee').DataTable(
                {
                    
                });
            });  

            function filterData(){
                if($.fn.DataTable.isDataTable('#tbldtr-employee')) {
                    $('#tbldtr-employee').DataTable().destroy();
                }
                
                $('#tbldtr-employee').empty();
                $('#tbldtr-employee').DataTable({
                    "ajax": {"method":"GET","url":"biosync/bio_sync/filter_dtr","dataType":"json","dataSrc":"",
                        data: {emp:$("input[name=txtEmpID]").val(),dtfrom:$("input[name=txtSyncRecordDatefrom]").val(),dtto:$("input[name=txtSyncRecordDateto]").val(),device:$("input[name=devicename]").val()}},
                        "columns": [
                            {"title":"Emplpoyee Number","data":"empnum"},
                            {"title":"DTR Date","data":"dtrDate"},
                            {"title":"DTR Time","data":"dtrTime"}
                        ],
                        // "scrollY": "200px","scrollCollapse": true,"paging": false,
                        "initComplete": function(settings, json) {
                            $('.loading-image').hide();
                            $('#tbldtr-employee').show();},
                });
                var table = $('#tbldtr-employee').DataTable();
            }
        </script>
    </body>

</html>