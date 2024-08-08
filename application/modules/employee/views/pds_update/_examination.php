<div class="col-md-12">
	<br>
	<table class="table table-bordered table-striped" id="table-examinations">
		<thead>
			<tr>
				<th align="center">Exam Description</th>
                <th align="center">Rating</th>
                <th align="center">Date of Examination/ Conferment</th>
                <th align="center">Place of Examination/ Conferment</th>
                <th align="center">License Number</th>
                <th align="center">Date of Validity</th>
                <th align="center">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($arrExamination  as $row):?>
			<tr>
				<td align="center"> <?=$row['examCode']?> </td>
                <td align="center"> <?=$row['examRating']?> </td>
                <td align="center"> <?=$row['examDate']?> </td>
                <td align="center"> <?=$row['examPlace']?> </td>
                <td align="center"> <?=$row['licenseNumber']?> </td>
                <td align="center"> <?=$row['dateRelease']?> </td>
				<td align="center">
					<?php 
						$row_show = 1;
						if(isset($pds_details)):
							$row_show = $pds_details[7] == $row['ExamIndex'] ? 0 : 1;
						else:
							if(count($emp_exam) > 0):
								$row_show = $emp_exam['ExamIndex'] == $row['ExamIndex'] ? 0 : 1;
							endif;
						endif;
						if($row_show):?>
							<a class="btn green btn-sm" href="<?=base_url('employee/pds_update/add?exam_id='.$row['ExamIndex'])?>"><i class="fa fa-edit"></i> Edit </a>
						<?php endif; ?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<br>
</div>

<div class="col-md-12">
	<?=form_open('employee/pds_update/submitExam?action='.$action, array('method' => 'post', 'id' => 'frmexaminations'))?>
		<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_ELIGIBILITY?>">
		<input class="hidden" name="txtexamid" value="<?=isset($_GET['exam_id']) ? $_GET['exam_id'] : (isset($pds_details) ? $pds_details[7] : '')?>">
		<div class="row" id="examdesc_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Exam Description :  </label>
					<div class="input-icon right">
						<select type="text" class="form-control select2" name="strExamDesc">
							<option value="0">-- SELECT EXAM --</option>
							<?php foreach($arrExamination_CMB as $exam):
									if(isset($pds_details)):
										$selected = $pds_details[1] == $exam['examCode'] ? 'selected' : '';
									else:
										$selected = count($emp_exam)>0 ? $emp_exam['examCode'] == $exam['examCode'] ? 'selected' : '' : '';
									endif;
									
									echo '<option value="'.$exam['examCode'].'" '.$selected.'>'.$exam['examDesc'].'</option>';
								  endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="rating_textbox">
			<div class="col-sm-2">
				<div class="form-group">
					<label class="control-label">Rating (%):  </label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strrating"
								value="<?=isset($pds_details) ? $pds_details[2] : (count($emp_exam) > 0 ? $emp_exam['examRating']:'')?>"  autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
		<div class="row" id="examdate_textbox">
			<div class="col-sm-4">
				<div class="form-group">
					<label class="control-label">Date of Exam/Conferment :  </label>
					<div class="input-icon right">
						<input class="form-control date-picker" name="dtmExamDate" id="dtmExamDate" type="text"
								value="<?=isset($pds_details) ? $pds_details[3] : (count($emp_exam) > 0 ? $emp_exam['examDate']:'')?>" data-date-format="yyyy-mm-dd" autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
		<div class="row" id="examplace_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Place of Exam/Conferment :  </label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strPlaceExam"
								value="<?=isset($pds_details) ? $pds_details[4] : (count($emp_exam) > 0 ? $emp_exam['examPlace']:'')?>"  autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="licenseNo_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">License No. (if applicable) : </label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="intLicenseNo"
								value="<?=isset($pds_details) ? $pds_details[5] : (count($emp_exam) > 0 ? $emp_exam['licenseNumber']:'')?>"  autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="release_textbox">
			<div class="col-sm-4">
				<div class="form-group">
					<label class="control-label">Date of Release :  </label>
					<div class="input-icon right">
						<input class="form-control date-picker" name="dtmRelease" id="dtmRelease" type="text" 
								value="<?=isset($pds_details) ? $pds_details[6] : (count($emp_exam) > 0 ? $emp_exam['dateRelease']:'')?>" data-date-format="yyyy-mm-dd"  autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
		<div class="row"><div class="col-sm-8"><hr></div></div>
		<div class="row">
		    <div class="col-sm-8">
		        <button type="submit" class="btn btn-success" id="btn-request-exam">
		            <i class="icon-check"></i>
		            <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
		        <a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    </div>
		</div>
	<?=form_close()?>
</div>
