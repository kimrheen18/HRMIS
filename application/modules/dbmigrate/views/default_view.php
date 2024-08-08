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

        <link href="<?=base_url('assets/global/plugins/uniform/css/uniform.default.css')?>" rel="stylesheet" type="text/css" />
        <link href="<?=base_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')?>" rel="stylesheet" type="text/css" />

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
    
        <body class=" login">

            <style type="text/css">
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
            </style>

            <div class="menu-toggler sidebar-toggler"></div>
            <div class="logo"></div>

            <!-- begin logo -->
            <div class="col-md-12">
                <div style="margin-left: 264px;">
                    <br><img style="height: 70px;" src="<?=base_url('assets/images/logo.png')?>" alt="" />
                    <h1 class="hrmisLogo" style="color: #fff!important;">HRMIS</h1>
                    <div class="small" style="color: #fff!important;">Human Resource Management Information System</div>
                </div>

                <div class="col-md-12">
                    <div style="margin-left: 250px;margin-top:5px;">
                        <h3 class="form-title font-green pull-left bold">Database Migration</h3>
                    </div>
                </div>

                <div class="row" style="margin-left: 250px;">
                    <div class="col-md-10">
                        <div class="portlet light bordered">
                            <div class="row">
                                <!-- begin previous database setup-->
                                <div class="col-md-6">
                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption font-blue">
                                                <i class="fa fa-database font-blue"></i>
                                                <span class="caption-subject bold uppercase"> Database Settings</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="control-label">Host <span class="required">*</span></label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-warning tooltips" data-original-title="Please provide a database host" style="display: none;"></i>
                                                        <i class="fa fa-check tooltips" style="display: none;"></i>
                                                        <input type="text" id="txthost" class="form-control" autocomplete="off" value="<?=$_ENV['DB_HOST']?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Database name <span class="required">*</span></label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-warning tooltips" data-original-title="Please provide a database name" style="display: none;"></i>
                                                        <i class="fa fa-check tooltips" style="display: none;"></i>
                                                        <input type="text" id="txtdbname" class="form-control" autocomplete="off" value="<?=$_ENV['DB_NAME']?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Username <span class="required">*</span></label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-warning tooltips" data-original-title="Please provide a database username" style="display: none;"></i>
                                                        <i class="fa fa-check tooltips" style="display: none;"></i>
                                                        <input type="text" id="txtuname" class="form-control" autocomplete="off" value="<?=$_ENV['DB_USER']?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Password <span class="required">*</span></label>
                                                    <div class="input-icon right">
                                                        <i class="fa fa-warning tooltips" data-original-title="Please provide a database password" style="display: none;"></i>
                                                        <i class="fa fa-check tooltips" style="display: none;"></i>
                                                        <input type="password" id="txtpass" class="form-control" autocomplete="off" value="<?=$_ENV['DB_PASS']?>">
                                                        <small><input type="checkbox" onclick="viewPassword()">Show Password</small>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="check" style="margin-top: 10px;">
                                                        <input type="checkbox" name="chkinipass" id="chkinipass" value="1" />Set Initial User Account Password </label>
                                                    <div class="input-icon right" id="div-inipass" style="display: none;">
                                                        <i class="fa fa-warning tooltips" data-original-title="Please provide a initial password" style="display: none;"></i>
                                                        <i class="fa fa-check tooltips" style="display: none;"></i>
                                                        <input type="password" id="txtinipass" name="txtinipass" class="form-control" autocomplete="off">
                                                        <small><input type="checkbox" onclick="viewIniPassword()">Show Password</small>
                                                    </div>
                                                </div>
                                                <div class="note note-danger" style="text-align: justify;">
                                                    <small>
                                                        <span class="label label-danger">REMINDER!</span>
                                                        <span class="bold">You are about to update your current database.</span> 
                                                        We recommend to create backup before you proceed.
                                                        There is no undo command to revert the changes. Click <b>Submit</b> to continue.
                                                    </small>
                                                </div>
                                                <button type="submit" class="btn green" id="btnmigrate">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end previous database setup -->

                                <!-- begin logs -->
                                <div class="col-md-6">
                                    <div class="portlet light">
                                        <div class="portlet-body form" style="margin-top: 100px;">
                                            <div class="scroller code" style="display: none;height:450px;" data-always-visible="0" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                        </div>
                                    </div>
                                </div>
                                <!-- end logs -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end logo -->

            <div class="footer">
                <div class="copyright"> 2018 © DOST ITD. </div>
            </div>

            <!-- start modal -->
            <?php include('_modal_migrate.php'); ?>
            <!-- end modal -->
            
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
            <script src="<?=base_url('assets/js/migrate.js')?>"></script>

            <script>
                $(document).ready(function(){
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
                });  
            </script>
        </body>

</html>