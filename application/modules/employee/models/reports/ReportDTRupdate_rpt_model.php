<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReportDTRupdate_rpt_model extends CI_Model {

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper(array('report_helper','general_helper'));	
		$this->load->model(array('hr/Hr_model'));
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

	function intToMonthFull($t_intMonth='')
	{
		$t_intMonth = $t_intMonth=='undefined' ? '' : $t_intMonth;
		if($t_intMonth!=''):
			$arrMonths = array(1=>"January", 2=>"February", 3=>"March", 
							4=>"April", 5=>"May", 6=>"June", 
							7=>"July", 8=>"August", 9=>"September", 
							10=>"October", 11=>"November", 12=>"December");
			return $arrMonths[$t_intMonth];
		else:
			return '';
		endif;
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

		$empno = $arrData['strEmpNo'] == "" ? $_SESSION['sessEmpNo'] : $arrData['strEmpNo'];
		$empname = $arrData['empname'];

		$today =  date("F j, Y",strtotime(date("Y-m-d")));
		$dtmDTRupdate = $arrData['dtmDTRupdate']==''?'':date("F j, Y",strtotime($arrData['dtmDTRupdate']));
		$month = $arrData['dtmDTRupdate']==''?'':date("F",strtotime($arrData['dtmDTRupdate']));

		// old
		$strOldMorningIn= $arrData['strOldMorningIn'] ?: "00:00";
		$strOldMorningOut= $arrData['strOldMorningOut'] ?: "00:00";
		$strOldAfternoonIn= $arrData['strOldAfternoonIn'] ?: "00:00";
		$strOldAfternoonOut= $arrData['strOldAfternoonOut'] ?: "00:00";
		$strOldOvertimeIn= $arrData['strOldOvertimeIn'] ?: "00:00";
		$strOldOvertimeOut= $arrData['strOldOvertimeOut'] ?: "00:00";
		// new
		$dtmMorningIn = $arrData['dtmMorningIn'] ?: "00:00";
		$dtmMorningOut = $arrData['dtmMorningOut'] ?: "00:00";
		$dtmAfternoonIn = $arrData['dtmAfternoonIn'] ?: "00:00";
		$dtmAfternoonOut = $arrData['dtmAfternoonOut'] ?: "00:00";
		$dtmOvertimeIn = $arrData['dtmOvertimeIn'] ?: "00:00";
		$dtmOvertimeOut = $arrData['dtmOvertimeOut'] ?: "00:00";

		$strReason = $arrData['strReason'];
		// $dtmMonthOf = $arrData['dtmMonthOf'];
		
		$strEvidence = $arrData['strEvidence'];
		$strSignatory = $arrData['strSignatory'];

		$this->fpdf->SetTitle('DTR Update Request');
		$this->fpdf->SetLeftMargin(20);
		$this->fpdf->SetRightMargin(20);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		$this->fpdf->AddPage('P','','A4');
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Ln(10);

		$this->fpdf->SetFont('Arial', "B", 12);
		$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
		$this->fpdf->Cell(0, 5, "OFFICE OF THE REGIONAL EXECUTIVE DIRECTOR", 0, 1, "C");		
		$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(0, 5, 'Region VI', 0, 1, "C");
		$this->fpdf->Cell(0, 5, 'Pepita Aquino Steet, Port Area, Iloilo City', 0, 0, "C");	
		$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');


		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Cell(0,6,'DTR Update Request','',0,'C');
		$this->fpdf->Ln(5);

		$this->fpdf->Ln(10);
		$arrDetails=$this->empInfo();
		foreach($arrDetails as $row)
			{
				$this->fpdf->SetFont('Arial', "", 10);		
				$this->fpdf->Cell(15, 5,"Name :"  , 0, 0, "L"); 
				$this->fpdf->SetFont('Arial', "UB", 10);		
				$this->fpdf->Cell(70, 5,$empname, 0, 0, "L"); 
				$this->fpdf->SetFont('Arial', "", 10);		
				$this->fpdf->Cell(30, 5,"Date : ", 0, 0, "C"); 
				$this->fpdf->SetFont('Arial', "UB", 10);	
				$this->fpdf->Cell(10, 5,"$today"."", 0, 0, "C"); 
				$this->fpdf->Ln(15);
			}

	   $this->fpdf->SetFont('Arial', "B", 9);
       $this->fpdf->Cell(86,10,'Previous DTR time',"RLT",0,"C");
	   $this->fpdf->Cell(86,10,'Requested DTR time',"RLT",1,"C");

	   $this->fpdf->SetFont('Arial', "", 9);
	   $this->fpdf->Cell(43,10,'Time In',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$strOldMorningIn,"RLT",0,"C");
	   $this->fpdf->Cell(43,10,'Time In',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$dtmMorningIn,"RLT",1,"C");

	   $this->fpdf->Cell(43,10,'Break Out',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$strOldMorningOut,"RLT",0,"C");
	   $this->fpdf->Cell(43,10,'Break Out',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$dtmMorningOut,"RLT",1,"C");

	   $this->fpdf->Cell(43,10,'Break In',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$strOldAfternoonIn,"RLT",0,"C");
	   $this->fpdf->Cell(43,10,'Break In',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$dtmAfternoonIn,"RLT",1,"C");

	   $this->fpdf->Cell(43,10,'Time Out',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$strOldAfternoonOut,"RLT",0,"C");
	   $this->fpdf->Cell(43,10,'Time Out',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$dtmAfternoonOut,"RLT",1,"C");

	   $this->fpdf->Cell(43,10,'Overtime In',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$strOldOvertimeIn,"RLT",0,"C");
	   $this->fpdf->Cell(43,10,'Overtime In',"RLT",0,"C");
	   $this->fpdf->Cell(43,10,$dtmOvertimeIn,"RLT",1,"C");

	   $this->fpdf->Cell(43,10,'Overtime Out',"RLTB",0,"C");
	   $this->fpdf->Cell(43,10,$strOldOvertimeOut,"RLTB",0,"C");
	   $this->fpdf->Cell(43,10,'Overtime Out',"RLTB",0,"C");
	   $this->fpdf->Cell(43,10,$dtmOvertimeOut,"RLTB",1,"C");

	   $this->fpdf->Ln(5);
	   $this->fpdf->SetFont('Arial', "B", 10);
	   $this->fpdf->Cell(22, 5,"Reason :","",1,"L");
	   $this->fpdf->Cell(22, 5,$strReason,"",1,"L");
	
		
		// $arrDetails=$this->getEmp($strSignatory);
		// $name=strtoupper($arrDetails[0]['firstname'].' '.$arrDetails[0]['middleInitial'].' '.$arrDetails[0]['surname']);
		// $this->fpdf->Cell(70,6,"$name",1,0,"C");
		// $this->fpdf->Cell(35,6,"$strEvidence",1,0,"C");
		// end of table

		$this->fpdf->Ln(15);
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(22, 5,"Submitted by :"  , 0, 0, "C"); 
		$this->fpdf->Cell(172, 5,"Date Submitted : ", 0, 0, "C"); 
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "B", 10);	
		$this->fpdf->Cell(72, 5,$empname, 'B', 0, "L"); 
		$this->fpdf->SetFont('Arial', "U", 10);	
		$this->fpdf->Cell(72, 5,"$today", 0, 0, "C"); 
		$this->fpdf->SetFont('Arial', "", 10);	
			
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(67, 5, "Name of Employee", 0, 0, "C"); 
		$this->fpdf->Cell(110, 5, "", 0, 0, "C"); 
		$this->fpdf->Cell(100, 5, "", 0, 0, "C"); 
		
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "", 8);
		
		echo $this->fpdf->Output();
	}
	

	function empInfo()
		{
			$sql = "SELECT tblEmpPersonal.empNumber, tblEmpPersonal.surname, tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension, 
							tblEmpPersonal.firstname, tblEmpPersonal.middlename, tblPlantilla.plantillaGroupCode,
							 tblPlantillaGroup.plantillaGroupName, tblEmpPosition.group3, tblEmpPosition.groupCode, tblEmpPosition.positionCode, tblEmpPosition.payrollGroupCode
							
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

	
	