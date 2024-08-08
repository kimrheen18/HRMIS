<?php 
/** 
Purpose of file:    Edit page for Agency Profile Library
 Library
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
            <span>Agency Information</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
	   &nbsp;
	</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-pencil font-dark"></i>
                    <span class="caption-subject bold uppercase"> Edit Agency Information</span>
                </div> 
            </div>
            <div class="portlet-body form">
                <?=form_open(base_url('libraries/agency_profile/edit/'.$this->uri->segment(4)), array('method' => 'post', 'class' => 'form-horizontal', 'id' => 'frmAgencyProfile'))?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Agency name <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strAgencyName" value="<?=isset($arrAgency[0]['agencyName'])?$arrAgency[0]['agencyName']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Agency Code <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strAgencyCode" value="<?=isset($arrAgency[0]['abbreviation'])?$arrAgency[0]['abbreviation']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Region <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strRegion" value="<?=!empty($arrAgency[0]['region'])?$arrAgency[0]['region']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">TIN Number <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intTinNum" value="<?=!empty($arrAgency[0]['agencyTin'])?$arrAgency[0]['agencyTin']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Address <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strAddress" value="<?=!empty($arrAgency[0]['address'])?$arrAgency[0]['address']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Zip Code <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intZipCode" value="<?=!empty($arrAgency[0]['zipCode'])?$arrAgency[0]['zipCode']:''?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">Telephone <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intTelephone" value="<?=!empty($arrAgency[0]['telephone'])?$arrAgency[0]['telephone']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Facsimile <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intFax" value="<?=!empty($arrAgency[0]['facsimile'])?$arrAgency[0]['facsimile']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Email <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strEmail" value="<?=!empty($arrAgency[0]['email'])?$arrAgency[0]['email']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Website <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strWebsite" value="<?=!empty($arrAgency[0]['website'])?$arrAgency[0]['website']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Salary Schedule <span class="required"> * </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strSalarySched" value="<?=!empty($arrAgency[0]['salarySchedule'])?$arrAgency[0]['salarySchedule']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Time Before OT </label>
                            <div class="col-md-3">
                                <input type="text" class="form-control timepicker" name="intBeforeOT" id="intBeforeOT" value="<?=!empty($arrAgency[0]['minOT'])?$arrAgency[0]['minOT']:''?>" format="12:00"  autocomplete="off">   
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Maximum Hours of OT </label>
                            <div class="col-md-3">
                                <input type="text" class="form-control timepicker timepicker-default" name="intMaxOT" id="intMaxOT" value="<?=!empty($arrAgency[0]['maxOT'])?$arrAgency[0]['maxOT']:''?>" format="12:00"  autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Expiration of CTO (Yr / Month)</label>
                            <div class="col-md-3">
                                <!-- <input class="form-control form-control-inline input-medium date-picker" name="intExpryOT" id="intExpryOT" autocomplete="off" size="16" type="text" value="<?=!empty($arrAgency[0]['expirationCTO'])?$arrAgency[0]['expirationCTO']:''?>" 
                                data-date-format="yyyy-mm-dd"> -->
                                    <!-- <select class="bs-select form-control" name="dtmExpMon" id="dtmExpMon" >
                                        <?php foreach (range(1, 12) as $m): ?>
                                            <option value="<?=sprintf('%02d', $m)?>"
                                                <?php 
                                                    if(isset($_GET['month'])):
                                                        echo $_GET['month'] == $m ? 'selected' : '';
                                                    else:
                                                        echo $m == sprintf('%02d', date('m')) ? 'selected' : '';
                                                    endif;
                                                 ?> >
                                                <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                        <?php endforeach; ?>
                                    </select> -->
                                <input type="text" class="form-control" name="dtmExpYr" maxlength="4" placeholder="Number of Years" value="<?=isset($arrAgency) ? $arrAgency[0]['expr_cto_yr'] : ''?>">
                            </div>
                             <div class="col-md-3">
                                <!-- <input class="form-control form-control-inline input-medium date-picker" name="intExpryOT" id="intExpryOT" autocomplete="off" size="16" type="text" value="<?=!empty($arrAgency[0]['expirationCTO'])?$arrAgency[0]['expirationCTO']:''?>" 
                                data-date-format="yyyy-mm-dd"> -->
                                    <?php
                                        // $already_selected_value = date("Y");
                                        // $earliest_year = 2003;

                                        // print '<select name="dtmExpYr" id="dtmExpYr" class="form-control bs-select form-required">';
                                        // foreach (range(date('Y'), $earliest_year) as $x) {
                                        //     print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                        // }
                                        // print '</select>'; ?>
                                    <input type="text" class="form-control" name="dtmExpMon" maxlength="2" placeholder="Number of Months" value="<?=isset($arrAgency) ? $arrAgency[0]['expr_cto_mon'] : ''?>">
                            </div>
                            <div class="col-md-1">
                                <a class="btn btn-info btn-circle btn-xs" data-toggle="modal" data-backdrop="static" data-keyboard="false"
                                        href="#modal-info"><i class="fa fa-question"></i></a>
                            </div>
                        </div>

                        <div class="form-group timepicker">
                            <label class="col-md-2 control-label">Flag Ceremony Time </label>
                            <div class="col-md-3">
                                <input type="text" class="form-control timepicker timepicker-default" name="intFlagTime" id="intFlagTime" value="<?=!empty($arrAgency[0]['flagTime'])?$arrAgency[0]['flagTime']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Auto Computation of Tax </label>
                            <!-- <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="intAutoComputeTax" value="1" <?=isset($arrAgency) ? $arrAgency[0]['autoComputeTax'] == '1' ? 'checked' : '' : ''?>> Yes </label>
                                <label class="radio-inline">
                                    <input type="radio" name="intAutoComputeTax" value="0" <?=isset($arrAgency) ? $arrAgency[0]['autoComputeTax'] == '0' ? 'checked' : '' : ''?>> No </label>
                            </div> -->
                            <div class="col-md-3" style="padding-top: 7px;padding-bottom: 0 !important;">
                                <label><input type="checkbox" name="intAutoComputeTax" <?=isset($arrAgency) ? $arrAgency[0]['autoComputeTax'] == '1' ? 'checked' : '' : ''?>></label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="col-md-2 control-label">GSIS Number </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intGSISNum" value="<?=!empty($arrAgency[0]['gsisId'])?$arrAgency[0]['gsisId']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">GSIS Employee Share </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intGSISEmpShare" value="<?=!empty($arrAgency[0]['gsisEmpShare'])?$arrAgency[0]['gsisEmpShare']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">GSIS Employer Share </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intGSISEmprShare" value="<?=!empty($arrAgency[0]['gsisEmprShare'])?$arrAgency[0]['gsisEmprShare']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Pagibig Number </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intPagibigNum" value="<?=!empty($arrAgency[0]['pagibigId'])?$arrAgency[0]['pagibigId']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Pagibig Employee Share </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intPagibigEmpShare" value="<?=!empty($arrAgency[0]['pagibigEmpShare'])?$arrAgency[0]['pagibigEmpShare']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Pagibig Employer Share </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intPagibigEmprShare" value="<?=!empty($arrAgency[0]['pagibigEmprShare'])?$arrAgency[0]['pagibigEmprShare']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Provident Employee Share </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intProvidentEmpShare" value="<?=!empty($arrAgency[0]['providentEmpShare'])?$arrAgency[0]['providentEmpShare']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Provident Employer Share </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intProvidentEmprShare" value="<?=!empty($arrAgency[0]['providentEmprShare'])?$arrAgency[0]['providentEmprShare']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Philhealth Employee Share </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intPhilhealthEmpShare" value="<?=!empty($arrAgency[0]['philhealthEmpShare'])?$arrAgency[0]['philhealthEmpShare']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Philhealth Employer Share </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intPhilhealthEmprShare" value="<?=!empty($arrAgency[0]['philhealthEmprShare'])?$arrAgency[0]['philhealthEmprShare']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Philhealth Percentage </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intPhilhealthPercentage" value="<?=!empty($arrAgency[0]['philhealthPercentage'])?$arrAgency[0]['philhealthPercentage']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Philhealth Number </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="intPhilhealthNum" value="<?=!empty($arrAgency[0]['PhilhealthNum'])?$arrAgency[0]['PhilhealthNum']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Mission </label>
                            <div class="col-md-9">
                                <textarea type="text" name="strMission" class="form-control"><?=!empty($arrAgency[0]['Mission'])?$arrAgency[0]['Mission']:''?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Vision </label>
                            <div class="col-md-9">
                                <textarea type="text" name="strVision" class="form-control"><?=!empty($arrAgency[0]['Vision'])?$arrAgency[0]['Vision']:''?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Mandate </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strMandate" value="<?=!empty($arrAgency[0]['Mandate'])?$arrAgency[0]['Mandate']:''?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Bank Account # </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="strAccountNum" value="<?=!empty($arrAgency[0]['AccountNum'])?$arrAgency[0]['AccountNum']:''?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="hidden" name="intAgencyName" value="<?=isset($arrAgency[0]['agencyName'])?$arrAgency[0]['agencyName']:''?>">
                                <button class="btn green" type="submit"><i class="icon-check"></i> Save</button>
                                <a href="<?=base_url('libraries/agency_profile')?>" class="btn btn-primary"><i class="icon-ban"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?php load_plugin('js',array('validation'));?>

<!-- begin Info Modal -->
<div class="modal fade" id="modal-info" tabindex="-1" role="basic" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title small">Expiration of CTO</h4>
            </div>
            <div class="modal-body"><small>
                Expiration of CTO will based on number of years and months. <b>For example:</b>
                <i>
                    <br>Expiration Years: 2
                    <br>Expiration Months: 6
                    <br>CTO Date: 2019-01-01
                    <br>CTO Expiration Date: 2021-07-01
                </i>
            </small> </div>
            <!-- <div class="modal-footer">
                <button type="submit" id="btndelete" class="btn btn-sm green">
                    <i class="icon-check"> </i> Yes</button>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
                    <i class="icon-ban"> </i> Cancel</button>
            </div> -->
        </div>
    </div>
</div>
<!-- end Info Modal -->

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
                    },
                    strRegion: {
                        minlength: 1,
                        required: true
                    },
                    intTinNum: {
                        minlength: 1,
                        required: true,
                    },
                    strAddress: {
                        minlength: 1,
                        required: true
                    },
                    intZipCode: {
                        minlength: 1,
                        required: true,
                    },
                    intTelephone: {
                        minlength: 1,
                        required: true
                    },
                    intFax: {
                        minlength: 1,
                        required: true,
                    },
                    strEmail: {
                        minlength: 1,
                        required: true
                    },
                    strWebsite: {
                        minlength: 1,
                        required: true,
                    },
                    strSalarySched: {
                        minlength: 1,
                        required: true
                    }
                    // intGSISNum: {
                    //     minlength: 1,
                    //     required: true,
                    // },
                    // intGSISEmpShare: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intGSISEmprShare: {
                    //     minlength: 1,
                    //     required: true,
                    // },
                    // intPagibigNum: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intPagibigEmpShare: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intPagibigEmprShare: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intProvidentEmpShare: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intProvidentEmprShare: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intPhilhealthEmpShare: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intPhilhealthEmprShare: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intPhilhealthPercentage: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // intPhilhealthNum: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // strMission: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // strVision: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // strMandate: {
                    //     minlength: 1,
                    //     required: true
                    // },
                    // strAccountNum: {
                    //     minlength: 1,
                    //     required: true
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

jQuery(document).ready(function() {
    FormValidation.init();

});
</script>
