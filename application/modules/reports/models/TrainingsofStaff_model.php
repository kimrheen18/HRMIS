<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TrainingsofStaff_model extends CI_Model {

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
	
	function getSQLData($t_strEmpNmbr="",$t_strOfc="")
	{
		if($t_strEmpNmbr!='')
			$this->db->where('tblEmpPersonal.empNumber',$t_strEmpNmbr);
		if($t_strOfc!='')
			$this->db->where('tblEmpPosition.group3',$t_strOfc);
		
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname, 
			tblEmpPersonal.firstname, tblEmpPersonal.middlename,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension, tblEmpPersonal.sex, 
			tblPosition.positionDesc, 
			tblEmpPersonal.comTaxNumber, tblEmpPersonal.issuedAt, 
			tblEmpPersonal.issuedOn, tblEmpPosition.positionDate,tblAppointment.appointmentDesc,
			tblEmpPosition.firstDayAgency');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
		$this->db->join('tblAppointment',
			'tblEmpPosition.appointmentCode = tblAppointment.appointmentCode','left');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->order_by('tblEmpPersonal.surname, tblEmpPersonal.firstname');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->SetLeftMargin(30);
		$this->fpdf->SetRightMargin(30);
		$this->fpdf = new FPDF('L','mm','A4');
		$this->fpdf->AliasNbPages();
		$this->fpdf->Open();

		$t_DateFrom = $arrData['dtmATrainDayFrm']." ".date('F',strtotime(date('Y').'-'.$arrData['dtmTrainMonthFrm'].'-'.date('d')))." ".$arrData['dtmTrainYearFrm'];
		$t_DateTo = $arrData['dtmATrainDayTo']." ".date('F',strtotime(date('Y').'-'.$arrData['dtmTrainMonthTo'].'-'.date('d')))." ".$arrData['dtmTrainYearTo'];

		$rs=$this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		foreach($rs as $t_arrEmpInfo):
			$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
			$strName = $t_arrEmpInfo['firstname']." ".mi($t_arrEmpInfo['middleInitial']).$t_arrEmpInfo['surname'].$extension;
			$this->fpdf->AddPage();			
			
			$this->fpdf->Ln(10);						
			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "Department of Science and Technology", 0, 0, "C");	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 8);
			$this->fpdf->Cell(0, 5, "General Santos Ave., Bicutan, Taguig City", 0, 0, "C");	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 8);
			$this->fpdf->Cell(0, 5, "Telephone : 8372071-82 - Facsimile 8372937", 0, 0, "C");	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 8);
			$this->fpdf->Cell(0, 5, "Email : Website : www.dost.dov.ph", 0, 0, "C");	
			$this->fpdf->Ln(20);
			$this->fpdf->SetFont('Arial', "B", 10);
			$this->fpdf->Cell(0, 5, "TRAININGS OF STAFF", 0, 0, "C");	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 8);
			$this->fpdf->Cell(0, 5, "For the month of, ".$t_DateFrom, 0, 0, "C");	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 7);
			$this->fpdf->Cell(0, 5, "Prepared by : ".$strName, 0, 0, "R");	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 7);
			$this->fpdf->Cell(0, 5, "Desgination : ".$t_arrEmpInfo['positionDesc'], 0, 0, "R");	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 7);
			$this->fpdf->Cell(0, 5, "Date : ".$t_DateTo, 0, 0, "R");	
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial', "B", 7);
			$this->fpdf->Cell(60, 5, "Training Title", "LTRB", 0, "C");	
			$this->fpdf->Cell(40, 5, "Period of Training", "LTRB", 0, "C");	
			$this->fpdf->Cell(40, 5, "Place", "LTRB", 0, "C");	
			$this->fpdf->Cell(40, 5, "Training conducted by", "LTRB", 0, "C");	
			$this->fpdf->Cell(35, 5, "Employee Name", "LTRB", 0, "C");	
			$this->fpdf->Cell(30, 5, "Office", "LTRB", 0, "C");	
			$this->fpdf->Cell(0, 5, "Training Cost", "LTRB", 0, "C");	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 7);
			$this->fpdf->Cell(60, 5, "", "LTRB", 0, "C");	
			$this->fpdf->Cell(40, 5, "", "LTRB", 0, "C");	
			$this->fpdf->Cell(40, 5, "", "LTRB", 0, "C");	
			$this->fpdf->Cell(40, 5, "", "LTRB", 0, "C");	
			$this->fpdf->Cell(35, 5, "", "LTRB", 0, "C");	
			$this->fpdf->Cell(30, 5, "", "LTRB", 0, "C");	
			$this->fpdf->Cell(0, 5, "", "LTRB", 0, "C");

			$this->fpdf->MultiCell(0, 6, "", 0, 'J', 0);			
			$this->fpdf->Ln(5);
			$this->fpdf->MultiCell(0, 6, "", 0, 'J', 0);			
			$this->fpdf->Ln(5);
			$this->fpdf->MultiCell(0, 6, "", 0, 'J', 0);
			//$group = mysql_query("SELECT  * FROM tblGroup WHERE groupCode = 'LAG00'");
			//$arrGroup=mysql_fetch_array($group);
		
		endforeach;
		echo $this->fpdf->Output();
	}
	
}
/* End of file CertificateServiceLoyaltyAward.php */
/* Location: ./application/models/reports/CertificateServiceLoyaltyAward.php */