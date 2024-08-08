
<div id="tab_personal_info" class="tab-pane active">
<?=form_open(base_url(''), array('method' => 'post', 'id' => 'frmPersonal'))?>
    
        <table class="table table-bordered table-striped" class="table-responsive">
            <tr>
                <td>Date of Birth :</td>
                <td><?=$arrData['birthday']?></td>
                <td colspan="2">RESIDENTIAL ADDRESS:</td>  
            </tr>
            <tr>
                <td>Place of Birth :</td>
                <td><?=$arrData['birthPlace']?></td>
                <td>House/Block/Lot No., Street:</td>
                <td><?=$arrData['lot1'].' '.$arrData['street1']?></td>
            </tr>
            <tr>
                <td>Sex :</td>
                <td><?=$arrData['sex']?></td>
                <td>Subdivision/Village, Barangay :</td>
                <td><?=$arrData['subdivision1'].' '.$arrData['barangay1']?></td>
            </tr>
            <tr>
                <td>Civil Status :</td>
                <td><?=$arrData['civilStatus']?></td>
                <td>City/Municipality, Province :</td>
                <td><?=$arrData['city1'].' '.$arrData['province1']?></td>
            </tr>
            <tr>
                <td>Citizenship :</td>
                <td><?=$arrData['citizenship']?></td>
                <td>Zip Code :</td>
                <td><?=$arrData['zipCode1']?></td>
            </tr>
            <tr>
                <td>Height (m) :</td>
                <td><?=$arrData['height']?></td>
                <td>Telephone No. :</td>
                <td><?=$arrData['telephone1']?></td>
            </tr>
            <tr>
                <td>Weight (kg) :</td>
                <td><?=$arrData['weight']?></td>
                <td colspan="2">PERMANENT ADDRESS:</td>
            </tr>
            <tr>
                <td>Blood Type :</td>
                <td><?=$arrData['bloodType']?></td>
                <td>House/Block/Lot No., Street:</td>
                <td><?=$arrData['lot2'].' '.$arrData['street2']?></td>
            </tr>
            <tr>
                <td>GSIS Policy No. :</td>
                <td><?=$arrData['gsisNumber']?></td>
                <td>Subdivision/Village, Barangay :</td>
                <td> <?=$arrData['subdivision2'].' '.$arrData['barangay2']?></td>
            </tr>
            <tr>
                <td>Pag-ibig ID No. :</td>
                <td><?=$arrData['pagibigNumber']?></td>
                <td>City/Municipality, Province :</td>
                <td><?=$arrData['city2'].' '.$arrData['province2']?></td>
            </tr>
            <tr>
                <td>PHILHEALTH ID No. :</td>
                <td><?=$arrData['philHealthNumber']?></td>
                <td>Zip Code :</td>
                <td><?=$arrData['zipCode2']?></td>
            </tr>
            <tr>
                <td>TIN :</td>
                <td><?=$arrData['tin']?></td>
                <td>Telephone No. :</td>
                <td><?=$arrData['telephone2']?></td>
            </tr>
            <tr>
                <td>Email Address :</td>
                <td><?=$arrData['email']?></td>
                <td>Business Partner No.</td>
                <td><?=$arrData['businessPartnerNumber']?></td>
            </tr>
        </table>      
        
         <div class="margin-top-10">
         <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
            <a class="btn green" data-toggle="modal" href="#editPersonal_modal" > Edit </a>
        <?php endif; ?>
        </div><br>  
    <?=form_close()?>                     
    
    <?=form_open(base_url('pds/edit_personal/'.$this->uri->segment(4)), array('method' => 'post', 'name' => 'employeeform' ,'onsubmit' => 'return checkForBlank()'))?>

    <div class="modal fade in" id="editPersonal_modal" tabindex="-1" role="full" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><b>201 File Update</b></h4>
                </div>
                <div class="modal-body"> </div>

                <div class="row">
                    <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-3 text-center">
                        <div class="form-group" >
                            <label class="control-label" ><b>PROFILE </b></label>
                            <div class="input-icon right">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 text-center">
                        <div class="form-group">
                            <label class="control-label"><b>Residential Address </b></label>
                            <div class="input-icon right">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 text-center">
                        <div class="form-group">
                            <label class="control-label"><b>Permanent Address </b></label>
                            <div class="input-icon right">
                            </div>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Salutation : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strSalutation" value="<?=isset($arrData['salutation'])?$arrData['salutation']:''?>">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">House/Blk/Lot No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strLot1" maxlength="30" value="<?=isset($arrData['lot1'])?$arrData['lot1']:''?>">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">House/Blk/Lot No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strLot2" maxlength="30" value="<?=isset($arrData['lot2'])?$arrData['lot2']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                   <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Surname : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strSurname" value="<?=isset($arrData['surname'])?$arrData['surname']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Street : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strStreet1" value="<?=isset($arrData['street1'])?$arrData['street1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Street : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strStreet2" value="<?=isset($arrData['street2'])?$arrData['street2']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                   <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">First Name : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strFirstname" value="<?=isset($arrData['firstname'])?$arrData['firstname']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Subd./Village : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strSubd1" value="<?=isset($arrData['subdivision1'])?$arrData['subdivision1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Subd./Village : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strSubd2" value="<?=isset($arrData['subdivision2'])?$arrData['subdivision2']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                   <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Middle Name : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strMiddlename" value="<?=isset($arrData['middlename'])?$arrData['middlename']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Barangay : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strBrgy1" value="<?=isset($arrData['barangay1'])?$arrData['barangay1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Barangay : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strBrgy2" value="<?=isset($arrData['barangay2'])?$arrData['barangay2']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                   <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Middle Initial : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strMidInitial" value="<?=isset($arrData['middleInitial'])?$arrData['middleInitial']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">City/Municipality : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strCity1" value="<?=isset($arrData['city1'])?$arrData['city1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">City/Municipality : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strCity2" value="<?=isset($arrData['city2'])?$arrData['city2']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Name Ext. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strNameExt" value="<?=isset($arrData['nameExtension'])?$arrData['nameExtension']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Province : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strProv1" value="<?=isset($arrData['province1'])?$arrData['province1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Province : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strProv2" value="<?=isset($arrData['province2'])?$arrData['province2']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Date of Birth : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="dtmBday" value="<?=isset($arrData['birthday'])?$arrData['birthday']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Zip Code : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intZipCode1" value="<?=isset($arrData['zipCode1'])?$arrData['zipCode1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Zip Code : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intZipCode2" value="<?=isset($arrData['zipCode2'])?$arrData['zipCode2']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Place of Birth : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strBirthPlace" value="<?=isset($arrData['birthPlace'])?$arrData['birthPlace']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Telephone No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intTel1" value="<?=isset($arrData['telephone1'])?$arrData['telephone1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Telephone No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intTel2" value="<?=isset($arrData['telephone2'])?$arrData['telephone2']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Sex : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strSex" value="<?=isset($arrData['sex'])?$arrData['sex']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Civil Status : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strCvlStatus" value="<?=isset($arrData['civilStatus'])?$arrData['civilStatus']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">GSIS Policy No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intGSIS" value="<?=isset($arrData['gsisNumber'])?$arrData['gsisNumber']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Mobile No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intMobile" value="<?=isset($arrData['Mobile'])?$arrData['Mobile']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Citizenship : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strCitizenship" value="<?=isset($arrData['citizenship'])?$arrData['citizenship']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Pag-Ibig No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intPagibig" value="<?=isset($arrData['pagibigNumber'])?$arrData['pagibigNumber']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Email Address : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strEmail" value="<?=isset($arrData['email'])?$arrData['email']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Height : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strHeight" value="<?=isset($arrData['height'])?$arrData['height']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Philheath No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intPhilhealth" value="<?=isset($arrData['philHealthNumber'])?$arrData['philHealthNumber']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Payroll Account No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intAccount" value="<?=isset($arrData['AccountNum'])?$arrData['AccountNum']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Weight : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strWeight" value="<?=isset($arrData['weight'])?$arrData['weight']:''?>">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">TIN : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intTin" value="<?=isset($arrData['tin'])?$arrData['tin']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">SSS No. : <span class="required"> * </span></label>
                        </div>
                    </div>
                     <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intSSS" value="<?=isset($arrData['sss'])?$arrData['sss']:''?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Blood Type : <span class="required"> * </span></label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strBloodType" value="<?=isset($arrData['bloodType'])?$arrData['bloodType']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                        </div>
                    </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                 <input type="hidden" name="strEmpNumber" value="<?=isset($arrData['empNumber'])?$arrData['empNumber']:''?>">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" name="btnPersonal" class="btn green">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<?=form_close()?>