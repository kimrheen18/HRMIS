<?php 
/** 
Purpose of file:    Add page for Country Library
Author:             Rose Anne Grefaldeo
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
            <span>Add Appointment Status</span>
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
                    <span class="caption-subject bold uppercase"> Add Appointment Status</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open('libraries/Appointment_status/add', array('method' => 'post', 'id' => 'frmAppointment'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Appointment Code <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strAppointmentCode" id="strAppointmentCode"" value="<?=!empty($this->session->userdata('strAppointmentCode'))?$this->session->userdata('strAppointmentCode'):''?>">
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
                                    <input type="text" class="form-control" name="strAppointmentDesc" id="strAppointmentDesc" value="<?=!empty($this->session->userdata('strAppointmentDesc'))?$this->session->userdata('strAppointmentDesc'):''?>">
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
                                    <select type="text" class="form-control" name="strLeaveEntitled" id="strLeaveEntitled" autocomplete="off" value="<?=!empty($arrAppointStatuses[0]['leaveEntitled'])?$arrAppointStatuses[0]['leaveEntitled']:''?>">
                                        <option value="">Select</option>
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
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
                                     <select type="text" class="form-control" name="intIncludedPlantilla" id="intIncludedPlantilla"  autocomplete="off" value="<?=!empty($arrAppointStatuses[0]['intIncludedPlantilla'])?$arrAppointStatuses[0]['intIncludedPlantilla']:''?>">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button class="btn btn-success" type="submit" id="btn-add-appoint"><i class="fa fa-plus"></i> Add</button>
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
<?php load_plugin('js',array('form_validation'));?>

<script type="text/javascript">
    $(document).ready(function(){

    $('#btn-add-appoint').click(function(e) 
        {
          // e.preventDefault(); 
            var total_error = 0;

            total_error = total_error + check_null('#strAppointmentCode','Appointment Code must not be empty.');
            total_error = total_error + check_null('#strAppointmentDesc','Appointment Description must not be empty.');
            total_error = total_error + check_null('#strLeaveEntitled','Leave Entitled must not be empty.');
            total_error = total_error + check_null('#intIncludedPlantilla','Included in Plantilla must not be empty.');
    
            if(total_error > 0){
            e.preventDefault();
        }
    });

});
</script>