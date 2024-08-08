<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReportLeave_rpt_model extends CI_Model {

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');	
		//ini_set('display_errors','On');
		//$this->load->model(array());
	}
	
	public function getEmp($intEmpNumber = '')
	{		
		if($intEmpNumber != "")
		{
			$this->db->where('empNumber',$intEmpNumber);
		}
		$objQuery = $this->db->get('tblEmpPersonal');
		return $objQuery->result_array();		
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
		$today =  date("F j, Y",strtotime(date("Y-m-d")));
		$strWholeday ="";
		$strHalfday ="";
		$intTotal ="";
		$dtmLeavefrom = $arrData['dtmLeavefrom'] == '' ? '' : date("F j, Y",strtotime($arrData['dtmLeavefrom']));
		$dtmLeaveto = $arrData['dtmLeaveto'] == '' ? '' : date("F j, Y",strtotime($arrData['dtmLeaveto']));
		$intDaysApplied = $arrData['intDaysApplied'];
		$str1stSignatory = $arrData['str1stSignatory'];
		$str2ndSignatory = $arrData['str2ndSignatory'];
		$strReason = $arrData['strReason'];

		$intVL = $arrData['intVL'];
		$intSL = $arrData['intSL'];
		
		// // $intTotal = $arrData['intVL'] + $arrData['intSL'];

		$strIncaseSL = "";
		$strInpatient = "";
		$strOutpatient ="";

		if ($strIncaseSL=='in patient')
			$strInpatient = "x";
		else
			$strOutpatient = "";

		$strIncaseVL = "";
		$strWithin = "";
		$strAbroad = "";		
		
		if ($strIncaseVL=='within the country')
			$strWithin = "x";
		else
			$strAbroad = "";

		// if ($strDay=='Whole day')
		// 	$strWholeday = "x";
		// else
		// 	$strHalfday = "x";
		// echo '<pre>';
		// print_r($arrData);
		// die();
		$this->fpdf->SetTitle('Application for Leave Form');
		$this->fpdf->SetLeftMargin(10);
		$this->fpdf->SetRightMargin(10);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		$this->fpdf->AddPage('P','','A4');
		

		$this->fpdf->SetFont('Arial', "", 8);
		
		$this->fpdf->Cell(0, 4, "CSC FORM NO. 6", 0, 0, "L");		
		$this->fpdf->Cell(0, 4, "", 0, 0, "R");
		$this->fpdf->Ln(3);
		$this->fpdf->Cell(0, 4, "Revised 1985", 0, 0, "L");		
		$this->fpdf->Cell(0, 4, "", 0, 0, "R");
	
		$this->fpdf->Ln(3);
		$this->fpdf->SetFont('Arial', "BU", 12);
		$this->fpdf->Cell(0, 5, "APPLICATION FOR LEAVE", 0, 0, "C");	

		$this->fpdf->Ln(9);
		
		$this->fpdf->Line(10, 25, 200, 25); //------------------------------------------------------------------
		// echo '<pre>';

		$empid = $this->uri->segment(4);
		if($empid!=''){
			$this->load->model(array('hr/Hr_model','employee/Leave_model'));
			$arrLeaveBal = $this->Leave_model->getLatestBalance($empid);
			$arrDetails = $this->Hr_model->getData($empid);
			$arrDetails[0]['payrollGroupCode'] = office_name(employee_office($empid));
			$arrDetails[0]['positionCode'] = isset($arrDetails[0]['positionDesc']) ? $arrDetails[0]['positionDesc'] : '';
			
		}else{
			$arrDetails=$this->empInfo();
		}
		// print_r($arrDetails);
		// die();
		// $arrDetails=$this->empInfo();
		foreach($arrDetails as $row)
			{
				$this->fpdf->SetFont('Arial', "", 10);
				$this->fpdf->Cell(50, 5, "1. OFFICE/AGENCY", "R", 0, "L");
				$this->fpdf->Cell(45, 5, "2. NAME (Last)", 0, 0, "L");
				$this->fpdf->Cell(45, 5, "(First)", 0, 0, "L");
				$this->fpdf->Cell(45, 5, "(Middle)", 0, 1, "L");
					
				$this->fpdf->Cell(50, 7,$row['payrollGroupCode'], "R", 0, "C");
				$this->fpdf->Cell(100,7,(isset($row['surname']) ? $row['surname'] : '').'                      '.(isset($row['firstname']) ? $row['firstname'] : '').'                                       '.(isset($row['middleInitial']) ? $row['middleInitial'] : ''), 0, 0, "C");

				$this->fpdf->Cell(45, 7,'', 0, 0, "L");
				$this->fpdf->Cell(45, 7, '', 0, 1, "L");

				// $this->fpdf->Ln(0);
				$this->fpdf->Line(10, 37, 200, 37); //------------------------------------------------------------------

				// $this->fpdf->SetFont('Arial', "", 10);
				$this->fpdf->Cell(50, 5, "3. DATE OF FILING", "R", 0, "L");
				$this->fpdf->Cell(90, 5, "4. POSITION", "R", 0, "L");
				$this->fpdf->Cell(45, 5, "5. SALARY (Monthly)", 0, 1, "L");
				// $this->fpdf->Cell(200, 10, "", 0, 1, "L");
				// $this->fpdf->Ln(0);
				$this->fpdf->Cell(50, 7, "$today", "R", 0, "C");
				$this->fpdf->Cell(90, 7,'    '.$row['positionCode'], "R", 0, "L");
				$this->fpdf->Cell(45, 7,'    '.(isset($row['actualSalary']) ? number_format($row['actualSalary'],2,".",",") : ''), 0, 1, "L");
			}



		// $this->fpdf->Ln(100);
		$this->fpdf->Line(10, 49, 200, 49); //------------------------------------------------------------------
		$this->fpdf->Ln(2);
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(0, 5, "6. DETAILS OF APPLICATION ", 0, 0, "C");			

		$this->fpdf->Line(10, 57, 200, 57); //------------------------------------------------------------------

		$this->fpdf->Ln(6);	
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(90, 5, "6. A)  TYPE OF LEAVE", "R", 0, "L");
		$this->fpdf->Cell(90, 5, "6. B)  WHERE LEAVE WILL BE SPENT:", 0, 1, "L");

		$this->fpdf->Cell(90, 7, "", "R", 0, "L");
		$this->fpdf->Cell(90, 4, "1) IN CASE OF VACATION LEAVE", 0, 1, "L");

		// $indentions = "     ";
		$this->fpdf->Ln(0);	
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
	// if ($strLeaveType == "VL" )
		// $this->fpdf->Cell(6, 5,"x", 1, 0, "C");
	// else
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(74, 5,"Vacation", "R", 0, "L");


		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		// if($strLocal == "local" && $strLeaveType == "VL" )
		// 	$this->fpdf->Cell(6, 5,"x", 1, 0, "C");		
		// else
			// $this->fpdf->Cell(6, 5,"d", 1, 0, "C");					
		$this->fpdf->Cell(6, 5,"$strWithin", 1, 0, "C");					
		$this->fpdf->Cell(37, 5,"Within the Philippines", 0, 0, "L");
		$this->fpdf->Cell(47, 5,"", "B", 1, "L"); 
		//----------------------------------------------------------
		$this->fpdf->Cell(17, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(67, 5,"To seek employment", "R", 0, "L");
		
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		// if($strLocal == "abroad" && $strLeaveType == "VL" )
		// 	$this->objRprt->Cell(6, 5,"x", 1, 0, "C");		
		// else
		$this->fpdf->Cell(6, 5,"$strAbroad", 1, 0, "C");					
		$this->fpdf->Cell(37, 5,"Abroad (Specify)", 0, 0, "L");
		$this->fpdf->Cell(47, 5,"", "B", 1, "L"); 

//----------------------------------------------------------
		$this->fpdf->Cell(17, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(30, 5,"Others (Specify)", 0, 0, "L");		
		$this->fpdf->Cell(35, 5,"", "B", 0, "L"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(17, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(83, 5,"", "B", 1, "L"); 

//----------------------------------------------------------
		$this->fpdf->Cell(23, 6,"", 0, 0, "L");	
		$this->fpdf->Cell(65, 6,"", "B", 0, "L"); 
		$this->fpdf->Cell(2, 11,"", "R", 0, "L"); 		
		$this->fpdf->Cell(90, 11, "2) IN CASE OF SICK LEAVE", 0, 1, "L");
		
//----------------------------------------------------------
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
	// if ($strLeaveType == "SL")
	// 	$this->fpdf->Cell(6, 5,"x", 1, 0, "C");
	// else
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(74, 5,"Sick", "R", 0, "L");
		
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
	// if($strPatient == "in" && $strLeaveType == "SL")
	// 	$this->fpdf->Cell(6, 5,"x", 1, 0, "C");		
	// else
		$this->fpdf->Cell(6, 5,"$strInpatient", 1, 0, "C");		
		$this->fpdf->Cell(37, 5,"In Hospital (Specify)", 0, 0, "L");
		$this->fpdf->Cell(47, 5,"", "B", 1, "L"); 

//----------------------------------------------------------
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
	// if ($strLeaveType == "MTL")
	// 	$this->fpdf->Cell(6, 5,"x", 1, 0, "C");
	// else
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(74, 5,"Maternity", "R", 0, "L");
				
		$this->fpdf->Cell(17, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(83, 5,"", "B", 1, "L"); 

//----------------------------------------------------------
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");
	// if ($strLeaveType != "SL" && $strLeaveType != "VL" && $strLeaveType != "MTL"){
		// $this->fpdf->Cell(6, 5,"x", 1, 0, "C");
		// $this->fpdf->Cell(30, 5,"Others (Specify)", 0, 0, "L");		
		// $this->fpdf->Cell(42, 5,"", "B", 0, "L"); 		
	// }else{
		if($_GET['leavetype'] == 'monetization'){
			$this->fpdf->SetFont('ZapfDingbats','', 10);
			$this->fpdf->Cell(6, 5,"4", 1, 0, "C");
			$this->fpdf->SetFont('Arial','', 10);
		}else{
			$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		}
		$this->fpdf->Cell(30, 5,"Others (Specify)", 0, 0, "L");
		if($_GET['leavetype'] == 'monetization'){
			$this->fpdf->Cell(42, 5,"Leave Monetization", "B", 0, "L"); 
		}else{
			$this->fpdf->Cell(42, 5,"", "B", 0, "L"); 
		}	
	// }		
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
				
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");
	// if($strPatient == "out" && $strLeaveType == "SL")
		// $this->fpdf->Cell(6, 5,"x", 1, 0, "C");		
	// else
		$this->fpdf->Cell(6, 5,"$strOutpatient", 1, 0, "C");		
		$this->fpdf->Cell(37, 5,"Out Patient (Specify)", 0, 0, "L");
		$this->fpdf->Cell(47, 5,"", "B", 1, "L"); 

//----------------------------------------------------------
		$this->fpdf->Cell(23, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(65, 5,"", "B", 0, "L"); 
		$this->fpdf->Cell(2, 10,"", "R", 0, "L"); 		
				
		$this->fpdf->Cell(17, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(83, 5,"", "B", 1, "L"); 
//----------------------------------------------------------
		$this->fpdf->Line(10, 117, 200, 117); //------------------------------------------------------------------

//----------------------------------------------------------
		$this->fpdf->Ln(5);	
		$this->fpdf->Cell(90, 5, "6. C)  NUMBER OF WORKING DAYS APPLIED FOR", "R", 0, "L");
		$this->fpdf->Cell(90, 5, "6. D)  COMMUTATION", 0, 1, "L");

		$this->fpdf->Cell(10, 5,"", 0, 0, "C");	
		$this->fpdf->Cell(78, 5,"$intDaysApplied", "B", 0, "C"); 
		$this->fpdf->Cell(2, 10,"", "R", 0, "L"); 

		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
	// if($strComm == "required")
	// 	$this->fpdf->Cell(6, 5,"x", 1, 0, "C");
	// else
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(37, 5,"Requested", 0, 0, "L");
	// if($strComm == "notrequired")
	// 	$this->fpdf->Cell(6, 5,"x", 1, 0, "C");
	// else
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(37, 5,"Not Requested", 0, 1, "L");

//----------------------------------------------------------
		$this->fpdf->Cell(8, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(35, 8,"INCLUSIVE DATES", 0, 0, "L");		
		$this->fpdf->Cell(47, 5,"", "R", 0, "L"); 

		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(48, 5,"", 0, 1, "C");
		
//----------------------------------------------------------

		$this->fpdf->Cell(10, 6,"", 0, 0, "L");
		// if($arrData['dtmLeavefrom'] != '' && $arrData['dtmLeaveto'] != ''){
		// 	$this->fpdf->Cell(78, 6,"$dtmLeavefrom from $dtmLeaveto", "B", 0, "C");
		// }else{
		// 	$this->fpdf->Cell(78, 6,"", "B", 0, "C"); 
		// }

		$this->fpdf->Cell(78, 6,"From $dtmLeavefrom to $dtmLeaveto", "B", 0, "C");
		
		$this->fpdf->Cell(2, 6,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(20, 6,"", 0, 0, "L");
		$this->fpdf->SetFont('Arial', "B", 10);	
		$this->fpdf->Cell(70, 6,"", "B", 1, "C");
		$this->fpdf->SetFont('Arial', "", 10);
		
//----------------------------------------------------------

		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(80, 6,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(20, 6,"", 0, 0, "L");	
		$this->fpdf->Cell(70, 6,"(Signature of Applicant)", 0, 1, "C");
		
//----------------------------------------------------------
		$this->fpdf->Ln(2);

		$this->fpdf->Line(10, 144, 200, 144); //------------------------------------------------------------------
		$this->fpdf->Cell(0, 5, "7. DETAILS OF ACTION ON APPLICATION", 0, 1, "C");
		$this->fpdf->Line(10, 152, 200, 152); //------------------------------------------------------------------
		$this->fpdf->Ln(1);
//----------------------------------------------------------
// get leave balance
	// $arrEmpLeaveBal = mysql_query("SELECT *
	// 		FROM tblEmpLeaveBalance
	// 		WHERE empNumber = '".$t_arrEmpInfo["empNumber"]."'
	// 		ORDER BY periodYear DESC, periodMonth DESC LIMIT 1 ");
						
	// $rowEmpLeave = mysql_fetch_array($arrEmpLeaveBal);		
	
	// $intVLBal = 0 + $rowEmpLeave['vlBalance'];
	// $intSLBal = 0 + $rowEmpLeave['slBalance'];

		$this->fpdf->Cell(90, 5, "7. A)  CERTIFICATION OF LEAVE CREDITS", "R", 0, "L");
		$this->fpdf->Cell(90, 5, "7. B)  RECOMMENDATION:", 0, 1, "L");

		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(10, 5,"as of", 0, 0, "L");
		if($_GET['leavetype'] == 'monetization'){
			$this->fpdf->Cell(68, 5,(isset($arrLeaveBal['periodMonth']) ? date('F', mktime(0, 0, 0, $arrLeaveBal['periodMonth'], 10)).' '.$arrLeaveBal['periodYear'] : ''), "B", 0, "L"); 
		}else{
			$this->fpdf->Cell(68, 5,"", "B", 0, "L"); 
		}
		
		$this->fpdf->Cell(2,  5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(80, 5,"", 0, 1, "C"); 
		
//----------------------------------------------------------
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(78, 5,"", 0, 0, "L"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");		
		$this->fpdf->Cell(20, 5,"Approval", 0, 0, "L");
		$this->fpdf->Cell(64, 5,"", "B", 1, "L");  
		
//----------------------------------------------------------

		$this->fpdf->Cell(10, 5,"", "R", 0, "L");	
		$this->fpdf->Cell(26, 5,"Vacation", 1, 0, "C"); 
		$this->fpdf->Cell(26, 5,"Sick", 1, 0, "C"); 
		$this->fpdf->Cell(26, 5,"Total", 1, 0, "C"); 		
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(17, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(83, 5,"", "B", 1, "C");
		
//----------------------------------------------------------
		if($_GET['leavetype'] == 'monetization'){
			$intVL = isset($arrLeaveBal['vlBalance']) ? $arrLeaveBal['vlBalance'] : 0;
			$intSL = isset($arrLeaveBal['slBalance']) ? $arrLeaveBal['slBalance'] : 0;
			$intTotal = $intVL + $intSL;
		}
		$this->fpdf->Cell(10, 3,"", "R", 0, "L");	
		$this->fpdf->Cell(26, 6,$intVL, "R", 0, "C"); 
		$this->fpdf->Cell(26, 6,$intSL, "R", 0, "C"); 
		$this->fpdf->Cell(26, 6,$intTotal, "R", 0, "C"); 		
		$this->fpdf->Cell(2, 3,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(10, 3,"", 0, 0, "L");	
		$this->fpdf->Cell(70, 3,"", 0, 1, "C");		
		
//----------------------------------------------------------		

		$this->fpdf->Cell(10, 5,"", "R", 0, "L");	
		$this->fpdf->SetFont('Arial', "BU", 10);
		$this->fpdf->Cell(26, 5,"", "R", 0, "C"); 
		$this->fpdf->Cell(26, 5,"", "R", 0, "C"); 
		$this->fpdf->Cell(26, 5,"", "R", 0, "C"); 		
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 

		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");		
		$this->fpdf->Cell(37, 5,"Disapproval due to", 0, 0, "L");
		$this->fpdf->Cell(47, 5,"", "B", 1, "L");  
		
//----------------------------------------------------------		
		$this->fpdf->Cell(10, 5,"", "R", 0, "L");	
		$this->fpdf->Cell(26, 5,"days", 1, 0, "C"); 
		$this->fpdf->Cell(26, 5,"days", 1, 0, "C"); 
		$this->fpdf->Cell(26, 5,"days", 1, 0, "C"); 		
		$this->fpdf->Cell(2, 7,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(17, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(83, 5,"", "B", 1, "C");

		$this->fpdf->Ln(2);
//----------------------------------------------------------	
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(30, 5,"", 0, 0, "L");	
	// if ($strCertifiedBy)
	// 	$this->fpdf->Cell(58, 5,"".$strSigned, 0, 0, "C"); 
	// else
		$this->fpdf->Cell(58, 5,"", 0, 0, "C"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(40, 5,"", 0, 0, "C");	
	// if ($strRecommendBy)
	// 	$this->fpdf->Cell(60, 5,"".$strSigned, 0, 1, "C"); 
	// else
		$this->fpdf->Cell(60, 5,"", 0, 1, "C");

//----------------------------------------------------------

		$this->fpdf->Cell(30, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
	// if ($strCertifiedBy)
	// 	$this->fpdf->Cell(58, 5,"  "."  ", 0, 0, "C"); 
	// else
		$this->fpdf->Cell(58, 5,"", 0, 0, "C");
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(40, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
	// if ($strRecommendBy)		
	// 	$this->fpdf->Cell(60, 5,"  "."  ", 0, 1, "C");
	// else
		$this->fpdf->Cell(60, 5,"", 0, 1, "C");
		
//----------------------------------------------------------
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(28, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
		// if( strtoupper($strName) == 'RAUL DUMOL')
		// 	$this->fpdf->Cell(60, 5,"MA. MARIVIC TOLEDANO  "."  ", 0, 0, "C"); 
		// else
		// $this->fpdf->Cell(60, 5,"DR. RAUL D. DUMOL  "."  ", 0, 0, "C");
		$this->fpdf->Cell(60, 5,"JESSICA L. MORAL   "."  ", 0, 0, "C"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(25, 5,"",  0, 0, "L");	
		//1st authorized official
		$this->fpdf->SetFont('Arial', "B", 10);
		// $this->fpdf->Cell(60, 5, 0, 0, "C");
		$this->fpdf->Cell(8, 5,"",  0, 0, "C");
		
//----------------------------------------------------------
		$this->fpdf->SetFont('Arial', "B", 10);
		$arrDetails=$this->getEmp($str1stSignatory);
		$FirstSig = count($arrDetails) > 0 ? strtoupper($arrDetails[0]['firstname'].' '.$arrDetails[0]['middleInitial'].'. '.$arrDetails[0]['surname']) : '';
		$this->fpdf->Cell(30, 5,$FirstSig, 0, 0, "C");	
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(30, 5,"", "", 0, "C"); 
		$this->fpdf->Cell(58, 5,"(Personnel Officer)", "T", 0, "C"); 
		$this->fpdf->Cell(2, 8,"", "R", 0, "L");  
		
		$this->fpdf->Cell(20, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(60, 5,"(Authorized Official)", "T", 1, "C");

		$this->fpdf->Ln(3);
//----------------------------------------------------------
		$this->fpdf->Line(10, 210, 200, 210); //------------------------------------------------------------------

		$this->fpdf->Cell(90, 5, "7. C)  APPROVED FOR:", "R", 0, "L");
		$this->fpdf->Cell(90, 5, "7. D)  DISAPPROVED DUE TO:", 0, 1, "L");
		
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(30, 5,"", "B", 0, "L"); 
		$this->fpdf->Cell(48, 5,"days with pay", 0, 0, "L"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(90, 5,"", "B", 1, "C");
		
//----------------------------------------------------------
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(30, 5,"", "B", 0, "L"); 
		$this->fpdf->Cell(48, 5,"days without pay", 0, 0, "L"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(90, 5,"", "B", 1, "C");

//----------------------------------------------------------

		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(30, 5,"", "B", 0, "L"); 
		$this->fpdf->Cell(48, 5,"other (Specify)", 0, 0, "L"); 
		$this->fpdf->Cell(2, 10,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(90, 5,"",0 , 1, "C");

		$this->fpdf->Line(10, 235, 200, 235); //------------------------------------------------------------------
//----------------------------------------------------------
		$this->fpdf->Ln(4);

		$this->fpdf->Cell(55, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
	// if ($strApprovedBy)		
	// 	$this->fpdf->Cell(70, 5,"" .$strSigned, 0, 1, "C"); 
	// else
		$this->fpdf->Cell(70, 5,"", 0, 1, "C"); 

		$this->fpdf->Cell(55, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
		
	// if ($strApprovedBy)
	// 	$this->fpdf->Cell(70, 5,"    ".."    ", 0, 1, "C");  
	// else
		$arrDetails=$this->getEmp($str2ndSignatory);
		$SecondSig = count($arrDetails) > 0 ? strtoupper($arrDetails[0]['firstname'].' '.$arrDetails[0]['middleInitial'].'. '.$arrDetails[0]['surname']) : '';
		$this->fpdf->Cell(70, 5,$SecondSig, 0, 1, "C");  
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(55, 5,"", 0, 0, "L");	
		//signature
		$this->fpdf->SetFont('Arial', "B", 10);	
		$this->fpdf->Cell(30, 5,'', 0, 0, "C");	
		$this->fpdf->Cell(30, 5,'', 0, 0, "C");	
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Ln(0);

		$this->fpdf->Cell(55, 6,"", 0, 0, "L");			
		$this->fpdf->Cell(70, 6,"(Signature)", "T", 1, "C"); 
		

		$this->fpdf->Cell(13, 4,"DATE", 0, 0, "L");			
		$this->fpdf->Cell(40, 4,"", "B", 1, "L"); 
		$this->fpdf->Ln(4);

		$this->fpdf->Cell(55, 5,"", 0, 0, "L");	
		//2nd signatory - authorized official
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(70, 5, "", 0, "C");
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(180, 8,"(Authorized Official)", 0, 1, "C"); 
		
		$this->fpdf->Ln(4);

	// if($strNote){
	// 	$this->fpdf->SetFont('Arial', "BI", 8);		
	// 	$this->fpdf->Cell(0, 5, "*** ".$strNote." ***", 0, 0, "C");
	// }


	}

	function empInfo()
	{
		$sql = "SELECT tblEmpPersonal.empNumber, tblEmpPersonal.surname, tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension, 
						tblEmpPersonal.firstname, tblEmpPersonal.middlename, tblPlantilla.plantillaGroupCode,
						 tblPlantillaGroup.plantillaGroupName, tblEmpPosition.actualSalary, tblEmpPosition.group3, tblEmpPosition.groupCode, tblEmpPosition.positionCode, tblEmpPosition.payrollGroupCode
						
						FROM tblEmpPersonal
						LEFT JOIN tblEmpPosition ON tblEmpPersonal.empNumber = tblEmpPosition.empNumber
						LEFT JOIN tblPlantilla ON tblEmpPosition.itemNumber = tblPlantilla.itemNumber
						LEFT JOIN tblPlantillaGroup ON tblPlantilla.plantillaGroupCode = tblPlantillaGroup.plantillaGroupCode
						WHERE tblEmpPersonal.empNumber = '".$this->session->userdata('sessEmpNo')."'";
            		// WHERE emp_id=$empId";
          // echo $sql;exit(1);				
		$query = $this->db->query($sql);
		return $query->result_array();	

	}	
	
	
	
}
/* End of file Reminder_renewal_model.php */
/* Location: ./application/models/reports/Reminder_renewal_model.php */

	
	

	