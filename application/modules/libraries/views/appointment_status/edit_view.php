<?php 
/** 
Purpose of file:    Edit page for Appointment Status Library
 Library
Author:             Edgardo P. Catorce Jr.
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
            <span>Edit Appointment Status</span>
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
                    <span class="caption-subject bold uppercase"> Edit Appointment Status</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/appointment_status/edit/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmAppointmentStatus'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Appointment Code <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strAppointmentCode" autocomplete="off" value="<?=isset($arrAppointStatuses[0]['appointmentCode'])?$arrAppointStatuses[0]['appointmentCode']:''?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Appointment Description <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strAppointmentDesc" autocomplete="off" value="<?=!empty($arrAppointStatuses[0]['appointmentDesc'])?$arrAppointStatuses[0]['appointmentDesc']:''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Leave Entitled? <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strLeaveEntitled" autocomplete="off" value="<?=!empty($arrAppointStatuses[0]['leaveEntitled'])?$arrAppointStatuses[0]['leaveEntitled']:''?>">
                                        <option value="">Select</option>
                                        <option <?php if ($arrAppointStatuses[0]['leaveEntitled'] == 'Y' ) echo 'selected' ; ?> value="Y">Y</option>
                                        <option <?php if ($arrAppointStatuses[0]['leaveEntitled'] != 'Y' ) echo 'selected' ; ?> value="N">N</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Included in Plantilla? <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="intIncludedPlantilla" autocomplete="off" value="<?=!empty($arrAppointStatuses[0]['incPlantilla'])?$arrAppointStatuses[0]['incPlantilla']:''?>">
                                        <option value="">Select</option>
                                        <option <?php if ($arrAppointStatuses[0]['incPlantilla'] == 1 ) echo 'selected' ; ?> value="1">Y</option>
                                        <option <?php if ($arrAppointStatuses[0]['incPlantilla'] != 1 ) echo 'selected' ; ?> value="0">N</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="intAppointmentId" id="intAppointmentId" value="<?=isset($arrAppointStatuses[0]['appointmentId'])?$arrAppointStatuses[0]['appointmentId']:''?>">
                                <button class="btn btn-success" type="submit"><i class="icon-check"></i> Save</button>
                                <a href="<?=base_url('libraries/appointment_status')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
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

            var form2 = $('#frmAppointmentStatus');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    strAppointmentCode: {
                        minLength: 1,
                        required: true
                    },
                    strAppointmentDesc: {
                        minLength: 1,
                        required: true,
                    },
                    strLeaveEntitled: {
                        minLength: 1,
                        required: true,
                    },
                    intIncludedPlantilla: {
                        minLength: 1,
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


<?php
  if(!empty($arrAppointStatuses[0]['leaveEntitled']))
    { ?>
        //alert(jQuery('#strLeaveEntitled').val());

        jQuery('#strLeaveEntitled').val('<?= $arrAppointStatuses[0]['leaveEntitled'] ?>').trigger('change');
        
        jQuery('#intAppointmentId').val('<?= $this->uri->segment(4) ?>').trigger('change');

    <?php } ?>

});
</script>
