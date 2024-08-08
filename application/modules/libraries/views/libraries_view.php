<link href="<?=base_url('assets/plugins/select2/css/select2.min.css')?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/plugins/select2/css/select2-bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        
        <li>
            <a href="<?=base_url('libraries/agency_profile')?>">Libraries</a>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
	   &nbsp;
	</div>
</div>
<div class="clearfix"></div>
<div class="row profile-account">
    <div class="col-md-3">
        <ul class="ver-inline-menu tabbable margin-bottom-10">
            <li class="active">
                <a data-toggle="tab" href="#tab_courses">
                    <i class="fa fa-graduation-cap"></i> Courses </a>
                <span class="after"> </span>
            </li>
            <li>
                <a data-toggle="tab" href="#tab_2-2">
                    <i class="fa fa-flag"></i> Country </a>
            </li>
            <li>
                <a data-toggle="tab" href="#tab_3-3">
                    <i class="fa fa-sticky-note"></i> Exam Type </a>
            </li>
            <li>
                <a data-toggle="tab" href="#tab_4-4">
                    <i class="fa fa-tag"></i> Leave Type </a>
            </li>
        </ul>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
            <div id="tab_courses" class="tab-pane active">
                <?php include('course/list_view.php');?>
            </div>
            <div id="tab_2-2" class="tab-pane">
                <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                    </p>
                <form action="#" role="form">
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                            <div>
                                <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="..."> </span>
                                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                        <div class="clearfix margin-top-10">
                            <span class="label label-danger"> NOTE! </span>
                            <span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                        </div>
                    </div>
                    <div class="margin-top-10">
                        <a href="javascript:;" class="btn green"> Submit </a>
                        <a href="javascript:;" class="btn default"> Cancel </a>
                    </div>
                </form>
            </div>
            <div id="tab_3-3" class="tab-pane">
                <form action="#">
                    <div class="form-group">
                        <label class="control-label">Current Password</label>
                        <input type="password" class="form-control" /> </div>
                    <div class="form-group">
                        <label class="control-label">New Password</label>
                        <input type="password" class="form-control" /> </div>
                    <div class="form-group">
                        <label class="control-label">Re-type New Password</label>
                        <input type="password" class="form-control" /> </div>
                    <div class="margin-top-10">
                        <a href="javascript:;" class="btn green"> Change Password </a>
                        <a href="javascript:;" class="btn default"> Cancel </a>
                    </div>
                </form>
            </div>
            <div id="tab_4-4" class="tab-pane">
                <form action="#">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                            <td>
                                <label class="uniform-inline">
                                    <input type="radio" name="optionsRadios1" value="option1" /> Yes </label>
                                <label class="uniform-inline">
                                    <input type="radio" name="optionsRadios1" value="option2" checked/> No </label>
                            </td>
                        </tr>
                        <tr>
                            <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                            <td>
                                <label class="uniform-inline">
                                    <input type="checkbox" value="" /> Yes </label>
                            </td>
                        </tr>
                        <tr>
                            <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                            <td>
                                <label class="uniform-inline">
                                    <input type="checkbox" value="" /> Yes </label>
                            </td>
                        </tr>
                        <tr>
                            <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                            <td>
                                <label class="uniform-inline">
                                    <input type="checkbox" value="" /> Yes </label>
                            </td>
                        </tr>
                    </table>
                    <!--end profile-settings-->
                    <div class="margin-top-10">
                        <a href="javascript:;" class="btn green"> Save Changes </a>
                        <a href="javascript:;" class="btn default"> Cancel </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-md-9-->
</div>

<?php load_plugin(array('datatable'));?>
<!--script src="<?=base_url('assets/js/datatable.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/plugins/datatables/datatables.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')?>" type="text/javascript"></script-->
<script src="<?=base_url('assets/js/table-datatables-libraries.js')?>" type="text/javascript"></script>

