<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReportTardiness_model extends CI_Model {

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

	function getSQLData($strEmpNo="",$intMonth="",$intYear="",$t_strOfc="")
	{
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname, tblEmpPersonal.firstname, tblEmpPersonal.middlename,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension, tblEmpPosition.longevityDate, tblEmpPosition.divisionCode, tblEmpPosition.firstDayAgency, tblEmpPosition.itemNumber, tblEmpLeaveBalance.*');
		if($strEmpNo!='')
			$this->db->where('tblEmpPersonal.empNumber',$strEmpNo);
		if($t_strOfc!='')
			$this->db->where('tblEmpPosition.group3',$t_strOfc);
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('tblEmpLeaveBalance.periodMonth',$intMonth);
		$this->db->where('tblEmpLeaveBalance.periodYear',$intYear);
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblEmpLeaveBalance','tblEmpPersonal.empNumber = tblEmpLeaveBalance.empNumber','left');
		$this->db->order_by('tblEmpPersonal.surname, tblEmpPersonal.firstname');
		$objQuery = $this->db->get('tblEmpPersonal');
		// echo $this->db->last_query(); exit(1);
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->Ln(18);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,6,strtoupper("Report on Tardiness"), 0, 0, 'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,6,"As of " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(15);
		
		
		$w = array(70,40,30,25,25);
		$Ln = array('L','L','L','L','L');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		
		$this->fpdf->SetFont('Arial','B',9);
		$this->fpdf->SetFillColor(200,200,200);
		$this->fpdf->Cell($w[0],5,'', 'TLR', 0, 'L',1);
		$this->fpdf->Cell($w[1]+$w[2],5,'TOTAL', 1, 0, 'C',1);
		$this->fpdf->Cell($w[3],5,'# OF TARDY ', 'TLR', 0, 'C',1);		
		$this->fpdf->Cell(0,5,'# OF ', 'TLR', 1, 'C',1);
		
		$this->fpdf->Cell($w[0],5,'EMPLOYEE NAME', 'BLR', 0, 'C',1);
		$this->fpdf->Cell($w[1],5,'Tardy/Undertime', 1, 0, 'C',1);
		$this->fpdf->Cell($w[2],5,'Excess', 1, 0, 'C',1);
		$this->fpdf->Cell($w[3],5,'& UND', 'BLR', 0, 'C',1);
		$this->fpdf->Cell(0,5,'ABSENT', 'BLR', 1, 'C',1);
		//$this->fpdf->Ln(5);
		$Ln = array('L','C','C','C','C');
		$this->fpdf->SetAligns($Ln);

		$objQuery = $this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['dtmMonth'],$arrData['dtmYear'],$arrData['strSelectPer']==2?$arrData['ofc']:'');
		$this->fpdf->SetFont('Arial','',8);
		$ctr=1;
		foreach($objQuery as $arrEmpInfo)
		{
			//$w = array(60,40,30,20,25);
			$Ln = array('L','C','C','C','C');
			$this->fpdf->SetWidths($w);
			$this->fpdf->SetAligns($Ln);
			$extension = (trim($arrEmpInfo['nameExtension'])=="") ? "" : " ".$arrEmpInfo['nameExtension'];		
			$name = $arrEmpInfo['surname'].", ".$arrEmpInfo['firstname'].$extension." ".mi($arrEmpInfo['middleInitial']);
			$name = utf8_decode($name);
			$vltru = $arrEmpInfo['vltrut_wpay'] + $arrEmpInfo['vltrut_wopay'];
			$this->fpdf->FancyRow(array($ctr.'. '.$name, $vltru, $arrEmpInfo['excess'], $arrEmpInfo['trut_notimes'], $arrEmpInfo['nodays_absent']),array(1,1,1,1,1),1);
			$ctr++;
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