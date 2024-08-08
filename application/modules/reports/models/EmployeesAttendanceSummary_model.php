<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EmployeesAttendanceSummary_model extends CI_Model {

	var $w=array(70,70,60,60);
	var $agencyName,$agencyAdd,$agencyNum,$agencyPhilNum,$agencyTin;

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

	function getSQLData($strAppStatus="",$intMonth="")
	{
		if($strAppStatus!=''):
			if($strAppStatus=='P')
			{
				$arrPermGroup = getPermanentGroup();
				if(count($arrPermGroup)>0)
				{
					$arrGroup = explode(',',$arrPermGroup[0]['processWith']);
					$strGroup = implode('","',$arrGroup);
					$this->db->where_in('tblEmpPosition.appointmentCode',$arrGroup);
				}
			}
			else
				$this->db->where('tblEmpPosition.appointmentCode',$strAppStatus);
		endif;
		if($intMonth!='')
			$this->db->like('tblEmpPersonal.birthday','%-'.($intMonth<10?'0'.$intMonth:$intMonth).'-%');
		//$strAppStatus = $_GET['cboAppointmentStatus'];
		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname,tblEmpPersonal.firstname,
			tblEmpPersonal.middleInitial, tblEmpPersonal.middlename, tblEmpPersonal.nameExtension, 
			tblEmpPersonal.birthday,tblEmpPosition.statusOfAppointment,
			tblPosition.positionDesc ,SUBSTR(tblEmpPersonal.birthday, 6, 2) as day');
		$this->db->join('tblEmpPosition',
			'tblEmpPersonal.empNumber = tblEmpPosition.empNumber','left');
		$this->db->join('tblPosition',
			'tblEmpPosition.positionCode = tblPosition.positionCode','left');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where("(tblEmpPosition.detailedfrom='0' OR tblEmpPosition.detailedfrom='2')");
		$this->db->order_by('tblEmpPersonal.surname ASC,tblEmpPersonal.firstname ASC');
		$objQuery = $this->db->get('tblEmpPersonal');
		// echo $this->db->last_query(); exit(1);
		return $objQuery->result_array();
	}


	function generate($arrData)
	{		
		$this->fpdf = new FPDF('L','mm','Legal');
		$this->fpdf->AliasNbPages();
		$this->fpdf->Open();

		$this->fpdf->AddPage('L','Legal');
		$this->setOfficeInfo();
		$this->printHeader();

		// $this->fpdf->Cell(339,4,'','LRT',0,'C');
		$this->fpdf->Ln(2);
		
		//$this->fpdf->Cell(5,4,' ',0,0,'C');				//  space				//  space
		// $this->fpdf->Cell(339,4,'               I certify to the correctness of the entries from columns 6 to 17 and that employees','LR',0,'L');
		// $this->fpdf->Ln(4);
		
		// //$this->fpdf->Cell(5,4,' ',0,0,'C');				//  space
		// $this->fpdf->Cell(339,4,'     whose names appear on the above plantilla are the incumbents of the positions.','LRB',0,'L');
		// $this->fpdf->Ln(4);

		 // if($this->fpdf->GetY()>195)
			//  $this->fpdf->AddPage('L','Legal');
			 
		
			
		$this->fpdf->Ln(20);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','',7);		
		$this->fpdf->Cell(150,4,"Note: On Travel with SO:",0,0,'L');
		$this->fpdf->Cell(50,4,"Legend: SL - Sick Leave VL/FL - Vacation Leave/Force Leave",0,0,'C');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(64,4,"",0,0,'C');
		$this->fpdf->Cell(136,4,"Period, SO No.",0,0,'L');
		$this->fpdf->Cell(50,4,"PL - Privilege Leave ML/PTL - Maternity Leave/Paternity Leave",0,0,'L');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(239,4,"AWOL - Absent w/o official Leave",0,0,'R');
		

		// $sig=getSignatories($arrData['intSignatory']);
		// if(count($sig)>0)
		// {
		// 	$sigName = $sig[0]['signatory'];
		// 	$sigPos = $sig[0]['signatoryPosition'];
		// }
		// else
		// {
		// 	$sigName='';
		// 	$sigPos='';
		// }
		$this->fpdf->Ln(20);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','B',12);		
		$this->fpdf->Cell(0,10,"",0,0,'L');

		$this->fpdf->Ln(4);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','',12);				
		$this->fpdf->Cell(0,10,"",0,0,'L');
		
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(30);
		$this->fpdf->Cell(30);				
		$this->fpdf->SetFont('Arial','',12);				
		//$this->fpdf->Cell(0,10,$sig[0],0,0,'L');
		$this->fpdf->Ln(15);
			
		
		
		echo $this->fpdf->Output();
	}
	

	function printHeader()
	{
		//$col = 5;//space
		$col1 = 35;//Item Number
		$col2 = 17;//Position Title and Salary Grade
		$col3 = 17;//Annual Salary Authorized
		$col4 = 17;//Annual Salary Actual
		$col5 = 15;//STEP
		$col6 = 15;//AREA Code
		$col7 = 15;//area type
		$col8 = 15;//lvl
		$col9 = 20;//P/P/A Attribution
		$col10 = 20;//name of Incumbent
		$col11 = 20;//Sex
		$col12 = 25;//Date of Birth
		$col13 = 50;//TIN
		// $col14 = 18;//Date of Original Appointment
		// $col15 = 18;//Date of Last Promotion
		// $col16 = 5;//Status
		// $col17 = 20;//Civil Service Eligibility
		// $col18 = 20;//Remarks
		// $col = array(35,17,17,17,15,15,15,15,20,20,20,25,50,18,18,5,20,20);
		$col = array(35,17,17,17,15,15,15,15,20,20,20,25,50);
		$InterLigne = 4;

		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,2,'', 0, 0, 'C');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,0,getAgencyName(), 0, 0, 'C');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,2,'EMPLOYEES ATTENDANCE SUMMARY', 0, 0, 'C');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,2,'CY '.date('Y'), 0, 0, 'C');
		$this->fpdf->Ln(4);
		// $this->fpdf->Cell(0,2,'(Pursuant to RA NO. 7916 as Amended by RA 8748)',0, 0, 'C');
		$this->fpdf->Ln(4);

		$this->fpdf->Cell(0,2,'Name:', 0, 0, 'L');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,2,'Position:', 0, 0, 'L');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,2,'Division:',0, 0, 'L');
		$this->fpdf->Ln(8);
		
		$this->intPageNo = $this->fpdf->PageNo();
		
		//$this->fpdf->Ln(4);
		$itemNumberCol = 41;
		$salCol = 17;
		$incumbentCol = 55;
		$this->fpdf->SetFont('Arial','B',8);
		//  first line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,'Entries','LTR',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,' ','LTR',0,'C');						//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2]+$col[3],$InterLigne,'Tardy/Undertime','LTRB',0,'C');	//  Annual Salary
		$this->fpdf->Cell($col[4]+$col[5]+$col[6]+$col[7],$InterLigne,'Approved No. of Days N','LTBR',0,'C');						//  Step 
		$this->fpdf->Cell($col[8],$InterLigne,'','LTR',0,'C');						//  P/P/A Attribution
		$this->fpdf->Cell($col[9]+$col[10]+$col[11],$InterLigne,'Official Business','LTRB',0,'C');	
		$this->fpdf->Cell($col[12],$InterLigne,' ','LBTR',0,'C');						//  TIN
		// $this->fpdf->Cell($col[13],$InterLigne,'Date of','LT',0,'C');				//  Date of Original Appointment
		// $this->fpdf->Cell($col[14],$InterLigne,'Date of','LTR',0,'C');				//  Date of Last Promotion
		// $this->fpdf->Cell($col[15],$InterLigne,'S','LT',0,'C');						//  Status
		// $this->fpdf->Cell($col[16],$InterLigne,' ','LT',0,'C');						//  CS Eligibility
		// $this->fpdf->Cell($col[17],$InterLigne,' ','LTR',0,'C');					//  Remarks
		$this->fpdf->Ln(4);

		//  second line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,'Certified','L',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,'CY '.date('Y'),'L',0,'C');						//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,'No. of ','L',0,'C');						//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,'Total ','L',0,'C');						//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'','LR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'','L',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'','L',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,' ','L',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,'Number','L',0,'C');						//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,'','L',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,' ','L',0,'C');						//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','LR',0,'C');						//  TIN
		// $this->fpdf->Cell($col[13],$InterLigne,'Original','L',0,'C');				//  Date of Original Appointment
		// $this->fpdf->Cell($col[14],$InterLigne,'Last','L',0,'C');					//  Date of Last Promotion
		// $this->fpdf->Cell($col[15],$InterLigne,'T','L',0,'C');						//  Status
		// $this->fpdf->Cell($col[16],$InterLigne,'Civil','L',0,'C');					//  CS Eligibility
		// $this->fpdf->Cell($col[17],$InterLigne,' ','LR',0,'C');						//  Remarks
		$this->fpdf->Ln(4);
		
		//  third line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,'Correct by','L',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,'','L',0,'C');			//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,'Times','L',0,'C');						//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,'Hrs/Min/Sec','L',0,'C');						//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'SL','LR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'VL/FL','L',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'PL','L',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,'ML/PTL','L',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,'AWOL','L',0,'C');				//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,'Date','L',0,'C');		//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,'Time','L',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,'Purpose','L',0,'C');						//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,'Remarks','LR',0,'C');					//  TIN

		$this->fpdf->Ln(4);

		$this->fpdf->Cell($col[0],$InterLigne,'HRMO III','L',0,'C');				//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,'','L',0,'C');				//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,'','L',0,'C');				//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,'','L',0,'C');					//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'','LR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'','L',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'','L',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,'','L',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,'of Days','L',0,'C');					//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,'','L',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,'','L',0,'C');					//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','LR',0,'C');						//  TIN

		$this->fpdf->Ln(4);
		$this->fpdf->Cell($col[0],$InterLigne,'','LBT',0,'C');				//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,'','LBT',0,'C');				//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,'','LTB',0,'C');				//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,'','LTB',0,'C');					//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'','LTRB',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'','LTB',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'','LTB',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,'','LTB',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,'','LTB',0,'C');					//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','LTB',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,'','LTB',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,'','LTB',0,'C');					//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','LTBR',0,'C');						//  TIN

		$this->fpdf->Ln(4);
	}

	function printGroupName($groupName)
	{	
		//$col = 3;//space
		// $col1 = 35;//Item Number
		// $col2 = 55;//Position Title and Salary Grade
		// $col3 = 17;//Annual Salary Authorized
		// $col4 = 17;//Annual Salary Actual
		// $col5 = 5;//STEP
		// $col6 = 7;//AREA Code
		// $col7 = 5;//area type
		// $col8 = 5;//lvl
		// $col9 = 20;//P/P/A Attribution
		// $col10 = 50;//name of Incumbent
		// $col11 = 5;//Sex
		// $col12 = 17;//Date of Birth
		// $col13 = 20;//TIN
		// $col14 = 18;//Date of Original Appointment
		// $col15 = 18;//Date of Last Promotion
		// $col16 = 5;//Status
		// $col17 = 20;//Civil Service Eligibility
		// $col18 = 20;//Remarks
		$col = array(35,55,17,17,5,7,5,5,20,50,5,17,20,18,18,5,20,20);
		/*
		$w = array($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$col10,$col11,$col12,$col13,$col14,$col15,$col16,$col17,$col18);
		$Ln = array('L','L','L','L','L','L','L','L','L','L','L','L','C','C','C','C','C','C');
		$this->SetWidths($w);
		$this->SetAligns($Ln);
		*/
		$InterLigne = 4;
		$itemNumberCol = 41;
		$salCol = 17;
		$incumbentCol = 55;		
		//  body first column
		$this->fpdf->SetFont('Arial','B',6);
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'L');				//  space
		$this->fpdf->Cell($col[0],$InterLigne,' ','L',0,'L');		//  Item Number
		$this->fpdf->Cell($col[1],$InterLigne,' ','L',0,'L');				//  Position Title
		$this->fpdf->Cell($col[2],$InterLigne,' ','L',0,'L');			//  Annual Salary Authorized
		$this->fpdf->Cell($col[3],$InterLigne,' ','LR',0,'L');	//  Annual Salary - Actual
		$this->fpdf->Cell($col[4],$InterLigne,' ','LR',0,'L');		//  STEP
		$this->fpdf->Cell($col[5],$InterLigne,' ','L',0,'L');			//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,' ','L',0,'L');			//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,' ','L',0,'L');			//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,' ','L',0,'L');			//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'L');			//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,' ','L',0,'L');			//  SEX
		$this->fpdf->Cell($col[11],$InterLigne,' ','L',0,'L');			//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','L',0,'C');			//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,' ','L',0,'C');				//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,' ','L',0,'C');		//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,' ','LR',0,'C');	//  Status
		$this->fpdf->Cell($col[16],$InterLigne,' ','L',0,'C');	//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,' ','LR',0,'C');	//  remarks
		$this->fpdf->Ln(4);
//pao		

		$InterLigne = 4;

		$groupNameFirst = substr($groupName, 0, 34);
		$groupNameSecond = substr($groupName, 34, strlen($groupName)-1);


		//  body first column
		$this->fpdf->SetFont('Arial','B',8);
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'L');				//  space
		$this->fpdf->Cell($col[0],$InterLigne,' ','L',0,'L');		//  Item Number
		$this->fpdf->Cell($col[1],$InterLigne,$groupNameFirst,'L',0,'L');				//  Position Title
		$this->fpdf->Cell($col[2],$InterLigne,' ','L',0,'L');			//  Annual Salary Authorized
		$this->fpdf->Cell($col[3],$InterLigne,' ','LR',0,'L');	//  Annual Salary - Actual
		$this->fpdf->Cell($col[4],$InterLigne,' ','LR',0,'L');		//  Step
		$this->fpdf->Cell($col[5],$InterLigne,' ','LR',0,'L');		//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,' ','LR',0,'L');		//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,' ','LR',0,'L');		//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,' ','LR',0,'L');		//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'L');			//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,' ','L',0,'C');			//  SEX
		$this->fpdf->Cell($col[11],$InterLigne,' ','L',0,'C');				//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','L',0,'C');	//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,' ','L',0,'C');		//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,' ','LR',0,'L');		//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,' ','LR',0,'C');	//  Status
		$this->fpdf->Cell($col[16],$InterLigne,' ','LR',0,'L');		//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,' ','LR',0,'L');		//  Remarks
		$this->fpdf->Ln(4);

		

		if(strlen($groupName)>=34)
		{
			$this->printGroupNameNextLine($groupNameSecond);
		}	

	}
	
	function printGroupNameNextLine($groupNameSecond)
	{
		//$col = 5;//space
		// $col1 = 35;//Item Number
		// $col2 = 55;//Position Title and Salary Grade
		// $col3 = 17;//Annual Salary Authorized
		// $col4 = 17;//Annual Salary Actual
		// $col5 = 5;//STEP
		// $col6 = 7;//AREA Code
		// $col7 = 5;//area type
		// $col8 = 5;//lvl
		// $col9 = 20;//P/P/A Attribution
		// $col10 = 50;//name of Incumbent
		// $col11 = 5;//Sex
		// $col12 = 17;//Date of Birth
		// $col13 = 20;//TIN
		// $col14 = 18;//Date of Original Appointment
		// $col15 = 18;//Date of Last Promotion
		// $col16 = 5;//Status
		// $col17 = 20;//Civil Service Eligibility
		// $col18 = 20;//Remarks		
		$InterLigne = 4;
		$itemNumberCol = 41;
		$salCol = 17;
		$incumbentCol = 55;
		$col = array(35,55,17,17,5,7,5,5,20,50,5,17,20,18,18,5,20,20);
		//  body first column
		$this->fpdf->SetFont('Arial','B',8);
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'L');				//  space
		$this->fpdf->Cell($col[0],$InterLigne,' ','L',0,'L');		//  Item Number
		$this->fpdf->Cell($col[1],$InterLigne,$groupNameSecond,'L',0,'L');				//  Position Title
		$this->fpdf->Cell($col[2],$InterLigne,' ','L',0,'L');			//  Annual Salary Auhtorized
		$this->fpdf->Cell($col[3],$InterLigne,' ','LR',0,'L');	//  Annual Salary - Actual
		$this->fpdf->Cell($col[4],$InterLigne,' ','LR',0,'L');		//  Step
		$this->fpdf->Cell($col[5],$InterLigne,' ','LR',0,'L');		//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,' ','LR',0,'L');		//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,' ','LR',0,'L');		//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,' ','LR',0,'L');		//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'L');			//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,' ','LR',0,'L');		//  SEX
		$this->fpdf->Cell($col[11],$InterLigne,' ','LR',0,'L');		//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','LR',0,'L');		//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,' ','L',0,'C');	//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,' ','L',0,'C');		//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,' ','LR',0,'C');	//  Status
		$this->fpdf->Cell($col[16],$InterLigne,' ','LR',0,'L');		//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,' ','LR',0,'LR');		//  Remarks
		$this->fpdf->Ln(4);

	}	
	
	function printBody($t_intCounter, $t_strName, $t_strSex, $t_strBirthday, $t_intTin, $t_strPositionDesc, $t_strItemNumber, $t_strAuthorizeSalary, $t_strActualSalary, $t_strStepNumber, $t_strSalaryGradeNumber, $t_strAppointmentCode, $t_strPositionDate, $t_strFirstDayAgency, $t_strExamType, $t_strWorkNature, $t_strEducal, $t_strExamDesc,$t_strAreaCode='',$t_strAreaType='',$t_strLvl='') 
	{
		$InterLigne = 4;

		$t_strNameCmbne = $t_strName;
		//$col = 5;//space
		// $col1 = 35;//Item Number
		// $col2 = 55;//Position Title and Salary Grade
		// $col3 = 17;//Annual Salary Authorized
		// $col4 = 17;//Annual Salary Actual
		// $col5 = 5;//STEP
		// $col6 = 7;//AREA Code
		// $col7 = 5;//area type
		// $col8 = 5;//lvl
		// $col9 = 20;//P/P/A Attribution
		// $col10 = 50;//name of Incumbent
		// $col11 = 5;//Sex
		// $col12 = 17;//Date of Birth
		// $col13 = 20;//TIN
		// $col14 = 18;//Date of Original Appointment
		// $col15 = 18;//Date of Last Promotion
		// $col16 = 5;//Status
		// $col17 = 20;//Civil Service Eligibility
		// $col18 = 20;//Remarks
		$col = array(35,55,17,17,5,7,5,5,20,50,5,17,20,18,18,5,20,20);
		$itemNumberCol = 41;
		$salCol = 17;
		$incumbentCol = 55;

		//  body first column
		$this->fpdf->SetFont('Arial','',6);
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'L');													//  space
		//$this->fpdf->Cell($col1,$InterLigne,$t_strItemNumber,'L',0,'L');									//  Item Number
		//$this->fpdf->Cell($col2,$InterLigne,$t_strPositionDesc." - ".$t_strSalaryGradeNumber,'L',0,'L');	//  Position Title
		//$this->fpdf->Cell($col3,$InterLigne,"",'L',0,'L');												//  Annual Salary Authorized
		
		if ($t_strActualSalary != $t_strAuthorizeSalary)
		{
			// if($t_strAuthorizeSalary=='')
			// 	$this->fpdf->Cell($col3,$InterLigne,'-','LR',0,'L');		//  Annual Salary - Authorized
			// else
			// 	$this->fpdf->Cell($col3,$InterLigne,$t_strAuthorizeSalary,'LR',0,'L');		//  Annual Salary - Authorized
			if($t_strAuthorizeSalary=='')
				$t_strAuthorizeSalary='-';
			
			if($t_strActualSalary=='')
				$t_strActualSalary='-';
		}
		else
		{
			$t_strActualSalary='-';
			// $this->fpdf->Cell($col3,$InterLigne,$t_strAuthorizeSalary,'LR',0,'L');	//  Annual Salary - Authorized
			// $this->fpdf->Cell($col4,$InterLigne,'-','LR',0,'L');		//  Annual Salary - Adjusted
		}
		//$this->fpdf->Cell($col5,$InterLigne,$t_strStepNumber,'L',0,'C');				//  Step	
		//$this->fpdf->Cell($col6,$InterLigne,$t_strAreaCode,'L',0,'C');				//  Area Code	
		//$this->fpdf->Cell($col7,$InterLigne,$t_strAreaType,'L',0,'C');				//  Area Type	
		//$this->fpdf->Cell($col8,$InterLigne,$t_strLvl,'L',0,'C');				//  LVL	
		//$this->fpdf->Cell($col9,$InterLigne,"",'L',0,'C');				//  P/P/A Attribution
		//$this->fpdf->Cell($col10,$InterLigne,$t_strNameCmbne,'L',0,'L');			//  Name of Incumbent
		//$this->fpdf->Cell($col11,$InterLigne,substr($t_strSex,0,1),'L',0,'C');				//  SEX
		//convert birthday
		$arrBday = explode("-",$t_strBirthday);
		$strBirthday = $arrBday[1]."-".$arrBday[2]."-".$arrBday[0];
		//$this->fpdf->Cell($col12,$InterLigne,$strBirthday,'L',0,'C');				//  Date of Birth
		//$this->fpdf->Cell($col13,$InterLigne,$t_intTin,'L',0,'C');				//  TIN
		//convert original appointment
		$arrFDA = explode("-",$t_strFirstDayAgency);
		$strFirstDayAgency = $arrFDA[1]."-".$arrFDA[2]."-".$arrFDA[0];		
		//$this->fpdf->Cell($col14,$InterLigne,$strFirstDayAgency,'L',0,'C');		//  Date of Original Appointment
		//convert last promotion
		$arrLP = explode("-",$t_strPositionDate);
		if($t_strPositionDate!='')
			$strPositionDate = $arrLP[1]."-".$arrLP[2]."-".$arrLP[0];
		else
			$strPositionDate = '';	
		//$this->fpdf->Cell($col15,$InterLigne,$strPositionDate,'L',0,'C');			//  Date of Last Promotion
		//$this->fpdf->Cell($col16,$InterLigne,substr($t_strAppointmentCode,0,1),'LR',0,'C');		//  Status
		// test field that may exceed the column line
		if(strlen($t_strExamDesc)>=26)
			{
			$t_strExamDesc1 = substr($t_strExamDesc, 0, 24);
			$t_strExamDesc2 = substr($t_strExamDesc, 24, strlen($t_strExamDesc)-1);
			//$this->fpdf->Cell($col17,$InterLigne,$t_strExamDesc1,'LR',0,'C');			//  CS
			}
		else	{
			//$this->fpdf->Cell($col17,$InterLigne,$t_strExamDesc,'LR',0,'C');			//  CS
			}	

		//$this->fpdf->Cell($col18,$InterLigne,"",'LR',0,'C');						//  Remarks
		//$this->fpdf->Ln(4);
		
		// if(strlen($t_strExamDesc)>=26)
		// {
		// 	$this-> printBodyNextLine('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $t_strExamDesc2);
		// }
		$this->fpdf->SetWidths($col);
		$aligns = array('C','L','R','R','C','C','C','C','C','L','C','C','C','C','C','C','C','C');
		$this->fpdf->SetAligns($aligns);
		$this->fpdf->FancyRow(array($t_strItemNumber,$t_strPositionDesc." - ".$t_strSalaryGradeNumber,$t_strAuthorizeSalary,$t_strActualSalary,$t_strStepNumber,$t_strAreaCode,$t_strAreaType,$t_strLvl,'',$t_strNameCmbne,substr($t_strSex,0,1),$strBirthday,$t_intTin,$strFirstDayAgency,$strPositionDate,substr($t_strAppointmentCode,0,1),$t_strExamDesc,$this->fpdf->GetY().''),array('LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR'),$aligns);
		// if($this->fpdf->GetY()<0)
		// {
		// 	$this->fpdf->SetY(-5);
		// 	$this->fpdf->Line(10,45,349,45);
		// }

	}
	
	// if next line
		// Body
	function printBodyNextLine($t_intCounter, $t_strName, $t_strSex, $t_strBirthday, $t_intTin, $t_strPositionDesc, $t_strItemNumber, $t_strAuthorizeSalary, $t_strActualSalary, $t_strStepNumber, $t_strSalaryGradeNumber, $t_strAppointmentCode, $t_strPositionDate, $t_strFirstDayAgency, $t_strExamType, $t_strWorkNature, $t_strEducal, $t_strExamDesc) 
	{
		$col = 5;//space
		$col1 = 35;//Item Number
		$col2 = 55;//Position Title and Salary Grade
		$col3 = 17;//Annual Salary Authorized
		$col4 = 17;//Annual Salary Actual
		$col5 = 5;//STEP
		$col6 = 7;//AREA Code
		$col7 = 5;//area type
		$col8 = 5;//lvl
		$col9 = 20;//P/P/A Attribution
		$col10 = 50;//name of Incumbent
		$col11 = 5;//Sex
		$col12 = 17;//Date of Birth
		$col13 = 20;//TIN
		// $col14 = 18;//Date of Original Appointment
		// $col15 = 18;//Date of Last Promotion
		// $col16 = 5;//Status
		// $col17 = 20;//Civil Service Eligibility
		// $col18 = 20;//Remarks		
		$InterLigne = 4;
		$itemNumberCol = 41;
		$salCol = 17;
		$incumbentCol = 55;		
		//  body first column
		$this->fpdf->SetFont('Arial','',7);
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'L');				//  space
		$this->fpdf->Cell($col1,$InterLigne,'','L',0,'L');		//  Item Number
		$this->fpdf->Cell($col2,$InterLigne,'','L',0,'L');				//  Position Title
		$this->fpdf->Cell($col3,$InterLigne,'','L',0,'L');			//  Annual Salary Auhtorized
		$this->fpdf->Cell($col4,$InterLigne,'','LR',0,'L');	//  Annual Salary - Actual
		$this->fpdf->Cell($col5,$InterLigne,'','LR',0,'L');		//  Step
		$this->fpdf->Cell($col6,$InterLigne,'','LR',0,'L');		//  Area Code
		$this->fpdf->Cell($col7,$InterLigne,'','LR',0,'L');		//  Area Type
		$this->fpdf->Cell($col8,$InterLigne,'','LR',0,'L');		//  LVL
		$this->fpdf->Cell($col9,$InterLigne,'','LR',0,'L');		//  P/P/A
		$this->fpdf->Cell($col10,$InterLigne,'','L',0,'L');			//  Name of Incumbent
		$this->fpdf->Cell($col11,$InterLigne,'','L',0,'C');			//  SEX
		$this->fpdf->Cell($col12,$InterLigne,'','L',0,'C');				//  Date of Birth
		$this->fpdf->Cell($col13,$InterLigne,'','L',0,'C');	//  TIN
		// $this->fpdf->Cell($col14,$InterLigne,'','L',0,'C');		//  Date of Last Appointment
		// $this->fpdf->Cell($col15,$InterLigne,'','L',0,'C');		//  Date of Last Promotion
		// $this->fpdf->Cell($col16,$InterLigne,'','LR',0,'C');	//  Status
		// $this->fpdf->Cell($col17,$InterLigne,'','LR',0,'C');	//  Civil Service Eligibility
		// $this->fpdf->Cell($col18,$InterLigne,'','LR',0,'C');	//  Remarks
		$this->fpdf->Ln(4);

	}
	
	// PRINT VACANT POSITION
	function vacantPosition($intCounter, $strItemNumber, $strPositionDesc,$strAuthorizeSalary, $strSalaryGrade)
	{
		$col = 5;//space
		$col1 = 35;//Item Number
		$col2 = 55;//Position Title and Salary Grade
		$col3 = 17;//Annual Salary Authorized
		$col4 = 17;//Annual Salary Actual
		$col5 = 5;//STEP
		$col6 = 7;//AREA Code
		$col7 = 5;//area type
		$col8 = 5;//lvl
		$col9 = 20;//P/P/A Attribution
		$col10 = 50;//name of Incumbent
		$col11 = 5;//Sex
		$col12 = 17;//Date of Birth
		$col13 = 20;//TIN
		$col14 = 18;//Date of Original Appointment
		$col15 = 18;//Date of Last Promotion
		$col16 = 5;//Status
		$col17 = 20;//Civil Service Eligibility
		$col18 = 20;//Remarks
		$InterLigne = 4;
		$itemNumberCol = 41;
		$salCol = 17;
		$incumbentCol = 55;
		//  body first column
		$this->fpdf->SetFont('Arial','',6);
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'L');				//  space
		$this->fpdf->Cell($col1,$InterLigne,$strItemNumber,'L',0,'C');		//  Item Number
		$this->fpdf->Cell($col2,$InterLigne,$strPositionDesc.' - '.$strSalaryGrade,'L',0,'L');				//  Position Title
		$this->fpdf->Cell($col3,$InterLigne,number_format($strAuthorizeSalary,2),'LR',0,'R');	//  Annual Salary - Authorized
		$this->fpdf->Cell($col4,$InterLigne,'-','LR',0,'R');		//  Annual Salary - Adjusted
		$this->fpdf->Cell($col5,$InterLigne,' ','LR',0,'L');		//  Step
		$this->fpdf->Cell($col6,$InterLigne,' ','LR',0,'L');		//  Area Code
		$this->fpdf->Cell($col7,$InterLigne,' ','LR',0,'L');		//  Area Type
		$this->fpdf->Cell($col8,$InterLigne,' ','LR',0,'L');		//  LVL
		$this->fpdf->Cell($col9,$InterLigne,' ','LR',0,'L');		//  P/P/A Attribution
		$this->fpdf->Cell($col10,$InterLigne,' - ','L',0,'L');			//  Name of Incumbent             //pao
		$this->fpdf->Cell($col11,$InterLigne,' ','L',0,'C');			//  SEX
		$this->fpdf->Cell($col12,$InterLigne,' ','L',0,'C');				//  Date of Birth
		$this->fpdf->Cell($col13,$InterLigne,' ','L',0,'C');	//  TIN
		$this->fpdf->Cell($col14,$InterLigne,' ','L',0,'C');		//  Date of Original Appointment
		$this->fpdf->Cell($col15,$InterLigne,' ','L',0,'C');		//  Date of last Promotion
		$this->fpdf->Cell($col16,$InterLigne,' ','LR',0,'C');	//  Status
		$this->fpdf->Cell($col17,$InterLigne,' ','LR',0,'C');	//  CS Eligibility
		$this->fpdf->Cell($col18,$InterLigne,' ','LR',0,'C');	//  Remarks
		$this->fpdf->Ln(4);

	}

	function setOfficeInfo()
	{
		$objOfficeInfo = $this->db->select('agencyName,address,telephone,PhilhealthNum,agencyTin')->get('tblAgency')->result_array();
		foreach($objOfficeInfo as $arrOfficeInfo)
		{
			$this->agencyName = $arrOfficeInfo['agencyName'];
			$this->agencyAdd = $arrOfficeInfo['address'];
			$this->agencyNum = $arrOfficeInfo['telephone'];
			$this->agencyPhilNum = $arrOfficeInfo['PhilhealthNum'];
			$this->agencyTin = $arrOfficeInfo['agencyTin'];
		}
	}
}
/* End of file ListPlantillaOfPersonnel_model.php */
/* Location: ./application/modules/reports/models/reports/ListPlantillaOfPersonnel_model.php */