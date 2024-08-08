<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EmployeesProfile_model extends CI_Model {

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
	
	function getSQLData($t_strEmpNmbr="",$t_strOfc="")
	{
		if($t_strEmpNmbr!='')
			$this->db->where('tblEmpPersonal.empNumber',$t_strEmpNmbr);
		if($t_strOfc!='')
			$this->db->where('tblEmpPosition.group3',$t_strOfc);
		
		$this->db->select('tblEmpPersonal.empNumber,tblEmpPersonal.surname, tblEmpPersonal.firstname,tblEmpPersonal.middleInitial, tblEmpPersonal.middlename,tblEmpPersonal.nameExtension,tblEmpPersonal.birthday, tblEmpPersonal.birthplace, tblEmpPosition.statusOfAppointment, tblEmpPosition.firstDayAgency,tblEmpPosition.firstDayGov,tblEmpPosition.positionCode,tblEmpPosition.officeCode,tblEmpExam.examRating,tblEmpExam.examCode');
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblEmpExam','tblEmpExam.empNumber = tblEmpPersonal.empNumber','left');
		$this->db->where("(tblEmpPosition.detailedfrom='2' OR tblEmpPosition.detailedfrom='0')");
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('tblEmpPosition.firstDayGov!=','0000-00-00');
		$this->db->where('tblEmpPosition.firstDayGov!=','');
		$this->db->order_by('tblEmpPosition.firstDayGov ASC, tblEmpPersonal.surname asc, 
				tblEmpPersonal.firstname asc, tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query(); exit(1);
		return $objQuery->result_array();
	}

	function printBody($t_intCounter,$t_strEmpName,$t_strFirstDayGov)
	{		
		$strCmbineName = $t_intCounter. ".  ".$t_strEmpName;
	}

	function generate($arrData)
	{		
		
		$rs=$this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		$this->fpdf->AddPage('P','A4');
		$this->fpdf->SetMargins(25,25);
		$this->fpdf->SetTextColor(0,0,0);
		$this->fpdf->Ln();
		$this->fpdf->SetFont('Times','B',12);
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(0,2,'E M P L O Y E E   P R O F I L E', 0, 0, 'C');
		$this->fpdf->Ln(10);

		foreach($rs as $t_arrEmpInfo):
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(40,5,"EMPLOYEE NAME", 0, 0, 'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(40,5,$t_arrEmpInfo['surname'], "B", 0, 'L');
			$this->fpdf->Cell(40,5,$t_arrEmpInfo['firstname'], "B", 0, 'L');
			$this->fpdf->Cell(0,5,$t_arrEmpInfo['middlename'], "B", 0, 'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(40,5,"", 0, 0, 'L');
			$this->fpdf->Cell(40,5,"(Surname)", 0, 0, 'L');
			$this->fpdf->Cell(40,5,"(Given Name)", 0, 0, 'L');
			$this->fpdf->Cell(0,5,"(Middle Name)", 0, 0, 'L');
			$this->fpdf->Ln(10);
			$this->fpdf->Cell(50,5,"", 0, 0, 'L');
			$this->fpdf->Cell(35,5,"", "B", 0, 'C');
			$this->fpdf->Cell(35,5,date('m/d/Y', strtotime($t_arrEmpInfo['birthday'])), "B", 0, 'C');
			$this->fpdf->Cell(0,5,$t_arrEmpInfo['birthplace'], "B", 0, 'C');
			$this->fpdf->Cell(50,5,"", 0, 0, 'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(50,5,"", 0, 0, 'L');
			$this->fpdf->Cell(35,5,"(Age)", 0, 0, 'C');
			$this->fpdf->Cell(35,5,"(Date)", 0, 0, 'C');
			$this->fpdf->Cell(0,5,"(Place)", 0, 0, 'C');
			// ELIGIBILITIES
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(40,5,"ELIGIBILITIES", 0, 0, 'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Ln(10);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(100,5,"EXAM", "TLRB", 0, 'L');
			$this->fpdf->Cell(0,5,"RATE", "TLRB", 0, 'C');
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(100,5,$t_arrEmpInfo['examCode'], "TLRB", 0, 'L');
			$this->fpdf->Cell(0,5,$t_arrEmpInfo['examRating'], "TLRB", 0, 'C');
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(100,5,"Present Position:", "TLRB", 0, 'L');
			$this->fpdf->Cell(0,5,$t_arrEmpInfo['positionCode'], "TLRB", 0, 'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(100,5,"Place of Assignment:", "TLRB", 0, 'L');
			$this->fpdf->Cell(0,5,$t_arrEmpInfo['officeCode'], "TLRB", 0, 'L');
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(100,5,"Performance Rating:", "TLRB", 0, 'L');
			$this->fpdf->Cell(0,5,"", "TLRB", 0, 'L');
			// EDUCATION
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(40,5,"EDUCATION", 0, 0, 'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Ln(10);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(55,5,"DEGREE", "TLRB", 0, 'L');
			$this->fpdf->Cell(50,5,"RATE", "TLRB", 0, 'C');
			$this->fpdf->Cell(0,5,"SCHOOL", "TLRB", 0, 'C');
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(55,5,"", "TLRB", 0, 'L');
			$this->fpdf->Cell(50,5,"", "TLRB", 0, 'C');
			$this->fpdf->Cell(0,5,"", "TLRB", 0, 'C');
			$this->fpdf->Ln(5);
			// SERVICE RECORD
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(40,5,"SERVICE RECORD (GOVERNMENT SERVICE)", 0, 0, 'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Ln(10);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(55,5,"DESIGNATION", "TLRB", 0, 'L');
			$this->fpdf->Cell(50,5,"AGENCY", "TLRB", 0, 'C');
			$this->fpdf->Cell(0,5,"INCLUSIVE DATES", "TLRB", 0, 'C');
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(55,5,"", "TLRB", 0, 'L');
			$this->fpdf->Cell(50,5,"", "TLRB", 0, 'C');
			$this->fpdf->Cell(0,5,"", "TLRB", 0, 'C');
			$this->fpdf->Ln(5);

			// TRAININGS
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(40,5,"TRAININGS", 0, 0, 'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Ln(10);
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(55,5,"TITLE", "TLRB", 0, 'L');
			$this->fpdf->Cell(50,5,"VENUE", "TLRB", 0, 'C');
			$this->fpdf->Cell(0,5,"DATE", "TLRB", 0, 'C');
			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(55,5,"", "TLRB", 0, 'L');
			$this->fpdf->Cell(50,5,"", "TLRB", 0, 'C');
			$this->fpdf->Cell(0,5,"", "TLRB", 0, 'C');
			$this->fpdf->Ln(20);
		endforeach;
		
		$this->fpdf->Ln(15);

		
		// $this->fpdf->AddPage();
		
		echo $this->fpdf->Output();
	}
	
}
/* End of file ListEducationalAttainment_model.php */
/* Location: ./application/modules/reports/models/reports/ListEducationalAttainment_model.php */