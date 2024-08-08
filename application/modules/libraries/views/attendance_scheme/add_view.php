<?php 
/** 
Purpose of file:    Add page for Attendance Scheme Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<!-- BEGIN PAGE BAR -->
<?=load_plugin('css', array('select','datetimepicker','timepicker'))?>
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
            <span>Add Attendance Scheme</span>
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
                    <span class="caption-subject bold uppercase"> Add Attendance Scheme</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/attendance_scheme/add'), array('method' => 'post', 'id' => 'frmAttendanceScheme'))?>
                    <div class="form-body">
                        <?php //print_r($arrPost);?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Scheme Type <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select name="strSchemeType" id="strSchemeType" class="form-control bs-select">
                                            <option value="">Select Scheme </option>
                                            <option value="Fixed">Fixed </option>
                                            <option value="Sliding">Sliding </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="scheme_desc">
                            <div class="row" id="schemecode">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Scheme Code <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="strSchemeCode" id="strSchemeCode" value="<?=!empty($this->session->userdata('strSchemeCode'))?$this->session->userdata('strSchemeCode'):''?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="schemename">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Scheme Name <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" name="strSchemeName" id="strSchemeName" value="<?=!empty($this->session->userdata('strSchemeName'))?$this->session->userdata('strSchemeName'):''?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fixed -->
                        <div id="div-fixed">
                            <div class="row" id="FtimeIn">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label" id="FtimeIn">Fixed Time In : <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeIn" id="dtmFtimeIn" value="12:00:00 PM">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="FtimeOutFrom">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time-Out From (noon) :  <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeOutFrom" id="dtmFtimeOutFrom" value="12:00:00 PM">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="FtimeOutTo">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time-Out To (noon) :  <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeOutTo" id="dtmFtimeOutTo" value="12:00:00 PM">
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <div class="row" id="FtimeInFrom">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time-In From (noon) :   <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeInFrom" id="dtmFtimeInFrom" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="FtimeInTo">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time-In To (noon) : <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeInTo" id="dtmFtimeInTo" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                              <div class="row" id="FtimeOut">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time Out : <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmFtimeOut" id="dtmFtimeOut" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div></br>
                        </div>
                        <!-- end of fixed -->
                        <!-- Sliding -->
                        <div id="div-sliding">
                            <div class="row" id="StimeInFrom">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Sliding Time In From :  <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeInFrom" id="dtmStimeInFrom" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="row" id="StimeInTo">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time In To : <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeInTo" id="dtmStimeInTo" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="StimeOutFromNN">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time-Out From (noon) : <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeOutFromNN" id="dtmStimeOutFromNN" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="StimeOutToNN">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time-Out To (noon) :  <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeOutToNN" id="dtmStimeOutToNN" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="StimeInFromNN">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time-In From (noon) :  <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeInFromNN" id="dtmStimeInFromNN" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="StimeInToNN">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time-In To (noon) : <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeInToNN" id="dtmStimeInToNN" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="StimeOutFrom">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time Out From : <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeOutFrom" id="dtmStimeOutFrom" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                              <div class="row" id="StimeOutTo">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Time Out To : <span class="required"> * </span></label>
                                        <div class="input-icon right">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" class="form-control timepicker timepicker-default" name="dtmStimeOutTo" id="dtmStimeOutTo" value="12:00:00 PM"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of sliding -->
                        <div id="checkbox">
                            <div class="row" id="allow">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Allow 30 mins (noon log) : <input type="checkbox" class="checkbox" name="strAllow" id="strAllow" value="Y"> </label>
                                        <div class="input-icon left">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="strict">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Strict (noon log) : <input type="checkbox" class="checkbox" name="strStrict" id="strStrict" value="Y"> </label>
                                        <div class="input-icon left">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="monday">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">8AM - 5PM during Mondays : </label>
                                        <label class="form-radio-inline"><input type="radio" name="strMonday" value="Y" checked>Yes</label>
                                        <label class="form-radio-inline"><input type="radio" name="strMonday" value="N">No</label>
                                        <div class="input-icon left">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="btn btn-success" id="btn-add-attscheme" type="submit"><i class="fa fa-plus"></i> Add</button>
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

<?=load_plugin('js',array('form_validation','select','datetimepicker','timepicker'));?>
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
    });
</script>


<script type="text/javascript" src="<?=base_url('assets/js/attendance.js')?>"></script>