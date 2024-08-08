<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>HRMIS | Home</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <?php load_plugin('css',array('global'));?>
        <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.ico')?>" />
        <script src="<?=base_url('assets/js/jquery.min.js')?>" type="text/javascript"></script>
        <script src="<?=base_url('assets/plugins/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>
        <script src="<?=base_url('assets/js/app.js')?>" type="text/javascript"></script>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-footer-fixed">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="<?=base_url('home')?>">
                        <h3 class="logodost logo-default">DOST</h3>&nbsp;<h3 class="logohrmis logo-default">HRMIS</h3> </a>
                    <div class="menu-toggler sidebar-toggler"><img src="<?=base_url('assets/images/logo.png')?>" width="30"></div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> <img src="<?=base_url('assets/images/logo.png')?>" width="30"></a>
                
                <!-- END RESPONSIVE MENU TOGGLER -->
                <div class="hor-menu  hor-menu-light hidden-sm hidden-xs">
                    <ul class="nav navbar-nav">
                        <li class="classic-menu-dropdown">
                            <a href="javascript:void(0)"> <?=strtoupper($this->session->userdata('sessUserPermission'))?>
                                <span class="selected"> </span>
                            </a>
                        </li>  
                    </ul>
                </div>
               
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <?php include("notifications.php");?>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <?php include("sidebar.php");?>
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE CONTENT -->
                    <?=$contents?>
                    <!-- END PAGE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->

        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 2018 &copy; DOST-HRMIS.
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="../assets/plugins/respond.min.js"></script>
<script src="../assets/plugins/excanvas.min.js"></script> 
<![endif]-->
        
        
        <!--script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script-->
        <!--script src="../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script-->
        <?php 
        //include global js plugins
        load_plugin('js',array('global'));?>
        <!-- BEGIN TEMPLATE SCRIPTS -->
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
                $.sessionTimeout({
                    title: 'Session Timeout Notification',
                    message: 'Your session is about to expire.',
                    keepAliveUrl: '<?=base_url('login/timeoutkeepalive')?>',
                    redirUrl: '<?=base_url('logout')?>',
                    logoutUrl: '<?=base_url('logout')?>',
                    warnAfter: 600000, //warn after 5 seconds
                    redirAfter: 700000, //redirect after 10 secons, (1500/second)
                    ignoreUserActivity: true,
                    countdownMessage: 'Redirecting in {timer} seconds.',
                    countdownBar: true
                });
            });  
        </script>
        <!-- END TEMPLATE SCRIPTS -->
    </body>
</html>