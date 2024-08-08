<div class="col-md-12">
	<br>
	<table class="table table-bordered table-striped" id="table-educ">
		<thead>
			<tr>
				<th style="text-align: center;vertical-align: middle;" nowrap>Level Code</th>
				<th style="text-align: center;vertical-align: middle;"> Name of School</th>
				<th style="text-align: center;vertical-align: middle;"> Basic Educ./ Degree/ Course</th>
				<th style="text-align: center;vertical-align: middle;"> Period of Attendance [From/To]</th>
				<th style="text-align: center;vertical-align: middle;"> Highest Level/ Units Earned</th>
				<th style="text-align: center;vertical-align: middle;"> Year Graduated</th>
				<th style="text-align: center;vertical-align: middle;"> Scholarship/ Honors Received</th>
				<th style="text-align: center;vertical-align: middle;"> Graduate</th>
				<th style="text-align: center;vertical-align: middle;"> Licensed</th>
				<th style="text-align: center;vertical-align: middle;"> Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($arrEduc as $row):?>
			<tr>
				<td align="center"> <?=$row['levelCode']?></td>
				<td> <?=$row['schoolName']?></td>
				<td> <?=$row['course']?></td>
				<td align="center"> <?=$row['schoolFromDate'].'-'.$row['schoolToDate']?></td>
				<td align="center"> <?=$row['units']?></td>
				<td align="center"> <?=$row['yearGraduated']?></td>
				<td> <?=$row['honors']?></td>
				<td align="center"> <?=$row['graduated']?></td>
				<td> <?=$row['licensed']?></td>
				<td>
					<?php 
						$row_show = 1;
						if(isset($pds_details)):
							$row_show = $pds_details[11] == $row['SchoolIndex'] ? 0 : 1;
						else:
							if(count($emp_educ) > 0):
								$row_show = $emp_educ['SchoolIndex'] == $row['SchoolIndex'] ? 0 : 1;
							else:
							endif;
						endif;
						if($row_show):?>
							<a class="btn green btn-sm" href="<?=base_url('employee/pds_update/add?educ_id='.$row['SchoolIndex'])?>"><i class="fa fa-edit"></i> Edit </a>
						<?php endif; ?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<br>
</div>

<div class="col-md-12">
	<?=form_open(base_url('employee/pds_update/submitEduc?action='.$action), array('method' => 'post', 'id' => 'frmEduc'))?>
		<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_EDUC?>">
		<input class="hidden" name="txteducid" value="<?=isset($_GET['educ_id']) ? $_GET['educ_id'] : (isset($pds_details) ? $pds_details[12] : '')?>">
		<div class="row" id="educlevel_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">Level Description :</label>
					<select type="text" class="form-control bs-select" name="strLevelDesc">
						<option value=""> -- SELECT LEVEL -- </option>
						<?php foreach($arrEduc_CMB as $educ):
								if(isset($pds_details)):
									$selected = $pds_details[1] == $educ['levelId'] ? 'selected' : '';
								else:
									$selected = count($emp_educ) > 0 ? ($emp_educ['levelCode']==$educ['levelId'] || $emp_educ['levelCode']==$educ['levelCode']) ? 'selected' : '' : '';
								endif;
								echo '<option value="'.$educ['levelId'].'" '.$selected.'>'.$educ['levelDesc'].'</option>';
							  endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row" id="schoolname_textbox">
			<div class="col-sm-8">
				<div class="form-group">
					<label class="control-label">School Name :  <span class="required"> * </span></label>
					<div class="input-icon right">
						<input type="text" class="form-control" name="strSchName" id="strSchName" 
								value="<?=isset($pds_details) ? $pds_details[2] : (count($emp_educ) > 0 ? $emp_educ['schoolName'] : '')?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div> 
	        <div class="row" id="degree_textbox">
	            <div class="col-sm-8">
	                <div class="form-group">
	                    <label class="control-label">Basic Education/Degree/Course :  </label>
	                    <select type="text" class="form-control select2" name="strDegree">
	                            <option value="0"> -- SELECT BASIC EDUCATION -- </option>
	                            <?php foreach($arrCourse as $course):
	                            		if(isset($pds_details)):
	                            			$selected = $pds_details[3] == $course['courseId'] ? 'selected' : '';
	                            		else:
	                            			$selected = count($emp_educ) > 0 ? $emp_educ['courseCode']==$course['courseId'] || $emp_educ['courseCode']==$course['courseCode']? 'selected' : '' : '';
	                            		endif;
	                            		echo '<option value="'.$course['courseId'].'" '.$selected.'>'.$course['courseDesc'].'</option>';
	                            	  endforeach; ?>
	                    </select>
	                </div>
	            </div>
	        </div> 
	        <div class="row" id="frmyr_textbox">
	            <div class="col-md-4">
	                <div class="form-group">
	                    <label class="control-label">From Year :</label>
	                    <select name="dtmFrmYr" id="dtmFrmYr" class="form-control bs-select">
	                   		<?php foreach (range(date('Y'), ERLIEST_YEAR) as $yr):
	                   				if(isset($pds_details)):
	                   					$selected = $pds_details[4] == $yr ? 'selected' : '';
	                   				else:
	                   					$selected = count($emp_educ) > 0 ? $emp_educ['schoolFromDate'] == $yr? 'selected' : '' : '';
	                   				endif;
	                            	echo '<option value="'.$yr.'" '.$selected.'>'.$yr.'</option>';
	                              endforeach;?>
	                    </select>
	                </div>
	            </div>
	            <div class="col-md-4">
	                <div class="form-group">
	                    <label class="control-label">To :</label>
	                    <select name="dtmTo" id="dtmTo" class="form-control bs-select">
	                    	<?php foreach (range(date('Y'), ERLIEST_YEAR) as $yr):
	                    			if(isset($pds_details)):
	                    				$selected = $pds_details[5] == $yr ? 'selected' : '';
	                    			else:
	                    				$selected = count($emp_educ) > 0 ? $emp_educ['schoolToDate'] == $yr? 'selected' : '' : '';
	                    			endif;
	                            	echo '<option value="'.$yr.'" '.$selected.'>'.$yr.'</option>';
	                              endforeach;?>
	                    </select>
	                </div>
	            </div>
	        </div>           
	        <div class="row" id="units_textbox">
	            <div class="col-sm-8">
	                <div class="form-group">
	                    <label class="control-label">Units Earned :  <span class="required"> * </span></label>
	                    <div class="input-icon right">
	                    	<input type="text" class="form-control" name="intUnits" id="intUnits"
	                    			value="<?=isset($pds_details) ? $pds_details[6] : (count($emp_educ) > 0 ? $emp_educ['units'] : '')?>" autocomplete="off"><label>* (write - if not-applicable)</label>
	                    </div>
	                </div>
	            </div>
	        </div>       
	        <div class="row" id="scholarship_textbox">
	            <div class="col-sm-8">
	                <div class="form-group">
	                    <label class="control-label">Scholarship :  </label>
	                    <select type="text" class="form-control bs-select" name="strScholarship">
	                    	<option value="">-- SELECT SCHOLARSHIP --</option>
	                            <?php foreach($arrScholarship as $scholar):
	                            		if(isset($pds_details)):
	                            			$selected = $pds_details[7] == $scholar['id'] ? 'selected' : '';
	                            		else:
	                            			$selected = count($emp_educ) > 0 ? $emp_educ['ScholarshipCode'] == $scholar['id']? 'selected' : '' : '';
	                            		endif;
	                            		echo '<option value="'.$scholar['id'].'" '.$selected.'>'.$scholar['description'].'</option>';
	                            	  endforeach; ?>
	                    </select>
	                </div>
	            </div>
	        </div>    
	        <div class="row" id="honors_textbox">
	            <div class="col-sm-8">
	                <div class="form-group">
	                	<label class="control-label">Honors :  </label>
	                	<input type="text" class="form-control" name="strHonors"
	                			value="<?=isset($pds_details) ? $pds_details[8] : (count($emp_educ) > 0 ? $emp_educ['honors'] : '')?>" autocomplete="off">
	                </div>
	            </div>
	        </div>
	        <div class="row" id="licensed_textbox">
	        	<div class="col-sm-12">
	        	    <div class="form-group">
	        	        <label>Licensed: </label>
	        	        <div class="radio-list">
	        	            <label class="radio-inline">
	        	                <input type="radio" name="strLicensed" value="Y"
	        	                	<?=isset($pds_details) ? ($pds_details[9] == 'Y' ? 'checked' : '') : (count($emp_educ) > 0 ? $emp_educ['licensed']=='Y' ? 'checked' : '' : '')?>> Yes </label>
	        	            <label class="radio-inline">
	        	                <input type="radio" name="strLicensed" value="N"
	        	                	<?=isset($pds_details) ? ($pds_details[9] == 'N' ? 'checked' : '') : (count($emp_educ) > 0 ? $emp_educ['licensed']!='Y' ? 'checked' : '' : 'checked')?>> No </label>
	        	        </div>
	        	    </div>
	        	</div>
	        </div>
	        <div class="row" id="graduated_textbox">
	        	<div class="col-sm-12">
	        	    <div class="form-group">
	        	        <label>Graudated: </label>
	        	        <div class="radio-list">
	        	            <label class="radio-inline">
	        	                <input type="radio" name="strGraduated" value="Y"
	        	                	<?=isset($pds_details) ? ($pds_details[10] == 'Y' ? 'checked' : '') : (count($emp_educ) > 0 ? $emp_educ['graduated']=='Y' ? 'checked' : '' : 'checked')?>> Yes </label>
	        	            <label class="radio-inline">
	        	                <input type="radio" name="strGraduated" value="N" 
	        	                	<?=isset($pds_details) ? ($pds_details[10] == 'N' ? 'checked' : '') : (count($emp_educ) > 0 ? $emp_educ['graduated']!='Y' ? 'checked' : '' : '')?>> No </label>
	        	        </div>
	        	    </div>
	        	</div>
	        </div>     
	        <div class="row" id="yrgraduated_textbox">
	            <div class="col-sm-8">
	                <div class="form-group">
	                   <label class="control-label">Year Graduated :   </label>
	                   <input type="number" class="form-control" name="strYrGraduated" maxlength="4" 
	                   			value="<?=isset($pds_details) ? $pds_details[11] : (count($emp_educ) > 0 ? $emp_educ['yearGraduated'] : '')?>" autocomplete="off">
	                </div>
	            </div>
	        </div>
	        <div class="row"><div class="col-sm-8"><hr></div></div>
	        <div class="row">
	            <div class="col-sm-8">
	                <button type="submit" class="btn btn-success" id="btn-request-educ">
	                    <i class="icon-check"></i>
	                    <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
	                <a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
	            </div>
	        </div>
	    <?=form_close()?>
	</div>
</div>