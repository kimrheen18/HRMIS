<!-- Current Profile -->
<div class="col-md-6" <?=isset($pds_details[7]) ? ($pds_details[7] == '' ? 'hidden' : '') : ''?>>
	<label class="bold">CURRENT PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Name of Organization : </label>
			<label class="form-control"><?=$emp_vol['vwName']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Address : </label>
			<label class="form-control"><?=$emp_vol['vwAddress']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Inclusive Date From : </label>
			<label class="form-control"><?=$emp_vol['vwDateFrom']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Inclusive Date To : </label>
			<label class="form-control"><?=$emp_vol['vwDateTo']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Number of Hours : </label>
			<label class="form-control"><?=$emp_vol['vwHours']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Position / Nature of Work : </label>
			<label class="form-control"><?=$emp_vol['vwPosition']?></label>
		</div>
	</div>
</div>

<!-- Replace Profile -->
<div class="col-md-6">
	<label class="bold">CHANGE REQUEST PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Name of Organization : </label>
			<label class="form-control"><?=$pds_details[1]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Address : </label>
			<label class="form-control"><?=$pds_details[2]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Inclusive Date From : </label>
			<label class="form-control"><?=$pds_details[3]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Inclusive Date To : </label>
			<label class="form-control"><?=$pds_details[4]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Number of Hours : </label>
			<label class="form-control"><?=$pds_details[5]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Position / Nature of Work : </label>
			<label class="form-control"><?=$pds_details[6]?></label>
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
		        <a type="submit" class="btn btn-success" href="<?=base_url('hr/request/certify_pds?status=vol&req_id='.$_GET['req_id'].'&type=vol')?>">
		            <i class="icon-check"></i> Certify</a>
		        <a href="<?=base_url('hr/request?request=pds')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    <?php endif; ?>
	    </div>
	</div>
</div>