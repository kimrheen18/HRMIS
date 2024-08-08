<?php 
/** 
Purpose of file:    Delete page for Plantilla Library
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
            <span>Delete Plantilla</span>
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
                    <span class="caption-subject bold uppercase"> Delete Plantilla</span>
                </div>
                
            </div>
            <div class="portlet-body">
             <?=form_open(base_url('libraries/plantilla/delete/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmPlantilla'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Item Number </label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" value="<?=isset($arrPlantilla[0]['itemNumber'])?$arrPlantilla[0]['itemNumber']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Position</label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" value="<?=isset($arrPlantilla[0]['positionCode'])?$arrPlantilla[0]['positionDesc']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Salary Grade </label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" value="<?=isset($arrPlantilla[0]['salaryGrade'])?$arrPlantilla[0]['salaryGrade']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Area Code</label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" value="<?=isset($arrPlantilla[0]['areaCode'])?$arrPlantilla[0]['areaCode']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Area Type </label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" value="<?=isset($arrPlantilla[0]['areaType'])?$arrPlantilla[0]['areaType']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Plantilla Group </label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" value="<?=isset($arrPlantilla[0]['plantillaGroupCode'])?$arrPlantilla[0]['plantillaGroupName']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Educational Requirements</label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strEducationalReq" value="<?=isset($arrPlantilla[0]['educational'])?$arrPlantilla[0]['educational']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Training Requirements </label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strTrainingReq" value="<?=isset($arrPlantilla[0]['training'])?$arrPlantilla[0]['training']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Experience Requirements</label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strExperienceReq" value="<?=isset($arrPlantilla[0]['experience'])?$arrPlantilla[0]['experience']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="intPlantillaId" value="<?=isset($arrPlantilla[0]['plantillaID'])?$arrPlantilla[0]['plantillaID']:''?>">
                                <button class="btn btn-danger" type="submit"><i class="icon-trash"></i> Yes</button>
                                <a href="<?=base_url('libraries/plantilla')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
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

