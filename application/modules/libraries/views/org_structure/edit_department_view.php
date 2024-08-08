<?php 
/** 
Purpose of file:    Edit page for Department Name Library
Author:             Francis Nikko V. Perez
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
            <span>Edit <?=$_ENV['Group5']?> Name</span>
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
                    <i class="icon-pencil font-dark"></i>
                    <span class="caption-subject bold uppercase"> Edit <?=$_ENV['Group5']?> Name</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/org_structure/edit_department/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmOrgStructure'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                    <i class="fa"></i>
                                    <label class="control-label">Executive Office  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strExec">
                                    <option value="">Select</option>
                                    <?php foreach($arrOrganization as $org)
                                        {
                                          echo '<option value="'.$org['group1Code'].'" '.($arrDepartment[0]['group1Code']==$org['group1Code']?'selected':'').'>'.$org['group1Name'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Service <!-- <span class="required"> * </span> --></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strService">
                                    <option value="">Select</option>
                                    <?php foreach($arrService as $service)
                                        {
                                          echo '<option value="'.$service['group2Code'].'" '.($arrDepartment[0]['group2Code']==$service['group2Code']?'selected':'').'>'.$service['group2Name'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Division <!-- <span class="required"> * </span> --></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strDivision">
                                    <option value="">Select</option>
                                    <?php foreach($arrDivision as $div)
                                        {
                                          echo '<option value="'.$div['group3Code'].'" '.($arrDepartment[0]['group3Code']==$div['group3Code']?'selected':'').'>'.$div['group3Name'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Section <!-- <span class="required"> * </span> --></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strSection">
                                    <option value="">Select</option>
                                    <?php foreach($arrSection as $sec)
                                        {
                                          echo '<option value="'.$sec['group4Code'].'" '.($arrDepartment[0]['group4Code']==$sec['group4Code']?'selected':'').'>'.$sec['group4Name'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Code </label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strDeptCode" value="<?=!empty($arrDepartment[0]['group5Code'])?$arrDepartment[0]['group5Code']:''?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Name<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strDeptName" value="<?=!empty($arrDepartment[0]['group5Name'])?$arrDepartment[0]['group5Name']:''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Head<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <select type="text" class="form-control" name="strDeptHead">
                                     <option value="">Select</option>

                                     <?php foreach($arrEmployees as $i=>$data)
                                        {
                                          echo '<option value="'.$data['empNumber'].'" '.($arrDepartment[0]['empNumber']==$data['empNumber']?'selected':'').'>'.(strtoupper($data['surname']).', '.(strtoupper($data['firstname']))).'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Head Title <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control" name="strDeptHeadTitle" value="<?=!empty($arrDepartment[0]['group5HeadTitle'])?$arrDepartment[0]['group5HeadTitle']:''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Secretary</label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <select type="text" class="form-control" name="strDeptSecretary">
                                     <option value="">Select</option>

                                     <?php foreach($arrEmployees as $i=>$data)
                                        {
                                          echo '<option value="'.$data['empNumber'].'" '.($arrDepartment[0]['group5Secretary']==$data['empNumber']?'selected':'').'>'.(strtoupper($data['surname']).', '.(strtoupper($data['firstname']))).'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="strCode" value="<?=isset($arrDepartment[0]['group5Code'])?$arrDepartment[0]['group5Code']:''?>">
                                <button class="btn btn-success" type="submit"><i class="icon-check"></i> Save</button>
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
                    strExecDivision: {
                        minlength: 1,
                        required: true
                    },
                    strSerDivision: {
                        minlength: 1,
                        required: true,
                    },
                    strDivCode: {
                        minlength: 1,
                        required: true,
                    },
                    strDivName: {
                        minlength: 1,
                        required: true,
                    },
                    strDivHead: {
                        minlength: 1,
                        required: true,
                    },
                    strDivHeadTitle: {
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
