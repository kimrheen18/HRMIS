<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListOfRetirees_model extends CI_Model {

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

	function getSQLData()
	{
		$dtmCurYear = date("Y");
		$dtmPrevYear = $dtmCurYear - 60;
		$dtmJanYear = $dtmPrevYear . "-" . "01-01";
		$dtmDecYear = $dtmPrevYear . "-" . "12-31";	
		//$t_intRetireeAge = $dtmCurYear - $t_dtmBdayYear;
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname, tblEmpPersonal.firstname, tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension,
			tblEmpPersonal.birthday, tblEmpPosition.statusOfAppointment, tblPosition.positionDesc');
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber');
		$this->db->join('tblPosition','tblEmpPosition.positionCode = tblPosition.positionCode');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('(tblEmpPosition.detailedfrom="2" OR tblEmpPosition.detailedfrom=0)');
		$this->db->where('tblEmpPersonal.birthday!=','0000-00-00');
		$this->db->where('tblEmpPersonal.birthday<=',$dtmDecYear);
		$this->db->order_by('tblEmpPersonal.surname asc, tblEmpPersonal.firstname asc,tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();exit(1);
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->Ln(18);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,6,strtoupper("list of retirees"), 0, 0, 'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,6,"As of " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(15);
		

		$this->fpdf->SetFillColor("210","210","210");
		$this->fpdf->SetFont('Arial','B',8);
		//$this->Cell(20,5," ",0,0,"L");
		$this->fpdf->Cell(60,7,"EMPLOYEE",1,0,"C",1);
		$this->fpdf->Cell(75,7,"OFFICE - POSITION",1,0,"C",1);
		$this->fpdf->Cell(30,7,"BIRTH DATE",1,0,"C",1);
		$this->fpdf->Cell(30,7,"RETIREMENT DATE",1,0,"C",1);
		$this->fpdf->Ln(7);
		
		
		$objQuery = $this->getSQLData();
		$w = array(60,75,30,30);
		$Ln = array('L','L','C','C');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		$this->fpdf->SetFillColor(255,255,255);
		$this->fpdf->SetFont('Arial','',8);
		$i=1;
		foreach($objQuery as $rs)
		//while($arrSalaryGrade = mysql_fetch_array($objSalaryGrade))
		{
			$name=$rs["surname"].', '.$rs["firstname"].' '.$rs["middleInitial"].". ".$rs["nameExtension"];
			$position = $rs["positionDesc"];
			$arrDate=explode('-',$rs['birthday']);
			$year=$arrDate[0];
			$month=$arrDate[1];
			$day=$arrDate[2];						
			//list($year,$month,$day)=str_split('[/,-]',$rs['birthday']);
			$resignDate = date("Y")."-".$month."-".$day;			
			$strOffice = office_name(employee_office($rs['empNumber']));
			$strOfficePosition = $strOffice.' - '.$rs["positionDesc"];
			$this->fpdf->FancyRow(array($i.'. '.$name,$strOfficePosition,date('F j, Y',strtotime($rs['birthday'])), date('F j, Y',strtotime($resignDate))),array(1,1,1,1),1);
			$i++;
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