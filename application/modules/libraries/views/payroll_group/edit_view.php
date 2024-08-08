<?php 
/** 
Purpose of file:    Edit page for Payroll Group Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php load_plugin('css',array('select2'));?>
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
            <span>Edit Payroll Group</span>
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
                    <span class="caption-subject bold uppercase"> <?=$action?> Payroll Group</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/payroll_group/edit/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmPayrollGroup'))?>
                <div class="form-body">
                    <?php //print_r($arrPayrollGroup);?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Project <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                      <select type="text" class="form-control select2" name="strProject" id="strProject" value="<?=!empty($this->session->userdata('projectDesc'))?$this->session->userdata('projectDesc'):''?>" <?=$action=='delete'?'disabled':''?>>
                                     <option value="">Select</option>
                                     <?php foreach($arrProject as $i=>$project)
                                        {
                                          echo '<option value="'.$project['projectId'].'" '.($arrPayrollGroup[0]['projectCode']==$project['projectCode']?'selected':'').'>'.(strtoupper($project['projectDesc'])).'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Payroll Group Code </label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strPayrollGroupCode" value="<?=!empty($arrPayrollGroup[0]['payrollGroupCode'])?$arrPayrollGroup[0]['payrollGroupCode']:''?>" <?=$action=='delete'?'disabled':''?> readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Payroll Group Description <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strPayrollGroupDesc" value="<?=!empty($arrPayrollGroup[0]['payrollGroupName'])?$arrPayrollGroup[0]['payrollGroupName']:''?>" <?=$action=='delete'?'disabled':''?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Payroll Group Order <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intPayrollGroupOrder" value="<?=!empty($arrPayrollGroup[0]['payrollGroupOrder'])?$arrPayrollGroup[0]['payrollGroupOrder']:''?>" <?=$action=='delete'?'disabled':''?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Responsibility Center  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strResponsibilityCntr" value="<?=!empty($arrPayrollGroup[0]['payrollGroupRC'])?$arrPayrollGroup[0]['payrollGroupRC']:''?>" <?=$action=='delete'?'disabled':''?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="intPayrollGroupId" value="<?=isset($arrPayrollGroup[0]['payrollGroupId'])?$arrPayrollGroup[0]['payrollGroupId']:''?>">
                                <?php if($action=='delete'): ?>
                                        <a href="<?=base_url('libraries/payroll_group/delete/'.$this->uri->segment(4))?>" class="btn red"><i class="icon-trash"></i> Delete</a>
                                <?php else: ?>
                                    <button class="btn btn-success" type="submit"><i class="icon-check"></i> Save</button>
                                <?php endif; ?>
                                <a href="<?=base_url('libraries/payroll_group')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?php load_plugin('js',array('validation','select2'));?>

<script type="text/javascript">
    jQuery.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "No space please and don't leave it empty");
var FormValidation = function () {

    // validation using icons
    var handleValidation = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form2 = $('#frmPayrollGroup');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    strProject: {
                        minlength: 1,
                        required: true
                    },
                    strPayrollGroupCode: {
                        minlength: 1,
                        required: true,
                    },
                    strPayrollGroupDesc: {
                        minlength: 1,
                        required: true,
                    },
                    intPayrollGroupOrder: {
                        minlength: 1,
                        required: true,
                    },
                    strResponsibilityCntr: {
                        minlength: 1,
                        required: true,
                    },
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
