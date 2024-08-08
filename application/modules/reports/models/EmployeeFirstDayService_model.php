<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EmployeeFirstDayService_model extends CI_Model {

	var $w=array(70,70,60,60);

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');
		//$this->fpdf->FPDF('L', 'mm', 'A');	
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
		$this->db->select('tblEmpPersonal.empNumber,tblEmpPersonal.surname, tblEmpPersonal.firstname,tblEmpPersonal.middleInitial, tblEmpPersonal.middlename,tblEmpPersonal.nameExtension,tblEmpPosition.statusOfAppointment, tblEmpPosition.firstDayAgency,tblEmpPosition.firstDayGov');
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->where("(tblEmpPosition.detailedfrom='2' OR tblEmpPosition.detailedfrom='0')");
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('tblEmpPosition.firstDayGov!=','0000-00-00');
		$this->db->where('tblEmpPosition.firstDayGov!=','');
		$this->db->order_by('tblEmpPosition.firstDayGov ASC, tblEmpPersonal.surname asc, 
				tblEmpPersonal.firstname asc, tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query(); exit(1);
		return $objQuery->result_array();
	}

	function printBody($t_intCounter,$t_strEmpName,$t_strFirstDayGov)
	{		
		$strCmbineName = $t_intCounter. ".  ".$t_strEmpName;
	}

	function generate($arrData)
	{		
		
		$rs=$this->getSQLData();
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->SetMargins(25,25);
		$this->fpdf->SetTextColor(0,0,0);
		$this->fpdf->Ln();
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(0,2,'EMPLOYEES FIRST DAY OF SERVICE', 0, 0, 'C');

//		$this->Cell(0,2,strtoupper('Employees by Educational Attainment'), 0, 0, 'C');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(0,2,'As of' . " " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(5);
		
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->SetFillColor(200,200,200);
		$this->fpdf->Cell(90,10,"",'LTR',0,'C',1);
		$this->fpdf->Cell(70,10,"",'LTR',0,'C',1);
		$this->fpdf->Ln(5);
		
		$this->fpdf->Cell(90,5,"NAME",'LR',0,'C',1);
		$this->fpdf->Cell(70,5,"DATE HIRED",'LR',0,'C',1);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(90,5,"",'LBR',0,'C',1);
		$this->fpdf->Cell(70,5,"",'LBR',0,'C',1);
		$this->fpdf->Ln(5);

		$i =0;
		foreach($rs as $row):
			
			$strEmpNum = $row['empNumber'];
			$strMidName = $row['middlename'];
			$strMiddleName = substr($strMidName, 0,1);			
			$strEmpName = $row['surname']. ",  ".$row['firstname']. " ".$row['nameExtension'].
			" ".(mi($row['middleInitial']));
			$strStatusOfAppointment = $row['statusOfAppointment'];
			$strFirstGov = $row['firstDayGov'];					
			//if($strStatusOfAppointment  == 'In-Service' && $strFirstGov!='0000-00-00')
			//{
				//$intCounter++;
				//$this->printBody(($i+1),$strEmpName,$strFirstGov);			
				$this->fpdf->SetFont('Arial','',10);
				$this->fpdf->Cell(90,5,($i+1).". ".$strEmpName,1,0,'L');
				$this->fpdf->Cell(70,5,date('F j, Y',strtotime($strFirstGov)),1,0,'C');
				$this->fpdf->Ln(5);	
				$i++;
		endforeach;
			
		
		if($this->fpdf->GetY()>195)
			$this->fpdf->AddPage();
			 
		
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
		$this->fpdf->Cell(0,10,"Certified Correct:",0,0,'L');
		
		$this->fpdf->Ln(20);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','B',12);		
		$this->fpdf->Cell(0,10,strtoupper($sigName),0,0,'L');

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
/* End of file ListEducationalAttainment_model.php */
/* Location: ./application/modules/reports/models/reports/ListEducationalAttainment_model.php */