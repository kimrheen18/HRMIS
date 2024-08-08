<?php 
	$show_ref = 1;
	if(isset($pds_details) || isset($emp_ref)):
		if(isset($pds_details)):
			if(end($pds_details) != PDS_REF):
				$show_ref = 0;
			endif;
		else:
			if(isset($emp_ref)):
				$show_ref = 0;
			endif;
		endif;
	endif;
 ?>
<div class="col-md-10">
	<br>
	<table class="table table-bordered table-striped" id="table-reference">
		<thead>
			<tr>
				<th style="vertical-align: middle;"> Name of Reference</th>
				<th style="vertical-align: middle;"> Address</th>
				<th style="text-align: center;vertical-align: middle;"> Telephone</th>
				<th style="text-align: center;vertical-align: middle;"> Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($arrReference as $row):?>
			<tr>
				<td> <?=$row['refName']?></td>
				<td> <?=$row['refAddress']?></td>
				<td align="center"> <?=$row['refTelephone']?></td>
				<td align="center">
					<?php 
						$row_show = 1;
						if(isset($pds_details)):
							$row_show = isset($pds_details[4]) ? $pds_details[4] == $row['ReferenceIndex'] ? 0 : 1 : 1;
						else:
							if(count($emp_ref) > 0):
								$row_show = $emp_ref['ReferenceIndex'] == $row['ReferenceIndex'] ? 0 : 1;
							else:
							endif;
						endif;
						if($row_show):?>
							<a class="btn green btn-sm" href="<?=base_url('employee/pds_update/add?ref_id='.$row['ReferenceIndex'])?>"><i class="fa fa-edit"></i> Edit </a>
						<?php endif; ?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<br>
</div>

<div class="col-md-12">
	<?=form_open('employee/pds_update/submitRef?action='.$action, array('method' => 'post', 'id' => 'frmEduc'))?>
		<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_REF?>">
		<input class="hidden" name="txtrefid" value="<?=isset($_GET['ref_id']) ? $_GET['ref_id'] : (isset($pds_details) ? $pds_details[3] : '')?>">
		<div class="row" id="refname_textbox">
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Name : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strRefName"
		        			value="<?=isset($pds_details) ? $pds_details[1] : (count($emp_ref) > 0 ? $emp_ref['refName']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" id="refadd_textbox">
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Address : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strRefAdd"
		        			value="<?=isset($pds_details) ? $pds_details[2] : (count($emp_ref) > 0 ? $emp_ref['refAddress']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" id="refcontact_textbox">
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Contact Number : </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="intRefContact"
		        			value="<?=isset($pds_details) ? $pds_details[3] : (count($emp_ref) > 0 ? $emp_ref['refTelephone']:'')?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" <?=$action!='add' ? ($show_ref ? '' : 'hidden') : ''?>><div class="col-sm-8"><hr></div></div>
		<div class="row" <?=$action!='add' ? ($show_ref ? '' : 'hidden') : ''?>>
		    <div class="col-sm-8">
		        <button type="submit" class="btn btn-success" id="btn-request-ref">
		            <i class="icon-check"></i>
		            <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
		        <a href="<?=base_url('employee/pds_update')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
		    </div>
		</div>
	<?=form_close()?>
</div>
