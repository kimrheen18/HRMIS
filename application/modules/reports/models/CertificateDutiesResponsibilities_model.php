<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CertificateDutiesResponsibilities_model extends CI_Model {

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');		
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
	
	function getSQLData($t_strEmpNmbr="",$t_strOfc="")
	{
		if($t_strEmpNmbr!='')
			$this->db->where('tblEmpPersonal.empNumber',$t_strEmpNmbr);
		if($t_strOfc!='')
			$this->db->where('tblEmpPosition.group3',$t_strOfc);
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname, 
				tblEmpPersonal.firstname, tblEmpPersonal.middleInitial,tblEmpPersonal.sex,
				tblPosition.positionDesc, 
				tblEmpPosition.appointmentCode, tblAppointment.appointmentDesc, tblEmpPosition.positionCode,tblEmpPosition.firstDayAgency, tblEmpPersonal.nameExtension ');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
		$this->db->join('tblAppointment',
			'tblEmpPosition.appointmentCode = tblAppointment.appointmentCode','left');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->order_by('tblEmpPersonal.surname, tblEmpPersonal.firstname');
		$objQuery = $this->db->get('tblEmpPersonal');
		return $objQuery->result_array();
	}
	
	function getplantilladuties($empno)
	{
		$this->db->Select('tblPlantillaDuties.*');	
		$this->db->where('empNumber',$empno);
		$this->db->join('tblEmpPosition',
			'tblPlantillaDuties.itemNumber=tblEmpPosition.itemNumber','left');
		$objQuery = $this->db->get('tblPlantillaDuties');
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		
		$rs=$this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		
		foreach($rs as $t_arrEmpInfo):
		//while($t_arrEmpInfo=mysql_fetch_array($query)) {
			$this->fpdf->AddPage();
					
			$middleInitial=strlen($t_arrEmpInfo['middleInitial'])!=0?$t_arrEmpInfo['middleInitial'].". ":"";
			$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
			$strName = $t_arrEmpInfo['firstname']." ".$middleInitial.$t_arrEmpInfo['surname'].$extension;			
			$strPronoun = pronoun($t_arrEmpInfo['sex']);
			$strMonthFull = date('F',strtotime($arrData['intYear'].'-'.$arrData['intMonth'].'-'.$arrData['intDay']));
			$day = daySuffix($arrData['intDay']);
				
			$strPrgrph1 = "     This is to certify that ".titleOfCourtesy($t_arrEmpInfo['sex'])." ".strtoupper($strName)
						.", a ".strtolower($t_arrEmpInfo['appointmentDesc'])." employee of this agency, holds the position of ".$t_arrEmpInfo['positionDesc']
						." and performs the following duties and responsibilities:";
			
			$strPrgrph3 = "     This certification is being issued upon request of ".titleOfCourtesy($t_arrEmpInfo['sex'])." ".strtoupper($t_arrEmpInfo['surname'])
						." for whatever legal purpose it may serve ".strtolower(pronoun($t_arrEmpInfo['sex'])).".";
			$this->fpdf->Ln(5);
			// create date string
			$strMonthFull = date('F',strtotime(date('Y').'-'.$arrData['intMonth'].'-'.date('d')));
			//list($year,$month,$day)=split('[/,-]',$t_arrEmpInfo['firstDayAgency']);
			$arrTmpDate = explode('-',$t_arrEmpInfo['firstDayAgency']);
			// if($t_arrEmpInfo['firstDayAgency']!='0000-00-00')
			// {
			// 	print_r($arrTmpDate);exit(1);
			// 	$year = $arrTmpDate[0];
			// 	$month = $arrTmpDate[1];
			// 	$day = $arrTmpDate[2];
			// }

			// $strMonth = date('F',strtotime( date('Y').'-'.($month+0).'-'.date('d') ));
			// $positionDate = $strMonth." ".($day+0).", ".$year;
			$divisionCode = employee_office($t_arrEmpInfo['empNumber']);
			$divisionName = office_name($divisionCode);
			
			$dateString = $strMonthFull." ".$arrData['intDay'].", ".$arrData['intYear'];
			$this->fpdf->SetFont('Arial', "", 12);
			//$this->Ln(20);
			//$this->Cell(100,0,"",0);							
			//$this->Cell(0,10,$dateString,0,0,C);
			//$this->Ln(20);
			//$this->SetFont('Arial', "BU", 16);
			//$this->Cell(0, 5, "C E R T I F I C A T I O N", 0, 0, "C");
			//$this->Ln(25);
			//$this->SetFont('Arial', "", 12);
			//$this->Cell(0, 5, "TO WHOM IT MAY CONCERN:", 0, 0, "L");	
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial', "B", 12);
			
			
			$this->fpdf->Write(5,"            ");
			//$this->SetFont('Arial','B',12);
			$this->fpdf->Write(5,titleOfCourtesy($t_arrEmpInfo['sex']).' '.$t_arrEmpInfo['surname']);
			$this->fpdf->SetFont('Arial','B',12);
			//$this->Write(5,",a ".strtolower($t_arrEmpInfo['appointmentDesc'])." employee of this agency, holds the position of ");
			//$this->Write(5," has been employed as ");
			//$this->SetFont('Arial','B',12);
			//$this->Write(5,$t_arrEmpInfo['positionDesc']." (".ucfirst($t_arrEmpInfo['appointmentDesc']).")");
			
			//$this->SetFont('Arial','',12);
			$this->fpdf->Write(5," performs the following duties and responsibilities:");
			$this->fpdf->Ln(5);
			$intCtr=1;
			$this->fpdf->SetFont('Arial', "", 12); //pau				
			$this->fpdf->SetWidths(array(20,8,150));
			$this->fpdf->Ln(5);
			//while($arrDuties = mysql_fetch_array($objDuties))
			$objDuties = $this->getplantilladuties($t_arrEmpInfo['empNumber']);
			foreach($objDuties as $arrDuties)
			{		
				//$this->Row(array("",$intCtr.". ", $arrDuties['duties']), 0);
				$this->fpdf->Row(array("",chr(149)." ", $arrDuties['itemDuties']), 0);
				//$this->Cell(0,10,chr(149).$arrDuties['itemDuties'],0,0,'L');	
				$this->fpdf->Ln(2);
				//$this->Row(array("","", ""), 0);
				$intCtr++;	
			}
			// output position duties
			/*
			$objPosDuties = mysql_query("SELECT * FROM tblDuties WHERE positionCode='".$t_arrEmpInfo['positionCode']."'");
			while($arrPosDuties = mysql_fetch_array($objPosDuties))
			{		
				//$this->Row(array("",$intCtr, $arrPosDuties['duties']), 0);
				$this->Row(array("",chr(149)." ", $arrPosDuties['duties']), 0);
				$this->Row(array("","", ""), 0);
				$intCtr++;	
			}
			*/			
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial', "", 12);
			//$this->MultiCell(0, 6, $strPrgrph3, 0, 'J', 0);
			$this->fpdf->Ln(10);
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
			$this->fpdf->Ln(10);
			$this->fpdf->Cell(100);				
			$this->fpdf->SetFont('Arial','B',12);		
			$this->fpdf->Cell(0,10,$sigName,0,0,'C');	
			$this->fpdf->Ln(4);
			$this->fpdf->Cell(100);		
			$this->fpdf->SetFont('Arial','',12);				
			$this->fpdf->Cell(0,10,$sigPos,0,0,'C');			
			$this->fpdf->Ln(4);
			$this->fpdf->Cell(100);		
			$this->fpdf->SetFont('Arial','',12);				
			//$this->fpdf->Cell(0,10,$sig[0],0,0,'C');
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial', "B", 12);	
		
		endforeach;
		echo $this->fpdf->Output();
	}
	
}
/* End of file CertificateDutiesResponsibilities_model.php */
/* Location: ./application/models/reports/CertificateDutiesResponsibilities_model.php */