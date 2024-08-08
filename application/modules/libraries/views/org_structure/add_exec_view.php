<?php 
/** 
Purpose of file:    Add page for Org Structure Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?=base_url('libraries/agency_profile')?>">Libraries</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Add <?=$_ENV['Group1']?></span>
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
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Add <?=$_ENV['Group1']?></span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/org_structure/add_exec'), array('method' => 'post', 'id' => 'frmOrgStructure', 'onsubmit' => 'return checkForBlank()'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group1']?> Code <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" maxlength="10" name="strExecOffice" id="strExecOffice"  value="<?=!empty($this->session->userdata('strExecOffice'))?$this->session->userdata('strExecOffice'):''?>">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group1']?> Name <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strExecName" id="strExecName" value="<?=!empty($this->session->userdata('strExecName'))?$this->session->userdata('strExecName'):''?>">
                                    <font color='red'> <span id="errorName"></span></font>
                                    </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group1']?> Head <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strExecHead" value="<?=!empty($this->session->userdata('strExecHead'))?$this->session->userdata('strExecHead'):''?>" required>
                                        <option value="">Select</option>
                                        <?php foreach($arrEmployees as $i=>$data): ?>
                                        <option value="<?=$data['empNumber']?>"><?=(strtoupper($data['surname']).', '.($data['firstname']).' '.($data['middleInitial']).' '.($data['nameExtension']))?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group1']?> Head Title <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                       <input type="text" class="form-control" name="strHeadTitle" id="strHeadTitle" autocomplete="off" value="<?=!empty($this->session->userdata('strHeadTitle'))?$this->session->userdata('strHeadTitle'):''?>">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group1']?> Secretary</label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strSecretary" value="<?=!empty($this->session->userdata('strSecretary'))?$this->session->userdata('strSecretary'):''?>" >
                                        <option value="">Select</option>
                                        <?php foreach($arrEmployees as $i=>$data): ?>
                                        <option value="<?=$data['empNumber']?>"><?=(strtoupper($data['surname']).', '.($data['firstname']).' '.($data['middleInitial']).' '.($data['nameExtension']))?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Add</button>
                                <a href="<?=base_url('libraries/org_structure')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?php load_plugin('js',array('validation'));?>
<script type="text/javascript">
    jQuery.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "No space please and don't leave it empty");
var FormValidation = function () {

    // validation using icons
    var handleValidation = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form2 = $('#frmOrgStructure');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    strExecOffice: {
                        minlength: 1,
                        required: true,
                    },
                    strExecName: {
                        minlength: 1,
                        required: true,
                    },
                    strExecHead: {
                        minlength: 1,
                        required: true,
                    },
                    strHeadTitle: {
                        minlength: 1,
                        required: true,
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    success2.show();
                    error2.hide();
                    form[0].submit(); // submit the form
                }
            });


    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});
</script>

<script>

function checkForBlank()
{
   var spaceCount = 0;

    $code= $('#strExecOffice').val();
    $name= $('#strExecName').val();
    $title= $('#strHeadTitle').val();

    $('#errorCode','#errorName','#errorTitle').html('');

    if($code=="")
    {
      $('#errorCode').html('This field is required!');
      return false;
    }
    else if($code==0)
    {
      $('#errorCode').html('Invalid Input!');
      return false;
    }
    if($name=="")
    {
      $('#errorName').html('This field is required!');
      return false;
    }
    else if($name==0)
    {
      $('#errorName').html('Invalid Input!');
      return false;
    }
    if($title=="")
    {
      $('#errorTitle').html('This field is required!');
      return false;
    }
    else if($title==0)
    {
      $('#errorTitle').html('Invalid Input!');
      return false;
    }
    else
    {
      return true;
    }

}
</script>