<!-- Current Profile -->
<div class="col-md-6" <?=isset($pds_details[15]) ? ($pds_details[15] == '' ? 'hidden' : '') : ''?>>
	<label class="bold">CURRENT PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Inclusive Date From : </label>
			<label class="form-control"><?=$emp_wxp['serviceFromDate']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Inclusive Date To : </label>
			<label class="form-control"><?=$emp_wxp['serviceToDate']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Position Title : </label>
			<label class="form-control"><?=$emp_wxp['positionDesc']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Department/Agency/Office : </label>
			<label class="form-control"><?=$emp_wxp['stationAgency']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Salary : </label>
			<label class="form-control"><?=$emp_wxp['salary']?></label>
			<label class="form-control"><?=$emp_wxp['salaryPer']?></label>
			<label class="form-control"><?=$emp_wxp['currency']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Salary Grade & Step Incremet (Format "00-0") : </label>
			<label class="form-control"><?=$emp_wxp['salaryGrade']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Status of Appointment : </label>
			<?php 
				$appt_desc = '';
				foreach($emp_wxp['arrAppointment'] as $appoint):
					if($emp_wxp['appointmentCode'] == $appoint['appointmentCode']):
						$appt_desc = $appoint['appointmentDesc'];
						break;
					endif;
				endforeach; ?>
			<label class="form-control"><?=$appt_desc?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Government Service : </label>
			<label class="form-control"><?=$emp_wxp['governService']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Branch : </label>
			<label class="form-control"><?=$emp_wxp['branch']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Separation Cause : </label>
			<label class="form-control"><?=$emp_wxp['separationCause']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Separation Date : </label>
			<label class="form-control"><?=$emp_wxp['separationDate']?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> L/V ABS W/O PAY : </label>
			<label class="form-control"><?=$emp_wxp['lwop']?></label>
		</div>
	</div>
</div>

<!-- Replace Profile -->
<div class="col-md-6">
	<label class="bold">CHANGE REQUEST PROFILE</label><hr>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Inclusive Date From : </label>
			<label class="form-control"><?=$pds_details[1]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Inclusive Date To : </label>
			<label class="form-control"><?=$pds_details[2]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Position Title : </label>
			<label class="form-control"><?=$pds_details[3]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Department/Agency/Office : </label>
			<label class="form-control"><?=$pds_details[4]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Salary : </label>
			<label class="form-control"><?=$pds_details[5]?></label>
			<label class="form-control"><?=$pds_details[6]?></label>
			<label class="form-control"><?=$pds_details[7]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Salary Grade & Step Incremet (Format "00-0") : </label>
			<label class="form-control"><?=$pds_details[8]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Status of Appointment : </label>
			<?php 
				$appt_desc = '';
				foreach($emp_wxp['arrAppointment'] as $appoint):
					if($pds_details[9] == $appoint['appointmentCode']):
						$appt_desc = $appoint['appointmentDesc'];
						break;
					endif;
				endforeach; ?>
			<label class="form-control"><?=$appt_desc?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Government Service : </label>
			<label class="form-control"><?=$pds_details[10]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Branch : </label>
			<label class="form-control"><?=$pds_details[11]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Separation Cause : </label>
			<label class="form-control"><?=$pds_details[12]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> Separation Date : </label>
			<label class="form-control"><?=$pds_details[13]?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<label class="control-label"><br> L/V ABS W/O PAY : </label>
			<label class="form-control"><?=$pds_details[14]?></label>
		</div>
	</div>
</div>

<div class="col-md-9">
	<div class="row"><div class="col-sm-8"><hr></div></div>
	<div class="row">
	    <div class="col-sm-8">
	        <a type="submit" class="btn btn-success" href="<?=base_url('hr/request/certify_pds?status=wxp&req_id='.$_GET['req_id'].'&type=wxp')?>">
	            <i class="icon-check"></i> Certify</a>
	        <a href="<?=base_url('hr/request?request=pds')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
	    </div>
	</div>
</div>