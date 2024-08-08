<div class="col-md-12">
	<?=form_open('employee/pds_update/submitTax?action='.$action, array('method' => 'post', 'id' => 'frmcommunity'))?>
		<input class="hidden" name="txtreqid" value="<?=isset($_GET['req_id']) ? $_GET['req_id'] : ''?>">
		<input class="hidden" name="strStatus" value="Filed Request">
		<input class="hidden" name="strCode" value="<?=PDS_TAX?>">
		<div class="row" id="taxcert_textbox">
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Tax Certificate Number :  </label>
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="intTaxCert"
		        				value="<?=count($arrData)>0 ? (isset($pds_details) ? $pds_details[1] : $arrData[0]['comTaxNumber']):''?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" id="issuedAt_textbox">
		    <div class="col-sm-8">
		        <div class="form-group">
		        	<label class="control-label">Issued At :  </label> 
		        	<div class="input-icon right">
		        		<input type="text" class="form-control" name="strIssuedAt"
		        				value="<?=count($arrData)>0 ? (isset($pds_details) ? $pds_details[2] : $arrData[0]['issuedAt']):''?>" autocomplete="off">
		        	</div>
		        </div>
		    </div>
		</div>
		<div class="row" id="issuedOn_textbox">
		    <div class="col-sm-4">
		        <div class="form-group">
		            <label class="control-label">Issued On :  </label>
		            <div class="input-icon right">
		            	<input class="form-control date-picker" name="dtmIssuedOn" id="dtmIssuedOn" type="text"
		            			value="<?=count($arrData)>0 ? (isset($pds_details) ? $pds_details[3] : $arrData[0]['issuedOn']):''?>" data-date-format="yyyy-mm-dd" autocomplete="off">
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
