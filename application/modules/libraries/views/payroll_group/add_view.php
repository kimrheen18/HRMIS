<?php 
/** 
Purpose of file:    Add page for Payroll Group Library
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
            <span>Add Payroll Group</span>
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
                    <span class="caption-subject bold uppercase"> Add Payroll Group</span>
                </div>
                
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" style="display: none" v-cloak>
             <?=form_open(base_url('libraries/payroll_group/add'), array('method' => 'post', 'id' => 'frmPayrollGroup'))?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Project <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <select class="form-control select2" name="strProject" id="strProject"
                                        value="<?=!empty($this->session->userdata('strProject'))?$this->session->userdata('strProject'):''?>">
                                        <option value=""> -- SELECT PROJECT -- </option>
                                            <?php foreach($arrProject as $project) {
                                                echo '<option value="'.$project['projectId'].'">'.$project['projectDesc'].'</option>'; }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Payroll Group Code <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="strPayrollGroupCode" id="strPayrollGroupCode" maxlength="20"
                                        value="<?=!empty($this->session->userdata('strPayrollGroupCode'))?$this->session->userdata('strPayrollGroupCode'):''?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Payroll Group Description <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="strPayrollGroupDesc" id="strPayrollGroupDesc" maxlength="200"
                                        value="<?=!empty($this->session->userdata('strPayrollGroupDesc'))?$this->session->userdata('strPayrollGroupDesc'):''?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Payroll Group Order <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="number" maxlength="11" class="form-control" name="intPayrollGroupOrder" id="intPayrollGroupOrder"
                                        value="<?=!empty($this->session->userdata('intPayrollGroupOrder'))?$this->session->userdata('intPayrollGroupOrder'):''?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Responsibility Center <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <input type="text" class="form-control" name="strResponsibilityCntr" id="strResponsibilityCntr" maxlength="30"
                                        value="<?=!empty($this->session->userdata('strResponsibilityCntr'))?$this->session->userdata('strResponsibilityCntr'):''?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button class="btn btn-success" type="submit" id="btn_add_pgroup"><i class="fa fa-plus"></i> Add</button>
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
<?php load_plugin('js',array('select2','form_validation'));?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.loading-image').hide();
        $('.portlet-body').show();

        $('#strProject').on('keyup keypress change', function() {
            check_null('#strProject','Project must not be empty.');
        });
        $('#strPayrollGroupCode').on('keyup keypress change', function() {
            check_null('#strPayrollGroupCode','Payroll Group Code must not be empty.');
        });
        $('#strPayrollGroupDesc').on('keyup keypress change', function() {
            check_null('#strPayrollGroupDesc','Payroll Group Description must not be empty.');
        });
        $('#intPayrollGroupOrder').on('keyup keypress change', function() {
            check_number('#intPayrollGroupOrder','Payroll Group Order must not be empty.');
        });
        $('#strResponsibilityCntr').on('keyup keypress change', function() {
            check_null('#strResponsibilityCntr','Responsibility Center must not be empty.');
        });

        $('#btn_add_pgroup').on('click', function(e) {
            var total_error = 0;
            total_error = total_error + check_null('#strProject','Project must not be empty.');
            total_error = total_error + check_null('#strPayrollGroupCode','Payroll Group Code must not be empty.');
            total_error = total_error + check_null('#strPayrollGroupDesc','Payroll Group Description must not be empty.');
            total_error = total_error + check_null('#intPayrollGroupOrder','Payroll Group Order must not be empty.');
            total_error = total_error + check_number('#intPayrollGroupOrder');;
            total_error = total_error + check_null('#strResponsibilityCntr','Responsibility Center must not be empty.');
            
            if(total_error > 0){
                e.preventDefault();
            }
        });
    });


//     jQuery.validator.addMethod("noSpace", function(value, element) { 
//   return value.indexOf(" ") < 0 && value != ""; 
// }, "No space please and don't leave it empty");
// var FormValidation = function () {

//     // validation using icons
//     var handleValidation = function() {
//         // for more info visit the official plugin documentation: 
//             // http://docs.jquery.com/Plugins/Validation

//             var form2 = $('#frmPayrollGroup');
//             var error2 = $('.alert-danger', form2);
//             var success2 = $('.alert-success', form2);

//             form2.validate({
//                 errorElement: 'span', //default input error message container
//                 errorClass: 'help-block help-block-error', // default input error message class
//                 focusInvalid: false, // do not focus the last invalid input
//                 ignore: "",  // validate all fields including form hidden input
//                 rules: {
//                     strProject: {
//                         minlength: 1,
//                         required: true
//                     },
//                     strPayrollGroupCode: {
//                         minlength: 1,
//                         required: true,
//                     },
//                     strPayrollGroupDesc: {
//                         minlength: 1,
//                         required: true,
//                     },
//                     intPayrollGroupOrder: {
//                         minlength: 1,
//                         required: true,
//                     },
//                     strResponsibilityCntr: {
//                         minlength: 1,
//                         required: true,
//                     },
//                 },

//                 invalidHandler: function (event, validator) { //display error alert on form submit              
//                     success2.hide();
//                     error2.show();
//                     App.scrollTo(error2, -200);
//                 },

//                 errorPlacement: function (error, element) { // render error placement for each input type
//                     var icon = $(element).parent('.input-icon').children('i');
//                     icon.removeClass('fa-check').addClass("fa-warning");  
//                     icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
//                 },

//                 highlight: function (element) { // hightlight error inputs
//                     $(element)
//                         .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
//                 },

//                 unhighlight: function (element) { // revert the change done by hightlight
                    
//                 },

//                 success: function (label, element) {
//                     var icon = $(element).parent('.input-icon').children('i');
//                     $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
//                     icon.removeClass("fa-warning").addClass("fa-check");
//                 },

//                 submitHandler: function (form) {
//                     success2.show();
//                     error2.hide();
//                     form[0].submit(); // submit the form
//                 }
//             });


//     }

//     return {
//         //main function to initiate the module
//         init: function () {
//             handleValidation();

//         }

//     };

// }();

// jQuery(document).ready(function() {
//     FormValidation.init();
// });
</script>
