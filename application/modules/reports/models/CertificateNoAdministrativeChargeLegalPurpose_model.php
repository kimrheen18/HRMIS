<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CertificateNoAdministrativeChargeLegalPurpose_model extends CI_Model {

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
			tblEmpPosition.firstDayAgency ');
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
		
		$rs=$this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		
		foreach($rs as $t_arrEmpInfo):
			$this->fpdf->AddPage();
			$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
			$strName = $t_arrEmpInfo['firstname']." ".mi($t_arrEmpInfo['middleInitial']).$t_arrEmpInfo['surname'].$extension;
			//$name = strtoupper($t_arrEmpInfo['surname'].", ".$t_arrEmpInfo['firstname'].$extension." ".$t_arrEmpInfo['middleInitial']);
	
			$strPronoun = pronoun($t_arrEmpInfo['sex']);
			$strPronoun2= pronoun2($t_arrEmpInfo['sex']);
			$title = titleOfCourtesy($t_arrEmpInfo['sex']);
			//list($year,$month,$day)=split('[/,-]',$t_arrEmpInfo['firstDayAgency']);
			// $arrTmpDate = explode('-',$t_arrEmpInfo['firstDayAgency']);
			// $year = $arrTmpDate[0];
			// $month = $arrTmpDate[1];
			// $day = $arrTmpDate[2];
			// $positionDate = intToMonthFull($month)." ".$day.", ".$year;
			$positionDate = date('F j, Y',strtotime($t_arrEmpInfo['firstDayAgency']));
			$year = date('Y',strtotime($t_arrEmpInfo['firstDayAgency']));
			$currYear=date("Y");
			$totalYear=$currYear-$year;
			$tmpYear=$currYear-$year;
			
			$strMonthFull = intToMonthFull($arrData['intMonth']+0);
			//$dayIssued = $_GET['cboDay'];
			$dayIssued = daySuffix($arrData['intDay']+0);
	
			$divisionName = office_name(employee_office($t_arrEmpInfo['empNumber']));
					
			$strPrgrph1 = "     This is to certify that ".strtoupper($strName)
						.", ".$t_arrEmpInfo['positionDesc'].", ".$divisionName
						.", is a ".strtolower($t_arrEmpInfo['appointmentDesc'])." employee of the ".getAgencyName()." and "
						."has been in the service since ".$positionDate." to date.";
		
			$strPrgrph2 = "     It is further certified that as per available records on file, subject employee has no "
						 ."pending administrative case filed against ".strtolower($strPronoun)." as of this date.";
			
			$strPrgrph3 = "     Issued this ".$dayIssued." day of ".$strMonthFull." ".$arrData['intYear']." upon request of ".titleOfCourtesy($t_arrEmpInfo['sex'])." ".strtoupper($t_arrEmpInfo['surname'])
						." for whatever legal purpose it may serve ".strtolower(pronoun($t_arrEmpInfo['sex'])).".";
	
			//$this->printHead();
			$this->fpdf->Ln(40);
			
			
			$this->fpdf->SetFont('Arial', "B", 16);
			$this->fpdf->Cell(0, 5, "C E R T I F I C A T I O N", 0, 0, "C");
	
			$this->fpdf->Ln(20);
			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "TO WHOM IT MAY CONCERN:", 0, 0, "L");
	
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->MultiCell(0, 6, $strPrgrph1, 0, 'J', 0);
			
			$this->fpdf->Ln(5);
			$this->fpdf->MultiCell(0, 6, $strPrgrph2, 0, 'J', 0);
			
			$this->fpdf->Ln(5);
			$this->fpdf->MultiCell(0, 6, $strPrgrph3, 0, 'J', 0);
			
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Cell(3);	
			//$this->Cell(10, 5,"      ". date("d F Y"), 0, 0, "L");
			
			// create date string
			$strMonthFull = intToMonthFull($arrData['intMonth']);
			$dateString = $strMonthFull." ".$arrData['intDay'].",  ".$arrData['intYear'];
			$this->fpdf->Ln(10);
			//$this->Cell(0,5,'    '.$dateString,0,1,'L');
			
			/*$objSgntry = mysql_query("SELECT * FROM tblSignatory WHERE designation = 'Personnel'");
			$arrSgntry = mysql_fetch_array($objSgntry);*/
			
			/*
			$group = mysql_query("SELECT  * FROM tblGroup WHERE groupCode = 'LAG00'");
			$arrGroup=mysql_fetch_array($group);
			*/
			$this->fpdf->Ln(15);	//$this->Cell(130);
	//		$this->Cell(0,0," ");
			//$sig=explode('|',PD);	
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
			$this->fpdf->SetFont('Arial','B',12);
			//$this->Cell(16,0," ",0,0,'L');	
			$this->fpdf->Cell(80);	
			$this->fpdf->Cell(100,0,$sigName,0,0,'C');
			$this->fpdf->Ln(4);	
			$this->fpdf->Cell(80);	
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(100,0,$sigPos,0,0,'C');
			$this->fpdf->Ln(4);	
			$this->fpdf->Cell(80);			
			//$this->fpdf->Cell(100,0,$sig[0],0,0,'C');
	
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Cell(3);	
			$this->fpdf->Cell(10, 5,"      ". date("d F Y"), 0, 0, "L");
			
		
		endforeach;
		echo $this->fpdf->Output();
	}
	
}
/* End of file CertificateNoAdministrativeChargeLegalPurpose_model.php */
/* Location: ./application/models/reports/CertificateNoAdministrativeChargeLegalPurpose_model.php */