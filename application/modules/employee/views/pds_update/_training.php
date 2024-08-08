<div class="col-md-12">
	<br>
	<table class="table table-bordered table-striped" id="table-trainings">
		<thead>
			<tr>
				<th style="text-align: center;vertical-align: middle;" nowrap> Title of Learning & <br> Dev./Training Programs</th>
				<th style="text-align: center;vertical-align: middle;"> Inclusive Dates of Attendance [From-To]</th>
				<th style="text-align: center;vertical-align: middle;"> Number of Hours</th>
				<th style="text-align: center;vertical-align: middle;"> Type of Leadership</th>
				<th style="text-align: center;vertical-align: middle;"> Conducted/Sponsored By</th>
				<th style="text-align: center;vertical-align: middle;"> Training Venue</th>
				<th style="text-align: center;vertical-align: middle;"> Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($arrTraining as $row):?>
			<tr>
				<td align="center"> <?=$row['trainingTitle']?></td>
				<td align="center"> <?=$row['trainingStartDate']?></td>
				<td align="center"> <?=$row['trainingHours']?></td>
				<td align="center"> <?=$row['trainingTypeofLD']?></td>
				<td align="center"> <?=$row['trainingConductedBy']?></td>
				<td align="center"> <?=$row['trainingVenue']?></td>
				<td align="center">
					<?php 
						$row_show = 1;
						if(isset($pds_details)):
							$row_show = isset($pds_details[10]) ? $pds_details[10] == $row['TrainingIndex'] ? 0 : 1 : 1;
						else:
							if(count($emp_tra) > 0):
								$row_show = $emp_tra['TrainingIndex'] == $row['TrainingIndex'] ? 0 : 1;
							else:
							endif;
						endif;
						if($row_show):?>
							<a class="btn green btn-sm" href="<?=base_url('employee/pds_update/add?tra_id='.$row['TrainingIndex'])?>"><i class="fa fa-edit"></i> Edit </a>
						<?php endif; ?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<br>
</div>

<div class="col-md-12">
	<?=form_open('employee/pds_update/submitTraining?action='.$action, array('method' => 'post', 'id' => 'frmtraining'))?>
		<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_TRAIN?>">
		<input class="hidden" name="txttraid" value="<?=isset($_GET['tra_id']) ? $_GET['tra_id'] : (isset($pds_details) ? $pds_details[10] : '')?>">
		<div class="row" id="traintitle_textbox">
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Training Title : </label>
		        	<div class="input-icon right">
		        		<textarea class="form-control" name="strTrainTitle"><?=isset($pds_details) ? $pds_details[1] : (count($emp_tra) > 0 ? $emp_tra['trainingTitle'] : '')?></textarea>
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" id="startdate_textbox">
		    <div class="col-sm-4">
		        <div class="form-group">
		            <label class="control-label">Start Date : </label>
		            <div class="input-icon right">
		            	<input class="form-control date-picker" name="dtmStartDate" id="dtmStartDate" type="text"
		            			value="<?=isset($pds_details) ? $pds_details[2] : (count($emp_tra) > 0 ? $emp_tra['trainingStartDate'] : '')?>" data-date-format="yyyy-mm-dd" autocomplete="off">
		            </div>
		        </div>
		    </div>
		</div>
		<div class="row" id="enddate_textbox">
		    <div class="col-sm-4">
		        <div class="form-group">
		            <label class="control-label">End Date : </label>
		            <div class="input-icon right">
		            	<input class="form-control date-picker" name="dtmEndDate" id="dtmEndDate" type="text" data-date-format="yyyy-mm-dd"
		            			value="<?=isset($pds_details) ? $pds_details[3] : (count($emp_tra) > 0 ? $emp_tra['trainingEndDate'] : '')?>" autocomplete="off">
		            </div>
		        </div>
		    </div>
		</div>
		<div class="row" id="number_textbox">
		    <div class="col-sm-3">
		        <div class="form-group">
		            <label class="control-label">Number of Hours : </label>
		            <div class="input-icon right">
		            	<input type="number" class="form-control" name="dtmHours"
		            			value="<?=isset($pds_details) ? $pds_details[4] : (count($emp_tra) > 0 ? $emp_tra['trainingHours'] : '')?>"  autocomplete="off">
		            </div>
		         </div>
		    </div>
		</div>	
		<div class="row">
		    <div class="col-sm-8">
		        <div class="form-group">
		            <label class="control-label">Type of Leadership : </label>
		            <div class="input-icon right">
		            	<select class="form-control bs-select form-required" name="strTypeLD">
		            		<option value="">-- SELECT TYPE OF LEADERSHIP --</option>
		            		<?php 
		            			foreach(array('Managerial','Supervisory','Technical') as $ld):
		            				if(isset($pds_details)):
		            					$selected = $pds_details[5] == $ld ? 'selected' : '';
		            				else:
		            					$selected = count($emp_tra)>0 ? $emp_tra['trainingTypeofLD'] == $ld ? 'selected' : '' : '';
		            				endif;
		            				
		            				echo '<option value="'.$ld.'" '.$selected.'>'.$ld.'</option>';
		            			endforeach;
		            		 ?>
		            	</select>
		            </div>
		        </div>
		    </div>
		</div>    
		<div class="row" id="conduct_textbox">
		    <div class="col-sm-8">
		        <div class="form-group">
		            <label class="control-label">Conducted By : </label>
		            <div class="input-icon right">
		            	<input type="text" class="form-control" name="strConduct"
		            			value="<?=isset($pds_details) ? $pds_details[6] : (count($emp_tra) > 0 ? $emp_tra['trainingConductedBy'] : '')?>" autocomplete="off">
		            </div>
		        </div>
		    </div>
		</div>      
		<div class="row" id="venue_textbox">
		    <div class="col-sm-8">
		        <div class="form-group">
		            <label class="control-label">Venue : </label>
		            <div class="input-icon right">
		            	<input type="text" class="form-control" name="strVenue" 
		            			value="<?=isset($pds_details) ? $pds_details[7] : (count($emp_tra) > 0 ? $emp_tra['trainingVenue']:'')?>" autocomplete="off">
		            </div>
		        </div>
		    </div>
		</div> 
		<div class="row" id="cost_textbox">
		    <div class="col-sm-3">
		        <div class="form-group">
		            <label class="control-label">Cost : </label>
		            <div class="input-icon right">
		            	<input type="text" class="form-control" name="intCost" 
		            			value="<?=isset($pds_details) ? $pds_details[8] : (count($emp_tra) > 0 ? $emp_tra['trainingCost']:'')?>" autocomplete="off">
		            </div>
		        </div>
		    </div>
		</div>    
		<div class="row" id="contract_textbox">
		    <div class="col-sm-4">
		        <div class="form-group">
		            <label class="control-label">Contract Dates : </label>
		            <div class="input-icon right">
		            	<input class="form-control form-control-inline input-medium date-picker" name="dtmContract" id="dtmContract" type="text"
		            			value="<?=isset($pds_details) ? $pds_details[9] : (count($emp_tra) > 0 ? $emp_tra['trainingContractDate']:'')?>" data-date-format="yyyy-mm-dd" autocomplete="off">
		            </div>
		        </div>
		    </div>
		</div>
		<div class="row"><div class="col-sm-8"><hr></div></div>
		<div class="row">
		    <div class="col-sm-8">
		        <button type="submit" class="btn btn-success" id="btn-request-training">
		            <i class="icon-check"></i>
		            <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
		        <a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    </div>
		</div>
	<?=form_close()?>
</div>
