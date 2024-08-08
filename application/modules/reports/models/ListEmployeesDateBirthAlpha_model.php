<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEmployeesDateBirthAlpha_model extends CI_Model {

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
	
	function printBody($t_intCounter,$t_strBDDay,$t_strBDYear,$t_strEmpName,$t_OfficePosition) 
	{
		$InterLigne = 7;
		$Percentage = 19; 
		$Height = 10;

		//$t_strNameCmbne = $t_intCounter."."."   ".$t_strName;
		
		$this->fpdf->SetFont('Arial','',10);
		$w = array(10,10,15,65,90);
		$Ln = array('L','C','C','C','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->FancyRow(array($t_intCounter,$t_strBDDay, $t_strBDYear,$t_strEmpName,$t_OfficePosition),array(1,1,1,1,1));

	}

	function printMonth($t_intMonthCntr)
	{
		$InterLigne = 7;
		$Percentage = 19; 
		$Height = 10;
		//$obj=new General;
		$strMonthName = intToMonthFull($t_intMonthCntr);
		$strMonthNameCap = strtoupper($strMonthName);
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Cell(175,5,"",0,0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFillColor(150,150,150);
		$this->fpdf->Cell(190,5,$strMonthNameCap,1,0,'C',1);
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->SetFillColor(200,200,200);
		$this->fpdf->Cell(10,7,"#",1,0,'L',1);
		$this->fpdf->Cell(10,7,"DAY",1,0,'C',1);
		$this->fpdf->Cell(15,7,"YEAR",1,0,'C',1);
		$this->fpdf->Cell(65,7,"NAME OF EMPLOYEE",1,0,'C',1);
		$this->fpdf->Cell(90,7,"OFFICE - POSITION",1,0,'C',1);
		$this->fpdf->Ln(7);
	 }

	function getSQLData($strAppStatus="",$intMonth="")
	{
		if($strAppStatus!=''):
			if($strAppStatus=='P')
			{
				$arrPermGroup = getPermanentGroup();
				if(count($arrPermGroup)>0)
				{
					$arrGroup = explode(',',$arrPermGroup[0]['processWith']);
					$strGroup = implode('","',$arrGroup);
					$this->db->where_in('tblEmpPosition.appointmentCode',$arrGroup);
				}
			}
			else
				$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
		endif;
		if($intMonth!='')
			$this->db->like('tblEmpPersonal.birthday','%-'.($intMonth<10?'0'.$intMonth:$intMonth).'-%');
		//$strAppStatus = $_GET['cboAppointmentStatus'];
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname,tblEmpPersonal.firstname,
			tblEmpPersonal.middleInitial, tblEmpPersonal.middlename, tblEmpPersonal.nameExtension, 
			tblEmpPersonal.birthday,tblEmpPosition.statusOfAppointment,
			tblPosition.positionDesc ,SUBSTR(tblEmpPersonal.birthday, 6, 2) as day');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where("(tblEmpPosition.detailedfrom='0' OR tblEmpPosition.detailedfrom='2')");
		$this->db->order_by('tblEmpPersonal.surname ASC,tblEmpPersonal.firstname ASC');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query(); exit(1);
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->Ln(5);
		$this->fpdf->Ln(20);
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Cell(0,2,strtoupper("alphabetical list of employee's birthdays"), 0, 0, 'C');
		$this->fpdf->Ln(10);
		
		$this->fpdf->SetFillColor(210,210,210);
		$this->fpdf->Cell(70,5,"EMPLOYEE",1,0,'C',1);
		$this->fpdf->Cell(85,5,"OFFICE - POSITION",1,0,'C',1);
		$this->fpdf->Cell(30,5,"DATE",1,0,'C',1);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(185,5," ",1,0,'L');
		$this->fpdf->Ln(5);

		$rs = $this->getSQLData($arrData['strAppStatus']);
		$this->fpdf->SetFillColor(255,255,255);
		$this->fpdf->SetFont('Arial','',11);
		$i=1;
		foreach($rs as $arrEmpBirthDay):
			if($arrEmpBirthDay["birthday"]!='0000-00-00')
			{			
				$arrDate = explode('-',$arrEmpBirthDay['birthday']);
				$year = $arrDate[0];
				$month = $arrDate[1];
				$day = $arrDate[2];
				$name=$arrEmpBirthDay["surname"].", ".$arrEmpBirthDay["firstname"]." ".$arrEmpBirthDay["nameExtension"]." ".mi($arrEmpBirthDay["middlename"]);
				$name = utf8_decode($name);
				$strOffice = office_name(employee_office($arrEmpBirthDay['empNumber']));
				$strOfficePosition = $strOffice.' - '.$arrEmpBirthDay["positionDesc"];

				$w = array(70,85,30);
				$Ln = array('L','C','C');
				$this->fpdf->SetWidths($w);
				$this->fpdf->SetAligns($Ln);
				$this->fpdf->FancyRow(array($i.'. '.$name,$strOfficePosition,date('F j, Y',strtotime($month.'/'.$day.'/'.$year))),array(1,1,1));
				$i++;
				//$ctr++;

			}
		endforeach;
		 
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
/* End of file ListEmployeesDateBirth_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesDateBirth_model.php */