<?php 
/** 
Purpose of file:    Delete page for Philhealth Range Library
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
            <span>Delete Philhealth Range</span>
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
                    <span class="caption-subject bold uppercase"> Delete Philhealth Range</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/philhealth_range/delete/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmCountry'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Range From <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="number" class="form-control" name="strRangeFrom" id="strRangeFrom" value="<?=isset($arrPhilHealth[0]['philhealthFrom'])?$arrPhilHealth[0]['philhealthFrom']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Range To <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strRangeTo" id="strRangeTo" value="<?=!empty($arrPhilHealth[0]['philhealthTo'])?$arrPhilHealth[0]['philhealthTo']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Salary Base <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="strSalBase" id="strSalBase"  value="<?=!empty($arrPhilHealth[0]['philSalaryBase'])?$arrPhilHealth[0]['philSalaryBase']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Total Monthly Contribution <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control" name="intTotalContri" id="intTotalContri"  value="<?=!empty($arrPhilHealth[0]['philMonthlyContri'])?$arrPhilHealth[0]['philMonthlyContri']:''?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="intPhId" value="<?=isset($arrPhilHealth[0]['philHealthId'])?$arrPhilHealth[0]['philHealthId']:''?>">
                                <button class="btn btn-danger" type="submit"><i class="icon-trash"></i> Yes</button>
                                <a href="<?=base_url('libraries/philhealth_range')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
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

