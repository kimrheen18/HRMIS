<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEmployeesAge_model extends CI_Model {

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');		
		//$this->load->model(array());
		//ini_set('display_errors','On');
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
	
	function getSQLData($strAppStatus="")
	{
		if($strAppStatus!='')
			$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		//$strAppStatus = $_GET['cboAppointmentStatus'];
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname, tblEmpPersonal.firstname,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension,  tblEmpPersonal.birthday,tblEmpPosition.statusOfAppointment,tblPosition.positionDesc,tblEmpPersonal.middlename');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
	
		$this->db->order_by('tblEmpPersonal.birthday, tblEmpPersonal.surname asc, tblEmpPersonal.firstname asc,tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function printBody($t_intCounter, $t_strEmpName,$t_age, $t_OfficePosition)
	{
		$InterLigne = 7;
		$Percentage = 19; 
		$Height = 10;
		$strNumEmpName = $t_intCounter.".    ".$t_strEmpName;
		$this->fpdf->SetFont('Arial','',10);
		$w = array(65,105,20);
		$Ln = array('L','C','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->FancyRow(array($strNumEmpName,$t_OfficePosition, $t_age),array(1,1,1),$Ln);
	}

	function generate($arrData)
	{		
		
		$rs=$this->getSQLData($arrData['strAppStatus']);
		$this->fpdf->AddPage();
		$this->fpdf->Ln(5);
		//$this->Cell(0,6,$this->agencyAdd, 0, 0, 'C');		
		//$head = new title();
		$this->fpdf->Ln(18);
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Cell(0,6,'List of Employees By Age', 0, 0, 'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,6,"As of " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(10);
		$InterLigne = 7;
		$Percentage = 19; 
		$Height = 10;
		
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->SetFillColor(200,200,200);
		$this->fpdf->Cell(65,10,"",'LTR',0,'C',1);
		$this->fpdf->Cell(105,10,"",'LTR',0,'C',1);
		$this->fpdf->Cell(20,10,"",'LTR',0,'C',1);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(65,10,"NAME OF EMPLOYEE",'LBR',0,'C',1);
		$this->fpdf->Cell(105,10,"OFFICE - POSITION",'LBR',0,'C',1);
		$this->fpdf->Cell(20,10,"AGE",'LBR',0,'C',1);
		$this->fpdf->Ln(10);
		$intCounter =0;	
		foreach($rs as $arrEmpAge):
			
			$strEmpNum = $arrEmpAge['empNumber'];
			$strStatusOfAppointment = $arrEmpAge['statusOfAppointment'];
			$strMidName = $arrEmpAge['middlename'];
			$strMiddleName = substr($strMidName, 0,1);
			$strEmpName = $arrEmpAge['surname']. ",  ".$arrEmpAge['firstname']." ".$arrEmpAge['nameExtension']." ".str_replace('.','',$arrEmpAge['middleInitial']).".";
			$strEmpName = utf8_decode($strEmpName);
			$strOffice = office_name(employee_office($arrEmpAge['empNumber']));
			$strOfficePosition = $strOffice.' - '.$arrEmpAge['positionDesc'];
			$strBirthDay = $arrEmpAge['birthday'];
			$arrBirthDayEx = explode('-',$strBirthDay);
			$arrBDYear = intval($arrBirthDayEx[0]);
			$arrBDMonth = intval($arrBirthDayEx[1]);
			$arrBDDay = intval($arrBirthDayEx[2]);

			$curDateYr = date("Y");
			$curDateMonth = date("m");
			$curDateDay = date("d");
			
			if($strStatusOfAppointment == 'In-Service')
			{		
				if($arrBDMonth < $curDateMonth)
				{
					$age = $curDateYr - $arrBDYear;			
				}			
				elseif($arrBDMonth > $curDateMonth)
				{
					$age = ($curDateYr - $arrBDYear)-1;
				}
				elseif(($arrBDMonth == $curDateMonth)&&($arrBDDay < $curDateDay))
				{
					$age = $curDateYr - $arrBDYear;
				}
				elseif(($arrBDMonth == $curDateMonth)&&($arrBDDay > $curDateDay))
				{
					$age = ($curDateYr - $arrBDYear)-1;
				}
				elseif(($arrBDMonth == $curDateMonth)&&($arrBDDay == $curDateDay))
				{
					$age = $curDateYr - $arrBDYear;
				}
				if($age==$curDateYr || $age=="")
					$age="0";
					
				if($age!=0)	
				{
				$intCounter++;
				$this->printBody($intCounter,$strEmpName,$age, $strOfficePosition);
				}
			 }
	    
			 endforeach;
			 if($this->fpdf->GetY()>195)
				 $this->fpdf->AddPage();
				 
			 //$obj = new signatoryName();
				//$arrSig = $obj->createSignatory('RPAGE');
				
			$this->fpdf->Ln(20);
			$this->fpdf->Cell(30);
			$this->fpdf->Cell(30);				
			$this->fpdf->SetFont('Arial','B',12);		
			$this->fpdf->Cell(0,10,"Certified Correct:",0,0,'L');
			//$sig=explode('|',PD);

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
/* End of file ListEmployeesAge_model.php */
/* Location: ./application/models/reports/ListEmployeesAge_model.php */