<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AccumulatedLeaveCredits_model extends CI_Model {

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');		
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
	
	function getSQLData($t_strEmpNmbr="",$t_strOfc="")
	{
	
		if($t_strEmpNmbr!='')
			$this->db->where('tblEmpPersonal.empNumber',$t_strEmpNmbr);
		if($t_strOfc!='')
			$this->db->where('tblEmpPosition.group3',$t_strOfc);

		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname,tblEmpPersonal.firstname,
		 tblEmpPersonal.middlename,tblEmpPersonal.sex, tblEmpPersonal.nameExtension, tblEmpPersonal.salutation, tblPosition.positionDesc');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
		$this->db->join('tblAppointment',
			'tblAppointment.appointmentCode=tblEmpPosition.appointmentCode ','left');
		$this->db->order_by('tblEmpPersonal.surname, tblEmpPersonal.firstname');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('tblAppointment.leaveEntitled','Y');
		$objQuery = $this->db->get('tblEmpPersonal');
		
		return $objQuery->result_array();
	
	}

	function getLeaveBalance($t_strEmpNmbr, $t_intMonth, $t_intYear)
	{
		$this->db->where('periodMonth',$t_intMonth);
		$this->db->where('periodYear',$t_intYear);
		$this->db->where('empNumber',$t_strEmpNmbr);
		$this->db->order_by('periodYear DESC,periodMonth DESC');
		$this->db->Select('periodMonth,periodYear,vlBalance,slBalance');
		$this->db->limit(1,0);
		$objQuery = $this->db->get('tblEmpLeaveBalance');
		return $objQuery->result_array();
	}

	function printRow($row,$i,$arrGet)
	{
		$rs=$row;
		
		$t_intMonth=$_GET['dtMonth'];
		$t_intYear=$_GET['dtYear'];

		$this->fpdf->SetFont('Arial','',9);
		$this->fpdf->Ln(2	);
		$this->fpdf->Cell(0,5,"DEPARTMENT OF SCIENCE AND TECHNOLOGY",0,0,"C");
		$this->fpdf->Ln();
		$this->fpdf->Cell(0,5,"Bicutan, Taguig City",0,0,"C");
		$this->fpdf->Ln(7);	
				
		$this->fpdf->Cell(0,5,"MEMORANDUM FOR:",0,0,'L');
		$this->fpdf->Ln();
		
		// $PD='RAUL D. DUMOL, DPA|Chief Administrative Officer|Personnel Division';
		// $ALS='TEODORO M. GATCHALIAN, PhD|Assistant Secretary for Administration';
		// $sig=explode('|',$PD);
		// $sig2=explode('|',$ALS);
		
		$strEmployeeName = strtoupper($rs[$i]['salutation']." ".$rs[$i]['firstname']." ".($rs[$i]['middlename']!=""?mi(substr($rs[$i]['middlename'],0,1)):" ").strtoupper($rs[$i]['surname'])." ".strtoupper($rs[$i]['nameExtension']));
		$strPosition = $rs[$i]['positionDesc'];

		$this->fpdf->Cell(0,5,$strEmployeeName,0,0,'L');
		$this->fpdf->Ln();
		
		$this->fpdf->Cell(0,5,$strPosition,0,0,'L');
		$this->fpdf->Ln(7);
		
		$this->fpdf->Cell(0,5,"SUBJECT: Accumulated Leave Credits",0,0,'L');
		$this->fpdf->Ln(6);
		$lb=$this->getLeaveBalance($rs[$i]['empNumber'], $t_intMonth, $t_intYear);

		$day= date('t',strtotime($t_intMonth.'/1/'.$t_intYear));

		$this->fpdf->Cell(0,5,"                Please be informed that your accumulated leave credits as of ".date('F',strtotime(date('Y').'-'.$t_intMonth.'-'.date('d')))." ".$day.", ".$t_intYear." are as follows:",0,0,'L');
		
		$this->fpdf->Ln(6);
		$intVL=0;$intSL=0;
		if(count($lb)>0):
			$intVL = $lb[0]['vlBalance'];
			$intSL = $lb[0]['slBalance'];
		endif;
		$this->fpdf->Cell(50,5,"",0,0,'L');		
		$this->fpdf->Cell(40,5,"Vacation Leave",0,0,'L');		
		$this->fpdf->Cell(5,5,"-",0,0,'C');
		$this->fpdf->Cell(20,5,number_format($intVL,3),0,0,'R');
		//$this->Cell(20,5,'',B,0,'R');
		$this->fpdf->Ln();
		
		$this->fpdf->Cell(50,5,"",0,0,'L');		
		$this->fpdf->Cell(40,5,"Sick Leave",0,0,'L');		
		$this->fpdf->Cell(5,5,"-",0,0,'C');
		$this->fpdf->Cell(20,5,number_format($intSL,3),'B',0,'R');
		//$this->Cell(20,5,'',B,0,'R');
		$this->fpdf->Ln();
		
		$this->fpdf->Cell(50,5,"",0,0,'L');		
		$this->fpdf->Cell(40,5,"TOTAL",0,0,'L');		
		$this->fpdf->Cell(5,5,"-",0,0,'C');
		$this->fpdf->Cell(20,5,number_format($intVL+$intSL,3),0,0,'R');
		//$this->Cell(20,5,'',0,0,'R');
		$this->fpdf->Ln(6);
		
		$this->fpdf->SetWidths(array(0));
		$this->fpdf->Row(array("                Should you wish to verify the accuracy of your earned leave credits, please feel free to inform the Personnel Division. We shall be glad to assist you."), 0);
		//$this->Cell(0,5,"   Should you wish to verify the accuracy of your earned leave credits, please feel free to inform the Personnel Division. We shall be glad to assist you.",0,0,'L');		
		$this->fpdf->Ln(2); 
		
		$this->fpdf->Row(array("                Please be informed likewise that we shall continue reviewing your leave balances to ensure the same are correctly posted."), 0);
		//$this->Cell(0,5,"   Please be informed likewise that we shall continue reviewing your leave balances to ensure the the same are correctly posted.",0,0,'L');
		$this->fpdf->Ln(2);
		
		$this->fpdf->Cell(0,5,"                For your information and guidance.",0,0,'L');
		$this->fpdf->Ln(6);
		
		$this->fpdf->Cell(0,5,"                Thank you.",0,0,'L');
		$this->fpdf->Ln(2);
		
		
		$sig=getSignatories($arrGet['intSignatory']);
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

		//$this->SetFont('Arial','',10);		
		$this->fpdf->Cell(120,10,"",0,0,'C');
		$this->fpdf->Cell(70,10,"Very truly yours,",0,0,'C');
		
		$this->fpdf->Ln(7);
		$this->fpdf->Cell(120,10,"",0,0,'C');
		if(trim($strEmployeeName)=='RAUL D. DUMOL')
		{
			$this->fpdf->Cell(70,10,"MA. VERONICA B. TOLEDANO",0,0,'C');
		}
		else
			$this->fpdf->Cell(70,10,$sigName,0,0,'C');
		

		$this->fpdf->Ln(4);
		$this->fpdf->Cell(120,10,"",0,0,'C');
		if(trim($strEmployeeName)=='RAUL D. DUMOL')
		{
			$this->fpdf->Cell(70,10,"Administrative Officer IV",0,0,'C');
		}
		else
			$this->fpdf->Cell(70,10,$sigPos,0,0,'C');
		//$this->Cell(70,10,"Supervising Administrative Officer",0,0,'C');
		
		
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(120,10,"",0,0,'C');
		// if(trim($strEmployeeName)=='RAUL D. DUMOL')
		// {
		// 	//$strEmployeeName = strtoupper("RHODORA C. ALFONSO");
		// 	//$strPosition = "Supervising Administrative Officer";
		// 	//$this->fpdf->Cell(70,10,"Personnel Division",0,0,'C');
		// }
		// else
		// 	$this->fpdf->Cell(70,10,$sig[0],0,0,'C');
		$this->fpdf->Ln(2);
		
		//$this->fpdf->Cell(120,10,trim(strtoupper($sig2[1]))!=trim($strEmployeeName)?"NOTED:":"",0,0,'L');
		$this->fpdf->Cell(120,10,"NOTED:",0,0,'L');	
		$this->fpdf->Cell(70,10,"",0,0,'C');				
		$this->fpdf->Ln(8);
		
		//$this->Cell(120,10,trim(strtoupper($sig2[1]))!=trim($strEmployeeName)?strtoupper($sig2[1]):"",0,0,'L');

		$sigNoted=getSignatories($arrGet['intSignatoryNoted']);
		if(count($sig)>0)
		{
			$sigNotedName = $sigNoted[0]['signatory'];
			$sigNotedPos = $sigNoted[0]['signatoryPosition'];
		}
		else
		{
			$sigNotedName='';
			$sigNotedPos='';
		}			
		$this->fpdf->Cell(120,10,$sigNotedName,0,0,'L');				
		$this->fpdf->Cell(70,10,"",0,0,'C');
		$this->fpdf->Ln(4);
		//$this->Cell(120,10,trim(strtoupper($sig2[1]))!=trim($strEmployeeName)?$sig2[2].", ".$sig2[0]:"",0,0,'L');		
		$this->fpdf->Cell(120,10,$sigNotedPos,0,0,'L');
		//$this->fpdf->Ln(11);

		//$this->Cell(120,10,"TEODORO M. GATCHALIAN",0,0,'L');				
		//$this->Cell(70,10,"",0,0,'C');
		//$this->Ln(4);
		//$this->Cell(120,10,"Office of the Assistant Secretary for Administration",0,0,'L');		
		$this->fpdf->Ln(6);

		$this->fpdf->SetFont('Arial','',7);
		$this->fpdf->Cell(120,10,date('m/d/Y h:i:s A'),0,0,'L');				
		$this->fpdf->Cell(60,10,"Date Issued:______________________",0,0,'C');
		$this->fpdf->Ln(4);
						

	}
			
	function generate($arrData)
	{		
		
		
		$rs=$this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		if(count($rs)>0)
		{
		for($i=0;$i<sizeof($rs);$i++)		
			{
			$this->fpdf->AddPage();								
			$this->printRow($rs,$i,$arrData);
			$this->fpdf->Cell(120,10,"_______________________________________________________________________________________________________________________",0,0,'L');
			$this->fpdf->Ln(7);
			
			$this->printRow($rs,$i,$arrData);	
			}
		}
		echo $this->fpdf->Output();
	}
	
}
/* End of file AccumulatedLeaveCredits_model.php */
/* Location: ./application/models/reports/AccumulatedLeaveCredits_model.php */