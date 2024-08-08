<?=load_plugin('css', array('profile-2', 'datepicker'))?>
<div class="tab-pane active" id="tab_1_6">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title" <?=$action == 'view' ? '' : 'hidden'?>>
                <a class="btn btn-primary" href="<?=base_url('finance/compensation/personnel_profile/edit_tax_details/'.$this->uri->segment(5))?>">
                    <i class="fa fa-edit"></i> Edit</a>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-12">
                        <?=form_open('', array('method' => 'post', 'role' => 'form'))?>
                            <div class="portlet box default ">
                                <div class="portlet-title">
                                    <div class="caption" style="text-align: center; display: block; float: inherit; font-size: medium;">Other Dependent for the Head of the Family</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name of Dependent</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtdependent_name" 
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['otherDependent'] : ''?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Date of Birth</label>
                                        <div class="input-icon right">
                                            <input class="form-control date-picker form-required" data-date="2012-03-01" data-date-format="yyyy-mm-dd" 
                                                    name="txtdependent_bday" type="text" value="<?=isset($arrTaxDetails) ? $arrTaxDetails['dBirthDate'] : ''?>"
                                                    <?=$action=='view' ? 'disabled' : ''?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Relationship</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtdependent_rel" 
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['dRelationship'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <br>
                            <div class="portlet box default ">
                                <div class="portlet-title">
                                    <div class="caption" style="text-align: center; display: block; float: inherit; font-size: medium;">Previous Employer Information (1)</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">TIN Number</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp1_tin"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pTin'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Registered Address</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp1_reg"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pAddress'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Employer's Name</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp1_name"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pEmployer'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Zip Code</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp1_zip"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pZipCode'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="portlet box default ">
                                <div class="portlet-title">
                                    <div class="caption" style="text-align: center; display: block; float: inherit; font-size: medium;">Previous Employer Information (2)</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">TIN Number</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp2_tin"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pTin1'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Registered Address</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp2_reg"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pAddress1'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Employer's Name</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp2_name"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pEmployer1'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Zip Code</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp2_zip"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pZipCode1'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="portlet box default ">
                                <div class="portlet-title">
                                    <div class="caption" style="text-align: center; display: block; float: inherit; font-size: medium;">Previous Employer Information (3)</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">TIN Number</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp3_tin"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pTin2'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Registered Address</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp3_reg"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pAddress2'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Employer's Name</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp3_name"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pEmployer2'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Zip Code</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtemp3_zip"
                                                    value="<?=isset($arrTaxDetails) ? $arrTaxDetails['pZipCode2'] : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="portlet box default ">
                                <div class="portlet-title">
                                    <div class="caption" style="text-align: center; display: block; float: inherit; font-size: medium;">Summary from Previous Employer</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Taxable Compensation</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txtcompen"
                                                    value="<?=isset($arrTaxDetails) ? number_format($arrTaxDetails['pTaxComp'], 2) : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Amount of Taxes withheld</label>
                                        <div class="input-icon right">
                                            <input type="text" class="form-control" <?=$action=='view' ? 'disabled' : ''?> name="txttax"
                                                    value="<?=isset($arrTaxDetails) ? number_format($arrTaxDetails['pTaxWheld'], 2) : ''?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <center <?=$action=='edit' ? '' : 'hidden'?>>
                                <br><br>
                                <div class="form-actions">
                                    <a href="<?=base_url('finance/compensation/personnel_profile/tax_details/'.$this->uri->segment(5))?>"><button type="button" class="btn default">Cancel</button></a>
                                    <button type="submit" class="btn green">Submit</button>
                                </div>
                            </center>
                        <?=form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php load_plugin('js', array('datepicker')) ?>
<script>
    $(document).ready(function() {
        $('.date-picker').datepicker();
    });
</script>