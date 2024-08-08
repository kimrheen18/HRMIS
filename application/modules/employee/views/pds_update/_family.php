<div class="col-md-12">
	<?=form_open('employee/pds_update/submitFam?action='.$action, array('method' => 'post', 'id' => 'frmfamily'))?>
		<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_FAMILY?>">
		<div class="row" id="ssurname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label"><b>NAME OF SPOUSE :</b> <br> Surname :  </label>
					<input type="text" class="form-control" name="strSSurname" maxlength="80" 
							value="<?=isset($arrData[0]['spouseSurname']) ? (isset($pds_details) > 0 ? $pds_details[1] : $arrData[0]['spouseSurname']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div> 
		<div class="row" id="sfirstname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Firstname :  </label>
					<input type="text" class="form-control" name="strSFirstname" maxlength="80" 
							value="<?=isset($arrData[0]['spouseFirstname']) ? (isset($pds_details) > 0 ? $pds_details[2] : $arrData[0]['spouseFirstname']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div> 
		<div class="row" id="smidname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Middlename : </label>
					<input type="text" class="form-control" name="strSMidname" maxlength="80" 
							value="<?=isset($arrData[0]['spouseMiddlename']) ? (isset($pds_details) > 0 ? $pds_details[3] : $arrData[0]['spouseMiddlename']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div> 
		<div class="row" id="spouseExt_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Name Extension : </label>
					<input type="text" class="form-control" name="strSNameExt" maxlength="80" 
							value="<?=isset($arrData[0]['spousenameExtension']) ? (isset($pds_details) > 0 ? $pds_details[4] : $arrData[0]['spousenameExtension']) : ''?>"  autocomplete="off">
				</div>
			</div>
		</div>       
		<div class="row" id="occu_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Occupation  : </label>
					<input type="text" class="form-control" name="strSOccupation" maxlength="50" 
							value="<?=isset($arrData[0]['spouseWork']) ? (isset($pds_details) > 0 ? $pds_details[5] : $arrData[0]['spouseWork']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>     
		<div class="row" id="busname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Employer/Business Name : </label>
					<input type="text" class="form-control" name="strSBusname" maxlength="70" 
							value="<?=isset($arrData[0]['spouseBusName']) ? (isset($pds_details) > 0 ? $pds_details[6] : $arrData[0]['spouseBusName']) : ''?>"  autocomplete="off">
				</div>
			</div>
		</div>       
		<div class="row" id="busadd_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Business Address : </label>
					<input type="text" class="form-control" name="strSBusadd" 
							value="<?=isset($arrData[0]['spouseBusAddress']) ? (isset($pds_details) > 0 ? $pds_details[7] : $arrData[0]['spouseBusAddress']) : ''?>"  autocomplete="off">
				</div>
			</div>
		</div>       
		<div class="row" id="tel_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Telephone No. :</label>
					<input type="text" class="form-control" name="strSTel" maxlength="10" 
							value="<?=isset($arrData[0]['spouseTelephone']) ? (isset($pds_details) > 0 ? $pds_details[8] : $arrData[0]['spouseTelephone']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<hr>
		<div class="row" id="fsurname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label"> <b>NAME OF FATHER :</b> <br> Surname :</label>
					<input type="text" class="form-control" name="strFSurname" maxlength="80" 
							value="<?=isset($arrData[0]['fatherSurname']) ? (isset($pds_details) > 0 ? $pds_details[9] : $arrData[0]['fatherSurname']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>         
		<div class="row" id="ffirstname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Firstname :</label>
					<input type="text" class="form-control" name="strFFirstname" maxlength="80" 
							value="<?=isset($arrData[0]['fatherFirstname']) ? (isset($pds_details) > 0 ? $pds_details[10] : $arrData[0]['fatherFirstname']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="fmidname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Middle name :</label>
					<input type="text" class="form-control" name="strFMidname" maxlength="80" 
							value="<?=isset($arrData[0]['fatherMiddlename']) ? (isset($pds_details) > 0 ? $pds_details[11] : $arrData[0]['fatherMiddlename']) : ''?>"  autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="fextension_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Name Extension :</label>
					<input type="text" class="form-control" name="strFExtension" maxlength="80" 
							value="<?=isset($arrData[0]['fathernameExtension']) ? (isset($pds_details) > 0 ? $pds_details[12] : $arrData[0]['fathernameExtension']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<hr>
		<div class="row" id="msurname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label"> <b>NAME OF MOTHER :</b> <br> Surname :</label>
					<input type="text" class="form-control" name="strMSurname" maxlength="80" 
							value="<?=isset($arrData[0]['motherSurname']) ? (isset($pds_details) > 0 ? $pds_details[13] : $arrData[0]['motherSurname']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>         
		<div class="row" id="mfirstname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Firstname :</label>
					<input type="text" class="form-control" name="strMFirstname" maxlength="80" 
							value="<?=isset($arrData[0]['motherFirstname']) ? (isset($pds_details) > 0 ? $pds_details[14] : $arrData[0]['motherFirstname']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>       
		<div class="row" id="mmidname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Middle name :</label>
					<input type="text" class="form-control" name="strMMidname" maxlength="80" 
							value="<?=isset($arrData[0]['motherMiddlename']) ? (isset($pds_details) > 0 ? $pds_details[15] : $arrData[0]['motherMiddlename']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row" id="paddress_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Parents Address :</label>
					<input type="text" class="form-control" name="strPaddress" 
							value="<?=isset($arrData[0]['parentAddress']) ? (isset($pds_details) > 0 ? $pds_details[16] : $arrData[0]['parentAddress']) : ''?>" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row"><div class="col-sm-8"><hr></div></div>
		<div class="row">
		    <div class="col-sm-8">
		        <button type="submit" class="btn btn-success" id="btn-request-family">
		            <i class="icon-check"></i>
		            <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
		        <a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    </div>
		</div>
	<?=form_close()?>
</div>