<?php 
/** 
Purpose of file:    Edit page for Request Signatories Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
load_plugin('css',array('select','select2'));
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
            <span>Edit Request</span>
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
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-pencil font-dark"></i>
                    <span class="caption-subject bold uppercase"> Edit Request</span>
                </div>
            </div>

            <div class="portlet-body">
                <?=form_open(base_url('libraries/request/edit/'.$this->uri->segment(4)), array('method' => 'post', 'id' => 'frmRequest'))?>
                    <input type="hidden" name="intReqId" value="<?=isset($arrRequest[0]['reqID'])?$arrRequest[0]['reqID']:''?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Type of Request <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="strReqType">
                                            <option value="0">-- SELECT REQUEST --</option>
                                            <?php foreach($arrRequestType as $type) {
                                                    echo '<option value="'.$type['requestCode'].'" '.($arrRequest[0]['RequestType']==$type['requestCode']?'selected':'').'>'.$type['requestDesc'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <label class="control-label"><strong>APPLICANT </strong><span class="required"> * </span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">General <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="strGenApplicant">
                                            <option value="">-- SELECT APPLICANT --</option>
                                            <?php foreach($arrApplicant as $applicant) {
                                                    echo '<option value="'.$applicant['AppliCode'].'" '.($arrRequest[0]['Applicant']==$applicant['AppliCode']?'selected':'').'>'.$applicant['Applicant'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Office Name </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control select2 form-required" name="strOfficeName">
                                            <option value="0">-- SELECT OFFICE --</option>
                                            <?php foreach($arrOfficeName as $office) {
                                                    echo '<option value="'.$office['groupCode'].'" '.($arrRequest[0]['groupCode']==$office['groupCode']?'selected':'').'>'.$office['groupName'].'</option>';                                          
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Employee Name </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control select2 form-required"  name="strName">
                                            <option value="0">-- SELECT EMPLOYEE --</option>
                                            <?php foreach($arrEmployees as $i=>$data) {
                                                    echo '<option value="'.$data['empNumber'].'" >'.getfullname($data['firstname'], $data['surname'], $data['middlename'], $data['middleInitial'], $data['nameExtension']).'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label class="control-label"><strong>1ST SIGNATORY </strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Action </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str1stSigAction">
                                            <option value="">-- SELECT ACTION --</option>
                                            <?php foreach($arrAction as $action) {
                                                    echo '<option value="'.$action['ActionCode'].'">'.$action['ActionDesc'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Signatory </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str1stSignatory">
                                            <option value="">-- SELECT SIGNATORY --</option>
                                            <?php foreach($arrSignatory as $signatory) {
                                                    echo '<option value="'.$signatory['SignCode'].'">'.$signatory['Signatory'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Officer </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control select2 form-required" name="str1stOfficer">
                                            <option value="0">-- SELECT OFFICER --</option>
                                            <?php foreach($arrEmployees as $i=>$data) {
                                                    echo '<option value="'.$data['empNumber'].'">'.$data['surname'].', '.$data['firstname'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label class="control-label"><strong>2ND SIGNATORY </strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Action </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str2ndSigAction">
                                            <option value="">-- SELECT ACTION --</option>
                                            <?php foreach($arrAction as $action) {
                                                    echo '<option value="'.$action['ActionCode'].'">'.$action['ActionDesc'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Signatory </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str2ndSignatory">
                                            <option value="">-- SELECT SIGNATORY --</option>
                                            <?php foreach($arrSignatory as $signatory) {
                                                    echo '<option value="'.$signatory['SignCode'].'">'.$signatory['Signatory'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Officer </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control select2 form-required" name="str2ndOfficer">
                                            <option value="0">-- SELECT OFFICER --</option>
                                            <?php foreach($arrEmployees as $i=>$data) {
                                                    echo '<option value="'.$data['empNumber'].'">'.$data['surname'].', '.$data['firstname'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label class="control-label"><strong>3RD SIGNATORY </strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Action </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str3rdSigAction">
                                            <option value="">-- SELECT ACTION --</option>
                                            <?php foreach($arrAction as $action) {
                                                    echo '<option value="'.$action['ActionCode'].'">'.$action['ActionDesc'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Signatory </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str3rdSignatory">
                                            <option value="">-- SELECT SIGNATORY --</option>
                                            <?php foreach($arrSignatory as $signatory) {
                                                    echo '<option value="'.$signatory['SignCode'].'">'.$signatory['Signatory'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Officer </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control select2 form-required" name="str3rdOfficer">
                                            <option value="0">-- SELECT OFFICER --</option>
                                            <?php foreach($arrEmployees as $i=>$data) {
                                                    echo '<option value="'.$data['empNumber'].'">'.$data['surname'].', '.$data['firstname'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label class="control-label"><strong>4TH SIGNATORY </strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Action </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str4thSigAction">
                                            <option value="">-- SELECT ACTION --</option>
                                            <?php foreach($arrAction as $action) {
                                                    echo '<option value="'.$action['ActionCode'].'">'.$action['ActionDesc'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Signatory </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str4thSignatory">
                                            <option value="">-- SELECT SIGNATORY --</option>
                                            <?php foreach($arrSignatory as $signatory) {
                                                    echo '<option value="'.$signatory['SignCode'].'">'.$signatory['Signatory'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Officer </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control select2 form-required" name="str4thOfficer">
                                            <option value="0">-- SELECT OFFICER --</option>
                                            <?php foreach($arrEmployees as $i=>$data) {
                                                    echo '<option value="'.$data['empNumber'].'">'.$data['surname'].', '.$data['firstname'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-8">
                                <label class="control-label"><strong>4TH SIGNATORY </strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Action </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str4thSigAction">
                                            <option value="">-- SELECT ACTION --</option>
                                            <?php foreach($arrAction as $action) {
                                                    echo '<option value="'.$action['ActionCode'].'">'.$action['ActionDesc'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Signatory </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control bs-select form-required" name="str4thSignatory">
                                            <option value="">-- SELECT SIGNATORY --</option>
                                            <?php foreach($arrSignatory as $signatory) {
                                                    echo '<option value="'.$signatory['SignCode'].'">'.$signatory['Signatory'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Officer </label>
                                    <div class="input-icon right">
                                        <select type="text" class="form-control select2 form-required" name="str4thOfficer">
                                            <option value="0">-- SELECT OFFICER --</option>
                                            <?php foreach($arrEmployees as $i=>$data) {
                                                    echo '<option value="'.$data['empNumber'].'">'.$data['surname'].', '.$data['firstname'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row"><div class="col-sm-8"><hr></div></div>
                        <div class="row">
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-success" id="btn-request-ob">
                                    <i class="icon-check"></i>
                                    <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
                                <a href="<?=base_url('libraries/request')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?=load_plugin('js',array('select','select2'))?>