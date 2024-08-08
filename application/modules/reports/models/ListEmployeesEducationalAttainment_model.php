<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEmployeesEducationalAttainment_model extends CI_Model {

	var $w=array(70,70,60,60);

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

	function getSQLData($empno="",$strAppStatus="",$intMonth="")
	{
		
		//$strAppStatus = $_GET['cboAppointmentStatus'];
		$this->db->select('tblEmpPersonal.empNumber, tblEmpSchool.levelCode,
											tblEmpSchool.course,tblEducationalLevel.level');
		
		$this->db->join('tblEmpSchool',
			'tblEmpPersonal.empNumber = tblEmpSchool.empNumber','left');
		$this->db->join('tblEducationalLevel',
			'tblEmpSchool.levelCode = tblEducationalLevel.levelCode','left');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		if($empno!='')
			$this->db->where('tblEmpSchool.empNumber',$empno);
		if($strAppStatus!='')
			$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);

		$this->db->order_by('tblEducationalLevel.level asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function get_degrees()
	{
		$this->db->Select('DISTINCT(courseCode),courseDesc');
		$this->db->where('courseDesc!=','');
		$this->db->order_by('courseDesc');
		$objQuery = $this->db->get('tblCourse');
		return $objQuery->result_array();
	}

	function get_courses($strDegree)
	{
		// $empQuery=mysql_query("SELECT  DISTINCT tblEmpSchool.empNumber, tblEmpSchool.courseCode, tblCourse.courseDesc,  tblEmpPersonal.surname,tblEmpPersonal.firstname,tblEmpPersonal.middlename, 
		// 	tblEmpPersonal.nameExtension,tblEmpPosition.detailedfrom,tblPosition.positionDesc     
		// 				FROM ( tblEmpSchool 
		// 				LEFT  JOIN tblEmpPersonal ON tblEmpSchool.empNumber = tblEmpPersonal.empNumber ) 
		// 				LEFT JOIN tblEmpPosition ON tblEmpPosition.empNumber=tblEmpPersonal.empNumber 
		// 				LEFT JOIN tblPosition ON tblEmpPosition.positionCode = tblPosition.positionCode	
		// 				LEFT  JOIN tblCourse ON tblCourse.courseCode = tblEmpSchool.courseCode 
		// 				WHERE tblEmpSchool.courseCode = '".$degree["courseCode"]."' AND tblEmpSchool.graduated ='Y'
		// 				AND (tblEmpSchool.levelCode ='Ph.D.' || tblEmpSchool.levelCode ='MA/MS' || tblEmpSchool.levelCode ='CLG' || tblEmpSchool.levelCode ='TRT')
		// 				AND tblEmpPosition.statusOfAppointment='In-Service' AND (tblEmpPosition.detailedfrom = '0' OR tblEmpPosition.detailedfrom = '2') 
		// 				ORDER BY tblEmpPersonal.surname ASC, tblEmpPersonal.firstname ASC");
		$this->db->Select('tblEmpSchool.empNumber, tblEmpSchool.courseCode, tblCourse.courseDesc,  tblEmpPersonal.surname,tblEmpPersonal.firstname,tblEmpPersonal.middlename, 
			tblEmpPersonal.nameExtension,tblEmpPosition.detailedfrom,tblPosition.positionDesc');
		$this->db->join('tblEmpPersonal','tblEmpSchool.empNumber = tblEmpPersonal.empNumber','left');
		$this->db->join('tblEmpPosition','tblEmpPosition.empNumber=tblEmpPersonal.empNumber','left');
		$this->db->join('tblPosition','tblEmpPosition.positionCode = tblPosition.positionCode','left');
		$this->db->join('tblCourse','tblCourse.courseCode = tblEmpSchool.courseCode','left');
		$this->db->where('tblEmpSchool.courseCode',$strDegree)->where('tblEmpSchool.graduated','Y')->where("(tblEmpSchool.levelCode ='Ph.D.' || tblEmpSchool.levelCode ='MA/MS' || tblEmpSchool.levelCode ='CLG' || tblEmpSchool.levelCode ='TRT')")->where('tblEmpPosition.statusOfAppointment','In-Service');
		//$this->db->where('','');
		$this->db->order_by('tblEmpPersonal.surname ASC, tblEmpPersonal.firstname ASC');
		$objQuery = $this->db->get('tblEmpSchool');
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->SetFont('Arial','B',10);
		//$this->Cell(0,6,'Republic of the Philippines', 0, 0, 'C');
		//$this->Ln(5);
		//$this->Cell(0,6,$this->agencyName, 0, 0, 'C');
		$this->fpdf->Ln(5);
		//$this->Cell(0,6,$this->agencyAdd, 0, 0, 'C');		
		$this->fpdf->Ln(20);
		//$head = new title();
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Cell(0,6,strtoupper('list of employees by educational attainment'), 0, 0, 'C');
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(0,6,"As of " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(15);	
		//$degQuery=mysql_query("SELECT DISTINCT courseCode,courseDesc from tblCourse where courseDesc!='' order by courseDesc");
		$degQuery = $this->get_degrees();
		foreach($degQuery as $degree)
		//while ($degree=mysql_fetch_array($degQuery))
		{
			// $empQuery=mysql_query("SELECT  DISTINCT tblEmpSchool.empNumber, tblEmpSchool.courseCode, tblCourse.courseDesc,  tblEmpPersonal.surname,tblEmpPersonal.firstname,tblEmpPersonal.middlename, 
			// tblEmpPersonal.nameExtension,tblEmpPosition.detailedfrom,tblPosition.positionDesc     
			// 			FROM ( tblEmpSchool 
			// 			LEFT  JOIN tblEmpPersonal ON tblEmpSchool.empNumber = tblEmpPersonal.empNumber ) 
			// 			LEFT JOIN tblEmpPosition ON tblEmpPosition.empNumber=tblEmpPersonal.empNumber 
			// 			LEFT JOIN tblPosition ON tblEmpPosition.positionCode = tblPosition.positionCode	
			// 			LEFT  JOIN tblCourse ON tblCourse.courseCode = tblEmpSchool.courseCode 
			// 			WHERE tblEmpSchool.courseCode = '".$degree["courseCode"]."' AND tblEmpSchool.graduated ='Y'
			// 			AND (tblEmpSchool.levelCode ='Ph.D.' || tblEmpSchool.levelCode ='MA/MS' || tblEmpSchool.levelCode ='CLG' || tblEmpSchool.levelCode ='TRT')
			// 			AND tblEmpPosition.statusOfAppointment='In-Service' AND (tblEmpPosition.detailedfrom = '0' OR tblEmpPosition.detailedfrom = '2') 
			// 			ORDER BY tblEmpPersonal.surname ASC, tblEmpPersonal.firstname ASC");
			$empQuery = $this->get_courses($degree["courseCode"]);
			if (count($empQuery)>0 AND strlen($degree["courseDesc"])!=0){
				$this->fpdf->SetFont('Arial','B',12);
				$this->fpdf->Cell(0,0,$degree["courseDesc"]);
				$this->fpdf->Ln(4);

				$this->fpdf->SetFont('Arial','B',10);
				$this->fpdf->SetFillColor(200,200,200);
				$this->fpdf->Cell(75,5,"NAME",1,0,'C',1);
				$this->fpdf->Cell(115,5,"OFFICE - POSITION",1,0,'C',1);
				$this->fpdf->Ln(5);
			}
			foreach($empQuery as $emp)
			{
			//while($emp = mysql_fetch_array($empQuery)){

				$this->fpdf->SetFont('Arial','',10);
				
				$name=$emp["surname"].', '.$emp["firstname"].' '.$emp["nameExtension"].' '.mi($emp["middlename"]);
				$name = utf8_decode($name);
				/*
				$this->Cell(20,0,$name);
				$this->Ln(5);
				*/
				
				$strOffice = office_name(employee_office($emp['empNumber']));
				$strOfficePosition = $strOffice.' - '.$emp['positionDesc'];

				$w = array(75,115);
				$Ln = array('L','C');
				$this->fpdf->SetWidths($w);
				$this->fpdf->SetAligns($Ln);
				$this->fpdf->FancyRow(array($name,$strOfficePosition),array(1,1));
				$this->fpdf->Ln();

			}//end inner while
			//$this->fpdf->Ln();
		}//end outer while
		
		 if($this->fpdf->GetY()>195)
			 $this->fpdf->AddPage();
			 
		
			
		$this->fpdf->Ln(20);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','B',12);		
		$this->fpdf->Cell(0,10,"Certified Correct:",0,0,'L');
		

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
			
		
		
		echo $this->fpdf->Output();
	}
	
}
/* End of file ListEmployeesEducationalAttainment_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesEducationalAttainment_model.php */