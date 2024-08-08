<?php 
/** 
Purpose of file:    Edit page for Holiday Library
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
            <span>Edit Local Holiday</span>
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
                    <span class="caption-subject bold uppercase"> Edit Local Holiday</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/holiday/edit_local/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmLocalHoliday'))?>
                <div class="form-body">
                    <?php //print_r($arrLocHoliday);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Local Holiday Name </label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strLocalHolidayName" disabled>
                                    <option value="">Select</option>
                                        <?php foreach($arrLocHoliday as $local)
                                            {
                                              echo '<option value="'.$local['holidayCode'].'" '.($arrData[0]['holidayCode']==$local['holidayCode']?'selected':'').'>'.$local['holidayName'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                    <label class="control-label">Local Holiday Date <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input class="form-control form-control-inline input-medium date-picker" name="dtmHolidayDate" id="dtmHolidayDate" size="16" type="text" value="<?=!empty($arrData[0]['holidayDate'])?$arrData[0]['holidayDate']:''?>">

                                 
                            </div>
                        </div>
                    </div>
                   <!--  <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Year <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select id="dtmYear" name="dtmYear" type="text" value="<?=!empty($arrLocHoliday[0]['holidayYear'])?$arrLocHoliday[0]['holidayYear']:''?>">
                                    <option value="">Select</option>
                                    <?php 
                                        $initialYear = 2000;
                                        $currentYear = date('Y');
                                        for ($i=$initialYear;$i <= $currentYear ;$i++)
                                        {
                                            $checked = ($i == $currentYear ? "selected" : "");
                                            echo '<option value="'.$i.'" '.$checked.'>'.$i.'</option>';
                                        }
                                    ?>
                                    </select>&nbsp&nbsp
                                <label class="control-label">Month <span class="required"> * </span></label>
                                    <i class="fa"></i>
                                    <select id="dtmMonth" name="dtmMonth">
                                        <option selected value="January">Jan</option>
                                        <option value="February">Feb</option>
                                        <option value="March">Mar</option>
                                        <option value="April">Apr</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">Aug</option>
                                        <option value="September">Sept</option>
                                        <option value="October">Oct</option>
                                        <option value="November">Nov</option>
                                        <option value="December">Dec</option>
                                    </select>&nbsp&nbsp
                                <label class="control-label">Day <span class="required"> * </span></label>
                                    <?php
                                        
                                        echo '<select name="dtmDay" id="dtmDay">' . PHP_EOL;
                                        for ($d=1; $d<=31; $d++) {
                                            echo '  <option value="' . $d . '" ' .($arrLocHoliday[0]['holidayDay']==$arrLocHoliday[0]['holidayDay']?'selected':'').'>'. $d . '</option>' . PHP_EOL;
                                        }
                                        echo '</select>' . PHP_EOL;
                                        ?>                                
                            </div>
                        </div>
                    </div>
                  -->
                   </div>
                   <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="strLocalCode" value="<?=isset($arrData[0]['holidayCode'])?$arrData[0]['holidayCode']:''?>">
                                <input type="hidden" name="strLocalName" value="<?=isset($arrData[0]['holidayName'])?$arrData[0]['holidayName']:''?>">
                                <button class="btn btn-success" type="submit"><i class="icon-check"></i> Save</button>
                                <a href="<?=base_url('libraries/holiday/add_local')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
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

            var form2 = $('#frmLocalHoliday');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    // strLocalName: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    dtmHolidayDate: {
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
    $('#dtmHolidayDate').datepicker({
        format:"yyyy-mm-dd"
    });

});
</script>
