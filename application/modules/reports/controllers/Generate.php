<?php 
/** 
Purpose of file:    Controller for Reports
Author:             Louie Carl R. Mandapat
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends MY_Controller
{
	var $arrData;
	
	function __construct() {
        parent::__construct();
        //$this->load->model(array('hr/reports_model','libraries/user_account_model','hr/Hr_model'));
    }
	
	public function report()
    {
    	$arrGet = $this->input->get();
    	$rpt = $arrGet['rpt'];
    	$empno = $arrGet['empno'];

    	$this->load->library('fpdf_gen');
		$this->fpdf = new FPDF();
		$this->fpdf->AliasNbPages();
		$this->fpdf->Open();

    	switch($rpt) 
    	{
    		case 'AR': 
    			$this->load->model('AcceptanceResignation_model');
				$this->AcceptanceResignation_model->generate($arrGet);
    		break;
    		case 'ALC':
    			$this->load->model('AccumulatedLeaveCredits_model');
				$this->AccumulatedLeaveCredits_model->generate($arrGet);
    		break;
            case 'ARO':
                $this->load->model('AccumulatedReportbyOffice_model');
                $this->AccumulatedReportbyOffice_model->generate($arrGet);
            break;
            case 'AFLF':
                $this->load->model('ApplicationforLeaveForm_model');
                $this->ApplicationforLeaveForm_model->generate($arrGet);
            break;
    		case 'ADR':
    			$this->load->model('AssumptionDutiesResponsibilities_model');
				$this->AssumptionDutiesResponsibilities_model->generate($arrGet);
    		break;
    		case 'CDR':
    			$this->load->model('CertificateDutiesResponsibilities_model');
				$this->CertificateDutiesResponsibilities_model->generate($arrGet);
    		break;
    		case 'CEC':
    			$this->load->model('CertificateEmployeeCompensation_model');
				$this->CertificateEmployeeCompensation_model->generate($arrGet);
    		break;
    		case 'CNAC':
    			$this->load->model('CertificateNoAdministrativeCharge_model');
				$this->CertificateNoAdministrativeCharge_model->generate($arrGet);
    		break;
    		case 'CNACLP':
    			$this->load->model('CertificateNoAdministrativeChargeLegalPurpose_model');
				$this->CertificateNoAdministrativeChargeLegalPurpose_model->generate($arrGet);
    		break;
    		case 'CNACL':
    			$this->load->model('CertificateServiceLoyaltyAward_model');
				$this->CertificateServiceLoyaltyAward_model->generate($arrGet);
    		break;
            case 'CACQ':
                $this->load->model('ComparativeAnalysisOfCandidatesQualifications_model');
                $this->ComparativeAnalysisOfCandidatesQualifications_model->generate($arrGet);
            break;
            case 'EAS':
                $this->load->model('EmployeesAttendanceSummary_model');
                $this->EmployeesAttendanceSummary_model->generate($arrGet);
            break;
            case 'EP':
                $this->load->model('EmployeesProfile_model');
                $this->EmployeesProfile_model->generate($arrGet);
            break;
            case 'EFDS':
                $this->load->model('EmployeeFirstDayService_model');
                $this->EmployeeFirstDayService_model->generate($arrGet);
            break;
            case 'LB':
                $this->load->model('LeaveBalanceForm_model');
                $this->LeaveBalanceForm_model->generate($arrGet);
            break;
    		case 'LEA':
    			$this->load->model('ListEducationalAttainment_model');
				$this->ListEducationalAttainment_model->generate($arrGet);
    		break;
    		case 'LEAGE':
    			$this->load->model('ListEmployeesAge_model');
				$this->ListEmployeesAge_model->generate($arrGet);
    		break;
    		case 'LEDH':
    			$this->load->model('ListEmployeesDateHired_model');
				$this->ListEmployeesDateHired_model->generate($arrGet);
    		break;
    		case 'LEDB':
    			$this->load->model('ListEmployeesDateBirth_model');
				$this->ListEmployeesDateBirth_model->generate($arrGet);
    		break;
            case 'LEDBA':
                $this->load->model('ListEmployeesDateBirthAlpha_model');
                $this->ListEmployeesDateBirthAlpha_model->generate($arrGet);
            break;
    		case 'LEEA':
    			$this->load->model('ListEmployeesEducationalAttainment_model');
				$this->ListEmployeesEducationalAttainment_model->generate($arrGet);
    		break;
    		case 'LEG':
    			$this->load->model('ListEmployeesGender_model');
				$this->ListEmployeesGender_model->generate($arrGet);
    		break;
    		case 'LELS':
    			$this->load->model('ListEmployeesLengthService_model');
				$this->ListEmployeesLengthService_model->generate($arrGet);
    		break;
    		case 'LESG':
    			$this->load->model('ListEmployeesSalaryGrade_model');
				$this->ListEmployeesSalaryGrade_model->generate($arrGet);
    		break;
    		case 'LESGA':
    			$this->load->model('ListEmployeesSalaryGradeAlpha_model');
				$this->ListEmployeesSalaryGradeAlpha_model->generate($arrGet);
    		break;
    		case 'LET':
    			$this->load->model('ListEmployeesTraining_model');
				$this->ListEmployeesTraining_model->generate($arrGet);
    		break;
            case 'LOYR':
                $this->load->model('LoyaltyReport_model');
                $this->LoyaltyReport_model->generate($arrGet);
            break;
            case 'OB':
                $this->load->model('OfficialBusinessSlip_model');
                $this->OfficialBusinessSlip_model->generate($arrGet);
            break;
            case 'LR':
                $this->load->model('ListOfRetirees_model');
                $this->ListOfRetirees_model->generate($arrGet);
            break;
            case 'LTP':
                $this->load->model('TrainingPrograms_model');
                $this->TrainingPrograms_model->generate($arrGet);
            break;
            case 'LVP':
                $this->load->model('ListOfVacantPositions_model');
                $this->ListOfVacantPositions_model->generate($arrGet);
            break;
            case 'PDS':
                $this->load->model('employee/reports/ReportPDSupdate_model');
                $this->ReportPDSupdate_model->generate($arrGet);
            break;
            case 'PP':
                $this->load->model('PlantillaOfPersonnel_model');
                $this->PlantillaOfPersonnel_model->generate($arrGet);
            break;
            case 'AAR':
                $this->load->model('RptofAttendanceandAccumulatedLeaveCredits_model');
                $this->RptofAttendanceandAccumulatedLeaveCredits_model->generate($arrGet);
            break;
            case 'PSK':
                $this->load->model('PanunumpaSaKatungkulan_model');
                $this->PanunumpaSaKatungkulan_model->generate($arrGet);
            break;
            case 'ROT':
                $this->load->model('ReportTardiness_model');
                $this->ReportTardiness_model->generate($arrGet);
            break;
            case 'ROTUAN':
                $this->load->model('ReportTardinessNonperm_model');
                $this->ReportTardinessNonperm_model->generate($arrGet);
            break;
    		case 'SR':
    			$this->load->model('ServiceRecord_model');
				$this->ServiceRecord_model->generate($arrGet);
    		break;
            case 'TOS':
                $this->load->model('TrainingsofStaff_model');
                $this->TrainingsofStaff_model->generate($arrGet);
            break;
            case 'MA':
                $this->load->model('MonthlyAttendance_model');
                $this->MonthlyAttendance_model->generate2($arrGet);
            break;
            default: echo "Sorry, this report is still not available."; break;
    	}

    	
	}
   
	
}
