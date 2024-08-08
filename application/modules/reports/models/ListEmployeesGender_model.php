<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEmployeesGender_model extends CI_Model {

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

	function getSQLData($strSex="",$strAppStatus="")
	{
		
		//$strAppStatus = $_GET['cboAppointmentStatus'];
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname,tblEmpPersonal.firstname,
			tblEmpPersonal.middlename, tblEmpPersonal.nameExtension, 
			tblEmpPersonal.sex,tblEmpPosition.statusOfAppointment, tblPosition.positionDesc');
		
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
		
		if($strSex!='')
			$this->db->where('tblEmpPersonal.sex',$strSex);
		if($strAppStatus!='')
			$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->order_by('tblEmpPersonal.surname asc,tblEmpPersonal.firstname asc, tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function printFemale($t_strEmpName,$ctrFemale, $t_strPosition)
	{
		$InterLigne = 7;
		$Percentage = 19; 
		$Height = 10;
		
		/*
		$this->SetFont(Arial,'B',10);
		$this->Cell(10,6,$ctrFemale.'.',0,0,L);
		$this->Cell(150,6,$t_strEmpName,0,0,L);
		$this->Ln(6);
		*/

		
		$w = array(75,115);
		$Ln = array('L','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->FancyRow(array($ctrFemale.'.  '.$t_strEmpName,$t_strPosition),array(1,1));

	}
	
	function printFemaleHeader()
	{
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->SetFillColor(150,150,150);
		$this->fpdf->Cell(190,8,"FEMALE",1,0,'C',1);
		$this->fpdf->Ln();
		
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->SetFillColor(200,200,200);
		$this->fpdf->Cell(75,5,"NAME",1,0,'C',1);
		$this->fpdf->Cell(115,5,"OFFICE - POSITION",1,0,'C',1);
		$this->fpdf->Ln(5);

	}
	
	function printMale($t_strEmpName,$ctrMale, $t_strPosition)
	{
		$InterLigne = 7;
		$Percentage = 19; 
		$Height = 10;

		/*			
		$this->SetFont(Arial,'B',10);
		$this->Cell(10,6,$ctrMale.'.',0,0,L);
		$this->Cell(160,6,$t_strEmpName,0,0,L);
		$this->Ln(6);
		*/		
		
		$w = array(75,115);
		$Ln = array('L','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->FancyRow(array($ctrMale.'.  '.$t_strEmpName,$t_strPosition),array(1,1));

		

	}
	
	function printMaleHeader()
	{
		$this->fpdf->Ln(10);
		$this->fpdf->SetFillColor(150,150,150);
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Cell(190,8,"MALE",1,0,'C',1);
		$this->fpdf->Ln();

		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->SetFillColor(200,200,200);
		$this->fpdf->Cell(75,5,"NAME",1,0,'C',1);
		$this->fpdf->Cell(115,5,"OFFICE - POSITION",1,0,'C',1);
		$this->fpdf->Ln(5);
	}
	
	function totalFemale($t_intCounter)
	{
		//$this->Ln(6);
		$this->fpdf->SetFillColor(200,200,200);
		$this->fpdf->SetFont('Arial','B',10);	
		$this->fpdf->Cell(190,6,'Total Female: '.$t_intCounter ,1,0,'C',1);
		$this->fpdf->Ln(6);
		

	}
	
	function totalMale($t_intCounter)
	{
		//$this->Ln(6);
		$this->fpdf->SetFillColor(200,200,200);
		$this->fpdf->SetFont('Arial','B',10);	
		$this->fpdf->Cell(190,6,'Total Male:  '.$t_intCounter ,1,0,'C',1);
		$this->fpdf->Ln(6);
	
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(25,0,"",0,0,'L');
	
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(25,0,"",0,0,'L');
	
		$this->fpdf->Ln(15);
		$this->fpdf->SetFont('Arial','B',12);
		
		$this->fpdf->Cell(0,5,strtoupper('list of employees by gender'),0,0,'C');
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(0,2,'As of '.date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','',12);
		

		$objEmpGenderFemale = $this->getSQLData('F',$arrData['strAppStatus']);
		$intCounter =0;
		$tmp=0;$tmp2=0;
		$this->printFemaleHeader();
		$this->fpdf->SetFont('Arial','',12);
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetFillColor(255,255,255);
		foreach($objEmpGenderFemale as $arrEmpGenderFemale)
		//while($arrEmpGenderFemale = mysql_fetch_array($objEmpGenderFemale))
		{
			$strEmpNum = $arrEmpGenderFemale['empNumber'];
			$strEmpName = $arrEmpGenderFemale['surname']. ",  ".$arrEmpGenderFemale['firstname']. " ".$arrEmpGenderFemale['nameExtension']." ".mi($arrEmpGenderFemale['middlename']);
			$strEmpName = utf8_decode($strEmpName);
			$strSex = $arrEmpGenderFemale['sex'];
			$strStatusOfAppointment = $arrEmpGenderFemale['statusOfAppointment'];
			
			
			$strOffice = office_name(employee_office($arrEmpGenderFemale['empNumber']));
			$strOfficePosition = $strOffice.' - '.$arrEmpGenderFemale['positionDesc'];
		
			if($strStatusOfAppointment == 'In-Service')
			{
				$tmp++;
				$intCounter++;
				$this->printFemale($strEmpName,$intCounter, $strOfficePosition);
			/*	if ($tmp==33){
					$this->Ln(10);
					$this->SetFont(Arial,'B',12);
					$this->SetFillColor(150,150,150);
					$this->Cell(157,15,"FEMALE",0,0,C,1);
					$this->Ln(10);
					$tmp=0;
				} */
				
			}
		
		}
		$this->totalFemale($intCounter);
		
		$objEmpGenderMale= $this->getSQLData('M',$arrData['strAppStatus']);
		$intCounter =0;
		$this->printMaleHeader();
		$this->fpdf->SetFont('Arial','',12);
		foreach($objEmpGenderMale as $arrEmpGenderMale)
		//while($arrEmpGenderMale = mysql_fetch_array($objEmpGenderMale))
		{
			$strEmpNum = $arrEmpGenderMale['empNumber'];
			$strEmpName = $arrEmpGenderMale['surname']. ",  ".$arrEmpGenderMale['firstname']. " ".$arrEmpGenderMale['nameExtension']." ".$arrEmpGenderMale['middlename'];
			$strSex = $arrEmpGenderMale['sex'];
			$strStatusOfAppointment = $arrEmpGenderMale['statusOfAppointment'];
			
			$strOffice = office_name(employee_office($arrEmpGenderMale['empNumber']));
			$strOfficePosition = $strOffice.' - '.$arrEmpGenderMale['positionDesc'];

			if($strStatusOfAppointment == 'In-Service')
			{
				$intCounter++;
				$this->printMale($strEmpName,$intCounter, $strOfficePosition);
			}
		}
		$this->totalMale($intCounter);
		
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
/* End of file ListEmployeesGender_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesGender_model.php */