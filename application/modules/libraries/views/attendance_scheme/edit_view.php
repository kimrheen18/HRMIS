<?php 
/** 
Purpose of file:    Edit page for Exam Type Library
 Library
Author:             Edgardo P. Catorce Jr.
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<!-- BEGIN PAGE BAR -->
<?=load_plugin('css', array('datetimepicker','timepicker'))?>

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
            <span>Edit Attendance Scheme</span>
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
                    <span class="caption-subject bold uppercase"> Edit Attendance Scheme</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/attendance_scheme/edit/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmAttendanceScheme'))?>
                <div class="form-body">
                    <?php //print_r($arrPost); 
                     //$arrAttendance[0]['schemeType']; ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Scheme Type <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                  <select type="text" class="form-control" name="strType" id="strType" value="<?=!empty($this->session->userdata('schemeType'))?$this->session->userdata('schemeType'):''?>" disabled>
                                     <option value="">Select</option>
                                     <?php foreach($arrType as $i=>$type)
                                        {
                                          echo '<option value="'.$type['schemeType'].'" '.($arrAttendance[0]['schemeType']==$type['schemeType']?'selected':'').'>'.(strtoupper($type['schemeType'])).'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Scheme Code<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i><?php //print_r($arrAttendance)?>
                                   <input type="text" class="form-control" name="strSchemeCode" id="strSchemeCode" value="<?=!empty($arrAttendance[0]['schemeCode'])?$arrAttendance[0]['schemeCode']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Scheme Name <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                   <input type="text" class="form-control" name="strSchemeName" id="strSchemeName" value="<?=!empty($arrAttendance[0]['schemeName'])?$arrAttendance[0]['schemeName']:''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- fixed -->
                     <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Fixed Time In :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeIn" id="dtmFtimeIn" value="<?=!empty($arrAttendance[0]['amTimeinFrom'])? date("h:i:s A", strtotime($arrAttendance[0]['amTimeinFrom'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time-Out From (noon) :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeOutFrom" id="dtmFtimeOutFrom" value="<?=!empty($arrAttendance[0]['nnTimeoutFrom'])? date("h:i:s A", strtotime($arrAttendance[0]['nnTimeoutFrom'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time-Out To (noon) :<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeOutTo" id="dtmFtimeOutTo" value="<?=!empty($arrAttendance[0]['nnTimeoutTo'])? date("h:i:s A", strtotime($arrAttendance[0]['nnTimeoutTo'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time-In From (noon) :     <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeInFrom" id="dtmFtimeInFrom" value="<?=!empty($arrAttendance[0]['nnTimeinFrom'])? date("h:i:s A", strtotime($arrAttendance[0]['nnTimeinFrom'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time-In To (noon) :   <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeInTo" id="dtmFtimeInTo" value="<?=!empty($arrAttendance[0]['nnTimeinTo'])? date("h:i:s A", strtotime($arrAttendance[0]['nnTimeinTo'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time Out : <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeOut" id="dtmFtimeOut" value="<?=!empty($arrAttendance[0]['pmTimeoutTo'])? date("h:i:s A", strtotime($arrAttendance[0]['pmTimeoutTo'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Allow 30 mins (noon log) :  <span class="required"> * </span></label>
                                <?php if ($arrAttendance[0]['allow30']=="Y") {
                                    echo '<input type="checkbox" class="icheck"  name="strAllow" id="strAllow" checked>'; }?>
                                <?php if ($arrAttendance[0]['allow30']=="") {
                                    echo '<input type="checkbox" class="icheck"  name="strAllow" id="strAllow" >'; }?>
                                <div class="input-icon left">
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Strict (noon log) : <span class="required"> * </span></label>
                                <?php if ($arrAttendance[0]['strict']=="Y") {
                                    echo '<input type="checkbox" class="icheck"  name="strStrict" id="strStrict" checked>'; }?>
                                <?php if ($arrAttendance[0]['strict']=="") {
                                    echo '<input type="checkbox" class="icheck"  name="strStrict" id="strStrict" >'; }?>
                                <div class="input-icon left">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sch-fixed">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">8AM - 5PM during Mondays  :  <span class="required"> * </span></label>
                                <label class="form-radio-inline"><input type="radio" name="strMonday" value="Y" <?=$arrAttendance[0]['fixMonday']=="Y" ? 'checked' : ''?>>Yes</label>
                                <label class="form-radio-inline"><input type="radio" name="strMonday" value="N" <?=$arrAttendance[0]['fixMonday']=="N" ? 'checked' : ''?>>No</label>
                                <div class="input-icon left">
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <!-- sliding -->
                     <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Sliding Time In From :  <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeInFrom" id="dtmStimeInFrom" value="<?=!empty($arrAttendance[0]['amTimeinFrom'])? date("h:i:s A", strtotime($arrAttendance[0]['amTimeinFrom'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time In To :   <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeInTo" id="dtmStimeInTo" value="<?=!empty($arrAttendance[0]['amTimeinTo'])? date("h:i:s A", strtotime($arrAttendance[0]['amTimeinTo'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time-Out From (noon) :   <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeOutFromNN" id="dtmStimeOutFromNN" value="<?=!empty($arrAttendance[0]['nnTimeoutFrom'])? date("h:i:s A", strtotime($arrAttendance[0]['nnTimeoutFrom'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time-Out To (noon) :   <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeOutToNN" id="dtmStimeOutToNN" value="<?=!empty($arrAttendance[0]['nnTimeoutTo'])? date("h:i:s A", strtotime($arrAttendance[0]['nnTimeoutTo'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time-In From (noon) :   <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeInFromNN" id="dtmStimeInFromNN" value="<?=!empty($arrAttendance[0]['nnTimeinFrom'])? date("h:i:s A", strtotime($arrAttendance[0]['nnTimeinFrom'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time-In To (noon) : <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeInToNN" id="dtmStimeInToNN" value="<?=!empty($arrAttendance[0]['nnTimeinTo'])? date("h:i:s A", strtotime($arrAttendance[0]['nnTimeinTo'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time Out From : <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeOutFrom" id="dtmStimeOutFrom" value="<?=!empty($arrAttendance[0]['pmTimeoutFrom'])? date("h:i:s A", strtotime($arrAttendance[0]['pmTimeoutFrom'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Time Out To : <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeOutTo" id="dtmStimeOutTo" value="<?=!empty($arrAttendance[0]['pmTimeoutTo'])? date("h:i:s A", strtotime($arrAttendance[0]['pmTimeoutTo'])):''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Allow 30 mins (noon log) :  <span class="required"> * </span></label>
                                <?php if ($arrAttendance[0]['allow30']=="Y") {
                                    echo '<input type="checkbox" class="icheck"  name="strAllow" id="strAllow" checked>'; }?>
                                <?php if ($arrAttendance[0]['allow30']=="") {
                                    echo '<input type="checkbox" class="icheck"  name="strAllow" id="strAllow" >'; }?>
                                <div class="input-icon left">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php //print_r($arrAttendance[0]['strict']);?>
                    <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Strict (noon log)  :  <span class="required"> * </span></label>
                                <?php if ($arrAttendance[0]['strict']=="Y") {
                                    echo '<input type="checkbox" class="icheck"  name="strStrict" id="strStrict" checked>'; }?>
                                <?php if ($arrAttendance[0]['strict']=="") {
                                    echo '<input type="checkbox" class="icheck"  name="strStrict" id="strStrict" >'; }?>
                                <div class="input-icon left">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row sch-sliding">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">8AM - 5PM during Mondays  :  <span class="required"> * </span></label>
                                <label class="form-radio-inline"><input type="radio" name="strMonday" value="Y" <?=$arrAttendance[0]['fixMonday']=="Y" ? 'checked' : ''?>>Yes</label>
                                <label class="form-radio-inline"><input type="radio" name="strMonday" value="N" <?=$arrAttendance[0]['fixMonday']=="N" ? 'checked' : ''?>>No</label>
                                <div class="input-icon left">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="strCode" value="<?=isset($arrAttendance[0]['schemeCode'])?$arrAttendance[0]['schemeCode']:''?>">
                                <input type="hidden" name="strSchemeType" value="<?=isset($arrAttendance[0]['schemeType'])?$arrAttendance[0]['schemeType']:''?>">
                                <button class="btn btn-success" type="submit"><i class="icon-check"></i> Save</button>
                                <a href="<?=base_url('libraries/attendance_scheme')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
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

            var form2 = $('#frmAttendanceScheme');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    strExamCode: {
                        minLength: 1,
                        required: true
                    },
                    strExamDesc: {
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
});
</script>

<?=load_plugin('js',array('validation','datetimepicker','timepicker'));?>
<script>
    $(document).ready(function() {
        $('.timepicker').timepicker({
                timeFormat: 'HH:mm:ss A',
                minuteStep: 1,
                secondStep: 1,
                disableFocus: true,
                showInputs: false,
                showSeconds: true,
                showMeridian: true,
                defaultTime: '12:00:00 a'
            });


        <?php if($arrAttendance[0]['schemeType']=='Sliding'):?>
            $('.sch-fixed').hide();
        <?php endif;?>
        <?php if($arrAttendance[0]['schemeType']=='Fixed'):?>
            $('.sch-sliding').hide();
        <?php endif;?>
    });
</script>

<script type="text/javascript" src="<?=base_url('assets/js/attendance.js')?>"></script>