<!-- Current Profile -->
<div class="col-md-6" <?=isset($pds_details[3]) ? ($pds_details[3] == '' ? 'hidden' : '') : ''?>>
	<label class="bold">CURRENT PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Name of Children : </label>
			<label class="form-control"><?=!empty($emp_child) ? $emp_child['childName'] : ''?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Date of Birth : </label>
			<label class="form-control"><?=!empty($emp_child) ? $emp_child['childBirthDate'] : ''?></label>
		</div>
	</div>
</div>

<!-- Replace Profile -->
<div class="col-md-6">
	<label class="bold">CHANGE REQUEST PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Name of Children : </label>
			<label class="form-control"><?=$pds_details[1]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Date of Birth : </label>
			<label class="form-control"><?=$pds_details[2]?></label>
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
		        <a type="submit" class="btn btn-success" href="<?=base_url('hr/request/certify_pds?status=child&req_id='.$_GET['req_id'].'&type=child')?>">
		            <i class="icon-check"></i> Certify</a>
		        <a href="<?=base_url('hr/request?request=pds')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    <?php endif; ?>
	    </div>
	</div>
</div>