<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReportCL_rpt_model extends CI_Model {

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
		$dtmComLeave=$arrData['dtmComLeave']=='' ? '' : date("F j, Y",strtotime($arrData['dtmComLeave']));
		$strPurpose=$arrData['strPurpose'];
		$strRecommend='';
		$strApproval=$arrData['strApproval'];

		$dtmMorningIn=$arrData['dtmMorningIn'];
		$dtmMorningOut=$arrData['dtmMorningOut'];
		$dtmAfternoonIn=$arrData['dtmAfternoonIn'];
		$dtmAfternoonOut=$arrData['dtmAfternoonOut'];
		$year= date("Y");

		$this->fpdf->SetTitle('Compensatory Time Off');
		$this->fpdf->SetLeftMargin(10);
		$this->fpdf->SetRightMargin(10);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		$this->fpdf->AddPage('P','','A4');
		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Ln(10);

		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,6,'       FORM A','',0,'L');
		$this->fpdf->Ln(10);

		$this->fpdf->SetFont('Arial','',11);
		$this->fpdf->Cell(20,6,'       ','',0,'C');
		$this->fpdf->Cell(150,6,'       DEPARTMENT OF SCIENCE AND TECHNOLOGY',1,0,'C');
		$this->fpdf->Ln(15);
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Cell(0,6,'REQUEST TO RENDER COMPENSATORY TIME OFF (CTO)','',0,'C');
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Ln(5);

		$arrDetails=$this->empInfo();
		foreach($arrDetails as $row)
			{
			$this->fpdf->Cell(100,6,'       Requested by :','',0,'L');
			$this->fpdf->Cell(32,6,'       Requested on : ',0,'C');
			$this->fpdf->SetFont('Arial','U',10);
			$this->fpdf->Cell(35,6,$dtmComLeave.'',0,0,'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Ln(5);
			$this->fpdf->Cell(20,6,'       Name :',0,0,'L');
			$this->fpdf->SetFont('Arial','U',10);
			$this->fpdf->Cell(80,6,$row['firstname'].' '.$row['middleInitial'].' '.$row['surname'].' '.$row['nameExtension'],0,0,'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Cell(20,6,'       Office :','',0,'C');
			$this->fpdf->SetFont('Arial','U',10);
			$this->fpdf->Cell(50,6,$row['payrollGroupCode'],0,0,'L');
			$this->fpdf->SetFont('Arial','',10);
			$this->fpdf->Ln(10);
			}

		$this->fpdf->Cell(8,6,'      ','',0,'C');
		$this->fpdf->Cell(120,6,'       Purpose/Target Deliverables','TBRL',0,'C');
		$this->fpdf->Cell(50,6,'       Target Date of CTO','TBRL',0,'L');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(8,6,'      ','',0,'C');
		$this->fpdf->Cell(120,6,$strPurpose,'TBRL',0,'L');
		$this->fpdf->Cell(50,6,$dtmComLeave,'TBRL',0,'C');
		$this->fpdf->Ln(15);

		$this->fpdf->Cell(20,6,'       Recommending Approval :','',0,'L');
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(8,6,'       ','',0,'C');
		$arrDetails=$this->getEmp($strRecommend);
		$Recommend=strtoupper($arrDetails[0]['firstname'].' '.$arrDetails[0]['middleInitial'].' '.$arrDetails[0]['surname']);
		$this->fpdf->Cell(20,6,$Recommend,'',0,'L'); 
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(8,6,'       ','',0,'C');
		$this->fpdf->Cell(60,6,'EXECOM Official/Service Director ','T',0,'L'); 

		$this->fpdf->Ln(10);
		$this->fpdf->Cell(80,6,'       ','',0,'C');
		$this->fpdf->Cell(20,6,'       APPROVAL / DISAPPROVAL :','',0,'C');
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(78,6,'       ','',0,'C');
		$arrDetails=$this->getEmp($strApproval);
		if(count($arrDetails) > 0):
			$Approval=strtoupper($arrDetails[0]['firstname'].' '.$arrDetails[0]['middleInitial'].' '.$arrDetails[0]['surname']);
		else:
			$Approval = '';
		endif;
		$this->fpdf->Cell(20,6,'         '.$Approval,'',0,'C'); 
		$this->fpdf->Ln(5);
		$this->fpdf->Cell(60,6,'       ','',0,'C');
		$this->fpdf->Cell(63,6,'Secretary/Authorized Representative ','T',0,'C'); 
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

	
	