<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEmployeesSalaryGrade_model extends CI_Model {

	var $w=array(70,70,60,60);

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');
	}
	
	public function Header()
	{

	}
	
	function Footer()
	{		
		$this->fpdf->SetFont('Arial','',7);	
		$this->fpdf->Cell(50,3,date('Y-m-d h:i A'),0,0,'L');
		$this->fpdf->Cell(0,3,"Page ".$this->fpdf->PageNo(),0,0,'R');
	}

	function getSQLData($strSGNumber,$strAppStatus="")
	{
		$this->db->select('DISTINCT(tblEmpPersonal.empNumber),tblEmpPersonal.surname,tblEmpPersonal.firstname,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension, tblEmpPersonal.middleName,tblEmpPosition.statusOfAppointment,tblEmpPosition.salaryGradeNumber,tblPosition.positionDesc,tblEmpPersonal.middlename');
		
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','inner');
		$this->db->join('tblSalarySched',
			'tblEmpPosition.salaryGradeNumber = tblSalarySched.salaryGradeNumber','inner');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('tblSalarySched.salaryGradeNumber',$strSGNumber);
		if($strAppStatus!='')
			$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
		
		$this->db->order_by('tblEmpPersonal.surname asc,tblEmpPersonal.firstname asc, tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function printBody($t_intCounter,$t_strEmpNumber,$t_strEmpName, $strOfficePosition)
	{
		$InterLigne = 7;
		$Percentage = 19; 
		$Height = 10;
	
		$strEmpNumCmbine = $t_intCounter.".    ".$t_strEmpNumber;
		$this->fpdf->SetFont('Arial','',10);
		/*
		$this->Cell(70,5,$strEmpNumCmbine,1,0,L);
		$this->Cell(110,5,$t_strEmpName,1,0,C);
		$this->Ln(5);
		*/
		
		$w = array(45,60,75);
		$Ln = array('L','C','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->FancyRow(array($strEmpNumCmbine,$t_strEmpName,$strOfficePosition),array(1,1,1));

	}

	function printSalaryGrade($t_strSalaryGrade)
	{
		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->SetFillColor(150,150,150);
		$this->fpdf->Cell(180,10,"SALARY GRADE NUMBER :  ".$t_strSalaryGrade,1,0,'C',1);
		$this->fpdf->Ln(10);
		$this->fpdf->SetFillColor(200,200,200);
		/*
		$this->Cell(70,6,"EMPLOYEE NUMBER",1,0,C,1);
		$this->Cell(110,6,"EMPLOYEE NAME",1,0,C,1);
		$this->Ln(6);
		*/
		
		$this->fpdf->SetFont('Arial','B',11);
		$w = array(45,60,75);
		$Ln = array('C','C','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->SetFillColor(225,225,225);
		$this->fpdf->Cell($w[0],10,"EMPLOYEE NUMBER",1,0,'C',1);
		$this->fpdf->Cell($w[1],10,"EMPLOYEE NAME",1,0,'C',1);
		$this->fpdf->Cell($w[2],10,"OFFICE - POSITION",1,0,'C',1);
		$this->fpdf->Ln();
		//$this->fpdf->FancyRow(array("EMPLOYEE NUMBER","EMPLOYEE NAME","OFFICE - POSITION"),array(1,1,1),1,1);
		$this->fpdf->SetFillColor(255,255,25);
	}

	function get_salarygrade()
	{
		$this->db->Select('DISTINCT(tblSalarySched.salaryGradeNumber)');
		$this->db->order_by('tblSalarySched.salaryGradeNumber desc');
		$objQuery = $this->db->get('tblSalarySched');
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->Ln(18);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,6,strtoupper('list of employees by salary grade'), 0, 0, 'C');
		$this->fpdf->Ln(15);
		
		$objSalaryGrade = $this->get_salarygrade();
		$this->fpdf->SetDrawColor(0,0,0);
		foreach($objSalaryGrade as $arrSalaryGrade)
		//while($arrSalaryGrade = mysql_fetch_array($objSalaryGrade))
		{
			
			$strSGNumber = $arrSalaryGrade['salaryGradeNumber'];
			$strAppStatus = $arrData['strAppStatus'];
			$objEmpSalaryGrade = $this->getSQLData($strSGNumber,$strAppStatus);
														
			$totalNumRows = count($objEmpSalaryGrade);											
			
			if($totalNumRows!=0)
			{
				$this->printSalaryGrade($strSGNumber);
				
				$intCounter = 0;
				foreach($objEmpSalaryGrade as $arrEmpSalaryGrade)
				//while($arrEmpSalaryGrade = mysql_fetch_array($objEmpSalaryGrade))
				{
					$strEmpNumber = $arrEmpSalaryGrade['empNumber'];
					$strMidName = $arrEmpSalaryGrade['middlename'];
					$strMiddleName = substr($strMidName,0,1);
					
					$extension = (trim($arrEmpSalaryGrade['nameExtension'])=="") ? "" : " ".$arrEmpSalaryGrade['nameExtension'];		
					$strEmpName=$arrEmpSalaryGrade["surname"].', '.$arrEmpSalaryGrade["firstname"].$extension.' '.mi($arrEmpSalaryGrade["middleInitial"]);

					
					//$strEmpName = $arrEmpSalaryGrade['surname'].",  ".$arrEmpSalaryGrade['firstname']." ".
					//$arrEmpSalaryGrade['nameExtension']." ".$arrEmpSalaryGrade['middleInitial'].".";
					$strStatusOfAppointment = $arrEmpSalaryGrade['statusOfAppointment'];
					

					$strOffice = office_name(employee_office($arrEmpSalaryGrade['empNumber']));
					$strOfficePosition = $strOffice.' - '.$arrEmpSalaryGrade['positionDesc'];

					if($strStatusOfAppointment =='In-Service')
					{
						$intCounter++;
						$this->printBody($intCounter,$strEmpNumber,$strEmpName, $strOfficePosition);				
					}


				}
			}
		}

		/* Signatory */
		 if($this->fpdf->GetY()>195)
			 $this->fpdf->AddPage();
			 
		
			
		$this->fpdf->Ln(20);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','B',12);		
		$this->fpdf->Cell(0,10,"Certified Correct:",0,0,'L');
		

		$sig=getSignatories($arrData['intSignatory']);
		if(count($sig)>0)
		{
			$sigName = $sig[0]['signatory'];
			$sigPos = $sig[0]['signatoryPosition'];
		}
		else
		{
			$sigName='';
			$sigPos='';
		}
		$this->fpdf->Ln(20);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','B',12);		
		$this->fpdf->Cell(0,10,$sigName,0,0,'L');

		$this->fpdf->Ln(4);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','',12);				
		$this->fpdf->Cell(0,10,$sigPos,0,0,'L');
		
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','',12);				
		//$this->fpdf->Cell(0,10,$sig[0],0,0,'L');
		$this->fpdf->Ln(15);
			
		
		
		echo $this->fpdf->Output();
	}
	
}
/* End of file ListEmployeesSalaryGrade_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesSalaryGrade_model.php */