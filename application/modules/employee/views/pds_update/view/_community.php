<!-- Current Profile -->
<div class="col-md-6">
	<label class="bold">CURRENT PROFILE</label><hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Tax Certificate Number :</label>
			<label class="form-control"><?=$arrData[0]['comTaxNumber']?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Issued At :</label>
			<label class="form-control"><?=$arrData[0]['issuedAt']?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Issued On :</label>
			<label class="form-control"><?=$arrData[0]['issuedOn']?></label>
		</div>
	</div>
</div>

<!-- Replace Profile -->
<div class="col-md-6">
	<label class="bold">CHANGE REQUEST PROFILE</label><hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Tax Certificate Number :</label>
			<label class="form-control"><?=$pds_details[1]?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Issued At :</label>
			<label class="form-control"><?=$pds_details[2]?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Issued On :</label>
			<label class="form-control"><?=$pds_details[3]?></label>
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
		        <a type="submit" class="btn btn-success" href="<?=base_url('hr/request/certify_pds?status=tax&req_id='.$_GET['req_id'].'&type=tax')?>">
		            <i class="icon-check"></i> Certify</a>
		        <a href="<?=base_url('hr/request?request=pds')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    <?php endif; ?>
	    </div>
	</div>
</div>