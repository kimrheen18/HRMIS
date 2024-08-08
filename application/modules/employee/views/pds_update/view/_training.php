<!-- Current Profile -->
<div class="col-md-6" <?=isset($pds_details[10]) ? ($pds_details[10] == '' ? 'hidden' : '') : ''?>>
	<label class="bold">CURRENT PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Training Title : </label>
			<label class="form-control"><?=$emp_tra['trainingTitle']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Start Date : </label>
			<label class="form-control"><?=$emp_tra['trainingStartDate']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> End Date : </label>
			<label class="form-control"><?=$emp_tra['trainingEndDate']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Number of Hourse : </label>
			<label class="form-control"><?=$emp_tra['trainingHours']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Type of Leadership : </label>
			<label class="form-control"><?=$emp_tra['trainingTypeofLD']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Conducted By : </label>
			<label class="form-control"><?=$emp_tra['trainingConductedBy']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Venue : </label>
			<label class="form-control"><?=$emp_tra['trainingVenue']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Cost : </label>
			<label class="form-control"><?=$emp_tra['trainingCost']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Contract Date : </label>
			<label class="form-control"><?=$emp_tra['trainingContractDate']?></label>
		</div>
	</div>
</div>

<!-- Replace Profile -->
<div class="col-md-6">
	<label class="bold">CHANGE REQUEST PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Training Title : </label>
			<label class="form-control"><?=$pds_details[1]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Start Date : </label>
			<label class="form-control"><?=$pds_details[2]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> End Date : </label>
			<label class="form-control"><?=$pds_details[3]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Number of Hourse : </label>
			<label class="form-control"><?=$pds_details[4]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Type of Leadership : </label>
			<label class="form-control"><?=$pds_details[5]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Conducted By : </label>
			<label class="form-control"><?=$pds_details[6]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Venue : </label>
			<label class="form-control"><?=$pds_details[7]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Cost : </label>
			<label class="form-control"><?=$pds_details[8]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Contract Date : </label>
			<label class="form-control"><?=$pds_details[9]?></label>
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
		        <a type="submit" class="btn btn-success" href="<?=base_url('hr/request/certify_pds?status=training&req_id='.$_GET['req_id'].'&type=training')?>">
		            <i class="icon-check"></i> Certify</a>
		        <a href="<?=base_url('hr/request?request=pds')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    <?php endif; ?>
	    </div>
	</div>
</div>