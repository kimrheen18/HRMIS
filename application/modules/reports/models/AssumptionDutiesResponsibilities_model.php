<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AssumptionDutiesResponsibilities_model extends CI_Model {

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
					tblEmpPersonal.firstname, tblEmpPersonal.middlename,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension, tblEmpPersonal.sex, 
					tblPosition.positionDesc, 
					tblEmpPersonal.comTaxNumber, tblEmpPersonal.issuedAt, 
					tblEmpPersonal.issuedOn, tblEmpPosition.positionDate');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
		$this->db->order_by('tblEmpPersonal.surname, tblEmpPersonal.firstname');
		$objQuery = $this->db->get('tblEmpPersonal');
		return $objQuery->result_array();
	}
			
	function generate($arrData)
	{		
		
		$rs=$this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		
		foreach($rs as $t_arrEmpInfo):
			//while($t_arrEmpInfo=mysql_fetch_array($query)) {
			$this->fpdf->AddPage();
			$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
			$strName = $t_arrEmpInfo['firstname']." ".mi($t_arrEmpInfo['middleInitial']).$t_arrEmpInfo['surname'].$extension;
			//$name = strtoupper($t_arrEmpInfo['surname'].", ".$t_arrEmpInfo['firstname'].$extension." ".$t_arrEmpInfo['middleInitial']);

			$strPronoun = pronoun2($t_arrEmpInfo['sex']);
			$arrDate=$t_arrEmpInfo['positionDate'];
			//list($year, $month, $day)=split('[/.-]',$arrDate);
			$arrTmpDate=explode('-',$arrDate);

			
			if($arrDate=='0000-00-00')
			{
				$positionDate = '0000-00-00';
			}
			else
			{
				if(count($arrTmpDate)>0)
					$positionDate = date("F d, Y",strtotime($arrDate));
				else
					$positionDate = '-';
			}
			
			
			$divisionName = office_name(employee_office($t_arrEmpInfo['empNumber']));
			$strPrgrph1 = "     This is to certify that ".titleOfCourtesy($t_arrEmpInfo['sex'])." ".strtoupper($strName)
						.", ".$t_arrEmpInfo['positionDesc'].", ".$divisionName
						." of ".getAgencyName()
						.", assumed the duties and responsibilities of "
						.strtolower($strPronoun)." position on "  
						.$positionDate.". ";
			
			
			//$this->Ln(15);	
			$this->fpdf->Ln(40);	
			$this->fpdf->SetFont('Arial', "", 12);	
			$this->fpdf->Cell(100, 5, "", 0, 0, "R");
			$this->fpdf->Cell(90, 5, date("F d, Y"), 0, 0, "C");
			$this->fpdf->Ln(20);
			$this->fpdf->SetFont('Arial', "BU", 16);
			$this->fpdf->Cell(0, 5, "CERTIFICATE OF ASSUMPTION", 0, 0, "C");

			$this->fpdf->Ln(20);
			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "TO WHOM IT MAY CONCERN:", 0, 0, "L");

			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->MultiCell(0, 6, $strPrgrph1, 0, 'J', 0);
			
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
			
			$this->fpdf->Ln(25);
			$this->fpdf->Cell(100);		
			$this->fpdf->SetFont('Arial','B',12);		
			$this->fpdf->Cell(90,10,$sigName,0,0,'C');

			$this->fpdf->Ln(4);
			$this->fpdf->Cell(100);		
			$this->fpdf->SetFont('Arial','',12);				
			$this->fpdf->Cell(90,10,$sigPos,0,0,'C');
			
			$this->fpdf->Ln(4);
			$this->fpdf->Cell(100);		
			$this->fpdf->SetFont('Arial','',12);				
			//$this->fpdf->Cell(90,10,$sig[0],0,0,'C');
		
		endforeach;
		echo $this->fpdf->Output();
	}
	
}
/* End of file AssumptionDutiesResponsibilities_model.php */
/* Location: ./application/models/reports/AssumptionDutiesResponsibilities_model.php */