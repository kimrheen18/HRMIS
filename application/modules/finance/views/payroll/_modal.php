<style>
    th { white-space: nowrap; }
</style>

<div id="modal-process" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Choose Deduction Type</h4>
            </div>
            <?=form_open('finance/compensation/personnel_profile/edit_payrollDetails/'.$this->uri->segment(5), array('id' => 'frmpayrollDetails'))?>
                <div class="modal-body">
                    <div class="row form-body">
                        <div class="col-md-4" id="div-loan">
                        	<div class="portlet light bordered">
                        	    <div class="portlet-title" style="min-height: 37px !important;">
                        	     <span class="caption-subject bold"> Loan</span>
                        	    </div>
                        	    <div class="portlet-body">
                        	    	<div class="row">
                        	    		<div class="col-md-12">
                        	    			<label class="checkbox chkall"><input type="checkbox" id="chkall-loan" value="chkall"> Check All </label>
                        	    		</div>
                        	    		<?php foreach($arrLoan as $loan): ?>
                        	    		<div class="col-md-6">
                        	    			<label class="checkbox"><input type="checkbox" id="chkloan" value="<?=$loan['deductionCode']?>"> <?=ucwords($loan['deductionDesc'])?> </label>
                        	    		</div>
                        	    		<?php endforeach; ?>
                        	    	</div>
                        	    	<br>
                        	    </div>
                        	</div>
                        </div>
                        <div class="col-md-4" id="div-cont">
                        	<div class="portlet light bordered">
                        	    <div class="portlet-title" style="min-height: 37px !important;">
                        	     <span class="caption-subject bold"> Contribution</span>
                        	    </div>
                        	    <div class="portlet-body">
                        	    	<div class="row">
                        	    		<div class="col-md-12">
                        	    			<label class="checkbox chkall"><input type="checkbox" id="chkall-cont" value="chkall"> Check All </label>
                        	    		</div>
                        	    		<?php foreach($arrContrib as $contr): ?>
                        	    		<div class="col-md-6">
                        	    			<label class="checkbox"><input type="checkbox" id="chkcont" value="<?=$contr['deductionCode']?>"> <?=ucwords($contr['deductionDesc'])?> </label>
                        	    		</div>
                        	    		<?php endforeach; ?>
                        	    	</div>
                        	    	<br>
                        	    </div>
                        	</div>
                        </div>
                        <div class="col-md-4" id="div-othr">
                        	<div class="portlet light bordered">
                        	    <div class="portlet-title" style="min-height: 37px !important;">
                        	     <span class="caption-subject bold"> Others</span>
                        	    </div>
                        	    <div class="portlet-body">
                        	    	<div class="row">
                        	    		<div class="col-md-12">
                        	    			<label class="checkbox chkall"><input type="checkbox" id="chkall-othr" value="chkall"> Check All </label>
                        	    		</div>
                        	    		<?php foreach($arrOthers as $othrs): ?>
                        	    		<div class="col-md-6">
                        	    			<label class="checkbox"><input type="checkbox" id="chkothrs" value="<?=$othrs['deductionCode']?>"> <?=ucwords($othrs['deductionDesc'])?> </label>
                        	    		</div>
                        	    		<?php endforeach; ?>
                        	    	</div>
                        	    	<br>
                        	    </div>
                        	</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn green"><i class="icon-check"> </i> Process</button>
                    <button type="button" class="btn blue" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>


<div id="modal-computeBenefits-Monthly" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Choose Deduction Type</h4>
            </div>
            <?=form_open('finance/compensation/personnel_profile/edit_payrollDetails/'.$this->uri->segment(5), array('id' => 'frmpayrollDetails'))?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title" style="display: grid;">
                                    <div class="well">
                                        Use data from Month:&nbsp;
                                        <select class="bs-select" id="pselmon">
                                            <?php foreach (range(1, 12) as $m): ?>
                                                <option value="<?=$m?>" <?=isset($_GET['pmon']) ? $_GET['pmon'] == $m ? 'selected' : '' : date('n') == $m ? 'selected' : ''?>>
                                                    <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        &nbsp;Year:&nbsp;
                                        <select class="bs-select" id="pselyr">
                                            <?php foreach(range((date('Y')-3), (date('Y')+3), +1) as $yr): ?>
                                                <option value="<?=$yr?>"><?=$yr?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        &nbsp;<button class="btn blue" id="btn-pprocess-compute">Compute</button>
                                        <p><b>Total Working days :</b></p>
                                        <p><b>Payroll Date</b>: November 2018 || <b>Total Working days</b>: 19 for Subsistence Allowance and RATA <b>For</b>
                                            <u> <span id="spnappt"></span> Employees</u></p>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-hover table-bordered" id="tblPayrollProcess">
                                        <thead>
                                            <tr>
                                                <th> Employee Name </th>
                                                <th> Salary </th>
                                                <th> Working Days </th>
                                                <th> Actual Days Present </th>
                                                <th> Absences </th>
                                                <th> HP % </th>
                                                <th> HP </th>
                                                <th> 8 hrs </th>
                                                <th> 6 hrs </th>
                                                <th> 5 hrs </th>
                                                <th> 4 hrs </th>
                                                <th> Total per diem </th>
                                                <th> Subsistence </th>
                                                <th> Days w/o Laundry</th>
                                                <th> Laundry </th>
                                                <th> LP </th>
                                                <th> RA % </th>
                                                <th> RA </th>
                                                <th> days w/ vehicle</th>
                                                <th> TA % </th>
                                                <th> TA </th>
                                                <th> Total </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn green"><i class="icon-check"> </i> Process</button>
                    <button type="button" class="btn blue" data-dismiss="modal"><i class="icon-ban"> </i> Cancel</button>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
