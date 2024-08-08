<?php 
/** 
Purpose of file:    Add page for Local Holiday Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php load_plugin('css',array('datepicker','datatables'));?>
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
            <span>Manage Local Holiday</span>
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
                    <span class="caption-subject bold uppercase">Manage Local Holiday</span>
                </div>
                
            </div>
            <div class="portlet-body">
               <?=form_open(base_url('libraries/holiday/add_local'), array('method' => 'post', 'id' => 'frmLocalHoliday'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Local Holiday Name <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strLocalName" id="strLocalName" value="<?=!empty($this->session->userdata('strLocalName'))?$this->session->userdata('strLocalName'):''?>">
                                     <option value="">Select</option>
                                      <?php foreach($arrHoliday as $local)
                                        {
                                          echo '<option value="'.$local['holidayName'].'">'.$local['holidayName'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                    <label class="control-label">Local Holiday Date</label>
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input class="form-control form-control-inline input-medium date-picker" autocomplete="off" name="dtmHolidayDate" id="dtmHolidayDate" size="16" type="text" value="" data-date-format="yyyy-mm-dd">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="strLocalCode" value="<?=isset($strLocalCode)?$strLocalCode:''?>">
                                <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Add</button>
                                <a href="<?=base_url('libraries/holiday')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?=form_close()?>

            </div>
        </div>
    </div>
</div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="libraries_local_holiday">
                    <thead>
                        <tr>
                            <th> No. </th>
                            <th> Local Holiday Code </th>
                            <th> Local Holiday Name </th>
                            <th> Local Holiday Date </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    foreach($arrLocHoliday as $row):?>
                        <tr class="odd gradeX">
                            <td> <?=$i?> </td>
                            <td> <?=trim($row['holidayCode'])?> </td> 
                            <td> <?=$row['holidayName']?> </td>  
                            <td> <?=$row['holidayDate']?> </td>                       
                            <td>
                                <a href="<?=base_url('libraries/holiday/edit_local/'.$row['holidayCode'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                <a href="<?=base_url('libraries/holiday/delete_local/'.$row['holidayCode'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-trash" title="Delete"></span> Delete</button></a>
                               
                            </td>
                        </tr>
                    <?php 
                    $i++;
                    endforeach;?>
                    </tbody>
                </table>

<?php load_plugin('js',array('validation'));?>
<?php load_plugin('js',array('datatables'));?>
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
                    strLocalName: {
                        minlength: 1,
                        required: true
                    },
                    dtmHolidayDate: {
                        minlength: 1,
                        required: true,
                    }
                    // dtmYear: {
                    //     minlength: 1,
                    //     required: true,
                    // },
                    // dtmMonth: {
                    //     minlength: 1,
                    //     required: true,
                    // },
                    // dtmDay: {
                    //     minlength: 1,
                    //     required: true,
                    // },
                   
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
</script>
<script>
jQuery(document).ready(function() {
//     var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
// $.fn.bootstrapDP = datepicker;                 // give $().bootstrapDP the bootstrap-datepicker functionality
    FormValidation.init();
     $('#dtmHolidayDate').datepicker({
        format:"yyyy-mm-dd"
    });
    Datatables.init('libraries_local_holiday');
});



    
</script>