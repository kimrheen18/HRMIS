<?php 
/** 
Purpose of file:    Add Employee View for 201
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?=load_plugin('css', array('datepicker'))?>

<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>201 File</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Add Employee</span>
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
                    <span class="caption-subject bold uppercase">Add New Employee</span>
                </div>
            </div>
            <div class="portlet-body form">
                <?=form_open(base_url('hr/add_employee/add_employee'), array('method' => 'post', 'name' => 'employeeform',  'onsubmit' => 'return checkForBlank()', 'id' => 'frmAddEmp'))?>
                    <div class="form-body">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right bold">ID Number <span class="required"> * </span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strEmpID" id="strEmpID" type="text" size="20" maxlength="20" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strEmpID'))?$this->session->userdata('strEmpID'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Salutation </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strSalutation" id="strSalutation" type="text" size="20" maxlength="20" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strSalutation'))?$this->session->userdata('strSalutation'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Surname <span class="required"> * </span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strSurname" id="strSurname" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strSurname'))?$this->session->userdata('strSurname'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> First Name <span class="required"> * </span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strFirstname" id="strFirstname" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strFirstname'))?$this->session->userdata('strFirstname'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Middle Name </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strMiddlename" id="strMiddlename" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strMiddlename'))?$this->session->userdata('strMiddlename'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Middle Initial  </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strMidInitial" id="strMidInitial" type="text" size="20" maxlength="10" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strMidInitial'))?$this->session->userdata('strMidInitial'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Name Extension </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strNameExt" id="strNameExt" type="text" size="20" maxlength="10" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strNameExt'))?$this->session->userdata('strNameExt'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Date of Birth </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input class="form-control form-control-inline input-medium date-picker" name="dtmBday" id="dtmBday" autocomplete="off" size="16" type="text" value="" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Place of Birth </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strBirthPlace" id="strBirthPlace" type="text" size="20" maxlength="255" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strBirthPlace'))?$this->session->userdata('strBirthPlace'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Sex </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <select name="strSex" id="strSex" type="text" autocomplete="off" class="form-control">
                                            <option value="">Please Select</option>
                                            <option value="Female">Female</option>
                                            <option value="Male">Male</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Civil Status </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                            <select name="strCvlStatus" id="strCvlStatus" type="text" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strCvlStatus'))?$this->session->userdata('strCvlStatus'):''?>">
                                                <option value="">Please Select</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Separated">Separated</option>
                                                <option value="Widowed">Widowed</option>
                                                <option value="Annulled">Annulled</option>
                                                <option value="Others">Others</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Citizenship </label>
                                <div class="col-md-9">
                                    <label><input type="radio" name="strCitizenship" <?php if (isset($strCitizenship) && $strCitizenship=="Filipino") echo "checked";?> value="Filipino"> &nbsp;Filipino</label>
                                    <label><input type="radio" name="strCitizenship" <?php if (isset($strCitizenship) && $strCitizenship=="Dual") echo "checked";?> value="dual"> &nbsp;Dual Citizenship</label>
                                </div>  
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Height (m) </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strHeight" id="strHeight" type="text" size="20" maxlength="10" autocomplete="off" class="form-control" value="<?=!empty($this->session->userdata('strHeight'))?$this->session->userdata('strHeight'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Weight (kg) </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strWeight" id="strWeight" type="text" size="20" maxlength="10" autocomplete="off" class="form-control" value="<?=!empty($this->session->userdata('strWeight'))?$this->session->userdata('strWeight'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Blood Type </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strBloodType" id="strBloodType" type="text" size="20" maxlength="6" autocomplete="off" class="form-control" value="<?=!empty($this->session->userdata('strBloodType'))?$this->session->userdata('strBloodType'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> GSIS BP No. </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intGSIS" id="intGSIS" type="text" size="20" maxlength="25" autocomplete="off" class="form-control" value="<?=!empty($this->session->userdata('intGSIS'))?$this->session->userdata('intGSIS'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> PAG-IBIG ID No. </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intPagibig" id="intPagibig" type="text" size="20" maxlength="14" autocomplete="off" class="form-control" value="<?=!empty($this->session->userdata('intPagibig'))?$this->session->userdata('intPagibig'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> PHILHEALTH No. </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intPhilhealth" id="intPhilhealth" type="text" size="20" maxlength="14" autocomplete="off" class="form-control" value="<?=!empty($this->session->userdata('intPhilhealth'))?$this->session->userdata('intPhilhealth'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> TIN </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intTin" id="intTin" type="text" size="20" maxlength="25" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intTin'))?$this->session->userdata('intTin'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Email Address </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strEmail" id="strEmail" type="text" size="20" maxlength="30" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strEmail'))?$this->session->userdata('strEmail'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> SSS Number </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intSSS" id="intSSS" type="text" size="20" maxlength="20" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intSSS'))?$this->session->userdata('intSSS'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Telephone Number </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intTel1" id="intTel1" type="text" size="20" maxlength="10" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intTel1'))?$this->session->userdata('intTel1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-12 control-label"> <center> <h4 class="bold">RESIDENTIAL ADDRESS</h4> </center></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> House/Block/Lot No. </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strLot1" id="strLot1" type="text" size="20" maxlength="30" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strLot1'))?$this->session->userdata('strLot1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Street </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strStreet1" id="strStreet1" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strStreet1'))?$this->session->userdata('strStreet1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Subdivision/Village </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strSubd1" id="strSubd1" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strSubd1'))?$this->session->userdata('strSubd1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Barangay </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strBrgy1" id="strBrgy1" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strBrgy1'))?$this->session->userdata('strBrgy1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> City/Municipality </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strCity1" id="strCity1" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strCity1'))?$this->session->userdata('strCity1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Province </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strProv1" id="strProv1" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strProv1'))?$this->session->userdata('strProv1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Zip Code </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intZipCode1" id="intZipCode1" type="number" size="20" maxlength="4" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intZipCode1'))?$this->session->userdata('intZipCode1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                            
                                <label class="col-md-2 control-label right"> Telephone Number </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intTel1" id="intTel1" type="text" size="20" maxlength="20" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intTel1'))?$this->session->userdata('intTel1'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-12 control-label"> <center> <h4 class="bold">PERMANENT ADDRESS</h4> </center></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> House/Block/Lot No. </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strLot2" id="strLot2" type="text" size="20" maxlength="30" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strLot2'))?$this->session->userdata('strLot2'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Street </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strStreet2" id="strStreet2" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strStreet2'))?$this->session->userdata('strStreet2'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Subdivision/Village </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strSubd2" id="strSubd2" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strSubd2'))?$this->session->userdata('strSubd2'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Barangay </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strBrgy2" id="strBrgy2" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strBrgy2'))?$this->session->userdata('strBrgy2'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> City/Municipality </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strCity2" id="strCity2" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strCity2'))?$this->session->userdata('strCity2'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Province </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="strProv2" id="strProv2" type="text" size="20" maxlength="50" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('strProv2'))?$this->session->userdata('strProv2'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Zip Code </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intZipCode2" id="intZipCode2" type="number" size="20" maxlength="4" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intZipCode2'))?$this->session->userdata('intZipCode2'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Telephone Number </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intTel2" id="intTel2" type="text" size="20" maxlength="20" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intTel2'))?$this->session->userdata('intTel2'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right"> Mobile Number </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intMobile" id="intMobile" type="text" size="20" maxlength="15" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intMobile'))?$this->session->userdata('intMobile'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label right">Payroll Account Number </label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input name="intAccount" id="intAccount" type="text" size="20" maxlength="15" class="form-control" autocomplete="off" value="<?=!empty($this->session->userdata('intAccount'))?$this->session->userdata('intAccount'):''?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-11 text-center">
                                    <input name="strStatus" id="strStatus" type="hidden" value="In-Service">
                                    <button type="submit" class="btn green"> <i class="fa fa-<?=$this->uri->segment(3) == 'edit' ? 'pencil' : 'plus'?>"></i> <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Add'?></button>
                                    <a href="<?=base_url('hr/add_employee')?>" class="btn blue"> <i class="icon-ban"></i> Clear</a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?=form_close()?>
            </div>
        </div>
    </div>
</div>


<script src="<?=base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script>

    $('#dtmBday').datepicker({dateFormat: 'dd-mm-yyyy'});

function checkForBlank()
{
   var spaceCount = 0;
 
  if((document.employeeform.strEmpID.value==0) && (document.employeeform.strSalutation.value==0) && (document.employeeform.strSurname.value==0) && (document.employeeform.strFirstname.value==0) && (document.employeeform.strMiddlename.value==0) && (document.employeeform.strMidInitial.value==0) && (document.employeeform.strNameExt.value==0) && (document.employeeform.dtmBday.value==0) && (document.employeeform.strBirthPlace.value==0) && (document.employeeform.strSex.value==0) && (document.employeeform.strHeight.value==0) && (document.employeeform.strWeight.value==0) && (document.employeeform.strBloodType.value==0) && (document.employeeform.intGSIS.value==0) && (document.employeeform.intPagibig.value==0) && (document.employeeform.strPhilhealth.value==0) && (document.employeeform.intTin.value==0) && (document.employeeform.strEmail.value==0) && (document.employeeform.intSSS.value==0) && (document.employeeform.intZipCode1.value=='') && (document.employeeform.intZipCode2.value=='') && (document.employeeform.intTelephone1.value==0)  && (document.employeeform.intTelephone2.value==0) && (document.employeeform.intMobile.value==0) && (document.employeeform.intAccount.value==0))

      { 
      document.getElementById('idnum').innerHTML = "Invalid input!";
      document.getElementById('salutation').innerHTML = "Invalid input!";
      document.getElementById('sur').innerHTML = "Invalid input!";
      document.getElementById('first').innerHTML = "Invalid input!";
      document.getElementById('middle').innerHTML = "Invalid input!";
      document.getElementById('mid').innerHTML = "Invalid input!";
      document.getElementById('namext').innerHTML = "Invalid input!";
      document.getElementById('bday').innerHTML = "Invalid input!";
      document.getElementById('place').innerHTML = "Invalid input!";
      document.getElementById('sex').innerHTML = "Invalid input!";
      document.getElementById('height').innerHTML = "Invalid input!";
      document.getElementById('weight').innerHTML = "Invalid input!";
      document.getElementById('blood').innerHTML = "Invalid input!";
      document.getElementById('gsis').innerHTML = "Invalid input!";
      document.getElementById('pagibig ').innerHTML = "Invalid input!";
      document.getElementById('philhealth ').innerHTML = "Invalid input!";
      document.getElementById('tin').innerHTML = "Invalid input!";
      document.getElementById('email').innerHTML = "Invalid input!";
      document.getElementById('sss').innerHTML = "Invalid input!";

      employeeform.strEmpID.focus();
      employeeform.strSalutation.focus();
      employeeform.strSurname.focus();
      employeeform.strFirstname.focus();
      employeeform.strMiddlename.focus();
      employeeform.strMidInitial.focus();
      employeeform.strNameExt.focus();
      employeeform.dtmBday.focus();
      employeeform.strBirthPlace.focus();
      employeeform.strSex.focus();
      employeeform.strHeight.focus();
      employeeform.strWeight.focus();
      employeeform.strBloodType.focus();
      employeeform.intGSIS.focus();
      employeeform.intPagibig.focus();
      employeeform.strPhilhealth.focus();
      employeeform.intTin.focus();
      employeeform.strEmail.focus();
 

      return(false);
      }
}

</script>

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

            var form2 = $('#frmAddEmp');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    strEmpID: {
                        required: true,
                       
                    },
                    strSurname: {
                         required: true,
                     
                    },
                    strFirstname: {
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

