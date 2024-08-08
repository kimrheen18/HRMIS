<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class OfficialBusinessSlip_model extends CI_Model {

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');	
		//ini_set('display_errors','On');
		//$this->load->model(array());
	}
	
	function Footer()
	{		
		$this->fpdf->SetFont('Arial','',7);	
		$this->fpdf->Cell(50,3,date('Y-m-d h:i A'),0,0,'L');
		$this->fpdf->Cell(0,3,"Page ".$this->fpdf->PageNo(),0,0,'R');					
	}
	
	function generate($arrData)
	{
		// $strOBtype=$arrData['strOBtype'];
		// $dtmOBrequestdate = date("F j, Y",strtotime($arrData['dtmOBrequestdate']));
		// $dtmOBdatefrom = date("F j, Y",strtotime($arrData['dtmOBdatefrom']));
		// $dtmOBdateto = date("F j, Y",strtotime($arrData['dtmOBdateto']));
		// $dtmTimeFrom = $arrData['dtmTimeFrom'];
		// $dtmTimeTo = $arrData['dtmTimeTo'];
		// $strDestination = $arrData['strDestination'];
		// $strPurpose = $arrData['strPurpose'];
		// $strOfficial = "";
		// $strPersonal = ""; 

		// if ($strOBtype=='Official')
		// 	$strOfficial = "x";
		// else
		// 	$strPersonal = "x";

		$this->fpdf->SetTitle('Official Business');
		$this->fpdf->SetLeftMargin(25);
		$this->fpdf->SetRightMargin(25);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		$this->fpdf->AddPage('P','','A4');
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Ln(10);

		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->Cell(0,6,'       Republic of the Philippines','',0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Cell(0,6,'       DEPARTMENT OF SCIENCE AND TECHNOLOGY','',0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->Cell(0,6,'       Central Office','',0,'C');
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Cell(0,6,'PERSONNEL TRAVEL PASS','',0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','',10);

		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(75, 5,"[", 0, 0, "R"); 
		$this->fpdf->SetFont('Arial', "B", 10);		
		$this->fpdf->Cell(5, 5,"" , 0, 0, "L"); 
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(10, 5,"]  Official" , 0, 0, "L"); 
		
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(75, 5,"[", 0, 0, "R"); 
		$this->fpdf->SetFont('Arial', "B", 10);		
		$this->fpdf->Cell(5, 5,"", 0, 0, "L");  
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(10, 5,"]  Personal" , 0, 0, "L");

		// $this->fpdf->Ln(10);
		// $rs = $this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'');
		// foreach($rs as $t_arrEmpInfo):
		// 	$this->fpdf->AddPage('P','','A4');
		// 	$extension = (trim($t_arrEmpInfo['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo['nameExtension'];		
		// 	// $position = $t_arrEmpInfo['positionDesc'];
		// 	$strName = $t_arrEmpInfo['firstname']." ".mi($t_arrEmpInfo['middleInitial']).$t_arrEmpInfo['surname'].$extension;
			
			$this->fpdf->Ln(10);
			$this->fpdf->SetFont('Arial', "B", 10);		
			$this->fpdf->Cell(100, 5,""  , 0, 0, "C"); 
			$this->fpdf->Cell(100, 5," ", 0, 0, "C"); 
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(75, 5,"", 0, 0, "C"); 
			// $this->fpdf->Cell(110, 5,$position, 0, 0, "C"); 
		//endforeach;
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(70, 5, "Name", "T", 0, "C"); 
		$this->fpdf->Cell(25, 5, "", 0, 0, "C"); 
		$this->fpdf->Cell(70, 5, "Position / Office", "T", 0, "C"); 
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "B", 10);		
		$this->fpdf->Cell(100, 5,'', 0, 0, "C"); 
		$this->fpdf->Cell(100, 5, "", 0, 0, "C"); 
		$this->fpdf->Ln(1);
		$this->fpdf->Cell(75, 5,"", 0, 0, "L"); 
		$this->fpdf->Cell(110, 5,"", 0, 0, "C"); 

		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(70, 5, "Signature", "T", 0, "C"); 
		$this->fpdf->Cell(25, 5, "", 0, 0, "C"); 
		$this->fpdf->Cell(70, 5, "Date of Application", "T", 0, "C"); 
		  
		$this->fpdf->Ln(15);   
		$this->fpdf->SetFont('Arial', "", 10);	
		$this->fpdf->Cell(2, 5,"", 0, 0, "L"); 	
		$this->fpdf->Cell(25, 5,"DESTINATION :", 0, 0, "L"); 
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->MultiCell(155, 5,"", 0, 'J', 0);
		$this->fpdf->Cell(28, 5,"", 0, 0, "L");
		$this->fpdf->Cell(100, 1,"____________________________________________________________________", 0, 0, "L"); 

		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Arial', "", 10);	
		$this->fpdf->Cell(2, 5,"", 0, 0, "L"); 	
		$this->fpdf->Cell(25, 5,"PURPOSE :", 0, 0, "L"); 
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->MultiCell(140, 5,"", 0, 'J', 0);
		  
		$this->fpdf->Cell(28, 5,"", 0, 0, "L");
		$this->fpdf->Cell(100, 1,"____________________________________________________________________", 0, 0, "L");  

		$this->fpdf->Ln(8);
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(2, 5,"", 0, 0, "L"); 		
		$this->fpdf->Cell(25, 5,"Date of Travel", 0, 0, "L"); 
		$this->fpdf->SetFont('Arial', "B", 10);		
		$this->fpdf->Cell(40, 5,'    :', 0, 0, "L");

		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(80, 5,"Time of Travel :", 0, 0, "C"); 
		$this->fpdf->SetFont('Arial', "B", 10);		
		$this->fpdf->Cell(10, 5, ' - ', 0, 0, "C");

		$this->fpdf->Ln(1); 
		$this->fpdf->Cell(34, 5,"", 0, 0, "L");
		$this->fpdf->SetFont('Arial', "U", 10);
		$this->fpdf->Cell(20, 3,"", 0, 0, "L"); 
		$this->fpdf->Cell(20, 5,"", 0, 0, "C");
		$this->fpdf->Cell(135, 3,"", 0, 0, "C"); 

		$this->fpdf->Ln(15);
		$this->fpdf->SetFont('Arial', "", 10);
		$this->fpdf->Cell(2, 5,"", 0, 0, "L"); 		
		$this->fpdf->Cell(10, 5,"RECOMMENDED BY:", 0, 0, "L"); 
		$this->fpdf->Cell(195, 5,"APPROVED BY:", 0, 0, "C");
		
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial', "B", 10);		
		$this->fpdf->Cell(100, 5,"", 0, 0, "C"); 
		$this->fpdf->Cell(100, 5, "", 0, 0, "C"); 
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(100, 5,"", 0, 0, "C"); 
		$this->fpdf->Cell(100, 5, "", 0, 0, "C"); 

		$this->fpdf->Ln(1);
		$this->fpdf->Cell(75, 5,"___________________________________", 0, 0, "C"); 
		$this->fpdf->Cell(110, 5,"___________________________________", 0, 0, "C"); 		
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial', "", 10);		
		$this->fpdf->Cell(75, 5, "Immediate Supervisor", 0, 0, "C"); 
		$this->fpdf->Cell(110, 5, "Service Chief / EXECOM Concerned", 0, 0, "C"); 
		$this->fpdf->Cell(100, 5, "", 0, 0, "C"); 
	 
 		$this->fpdf->Ln(5);
 		$this->fpdf->SetFont('Arial', "", 10);
 		$this->fpdf->Ln(5);
		$this->fpdf->Cell(230, 5, "Date :  "."", 0, 0, "C"); 
		$this->fpdf->Ln(0);
		$this->fpdf->SetFont('Arial', "B", 10);
		$this->fpdf->Cell(95, 5, "", 0, 0, "C"); 
		$this->fpdf->Cell(20, 5,"___________________________________", 0, 0, "L"); 
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "BI", 8);
		$this->fpdf->Cell(200, 5, "", 0, 0, "C");
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial', "", 8);
		$this->fpdf->Cell(0, 4, "**************** NO SIGNATURE NEEDED. THIS DOCUMENT HAS BEEN APPROVED ONLINE ****************", 0, 1, "C");		
			
		echo $this->fpdf->Output();
	}
	
	// function empInfo()
	// 	{
	// 		$sql = "SELECT tblEmpPersonal.empNumber, tblEmpPersonal.surname, tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension, 
	// 						tblEmpPersonal.firstname, tblEmpPersonal.middlename, tblPlantilla.plantillaGroupCode,
	// 						 tblPlantillaGroup.plantillaGroupName, tblEmpPosition.group3, tblEmpPosition.groupCode, tblEmpPosition.positionCode, tblEmpPosition.payrollGroupCode
							
	// 						FROM tblEmpPersonal
	// 						LEFT JOIN tblEmpPosition ON tblEmpPersonal.empNumber = tblEmpPosition.empNumber
	// 						LEFT JOIN tblPlantilla ON tblEmpPosition.itemNumber = tblPlantilla.itemNumber
	// 						LEFT JOIN tblPlantillaGroup ON tblPlantilla.plantillaGroupCode = tblPlantillaGroup.plantillaGroupCode
	// 						WHERE tblEmpPersonal.empNumber = '".$this->session->userdata('sessEmpNo')."'";
	//             		// WHERE emp_id=$empId";
	//           // echo $sql;exit(1);				
	// 		$query = $this->db->query($sql);
	// 		return $query->result_array();	

	// 	}	

	function getSQLData($t_strEmpNmbr="")
	{
	
		if($t_strEmpNmbr!='')
			$this->db->where('tblEmpPersonal.empNumber',$t_strEmpNmbr);
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