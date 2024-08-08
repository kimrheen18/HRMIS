<!-- Current Profile -->
<div class="col-md-6" <?=isset($pds_details[7]) ? ($pds_details[7] == '' ? 'hidden' : '') : ''?>>
	<label class="bold">CURRENT PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Exam Description : </label>
			<?php
				$exam_desc = '';
				foreach($emp_exam['arrExamination_CMB'] as $exam):
					if($exam['examCode'] == $emp_exam['examCode']):
						$exam_desc = $exam['examDesc'];
						break;
					endif;
				endforeach; ?>
			<label class="form-control"><?=$exam_desc?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<label class="control-label"><br> Rating (%) : </label>
			<label class="form-control"><?=$emp_exam['examRating']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<label class="control-label"><br> Date of Exam/Conferment : </label>
			<label class="form-control"><?=$emp_exam['examDate']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Place of Exam/Conferment : </label>
			<label class="form-control"><?=$emp_exam['examPlace']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> License No. (if applicable) : </label>
			<label class="form-control"><?=$emp_exam['licenseNumber']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<label class="control-label"><br> Date of Release : </label>
			<label class="form-control"><?=$emp_exam['dateRelease']?></label>
		</div>
	</div>
</div>

<!-- Replace Profile -->
<div class="col-md-6">
	<label class="bold">CHANGE REQUEST PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Exam Description : </label>
			<?php
				$exam_desc = '';
				foreach($emp_exam['arrExamination_CMB'] as $exam):
					if($exam['examCode'] == $pds_details[1]):
						$exam_desc = $exam['examDesc'];
						break;
					endif;
				endforeach; ?>
			<label class="form-control"><?=$exam_desc?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<label class="control-label"><br> Rating (%) : </label>
			<label class="form-control"><?=$pds_details[2]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<label class="control-label"><br> Date of Exam/Conferment : </label>
			<label class="form-control"><?=$pds_details[3]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Place of Exam/Conferment : </label>
			<label class="form-control"><?=$pds_details[4]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> License No. (if applicable) : </label>
			<label class="form-control"><?=$pds_details[5]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<label class="control-label"><br> Date of Release : </label>
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
		        <a type="submit" class="btn btn-success" href="<?=base_url('hr/request/certify_pds?status=exam&req_id='.$_GET['req_id'].'&type=exam')?>">
		            <i class="icon-check"></i> Certify</a>
		        <a href="<?=base_url('hr/request?request=pds')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    <?php endif; ?>
	    </div>
	</div>
</div>