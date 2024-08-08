<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ApplicationforLeaveForm_model extends CI_Model {

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
		$today =  date("F j, Y",strtotime(date("Y-m-d")));
		
		$this->fpdf->SetLeftMargin(25);
		$this->fpdf->SetRightMargin(25);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Ln(10);

		$arrGet = $this->input->get();
		
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

	
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(50, 5, "1. OFFICE/AGENCY", "R", 0, "L");
		$this->fpdf->Cell(45, 5, "2. NAME (Last)", 0, 0, "L");
		$this->fpdf->Cell(45, 5, "(First)", 0, 0, "L");
		$this->fpdf->Cell(45, 5, "(Middle)", 0, 1, "L");
		$this->fpdf->Cell(50, 7,"", "R", 0, "C");
		$this->fpdf->Cell(100,7,"", 0, 0, "C");
		$this->fpdf->Cell(45, 7,'', 0, 0, "L");
		$this->fpdf->Cell(45, 7, '', 0, 1, "L");
		$this->fpdf->Line(10, 37, 200, 37); //------------------------------------------------------------------
		$this->fpdf->Cell(50, 5, "3. DATE OF FILING", "R", 0, "L");
		$this->fpdf->Cell(90, 5, "4. POSITION", "R", 0, "L");
		$this->fpdf->Cell(45, 5, "5. SALARY (Monthly)", 0, 1, "L");
		$this->fpdf->Cell(50, 7, "$today", "R", 0, "C");
		$this->fpdf->Cell(90, 7,"", "R", 0, "L");
		$this->fpdf->Cell(45, 7,"", 0, 1, "L");

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
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(74, 5,"Vacation", "R", 0, "L");


		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		// if($strLocal == "local" && $strLeaveType == "VL" )
		// 	$this->fpdf->Cell(6, 5,"x", 1, 0, "C");		
		// else
			// $this->fpdf->Cell(6, 5,"d", 1, 0, "C");					
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");					
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
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");					
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
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");		
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
		$this->fpdf->Cell(6, 5,"", 1, 0, "C");
		$this->fpdf->Cell(30, 5,"Others (Specify)", 0, 0, "L");
		$this->fpdf->Cell(42, 5,"", "B", 0, "L"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		$this->fpdf->Cell(10, 5,"", 0, 0, "L");

		$this->fpdf->Cell(6, 5,"", 1, 0, "C");		
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
		$this->fpdf->Cell(78, 5,"", "B", 0, "C"); 
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
		$this->fpdf->Cell(78, 6,"", "B", 0, "C"); 
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
		$this->fpdf->Cell(90, 5, "7. A)  CERTIFICATION OF LEAVE CREDITS", "R", 0, "L");
		$this->fpdf->Cell(90, 5, "7. B)  RECOMMENDATION:", 0, 1, "L");

		$this->fpdf->Cell(10, 5,"", 0, 0, "L");	
		$this->fpdf->Cell(10, 5,"as of", 0, 0, "L");
		$this->fpdf->Cell(68, 5,"", "B", 0, "L"); 
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
		
		$this->fpdf->Cell(10, 3,"", "R", 0, "L");	
		$this->fpdf->Cell(26, 6,"", "R", 0, "C"); 
		$this->fpdf->Cell(26, 6,"", "R", 0, "C"); 
		$this->fpdf->Cell(26, 6,"", "R", 0, "C"); 		
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
		$this->fpdf->Cell(58, 5,"", 0, 0, "C"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		$this->fpdf->Cell(40, 5,"", 0, 0, "C");	
		$this->fpdf->Cell(60, 5,"", 0, 1, "C");

//----------------------------------------------------------

		$this->fpdf->Cell(30, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(58, 5,"", 0, 0, "C");
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(40, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(60, 5,"", 0, 1, "C");
		
//----------------------------------------------------------
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(28, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(60, 5,"DR. RAUL D. DUMOL  "."  ", 0, 0, "C"); 
		$this->fpdf->Cell(2, 5,"", "R", 0, "L"); 
		
		$this->fpdf->Cell(25, 5,"",  0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(8, 5,"",  0, 0, "C");
		
//----------------------------------------------------------
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(30, 5,"", 0, 0, "C");	
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
		$this->fpdf->Cell(70, 5,"", 0, 1, "C"); 

		$this->fpdf->Cell(55, 5,"", 0, 0, "L");	
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(70, 5,"", 0, 1, "C");  
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(55, 5,"", 0, 0, "L");	
		//signature
		$this->fpdf->SetFont('Arial', "B", 10);	
		$this->fpdf->Cell(30, 5,'', 0, 0, "C");	
		$this->fpdf->Cell(30, 5,'', 0, 0, "C");	
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Ln(5);

		$this->fpdf->Cell(55, 6,"", 0, 0, "L");			
		$this->fpdf->Cell(70, 6,"(Signature)", "T", 1, "C"); 
		
		$this->fpdf->Cell(13, 4,"DATE", 0, 0, "L");			
		$this->fpdf->Cell(40, 4,"", "B", 1, "L"); 
		$this->fpdf->Cell(55, 5,"", 0, 0, "L");	
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(55, 6,"", 0, 0, "L");			
		$this->fpdf->Cell(70, 6,"(Authorized Official)", "T", 1, "C"); 
		$this->fpdf->Ln(4);

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