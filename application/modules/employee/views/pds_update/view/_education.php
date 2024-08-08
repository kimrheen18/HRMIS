<!-- Current Profile -->
<div class="col-md-6" <?=isset($pds_details[12]) ? ($pds_details[12] == '' ? 'hidden' : '') : ''?>>
	<label class="bold">CURRENT PROFILE</label><hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label"><br> Level Description : </label>
			<?php
				foreach($emp_educ['arrEduc_CMB'] as $educ):
					if(in_array($emp_educ['levelCode'],array($educ['levelCode'],$educ['levelId']))):
						echo '<label class="form-control">'.$educ['levelDesc'].'</label>';
					endif;
				endforeach; ?>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">School Name : <span class="required"> * </span></label>
			<label class="form-control"><?=$emp_educ['schoolName']?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Basic Education/Degree/Course : </label>
			<?php
				foreach($emp_educ['arrCourse'] as $course):
					if(in_array($emp_educ['course'],array($course['courseId'],$course['courseDesc'],$course['courseCode']))):
						echo '<label class="form-control">'.$course['courseDesc'].'</label>';
					endif;
				endforeach; ?>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-6">
			<label class="control-label">From Year: </label>
			<label class="form-control"><?=$emp_educ['schoolFromDate']?></label>
		</div>
		<div class="col-sm-6">
			<label class="control-label">To: </label>
			<label class="form-control"><?=$emp_educ['schoolToDate']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Units Earned : </label>
			<label class="form-control"><?=$emp_educ['units']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Scholarship : </label>
			<?php
				if($emp_educ['ScholarshipCode']==''):
					echo '<label class="form-control">-</label>';
				else:
					foreach($emp_educ['arrScholarship'] as $sch):
						if($emp_educ['ScholarshipCode'] == $sch['id']):
							echo '<label class="form-control">'.$sch['description'].'</label>';
						endif;
					endforeach;
				endif;?>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Honors : </label>
			<label class="form-control" style="height: auto;"><?=$emp_educ['honors']==''?'-':$emp_educ['honors']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Licensed : </label>
			<label class="form-control"><?=$emp_educ['licensed']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Graduated : </label>
			<label class="form-control"><?=$emp_educ['graduated']?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Year Graduated : </label>
			<label class="form-control"><?=$emp_educ['yearGraduated']?></label>
		</div>
	</div>
</div>

<!-- Replace Profile -->
<div class="col-md-6">
	<label class="bold">CHANGE REQUEST PROFILE</label><hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label"><br> Level Description : </label>
			<?php
				foreach($emp_educ['arrEduc_CMB'] as $educ):
					if(in_array($pds_details[1],array($educ['levelCode'],$educ['levelId']))):
						echo '<label class="form-control">'.$educ['levelDesc'].'</label>';
					endif;
				endforeach; ?>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">School Name : <span class="required"> * </span></label>
			<label class="form-control"><?=$pds_details[2]?></label>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Basic Education/Degree/Course : </label>
			<?php
				foreach($emp_educ['arrCourse'] as $course):
					if(in_array($pds_details[3],array($course['courseId'],$course['courseDesc'],$course['courseCode']))):
						echo '<label class="form-control">'.$course['courseDesc'].'</label>';
					endif;
				endforeach; ?>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-6">
			<label class="control-label">From Year: </label>
			<label class="form-control"><?=$pds_details[4]?></label>
		</div>
		<div class="col-sm-6">
			<label class="control-label">To: </label>
			<label class="form-control"><?=$pds_details[5]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Units Earned : </label>
			<label class="form-control"><?=$pds_details[6]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Scholarship : </label>
			<?php
				foreach($emp_educ['arrScholarship'] as $sch):
					if($pds_details[7] == $sch['id']):
						echo '<label class="form-control">'.$sch['description'].'</label>';
					endif;
				endforeach; ?>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Honors : </label>
			<label class="form-control" style="height: auto;"><?=$pds_details[8]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Licensed : </label>
			<label class="form-control"><?=$pds_details[9]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Graduated : </label>
			<label class="form-control"><?=$pds_details[10]?></label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-sm-12">
			<label class="control-label">Year Graduated : </label>
			<label class="form-control"><?=$pds_details[11]?></label>
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
		        <a type="submit" class="btn btn-success" id="btn-request-profile" href="<?=base_url('hr/request/certify_pds?status=educ&req_id='.$_GET['req_id'].'&type=profile')?>">
		            <i class="icon-check"></i> Certify</a>
		        <a href="<?=base_url('hr/request?request=pds')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    <?php endif; ?>
	    </div>
	</div>
</div>