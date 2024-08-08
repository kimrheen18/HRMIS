<?php 
/** 
Purpose of file:    Add page for Agency Profile Library
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
            <span>Add Agency Information</span>
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
                    <span class="caption-subject bold uppercase"> Add Agency Profile</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/appointment_status/add'), array('method' => 'post', 'id' => 'frmAgencyProfile'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Agency Name <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strAgencyName" value="<?=!empty($this->session->userdata('strAgencyName'))?$this->session->userdata('strAgencyName'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Agency Code <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strAgencyCode" value="<?=!empty($this->session->userdata('strAgencyCode'))?$this->session->userdata('strAgencyCode'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Region <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strRegion" value="<?=!empty($this->session->userdata('strRegion'))?$this->session->userdata('strRegion'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">TIN Number <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intTinNum" value="<?=!empty($this->session->userdata('intTinNum'))?$this->session->userdata('intTinNum'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Address <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strAddress" value="<?=!empty($this->session->userdata('strAddress'))?$this->session->userdata('strAddress'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Zip Code <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intZipCode" value="<?=!empty($this->session->userdata('intZipCode'))?$this->session->userdata('intZipCode'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Telephone <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intTelephone" value="<?=!empty($this->session->userdata('intTelephone'))?$this->session->userdata('intTelephone'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Facsimile <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intFax" value="<?=!empty($this->session->userdata('intFax'))?$this->session->userdata('intFax'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Email <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strEmail" value="<?=!empty($this->session->userdata('strEmail'))?$this->session->userdata('strEmail'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Website <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strWebsite" value="<?=!empty($this->session->userdata('strWebsite'))?$this->session->userdata('strWebsite'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Salary Schedule <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strSalarySched" value="<?=!empty($this->session->userdata('strSalarySched'))?$this->session->userdata('strSalarySched'):''?>">
                                        <option value="">Select</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Bi-Monthly">Bi-Monthly</option>
                                        <option value="Monthly">Monthly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">GSIS Number <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intGSISNum" value="<?=!empty($this->session->userdata('intGSISNum'))?$this->session->userdata('intGSISNum'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">GSIS Employee Share <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intGSISEmpShare" value="<?=!empty($this->session->userdata('intGSISEmpShare'))?$this->session->userdata('intGSISEmpShare'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">GSIS Employer Share <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intGSISEmprShare" value="<?=!empty($this->session->userdata('intGSISEmprShare'))?$this->session->userdata('intGSISEmprShare'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Pagibig Number <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intPagibigNum" value="<?=!empty($this->session->userdata('intPagibigNum'))?$this->session->userdata('intPagibigNum'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Pagibig Employee Share <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intPagibigEmpShare" value="<?=!empty($this->session->userdata('intPagibigEmpShare'))?$this->session->userdata('intPagibigEmpShare'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Pagibig Employer Share <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intPagibigEmprShare" value="<?=!empty($this->session->userdata('intPagibigEmprShare'))?$this->session->userdata('intPagibigEmprShare'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Provident Employee Percentage Share <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intProvidentEmpShare" value="<?=!empty($this->session->userdata('intProvidentEmpShare'))?$this->session->userdata('intProvidentEmpShare'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Provident Employer Percentage Share <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intProvidentEmprShare" value="<?=!empty($this->session->userdata('intProvidentEmprShare'))?$this->session->userdata('intProvidentEmprShare'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Philhealth Employee Share <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intPhilhealthEmpShare" value="<?=!empty($this->session->userdata('intPhilhealthEmpShare'))?$this->session->userdata('intPhilhealthEmpShare'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Philhealth Employer Share <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intPhilhealthEmprShare" value="<?=!empty($this->session->userdata('intPhilhealthEmprShare'))?$this->session->userdata('intPhilhealthEmprShare'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Philhealth Percentage <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intPhilhealthPercentage" value="<?=!empty($this->session->userdata('intPhilhealthPercentage'))?$this->session->userdata('intPhilhealthPercentage'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Philhealth # <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intPhilhealthNum" value="<?=!empty($this->session->userdata('intPhilhealthNum'))?$this->session->userdata('intPhilhealthNum'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Mission<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strMission" value="<?=!empty($this->session->userdata('strMission'))?$this->session->userdata('strMission'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Vision<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strVision" value="<?=!empty($this->session->userdata('strVision'))?$this->session->userdata('strVision'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Mandate<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                   <input type="text" class="form-control" name="strMandate" value="<?=!empty($this->session->userdata('strMandate'))?$this->session->userdata('strMandate'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Bank Account #<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strAccountNum" value="<?=!empty($this->session->userdata('strAccountNum'))?$this->session->userdata('strAccountNum'):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Add</button>
                                <a href="<?=base_url('libraries/agency_profile')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
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

            var form2 = $('#frmAgencyProfile');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    strAgencyName: {
                        minlength: 1,
                        required: true
                    },
                    strAgencyCode: {
                        minlength: 1,
                        required: true,
                    }
                    strRegion: {
                        minlength: 1,
                        required: true
                    },
                    intTinNum: {
                        minlength: 1,
                        required: true,
                    }
                    strAddress: {
                        minlength: 1,
                        required: true
                    },
                    intZipCode: {
                        minlength: 1,
                        required: true,
                    }
                    intTelephone: {
                        minlength: 1,
                        required: true
                    },
                    intFax: {
                        minlength: 1,
                        required: true,
                    }
                    strEmail: {
                        minlength: 1,
                        required: true
                    },
                    strWebsite: {
                        minlength: 1,
                        required: true,
                    }
                    strSalarySched: {
                        minlength: 1,
                        required: true
                    },
                    intGSISNum: {
                        minlength: 1,
                        required: true,
                    }
                    intGSISEmpShare: {
                        minlength: 1,
                        required: true
                    },
                    intGSISEmprShare: {
                        minlength: 1,
                        required: true,
                    }
                    intPagibigNum: {
                        minlength: 1,
                        required: true
                    },
                    intPagibigEmpShare: {
                        minlength: 1,
                        required: true
                    },
                    intPagibigEmprShare: {
                        minlength: 1,
                        required: true
                    },
                    intProvidentEmpShare: {
                        minlength: 1,
                        required: true
                    },
                    intProvidentEmprShare: {
                        minlength: 1,
                        required: true
                    },
                    intPhilhealthEmpShare: {
                        minlength: 1,
                        required: true
                    },
                    intPhilhealthEmprShare: {
                        minlength: 1,
                        required: true
                    },
                    intPhilhealthPercentage: {
                        minlength: 1,
                        required: true
                    },
                    intPhilhealthNum: {
                        minlength: 1,
                        required: true
                    },
                    strMission: {
                        minlength: 1,
                        required: true
                    },
                    strVision: {
                        minlength: 1,
                        required: true
                    },
                    strMandate: {
                        minlength: 1,
                        required: true
                    },
                    strAccountNum: {
                        minlength: 1,
                        required: true
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
