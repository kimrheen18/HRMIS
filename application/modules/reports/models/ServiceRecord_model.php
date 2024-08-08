<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ServiceRecord_model extends CI_Model {

	//var $w=array(70,70,60,60);
	var $w=array(18,17,35,13,20,28,15,15,20,15);
	var $a=array("C", "C", "C", "C", "C", "C", "C", "C", "C", "C");

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

	function getSQLData($empno="",$t_strOfc="")
	{
		$this->db->select('DISTINCT(tblEmpPersonal.empNumber), tblEmpPersonal.surname, 
								tblEmpPersonal.firstname, tblEmpPersonal.middlename, 
								tblEmpPersonal.birthday,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension, tblEmpPersonal.birthPlace');
		
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');
		//$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		if($empno!='')
			$this->db->where('tblEmpPersonal.empNumber',$empno);
		if($t_strOfc!='')
			$this->db->where('tblEmpPosition.group3',$t_strOfc);
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->order_by('tblEmpPersonal.surname asc,tblEmpPersonal.firstname asc, tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function get_servicerecord($empno)
	{
		$this->db->select('tblServiceRecord.*,tblPosition.positionCode');
		
		$this->db->join('tblPosition',
			'tblPosition.positionCode=tblServiceRecord.positionCode','left');
		$this->db->where('tblServiceRecord.governService!=','No');
		$this->db->where('tblServiceRecord.empNumber',$empno);
		
		$this->db->order_by('tblServiceRecord.serviceFromDate ASC');
		$objQuery = $this->db->get('tblServiceRecord');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function get_positiondesc($positionCode)
	{
		$this->db->select('positionCode, positionAbb, positionDesc');
		$this->db->where('positionCode',$positionCode);
		$objQuery = $this->db->get('tblPosition');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function convertDateFormat($t_dtmDate)
	{
		$arrDate=explode('-',$t_dtmDate);
		if(isset($arrDate[0]) && isset($arrDate[1]) && isset($arrDate[2]))
			return $arrDate[1]."-".$arrDate[2]."-".$arrDate[0];
		else
			return '0000-00-00';
	}

	function convertSalary($salary,$salaryPer)
	{
//		setlocale(LC_MONETARY, 'en_US.UTF-8');
		//setlocale(LC_MONETARY, 'en_US');
		//money_format('%.2n', $salary);
		
		if($salaryPer=="Month")
			return number_format($salary, 2, '.', ',')."/m";
		else if($salaryPer=="Year")
			return number_format($salary, 2, '.', ',')."/a";	
		else if($salaryPer=="Day")
			return number_format($salary, 2, '.', ',')."/d";
		else if($salaryPer=="Hour")
			return number_format( $salary, 2, '.', ',')."/hr";
		else if($salaryPer=="Quarter")
			return number_format($salary, 2, '.', ',')."/q";
		else 
			return number_format($salary, 2, '.', ',').""; 	
	}

	function generate($arrData)
	{		
		
		//print_r($arrData);exit(1);
		
		$rs=$this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		for($i=0;$i<sizeof($rs);$i++) {
		//while($rs=mysql_fetch_array($t_arrEmpInfo)){
			//$this->AddPage();
			$this->fpdf->AddPage('P','A4');
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(0, 5, 'S E R V I C E  R E C O R D', 0, 0, 'C');
			$this->fpdf->Ln();
			$this->fpdf->SetFont('Arial','',11);
			$this->fpdf->Cell(0, 5, '(To Be Accomplished By Employer)', 0, 0, 'C');
			$this->fpdf->Ln(10);
			
			$this->fpdf->SetFont('Arial','B',11);
			$this->fpdf->Cell(15, 5, 'NAME:', 0, 0, 'L');
			$this->fpdf->Cell(1, 5, '', 0, 0, 'L');
			$this->fpdf->Cell(30, 5, strtoupper($rs[$i]['surname'].", "), 'B', 0, 'C');
			$this->fpdf->Cell(44, 5, strtoupper($rs[$i]['firstname']." "), 'B', 0, 'C');
			$this->fpdf->Cell(30, 5, strtoupper($rs[$i]['middlename']." "), 'B', 0, 'C');			
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(70, 5, '(if married woman, give also full maiden name)', 0, 0, 'L');
			$this->fpdf->Ln();
			
			$this->fpdf->Cell(15, 5, '', 0, 0, 'L');
			$this->fpdf->Cell(1, 5, '', 0, 0, 'L');
			$this->fpdf->SetFont('Arial','B',11);
			$this->fpdf->Cell(30, 5, "(Surname)", 0, 0, 'C');
			$this->fpdf->Cell(44, 5,"(Give Name)", 0, 0, 'C');
			$this->fpdf->Cell(30, 5, "(Middle Name)", 0, 0, 'C');			
			$this->fpdf->Ln(10);
			
			$this->fpdf->SetFont('Arial','B',11);
			$this->fpdf->Cell(15, 5, 'BIRTH:', 0, 0, 'L');
			$this->fpdf->Cell(1, 5, '', 0, 0, 'L');
			$this->fpdf->Cell(30, 5, $rs[$i]['birthday'], 'B', 0, 'C');
			$this->fpdf->Cell(74, 5, $rs[$i]['birthPlace'], 'B', 0, 'C');			
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(70, 5, '(Data herein should be checked from birth or ', 0, 0, 'L');
			$this->fpdf->Ln();
			
			$this->fpdf->Cell(15, 5, '', 0, 0, 'L');
			$this->fpdf->Cell(1, 5, '', 0, 0, 'L');
			$this->fpdf->SetFont('Arial','B',11);
			$this->fpdf->Cell(30, 5, "(Date)", 0, 0, 'C'); 
			$this->fpdf->Cell(74, 5,"(Place)", 0, 0, 'C');
			$this->fpdf->SetFont('Arial','',11);
			$this->fpdf->Cell(70, 5, 'baptismal certificate or some other reliable', 0, 0, 'L');
			$this->fpdf->Ln(5);
			
			$this->fpdf->Cell(15, 5, '', 0, 0, 'L');
			$this->fpdf->Cell(1, 5, '', 0, 0, 'L');
			$this->fpdf->Cell(30, 5, "", 0, 0, 'C');			
			$this->fpdf->Cell(74, 5,"", 0, 0, 'C');
			$this->fpdf->SetFont('Arial','',11);
			$this->fpdf->Cell(70, 5, 'documents)', 0, 0, 'L');
			$this->fpdf->Ln(10);		
			
			$strParagraph="     This is to certify that the employee named hereinabove actually rendered services in this Office as shown by the service record below, each line of which is supported by appointment and other papers actually issued by this Office and approved by the authorities concerned:";
			$this->fpdf->SetWidths(array(16,158,16));
			$this->fpdf->SetAligns(array("L", "J", "L"));
			$this->fpdf->Row(array('',$strParagraph,''),0);
			$this->fpdf->Ln();
			$this->fpdf->Cell(0, 1, '', 'T', 0, 'L');
			$this->fpdf->Ln();
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell($this->w[0]+$this->w[1], 4, 'SERVICE RECORD', 1, 0, 'C');
			$this->fpdf->Cell($this->w[2]+$this->w[3]+$this->w[4], 4, 'RECORD OF APPOINTMENT', 1, 0, 'C');
			$this->fpdf->Cell($this->w[5]+$this->w[6]+$this->w[7], 4, 'OFFICE ENTITY/DIVISION', 1, 0, 'C');
			$this->fpdf->Cell($this->w[8]+$this->w[9], 4, 'SEPARATION', 1, 0, 'C');
			$this->fpdf->Ln();
			
			$this->fpdf->Cell($this->w[0]+$this->w[1], 4, '(Inclusive Dates)', 1, 0, 'C');
			$this->fpdf->Cell($this->w[2], 4, 'Designation', 'TLR', 0, 'C');
			$this->fpdf->Cell($this->w[3], 4, 'Status', 'TLR', 0, 'C');
			$this->fpdf->Cell($this->w[4], 4, 'Salary', 'TLR', 0, 'C');
			$this->fpdf->Cell($this->w[5], 4, 'Station/Place', 1, 0, 'C');
			$this->fpdf->Cell($this->w[6], 4, 'Branch', 1, 0, 'C');
			$this->fpdf->Cell($this->w[7], 4, 'L/V ABS', 1, 0, 'C');
			$this->fpdf->Cell($this->w[8], 4, 'Date', 1, 0, 'C');
			$this->fpdf->Cell($this->w[9], 4, 'Cause', 1, 0, 'C');
			$this->fpdf->Ln();
			
			$this->fpdf->Cell($this->w[0], 4, 'From', 1, 0, 'C');
			$this->fpdf->Cell($this->w[1], 4, 'To', 1, 0, 'C');
			$this->fpdf->Cell($this->w[2], 4, '', 'BLR', 0, 'C');
			$this->fpdf->Cell($this->w[3], 4, '(1)', 'BLR', 0, 'C');
			$this->fpdf->Cell($this->w[4], 4, '(2)', 'BLR', 0, 'C');
			$this->fpdf->Cell($this->w[5], 4, 'of Assigmnt.', 'BLR', 0, 'C');
			$this->fpdf->Cell($this->w[6], 4, '(3)', 'BLR', 0, 'C');
			$this->fpdf->Cell($this->w[7], 4, 'W/O PAY', 'BLR', 0, 'C');
			$this->fpdf->Cell($this->w[8]+$this->w[9], 4, '(4)', 1, 0, 'C');
			$this->fpdf->Ln();
			
			
						
			$row=$this->get_servicerecord($rs[$i]['empNumber']);
			$this->fpdf->SetWidths($this->w);
			$this->fpdf->SetAligns($this->a);	
			$this->fpdf->SetFont('Arial','',8);
			$this->fpdf->SetFillColor(255,255,255);
			//if($_SERVER['REMOTE_ADDR']=="10.10.10.31")
				//print_r($row);
			for($j=0;$j<sizeof($row);$j++) 
			{
			//while($row=mysql_fetch_array($t_arrSRInfo)){
				$fromDate=$this->convertDateFormat($row[$j]['serviceFromDate']);
				$toDate=$this->convertDateFormat($row[$j]['serviceToDate']);
				
				if (!$row[$j]['positionDesc']){
					$rs2 = $this->get_positiondesc($row[$j]['positionCode']);
					$positionAbb=	count($rs2) && $rs2[0]['positionDesc']<>""?$rs2[0]['positionAbb']:$row[$j]['positionDesc'];
						if (!$positionAbb) $positionAbb= "".$row[$j]['positionCode'];						
				} else 
					$positionAbb=	"".$row[$j]['positionDesc'];

				if($j>0)
				{			
					if ( ($positionAbb ==$row[$j-1]['positionCode']) OR ($positionAbb ==$row[$j-1]['positionDesc']) )
							$positionAbb=	"-do-";  
				}	

				//$sql= "SELECT positionAbb FROM tblPosition WHERE positionCode='".$arrSR['positionCode']."'";
				//$this->Cell(0, 5, $sql, 0, 0, 'L');
				if($j>0)
					$status=$row[$j]['appointmentCode']==$row[$j-1]['appointmentCode']?"-do-":$row[$j]['appointmentCode'];
				else
					$status='';
				$salary=$this->convertSalary($row[$j]['salary'],$row[$j]['salaryPer']);
				if($j>0)
				{
					$stationAgency=$row[$j]['stationAgency']==$row[$j-1]['stationAgency']?"-do-":$row[$j]['stationAgency'];
					$branch=$row[$j]['branch']==$row[$j-1]['branch']?"-do-":$row[$j]['branch'];
					$lwop=$row[$j]['lwop']==0?"None":$row[$j]['lwop'];
					$lwop=$row[$j]['lwop']==$row[$j-1]['lwop'] && $j>0?"-do-":$lwop;
				}
				else
				{
					$stationAgency=$row[$j]['stationAgency'];
					$branch=$row[$j]['branch'];
					$lwop=$row[$j]['lwop']==0?"None":$row[$j]['lwop'];
					//$lwop=$row[$j]['lwop']==$row[$j-1]['lwop'] && $j>0?"-do-":$lwop;
				}
				$separationDate=$this->convertDateFormat($row[$j]['separationDate']);
				$separationCause=$row[$j]['separationCause'];
				$this->fpdf->FancyRow(array($fromDate,$toDate,$positionAbb,$status,$salary,$stationAgency,$branch,$lwop,$separationDate,$separationCause),1);
			}
			$this->fpdf->Cell(0,10,"",'B',0,'L');
			$this->fpdf->Ln(20);
			$this->fpdf->Cell(30);
			$this->fpdf->Cell(30);				
			$this->fpdf->SetFont('Arial','',12);		
			$this->fpdf->Cell(0,10,"Certified Correct:",0,0,'L');
			
			$this->fpdf->SetFont('Arial','B',12);	
			$sig=getSignatories($arrData['intSignatory']);
			//print_r($sig);
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
			
		}

		/* Signatory */
		 if($this->fpdf->GetY()>195)
			 $this->fpdf->AddPage();
			 
		
			

			
		
		
		echo $this->fpdf->Output();
	}
	
}
/* End of file ServiceRecord_model.php */
/* Location: ./application/modules/reports/models/reports/ServiceRecord_model.php */