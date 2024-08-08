<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LeaveBalanceForm_model extends CI_Model {

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
		$this->fpdf->SetMargins(10,25);
		$this->fpdf->SetTextColor(0,0,0);
		$this->fpdf->Ln();
		$this->fpdf->SetFont('Arial','B',14);
		$this->fpdf->Ln(10);
		$this->fpdf->Cell(0,2,'LEAVE BALANCE FORM', 0, 0, 'C');
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','B',10);

			foreach($rs as $t_arrEmpInfo):
				$name = $t_arrEmpInfo['surname'].', '.$t_arrEmpInfo['firstname'].' '.$t_arrEmpInfo['middlename'].''.$t_arrEmpInfo['nameExtension'];
				$this->fpdf->Cell(35,5,'Employee Number: ', 0, 0, 'L');
				$this->fpdf->SetFont('Arial', "", 8);
				$this->fpdf->Cell(65,5,$t_arrEmpInfo['empNumber'], 0, 0, 'L');
				$this->fpdf->SetFont('Arial', "B", 8);
				$this->fpdf->Cell(15,5,'Name: ', 0, 0, 'L');
				$this->fpdf->SetFont('Arial', "", 8);
				$this->fpdf->Cell(0,5,$name, 0, 0, 'L');
				$this->fpdf->Ln(7);
				$this->fpdf->SetFont('Arial', "B", 8);
				$this->fpdf->Cell(35,5,'Division: ', 0, 0, 'L');
				$this->fpdf->SetFont('Arial', "", 8);
				$this->fpdf->Cell(65,5,$t_arrEmpInfo['officeCode'], 0, 0, 'L');
				$this->fpdf->Ln(7);
				$this->fpdf->SetFont('Arial', "B", 8);
				$this->fpdf->Cell(35,5,'1st Day of Service: ', 0, 0, 'L');
				$this->fpdf->SetFont('Arial', "", 8);
				$this->fpdf->Cell(65,5,$t_arrEmpInfo['firstDayGov'], 0, 0, 'L');
				$this->fpdf->SetFont('Arial', "B", 8);
				$this->fpdf->Cell(15,5,'Position: ', 0, 0, 'L');
				$this->fpdf->SetFont('Arial', "", 8);
				$this->fpdf->Cell(65,5,$t_arrEmpInfo['positionCode'], 0, 0, 'L');
				$this->fpdf->Ln(10);
			
				$this->fpdf->SetFont('Arial', "B", 8);
				$this->fpdf->Cell(13, 5, "", "LTR", 0, "C");
				$this->fpdf->Cell(20, 5, "", "LTR", 0, "C");
				$this->fpdf->Cell(71, 5, "VACATION LEAVE", 1, 0, "C");
				$this->fpdf->Cell(63, 5, "SICK LEAVE", 1, 0, "C");
				$this->fpdf->Cell(5, 5, "FL", "LTR", 0, "C");
				$this->fpdf->Cell(5, 5, "PL", "LTR", 0, "C");
				$this->fpdf->Cell(15, 5, "REMARKS", "LTR", 1, "C");

				$this->fpdf->Cell(13, 5, "Period", "LR", 0, "C");
				$this->fpdf->Cell(20, 5, "Particular", "LR", 0, "C");		
				$this->fpdf->Cell(10, 5, "", "LTR", 0, "C");
				$this->fpdf->Cell(24, 5, "Abs Und W/P", 1, 0, "C");
				$this->fpdf->Cell(13, 5, "", "LTR", 0, "C");
				$this->fpdf->Cell(24, 5, "Abs Und WOP", 1, 0, "C");
				$this->fpdf->Cell(10, 5, "", "LTR", 0, "C");
				$this->fpdf->Cell(20, 5, "", "LTR", 0, "C");
				$this->fpdf->Cell(13, 5, "", "LTR", 0, "C");
				$this->fpdf->Cell(20, 5, "", "LTR", 0, "C");
				$this->fpdf->Cell(5, 5, "", "LR", 0, "C");
				$this->fpdf->Cell(5, 5, "", "LR", 0, "C");
				$this->fpdf->Cell(15, 5, "", "LR", 1, "C");

				$this->fpdf->Cell(13, 5, "", "LBR", 0, "C");
				$this->fpdf->Cell(20, 5, "", "LBR", 0, "C");		
				$this->fpdf->Cell(10, 5, "Earned", "LBR", 0, "C");
				$this->fpdf->Cell(12, 5, "tr/ut/hd", 1, 0, "C");
				$this->fpdf->Cell(12, 5, "Leave", 1, 0, "C");
				$this->fpdf->Cell(13, 5, "Balance", "LBR", 0, "C");
				$this->fpdf->Cell(12, 5, "tr/ut/hd", 1, 0, "C");
				$this->fpdf->Cell(12, 5, "Leave", 1, 0, "C");
				$this->fpdf->Cell(10, 5, "Earned", "LBR", 0, "C");
				$this->fpdf->Cell(20, 5, "Abs Und W/P", "LBR", 0, "C");
				$this->fpdf->Cell(13, 5, "Balance", "LBR", 0, "C");
				$this->fpdf->Cell(20, 5, "Abs Und WOP", "LBR", 0, "C");
				$this->fpdf->Cell(5, 5, "", "LBR", 0, "C");
				$this->fpdf->Cell(5, 5, "", "LBR", 0, "C");
				$this->fpdf->Cell(15, 5, "", "LBR", 0, "C");
				$this->fpdf->Ln(15);
			endforeach;

		$this->fpdf->Ln(5);
//
		// if ($_SESSION['FromToLB']["Period"])   //get the month from, year from and To
		// {
		// 	$queryLeaveBal = mysql_query("SELECT * FROM  tblEmpLeaveBalance WHERE  (periodMonth >='".$this->monthfrom."' AND periodYear >='".$this->yearfrom."') AND
		// 			 (periodMonth <='".$this->monthto."' AND periodYear <='".$this->yearto."' ) AND 
		// 			 empNumber='".$t_arrEmpInfo["empNumber"]."'
		// 			 ORDER BY `tblEmpLeaveBalance`.`periodMonth`, `tblEmpLeaveBalance`.`periodYear` ASC");
		// }
		// else
		// {
		// 	$queryLeaveBal = mysql_query("SELECT * FROM  tblEmpLeaveBalance WHERE  
		// 			empNumber='".$t_arrEmpInfo["empNumber"]."'
		// 			 ORDER BY `tblEmpLeaveBalance`.`periodMonth`, `tblEmpLeaveBalance`.`periodYear` ASC");
		// }
		
		
		// $w = array(13,20,10,12,12,13,12,12,10,20,13,20,5,5,15);
		// $Ln = array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L');
		// $this->SetWidths($w);
		// $this->SetAligns($Ln);
				
		// while ($queryRowBal = mysql_fetch_array($queryLeaveBal))
		// {			
		// 	$strMonth = $att->intToMonthName($queryRowBal["periodMonth"]);
		// 	$intPL = $att->getPriveledgeLeave($queryRowBal['empNumber'],$queryRowBal["periodMonth"],$queryRowBal["periodYear"]);
		// 	$this->Row(array($strMonth." ".$queryRowBal["periodYear"],"Ending Balance",$queryRowBal["vlEarned"],$queryRowBal["vltrut_wpay"],$queryRowBal["vl_wpay"],$queryRowBal["vlBalance"],$queryRowBal["vltrut_wopay"],$queryRowBal["vl_wopay"],$queryRowBal["slEarned"],$queryRowBal["slAbsUndWPay"],$queryRowBal["slBalance"],$queryRowBal["slAbsUndWoPay"],$queryRowBal["flBalance"],$intPL,""),1);
		// }
		// $sig=explode('|',PD);	
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(50, 5, '', 0, 0, 'R');
		$this->fpdf->Cell(150, 5, 'CERTIFIED CORRECT', 0, 0, 'C');

		$this->fpdf->Ln(20);

		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(50, 5, '', 0, 0, 'R');
		// $this->fpdf->Cell(150, 5, strtoupper($sig[1]), 0, 0, 'C');
		$this->fpdf->Cell(150, 5, '', 0, 0, 'C');

		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(50, 5, '', 0, 0, 'R');
		// $this->fpdf->Cell(150, 5, $sig[2], 0, 0, 'C');	
		$this->fpdf->Cell(150, 5, '', 0, 0, 'C');	

		$this->fpdf->Ln(15);
		$this->fpdf->AddPage();
		echo $this->fpdf->Output();
	}
	
}
/* End of file ListEducationalAttainment_model.php */
/* Location: ./application/modules/reports/models/reports/ListEducationalAttainment_model.php */