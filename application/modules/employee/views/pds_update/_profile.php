<div class="col-md-12">
	<?=form_open('employee/pds_update/submitProfile?action='.$action, array('method' => 'post', 'id' => 'frmprofile'))?>
		<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_PROFILE?>">
		<div class="row" id="surname_textbox">
	        <div class="col-sm-8">
	            <div class="form-group">
	            	<label class="control-label">Surname : <span class="required"> * </span></label>
	            	<div class="input-icon right">
	            		<input type="text" class="form-control" name="strSname" id="strSname" maxlength="50" 
	            				value="<?=isset($arrData[0]['surname']) ? (isset($pds_details) ? $pds_details[1] : $arrData[0]['surname'] ) : ''?>" autocomplete="off">
		            </div>
	            </div>
	        </div>
	    </div>
		<div class="row" id="firstname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Firstname : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strFname" id="strFname" maxlength="50" 
								value="<?=isset($arrData[0]['firstname'])  ? (isset($pds_details) ? $pds_details[2] : $arrData[0]['firstname']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="midname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Middle Name : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strMname" id="strMname" maxlength="50"
							value="<?=isset($arrData[0]['middlename']) ? (isset($pds_details) ? $pds_details[3] : $arrData[0]['middlename']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="extension_textbox">
			<div class="col-sm-3">
				<div class="form-group">
					<label class="control-label">Name Extension: </label>
					<input type="text" class="form-control" name="strExtension" maxlength="10" 
							value="<?=isset($arrData[0]['nameExtension']) ? (isset($pds_details) ? $pds_details[4] : $arrData[0]['nameExtension']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="bdate_textbox">
			<div class="col-sm-3">
				<div class="form-group">
					<label class="control-label">Date of Birth : </label>
					<input class="form-control date-picker" name="dtmBirthdate" id="dtmBirthdate" type="text" data-date-format="yyyy-mm-dd" autocomplete="off" 
							value="<?=isset($arrData[0]['birthday']) ? (isset($pds_details) ? $pds_details[5] : $arrData[0]['birthday']) :''?>" >
				</div>
			</div>
		</div>
		<div class="row" id="birthplace_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Place of Birth : </label>
					<input type="text" class="form-control" name="strBirthplace" maxlength="80" 
							value="<?=isset($arrData[0]['birthPlace']) ? (isset($pds_details) ? $pds_details[6] : $arrData[0]['birthPlace']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="cs_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Civil Status : </label>
					<select name="strCS" id="strCS" type="text" class="form-control bs-select" autocomplete="off">
						<option value="">Please Select</option>
						<?php 
							foreach(array('Single','Married','Separated','Widowed','Annulled','Others') as $cs):
								$select = isset($arrData) ? $arrData[0]['civilStatus'] == $cs ? 'selected' : '' : '';
								echo '<option value="'.$cs.'" '.$select.'>'.$cs.'</option>';
							endforeach;
						 ?>
					</select>
				</div>
			</div>
		</div>
		<hr>

		<div class="row" id="weight_textbox">
			<div class="col-sm-3">
				<div class="form-group">
					<label class="control-label">Weight(kg) : </label>
					<input type="text" class="form-control" name="intWeight" maxlength="5"
							value="<?=isset($arrData[0]['weight']) ? (isset($pds_details) ? $pds_details[8] : $arrData[0]['weight']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="height_textbox">
			<div class="col-sm-3">
				<div class="form-group">
					<label class="control-label">Height(m) : </label>
					<input type="text" class="form-control" name="intHeight" maxlength="5" 
							value="<?=isset($arrData[0]['height']) ? (isset($pds_details) ? $pds_details[9] : $arrData[0]['height']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="blood_textbox">
			<div class="col-sm-3">
				<div class="form-group">
					<label class="control-label">Blood Type: </label>
					<input type="text" class="form-control" name="strBlood" maxlength="6" 
							value="<?=isset($arrData[0]['bloodType']) ? (isset($pds_details) ? $pds_details[10] : $arrData[0]['bloodType']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="gsis_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">GSIS Policy No. : </label>
					<input type="text" class="form-control" name="intGSIS" maxlength="25" 
							value="<?=isset($arrData[0]['gsisNumber']) ? (isset($pds_details) ? $pds_details[11] : $arrData[0]['gsisNumber']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="bp_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Business Partner No. : </label>
					<input type="text" class="form-control"  name="strBP" maxlength="25" 
							value="<?=isset($arrData[0]['businessPartnerNumber']) ? (isset($pds_details) ? $pds_details[12] : $arrData[0]['businessPartnerNumber']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="pagibig_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">PAG-IBIG ID No. : </label>
					<input type="text" class="form-control"  name="intPagibig" maxlength="14" 
							value="<?=isset($arrData[0]['pagibigNumber']) ? (isset($pds_details) ? $pds_details[13] : $arrData[0]['pagibigNumber']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="philhealth_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">PHILHEALTH No. :  </label>
					<input type="text" class="form-control" name="intPhilhealth" maxlength="14" 
							value="<?=isset($arrData[0]['philHealthNumber']) ? (isset($pds_details) ? $pds_details[14] : $arrData[0]['philHealthNumber']) : ''?>"  autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="tin_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">TIN :  </label>
					<input type="text" class="form-control" name="intTin" maxlength="20" 
							value="<?=isset($arrData[0]['tin']) ? (isset($pds_details) ? $pds_details[15] : $arrData[0]['tin']) : ''?>"  autocomplete="off">
				</div>
			</div>
		</div>
		<hr>

		<div class="row" id="block1_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label"> <b>RESIDENTIAL ADDRESS :</b> <br> House/Block/Lot No. : <span class="required"> * </span></label>
					<input type="text" class="form-control" name="strBlk1" id="strBlk1" maxlength="10" 
							value="<?=isset($arrData[0]['lot1']) ? (isset($pds_details) ? $pds_details[16] : $arrData[0]['lot1']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="street1_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Street : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strStreet1" id="strStreet1" maxlength="50" 
								value="<?=isset($arrData[0]['street1']) ? (isset($pds_details) ? $pds_details[17] : $arrData[0]['street1']) : ''?>"  autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="subd1_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Subdivision/Village : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strSubd1" id="strSubd1" maxlength="50"
								value="<?=isset($arrData[0]['subdivision1']) ? (isset($pds_details) ? $pds_details[18] : $arrData[0]['subdivision1']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="brgy1_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Barangay : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strBrgy1" id="strBrgy1" maxlength="50"
								value="<?=isset($arrData[0]['barangay1']) ? (isset($pds_details) ? $pds_details[19] : $arrData[0]['barangay1']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="city1_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">City/Municipality : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strCity1" id="strCity1" maxlength="50" 
								value="<?=isset($arrData[0]['city1']) ? (isset($pds_details) ? $pds_details[20] : $arrData[0]['city1']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="prov1_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Province : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strProv1" id="strProv1" maxlength="50" 
								value="<?=isset($arrData[0]['province1']) ? (isset($pds_details) ? $pds_details[21] : $arrData[0]['province1']) : ''?>"  autocomplete="off">
					</div>
				</div>
			</div>
		</div>   
		<div class="row" id="zip1_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Zip Code : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strZipCode1" id="strZipCode1" maxlength="4"
								value="<?=isset($arrData[0]['zipCode1']) ? (isset($pds_details) ? $pds_details[22] : $arrData[0]['zipCode1']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>  
		<div class="row" id="tel1_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Telephone No. : </label>
					<input type="text" class="form-control" name="strTel1" maxlength="20"
							value="<?=isset($arrData[0]['telephone1']) ? (isset($pds_details) ? $pds_details[23] : $arrData[0]['telephone1']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="block2_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label"> <b>PERMANENT ADDRESS :</b> <br> House/Block/Lot No. : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strBlk2" id="strBlk2" maxlength="10" 
								value="<?=isset($arrData[0]['lot2']) ? (isset($pds_details) ? $pds_details[24] : $arrData[0]['lot2']) : ''?>"  autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
		<div class="row" id="street2_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Street : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strStreet2" id="strStreet2" maxlength="50" 
								value="<?=isset($arrData[0]['street2']) ? (isset($pds_details) ? $pds_details[25] : $arrData[0]['street2']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
		<div class="row" id="subd2_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Subdivision/Village : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strSubd2" id="strSubd2" maxlength="50" 
								value="<?=isset($arrData[0]['subdivision2']) ? (isset($pds_details) ? $pds_details[26] : $arrData[0]['subdivision2']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
		<div class="row" id="brgy2_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Barangay : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strBrgy2" id="strBrgy2" maxlength="50"
								value="<?=isset($arrData[0]['barangay2']) ? (isset($pds_details) ? $pds_details[27] : $arrData[0]['barangay2']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
		<div class="row" id="city2_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">City/Municipality : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strCity2" id="strCity2" maxlength="50" 
								value="<?=isset($arrData[0]['city2']) ? (isset($pds_details) ? $pds_details[28] : $arrData[0]['city2']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>  
		<div class="row" id="prov2_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Province : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strProv2" id="strProv2" maxlength="50" 
								value="<?=isset($arrData[0]['province2']) ? (isset($pds_details) ? $pds_details[29] : $arrData[0]['province2']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>   
		<div class="row" id="zip2_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Zip Code : <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strZipCode2" id="strZipCode2" maxlength="4" 
								value="<?=isset($arrData[0]['zipCode2']) ? (isset($pds_details) ? $pds_details[30] : $arrData[0]['zipCode2']) : ''?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
		<div class="row" id="tel2_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Telephone No.: </label>
					<input type="text" class="form-control" name="intTel2" maxlength="20" 
							value="<?=isset($arrData[0]['telephone2']) ? (isset($pds_details) ? $pds_details[31] : $arrData[0]['telephone2']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>  
		<div class="row" id="email_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Email Address (if any) : </label>
					<input type="text" class="form-control" name="strEmail" maxlength="30" 
							value="<?=isset($arrData[0]['email']) ? (isset($pds_details) ? $pds_details[32] : $arrData[0]['email']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>    
		<div class="row" id="cp_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Cellphone No. : </label>
					<input type="text" class="form-control" name="strCP" maxlength="15" 
							value="<?=isset($arrData[0]['mobile']) ? (isset($pds_details) ? $pds_details[33] : $arrData[0]['mobile']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div> 
		<div class="row"><div class="col-sm-8"><hr></div></div>
		<div class="row">
		    <div class="col-sm-8">
		        <button type="submit" class="btn btn-success" id="btn-request-profile">
		            <i class="icon-check"></i>
		            <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
		        <a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    </div>
		</div>
	<?=form_close()?>
</div>