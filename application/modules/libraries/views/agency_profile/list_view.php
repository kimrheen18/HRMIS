<?php 
/** 
Purpose of file:    List page for Agency Profile Library
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
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> AGENCY INFORMATION</span>
                </div>
                <div class="action pull-right">
                    <a href="<?=base_url('libraries/agency_profile/edit/'.$arrAgency[0]['agencyName'])?>" class="btn green" title="Edit">
                        <i class="fa fa-pencil"></i> Edit </a> &nbsp;
                    <a href="<?=base_url('libraries/agency_profile/edit_logo')?>" class="btn blue-hoki" title="Edit_Logo">
                        <i class="fa fa-edit"></i> Edit Logo </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="row">
                    <div class="col-md-12">
                        <!-- begin form -->
                        <div class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Agency name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="strAgencyName" value="<?=isset($arrAgency[0]['agencyName'])?$arrAgency[0]['agencyName']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Agency Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="strAgencyCode" value="<?=isset($arrAgency[0]['abbreviation'])?$arrAgency[0]['abbreviation']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Region</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="strRegion" value="<?=isset($arrAgency[0]['region'])?$arrAgency[0]['region']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">TIN</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="intTinNum" value="<?=isset($arrAgency[0]['agencyTin'])?$arrAgency[0]['agencyTin']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Address</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="strAddress" value="<?=isset($arrAgency[0]['address'])?$arrAgency[0]['address']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Zip Code</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="intZipCode" value="<?=isset($arrAgency[0]['zipCode'])?$arrAgency[0]['zipCode']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Telephone</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="intTelephone" value="<?=isset($arrAgency[0]['telephone'])?$arrAgency[0]['telephone']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Facsimile</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="intFax" value="<?=isset($arrAgency[0]['facsimile'])?$arrAgency[0]['facsimile']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="strEmail" value="<?=isset($arrAgency[0]['email'])?$arrAgency[0]['email']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Website</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="strWebsite" value="<?=isset($arrAgency[0]['website'])?$arrAgency[0]['website']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Salary Schedule</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="strSalarySched" value="<?=isset($arrAgency[0]['salarySchedule'])?$arrAgency[0]['salarySchedule']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Time Before OT</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="intBeforeOT" value="<?=isset($arrAgency[0]['minOT'])?$arrAgency[0]['minOT']:''?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Maximum Hours of OT</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="intMaxOT" value="<?=isset($arrAgency[0]['maxOT'])?$arrAgency[0]['maxOT']:''?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Expiration of CTO (Yr / Month)</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="dtmExpYr" value="<?=isset($arrAgency[0]['expirationCTO'])?$arrAgency[0]['expirationCTO']:''?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Flag Ceremony Time</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="intFlagTime" value="<?=isset($arrAgency[0]['flagTime'])?$arrAgency[0]['flagTime']:''?>" disabled>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-2 control-label">Auto Computation of Tax</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="intAutoComputeTax" value="<?=isset($arrAgency[0]['autoComputeTax'])?$arrAgency[0]['autoComputeTax']:''?>" disabled>
                                    </div>
                                </div>

                            <hr>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">GSIS Number</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['gsisId']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">GSIS Employee Share</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['gsisEmpShare']; ?></textarea>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="col-md-2 control-label">GSIS Employer Share</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['gsisEmprShare']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Pagibig Number</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['pagibigId']; ?></textarea>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="col-md-2 control-label">Pagibig Employee Share</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['pagibigEmpShare']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Pagibig Employer Share</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['pagibigEmprShare']; ?></textarea>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label class="col-md-2 control-label">Provident Employee Share</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['providentEmpShare']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Provident Employer Share</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['providentEmprShare']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Philhealth Employee Share</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['philhealthEmpShare']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Philhealth Employer Share</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['philhealthEmprShare']; ?></textarea>
                                    </div>
                                </div>
                                 
                                 <div class="form-group">
                                    <label class="col-md-2 control-label">Philhealth Percentage</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['philhealthPercentage']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Philhealth Number</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['PhilhealthNum']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Mission</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['Mission']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Vision</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" disabled><?=$arrAgency[0]['Vision']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Mandate</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" value="<?=isset($arrAgency[0]['Mandate'])?$arrAgency[0]['Mandate']:''?>" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Bank Account Number</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" value="<?=isset($arrAgency[0]['AccountNum'])?$arrAgency[0]['AccountNum']:''?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end form -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>