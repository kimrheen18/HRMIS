<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AcceptanceResignation_model extends CI_Model {

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
		
		$this->fpdf->SetLeftMargin(25);
		$this->fpdf->SetRightMargin(25);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Ln(10);

		$arrGet = $this->input->get();
		
		$t_dtmLtrDate = $arrData['dtLetterDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtLetterMonth'].'-'.date('d')))." ".$arrData['dtLetterYear'];
		$t_dtmRcvDate = $arrData['dtReceivedDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtReceivedMonth'].'-'.date('d')))." ".$arrData['dtReceivedYear'];
		$t_dtmAcptDate = $arrData['dtAcceptedDay']." ".date('F',strtotime(date('Y').'-'.$arrData['dtAcceptedMonth'].'-'.date('d')))." ".$arrData['dtAcceptedYear'];

		$rs = $this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		foreach($rs as $t_arrEmpInfo):
			$this->fpdf->AddPage('P','','A4');
			$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
			$strName = $t_arrEmpInfo['firstname']." ".mi($t_arrEmpInfo['middleInitial']).$t_arrEmpInfo['surname'].$extension;
			$strName = utf8_decode($strName);
			$this->fpdf->Ln(30);
			$this->fpdf->SetFont('Arial', "BU", 16);
			//$this->Cell(0, 5, "A C C E P T A N C E  O F  R E S I G N A T I O N", 0, 0, "C");
			$this->fpdf->Ln(20);
					
			$this->fpdf->SetFont('Arial', "", 12);	
			$this->fpdf->Cell(0, 5, date("d F Y"), 0, 0, "L");


			$this->fpdf->Ln(20);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Cell(0, 5, $strName, 0, 1, "L");
			$this->fpdf->Cell(0, 5, $t_arrEmpInfo['positionDesc'], 0, 0, "L");
			$this->fpdf->Ln();
			
			$this->fpdf->Cell(0, 5, trim(office_name(employee_office($t_arrEmpInfo['empNumber']))), 0, 0, "L");
			$this->fpdf->Ln(15);
			
			
			
			$this->fpdf->Cell(0, 5, getSalutation($t_arrEmpInfo['sex']).":", 0, 0, "L");
			

			$strPrgrph1 = "In reply to your letter of ".$t_dtmLtrDate  
						." which we received last ".$t_dtmRcvDate 
						.", opting for resignation from the position of ".$t_arrEmpInfo['positionDesc']
						." in this Office, please be advised that the same is hereby ";
			$strPrgrph2 = "accepted";
			$strPrgrph3 = " to take effect ";
			$strPrgrph4 = " at the close of the office hours on ".$t_dtmAcptDate.".";        
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Write(5,$strPrgrph1);
			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Write(5,$strPrgrph2);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Write(5,$strPrgrph3);
			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Write(5,$strPrgrph4);
			$this->fpdf->SetFont('Arial', "", 12);

			$this->fpdf->Ln(20);
			$this->fpdf->Cell(0,10,"Very truly yours,",0,0,'L');
				
			//$obj = new signatoryName();
			//$arrSig = $obj->createSignatory('AR');
			$this->fpdf->Ln(20);
			//$this->Cell(130);		
			$this->fpdf->SetFont('Arial','',12);		
			//$sig=explode('|',PD);
			$sig=getSignatories($arrGet['intSignatory']);
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
			//$this->fpdf->Cell(0,10,$sig[1],0,0,'L');
			$this->fpdf->Cell(0,10,$sigName,0,0,'L');

			$this->fpdf->Ln(5);
			//$this->Cell(130);		
			$this->fpdf->Cell(0,10,$sigPos,0,0,'L');
			$this->fpdf->Cell(0,10,'',0,0,'L');
			
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial','',11);		
			$this->fpdf->Cell(0,10,"Copy furnished:",0,0,'L');
			$this->fpdf->Ln(7);
			$this->fpdf->Cell(0,10,"Civil Service Commision",0,0,'L');
			
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
	
}
/* End of file Reminder_renewal_model.php */
/* Location: ./application/models/reports/Reminder_renewal_model.php */