<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>HRMIS | User Login </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <?php include('css.php');?>
        
        <link rel="shortcut icon" href="<?=base_url('assets/images/DENR-LOGO.png')?>" /> </head>
    <body class=" login">
        <div class="menu-toggler sidebar-toggler"></div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
        <!-- BEGIN LOGO -->
        <div class="logo">
            <!-- <a href="index.html"> -->
                <!-- <img style="height: 50px;" src="../hrmis_images/logo.png" alt="" /> </a> -->
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <br><img style="height: 50px;" src="<?=base_url('assets/images/DENR-LOGO.png')?>" alt="" />
            <h1 class="hrmisLogo">DENR</h1>
            <div class="small">Human Resource Management Information System</div>
            <h3 class="form-title font-green">Log In</h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter any username and password. </span>
            </div>
            <?=form_open(base_url('login'), array('method' => 'post'))?>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="strUsername" maxlength="20" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="strPassword" maxlength="60" /> </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">Log in</button>
                    <!--label class="rememberme check">
                        <input type="checkbox" name="remember" value="1" />Remember </label-->
                    <!--a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a-->
                </div>
                 <div class="create-account">
                    <p class="small"><b>The Human Resource Management Information System (HRMIS)</b> is a comprehensive and proactive human resources system designed to provide a single interface for government employees to perform the human resources management functions efficiently and effectively.</p>
                </div> 
            <?=form_close()?>
            <!-- END LOGIN FORM -->

        </div>
        <div class="copyright"> 2021 © DENR ITD. </div>
        <!--[if lt IE 9]>
<script src="../assets/plugins/respond.min.js"></script>
<script src="../assets/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <?php include('js.php');?>
        <script>
            $(document).ready(function(){

                <?php if($this->session->flashdata('strErrorMsg')!=''):?>
                    toastr.error('<?=$this->session->flashdata('strErrorMsg')?>')
                <?php endif;?>

            });  
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>