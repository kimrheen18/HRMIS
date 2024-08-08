<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ListEducationalAttainment_model extends CI_Model {

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
		if($strAppStatus!='')
			$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		//$strAppStatus = $_GET['cboAppointmentStatus'];
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname,
					tblEmpPersonal.firstname, tblEmpPersonal.middlename, 
					tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension,   
					tblEmpPosition.positionCode, tblPosition.positionDesc,
					tblEmpPosition.statusOfAppointment');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
	
		$this->db->order_by('tblEmpPersonal.birthday, tblEmpPersonal.surname asc, tblEmpPersonal.firstname asc,tblEmpPersonal.middlename asc');
		$objQuery = $this->db->get('tblEmpPersonal');
		// echo $this->db->last_query();
		return $objQuery->result_array();
	}

	function educ_attain($empno)
	{
		// $sql2="SELECT tblEmpSchool.empNumber, tblEmpSchool.levelCode,
		// 													tblEmpSchool.course,tblEducationalLevel.level
		// 											 FROM tblEmpSchool
		// 											 	LEFT JOIN tblEducationalLevel
		// 											 		ON tblEmpSchool.levelCode = tblEducationalLevel.levelCode
		// 											 WHERE tblEmpSchool.empNumber ='$strEmpNumber' AND tblEmpSchool.graduated ='Y'
													 
		// 											 ORDER BY tblEducationalLevel.level asc";
			//echo $sql2.'<br>';//exit(1);
			//$objHighestEducAttainment = mysql_query($sql2);
			//AND (tblEmpSchool.levelCode ='Ph.D.' || tblEmpSchool.levelCode ='MA/MS' || tblEmpSchool.levelCode ='CLG' || tblEmpSchool.levelCode ='TRT')
			//$arrHighestEducAttainment = mysql_fetch_array($objHighestEducAttainment);
			$this->db->Select('tblEmpSchool.empNumber, tblEmpSchool.levelCode,tblEmpSchool.course');
			$this->db->where('tblEmpSchool.empNumber',$empno);
			$this->db->where('tblEmpSchool.graduated','Y');
			$this->db->join('tblEducationalLevel','tblEmpSchool.levelCode = tblEducationalLevel.levelCode','left');
			$this->db->order_by('tblEducationalLevel.levelId asc');
			$objQuery = $this->db->get('tblEmpSchool');
			$rs = $objQuery->result_array();
			return $rs;
	}

	function printBody($t_intCounter, $t_strEmpNumber, $t_strEmpName, $t_strPositionDesc, $t_strCourse)
	{

		$interLigne = 7;
		$this->fpdf->SetFont('Arial','',9);
		$strNameCombine = $t_intCounter.".  ".$t_strEmpName;		
		//$w = array(70,80,90,85);
		$w=$this->w;
		$Ln = array('L','L','L','L');
		$this->fpdf->SetWidths($w);
		$this->fpdf->SetAligns($Ln);
		// $query="SELECT tblEmpPersonal.empNumber, tblEmpSchool.levelCode,
		// 									tblEmpSchool.course,tblEducationalLevel.level 											
		// 								FROM tblEmpPersonal
		// 									LEFT JOIN tblEmpSchool
		// 										ON tblEmpPersonal.empNumber = tblEmpSchool.empNumber
		// 									LEFT JOIN tblEducationalLevel
		// 										ON tblEmpSchool.levelCode = tblEducationalLevel.levelCode
		// 								WHERE (tblEmpSchool.empNumber ='$t_strEmpNumber'
		// 									)											 
		// 								ORDER BY tblEducationalLevel.level asc";//AND tblEmpSchool.course != '$t_strCourse'
		// //echo $query."<Br>";
		// $objEmpEducation = mysql_query($query);
		// $totalNumRows = mysql_num_rows($objEmpEducation);	
		$objEmpEducation = $this->educ_attain($t_strEmpNumber);	
		$intCountEmpEducation = 0;

		$intCtr = 0;
		$this->fpdf->SetFillColor(255,255,255);
		$this->fpdf->SetDrawColor(0,0,0);
		//while($arrHighestEducAttainment = mysql_fetch_array($objEmpEducation))
		foreach($objEmpEducation as $arrHighestEducAttainment)
		{
			$intCtr++;
			
			$intCountEmpEducation++;
			$strCourse = $arrHighestEducAttainment['course'];
			$strLevelCode = $arrHighestEducAttainment['levelCode'];
			//$strLevel = $arrHighestEducAttainment['level'];
		if($intCtr==1)
			$this->fpdf->FancyRow(array($t_strEmpName,$t_strPositionDesc,$t_strCourse,$strCourse),array('T','T','T','T'));
		else
			$this->fpdf->Row(array('','','',$strCourse),array(1,1,1,1));		
		}	//end while
	}	//end of PrintBody

	function generate($arrData)
	{		
		
		$rs=$this->getSQLData($arrData['strAppStatus']);
		$this->fpdf->AddPage('L','A4');
		$this->fpdf->SetTextColor(0,0,0);
		$this->fpdf->Ln();
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,2,'List of Educational Attainment', 0, 0, 'C');

//		$this->Cell(0,2,strtoupper('Employees by Educational Attainment'), 0, 0, 'C');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(0,2,'as of' . " " . date("Y"), 0, 0, 'C');
		$this->fpdf->Ln(5);
		
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->SetFillColor(150,150,150);
		$w=$this->w;
		$this->fpdf->Cell($w[0],10,"",'LTR',0,'C',1);
		$this->fpdf->Cell($w[1],10,"",'LTR',0,'C',1);
		$this->fpdf->Cell($w[2],10,"HIGHEST",'LTR',0,'C',1);
		$this->fpdf->Cell($w[3],10,"OTHER COURSE/",'LTR',0,'C',1);
		$this->fpdf->Ln(10);		
		$this->fpdf->Cell($w[0],10,"EMPLOYEE NAME",'LBR',0,'C',1);
		$this->fpdf->Cell($w[1],10,"POSITION TITLE",'LBR',0,'C',1);
		$this->fpdf->Cell($w[2],10," EDUCATIONAL ATTAINMENT",'LBR',0,'C',1);
		$this->fpdf->Cell($w[3],10,"DEGREE OBTAINED",'LBR',0,'C',1);
		$this->fpdf->Ln(10);

		$intCounter =0;
		foreach($rs as $arrPersonnelInfo):
			$intCounter++;
			$strEmpNumber = $arrPersonnelInfo['empNumber'];
			$strMidName = $arrPersonnelInfo['middlename'];
			$strMiddleName = substr($strMidName,0,1);			
			$strEmpName = $arrPersonnelInfo['firstname']. " ".mi($arrPersonnelInfo['middleInitial']).$arrPersonnelInfo['surname']." ".$arrPersonnelInfo['nameExtension'];
			$strPositionCode = $arrPersonnelInfo['positionCode'];
			$strPositionDesc = $arrPersonnelInfo['positionDesc'];
			$strStatusOfAppointment = $arrPersonnelInfo['statusOfAppointment'];
			// $sql2="SELECT tblEmpSchool.empNumber, tblEmpSchool.levelCode,
			// 												tblEmpSchool.course,tblEducationalLevel.level
			// 										 FROM tblEmpSchool
			// 										 	LEFT JOIN tblEducationalLevel
			// 										 		ON tblEmpSchool.levelCode = tblEducationalLevel.levelCode
			// 										 WHERE tblEmpSchool.empNumber ='$strEmpNumber' AND tblEmpSchool.graduated ='Y'
													 
			// 										 ORDER BY tblEducationalLevel.level asc";
			// //echo $sql2.'<br>';//exit(1);
			// $objHighestEducAttainment = mysql_query($sql2);
			// //AND (tblEmpSchool.levelCode ='Ph.D.' || tblEmpSchool.levelCode ='MA/MS' || tblEmpSchool.levelCode ='CLG' || tblEmpSchool.levelCode ='TRT')
			// $arrHighestEducAttainment = mysql_fetch_array($objHighestEducAttainment);
			$arrHighestEducAttainment = $this->educ_attain($strEmpNumber);
			if(count($arrHighestEducAttainment)>0):
				$strCourse = $arrHighestEducAttainment[0]['course'];
				$strLevelCode = $arrHighestEducAttainment[0]['levelCode'];
			else:
				$strCourse = '';
				$strLevelCode = '';
			endif;
			
			//$strLevel = $arrHighestEducAttainment['level'];
			$this->printBody($intCounter, $strEmpNumber, $strEmpName, $strPositionDesc, $strCourse);
		endforeach;
			
		//$this->printBody($intCounter, $strEmpNumber, $strEmpName, $strPositionDesc, $strCourse);
			
			
		//}	
		
		 if($this->fpdf->GetY()>195)
			 $this->fpdf->AddPage();
			 
		 //$obj = new signatoryName();
		//$arrSig = $obj->createSignatory('RPE');
		//$sig=explode('|',PD);	
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
	
}
/* End of file ListEducationalAttainment_model.php */
/* Location: ./application/modules/reports/models/reports/ListEducationalAttainment_model.php */