<!-- Current Profile -->
<div class="col-md-6">
	<label class="bold">CURRENT PROFILE</label><hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label"><b>NAME OF SPOUSE :</b><br> Surname : <span class="required"> * </span></label>
			<label class="form-control"><?=$pds_details[1]?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Firstname : <span class="required"> * </span></label>
			<label class="form-control"><?=$pds_details[2]?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Middle Name : <span class="required"> * </span></label>
			<label class="form-control"><?=$pds_details[3]?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Name Extension: </label>
			<label class="form-control"><?=$pds_details[4]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Occupation : </label>
			<label class="form-control"><?=$pds_details[5]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Employer/Business Name : </label>
			<label class="form-control"><?=$pds_details[6]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Business Address : </label>
			<label class="form-control" style="height: auto;"><?=$pds_details[7]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Telephone No. : </label>
			<label class="form-control"><?=$pds_details[8]?></label>
		</div>
	</div>
	<hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label"><b>NAME OF FATHER :</b><br> Surname : </label>
			<label class="form-control"><?=$pds_details[9]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Firstname : </label>
			<label class="form-control"><?=$pds_details[10]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Middle name : </label>
			<label class="form-control"><?=$pds_details[11]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Name Extension : </label>
			<label class="form-control"><?=$pds_details[12]?></label>
		</div>
	</div>
	<hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label"><b>NAME OF MOTHER :</b><br> Surname : </label>
			<label class="form-control"><?=$pds_details[13]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Firstname : </label>
			<label class="form-control"><?=$pds_details[14]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Middle name : </label>
			<label class="form-control"><?=$pds_details[15]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Parents Address : </label>
			<label class="form-control" style="height: auto;"><?=$pds_details[16]?></label>
		</div>
	</div>
</div>

<!-- Replace Profile -->
<div class="col-md-6">
	<label class="bold">CHANGE REQUEST PROFILE</label><hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label"><b>NAME OF SPOUSE :</b><br> Surname : <span class="required"> * </span></label>
			<label class="form-control"><?=$arrData[0]['spouseSurname']?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Firstname : <span class="required"> * </span></label>
			<label class="form-control"><?=$arrData[0]['spouseFirstname']?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Middle Name : <span class="required"> * </span></label>
			<label class="form-control"><?=$arrData[0]['spouseMiddlename']?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Name Extension: </label>
			<label class="form-control"><?=$arrData[0]['spousenameExtension']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Occupation : </label>
			<label class="form-control"><?=$arrData[0]['spouseWork']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Employer/Business Name : </label>
			<label class="form-control"><?=$arrData[0]['spouseBusName']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Business Address : </label>
			<label class="form-control" style="height: auto;"><?=$arrData[0]['spouseBusAddress']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Telephone No. : </label>
			<label class="form-control"><?=$arrData[0]['spouseTelephone']?></label>
		</div>
	</div>
	<hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label"><b>NAME OF FATHER :</b><br> Surname : </label>
			<label class="form-control"><?=$arrData[0]['fatherSurname']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Firstname : </label>
			<label class="form-control"><?=$arrData[0]['fatherFirstname']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Middle name : </label>
			<label class="form-control"><?=$arrData[0]['fatherMiddlename']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Name Extension : </label>
			<label class="form-control"><?=$arrData[0]['fathernameExtension']?></label>
		</div>
	</div>
	<hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label"><b>NAME OF MOTHER :</b><br> Surname : </label>
			<label class="form-control"><?=$arrData[0]['motherSurname']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Firstname : </label>
			<label class="form-control"><?=$arrData[0]['motherFirstname']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Middle name : </label>
			<label class="form-control"><?=$arrData[0]['motherMiddlename']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Parents Address : </label>
			<label class="form-control" style="height: auto;"><?=$arrData[0]['parentAddress']?></label>
		</div>
	</div>
</div>

<div class="col-md-9">
	<div class="row"><div class="col-sm-8"><hr></div></div>
	<div class="row">
	    <div class="col-sm-8">
	    	<?php if(check_module() == 'employee'): ?>
	    		<a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    <?php else: ?>
		    	<a type="submit" class="btn btn-success" id="btn-request-profile" href="<?=base_url('hr/request/certify_pds?status=family&req_id='.$_GET['req_id'].'&type=profile')?>">
		            <i class="icon-check"></i> Certify</a>
		        <a href="<?=base_url('hr/request?request=pds')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    <?php endif; ?>
	    </div>
	</div>
</div>
