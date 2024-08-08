<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEmployeesDateHired_model extends CI_Model {

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
	
	function getSQLData($strAppStatus="")
	{
		if($strAppStatus!='')
			$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		//$strAppStatus = $_GET['cboAppointmentStatus'];
		$this->db->select('tblEmpPersonal.empNumber,tblEmpPersonal.surname, tblEmpPersonal.firstname, tblEmpPersonal.middlename, tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension,tblEmpPosition.statusOfAppointment,tblEmpPosition.firstDayAgency');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
	
		$this->db->order_by('tblEmpPosition.firstDayAgency asc,tblEmpPersonal.surname asc, tblEmpPersonal.firstname asc, tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		//$this->Ln(5);
		//$this->Cell(0,6,$this->agencyAdd, 0, 0, 'C');
		$this->fpdf->Ln(18);
		///s$head = new title();
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,6,'List of Employees by Date Hired', 0, 0, 'C');
		$this->fpdf->Ln(5);
		
		$this->fpdf->Cell(0,6,'As of ' . " " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(10);
		$this->fpdf->SetFillColor(210,210,210);
		$this->fpdf->Cell(20);		
		$this->fpdf->Cell(10,5,"No.",1,0,'L',1);		
		$this->fpdf->Cell(100,5,"Employee",1,0,'L',1);		
		$this->fpdf->Cell(50,5,"Date Hired ",1,0,'C',1);
		
		
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(20);	
		$this->fpdf->Cell(160,5," ",1,0,'L');
		$this->fpdf->Ln(5);
		
		$rs=$this->getSQLData($arrData['strAppStatus']);
		
		

		$intCounter = 0;
		$ctr=0;
		$this->fpdf->SetFont('Arial','',10);
		foreach($rs as $arrEmpDateHired):
			$strMidName = $arrEmpDateHired['middlename'];
			$strMiddleName = substr($strMidName, 0,1);
			$strEmpName = $arrEmpDateHired['surname']. ",  ".$arrEmpDateHired['firstname']." ".$arrEmpDateHired['nameExtension']. 
			" ".str_replace('.','',$arrEmpDateHired['middleInitial']).".";
			$strEmpName = utf8_decode($strEmpName);
			$strFirstDayAgency = $arrEmpDateHired['firstDayAgency'];
		
			//$this->SetFont(Arial,'B',10);
			if($strFirstDayAgency!='0000-00-00')
			{
				$ctr=$ctr+1;
				$this->fpdf->Cell(20);	
				$this->fpdf->Cell(10,5,$ctr,1,0,'L');	
				$this->fpdf->Cell(100,5,$strEmpName,1,0,'L');		
				$this->fpdf->Cell(50,5,date('F j, Y',strtotime($strFirstDayAgency)),1,0,'C');
				$this->fpdf->Ln(5);
			}
						
			/*
			if ($intCounter==39){
				$this->AddPage();
				$intCounter=0;
			}
			*/
			
			$intCounter++;
		endforeach;
			
		if($this->fpdf->GetY()>195)
			 $this->fpdf->AddPage();
			 
			//$obj = new signatoryName();
			//$arrSig = $obj->createSignatory('RPDHD');
			
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
/* End of file ListEmployeesDateHired_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesDateHired_model.php */