<!-- begin modal update personal info -->
<div class="modal fade in" id="editPersonal_modal" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title uppercase"><b>Edit Personal Info</b></h4>
            </div>
            <?=form_open(base_url('pds/edit_personal/'.$this->uri->segment(4)), array('method' => 'post', 'name' => 'frmEditEmp' ,'onsubmit' => 'return checkForBlank()', 'autocomplete' =>'off'))?>
            <div class="modal-body">
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
                            <label class="control-label"><b>Residential Address</b></label>
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
                            <label class="control-label">Salutation </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strSalutation" autcomplete="false" required="" value="<?=isset($arrData['salutation'])?$arrData['salutation']:''?>">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">House/Blk/Lot No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strLot1" maxlength="30" autcomplete="off" value="<?=isset($arrData['lot1'])?$arrData['lot1']:''?>">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">House/Blk/Lot No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strLot2" maxlength="30" autcomplete="off" value="<?=isset($arrData['lot2'])?$arrData['lot2']:''?>">
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
                             <input type="text" class="form-control" name="strSurname" autcomplete="off" value="<?=isset($arrData['surname'])?$arrData['surname']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Street : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strStreet1" autcomplete="off" value="<?=isset($arrData['street1'])?$arrData['street1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Street : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strStreet2" autcomplete="off" value="<?=isset($arrData['street2'])?$arrData['street2']:''?>">
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
                            <input type="text" class="form-control" name="strFirstname" autcomplete="off" value="<?=isset($arrData['firstname'])?$arrData['firstname']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Subd./Village :</label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strSubd1" autcomplete="off" value="<?=isset($arrData['subdivision1'])?$arrData['subdivision1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Subd./Village : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strSubd2" autcomplete="off" value="<?=isset($arrData['subdivision2'])?$arrData['subdivision2']:''?>">
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
                            <label class="control-label">Middle Name : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strMiddlename" autcomplete="off" value="<?=isset($arrData['middlename'])?$arrData['middlename']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Barangay : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strBrgy1" autcomplete="off" value="<?=isset($arrData['barangay1'])?$arrData['barangay1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Barangay : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strBrgy2" autcomplete="off" value="<?=isset($arrData['barangay2'])?$arrData['barangay2']:''?>">
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
                            <label class="control-label">Middle Initial : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strMidInitial" autcomplete="off" value="<?=isset($arrData['middleInitial'])?$arrData['middleInitial']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">City/Municipality : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strCity1" autcomplete="off" value="<?=isset($arrData['city1'])?$arrData['city1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">City/Municipality : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strCity2" autcomplete="off" value="<?=isset($arrData['city2'])?$arrData['city2']:''?>">
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
                            <label class="control-label">Name Ext. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strNameExt" autcomplete="off" value="<?=isset($arrData['nameExtension'])?$arrData['nameExtension']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Province : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strProv1" autcomplete="off" value="<?=isset($arrData['province1'])?$arrData['province1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Province :</label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strProv2" autcomplete="off" value="<?=isset($arrData['province2'])?$arrData['province2']:''?>">
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
                            <label class="control-label">Date of Birth : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input class="form-control form-control-inline input-medium date-picker" type="text" class="form-control" name="dtmBday" autcomplete="off" value="<?=isset($arrData['birthday'])?$arrData['birthday']:''?>" data-date-format="yyyy-mm-dd">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Zip Code : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intZipCode1" autcomplete="off" value="<?=isset($arrData['zipCode1'])?$arrData['zipCode1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Zip Code : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intZipCode2" autcomplete="off" value="<?=isset($arrData['zipCode2'])?$arrData['zipCode2']:''?>">
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
                            <label class="control-label">Place of Birth : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strBirthPlace" autcomplete="off" value="<?=isset($arrData['birthPlace'])?$arrData['birthPlace']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Telephone No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intTel1" autcomplete="off" value="<?=isset($arrData['telephone1'])?$arrData['telephone1']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Telephone No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intTel2" autcomplete="off" value="<?=isset($arrData['telephone2'])?$arrData['telephone2']:''?>">
                        </div>
                    </div>
                </div>
                <?php //print_r($arrData[sex]); ?>
                <div class="row">
                <div class="col-sm-1">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Sex : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <select type="text" class="form-control" name="strSex" id="strSex" autocomplete="off" value="<?=!empty($arrData['sex'])?$arrData['sex']:''?>">
                                <option value="">Select</option>
                                <option <?php if ($arrData['sex'] == 'M' ) echo 'selected' ; ?> value="M">M</option>
                                <option <?php if ($arrData['sex'] != 'M' ) echo 'selected' ; ?> value="F">F</option>
                            </select>
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
                            <label class="control-label">Civil Status : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                              <select name="strCvlStatus" id="strCvlStatus" type="text" class="form-control" autocomplete="off">
                                <option value="">Please Select</option>
                                <?php 
                                    foreach(array('Single','Married','Separated','Widowed','Annulled','Others') as $cs):
                                        $select = isset($arrData) ? $arrData['civilStatus'] == $cs ? 'selected' : '' : '';
                                        echo '<option value="'.$cs.'" '.$select.'>'.$cs.'</option>';
                                    endforeach;
                                 ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">GSIS Policy No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intGSIS" autcomplete="off" value="<?=isset($arrData['gsisNumber'])?$arrData['gsisNumber']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Mobile No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intMobile" autcomplete="off" value="<?=isset($arrData['Mobile'])?$arrData['Mobile']:''?>">
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
                            <label class="control-label">Citizenship : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <select type="text" class="form-control" name="strCitizenship" id="strCitizenship" autocomplete="off" value="<?=!empty($arrData['sex'])?$arrData['sex']:''?>">
                                <option value="">Select</option>
                                <option <?php if ($arrData['citizenship'] == 'Filipino' ) echo 'selected' ; ?> value="Filipino">Filipino</option>
                                <option <?php if ($arrData['citizenship'] != 'Filipino' ) echo 'selected' ; ?> value="Dual Citizenship">Dual Citizenship</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">GSIS BP No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intGSISBP" autcomplete="off" value="<?=isset($arrData['businessPartnerNumber'])?$arrData['businessPartnerNumber']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Email Address : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strEmail" autcomplete="off" value="<?=isset($arrData['email'])?$arrData['email']:''?>">
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
                            <label class="control-label">Height : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strHeight" autcomplete="off" value="<?=isset($arrData['height'])?$arrData['height']:''?>">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Pag-Ibig No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intPagibig" autcomplete="off" value="<?=isset($arrData['pagibigNumber'])?$arrData['pagibigNumber']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Payroll Account No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intAccount" autcomplete="off" value="<?=isset($arrData['AccountNum'])?$arrData['AccountNum']:''?>">
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
                            <label class="control-label">Weight : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="strWeight" autcomplete="off" value="<?=isset($arrData['weight'])?$arrData['weight']:''?>">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">Philheath No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intPhilhealth" autcomplete="off" value="<?=isset($arrData['philHealthNumber'])?$arrData['philHealthNumber']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">SSS No. : </label>
                        </div>
                    </div>
                     <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="intSSS" autcomplete="off" value="<?=isset($arrData['sssNumber'])?$arrData['sssNumber']:''?>">
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
                            <label class="control-label">Blood Type : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                            <input type="text" class="form-control" name="strBloodType" autcomplete="off" value="<?=isset($arrData['bloodType'])?$arrData['bloodType']:''?>">
                        </div>
                    </div>
                    <div class="col-sm-1 text-left">
                        <div class="form-group">
                            <label class="control-label">TIN No. : </label>
                        </div>
                    </div>
                    <div class="col-sm-2" text-left>
                        <div class="form-group">
                             <input type="text" class="form-control" name="intTin" autcomplete="off" value="<?=isset($arrData['tin'])?$arrData['tin']:''?>">
                        </div>
                    </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                        </div>
                    </div>
                </div>
                
            </div>
                <div class="modal-footer">
                    <input type="hidden" name="strEmpNumber" value="<?=isset($arrData['empNumber'])?$arrData['empNumber']:''?>">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" name="btnPersonal" class="btn green">Save</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<!-- end modal update personal info -->


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

            var form2 = $('#frmEditEmp');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    strEmpID: {
                        minlength: 2,
                        required: true,
                    },
                    strSurname: {
                        minlength: 2,
                        required: true,
                    },
                    strFirstname: {
                        minlength: 2,
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
<script>

    $('#dtmBday').datepicker({dateFormat: 'dd-mm-yyyy'});

</script>