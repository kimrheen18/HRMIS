<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ComparativeAnalysisOfCandidatesQualifications_model extends CI_Model {

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
		
		$this->fpdf->SetLeftMargin(20);
		$this->fpdf->SetRightMargin(20);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Ln(10);

		$arrGet = $this->input->get();
		
		//$t_dtmRcvDate = $arrData['dtReceivedDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtReceivedMonth'].'-'.date('d')))." ".$arrData['dtReceivedYear'];
		//$t_dtmLtrDate = $arrData['dtLetterDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtLetterMonth'].'-'.date('d')))." ".$arrData['dtLetterYear'];
		//$t_dtmAcptDate = $arrData['dtAcceptedDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtAcceptedMonth'].'-'.date('d')))." ".$arrData['dtAcceptedYear'];

		$rs = $this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		foreach($rs as $t_arrEmpInfo):
			$this->fpdf->AddPage('L','','A4');
			$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
			$strName = $t_arrEmpInfo['firstname']." ".mi($t_arrEmpInfo['middleInitial']).$t_arrEmpInfo['surname'].$extension;
			
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "B", 8);
			$this->fpdf->Cell(0, 5, "Republic of the Philippines", 0, 0, "C");
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF SCIENCE AND TECHNOLOGY", 0, 0, "C");
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(0, 5, "General Santos Ave., Bicutan, Taguig City", 0, 0, "C");
			$this->fpdf->Ln(10);
			$this->fpdf->SetFont('Arial', "BU", 8);
			$this->fpdf->Cell(0, 5, "COMPARATIVE ANALYSIS OF CANDIDATES' QUALIFICATION", 0, 1, "C");
			$this->fpdf->SetFont('Arial', "B", 8);
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(0, 5, "POSITION CONSIDERED: ", "LTRB", 0, "L");
			$this->fpdf->SetFont('Arial', "B", 8);
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(0, 5, "QUALIFICATION STANDARDS: ", "LTRB", 0, "L");
			$this->fpdf->SetFont('Arial', "", 8);
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(0, 7, "Educational Requirement: ", "LR", 0, "L");
			$this->fpdf->Ln(7);
			$this->fpdf->Cell(0, 7, "Experience Requirement: ", "LR", 0, "L");
			$this->fpdf->Ln(7);
			$this->fpdf->Cell(0, 7, "Eligibility Requirement: ", "LR", 0, "L");
			$this->fpdf->Ln(7);
			$this->fpdf->Cell(0, 7, "Training Requirement: ", "LBR", 0, "L");
			
			$this->fpdf->SetFont('Arial', "", 10);
			$this->fpdf->Ln(5);
					$this->fpdf->Ln(5);
					$this->fpdf->SetFont('Arial','B',8);
						
					$this->fpdf->SetWidths(array(185));
					$this->fpdf->SetAligns(array('C'));
					$this->fpdf->Cell(65,5,"CANDIDATES",1,0,"C");
					$this->fpdf->Cell(64,5,"",1,0,"C");
					$this->fpdf->Cell(64,5,"",1,0,"C");
					$this->fpdf->Cell(64,5,"",1,0,"C");
					$this->fpdf->Ln(5);	

					// $empQuery = mysql_query("Select tblEmpPersonal.firstname,tblEmpPersonal.surname,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension from tblEmpPersonal INNER JOIN 
					// tblEmpPosition ON tblEmpPersonal.empNumber = tblEmpPosition.empNumber WHERE
					// tblEmpPersonal.empNumber='".$rs[$i]['empNumber']."'
					//  AND  tblEmpPosition.statusOfAppointment = 'In-Service' AND ( tblEmpPosition.detailedfrom='2' OR  tblEmpPosition.detailedfrom='0') 
					// ");
					//$empArr = mysql_fetch_array($empQuery);
					// $extension = (trim($empArr['nameExtension'])=='') ? "" : " ".$empArr['nameExtension'] ;
					// $name = $empArr['firstname']." ".$empArr['middleInitial'].". ".$empArr['surname'].$extension;
					
					$this->fpdf->SetWidths(array(55,30,20,40,40));
					$this->fpdf->SetAligns(array('L','C','C','L','L'));
					// $this->fpdf->Row(array($name,$rs[$i]['trainingStartDate'].' - '.$rs[$i]['trainingEndDate'],$rs[$i]['trainingHours'],$rs[$i]['trainingVenue'],$rs[$i]['trainingConductedBy']), 1);
					$this->fpdf->Row(array());
			
		endforeach;
		 
		echo $this->fpdf->Output();
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