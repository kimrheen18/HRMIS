<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEmployeesTraining_model extends CI_Model {

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

	function getSQLData($strEmpNo="")
	{
		$this->db->select('tblEmpTraining.*');
		if($strEmpNo!='')
			$this->db->where('tblEmpTraining.empNumber',$strEmpNo);
		$this->db->order_by('tblEmpTraining.trainingStartDate desc');
		$objQuery = $this->db->get('tblEmpTraining');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->Ln(18);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,6,strtoupper("list of employees' training"), 0, 0, 'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,6,"As of " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(15);
		
		$arrEmpName = employee_name($arrData['empno']);

		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(50, 10, "Employee Number : ", 0, 0, 'R');
		$this->fpdf->SetFont('Arial','',10);		
		$this->fpdf->Cell(0, 10, $arrData['empno'], 0, 0, 'L');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(50, 10, "Name : ", 0, 0, 'R');
		$this->fpdf->SetFont('Arial','',10);		
		$this->fpdf->Cell(0, 10, $arrEmpName, 0, 0, 'L');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(50, 10, "Position : ", 0, 0, 'R');
		$this->fpdf->SetFont('Arial','',10);
		$arrEmpDetails = employee_details($arrData['empno']);
		//print_r($arrEmpDetails); exit(1);		
		$this->fpdf->Cell(0, 10, $arrEmpDetails[0]['positionDesc'], 0, 0, 'L');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(50, 10, "Office : ", 0, 0, 'R');
		$this->fpdf->SetFont('Arial','',10);
		$strOffice = office_name(employee_office($arrData['empno']));	
		$this->fpdf->Cell(0, 10, $strOffice, 0, 0, 'L');
		$this->fpdf->Ln(5);
		
		//$strOfficePosition = $strOffice.' - '.$arrEmp["positionDesc"];

		// $this->fpdf->SetFont('Arial','B',10);
		// $this->fpdf->SetFillColor(150,150,150);
		// $this->fpdf->Cell(70,6,"EMPLOYEE NAME",1,0,'C',1);
		// $this->fpdf->Cell(85,6,"OFFICE - POSITION",1,0,'C',1);
		// $this->fpdf->Cell(30,6,"SALARY GRADE",1,0,'C',1);
		// $this->fpdf->Ln(6);
		$this->fpdf->Ln(5);
		$strPrgrph1 = "     This is to certify that the employee here in above has"
					." attended the following training(s):";
		$this->fpdf->MultiCell(0, 6, $strPrgrph1, 0, 'J', 0);

		$objQuery = $this->getSQLData($arrData['empno']);
		$this->fpdf->SetFillColor(255,255,255);
		$this->fpdf->SetDrawColor(0,0,0);
		$this->fpdf->SetFont('Arial','',10);

		$this->fpdf->Cell(60, 5, 'Training Title', 'TB', 0, 'C');
		$this->fpdf->Cell(35, 5, 'Period of Training', 'TB', 0, 'C');
		$this->fpdf->Cell(15, 5, 'Hours', 'TB', 0, 'C');		
		//$this->Cell(15, 5, 'Cost', 0, 0, 'C');		
		$this->fpdf->Cell(35, 5, 'Conducted by', 'TB', 0, 'C');		
		$this->fpdf->Cell(45, 5, 'Venue', 'TB', 0, 'C');	
		$this->fpdf->Ln(5);

		$this->fpdf->SetWidths(array(60, 35, 15, 35, 45));
		$this->fpdf->SetAligns(array("L", "C", "R", "L", "L"));
		foreach($objQuery as $arrEmpData)
		//while($arrSalaryGrade = mysql_fetch_array($objSalaryGrade))
		{
			$strPeriod = date("m/d/y",strtotime($arrEmpData["trainingStartDate"]))
						."-".date("m/d/y",strtotime($arrEmpData["trainingEndDate"]));
			$this->fpdf->Row(array($arrEmpData["trainingDesc"], $strPeriod, $arrEmpData["trainingHours"], $arrEmpData["trainingConductedBy"], $arrEmpData["trainingVenue"]), 0);
		}
		$this->fpdf->Cell(0, 5, '', 'B', 0, 'C');	
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
/* End of file ListEmployeesTraining_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesTraining_model.php */