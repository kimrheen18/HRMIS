<?php 
/** 
Purpose of file:    Delete page for Appointment Status Library
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
            <span>Delete Appointment Status</span>
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
                    <i class="icon-trash font-dark"></i>
                    <span class="caption-subject bold uppercase"> Delete Appointment Status</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/appointment_status/delete/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmAppointmentStatus'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Appointment Code <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strAppointmentCode" autocomplete="off" value="<?=isset($arrAppointStatuses[0]['appointmentCode'])?$arrAppointStatuses[0]['appointmentCode']:''?>" disabled>
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
                                    <input type="text" class="form-control" name="strAppointmentDesc" autocomplete="off" value="<?=!empty($arrAppointStatuses[0]['appointmentDesc'])?$arrAppointStatuses[0]['appointmentDesc']:''?>" disabled>
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
                                    <input type="text" class="form-control" name="strLeaveEntitled" autocomplete="off" value="<?=!empty($arrAppointStatuses[0]['leaveEntitled'])?$arrAppointStatuses[0]['leaveEntitled']:''?>" disabled>
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
                                    <?php if ($arrAppointStatuses[0]['incPlantilla'] == 1)
                                    { ?>
                                        <input type="text" class="form-control" name="intIncludedPlantilla" autocomplete="off" value="Y" disabled>
                                    <?php } 
                                    else{ ?>
                                    <input type="text" class="form-control" name="intIncludedPlantilla" autocomplete="off" value="N" disabled>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="intAppointmentId" value="<?=isset($arrAppointStatuses[0]['appointmentId'])?$arrAppointStatuses[0]['appointmentId']:''?>">
                                <button class="btn btn-danger" type="submit"><i class="icon-trash"></i> Yes</button>
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

