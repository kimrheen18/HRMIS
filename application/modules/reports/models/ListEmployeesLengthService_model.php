<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEmployeesLengthService_model extends CI_Model {

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
		
		//$strAppStatus = $_GET['cboAppointmentStatus'];
		$this->db->select('tblEmpPersonal.empNumber,tblEmpPersonal.surname,tblEmpPersonal.firstname,tblEmpPersonal.middlename,tblEmpPersonal.nameExtension,
			tblEmpPosition.firstDayAgency,tblEmpPosition.statusOfAppointment, tblEmpPosition.firstDayGov, tblPosition.positionDesc');
		
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		if($strAppStatus!='')
			$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
		
		$this->db->order_by('tblEmpPosition.firstDayGov ASC, tblEmpPersonal.surname ASC, tblEmpPersonal.firstname ASC, tblEmpPersonal.middlename ASC');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->SetFont('Arial','B',20);
		
		$this->fpdf->Cell(25,0,"",0,0,'L');
		
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(25,0,"",0,0,'L');
		$this->fpdf->Ln(15);
		$this->fpdf->SetFont('Arial','B',12);
		//$head = new title();
		$this->fpdf->Cell(0,2,strtoupper('list of employees by length of service'), 0, 0, 'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,2,'As of '.date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','B',9);

		
		$this->fpdf->SetFillColor(200,200,200);

		$w = array(70,20,100);
		$Ln = array('C','C','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->Cell($w[0],5,"",'TLR',0,'C',1);
		$this->fpdf->Cell($w[1],5,"# OF",'TLR',0,'C',1);
		$this->fpdf->Cell($w[2],5,"",'TLR',0,'C',1);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell($w[0],5,"NAME",'BLR',0,'C',1);		
		$this->fpdf->Cell($w[1],5,"YEARS",'BLR',0,'C',1);
		$this->fpdf->Cell($w[2],5,"OFFICE - POSITION",'BLR',0,'C',1);
				
		$this->fpdf->Ln(5);
		$query = $this->getSQLData($arrData['strAppStatus']);
		$this->fpdf->SetFont('Arial','',9);
		$this->fpdf->SetFillColor(255,255,255);
		$this->fpdf->SetDrawColor(0,0,0);
		foreach($query as $row)
		//while ($row = mysql_fetch_array($query))
		{
			$name = $row['surname'].", ".$row['firstname']." ".$row['nameExtension']." ".mi($row['middlename']);
			//list($year,$month,$day)=split('[/,-]',$row['firstDayGov']);
			$arrTmpDate = explode('-',$row['firstDayGov']);
			$year=$arrTmpDate[0];
			$month=$arrTmpDate[1];
			$day=$arrTmpDate[2];
			$current = date('Y');
			$total = $year!="0000"?$current - $year:"-";
			//$office = new General();
			$strOffice = office_name(employee_office($row['empNumber']));
			$strOfficePosition = $strOffice.' - '.$row['positionDesc'];

			//$w = array(60,25,20,85);
			$w = array(70,20,100);
			//$Ln = array('L','C','C','C');
			$Ln = array('C','C','C');
			$this->fpdf->SetWidths($w);
			$this->fpdf->SetAligns($Ln);

			$firstDay=$row['firstDayGov']!="0000-00-00"?$row['firstDayGov']:"-";
			//$this->Row(array($name,$firstDay,$total,$strOfficePosition),1);
			if($firstDay=="")
			{
				$this->fpdf->FancyRow(array($name,'None',$strOfficePosition),array(1,1,1));	
			}else{
				$this->fpdf->FancyRow(array($name,$total,$strOfficePosition),array(1,1,1));		
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
/* End of file ListEmployeesLengthService_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesLengthService_model.php */