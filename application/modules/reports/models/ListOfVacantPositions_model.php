<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListOfVacantPositions_model extends CI_Model {

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

	function getplantilla()
	{
		$this->db->select('DISTINCT (itemNumber),positionCode,salaryGrade');
		$this->db->order_by('itemNumber ASC, salaryGrade DESC');
		return $this->db->get('tblPlantilla')->result_array();
	}

	function getposition($strCode)
	{
		$this->db->select('positionDesc');
		$this->db->where('positionCode',$strCode);
		$rs = $this->db->get('tblPosition')->result_array();
		return count($rs)>0?$rs[0]['positionDesc']:'';
	}

	function getSQLData($itemNumber)
	{
		

		$this->db->select('tblEmpPersonal.empNumber, tblEmpPosition.itemNumber, tblEmpPosition.divisionCode,
										tblEmpPosition.statusOfAppointment');
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');
		
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('(tblEmpPosition.detailedfrom="2" OR tblEmpPosition.detailedfrom=0)');
		
		$this->db->where('tblEmpPosition.itemNumber',$itemNumber);
		$this->db->order_by('tblEmpPosition.itemNumber asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();exit(1);
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->Ln(18);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,6,strtoupper("list of vacant position(s)"), 0, 0, 'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,6,"As of " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(15);
		

		$this->fpdf->SetFillColor("210","210","210");
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(40,5," ",0,0,"L");
		$this->fpdf->Cell(60,5,"ITEM NUMBER",1,0,"L",1);
		$this->fpdf->Cell(80,5,"POSITION TITLE",1,0,"L",1);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(40,5," ",0,0,"L");
		$this->fpdf->Cell(140,5," ",1,0,"L");
		$this->fpdf->Ln(5);	
		
		$objQuery = $this->getplantilla();
		//$objQuery = $this->getSQLData();
		$w = array(60,75,30,30);
		$Ln = array('L','L','C','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->SetFillColor(255,255,255);
		$this->fpdf->SetFont('Arial','',10);
		foreach($objQuery as $row)
		//while($arrSalaryGrade = mysql_fetch_array($objSalaryGrade))
		{
			$itemNumber = $row['itemNumber'];
			$positionCode = $row['positionCode'];
			$rs = $this->getSQLData($itemNumber);

			if(count($rs)==0)
			{
				$this->fpdf->Cell(40,5," ",0,0,"L");
				$this->fpdf->Cell(60,5,$itemNumber,1,0,"L");
				$strPosDesc = $this->getposition($positionCode);
				
				
				$this->fpdf->Cell(80,5,$strPosDesc,1,0,"L");
				$this->fpdf->Ln(5);
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
/* End of file ListEmployeesTraining_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesTraining_model.php */