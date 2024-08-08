<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReportPDSupdate_rpt_model extends CI_Model {

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
		
		$InterLigne = 6;
		$Ligne = 45;
		// $row=$cn->Select($SQL);
		// $cn= new MySQLHandler2;
		// $cn->init();
		$this->fpdf = new FPDF('P','mm','Legal');
		$this->fpdf->AliasNbPages();
		$this->fpdf->Open();
		$arrDetails=$this->empInfo(isset($arrData['empNumber'])?$arrData['empNumber']:'');
		foreach($arrDetails as $row)
			{
			$this->fpdf->AddPage('P','Legal');
			$this->fpdf->SetTitle('Personal Data Sheet');
			$this->fpdf->SetLeftMargin(8);
			$this->fpdf->SetRightMargin(6);
			$this->fpdf->SetTopMargin(0);
			$this->fpdf->SetAutoPageBreak("on",10);
			//$this->fpdf->AddPage('P','Legal');
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Ln(5);

			$this->fpdf->SetFont('Arial','',7);
			$this->fpdf->Cell(0,$InterLigne,"CS Form No. 212",'LTR',0,"L");
			$this->fpdf->Ln(4);
			$this->fpdf->Cell(0,$InterLigne, "(Revised 2017)","LR",0,"L");
			$this->fpdf->Ln(2);

			$this->fpdf->SetFont('Arial','B',20);
			$this->fpdf->Cell(0,20,"PERSONAL DATA SHEET","LR",0,"C");
			$this->fpdf->Ln(20);
			
			$this->fpdf->SetFont('Arial','IB',7);
			$this->fpdf->Cell(0,$InterLigne, "WARNING: Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s","LR",0,"L");
			$this->fpdf->Ln(4);
			$this->fpdf->SetFont('Arial','IB',7);
			$this->fpdf->Cell(0,$InterLigne,"against the person concerned.","LR",0,"L");
			$this->fpdf->Ln(4);
			$this->fpdf->SetFont('Arial','IB',7);
			$this->fpdf->Cell(0,$InterLigne,"READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.","LR",0,"L");
			$this->fpdf->Ln(4);
			$this->fpdf->SetFont('Arial','',6);
			$this->fpdf->Cell(105,$InterLigne,"Print legibly. Tick appropriate boxes (     ) and use separate sheet if necessary. Indicate N/A if not applicable. ","L",0,"L");
			$this->fpdf->SetFont('Arial','B',6);
			$this->fpdf->Cell(30,$InterLigne,"DO NOT ABBREVIATE.","R",0,"L");
			$this->fpdf->SetFont('Arial','',6);

			$this->fpdf->SetFillColor(200,200,200);
			$this->fpdf->SetFont('Arial','B',7);
			$this->fpdf->Cell(20,$InterLigne,"1.   CS ID NO.  ",1,0,'L',1);
					
			$this->fpdf->SetFont('Arial','',6);
			$this->fpdf->Cell(0,$InterLigne," (Do not fill up. For CSC use only)",'TR',0,"R");
			$this->fpdf->Ln(5);

		
				//  PERSONAL INFORMATION - Colors of frame, background and text
				$this->fpdf->SetFont('Arial','IB',9);
				$this->fpdf->SetFillColor(200,200,200);
				$this->fpdf->Cell(0,$InterLigne,"I. PERSONAL INFORMATION",1,0,'L',1);
				$this->fpdf->Ln(6);
				
				$this->fpdf->SetFillColor(225,225,225);
				//  surname
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"2.     SURNAME ",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,$row['surname'],1,0,'L');
				$this->fpdf->Ln(6);
				//  firstname
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"        FIRST NAME ",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['firstname'],'LTB',0,'L');
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(45,$InterLigne," ",'TBR',0,'L');
				$this->fpdf->Cell(40,$InterLigne,"NAME EXTENSION (e.g. Jr., Sr.) ",1,0,'L',1);
				$this->fpdf->Cell(0,$InterLigne,$row['nameExtension'],1,0,'L');
				$this->fpdf->Ln(6);
				//  middlename
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"        MIDDLE NAME ",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,$row['middlename'],1,0,'L');
				$this->fpdf->Ln(6);
				//  Date of Birth
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"3.     DATE OF BIRTH ",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,date("m-d-Y", strtotime($row['birthday'])),0,'L');
					//  Citizenship
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"16.    CITIZENSHIP           ",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				// $i='';
				if($row['citizenship']=="Filipino")
					{$this->fpdf->Cell(0,$InterLigne," [  X ] Filipino    [    ]  Dual Citizenship",'LR',0,'L');}
				if($row['citizenship']=="Dual Citizenship")
					{$this->fpdf->Cell(0,$InterLigne," [    ]  Filipino      [  X  ]  Dual Citizenship",'LR',0,'L');}
				if($row['citizenship']!="Filipino" && $row['citizenship']!="Dual Citizenship")
					{$this->fpdf->Cell(0,$InterLigne," [    ]  Filipino      [    ]  Dual Citizenship",'LR',0,'L');}
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"         (mm/dd/yyyy)",'LR',0,'L',1);		//  Date of Birth Blank
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LR',0,'L',1);		//  Citizenship Blank
				$this->fpdf->SetFont('Arial','',7);
				if($row['citizenship']=="by birth")
					{$this->fpdf->Cell(0,$InterLigne,"[ X ]  by birth  [  ]  by naturalization",'LR',0,'R');}
				if($row['citizenship']=="by naturalization")
					{$this->fpdf->Cell(0,$InterLigne," [    ]  by birth    [  X  ]  by naturalization",'LR',0,'R');}
				if($row['citizenship']!="birth" && $row['citizenship']!="by naturalization")
					{$this->fpdf->Cell(0,$InterLigne," [    ]  by birth    [    ]  by naturalization",'LR',0,'R');}
					
				$this->fpdf->SetFont('Arial','',7);	
				$this->fpdf->Ln(6);
				//  Place of Birth
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"4.     PLACE OF BIRTH ",'LTBR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['birthPlace'],0,'L');

				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"If holder of  dual citizenship,",'LR',0,'C',1);

				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,"Pls. indicate country:",'LBR',0,'C');
				$this->fpdf->Ln(6);
				//  Sex
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"5.     SEX ",'LTBR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				if($row['sex']=="M")
					{$this->fpdf->Cell($Ligne,$InterLigne,"[  X  ]   Male     [    ]   Female",1,0,'C');}
				else
					{$this->fpdf->Cell($Ligne,$InterLigne,"[    ]   Male     [  X  ]   Female",1,0,'C');}
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"please indicate the details.",'LBR',0,'C',1);
				$this->fpdf->Cell(0,$InterLigne,"",1,0,'L');
				$this->fpdf->Ln(6);

				//  civil status
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"6.     CIVIL STATUS ",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				if($row['civilStatus']=="Single")
					{$this->fpdf->Cell($Ligne,$InterLigne," [  X  ]  Single    [    ]  Married",'R',0,'C');}
				if($row['civilStatus']=="Married")
				 {$this->fpdf->Cell($Ligne,$InterLigne," [    ]  Single    [  X  ]  Married",'R',0,'C');}
				if($row['civilStatus']!="Single" && $row['civilStatus']!="Married")
					{$this->fpdf->Cell($Ligne,$InterLigne," [    ]  Single    [    ]  Married",'R',0,'C');}
				// residential address
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"17. 		RESIDENTIAL ADDRESS                     ",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,$row['lot1'].' '.$row['street1'],1,0,'L');//res address 1st line
				$this->fpdf->Ln(6);
					
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LR',0,'C',1);		

				$this->fpdf->SetFont('Arial','',7);
				if($row['civilStatus']=="Widowed")
					{$this->fpdf->Cell($Ligne,$InterLigne,"   [  X  ]  Widowed  [    ]  Separated",'LR',0,'C');}
				if($row['civilStatus']=="Separated")
					{$this->fpdf->Cell($Ligne,$InterLigne,"    [    ]  Widowed  [  X  ]  Separated",'LR',0,'C');}
				if($row['civilStatus']!="Separated" && $row['civilStatus']!="Widowed")
					{$this->fpdf->Cell($Ligne,$InterLigne,"   [    ]  Widowed  [    ]  Separated",'LR',0,'C');}
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,'','LR',0,'L',1);  // Residential 2nd blank
				$this->fpdf->SetFont('Arial','',7);
				
				$this->fpdf->Cell(0,$InterLigne,$row['subdivision1'].' '.$row['barangay1'],1,0,'L');//res address 2nd line SUBD / BRGY
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LR',0,'C');
				$this->fpdf->Ln(6);
				
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LBR',0,'C',1);		//  Civil Status Blank-2
				$this->fpdf->SetFont('Arial','',7);
				if($row['civilStatus']=="Other/s:")
					{$this->fpdf->Cell($Ligne,$InterLigne,"   [  X  ]  Other/s:  [    ]  ",'LBR',0,'C');}
				if($row['civilStatus']=="")
					{$this->fpdf->Cell($Ligne,$InterLigne,"    [    ]  Other/s:  [  X  ]  ",'LBR',0,'C');}
				if($row['civilStatus']!="" && $row['civilStatus']!="Other/s:")
					{$this->fpdf->Cell($Ligne,$InterLigne,"   [    ]  Other/s:  ",'LBR',0,'C');}

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,'','LR',0,'L',1);  // Residential 2nd blank
				$this->fpdf->SetFont('Arial','',7);
				
				$this->fpdf->Cell(0,$InterLigne,$row['city1'].' '.$row['province1'],1,0,'L');//res address 3rd line CITY/PROV
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LR',0,'C');
				$this->fpdf->Ln(6);
				//  height
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"7.     HEIGHT (m) ",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['height'],'B',0,'L');
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->Cell(0,$InterLigne,'',1,0);//res address 4th line
				$this->fpdf->Ln(6);
				//  weight
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"8.     WEIGHT (kg) ",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['weight'],'B',0,'L');
				$this->fpdf->Cell($Ligne,$InterLigne,"ZIP CODE",'LR',0,'C',1);
				$this->fpdf->Cell(0,$InterLigne,$row['zipCode1'],1,0,'L');
				$this->fpdf->Ln(6);
				// blood type
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"9.     BLOOD TYPE ",1,0,'LR',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['bloodType'],'B',0,'L');
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"18.   PERMANENT ADDRESS",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);

				$this->fpdf->Cell(0,$InterLigne,($row['lot2'].' '.$row['street2']),1,0,'L');//res address 1st line LOT/STREET
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"10.   GSIS ID NO. ",1,0,'LR',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['gsisNumber'],'B',0,'L');
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->Cell(0,$InterLigne,($row['subdivision2'].' '.$row['barangay2']),1,0,'L');//perm address 2nd line sudb/brgy
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"11.   PAG-IBIG ID NO. ",1,0,'LR',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['pagibigNumber'],'B',0,'L');
				$this->fpdf->Cell($Ligne,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->Cell(0,$InterLigne,($row['city2'].' '.$row['province2']),1,0,'L');//perm address 3rd line city2/prov2
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"12.   PHILHEALTH NO. ",1,0,'LR',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['philHealthNumber'],'B',0,'L');
				$this->fpdf->Cell($Ligne,$InterLigne,"ZIP CODE",'LR',0,'C',1);
				$this->fpdf->Cell(0,$InterLigne,$row['zipCode2'],1,0,'L');
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"13.   SSS NO. ",1,0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['sssNumber'],'B',0,'L');
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"19.    TELEPHONE NO.          ",'LTBR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,$row['telephone1'],1,0,'L');
				//$this->Cell(0,$InterLigne,$new_str[1],1,0);
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"14.    TIN NO.           ",1,0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['tin'],'B',0,'L');
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"20.    MOBILE NO.    ",1,0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,$row['mobile'],1,0,'L');
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"15.    AGENCY EMPLOYEE NO.    ",1,0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,$row['empNumber'],'B',0,'L');
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($Ligne,$InterLigne,"21.    E-MAIL ADDRESS (if any)   ",1,0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,$row['email'],1,0,'L');
				$this->fpdf->Ln(6);
				//   FAMILY BACKGROUND
				$this->fpdf->SetFont('Arial','IB',9);
				$this->fpdf->SetFillColor(200,200,200);
				$this->fpdf->Cell(0,$InterLigne,"II. FAMILY BACKGROUND",1,0,'L',1);
				$this->fpdf->Ln(6);
				$this->fpdf->SetFillColor(225,225,225);

				//  name of spouse
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"22.   SPOUSE'S SURNAME",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['spouseSurname']),'TBRL',0,'L');
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell(55,$InterLigne,"23.   NAME of CHILDREN  (Write full name and list all)",1,0,'L',1);

				// if($row['empNumber']!="" && $row['empNumber']!="undefined")
				// 	$whereChild = " AND empNumber='".$row['empNumber']."'";
				// else
				// 	$whereChild = "";
				$rsChild = $this->db->select('childName,childBirthDate')->where('empNumber',$row['empNumber'])->order_by('childBirthDate ASC')->get('tblEmpChild')->result_array();

				// $SQL = "SELECT childName,childBirthDate FROM tblEmpChild 
				// WHERE 1=1 $whereChild ORDER BY childBirthDate ASC";
				
				// $cn= new MySQLHandler2;
				// $cn->init();
				// $row2=$cn->Select($SQL);

				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell(0,$InterLigne,"DATE OF BIRTH",1,0,'C',1);
				$this->fpdf->Ln(6);

				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        FIRST NAME",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(35,$InterLigne,($row['spouseFirstname']),'LTRB',0,'L');
				

				$this->fpdf->SetFont('Arial','',5);
				$this->fpdf->Cell(25,$InterLigne,"    NAME EXTENSION (JR,SR)   ",1,0,'C',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(10,$InterLigne,$row['spousenameExtension'],'LRB',0,'C');
				
				if(count($rsChild)>0)//1st child 
				{
					$childIndex=0;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',7);  
				$this->fpdf->Cell($Ligne,$InterLigne,"        MIDDLE NAME",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);  
				$this->fpdf->Cell(70,$InterLigne,($row['spouseMiddlename']),'TBRL',0,'L');
				
				if(count($rsChild)>1)//2nd child 
				{
					$childIndex=1;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}


				$this->fpdf->Ln(6);
					// occupation
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        OCCUPATION",'LTBR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);  
				$this->fpdf->Cell(70,$InterLigne,($row['spouseWork']),'TBRL',0,'L');
				
				if(count($rsChild)>2)//3rd child 
				{
					$childIndex=2;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);
				// employer/business name
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        EMPLOYER/BUSINESS NAME ",'LTBR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['spouseBusName']),'TBRL',0,'L');
				
				if(count($rsChild)>3)//4th child bday
				{
					$childIndex=3;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        BUSINESS ADDRESS ",'LTBR',0,'LR',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['spouseBusAddress']),'TBRL',0,'L');
				
				if(count($rsChild)>4)//5th child bday
				{
					$childIndex=4;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);
				// bus. telephone no.
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        TELEPHONE NO. ",'LTBR',0,'LR',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,$row['spouseTelephone'],'TBRL',0,'L');
				
				if(count($rsChild)>5)//6th child bday
				{
					$childIndex=5;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);
				//  name of father
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"24.   FATHER'S SURNAME ",'LTR',0,'LR',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['fatherSurname']),'TBRL',0,'L');
				
				if(count($rsChild)>6)//7th child bday
				{
					$childIndex=6;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);

				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        FIRST NAME",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(35,$InterLigne,($row['fatherFirstname']),'LBR',0,'L');
				$this->fpdf->SetFont('Arial','',5);
				$this->fpdf->Cell(25,$InterLigne,"    NAME EXTENSION (JR,SR)   ",'LTBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(10,$InterLigne,$row['fathernameExtension'],'LBR',0,'C');
				
				if(count($rsChild)>7)//8th child bday
				{
					$childIndex=7;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        MIDDLE NAME",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['fatherMiddlename']),'LTRB',0,'L');
				
				if(count($rsChild)>8)//9th child bday
				{
					$childIndex=8;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);
				//  full maiden name of mother
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"25.   MOTHER'S MAIDEN NAME",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['motherName']),'LTRB',0,'L');
				
				if(count($rsChild)>9)//10th child bday
				{
					$childIndex=9;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        SURNAME",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['motherSurname']),'LTRB',0,'L');
				if(count($rsChild)>10)//11th child bday
				{
					$childIndex=10;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        FIRSTNAME",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['motherFirstname']),'LTRB',0,'L');
				
				if(count($rsChild)>11)//12th child bday
				{
					$childIndex=11;
					$this->fpdf->Cell(55,$InterLigne,($rsChild[$childIndex]['childName']),'LRB',0,'C');
					$this->fpdf->SetFont('Arial','',7);
					$this->fpdf->Cell(0,$InterLigne,date('m/d/Y',strtotime($rsChild[$childIndex]['childBirthDate'])),'LRB',0,'C');
				}
				else
				{
					$this->fpdf->Cell(55,$InterLigne,'','LRB',0,'C');
					$this->fpdf->Cell(0,$InterLigne,'',1,0,'C');
				}

				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($Ligne,$InterLigne,"        MIDDLENAME",'LBR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(70,$InterLigne,($row['motherMiddlename']),'LTRB',0,'L');
				$this->fpdf->SetFont('Arial','I',7);
				$this->fpdf->Cell(0,$InterLigne,"(Continue on separate sheet if necessary)",'LTRB',0,'C',1);
				$this->fpdf->Ln(6);
				//  EDUCATIONAL BACKGROUND
				$this->fpdf->SetFont('Arial','IB',9);
				$this->fpdf->SetFillColor(200,200,200);
				$this->fpdf->Cell(0,$InterLigne,"III. EDUCATIONAL BACKGROUND",1,0,'L',1);
				$this->fpdf->Ln(6);
				$this->fpdf->SetFillColor(225,225,225);
				$h=array(20,45,39,17,17,22,0);

				//  level
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($h[0],3,"26.",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell($h[1],3,"",'LTR',0,'C',1);
				$this->fpdf->Cell($h[2],3,"",'LTR',0,'C',1);
				$this->fpdf->Cell($h[3],3,"",'LTR',0,'C',1);
				$this->fpdf->Cell($h[4],3,"Highest",'LTR',0,'C',1);
				$this->fpdf->Cell($h[5],3,"",'LTR',0,'C',1);
				$this->fpdf->Cell($h[6],3,"SCHOLARSHIP/",'LTR',0,'C',1);
				$this->fpdf->Ln(3);
				
				$this->fpdf->Cell($h[0],3,"",'LR',0,'C',1);
				$this->fpdf->Cell($h[1],3,"NAME OF SCHOOL",'LR',0,'C',1);
				$this->fpdf->Cell($h[2],3,"BASIC EDUCATION/DEGREE/COURSE",'LR',0,'C',1);
				$this->fpdf->Cell($h[3],3,"PERIOD OF",'LR',0,'C',1);
				$this->fpdf->Cell($h[4],3,"Level/",'LR',0,'C',1);
				$this->fpdf->Cell($h[5],3,"YEAR",'LR',0,'C',1);
				$this->fpdf->Cell($h[6],3,"ACADEMIC",'LR',0,'C',1);
				$this->fpdf->Ln(3);
				
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($h[0],3,"LEVEL",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell($h[1],3,"(Write in full)",'LR',0,'C',1);
				$this->fpdf->Cell($h[2],3,"(Write in full)",'LR',0,'C',1);
				$this->fpdf->Cell($h[3],3,"ATTENDANCE",'LR',0,'C',1);
				$this->fpdf->Cell($h[4],3,"Units Earned",'LR',0,'C',1);
				$this->fpdf->Cell($h[5],3,"GRADUATED",'LR',0,'C',1);
				$this->fpdf->Cell($h[6],3,"HONORS",'LR',0,'C',1);
				$this->fpdf->Ln(3);
				
				$this->fpdf->Cell($h[0],3,"",'LR',0,'C',1);
				$this->fpdf->Cell($h[1],3,"",'LR',0,'C',1);
				$this->fpdf->Cell($h[2],3,"",'LR',0,'C',1);
				$this->fpdf->Cell($h[3],3,"",'LR',0,'C',1);
				$this->fpdf->Cell($h[4],3,"(If not",'LR',0,'C',1);
				$this->fpdf->Cell($h[5],3,"",'LR',0,'C',1);
				$this->fpdf->Cell($h[6],3,"RECEIVED",'LR',0,'C',1);
				$this->fpdf->Ln(3);
				
				$this->fpdf->Cell($h[0],3,"",'LBR',0,'C',1);
				$this->fpdf->Cell($h[1],3,"",'LBR',0,'C',1);
				$this->fpdf->Cell($h[2],3,"",'LBR',0,'C',1);
				$this->fpdf->Cell($h[3]/2,3,"FROM",'LTBR',0,'C',1);
				$this->fpdf->Cell($h[3]/2,3,"TO",'LTBR',0,'C',1);
				$this->fpdf->Cell($h[4],3,"graduate)",'LBR',0,'C',1);
				$this->fpdf->Cell($h[5],3,"",'LBR',0,'C',1);
				$this->fpdf->Cell($h[6],3,"",'LBR',0,'C',1);
				$this->fpdf->Ln(3);

				// $educSQL = "SELECT * FROM tblEducationalLevel ORDER BY level DESC,levelCode";
				// $result_educ = mysql_query($educSQL);

				$rsEduc = $this->db->select('*')->order_by('level DESC,levelCode')->get('tblEducationalLevel')->result_array();
				//print_r($rsEduc);
				$this->fpdf->SetWidths(array($h[0], $h[1], $h[2], ($h[3]/2), ($h[3]/2), $h[4], $h[5], 42));
				$align = array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C');
				$this->fpdf->SetAligns($align);
				$this->fpdf->SetFont('Arial','',6);

				//while($educ=mysql_fetch_array($result_educ)) {
				foreach($rsEduc as $educ) {
					// $qry = "SELECT * FROM tblEmpSchool WHERE empNumber='".$strEmpNmbr."' AND levelCode='".$educ['levelCode']."'";

					// $result3 = mysql_query($qry);
					$rsEmpEduc = $this->db->select('*')->where('empNumber',$row['empNumber'])->where('levelCode',$educ['levelCode'])->get('tblEmpSchool')->result_array();
					
					$t_educCode = "";
					foreach ($rsEmpEduc as $row3) {
						if($t_educCode==$educ['levelCode'])
							$educ_header = "";
						else
							$educ_header=$educ['levelDesc'];
						// if($row3['graduated']=='Y')
							$year_graduated = $row3['graduated']=='Y'?$row3['schoolToDate']:'-';
							

						$debcourse = $this->db->select('*')->where('courseCode',$row3['course'])->get('tblCourse')->result_array();
						foreach ($debcourse as $debc){
							$courseDesc = $debc['courseDesc'];
						}
						
						$this->fpdf->FancyRow( array($educ_header, ($row3['schoolName']), $courseDesc, $row3['schoolFromDate'], $row3['schoolToDate'], $row3['units'], $row3['yearGraduated'], urldecode($row3['honors'])),array(1,1,1,1,1,1,1,1), 1);		
						$t_educCode=$educ['levelCode'];
					}
				}
				$this->fpdf->SetFont('Arial','I',7);
				$this->fpdf->Cell(0,5,"(Continue on Separate sheet if necessary)",1,0,'C');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','B',7);
				$this->fpdf->Cell(20,5,"SIGNATURE",'LTBR',0,'C',1);
				$this->fpdf->SetFont('Arial','B',7);
				$this->fpdf->Cell($Ligne,5,"",'LTB',0,'C');
				$this->fpdf->Cell(39,5,"",'TBR',0,'C');
				$this->fpdf->Cell(17,5,"DATE",'LTBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,5,"",'LTBR',0,'C');
				$this->fpdf->Ln(5);

				$this->fpdf->SetFont('Arial','I',6);
				$this->fpdf->Cell(0,4,"CS FORM 212 (Revised 2017), Page 1 of 4",1,0,'R');
				$this->fpdf->Ln(50);

				$this->fpdf->AddPage('P','','Legal');
				$this->fpdf->Ln(10);
				//  CIVIL SERVICE ELIGIBILITY
				$this->fpdf->SetFont('Arial','IB',9);
				$this->fpdf->Cell(0,$InterLigne,"IV. CIVIL SERVICE ELIGIBILITY",1,0,'L',1);
				$this->fpdf->Ln(6);
				
				//  career service/RA 1080(board/bar)
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->Cell(65,$InterLigne,"27.CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER ",'LTR',0,'L',1);
				$this->fpdf->Cell(20,$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->Cell(30,$InterLigne,"DATE OF",'LTR',0,'C',1);
				$this->fpdf->Cell(50,$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,"LICENSE (if applicable)",'LTBR',0,'C',1);
				$this->fpdf->Ln(4);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(65,$InterLigne,"SPECIAL LAWS/ CES/ CSEE ",'LR',0,'C',1);
				$this->fpdf->Cell(20,$InterLigne,"RATING",'LR',0,'C',1);
				$this->fpdf->Cell(30,$InterLigne,"EXAMINATION/",'LR',0,'C',1);
				$this->fpdf->Cell(50,$InterLigne,"PLACE OF EXAMINATION / CONFERMENT",'LR',0,'C',1);
				$this->fpdf->Cell(18,$InterLigne,"NUMBER",'LTBR',0,'C',1);
				$this->fpdf->Cell(19,$InterLigne,"DATE OF",'LTR',0,'C',1);
				$this->fpdf->Ln(4);
				$this->fpdf->Cell(65,$InterLigne,"BARANGAY ELIGIBILITY / DRIVER'S LICENSE",'LBR',0,'C',1);
				$this->fpdf->Cell(20,$InterLigne,"(If Applicable)",'LBR',0,'C',1);
				$this->fpdf->Cell(30,$InterLigne,"CONFERNMENT",'LBR',0,'C',1);
				$this->fpdf->Cell(50,$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell(18,$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell(19,$InterLigne,"Validity",'LBR',0,'C',1);
				
				$this->fpdf->Ln(6);

				// $examSQL = "SELECT * FROM tblEmpExam WHERE empNumber='".$strEmpNmbr."' ORDER BY examDate DESC";
				$rsEmpExam = $this->db->select('*')->where('empNumber',$row['empNumber'])->order_by('examDate DESC')->get('tblEmpExam')->result_array();
				//$result_exam = mysql_query($examSQL);
				$this->fpdf->SetWidths(array(65, 20, 30, 50, 18, 19));
				$align = array('L', 'L', 'L', 'L', 'L', 'L');
				$this->fpdf->SetAligns($align);
				$this->fpdf->SetFont('Arial','',6);
				$exam_limit = 15;$total_exam=0;
				$this->fpdf->SetFillColor(255,255,255);
				foreach($rsEmpExam as $exam) {
					// $qry = "SELECT * FROM tblExamType WHERE examCode='".$exam['examCode']."'";
					$rsExam = $this->db->select('*')->where('examCode',$exam['examCode'])->get('tblExamType')->result_array();
					//$result3 = mysql_query($qry);
					//$total_exam = mysql_num_rows($result3);
					foreach ($rsExam as $row3) {
						$strDate = explode('-',$exam['examDate']);
						$examDate = $strDate[1]."/".$strDate[2]."/".$strDate[0];
						$strDate2 = explode('-',$exam['dateRelease']);
						$releaseDate = $strDate2[1]."/".$strDate2[2]."/".$strDate2[0];
						$this->fpdf->FancyRow(array(($row3['examDesc']), $exam['examRating'], $examDate, $exam['examPlace'], $exam['licenseNumber'], $releaseDate), array(1,1,1,1,1,1),1);
						$total_exam++;	
					}		
				}
				while($total_exam<$exam_limit)
				{
				$this->fpdf->FancyRow(array("", "", "", "", "", ""), array(1,1,1,1,1,1),1);
				$total_exam+=1;
				}

				$this->fpdf->SetFont('Arial','IB',7);
				$this->fpdf->Cell(0,4,"(Continue on Separate sheet if necessary)",1,0,'C');
				$this->fpdf->Ln(4);

				// work experience
				$this->fpdf->SetFont('Arial','IB',10);
				$this->fpdf->SetFillColor(200,200,200);
				$this->fpdf->Cell(0,$InterLigne,"V. WORK EXPERIENCE",'LTR',0,'L',1);
				$this->fpdf->Ln(5);
				$this->fpdf->SetFont('Arial','IB',8);
				$this->fpdf->Cell(0,$InterLigne,"(Include private employment. Start from your recent work) Description of duties should be indicated in the attached Work Experience sheet.",'LBR',0,'L',1);
				$this->fpdf->Ln(6);
				
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->SetFillColor(225,225,225);
				$w=array(32,36,56,20,20,19,19);
				$this->fpdf->Cell($w[0],$InterLigne,"28. INCLUSIVE DATES",'LTR',0,'L',1);
				$this->fpdf->Cell($w[1],$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->Cell($w[4],$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->SetFont('Arial','',5);
				$this->fpdf->Cell($w[4],$InterLigne,"SALARY/JOB/PAY",'LTR',0,'C',1);
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell($w[5],$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->Cell($w[6],$InterLigne,"GOV'T",'LTR',0,'C',1);
				$this->fpdf->Ln(4);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[0],$InterLigne,"(mm/dd/yyyy)",'LBR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"POSITION TITLE",'LR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"DEPARTMENT/AGENCY/OFFICE/COMPANY",'LR',0,'C',1);
				$this->fpdf->Cell($w[4],$InterLigne,"MONTHLY",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',5);
				$this->fpdf->Cell($w[4],$InterLigne,"GRADE(If applicable) &",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell($w[5],$InterLigne,"STATUS OF",'LR',0,'C',1);
				$this->fpdf->Cell($w[6],$InterLigne,"SERVICE",'LR',0,'C',1);
				$this->fpdf->Ln(4);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[0],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"(Write in full/Do not abbreviate)",'LBR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"(Write in full/Do not abbreviate)",'LBR',0,'C',1);
				$this->fpdf->Cell($w[4],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',5);
				$this->fpdf->Cell($w[4],$InterLigne,"STEP(FORMAT 00-0)/",'LBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell($w[5],$InterLigne,"APPOINTMENT",'LBR',0,'C',1);
				$this->fpdf->Cell($w[6],$InterLigne,"(Yes / No)",'LBR',0,'C',1);
				$this->fpdf->Ln(4);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[0]-16,$InterLigne,"From",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[0]-16,$InterLigne,"To",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell($w[4],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',5);
				$this->fpdf->Cell($w[4],$InterLigne,"INCREMENT",'LBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell($w[5],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell($w[6],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Ln(6);

				// $workSQL = "SELECT * FROM tblServiceRecord WHERE empNumber='".$strEmpNmbr."' ORDER BY serviceFromDate DESC";
				// $result_work = mysql_query($workSQL);
				$rsWork = $this->db->select('*')->where('empNumber',$row['empNumber'])->order_by('serviceFromDate DESC')->get('tblServiceRecord')->result_array();
				$total_work = count($rsWork);
				$limit_work = 20;
				$this->fpdf->SetWidths(array($w[0]-16, $w[0]-16, $w[1], $w[2], $w[3], $w[4], $w[5], $w[6]));
				$align = array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L');
				$this->fpdf->SetAligns($align);
				$this->fpdf->SetFont('Arial','',6);
				foreach($rsWork as $work) {
					if($work['positionDesc']=="")
					{
						$rsPos = $this->db->select('*')->where('positionCode',$work['positionCode'])->get('tblPosition')->result_array();
						// $result_position = mysql_query("SELECT * FROM tblPosition WHERE positionCode='".$work['positionCode']."'");
						// $row_position = mysql_fetch_assoc($result_position);
						$positionDesc=count($rsPos)>0?$rsPos[0]['positionDesc']:'';
					}
					else
						$positionDesc=	$work['positionDesc'];

					$rsApp = $this->db->select('*')->where('appointmentCode',$work['appointmentCode'])->get('tblAppointment')->result_array();
					$strAppDesc=count($rsApp)>0?$rsApp[0]['appointmentDesc']:'';
					// $result_app = mysql_query("SELECT * FROM tblAppointment WHERE appointmentCode='".$work['appointmentCode']."'");
					// $row_app = mysql_fetch_assoc($result_app);
					$strFromDate = explode('-',$work['serviceFromDate']);
					$fromDate = "";
					// if($fromDate != 0)
					// {
						$fromDate = $strFromDate[1]."/".$strFromDate[2]."/".$strFromDate[0];
					// }
					// else
					// 	$fromDate = $work['serviceFromDate'];

					if($work['serviceToDate']!="Present")
					{
						$strToDate = explode('-',$work['serviceToDate']);
						$toDate = $strToDate[1]."/".$strToDate[2]."/".$strToDate[0];
					}
					else
						$toDate = $work['serviceToDate'];
					//$salary = 'P '.$work['salary']."/".$work['salaryPer'];
					$this->fpdf->FancyRow(array($fromDate, $toDate, $positionDesc, $work['stationAgency'], 'P '.$work['salary']."/".$work['salaryPer'], $work['salaryGrade'],$strAppDesc, $work['governService']), array(1,1,1,1,1,1,1,1),1);		
					}
					while($total_work<$limit_work)
					{
					$this->fpdf->FancyRow(array("", "", "", "", "".""."", "","", ""), array(1,1,1,1,1,1,1,1), 1);
					$total_work+=1;
					}

				$this->fpdf->SetFont('Arial','IB',7);
				//$this->fpdf->Ln(2);
				$this->fpdf->Cell(0,4,"(Continue on Separate sheet if necessary)",1,0,'C');
				$this->fpdf->Ln(4);
				
				$this->fpdf->SetFont('Arial','B',7);
				$this->fpdf->Cell(20,5,"SIGNATURE",'LTBR',0,'C',1);
				$this->fpdf->SetFont('Arial','B',7);
				$this->fpdf->Cell($Ligne,5,"",'LTB',0,'C');
				$this->fpdf->Cell(39,5,"",'TBR',0,'C');
				$this->fpdf->Cell(17,5,"DATE",'LTBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,5,"",'LTBR',0,'C');
				$this->fpdf->Ln(5);

				$this->fpdf->SetFont('Arial','I',6);
				$this->fpdf->Cell(0,4,"CS FORM 212 (Revised 2017), Page 2 of 4",1,0,'R');
				$this->fpdf->Ln(50);

				$this->fpdf->AddPage('P','','Legal');
				$this->fpdf->Ln(10);
				//  VOLUNTARY WORK (Colors of frame, background and text)
				$this->fpdf->SetFont('Arial','IB',9);
				$this->fpdf->SetFillColor(200,200,200);
				$this->fpdf->Cell(0,$InterLigne,"VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S",1,0,'L',1);
				$this->fpdf->Ln(6);
				//Text color in gray
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->SetFillColor(225,225,225);
				$w=array(72,50,30,50);
				$this->fpdf->Cell($w[0],$InterLigne,"29.      NAME & ADDRESS OF ORGANIZATION",'LTR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"INCLUSIVE DATES",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"NUMBER OF",'LTR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->Ln(4);
				
				$this->fpdf->Cell($w[0],$InterLigne,"(Write in full)",'LR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"(mm/dd/yyyy)",'LBR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"HOURS",'LR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"POSITION / NATURE OF WORK",'LR',0,'C',1);
				$this->fpdf->Ln(6);

				$this->fpdf->Cell($w[0],$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->Cell($w[1]/2,$InterLigne,"From",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[1]/2,$InterLigne,"To",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Ln(6);

				// $volSQL = "SELECT * FROM tblEmpVoluntaryWork WHERE empNumber='".$strEmpNmbr."' ORDER BY vwDateFrom DESC";
				// $result_vol = mysql_query($volSQL);
				$rsVolWork = $this->db->select('*')->where('empNumber',$row['empNumber'])->order_by('vwDateFrom DESC')->get('tblEmpVoluntaryWork')->result_array();
				$total_vol = count($rsVolWork);
				$limit_vol = 5;
				$this->fpdf->SetWidths(array($w[0], $w[1]/2, $w[1]/2, $w[2], $w[3]));
				$align = array('C', 'C', 'C', 'C', 'C');
				$this->fpdf->SetAligns($align);
				$this->fpdf->SetFont('Arial','B',6);
				foreach($rsVolWork as $vol) 
				{
					$strFromDate = explode('-',$vol['vwDateFrom']);
					$fromDate = $strFromDate[1]."-".$strFromDate[2]."-".$strFromDate[0];
					$strToDate = explode('-',$vol['vwDateTo']);
					$toDate = $strToDate[1]."-".$strToDate[2]."-".$strToDate[0];		
					$this->fpdf->FancyRow(array(($vol['vwName'].", ".$vol['vwAddress']), $fromDate, $toDate, $vol['vwHours'], $vol['vwPosition']), array(1,1,1,1,1,1), 1);		
				}
				while($total_vol<$limit_vol)	
				{
					$this->fpdf->FancyRow(array(""." "."", "", "", "", ""), array(1,1,1,1,1,1), 1);
					$total_vol+=1;
				}

				$this->fpdf->SetFont('Arial','IB',7);
				$this->fpdf->Cell(0,4,"(Continue on Separate sheet if necessary)",1,0,'C');
				$this->fpdf->Ln(4);

				// training
				//  TRAINING PROGRAMS (Colors of frame, background and text)
				$this->fpdf->SetFont('Arial','IB',10);
				$this->fpdf->SetFillColor(200,200,200);
				$this->fpdf->Ln(10);
				$this->fpdf->Cell(0,$InterLigne,"VII.  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED",1,0,'L',1);
				$this->fpdf->Ln(6);
				$this->fpdf->SetFont('Arial','I',7);
				$this->fpdf->Cell(0,$InterLigne,"(Start from the most recent L&D/training program and include only the relevant L&D/training taken for the last five (5) years for Division Chief/Executive/Managerial positions)",1,0,'L',1);
				$this->fpdf->Ln(6);
				
				//  30. title of seminar/trainings
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->SetFillColor(225,225,225);
				$w=array(90,40,15,15,42);
				$this->fpdf->Cell($w[0],$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"INCLUSIVE DATES OF",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"Type of LD",'LTR',0,'C',1);
				$this->fpdf->Cell($w[4],$InterLigne,"",'LTR',0,'C',1);
				$this->fpdf->Ln(4);
				$this->fpdf->Cell($w[0],$InterLigne,"30. TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS ",'LR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"ATTENDANCE",'LBR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"NUMBER OF ",'LR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"(Managerial/",'LR',0,'C',1);
				$this->fpdf->Cell($w[4],$InterLigne,"CONDUCTED/ SPONSORED BY",'LR',0,'C',1);
				$this->fpdf->Ln(4);
				$this->fpdf->Cell($w[0],$InterLigne,"(Write in full)",'LR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"(mm/dd/yyyy)",'LBR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"HOURS",'LR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"Supervisory/",'LR',0,'C',1);
				$this->fpdf->Cell($w[4],$InterLigne,"(Write in full)",'LR',0,'C',1);
				$this->fpdf->Ln(4);
				$this->fpdf->Cell($w[0],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell($w[1]/2,$InterLigne,"From",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[1]/2,$InterLigne,"To",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"Technical/etc)",'LBR',0,'C',1);
				$this->fpdf->Cell($w[4],$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Ln(6);
				
				// $trainingSQL = "SELECT * FROM tblEmpTraining WHERE empNumber='".$strEmpNmbr."' ORDER BY trainingStartDate DESC";
				// $result_training = mysql_query($trainingSQL);
				$rsLD = $this->db->select('*')->where('empNumber',$row['empNumber'])->order_by('trainingStartDate DESC')->get('tblEmpTraining')->result_array();
				$total_training = count($rsLD);
				$limit_training = 20;
				$this->fpdf->SetWidths(array($w[0], $w[1]/2, $w[1]/2, $w[2], $w[3], $w[4]));
				$align = array('C', 'C', 'C', 'C', 'C','C');
				$this->fpdf->SetAligns($align);
				$this->fpdf->SetFont('Arial','',6);
				foreach($rsLD as $training) 
				{
					$strDate = explode("-",$training['trainingStartDate']);
					$startDate = $strDate[1]."/".$strDate[2]."/".$strDate[0];		
					$strDate2 = explode("-",$training['trainingEndDate']);
					$endDate = $strDate2[1]."/".$strDate2[2]."/".$strDate2[0];		
					$this->fpdf->FancyRow(array(($training['trainingDesc']), $startDate, $endDate, $training['trainingHours'], $training['trainingTypeofLD'], ($training['trainingConductedBy'])),array(1,1,1,1,1,1),1);		
				}
				while($total_training<$limit_training)
					{
					$this->fpdf->FancyRow(array("", "", "", "", "",""),array(1,1,1,1,1,1), 1);	
					$total_training+=1;	
					}

				// $strEmpNmbr ='';
				// $trainingSQL = "SELECT * FROM tblEmpTraining WHERE empNumber='".$strEmpNmbr."' ORDER BY trainingStartDate DESC";
				// $result_training = $trainingSQL;
				// $total_training = $result_training;
				// $limit_training = 20;
				// $this->fpdf->SetWidths(array($w[0], $w[1]/2, $w[1]/2, $w[2], $w[3], $w[4]));
				// $align = array('C', 'C', 'C', 'C', 'C','C');
				// $this->fpdf->SetAligns($align);
				// $this->fpdf->SetFont('Arial','',6);
				// while($training=mysql_fetch_array($result_training))
				// $training=$result_training;
				// foreach ($training  as $row)
				// {
				// 	$strDate = explode("-",$training['trainingStartDate']);
				// 	$startDate = $strDate[1]."/".$strDate[2]."/".$strDate[0];		
				// 	$strDate2 = explode("-",$training['trainingEndDate']);
				// 	$endDate = $strDate2[1]."/".$strDate2[2]."/".$strDate2[0];		
				// }
					// if ($total_training<$limit_training)
					// 	{
					// 		$this->Row(array("", "", "", "", "",""), 1);	
					// 		$total_training+=1;	
					// 	}

				// $this->fpdf->SetFont('Arial','IB',7);
				// $this->fpdf->Cell(0,4,"(Continue on Separate sheet if necessary)",1,0,'C');
				// $this->fpdf->Ln(4);

				// $this->fpdf->SetFont('Arial','IB',10);
				// $this->fpdf->SetFillColor(200,200,200);
				// $this->fpdf->Cell(0,$InterLigne,"VII. OTHER INFORMATION",1,0,'L',1);
				// $this->fpdf->Ln(6);
				
				// //  special skills/recognition/organization
				// $w=array(60,80,0);
				// $this->fpdf->SetFont('Arial','',7);	
				// $this->fpdf->Cell($w[0],$InterLigne,"31. SPECIAL SKILLS and HOBBIES",'LTR',0,'C');
				// $this->fpdf->Cell($w[1],$InterLigne,"32. NON-ACADEMIC DISTINCTIONS / RECOGNITION",'LTR',0,'C');
				// $this->fpdf->SetFont('Arial','',6);
				// $this->fpdf->Cell($w[2],$InterLigne,"33. MEMBERSHIP IN ASSOCIATION/ORGANIZATION",'LTR',0,'L');
				// $this->fpdf->Ln(3);
				// $this->fpdf->Cell($w[0],$InterLigne,"",'LBR',0,'C');
				// $this->fpdf->Cell($w[1],$InterLigne,"(Write in full)",'LBR',0,'C');
				// $this->fpdf->Cell($w[2],$InterLigne,"(Write in full)",'LRB',0,'C');
				// $this->fpdf->Ln(6);
						
				// $this->fpdf->SetWidths(array($w[0], $w[1], 56));
				// $align = array('C', 'C', 'C');
				// $this->fpdf->SetAligns($align);
				// $this->fpdf->SetFont('Arial','',6);
				// $this->fpdf->Row(array(), 0);	
				// $this->fpdf->Row(array($row['skills'], $row['nadr'], $row['miao']),1,'C');
				// $this->fpdf->SetFont('Arial','IB',7);
				// $this->fpdf->Cell(0,4,"(Continue on Separate sheet if necessary)",1,0,'C');
				// $this->fpdf->Ln(4);

				// $this->fpdf->SetFont('Arial','B',7);
				// $this->fpdf->Cell(20,5,"SIGNATURE",'LTBR',0,'C',1);
				// $this->fpdf->SetFont('Arial','B',7);
				// $this->fpdf->Cell($Ligne,5,"",'LTB',0,'C');
				// $this->fpdf->Cell(39,5,"",'TBR',0,'C');
				// $this->fpdf->Cell(17,5,"DATE",'LTBR',0,'C',1);
				// $this->fpdf->SetFont('Arial','',7);
				// $this->fpdf->Cell(0,5,"",'LTBR',0,'C');
				// $this->fpdf->Ln(5);$this->fpdf->SetFont('Arial','IB',7);
				// $this->fpdf->Cell(0,4,"(Continue on Separate sheet if necessary)",1,0,'C');
				// $this->fpdf->Ln(4);

				$this->fpdf->SetFont('Arial','IB',10);
				$this->fpdf->SetFillColor(200,200,200);
				$this->fpdf->Cell(0,$InterLigne,"VII. OTHER INFORMATION",1,0,'L',1);
				$this->fpdf->Ln(6);
				
				//  special skills/recognition/organization
				$w=array(60,82,0);
				$this->fpdf->SetFont('Arial','',7);	
				$this->fpdf->Cell($w[0],$InterLigne,"31. SPECIAL SKILLS and HOBBIES",'LTR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"32. NON-ACADEMIC DISTINCTIONS / RECOGNITION",'LTR',0,'C',1);
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell($w[2],$InterLigne,"33. MEMBERSHIP IN ASSOCIATION/ORGANIZATION",'LTR',0,'L',1);
				$this->fpdf->Ln(4);
				$this->fpdf->Cell($w[0],$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->Cell($w[1],$InterLigne,"(Write in full)",'LR',0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"(Write in full)",'LR',0,'C',1);
				$this->fpdf->Ln(6);
						
				$this->fpdf->SetWidths(array($w[0], $w[1], 60));
				$align = array('C', 'C', 'C');
				$this->fpdf->SetAligns($align);
				$this->fpdf->SetFont('Arial','',6);
				//$this->fpdf->Row(array(), 1);	
				$this->fpdf->FancyRow(array($row['skills'], $row['nadr'], $row['miao']),array(1,1,1), 1);	
				
				$this->fpdf->SetFont('Arial','IB',7);
				$this->fpdf->Cell(0,4,"(Continue on Separate sheet if necessary)",1,0,'C');
				$this->fpdf->Ln(4);

				$this->fpdf->SetFont('Arial','B',7);
				$this->fpdf->Cell(20,5,"SIGNATURE",'LTBR',0,'C',1);
				$this->fpdf->SetFont('Arial','B',7);
				$this->fpdf->Cell($Ligne,5,"",'LTB',0,'C');
				$this->fpdf->Cell(39,5,"",'TBR',0,'C');
				$this->fpdf->Cell(17,5,"DATE",'LTBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,5,"",'LTBR',0,'C');
				$this->fpdf->Ln(5);

				$this->fpdf->SetFont('Arial','I',6);
				$this->fpdf->Cell(0,4,"CS FORM 212 (Revised 2017), Page 3 of 4",1,0,'R');
				$this->fpdf->Ln(50);

				$this->fpdf->AddPage('P','','Legal');
				//end page
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->SetFillColor(225,225,225);
				$InterLigne=4;
				$this->fpdf->Ln(10);
				$this->fpdf->Cell(144,$InterLigne,"34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the ",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"",'LTR',0,'C');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(144,$InterLigne,"     chief of bureau or office or to the person who has immediate supervision over you in the Office, ",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','I',9);
				$this->fpdf->Cell(0,$InterLigne,"",'LR',0,'C');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(144,$InterLigne,"     Bureau or Department where you will be apppointed,",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','I',9);
				$this->fpdf->Cell(0,$InterLigne,"",'LR',0,'C');
				$this->fpdf->Ln();
				
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(144,$InterLigne,"a.  within the third degree?",'LR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne,"",'LR',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['relatedThird'] == "Y")
					{$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LR',0,'L');}
				if ($row['relatedThird']== "N")	
					{$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LR',0,'L');}
				if ($row['relatedThird'] != "N" && $row['relatedThird'] != "Y")
					{$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LR',0,'L');}
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(144,$InterLigne,"b.  within the fourth degree (for Local Government Unit - Career Employees)?",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				if ($row['relatedThird'] == "Y")
					{$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LR',0,'L');}
				if ($row['relatedThird']== "N")
					{$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LR',0,'L');}
				if ($row['relatedThird'] != "N" && $row['relatedThird'] != "Y")
					{$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LR',0,'L');}
				
				$this->fpdf->Ln(4);

				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"If YES, give details:",'LR',0,'L');
				$this->fpdf->Ln();

				if(strlen($row['relatedDegreeParticularsThird'])>38 && $row['relatedThird']=="Y")
					{
					$t_relatedThirdDegreeParticular = substr($row['relatedDegreeParticularsThird'],0,38);
					$t_relatedThirdDegreeParticular2 = substr($row['relatedDegreeParticularsThird'],38,38);
					$t_relatedThirdDegreeParticular3 = substr($row['relatedDegreeParticularsThird'],76,38);
					}
				else if($row['relatedThird']=="N")
					$t_relatedThirdDegreeParticular = "";
				else
					$t_relatedThirdDegreeParticular = $row['relatedDegreeParticularsThird']	;

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LRB',0,'L');
				$this->fpdf->Ln();
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LR',0,'L');
				$this->fpdf->Ln();
				//35
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(144,$InterLigne,"35. a. Have you ever been found guilty of any administrative offense?",'LTR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne,"",'LTR',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['formallyCharged'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LTR',0,'L');
				if ($row['formallyCharged'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LTR',0,'L');
				if ($row['formallyCharged'] != "N" && $row['formallyCharged'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LTR',0,'L');		
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"If YES, give details:",'LR',0,'L');
				$this->fpdf->Ln();

				if(strlen($row['relatedDegreeParticulars'])>38 && $row['formallyCharged']=="Y")
					{
					$t_strformallyChargedParticulars = substr($row['formallyChargedParticulars'],0,38);
					$t_strformallyChargedParticulars2 = substr($row['formallyChargedParticulars'],38,38);
					$t_strformallyChargedParticulars3 = substr($row['formallyChargedParticulars'],76,38);
					}
				else if($row['formallyCharged']=="N")
					$t_strformallyChargedParticulars = "";
				else
					$t_strformallyChargedParticulars = $row['formallyChargedParticulars'];
				
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();
						
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->Cell(144,$InterLigne,"      b. Have you been criminally charged before any court? ",'LR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne,"  ",'LR',0,'L');
				$this->fpdf->SetFont('Arial','',9); 
				if ($row['adminCase'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LR',0,'L');
				if ($row['adminCase'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LR',0,'L');
				if ($row['adminCase'] != "N" && $row['adminCase'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LR',0,'L');

				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"If YES, give details:",'LR',0,'L');
				$this->fpdf->Ln();
				if(strlen($row['adminCaseParticulars'])>38 && $row['adminCase']=="Y")
					{
					$t_stradminCaseParticulars = substr($row['adminCaseParticulars'],0,38);
					$t_stradminCaseParticulars2 = substr($row['adminCaseParticulars'],38,38);
					$t_stradminCaseParticulars3 = substr($row['adminCaseParticulars'],76,38);
					}
				else if($row['adminCase']=="N")
					$t_stradminCaseParticulars = "";
				else
					$t_stradminCaseParticulars = $row['adminCaseParticulars'];
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"Date Filed:",'LR',0,'L');
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');

				$this->fpdf->Ln();
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"Status of Case/s:",'LR',0,'L');
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();
				//  36
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->Cell(144,$InterLigne,"36.  Have you ever been convicted of any crime or violation of any law, decree, ordinance or ",'LTR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne,"",'LTR',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['violateLaw'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LTR',0,'L');
				if ($row['violateLaw'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LTR',0,'L');
				if ($row['violateLaw'] != "N" && $row['violateLaw'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LTR',0,'L');

				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"       regulation by any court or tribunal?",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"If YES , give details:",'LR',0,'L');
				$this->fpdf->Ln();
				if(strlen($row['violateLawParticulars'])>38 && $row['violateLaw']=="Y")
					{
					$t_strviolateLawParticulars = substr($row['violateLawParticulars'],0,38);
					$t_strviolateLawParticulars2 = substr($row['violateLawParticulars'],38,38);
					$t_strviolateLawParticulars3 = substr($row['violateLawParticulars'],76,38);
					}
				else if($row['violateLaw']=="N")
					$t_strviolateLawParticulars = "";
				else
					$t_strviolateLawParticulars = $row['violateLawParticulars'];

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();

				//  37
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->Cell(144,$InterLigne,"37. Have you ever been separated from the service in any of the following modes: resignation, ",'LTR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne," ",'LTR',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['forcedResign'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LTR',0,'L');
				if ($row['forcedResign'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LTR',0,'L');
				if ($row['forcedResign'] != "N" && $row['forcedResign'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LTR',0,'L');

				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"     retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out ",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"If YES , give details:",'LR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"     (abolition) in the public or private sector?",'LR',0,'L',1);

				if(strlen($row['forcedResignParticulars'])>38 && $row['forcedResign']=="Y")
					{
					$t_strforcedResignParticulars = substr($row['forcedResignParticulars'],0,38);
					$t_strforcedResignParticulars2 = substr($row['forcedResignParticulars'],38,38);
					$t_strforcedResignParticulars3 = substr($row['forcedResignParticulars'],76,38);
					}
				else if($row['forcedResign']=="N")
					$t_strforcedResignParticulars = "";
				else
					$t_strforcedResignParticulars = $row['forcedResignParticulars'];

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();

				//  38
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->Cell(144,$InterLigne,"38. a. Have you ever been a candidate in a national or local election held within the last year (except ",'LTR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne," ",'LTR',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['candidate'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LTR',0,'L');
				if ($row['candidate'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LTR',0,'L');
				if ($row['candidate'] != "N" && $row['candidate'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LTR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"       Barangay election)?",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"If YES , give details:",'LR',0,'L');
				$this->fpdf->Ln();
				
				if(strlen($row['candidateParticulars'])>38 && $row['candidate']=="Y")
					{
					$t_strcandidateParticulars = substr($row['candidateParticulars'],0,38);
					$t_strcandidateParticulars2 = substr($row['candidateParticulars'],38,38);
					$t_strcandidateParticulars3 = substr($row['candidateParticulars'],76,38);
					}
				else if($row['candidate']=="N")
					$t_strv = "";
				else
					$t_strcandidateParticulars = $row['candidateParticulars'];

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();
				
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LR',0,'L');
				$this->fpdf->Ln();
				//
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->Cell(144,$InterLigne,"       b. Have you resigned from the government service during the three (3)-month period before the ",'LR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne,"  ",'LR',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['campaign'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LTR',0,'L');
				if ($row['campaign'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LTR',0,'L');
				if ($row['campaign'] != "N" && $row['campaign'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LTR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"       last election to promote/actively campaign for a national or local candidate?",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"If YES , give details:",'LR',0,'L');
				$this->fpdf->Ln();
				
				if(strlen($row['campaignParticulars'])>38 && $row['campaign']=="Y")
					{
					$t_strcampaignParticulars = substr($row['campaignParticulars'],0,38);
					$t_strcampaignParticulars2 = substr($row['campaignParticulars'],38,38);
					$t_strcampaignParticulars3 = substr($row['campaignParticulars'],76,38);
					}
				else if($row['campaign']=="N")
					$t_strv = "";
				else
					$t_strcampaignParticulars = $row['campaignParticulars'];
				
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);	
				$this->fpdf->Cell(144,$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();
				//39
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"39. Have you acquired the status of an immigrant or permanent resident of another country?",'LTR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne,"",'R',0,'C');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['immigrant'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LTR',0,'L');
				if ($row['immigrant'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LTR',0,'L');
				if ($row['immigrant'] != "N" && $row['immigrant'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LTR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"If YES, please give details (country):",'R',0,'L');
				$this->fpdf->Ln();

				if(strlen($row['immigrantParticulars'])>16 && $row['indigenous']=="Y")
					{
					$t_strimmigrantParticulars = substr($row['immigrantParticulars'],0,16);
					}
				else if($row['immigrant']=="N")
					$t_strimmigrantParticulars = "";
				else
					$t_strimmigrantParticulars = $row['immigrantParticulars'];

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'BR',0,'L');
				$this->fpdf->Ln();
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'LBR',0,'L');
				$this->fpdf->Ln();
				//40
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->Cell(144,$InterLigne,"40.  Pursuant  to  (a)  Indigenous People's Act (RA 8371);(b) Magna Carta for Disabled Persons (RA",'LTR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"",'LTR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"     7277); and Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:",'LR',0,'L',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"",'LR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"     a. Are you a member of any indigenous group?",'LR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne,"",'R',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['indigenous'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LR',0,'L');
				if ($row['indigenous'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LR',0,'L');
				if ($row['indigenous'] != "N" && $row['indigenous'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LR',0,'L');

				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(35,$InterLigne,"If YES, please specify:",'L',0,'L');
				if(strlen($row['indigenousParticulars'])>16 && $row['indigenous']=="Y")
					{
					$t_strindigenousParticulars = substr($row['indigenousParticulars'],0,16);
					}
				else if($row['indigenous']=="N")
					$t_strindigenousParticulars = "";
				else
					$t_strindigenousParticulars = $row['indigenousParticulars'];
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'RB',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"     b. Are you differently abled?",'LR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne," ",'R',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['disabled'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LR',0,'L');
				if ($row['disabled'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LR',0,'L');
				if ($row['disabled'] != "N" && $row['disabled'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(35,$InterLigne,"If YES, please specify:",'L',0,'L');
				if(strlen($row['disabledParticulars'])>16 && $row['disabled']=="Y")
					{
					$t_strdisabledParticulars = substr($row['disabledParticulars'],0,16);
					}
				else if($row['disabled']=="N")
					$t_strdisabledParticulars = "";
				else
					$t_strdisabledParticulars = $row['disabledParticulars'];
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"",'BR',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"     c. Are you a solo parent?",'LR',0,'L',1);
				// $this->fpdf->Cell(0,$InterLigne,"   ",'LR',0,'L');
				$this->fpdf->SetFont('Arial','',9);
				if ($row['soloParent'] == "Y")
					$this->fpdf->Cell(0,$InterLigne,"[  X  ] YES   [    ] NO",'LR',0,'L');
				if ($row['soloParent'] == "N")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [  X  ] NO",'LR',0,'L');
				if ($row['soloParent'] != "N" && $row['soloParent'] != "Y")
					$this->fpdf->Cell(0,$InterLigne,"[    ] YES   [    ] NO",'LR',0,'L');

				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(35,$InterLigne,"If YES, please specify:",'L',0,'L');
				if(strlen($row['soloParentParticulars'])>16 && $row['soloParent']=="Y")
					{
					$t_strsoloParentParticulars = substr($row['soloParentParticulars'],0,16);
			
					}
				else if($row['soloParent']=="N")
					$t_strsoloParentParticulars = "";
				else
					$t_strsoloParentParticulars = $row['soloParentParticulars'];
				$this->fpdf->SetFont('Arial','',8);		
				$this->fpdf->Cell(0,$InterLigne,"",'RB',0,'L');
				$this->fpdf->Ln();

				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(144,$InterLigne,"",'LR',0,'C',1);
				$this->fpdf->SetFont('Arial','',9);
				$this->fpdf->Cell(0,$InterLigne,"",'LR',0,'C');
				$this->fpdf->Ln(2);
				$this->fpdf->Cell(144,$InterLigne,"",'LBR',0,'C',1);
				$this->fpdf->Cell(0,$InterLigne,"",'LRB',0,'C');
				$this->fpdf->Ln(2);
				$InterLigne=6;
				//  41.  References
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"41.  REFERENCES (Person not related by consanguinity or affinity to applicant /appointee)",1,0,'LTRB',1);
				$this->fpdf->Ln();
				
				//  name
				$this->fpdf->SetFont('Arial','',8);
				$w=array(65,70,20,4,39,4);
				$this->fpdf->Cell($w[0],$InterLigne,"NAME",'LTBR',0,'C',1);
				//  address
				$this->fpdf->Cell($w[1],$InterLigne,"ADDRESS",'LTBR',0,'C',1);
				//  telephone no.
				$this->fpdf->Cell($w[2],$InterLigne,"TEL NO.",'LTBR',0,'C',1);
				$this->fpdf->Cell($w[3],$InterLigne,"",0,'C');
				$this->fpdf->SetFont('Arial','',6);
				$this->fpdf->Cell($w[4],$InterLigne,"ID picture taken within",'LR',0,'C');
				$this->fpdf->Cell($w[5],$InterLigne,"",'R','C');
				$this->fpdf->Ln();
				
				//  line space 1
				$j = 0;
				$rsRef = $this->db->select('*')->where('empNumber',$row['empNumber'])->limit(3)->get('tblEmpReference')->result_array();
				//echo $this->db->last_query();exit(1);
				// $SQL11 = "SELECT * FROM tblEmpReference WHERE empNumber='".$strEmpNmbr."' LIMIT 3";
				// $result11 = mysql_query($SQL11);
				$total_ref = count($rsRef);
				foreach ($rsRef as $ref) 
				{

					$j+=1;
					$this->fpdf->setFont('Arial','',7);
					$this->fpdf->Cell($w[0],$InterLigne,($ref['refName']),1,0,'L');
					$this->fpdf->Cell($w[1],$InterLigne,$ref['refAddress'],1,0,'L');
					$this->fpdf->Cell($w[2],$InterLigne,$ref['refTelephone'],1,0,'C');
					$this->fpdf->Cell($w[3],$InterLigne,"",'LR','C');
					$this->fpdf->setFont('Arial','',6);
					if ($j==1)
						$this->fpdf->Cell($w[4],$InterLigne,"the last  6 months 3.5 cm",'R',0,'C');
					if ($j==2)
						$this->fpdf->Cell($w[4],$InterLigne,"X 4.5cm (passport size) ",'R',0,'C');
					if ($j==3)
						$this->fpdf->Cell($w[4],$InterLigne,"With full and handwritten",0,0,'C');
					$this->fpdf->setFont('Arial','',8);
					$this->fpdf->Cell($w[5],$InterLigne,"",'LR','C');
					
					$this->fpdf->Ln();
					
				}
				$n = 3 - $total_ref;
				$x = 1;
				
				while($x<=$n) 
				{
					$this->fpdf->setFont('Arial','',8);
					$this->fpdf->Cell($w[0],$InterLigne,"",1,0,'C');
					$this->fpdf->Cell($w[1],$InterLigne,"",1,0,'C');
					$this->fpdf->Cell($w[2],$InterLigne,"",1,0,'C');
					$this->fpdf->Cell($w[3],$InterLigne,"",'LR',0,'C');
					 $x++;
				
					$this->fpdf->setFont('Arial','',6);
					if($j==0)		
						$this->fpdf->Cell($w[4],$InterLigne,"the last  6 months 3.5 cm",'R',0,'C');
					if($j==1)
						$this->fpdf->Cell($w[4],$InterLigne,"X 4.5cm (passport size)",'R',0,'C');
					if($j==2)
						$this->fpdf->Cell($w[4],$InterLigne,"With full and handwritten",'R',0,'C');
					$x+=1;$j+=1;
					$this->fpdf->Cell($w[5],$InterLigne,"",'R','C');
					$this->fpdf->Ln();
				}
					// $this->fpdf->Cell($w[0],$InterLigne,"",1,0,'C');
					// $this->fpdf->Cell($w[1],$InterLigne,"",1,0,'C');
					// $this->fpdf->Cell($w[2],$InterLigne,"",1,0,'C');
					// $this->fpdf->Cell($w[3],$InterLigne,"",'LR',0,'C');

				// $this->fpdf->Cell($w[4],$InterLigne,"With full and handwritten",'R',0,'C');
				// $this->fpdf->Cell($w[5],$InterLigne,"",'LR','C');
				// $this->fpdf->Ln();
				//  42. declaration to wit
				$txt = "42.  I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and";
				$this->fpdf->SetFont('Arial','',7);
				$w=array(155,4,39,4);
				$this->fpdf->Cell($w[0],$InterLigne,$txt,'LTR',0,'L',1);
				$this->fpdf->Cell($w[1],$InterLigne,"",'LR','C');
				$this->fpdf->setFont('Arial','',6);
				$this->fpdf->Cell($w[2],$InterLigne,"name tag and signature over",0,0,'C');
				$this->fpdf->Cell($w[3],$InterLigne,"",'LR','C');
				$this->fpdf->Ln();

				//  paragraph1
				$txt = "        complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the ";
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[0],$InterLigne,$txt,'LR',0,'L',1);
				$this->fpdf->Cell($w[1],$InterLigne,"",'LR','C');
				$this->fpdf->setFont('Arial','',6);
				$this->fpdf->Cell($w[2],$InterLigne,"printed name.Computer",0,0,'C');
				$this->fpdf->Cell($w[3],$InterLigne,"",'LR','C');
				$this->fpdf->Ln();
				// paragraph1
				$txt = "        Philippines. I authorize the agency head/authorized representative to verify/validate the contents stated herein.";
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[0],$InterLigne,$txt,'LR',0,'L',1);
				$this->fpdf->Cell($w[1],$InterLigne,"",'LR','C');
				$this->fpdf->setFont('Arial','',6);
				$this->fpdf->Cell($w[2],$InterLigne,"generated or photocopied",0,0,'C');
				$this->fpdf->Cell($w[3],$InterLigne,"",'LR','C');
				$this->fpdf->Ln();
				//  paragraph2
				$txt = "         I  agree that any misrepresentation made in this document and its attachments shall cause the filing of ";
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[0],$InterLigne,$txt,'LR',0,'L',1);
				$this->fpdf->Cell($w[1],$InterLigne,"",'LR','C');
				$this->fpdf->setFont('Arial','',6);
				$this->fpdf->Cell($w[2],$InterLigne,"picture is not acceptable",'B',0,'C');
				$this->fpdf->Cell($w[3],$InterLigne,"",'LR','C');

				$this->fpdf->Ln();
				//  paragraph2
				$txt = "         administrative/criminal case/s against me.";
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[0],$InterLigne,$txt,'LBR',0,'L',1);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell(0,$InterLigne,"PHOTO",'LRB',0,'C');
				$this->fpdf->Ln(2);

				//  SIGNATURE/DATE ACCOMPLISHED/TAX
				$w=array(3,70,2,80,4,39,4);
				$this->fpdf->SetFont('Arial','',5);
				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->Cell($w[1],$InterLigne,"",0,0);			//  signature
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[3],$InterLigne,"",0,0);			//  blank/space provided
				$this->fpdf->Cell($w[4],$InterLigne,"",0,0);			//  spaces
				$this->fpdf->Cell($w[5],10,"",0,0);					//  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				
				$this->fpdf->Ln();

				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[1],$InterLigne,"Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's,",1,0,'C',1);
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[3],$InterLigne,"",'LRT',0,'C');          // signature
				$this->fpdf->Cell($w[4],$InterLigne,"",'LR',0);				//  spaces
				$this->fpdf->Cell($w[5],$InterLigne,"",'RT',0);			    //  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Ln();
				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[1],$InterLigne,"License, etc.)             PLEASE INDICATE ID Number",1,0,'L',1);
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[3],$InterLigne,"",'LR',0,'C');           // signature
				$this->fpdf->Cell($w[4],$InterLigne,"",'LR',0);				//  spaces
				$this->fpdf->Cell($w[5],$InterLigne,"",'R',0);		     	//  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Ln();
				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[1],$InterLigne,"Government Issued ID: ",1,0,'L');
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0,'C');
				$this->fpdf->Cell($w[3],$InterLigne,"SIGNATURE (Sign inside the box)",1,0,'C',1);     // signature
				$this->fpdf->Cell($w[4],$InterLigne,"",'LR',0);				//  spaces
				$this->fpdf->Cell($w[5],$InterLigne,"",'R',0);			    //  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Ln();
				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[1],$InterLigne,"ID/License/Passport No.: ",1,0,'L');
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$strDate2 = explode('-',$row['dateAccomplished']);
				$dateAccomplished = $strDate2[1]."-".$strDate2[2]."-".$strDate2[0];
				$this->fpdf->Cell($w[3],$InterLigne,"",'LTBR',0,'C');           // date accomplished
				$this->fpdf->Cell($w[4],$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Cell($w[5],$InterLigne,"",'LR',0);			    //  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Ln();

				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->SetFillColor(225,225,225);
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->Cell($w[1],$InterLigne,"Date/Place of Issuance: ",1,0,'L');
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[3],$InterLigne,"Date Accomplished",'LTBR',0,'C',1);           // signature
				$this->fpdf->Cell($w[4],$InterLigne,"",'R',0);									 //  spaces
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($w[5],$InterLigne,"Right Thumbmark",'LTBR',0,'C',1);			 //  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'LR',0);	
				$this->fpdf->Ln(2);
				// sworn
				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->Cell($w[1],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[3],$InterLigne,"",0,0);              // signature
				$this->fpdf->Cell($w[4],$InterLigne,"",0,0);				//  spaces
				$this->fpdf->Cell($w[5],$InterLigne,"",0,0);				//  spaces
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Ln();
				//sworn
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(0,$InterLigne,"SUBSCRIBED AND SWORN to before me this ________________, affiant exhibiting his/her validly issued government ID as indicated above.",'LTR',0,'C');
				$this->fpdf->Ln(2);

				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->Cell($w[1],$InterLigne,"",0,0,'C');
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[3],$InterLigne,"",0,0,'C');           // signature
				$this->fpdf->Cell($w[4],$InterLigne,"",0,0);				//  spaces
				$this->fpdf->Cell($w[5],$InterLigne,"",0,0);			//  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Ln(4);

				$this->fpdf->SetFont('Arial','',8);
				$InterLigne=13;
				$this->fpdf->Cell($w[0],$InterLigne,'','L',0,'C');
				$this->fpdf->Cell($w[1],$InterLigne,'',0,0,'C');
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				
				$this->fpdf->Cell($w[3],$InterLigne,'','LTR',0,'C');
				$this->fpdf->Cell($w[4],$InterLigne,"",0,0);				//  spaces
				$this->fpdf->SetFont('Arial','',10);
				$this->fpdf->Cell($w[5],$InterLigne,"",0,0,'C');			//  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Ln();
				$InterLigne=6;
				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell($w[1],$InterLigne,"",0,'C');
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[3],$InterLigne,"Person Administering Oath",'LTBR',0,'C',1);
				$this->fpdf->Cell(0,$InterLigne,"",'R',0);				//  spaces
				$this->fpdf->Ln(3);
				$this->fpdf->SetFont('Arial','B',8);
				$this->fpdf->Cell($w[0],$InterLigne,"",'L',0);
				$this->fpdf->Cell($w[1],$InterLigne,"",0,0);			//  signature
				$this->fpdf->Cell($w[2],$InterLigne,"",0,0);
				$this->fpdf->Cell($w[3],$InterLigne,"",0,0);			//  blank/space provided
				$this->fpdf->Cell($w[4],$InterLigne,"",0,0);			//  spaces
				$this->fpdf->Cell($w[5],10,"",0,0);					//  thumbmark
				$this->fpdf->Cell($w[6],$InterLigne,"",'R',0);				
				$this->fpdf->Ln();
				$this->fpdf->SetFont('Arial','I',6);
				$this->fpdf->Cell(0,$InterLigne,"CS FORM 212 (Revised 2017),  Page 4 of 4",1,0,'R');
				$this->fpdf->Ln(6);
		}
		echo $this->fpdf->Output();	
	}
	
	function empInfo($strEmpNmbr="")
		{
			$sql = "SELECT tblEmpPersonal.empNumber, tblEmpPersonal.surname, tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension, 
							tblEmpPersonal.firstname, tblEmpPersonal.middlename, tblEmpPersonal.birthday,tblEmpPersonal.birthPlace,tblEmpPersonal.citizenship,tblEmpPersonal.sex,tblEmpPersonal.civilStatus,tblEmpPersonal.height, tblEmpPersonal.weight, tblEmpPersonal.bloodType, tblEmpPersonal.gsisNumber,tblEmpPersonal.pagibigNumber, tblEmpPersonal.pagibigNumber, tblEmpPersonal.philHealthNumber,  tblEmpPersonal.sssNumber,tblEmpPersonal.tin, tblEmpPersonal.telephone1, tblEmpPersonal.mobile, 
							tblEmpPersonal.lot1,tblEmpPersonal.street1,tblEmpPersonal.subdivision1,tblEmpPersonal.barangay1,tblEmpPersonal.city1,tblEmpPersonal.province1,tblEmpPersonal.zipCode1,
							tblEmpPersonal.lot2,tblEmpPersonal.street2,tblEmpPersonal.subdivision2,tblEmpPersonal.barangay2,tblEmpPersonal.city2,tblEmpPersonal.province2,tblEmpPersonal.zipCode2,tblEmpPersonal.email,
							tblEmpPersonal.spouseSurname,tblEmpPersonal.spouseFirstname,tblEmpPersonal.spouseMiddlename,tblEmpPersonal.spousenameExtension,tblEmpPersonal.spouseWork,tblEmpPersonal.spouseBusName,tblEmpPersonal.spouseBusAddress,tblEmpPersonal.spouseTelephone,
							tblEmpPersonal.fatherSurname,tblEmpPersonal.fatherFirstname,tblEmpPersonal.fatherMiddlename,tblEmpPersonal.fathernameExtension,tblEmpPersonal.motherSurname,tblEmpPersonal.motherFirstname,tblEmpPersonal.motherMiddlename,tblEmpPersonal.motherName,
							tblEmpPersonal.relatedThird,tblEmpPersonal.relatedDegreeParticulars,tblEmpPersonal.relatedDegreeParticularsThird,tblEmpPersonal.dateAccomplished,tblEmpPersonal.soloParentParticulars,tblEmpPersonal.soloParent,tblEmpPersonal.disabledParticulars,tblEmpPersonal.disabled,tblEmpPersonal.indigenousParticulars,tblEmpPersonal.indigenous,tblEmpPersonal.immigrantParticulars,tblEmpPersonal.immigrant,tblEmpPersonal.campaignParticulars,tblEmpPersonal.campaign,tblEmpPersonal.candidateParticulars,tblEmpPersonal.candidate,tblEmpPersonal.forcedResignParticulars,tblEmpPersonal.forcedResign,tblEmpPersonal.violateLawParticulars,tblEmpPersonal.violateLaw,tblEmpPersonal.adminCaseParticulars,tblEmpPersonal.adminCase,tblEmpPersonal.relatedDegreeParticulars,tblEmpPersonal.formallyCharged,tblEmpPersonal.formallyChargedParticulars,tblEmpPersonal.skills,tblEmpPersonal.nadr,tblEmpPersonal.miao,
							tblPlantilla.plantillaGroupCode,
						 	tblPlantillaGroup.plantillaGroupName, tblEmpPosition.group3, tblEmpPosition.groupCode, tblEmpPosition.positionCode, tblEmpPosition.payrollGroupCode,
						 	tblEmpChild.childName,tblEmpChild.childBirthDate
						
							FROM tblEmpPersonal
							LEFT JOIN tblEmpPosition ON tblEmpPersonal.empNumber = tblEmpPosition.empNumber
							LEFT JOIN tblEmpChild ON tblEmpPersonal.empNumber = tblEmpChild.empNumber
							LEFT JOIN tblPlantilla ON tblEmpPosition.itemNumber = tblPlantilla.itemNumber
							LEFT JOIN tblPlantillaGroup ON tblPlantilla.plantillaGroupCode = tblPlantillaGroup.plantillaGroupCode
							WHERE tblEmpPersonal.empNumber = '".$strEmpNmbr."'";
	            		// WHERE emp_id=$empId";
				$this->db->select('DISTINCT(tblEmpPersonal.empNumber), tblEmpPersonal.surname, tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension, 
							tblEmpPersonal.firstname, tblEmpPersonal.middlename, tblEmpPersonal.birthday,tblEmpPersonal.birthPlace,tblEmpPersonal.citizenship,tblEmpPersonal.sex,tblEmpPersonal.civilStatus,tblEmpPersonal.height, tblEmpPersonal.weight, tblEmpPersonal.bloodType, tblEmpPersonal.gsisNumber,tblEmpPersonal.pagibigNumber, tblEmpPersonal.pagibigNumber, tblEmpPersonal.philHealthNumber,  tblEmpPersonal.sssNumber,tblEmpPersonal.tin, tblEmpPersonal.telephone1, tblEmpPersonal.mobile, 
							tblEmpPersonal.lot1,tblEmpPersonal.street1,tblEmpPersonal.subdivision1,tblEmpPersonal.barangay1,tblEmpPersonal.city1,tblEmpPersonal.province1,tblEmpPersonal.zipCode1,
							tblEmpPersonal.lot2,tblEmpPersonal.street2,tblEmpPersonal.subdivision2,tblEmpPersonal.barangay2,tblEmpPersonal.city2,tblEmpPersonal.province2,tblEmpPersonal.zipCode2,tblEmpPersonal.email,
							tblEmpPersonal.spouseSurname,tblEmpPersonal.spouseFirstname,tblEmpPersonal.spouseMiddlename,tblEmpPersonal.spousenameExtension,tblEmpPersonal.spouseWork,tblEmpPersonal.spouseBusName,tblEmpPersonal.spouseBusAddress,tblEmpPersonal.spouseTelephone,
							tblEmpPersonal.fatherSurname,tblEmpPersonal.fatherFirstname,tblEmpPersonal.fatherMiddlename,tblEmpPersonal.fathernameExtension,tblEmpPersonal.motherSurname,tblEmpPersonal.motherFirstname,tblEmpPersonal.motherMiddlename,tblEmpPersonal.motherName,
							tblEmpPersonal.relatedThird,tblEmpPersonal.relatedDegreeParticulars,tblEmpPersonal.relatedDegreeParticularsThird,tblEmpPersonal.dateAccomplished,tblEmpPersonal.soloParentParticulars,tblEmpPersonal.soloParent,tblEmpPersonal.disabledParticulars,tblEmpPersonal.disabled,tblEmpPersonal.indigenousParticulars,tblEmpPersonal.indigenous,tblEmpPersonal.immigrantParticulars,tblEmpPersonal.immigrant,tblEmpPersonal.campaignParticulars,tblEmpPersonal.campaign,tblEmpPersonal.candidateParticulars,tblEmpPersonal.candidate,tblEmpPersonal.forcedResignParticulars,tblEmpPersonal.forcedResign,tblEmpPersonal.violateLawParticulars,tblEmpPersonal.violateLaw,tblEmpPersonal.adminCaseParticulars,tblEmpPersonal.adminCase,tblEmpPersonal.relatedDegreeParticulars,tblEmpPersonal.formallyCharged,tblEmpPersonal.formallyChargedParticulars,tblEmpPersonal.skills,tblEmpPersonal.nadr,tblEmpPersonal.miao,tblEmpPosition.group3, tblEmpPosition.groupCode, tblEmpPosition.positionCode, tblEmpPosition.payrollGroupCode');
				$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');	
				// $this->db->join('tblEmpChild','tblEmpPersonal.empNumber = tblEmpChild.empNumber','left');	
				// $this->db->join('tblPlantilla','tblEmpPosition.itemNumber = tblPlantilla.itemNumber','inner');
				// $this->db->join('tblPlantillaGroup','tblPlantilla.plantillaGroupCode = tblPlantillaGroup.plantillaGroupCode','inner');
				$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
				$this->db->group_by('tblEmpPersonal.empNumber');
				if($strEmpNmbr!='')
					$this->db->where('tblEmpPersonal.empNumber',$strEmpNmbr);
	          // echo $sql;exit(1);				
			// $query = $this->db->query($sql);
			$query = $this->db->get('tblEmpPersonal');
			return $query->result_array();	

		}	
	
	
}
/* End of file Reminder_renewal_model.php */
/* Location: ./application/models/reports/Reminder_renewal_model.php */
//Instanciation of inherited class

	
	