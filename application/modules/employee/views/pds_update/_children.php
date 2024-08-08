<div class="col-md-10">
	<br>
	<table class="table table-bordered table-striped" id="table-children">
		<thead>
			<tr>
				<th style="vertical-align: middle;"> Name of Children</th>
				<th style="text-align: center;vertical-align: middle;"> Date of Birth</th>
				<th style="text-align: center;vertical-align: middle;"> Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($arrChild as $row):?>
			<tr>
				<td> <?=$row['childName']?></td>
				<td align="center"> <?=$row['childBirthDate']?></td>
				<td align="center">
					<?php 
						$row_show = 1;
						if(isset($pds_details)):
							$row_show = isset($pds_details[3]) ? $pds_details[3] == $row['childCode'] ? 0 : 1 : 1;
						else:
							if(count($emp_child) > 0):
								$row_show = $emp_child['childCode'] == $row['childCode'] ? 0 : 1;
							else:
							endif;
						endif;
						if($row_show):?>
							<a class="btn green btn-sm" href="<?=base_url('employee/pds_update/add?child_id='.$row['childCode'])?>"><i class="fa fa-edit"></i> Edit </a>
						<?php endif; ?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<br>
</div>

<div class="col-md-12">
	<?=form_open('employee/pds_update/submitChild?action='.$action, array('method' => 'post', 'id' => 'frmchildren'))?>
		<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_CHILD?>">
		<input class="hidden" name="txtchildid" value="<?=isset($_GET['child_id']) ? $_GET['child_id'] : (isset($pds_details) ? $pds_details[3] : '')?>">
		<div class="row" id="traintitle_textbox">
		    <div class="col-sm-10">
		        <div class="form-group">
		        	<label class="control-label">Name of Children : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strChildName"
		        				value="<?=isset($pds_details) ? $pds_details[1] : (count($emp_child) > 0 ? $emp_child['childName']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" id="startdate_textbox">
		    <div class="col-sm-4">
		        <div class="form-group">
		            <label class="control-label">Date of Birth : </label>
		            <div class="input-icon right">
		            	<input class="form-control date-picker" name="dtmChildBdate" id="dtmChildBdate" type="text" data-date-format="yyyy-mm-dd" 
		            			value="<?=isset($pds_details) ? $pds_details[2] : (count($emp_child) > 0 ? $emp_child['childBirthDate']:'')?>" autocomplete="off">
		            </div>
		        </div>
		    </div>
		</div>
		<div class="row"><div class="col-sm-8"><hr></div></div>
		<div class="row">
		    <div class="col-sm-8">
		        <button type="submit" class="btn btn-success" id="btn-request-children">
		            <i class="icon-check"></i>
		            <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
		        <a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    </div>
		</div>
	<?=form_close()?>
</div>
