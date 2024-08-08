<?php 
	$show_xp = 1;
	if(isset($pds_details) || isset($emp_wxp)):
		if(isset($pds_details)):
			if(end($pds_details) != PDS_WORKXP):
				$show_xp = 0;
			endif;
		else:
			if(isset($emp_wxp)):
				$show_xp = 0;
			endif;
		endif;
		
	endif;
 ?>
<div class="col-md-12">
	<br>
	<table class="table table-bordered table-striped" id="table-workxp">
		<thead>
			<tr>
				<th style="text-align: center;vertical-align: middle;" colspan="9" class="active">WORK EXPERIENCE (Include private employment)</th>
			</tr>
			<tr>
				<th style="vertical-align: middle;" colspan="2"> Inclusive Dates</th>
				<th style="vertical-align: middle;" rowspan="2"> Position Title</th>
				<th style="vertical-align: middle;" rowspan="2"> Department / Agency / Office</th>
				<th style="vertical-align: middle;" rowspan="2"> Monthly</th>
				<th style="vertical-align: middle;" rowspan="2"> Salary/Job <br>Pay Grade</th>
				<th style="vertical-align: middle;" rowspan="2"> Status of Appointment</th>
				<th style="vertical-align: middle;" rowspan="2"> Gov. Service <br>(Yes/No)</th>
				<th style="text-align: center;vertical-align: middle;" rowspan="2"> Action</th>
			</tr>
			<tr>
				<th style="vertical-align: middle;"> From</th>
				<th style="vertical-align: middle;"> To</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($arrExperience as $row):?>
			<tr>
				<td align="center" nowrap> <?=$row['serviceFromDate']?></td>
				<td align="center" nowrap> <?=$row['serviceToDate']?></td>
				<td> <?=$row['positionDesc']?></td>
				<td> <?=$row['stationAgency']?></td>
				<td align="center" nowrap> <?=$row['salary']?></td>
				<td align="center" nowrap> <?=$row['salaryGrade']?></td>
				<td align="center" nowrap> <?=$row['appointmentCode']?></td>
				<td align="center" nowrap> <?=$row['governService']?></td>
				<td align="center">
					<?php 
						$row_show = 1;
						if(isset($pds_details)):
							$row_show = isset($pds_details[16]) ? $pds_details[16] == $row['serviceRecID'] ? 0 : 1 : 1;
						else:
							if(count($emp_wxp) > 0):
								$row_show = $emp_wxp['serviceRecID'] == $row['serviceRecID'] ? 0 : 1;
							else:
							endif;
						endif;
						if($row_show):?>
							<a class="btn green btn-sm" href="<?=base_url('employee/pds_update/add?wxp_id='.$row['serviceRecID'])?>"><i class="fa fa-edit"></i> Edit </a>
						<?php endif; ?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<br>
</div>

<div class="col-md-12">
	<?=form_open('employee/pds_update/submitWorkExp?action='.$action, array('method' => 'post', 'id' => 'frmworkxp'))?>
	<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_WORKXP?>">
		<input class="hidden" name="txtwxpid" value="<?=isset($_GET['wxp_id']) ? $_GET['wxp_id'] : ''?>">
		<div class="row">
		    <div class="col-sm-3">
		        <div class="form-group">
		        	<label class="control-label">Inclusive Date From : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control date-picker" name="dtmExpDateFrom" 
		        				value="<?=isset($pds_details) ? $pds_details[1] : (count($emp_wxp)>0?$emp_wxp['serviceFromDate']:'')?>" data-date-format="yyyy-mm-dd" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-3">
		        <div class="form-group">
		        	<label class="control-label">Inclusive Date To : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control date-picker" name="dtmExpDateTo" 
		        				value="<?=isset($pds_details) ? $pds_details[2] : (count($emp_wxp)>0?$emp_wxp['serviceToDate']:'')?>" data-date-format="yyyy-mm-dd" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		    <div class="col-sm-3">
		        <div class="form-group">
		        	<label class="control-label">&nbsp;</label>
		        	<div class="input-icon">
		        		<label><input type="checkbox" name="chkpresent"
		        			<?=isset($pds_details) ? ($pds_details[3]=='Present' ? 'checked' : '') : (count($emp_wxp)>0? ($emp_wxp['serviceToDate']=='Present' ? 'checked' : '') :'')?>> Present </label>
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Position Title : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strPosTitle" 
		        				value="<?=isset($pds_details) ? $pds_details[4] : (count($emp_wxp)>0?$emp_wxp['positionDesc']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Department/Agency/Office : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strExpDept" 
		        				value="<?=isset($pds_details) ? $pds_details[5] : (count($emp_wxp)>0?$emp_wxp['stationAgency']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-4">
		        <div class="form-group">
		        	<label class="control-label">Salary : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strSalary" 
		        				value="<?=isset($pds_details) ? $pds_details[6] : (count($emp_wxp)>0?$emp_wxp['salary']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		    <div class="col-sm-2">
		        <div class="form-group">
		        	<label class="control-label">&nbsp;</label>
		        	<div class="input-icon">
		        		<select name="strExpPer" id="strExpPer" type="text" class="form-control bs-select" autocomplete="off">
		        			<option value="0">--</option>
							<?php 
								foreach(array('Hour','Day','Month','Quarter','Year') as $pos):
									if(isset($pds_details)):
										$selected = $pds_details[7] == $pos ? 'selected' : '';
									else:
										$selected = isset($emp_wxp) ? $emp_wxp['salaryPer'] == $pos ? 'selected' : '' : '';
									endif;

									echo '<option value="'.$pos.'" '.$selected.'>PER '.$pos.'</option>';
								endforeach;
							 ?>
						</select>
		        	</div>
		        </div>
		    </div>
		    <div class="col-sm-2">
		        <div class="form-group">
		        	<label class="control-label">Currency : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strCurrency" 
		        				value="<?=isset($pds_details) ? $pds_details[8] : (count($emp_wxp)>0?$emp_wxp['currency']:'')?>" autocomplete="off">
		        	</div>
		        	<span class="help-block small">(leave blank if PHP) /   (ex. USD for US dollars)</span>
		        </div>
		    </div>
		</div>
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>>
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Salary Grade & Step Incremet (Format "00-0") :  </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strExpSG" 
		        				value="<?=isset($pds_details) ? $pds_details[9] : (count($emp_wxp)>0?$emp_wxp['salaryGrade']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>>
		    <div class="col-sm-8">
		        <div class="form-group">
		            <label class="control-label">Status of Appointment :</label>
		            <select class="form-control select2" name="strAStatus">
		            	<option value="0">-- SELECT STATUS --</option>
		                    <?php 
								foreach($arrAppointment as $appoint):
									if(isset($pds_details)):
										$selected = $pds_details[10] == $appoint['appointmentCode'] ? 'selected' : '';
									else:
										$selected = isset($emp_wxp) ? $emp_wxp['appointmentCode'] == $appoint['appointmentCode'] ? 'selected' : '' : '';
									endif;
									
									echo '<option value="'.$appoint['appointmentCode'].'" '.$selected.'>'.$appoint['appointmentDesc'].'</option>';
								endforeach;
							 ?>
		            </select>
		        </div>
		    </div>
		</div>
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>>
			<div class="col-sm-12">
			   	<div class="form-group">
			       	<label>Government Service : </label>
			       	<div class="radio-list">
			        	  	<label class="radio-inline">
			        	      	<input type="radio" name="strGovn" value="Y" 
			        	      		<?=isset($pds_details) ? ($pds_details[11]=='Y' ? 'checked' : '') : (count($emp_wxp) > 0 ? $emp_wxp['governService']=='Yes' ? 'checked' : '' : '')?>> Yes </label>
			        	  	<label class="radio-inline">
			        	      	<input type="radio" name="strGovn" value="N" 
			        	      		<?=isset($pds_details) ? ($pds_details[11]=='N' ? 'checked' : '') : (count($emp_wxp) > 0 ? $emp_wxp['governService']!='Yes' ? 'checked' : '' : 'checked')?>> No </label>
			       	</div>
			   	</div>
			</div>
		</div>
		
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>>
		    <div class="col-sm-8">
		        <div class="form-group">
		            <label class="control-label">Branch :</label>
		            <select class="form-control bs-select" name="strBranch">
		            	<option value="0">-- SELECT BRANCH --</option>
		                    <?php 
								foreach(array('Government Corp','National','FGI') as $branch):
									if(isset($pds_details)):
										$selected = $pds_details[12] == $branch ? 'selected' : '';
									else:
										$selected = isset($emp_wxp) ? $emp_wxp['branch'] == $branch ? 'selected' : '' : '';
									endif;
									
									echo '<option value="'.$branch.'" '.$selected.'>'.$branch.'</option>';
								endforeach;
							 ?>
		            </select>
		        </div>
		    </div>
		</div>
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>>
		    <div class="col-sm-8">
		        <div class="form-group">
		            <label class="control-label">Separation Cause :</label>
		            <select class="form-control bs-select" name="strSepCause">
		            	<option value="">-- SELECT SEPARATION CAUSE --</option>
		                    <?php 
								foreach($arrSeparation as $separation):
									if(isset($pds_details)):
										$selected = $pds_details[12] == $separation['separationCause'] ? 'selected' : '';
									else:
										$selected = isset($emp_wxp) ? ($emp_wxp['separationCause'] == $separation['separationCause'] ? 'selected' : '') : '';
									endif;
									
									echo '<option value="'.$separation['separationCause'].'" '.$selected.'>'.$separation['separationCause'].'</option>';
								endforeach;
							 ?>
		            </select>
		        </div>
		    </div>
		</div>
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>>
		    <div class="col-sm-3">
		        <div class="form-group">
		        	<label class="control-label">Separation Date :</label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control date-picker" name="strSepDate" 
		        				value="<?=isset($pds_details) ? $pds_details[13] : (count($emp_wxp)>0?$emp_wxp['separationDate']:'')?>" data-date-format="yyyy-mm-dd" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>>
		    <div class="col-sm-3">
		        <div class="form-group">
		        	<label class="control-label">L/V ABS W/O PAY :</label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strLV" 
		        				value="<?=isset($pds_details) ? $pds_details[14] : (count($emp_wxp)>0?$emp_wxp['lwop']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>><div class="col-sm-8"><hr></div></div>
		<div class="row" <?=$action!='add' ? ($show_xp ? '' : 'hidden') : ''?>>
		    <div class="col-sm-8">
		        <button type="submit" class="btn btn-success" id="btn-request-ref">
		            <i class="icon-check"></i>
		            <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
		        <a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    </div>
		</div>
	<?=form_close()?>
</div>
