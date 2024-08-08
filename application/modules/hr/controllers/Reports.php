<?php 
/** 
Purpose of file:    Controller for Reports
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends MY_Controller
{
	var $arrData;
	
	function __construct() {
        parent::__construct();
        $this->load->model(array('hr/reports_model','libraries/user_account_model','hr/Hr_model','libraries/org_structure_model'));
        $this->load->helper('report_helper');
    }

	public function index()
	{
		$this->arrData['arrReports'] = $this->reports_model->getData();
		$this->arrData['arrUser'] = $this->user_account_model->getData();
		$this->arrData['arrUser'] = $this->user_account_model->getEmpDetails();
		$this->arrData['arrOffice'] = $this->org_structure_model->getDivisionData();
		$this->arrData['arrEmployees'] = $this->Hr_model->getData();

		$this->template->load('template/template_view', 'hr/reports_view', $this->arrData);
	}

	function intToMonthFull($t_intMonth)
	{
		$arrMonths = array(1=>"January", 2=>"February", 3=>"March", 
						4=>"April", 5=>"May", 6=>"June", 
						7=>"July", 8=>"August", 9=>"September", 
						10=>"October", 11=>"November", 12=>"December");
		return $arrMonths[$t_intMonth];
	}


	public function getfields()
	{
		$rpt = $this->uri->segment(4);
		echo load_plugin('css', array('datepicker'));
		echo load_plugin('js', array('datepicker'));
		switch($rpt)
		{
			case 'AR':
				echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label">Letter Date : </label>
	                	</div>
	                </div>';
				echo '<div class="col-sm-2">'.comboYear('dtLetterYear').'</div>
                <div class="col-sm-2">'.comboMonth('dtLetterMonth').'</div>
                <div class="col-sm-2">'.comboDay('dtLetterDay').'</div>
                </div>
                </div>';
                echo '<div class="row">
                		<div class="col-sm-3 text-right">
                			<div class="form-group">
                				<label class="control-label">Received Date : </label>
                			</div>
                		</div>';
				echo '<div class="col-sm-2">'.comboYear('dtReceivedYear').'</div>
				<div class="col-sm-2">'.comboMonth('dtReceivedMonth').'</div>
	            <div class="col-sm-2">'.comboDay('dtReceivedDay').'</div>
				</div></div>';
                echo '<div class="row">
                		<div class="col-sm-3 text-right">
                			<div class="form-group">
                				<label class="control-label">Accepted Date : </label>
                			</div>
                		</div>';
				echo '<div class="col-sm-2">'.comboYear('dtAcceptedYear').'</div>
                <div class="col-sm-2">'.comboMonth('dtAcceptedMonth').'</div>
                <div class="col-sm-2">'.comboDay('dtAcceptedDay').'</div>
                </div></div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
			break;
			case 'ALC':
				echo '<div class="row">
						<div class="col-sm-3 text-right">
		                	<div class="form-group">
		                		<label class="control-label">Month: </label>
		                	</div>
		                </div>
		                <div class="col-sm-3">
		                	<div class="form-group">'.comboMonth('dtMonth').'</div>
		                </div>
	                </div>
	                <div class="row">
		                <div class="col-sm-3 text-right">
		                	<div class="form-group">
		                		<label class="control-label">Year: </label>
		                	</div>
		                </div>
		                <div class="col-sm-3">
		                	<div class="form-group">'.comboYear('dtYear').'</div>
		                </div>
	                </div>';
	                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Noted : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatoryNoted').'</div>
	        			</div>
                	</div>
                </div>';
			break;
			case 'ARO':
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
			break;
			case 'AFLF':
				echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label">Date filed : </label>
	                	</div>
	                </div>';
				echo '<div class="col-sm-2">'.comboYear('dtLetterYear').'</div>
                <div class="col-sm-2">'.comboMonth('dtLetterMonth').'</div>
                <div class="col-sm-2">'.comboDay('dtLetterDay').'</div>
                </div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
			break;
			case 'ADR':
				echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
			break;
			case 'DTR':
            	echo '<div class="row">
                		<div class="col-sm-3 text-right">
                			<div class="form-group">
                				<label class="control-label">Period : </label>
                			</div>
                		</div>';
				echo '<div class="col-sm-2">'.comboYear('dtrYear').'</div>
                <div class="col-sm-2">'.comboMonth('dtrMonth').'</div>
                </div></div>';
            break;
            case 'EAS':
            	echo '<div class="row">
                		<div class="col-sm-3 text-right">
                			<div class="form-group">
                				<label class="control-label">Period : </label>
                			</div>
                		</div>';
				echo '<div class="col-sm-2">
					<select type="text" class="form-control" name="strEligibility" maxlength="50">
						<option value="">Select</option>
						<option value="First Half">First Half</option>
						<option value="Second Half">Second Half</option>
					</select>
                </div></div>';
                echo '<div class="row">
                		<div class="col-sm-3 text-right">
                			<div class="form-group">
                				<label class="control-label">Year : </label>
                			</div>
                		</div>';
				echo '<div class="col-sm-2">'.comboYear('dtrYear').'</div>
                </div></div>';
            break;
            case 'EP':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LB':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div></div>';
                echo '<div class="row">
                			<div class="col-sm-3 text-right">
	        					<div class="form-group">
								</div>
	        				</div>
	        		</div>';
	        	echo '<div class="row">
                			<div class="col-sm-3 text-right">
	        					<div class="form-group">
								</div>
	        				</div>
	        		</div>';
                echo '<div class="row">
                		<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        			<input type="radio" name="radio" id="radio1" class="radio" checked/>
						<label for="radio1">Select Period </label>
							</div>
	        		</div>
	        	</div>';
	        	echo '<div class="row">
	        		<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">From : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        			  	<div class="col-sm-2">'.comboMonth('intMonth').'</div>
	        				<div class="col-sm-2">'.comboYear('intYear').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
	        		<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">To : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        			  	<div class="col-sm-2">'.comboMonth('intMonth').'</div>
	        				<div class="col-sm-2">'.comboYear('intYear').'</div>
	        			</div>
                	</div>
                </div>';
  				echo '<div class="row">
                		<div class="col-sm-3 text-right">
	        			<div class="form-group">

						<input type="radio" name="radio" id="radio2" class="radio"/>
						<label for="radio2">View All Period</label>
	        			</div>
	        		</div>
	        	</div>';
            break;
			case 'CDR':
				echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label"> Date : </label>
	                	</div>
	                </div>';
				echo '<div class="col-sm-2">'.comboYear('intYear').'</div>
                <div class="col-sm-2">'.comboMonth('intMonth').'</div>
                <div class="col-sm-2">'.comboDay('intDay').'</div>
                </div>
                </div>';
				echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'CEC':
				echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'CNAC':
				echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label"> Date Year : </label>
	                	</div>
	                </div>';
				echo '<div class="col-sm-2">'.comboYear('intYear').'</div>
                <div class="col-sm-2">'.comboMonth('intMonth').'</div>
                <div class="col-sm-2">'.comboDay('intDay').'</div>
                </div>
                </div>';
				echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'CNACLP':
				echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label"> Issued Date : </label>
	                	</div>
	                </div>';
				echo '<div class="col-sm-2">'.comboYear('intYear').'</div>
                <div class="col-sm-2">'.comboMonth('intMonth').'</div>
                <div class="col-sm-2">'.comboDay('intDay').'</div>
                </div>
                </div>';
				echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Signatory : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'CNACL':
				echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'CACQ':
				echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Position Considered : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboPosition('strPosition').'</div>
	        			</div>
                	</div>
                </div>';
                 echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Eligibility Requirement : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="form-control" name="strEligibility" maxlength="50"></div>
	        			</div>
                	</div>
                </div>';
                 echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Educational Requirement : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="form-control" name="strEducational" maxlength="50"></div>
	        			</div>
                	</div>
                </div>';
                 echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Experience Requirement : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="form-control" name="strExpReq" maxlength="50"></div>
	        			</div>
                	</div>
                </div>';
                 echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Training Requirement : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="form-control" name="strTraining" maxlength="50"></div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'EFDS':
				echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LEA':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LEAGE':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LEDH':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LEDB':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LEDBA':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LEEA':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LEG':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LELS':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LESG':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LESGA':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Appointment Status : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboAppStatus('strAppStatus').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LET':
        
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LOYR':
        		echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Cut Off From Date : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="date-picker form-control" name="dtmFromDate" maxlength="10"></div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Cut Off To Date : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="date-picker form-control" name="dtmToDate" maxlength="10"></div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Printed Date : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="date-picker form-control" name="dtmPrintedDate" maxlength="10"></div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'OB':
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label">Date filed : </label>
	                	</div>
	                </div>';
				echo '<div class="col-sm-2">'.comboYear('dtLetterYear').'</div>
                <div class="col-sm-2">'.comboMonth('dtLetterMonth').'</div>
                <div class="col-sm-2">'.comboDay('dtLetterDay').'</div>
                </div>
                </div>';
            break;
            case 'LR':
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LTP':
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Training Criteria : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="form-control" name="strCriteria" maxlength="50"></div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'LVP':
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'PP':
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'AAR':
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
               echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label"> Period : </label>
	                	</div>
	                </div>';
				echo ' <div class="col-sm-2">'.comboMonth('dtmMonth').'</div>
					<div class="col-sm-2">'.comboYear('dtmYear').'</div>
                </div>';
                 echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Year : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboYear('dtmYear').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'PSK':
            	echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Date : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="date-picker form-control" name="dtmDate" maxlength="10"></div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Nilagdaan sa : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="form-control" name="strNilagdaan" maxlength="50"></div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Sedula Klase A : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="form-control" name="strSedula" maxlength="50"></div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Kinuha sa : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6"><input type="text" class="form-control" name="strKinuha" maxlength="50"></div>
	        			</div>
                	</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'ROT':
            	echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label"> Period : </label>
	                	</div>
	                </div>';
				echo ' <div class="col-sm-2">'.comboMonth('dtmMonth').'</div>
					<div class="col-sm-2">'.comboYear('dtmYear').'</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'ROTUAN':
            	echo '<div class="row">
					<div class="col-sm-3 text-right">
	                	<div class="form-group">
	                		<label class="control-label"> Period : </label>
	                	</div>
	                </div>';
				echo ' <div class="col-sm-2">'.comboMonth('dtmMonth').'</div>
					<div class="col-sm-2">'.comboYear('dtmYear').'</div>
                </div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'SR':
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'TOS':
                echo '<div class="row">
                		<div class="col-sm-3 text-right">
                			<div class="form-group">
                				<label class="control-label">Training Date From: </label>
                			</div>
                		</div>';
				echo '<div class="col-sm-2">'.comboYear('dtmTrainYearFrm').'</div>
                		<div class="col-sm-2">'.comboMonth('dtmTrainMonthFrm').'</div>
                		<div class="col-sm-2">'.comboDay('dtmATrainDayFrm').'</div>
                	</div></div>';
        	 	echo '<div class="row">
                		<div class="col-sm-3 text-right">
                			<div class="form-group">
                				<label class="control-label">Training Date To: </label>
                			</div>
                		</div>';
				echo '<div class="col-sm-2">'.comboYear('dtmTrainYearTo').'</div>
                		<div class="col-sm-2">'.comboMonth('dtmTrainMonthTo').'</div>
                		<div class="col-sm-2">'.comboDay('dtmATrainDayTo').'</div>
                	</div></div>';
                echo '<div class="row">
                	<div class="col-sm-3 text-right">
	        			<div class="form-group">
	        				<label class="control-label">Certified Correct : </label>
	        			</div>
	        			</div>
	        			<div class="form-group">
	        				<div class="col-sm-6">'.comboSignatory('intSignatory').'</div>
	        			</div>
                	</div>
                </div>';
            break;
            case 'MA':
	            echo '<div class="row">
		        		<div class="col-sm-3 text-right">
		        			<div class="form-group">
		        				<label class="control-label">For : </label>
		        			</div>
		        			</div>
		        			<div class="form-group">
		        			  	<div class="col-sm-2">'.comboMonth('intMonth').'</div>
		        				<div class="col-sm-2">'.comboYear('intYear').'</div>
		        			</div>
	                	</div>
	                </div>';
	        break;
		}
		echo "<script>
		$('.date-picker').datepicker({format: 'yyyy-mm-dd'});
		</script>";
	}
   
	
}
