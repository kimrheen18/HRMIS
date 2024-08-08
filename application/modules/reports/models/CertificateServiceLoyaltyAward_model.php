<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CertificateServiceLoyaltyAward_model extends CI_Model {

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
		
		$rs=$this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		
		foreach($rs as $t_arrEmpInfo):
			$this->fpdf->AddPage();
			$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
			$name = $t_arrEmpInfo['firstname']." ".mi($t_arrEmpInfo['middleInitial']).$t_arrEmpInfo['surname'].$extension;			
			$strPronoun = pronoun($t_arrEmpInfo['sex']);
			$strPronoun2= pronoun2($t_arrEmpInfo['sex']);
			$title = titleOfCourtesy($t_arrEmpInfo['sex']);
			$arrTmpDate = explode('-',$t_arrEmpInfo['firstDayAgency']);
			$year = $arrTmpDate[0];
			$month = $arrTmpDate[1];
			$day = $arrTmpDate[2];
			$currYear=date("Y");
			$totalYear=$currYear-$year;
			$tmpYear=$currYear-$year;			
			if($totalYear==10 || $totalYear==20 || $totalYear==30 || $totalYear==40 || $totalYear==50 || $totalYear==60)
			{
				
				$totalYear=$totalYear/10;
				$nthYear=numOrder($totalYear);
				
				
				$strPrgrph3 = "     This certification is being issued upon request of ".$title." ".$t_arrEmpInfo['surname']." "
						." for purposes of claiming ".strtolower($strPronoun2)." ".strtolower($nthYear)." ten (10) years continuous satisfactory service " 
						."(LOYALTY CASH AWARD) from ".date("d F Y",mktime(0,0,0,$month,$day,$year))." to ".date("d F Y").".";
			}
			else
			{
	
				$tmpYear=$currYear-$year;
				$strPrgrph3 = $strPrgrph3 = "     This certification is being issued upon request of ".$title." ".$t_arrEmpInfo['surname']." "
						." for purposes of claiming ".strtolower($strPronoun2)." additional five (5) years continuous satisfactory service equivalent to ".$tmpYear
						." years (LOYALTY CASH AWARD) from ".date("d F Y",mktime(0,0,0,$month,$day,$year))." to ".date("d F Y").".";
	
			}		
			$divisionName = office_name(employee_office($t_arrEmpInfo['empNumber']));			
			$strPrgrph1 = "     This is to certify that ".$title." ".strtoupper($name)
						.", ".$t_arrEmpInfo['positionDesc'].", ".$divisionName
						.", is a ".strtolower($t_arrEmpInfo['appointmentDesc'])." employee of the ".getAgencyName()." and "
						."has been in the service since ".date("d F Y",mktime(0,0,0,$month,$day,$year))." to date.";
						//.strtolower($strPronoun)." in this Office.";
			$strPrgrph2 = "     It is further certified that as per available records on file, subject employee has no "
						 ."pending administrative case filed against ".strtolower($strPronoun).".";			
			$this->fpdf->Ln(40);						
			$this->fpdf->SetFont('Arial', "BU", 16);
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
			//$group = mysql_query("SELECT  * FROM tblGroup WHERE groupCode = 'LAG00'");
			//$arrGroup=mysql_fetch_array($group);
			$this->fpdf->Ln(30);
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
			$this->fpdf->Cell(80);	
			$this->fpdf->Cell(100,0,$sigName,0,0,'C');
			$this->fpdf->Ln(4);	
			$this->fpdf->Cell(80);	
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(100,0,$sigPos,0,0,'C');
			$this->fpdf->Ln(4);	
			$this->fpdf->Cell(80);			
			//$this->fpdf->Cell(100,0,$sig[0],0,0,'C');
			$this->fpdf->Ln(4);
			$this->fpdf->SetFont('Arial','',12);
			$this->fpdf->Cell(30, 5,"      ". date("d F Y"), 0, 0, "L");	
			
		
		endforeach;
		echo $this->fpdf->Output();
	}
	
}
/* End of file CertificateServiceLoyaltyAward.php */
/* Location: ./application/models/reports/CertificateServiceLoyaltyAward.php */