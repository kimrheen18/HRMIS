<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LoyaltyReport_model extends CI_Model {

	var $w=array(70,70,60,60);

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');
		//$this->fpdf->FPDF('L', 'mm', 'A');	
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
	
	function getSQLData($strAppStatus="")
	{
		$this->db->select('tblEmpPersonal.empNumber,tblEmpPersonal.surname,tblEmpPersonal.firstname,tblEmpPersonal.middlename,tblEmpPersonal.nameExtension,tblEmpPersonal.middleInitial,tblEmpPosition.firstDayAgency,tblEmpPosition.statusOfAppointment,tblEmpPosition.plantillaGroupCode');
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');
		$this->db->where("(tblEmpPosition.detailedfrom='2' OR tblEmpPosition.detailedfrom='0')");
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->order_by('tblEmpPersonal.surname ASC , tblEmpPersonal.firstname ASC , tblEmpPersonal.middlename ASC');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query(); exit(1);
		return $objQuery->result_array();
	}

	function getplantillagroupname($strGroupCode)
	{
		$objQuery = $this->db->select('plantillaGroupName')->where('plantillaGroupCode',$strGroupCode)->get('tblPlantillaGroup');
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		
		$rs=$this->getSQLData();
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->SetMargins(20,20);
		$this->fpdf->Ln(20);	
		$this->fpdf->SetFont('Arial','B',20);
		$this->fpdf->Ln(15);
		$this->fpdf->SetFont('Arial','',12);
		//$head = new title();
		//$this->Cell(0,2,strtoupper($head->setTitle("RLP").' AS OF ').date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(15);
		
		$this->fpdf->SetFont('Arial','',8);
		//$this->setOfficeInfo();
		$this->fpdf->Cell(10,0,strtoupper(getAgencyName()),0,0,'L');
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(10,0,"List of employee entitled for LOYALTY AWARD",0,0,'L');
		$this->fpdf->Ln(5);
		$arrFromDate = explode('-',$arrData['dtmFromDate']);
		$fromYear = $arrFromDate[0];
		$fromMonth = $arrFromDate[1];
		$fromDay = $arrFromDate[2];
		
		$arrToDate = explode('-',$arrData['dtmToDate']);
		$toYear = $arrToDate[0];
		$toMonth = $arrToDate[1];
		$toDay = $arrToDate[2];
			
		$cutOffFrom = $this->combineLoyaltyDate($fromYear, $fromMonth, $fromDay);
		$cutOffTo = $this->combineLoyaltyDate($toYear, $toMonth, $toDay);
			
		$this->fpdf->Cell(25,0,"Cut off date : ".date('F j, Y',strtotime($cutOffFrom))." to ".date('F j, Y',strtotime($cutOffTo)),0,0,'L');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','B',8);
		$col=array(45,55,30,20,20);
		$this->fpdf->Cell(array_sum($col),5,"","B",0);
		$this->fpdf->Cell($col[0],5,"",0,0,'C');
		$this->fpdf->Cell($col[1],5,"",0,0,'C');
		$this->fpdf->Cell($col[2],5,"",0,0,'C');
		$this->fpdf->Cell($col[3],5,"",0,0,'C');
		$this->fpdf->Cell($col[4],5,"",0,1,'C');
		
		$this->fpdf->Cell($col[0],5,"",0,0,'C');
		$this->fpdf->Cell($col[1],5,"",0,0,'C');
		$this->fpdf->Cell($col[2],5,"DATE",0,0,'C');
		$this->fpdf->Cell($col[3],5,"",0,0,'C');
		$this->fpdf->Cell($col[4],5,"",0,1,'C');
		
		$this->fpdf->Cell($col[0],5,"NAME",0,0,'C');
		$this->fpdf->Cell($col[1],5,"STATION",0,0,'C');
		$this->fpdf->Cell($col[2],5,"OF",0,0,'C');
		$this->fpdf->Cell($col[3],5,"LENGTH OF",0,0,'C');
		$this->fpdf->Cell($col[4],5,"REMARKS",0,1,'C');
		
		$this->fpdf->Cell($col[0],5,"",0,0,'C');
		$this->fpdf->Cell($col[1],5,"",0,0,'C');
		$this->fpdf->Cell($col[2],5,"LOYALTY",0,0,'C');
		$this->fpdf->Cell($col[3],5,"SERVICE",0,0,'C');
		$this->fpdf->Cell($col[4],5,"",0,1,'C');
		$this->fpdf->Cell(array_sum($col),5,"","B",0);
//		$this->Cell(60,15,"FIRST DAY OF EMPLOYMENT","LTBR",0,'C',1);
//		$this->Cell(30,15,"# OF YEARS","LTBR",0,'C',1);
		$this->fpdf->Ln(10);	

		foreach($rs as $row)
		{
			$extension = (trim($row['nameExtension'])=="") ? "" : " ".$row['nameExtension'];		
			$strName = $row['firstname']." ".mi($row['middleInitial']).$row['surname'].$extension;
			$strName = utf8_decode($strName);

			// $sqlGroup = mysql_query("Select plantillaGroupName from tblPlantillaGroup WHERE plantillaGroupCode='".$row['plantillaGroupCode']."'");
			$objplantillaRow = $this->getplantillagroupname($row['plantillaGroupCode']);
			//$plantillaRow = mysql_fetch_array($sqlGroup);
			$plantillaGroup='';
			$this->fpdf->SetFont('Arial','',8);
			foreach($objplantillaRow as $plantillaRow)
				$plantillaGroup = $plantillaRow['plantillaGroupName'];
			//list($posYear,$posMonth,$posDay)=split('[/,-]',$row['firstDayAgency']);
			$arrPosDate = explode('-',$row['firstDayAgency']);
			$posYear = $arrPosDate[0];
			$posMonth = $arrPosDate[1];
			$posDay = $arrPosDate[2];
			//$dateofloyalty = $this->combineLoyaltyDate($posYear, $posMonth, $posDay);
			
			/*
			$current = date('Y');
			$total = $current - $year;
			*/
			
			
			$cutOffFrom = $this->combineLoyaltyDate($fromYear, $fromMonth, $fromDay);
			$cutOffTo = $this->combineLoyaltyDate($toYear, $toMonth, $toDay);
			$dateofloyalty = $this->combineLoyaltyDate($fromYear, $posMonth, $posDay);
			
			$difFromYear = $fromYear - $posYear;
			$difToYear = $toYear - $posYear;
			// $this->fpdf->Cell(array_sum($col),5,$difFromYear,"B",0);
			// $this->fpdf->Ln();
			// $this->fpdf->Cell(array_sum($col),5,$dateofloyalty.'>='.$cutOffFrom,"B",0);
			// $this->fpdf->Ln();
			// $this->fpdf->Cell(array_sum($col),5,$dateofloyalty.'<='.$cutOffTo,"B",0);
			// $this->fpdf->Ln(10);
			if(($difFromYear==5 || $difFromYear==10 || $difFromYear==15 || $difFromYear==20 || $difFromYear==25 || $difFromYear==30 || $difFromYear==35 || $difFromYear==40) // test year from
					&& ($dateofloyalty >= $cutOffFrom) // 		// test month . should be equal or greater than from month
					&& ($dateofloyalty <= $cutOffTo) // 			// test day . should be equal or greater than from day
					)
				{
						$total = $fromYear - $posYear;
						$dateofloyalty = $this->combineLoyaltyDate($fromYear, $posMonth, $posDay);
						
						//$w = array(55,65,25,20,25);
						$Ln = array('L','L','C','C','C');
						$this->fpdf->SetWidths($col);
						$this->fpdf->SetAligns($Ln);
						$this->fpdf->Row(array($strName, $plantillaGroup, date('F j, Y',strtotime($dateofloyalty)), $total, "___________"),0);
						/*
						$this->Cell(55,5,$strName,0,0,'L');
						$this->Cell(65,5,$plantillaGroup,0,0,'L');
						$this->Cell(25,5,$dateofloyalty,0,0,'C');
						$this->Cell(20,5,$total,0,0,'C');
						$this->Cell(25,5,"______________",0,1,'C');
						$this->Ln(5);
						*/
						//$this->checkAddPage(250);
				}										
		}		
			
		
		if($this->fpdf->GetY()>195)
			$this->fpdf->AddPage();
			 
		
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
		$this->fpdf->Cell(0,10,"Certified Correct:",0,0,'L');
		
		$this->fpdf->Ln(20);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','B',12);		
		$this->fpdf->Cell(0,10,strtoupper($sigName),0,0,'L');

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
	
	function combineLoyaltyDate($t_strYear, $t_strMonth, $t_strDay)
	{
		if(strlen($t_strMonth) == 1)
		{
			$t_strMonth = "0".$t_strMonth;
		}
		
		if(strlen($t_strDay) == 1)
		{
			$t_strDay = "0".$t_strDay;
		}

		$strDate = $t_strMonth."/".$t_strDay."/".$t_strYear;
		return $strDate;
	}
	
	// TO COMBINE MONTH AND YEAR ex. January 1, 2006
	function combineStrLoyaltyDate($t_strYear, $t_strMonth, $t_strDay)
	{
		$t_strMonth = intToMonthFull($t_strMonth);
				
		$strDate = $t_strMonth." ".$t_strDay.", ".$t_strYear;
		
		return $strDate;	
	}

}
/* End of file ListEducationalAttainment_model.php */
/* Location: ./application/modules/reports/models/reports/ListEducationalAttainment_model.php */