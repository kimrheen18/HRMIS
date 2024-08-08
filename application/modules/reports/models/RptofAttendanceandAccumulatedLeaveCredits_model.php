<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class RptofAttendanceandAccumulatedLeaveCredits_model extends CI_Model {

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');	
		//ini_set('display_errors','On');
		//$this->load->model(array());
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
	
	function generate($arrData)
	{
		$pdf = new FPDF('L','mm','Legal');
		$this->fpdf->SetLeftMargin(25);
		$this->fpdf->SetRightMargin(25);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Ln(10);

		$arrGet = $this->input->get();
		$today = date("F j, Y");
		// $dtmMonth = $arrData['dtmMonth'];
		// $dtmYear = $arrData['dtmYear'];
		//$t_dtmRcvDate = $arrData['dtReceivedDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtReceivedMonth'].'-'.date('d')))." ".$arrData['dtReceivedYear'];
		//$t_dtmLtrDate = $arrData['dtLetterDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtLetterMonth'].'-'.date('d')))." ".$arrData['dtLetterYear'];
		//$t_dtmAcptDate = $arrData['dtAcceptedDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtAcceptedMonth'].'-'.date('d')))." ".$arrData['dtAcceptedYear'];

		$rs = $this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'');
		foreach($rs as $t_arrEmpInfo):
			$this->fpdf->AddPage('L','','A4');
			$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
			$strName = $t_arrEmpInfo['firstname']." ".mi($t_arrEmpInfo['middleInitial']).$t_arrEmpInfo['surname'].$extension;
			
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 8);
			$this->fpdf->Cell(0, 5, "REPORT OF ATTENDANCE AND ACCUMULATED LEAVE CREDITS", 0, 0, "C");
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(0, 5, "For the month of :", 0, 0, "C");
			$this->fpdf->Ln(10);
			$this->fpdf->Cell(0, 5, "The record of Human Resource Management Unit show that for the month of , the division's staff had incurred tardiness/undertime/half-days/absences and certified in their favor the accumulated ", 0, 0, "L");
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(0, 5, "vacation leave and sick leave as follows:", 0, 0, "L");
			$this->fpdf->Ln(10);

			// table 
			$this->fpdf->SetFillColor(180,180,180);
			$this->fpdf->SetFillColor(180,180,180);					
			$this->fpdf->SetWidths(array(185));
			$this->fpdf->SetAligns(array('C'));
			$this->fpdf->SetFillColor(210,210,210);

			$this->fpdf->SetFont('Arial', "B", 6);
			$this->fpdf->Cell(55,5,"","LTR",0,'C',1);
			$this->fpdf->Cell(64,5,"MONTH1","TL",0,'C',1);
			$this->fpdf->Cell(64,5,"MONTH2","TL",0,'C',1);
			$this->fpdf->Cell(64,5,"MONTH3","TRL",0,'C',1);
			$this->fpdf->Ln(4);

			$this->fpdf->SetFont('Arial', "B", 6);
			$this->fpdf->Cell(55,5,"","LTR",0,'C',1);
			$this->fpdf->Cell(20,5,"# of Days","TL",0,'C',1);
			$this->fpdf->Cell(14,5,"# of Abs",1,0,'C',1);
			$this->fpdf->Cell(30,5,"Leave Credits",1,0,'C',1);
			$this->fpdf->Cell(20,5,"# of Days","TL",0,'C',1);
			$this->fpdf->Cell(14,5,"# of Abs",1,0,'C',1);
			$this->fpdf->Cell(30,5,"Leave Credits",1,0,'C',1);
			$this->fpdf->Cell(20,5,"# of Days","TL",0,'C',1);
			$this->fpdf->Cell(14,5,"# of Abs",1,0,'C',1);
			$this->fpdf->Cell(30,5,"Leave Credits",1,0,'C',1);
			$this->fpdf->Ln(4);

			$this->fpdf->SetFont('Arial', "B", 6);
			$this->fpdf->Cell(55,5,"EMPLOYEE NAME",1,0,'C',1);
			$this->fpdf->Cell(15,5,"TR/UT",1,0,'C',1);
			$this->fpdf->Cell(5,5,"HD",1,0,'C',1);
			$this->fpdf->Cell(7,5,"VL",1,0,'C',1);
			$this->fpdf->Cell(7,5,"SL",1,0,'C',1);
			$this->fpdf->Cell(15,5,"VL",1,0,'C',1);
			$this->fpdf->Cell(15,5,"SL",1,0,'C',1);
			$this->fpdf->Cell(15,5,"TR/UT",1,0,'C',1);
			$this->fpdf->Cell(5,5,"HD",1,0,'C',1);
			$this->fpdf->Cell(7,5,"VL",1,0,'C',1);
			$this->fpdf->Cell(7,5,"SL",1,0,'C',1);
			$this->fpdf->Cell(15,5,"VL",1,0,'C',1);
			$this->fpdf->Cell(15,5,"SL",1,0,'C',1);
			$this->fpdf->Cell(15,5,"TR/UT",1,0,'C',1);
			$this->fpdf->Cell(5,5,"HD",1,0,'C',1);
			$this->fpdf->Cell(7,5,"VL",1,0,'C',1);
			$this->fpdf->Cell(7,5,"SL",1,0,'C',1);
			$this->fpdf->Cell(15,5,"VL",1,0,'C',1);
			$this->fpdf->Cell(15,5,"SL",1,0,'C',1);
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 6);
			$this->fpdf->Cell(55,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Cell(5,5,"",1,0,'C');
			$this->fpdf->Cell(7,5,"",1,0,'C');
			$this->fpdf->Cell(7,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Cell(5,5,"",1,0,'C');
			$this->fpdf->Cell(7,5,"",1,0,'C');
			$this->fpdf->Cell(7,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Cell(5,5,"",1,0,'C');
			$this->fpdf->Cell(7,5,"",1,0,'C');
			$this->fpdf->Cell(7,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Cell(15,5,"",1,0,'C');
			$this->fpdf->Ln(5);
			
			$this->fpdf->Ln(5);

			$this->fpdf->Ln(10);
			$this->fpdf->SetFont('Arial', "B", 8);
			$this->fpdf->Cell(0, 5, "CERTIFIED CORRECT", 0, 1, "C");
			$this->fpdf->SetFont('Arial', "", 8);
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(120, 5, $today, 0, 0, "C");
			$this->fpdf->SetFont('Arial', "B", 8);
			$this->fpdf->Cell(120, 5, "RAUL D. DUMOL, DPA", 0, 0, "C");
			$this->fpdf->SetFont('Arial', "", 8);
			$this->fpdf->Ln(4);
			$this->fpdf->Cell(120, 5, "Date", 0, 0, "C");
			$this->fpdf->Cell(120, 5, "Chief Administrative Officer", 0, 0, "C");
			$this->fpdf->Ln(5);
		
			
		endforeach;
		 
		echo $this->fpdf->Output();
	}
	
	function getSQLData($t_strEmpNmbr="")
	{
	
		if($t_strEmpNmbr!='')
			$this->db->where('tblEmpPersonal.empNumber',$t_strEmpNmbr);
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
			'tblAppointment.appointmentCode=tblEmpPosition.appointmentCode ','left');
		$this->db->order_by('tblEmpPersonal.surname, tblEmpPersonal.firstname');
		$objQuery = $this->db->get('tblEmpPersonal');
		return $objQuery->result_array();
	
	}

	function getCriteriaData($t_strEmpNmbr="")
	{
		$criteria = strtr($_GET['criteria'],' ','%');
		$sql = "Select tblEmpTraining.* from tblEmpTraining 
										 LEFT JOIN tblEmpPosition ON tblEmpTraining.empNumber = tblEmpPosition.empNumber WHERE tblEmpPosition.statusOfAppointment = 'In-Service' AND ( tblEmpPosition.detailedfrom='2' OR  tblEmpPosition.detailedfrom='0')
										AND tblEmpTraining.trainingDesc like '%".$criteria."%' 
										  Order by tblEmpTraining.trainingDesc";	
		$cn= new MySQLHandler2;
		$cn->init();
		$rs=$cn->Select($sql);
		return $rs;		
	}
	
}
/* End of file Reminder_renewal_model.php */
/* Location: ./application/models/reports/Reminder_renewal_model.php */