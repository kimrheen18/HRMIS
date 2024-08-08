<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReportTO_rpt_model extends CI_Model {

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();
		$this->load->helper(array('report_helper','general_helper'));	
		$this->load->model(array('hr/Hr_model'));
		//ini_set('display_errors','On');
		//$this->load->model(array());
	}
	
	public function Header($arrData)
	{
		$empno = $arrData['strEmpNo'] == "" ? $_SESSION['sessEmpNo'] : $arrData['strEmpNo'];
		$emp = $this->Hr_model->getData($empno,'','all')[0];
		$sec_code = $this->Hr_model->get_employee_position($emp['empNumber']);

		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(0, 8, "Republic of the Philippines", 0, 1, "C");	

		if($sec_code[0]['sectionCode'] == "PAKLAN"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Aklan', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Bliss Site, Kalibo, Aklan', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "CBORACAY"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Aklan', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Bliss Site, Kalibo, Aklan', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "PANTIQUE"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Antique', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Binirayan Hills, San Jose, Antique', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "CBELISON"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Antique', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Binirayan Hills, San Jose, Antique', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "CCULASI"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Antique', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Binirayan Hills, San Jose, Antique', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "PCAPIZ"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Capiz', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Brgy. Lanot, Roxas City, Capiz', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "CMAMBUSAO"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Capiz', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Brgy. Lanot, Roxas City, Capiz', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');
		
		elseif($sec_code[0]['sectionCode'] == "PILOILO"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Iloilo', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Old Rotary Park, Brgy. Conception-Montes, Iloilo City', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');	

		elseif($sec_code[0]['sectionCode'] == "CGUIMBAL"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Iloilo', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Old Rotary Park, Brgy. Conception-Montes, Iloilo City', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');	

		elseif($sec_code[0]['sectionCode'] == "CBAROTAC"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Iloilo', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Old Rotary Park, Brgy. Conception-Montes, Iloilo City', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');	

		elseif($sec_code[0]['sectionCode'] == "CSARA"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Iloilo', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Old Rotary Park, Brgy. Conception-Montes, Iloilo City', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "FMP-PPMO"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Iloilo', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Old Rotary Park, Brgy. Conception-Montes, Iloilo City', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');	

		elseif($sec_code[0]['sectionCode'] == "PILOILO TSD"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Province of Iloilo', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Old Rotary Park, Brgy. Conception-Montes, Iloilo City', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');
		
		elseif($sec_code[0]['sectionCode'] == "PNEGROS"):

				$this->fpdf->SetFont('Arial', "B", 12);
				$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
				$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
				$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
				$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
				$this->fpdf->SetFont('Arial', "", 12);
				$this->fpdf->Ln(1);
				$this->fpdf->Cell(0, 5, 'Province of Negros Occidental', 0, 1, "C");
				$this->fpdf->Cell(0, 5, 'Corner Porras - Abad Santos Sts., Brgy. 39, Bacolod City', 0, 0, "C");	
				$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "SCSO"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "Province of Negros Occidental", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, 'SAN CARLOS SATELLITE OFFICE', 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'San Carlos City, Negros Occidental', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "MKNP"):

			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");
			$this->fpdf->Cell(0, 5, "Province of Negros Occidental", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, 'MOUNT KANLAON NATURAL PARK', 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'La Carlota City, Negros Occidental', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "CBAGO"):

				$this->fpdf->SetFont('Arial', "B", 12);
				$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
				$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
				$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
				$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
				$this->fpdf->SetFont('Arial', "", 12);
				$this->fpdf->Ln(1);
				$this->fpdf->Cell(0, 5, 'Province of Negros Occidental', 0, 1, "C");
				$this->fpdf->Cell(0, 5, 'Corner Porras - Abad Santos Sts., Brgy. 39, Bacolod City', 0, 0, "C");	
				$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "CCADIZ"):

				$this->fpdf->SetFont('Arial', "B", 12);
				$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
				$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
				$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
				$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
				$this->fpdf->SetFont('Arial', "", 12);
				$this->fpdf->Ln(1);
				$this->fpdf->Cell(0, 5, 'Province of Negros Occidental', 0, 1, "C");
				$this->fpdf->Cell(0, 5, 'Corner Porras - Abad Santos Sts., Brgy. 39, Bacolod City', 0, 0, "C");	
				$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "CKABANKALAN"):

				$this->fpdf->SetFont('Arial', "B", 12);
				$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
				$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
				$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
				$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
				$this->fpdf->SetFont('Arial', "", 12);
				$this->fpdf->Ln(1);
				$this->fpdf->Cell(0, 5, 'Province of Negros Occidental', 0, 1, "C");
				$this->fpdf->Cell(0, 5, 'Corner Porras - Abad Santos Sts., Brgy. 39, Bacolod City', 0, 0, "C");	
				$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "PGUIMARAS"):

					$this->fpdf->SetFont('Arial', "B", 12);
					$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
					$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
					$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
					$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
					$this->fpdf->SetFont('Arial', "", 12);
					$this->fpdf->Ln(1);
					$this->fpdf->Cell(0, 5, 'Province of Guimaras', 0, 1, "C");
					$this->fpdf->Cell(0, 5, 'Capitol Compound, San Miguel, Jordan, Guimaras', 0, 0, "C");	
					$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		elseif($sec_code[0]['sectionCode'] == "PGUIMARAS TSD"):

					$this->fpdf->SetFont('Arial', "B", 12);
					$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
					$this->fpdf->Cell(0, 5, "PROVINCIAL ENVIRONMENT AND NATURAL", 0, 1, "C");
					$this->fpdf->Cell(0, 5, "RESOURCES OFFICE", 0, 1, "C");		
					$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
					$this->fpdf->SetFont('Arial', "", 12);
					$this->fpdf->Ln(1);
					$this->fpdf->Cell(0, 5, 'Province of Guimaras', 0, 1, "C");
					$this->fpdf->Cell(0, 5, 'Capitol Compound, San Miguel, Jordan, Guimaras', 0, 0, "C");	
					$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		else:
		
			$this->fpdf->SetFont('Arial', "B", 12);
			$this->fpdf->Cell(0, 5, "DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES", 0, 1, "C");	
			$this->fpdf->Cell(0, 5, "OFFICE OF THE REGIONAL EXECUTIVE DIRECTOR", 0, 1, "C");		
			$this->fpdf->Image('assets/images/DENR-LOGO.png',10,10,25,25,'PNG');
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Ln(1);
			$this->fpdf->Cell(0, 5, 'Region VI', 0, 1, "C");
			$this->fpdf->Cell(0, 5, 'Pepita Aquino Street, Port Area, Iloilo City', 0, 0, "C");	
			$this->fpdf->Image('assets/images/PRIME_HRM_LOGO.png',175,10,25,25,'PNG');

		endif;

	}
	
	function Footer()
	{		
		$this->fpdf->SetFont('Arial','',7);	
		$this->fpdf->Cell(50,3,date('Y-m-d h:i A'),0,0,'L');
		$this->fpdf->Cell(0,3,"Page ".$this->fpdf->PageNo(),0,0,'R');					
	}
	
	function generate($arrData)
	{
		$empno = $arrData['strEmpNo'] == "" ? $_SESSION['sessEmpNo'] : $arrData['strEmpNo'];

		$empname = employee_name($empno);
		$empname = stripslashes($empname);
		$empname = iconv('UTF-8', 'windows-1252', $empname);

		$empdesti = $arrData['strDestination'];
		$empdesti = stripslashes($empdesti);
		$empdesti = iconv('UTF-8', 'windows-1252', $empdesti);

		$emppur = $arrData['strPurpose'];
		$emppur = stripslashes($emppur);
		$emppur = iconv('UTF-8', 'windows-1252', $emppur);

		$emp = $this->Hr_model->getData($empno,'','all')[0];
		$sec_code = $this->Hr_model->get_employee_position($emp['empNumber']);
		$request_status = $this->Hr_model->getRequestStatus($emp['empNumber']);
		$request_date = $request_status['requestDate'];
		echo $request_date;
		$cancel_or_not = strtolower($request_status[0]['requestStatus']) == "disapproved" ? true : false;
		$isDateProcess = ($arrData['endate'] != "Processing") ? true : false;
		$toyear=$arrData['endate'];
		$str = substr($toyear, -4);
	
		$this->fpdf->SetTitle('Travel Order');
		$this->fpdf->SetLeftMargin(25);
		$this->fpdf->SetRightMargin(25);
		$this->fpdf->SetTopMargin(10);
		$this->fpdf->SetAutoPageBreak("on",10);
		$this->fpdf->AddPage('P','','A4');
		
		$this->Header($arrData);

		// Travel Order text
		$this->fpdf->Ln(20);
		$this->fpdf->SetFont('Arial', "B", 12);
		$this->fpdf->Cell(0, 5, 'TRAVEL ORDER', 0, 1, "C");
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(0, 5, $isDateProcess ? '(DENR6-'.$str.'-'.$arrData['rid'].')' : '', 0, 1, "C");

		// Employee Name
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(35, 5, "Name", 0, 0, "L");
		$this->fpdf->SetFont('Arial', "U", 12);
		$this->fpdf->Cell(120, 5, ': '.$empname, 0,0, "L");
 
		// Position
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(35, 5, "Position", 0, 0, "L");
		$this->fpdf->SetFont('Arial', "U", 12);
		$this->fpdf->Cell(120, 5, ': '.$emp['positionDesc'], 0,0, "L");
		
		
		//Departure Date
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(35, 5, "Departure Date", 0, 0, "L");
		$this->fpdf->SetFont('Arial', "U", 12);
		$this->fpdf->Cell(45, 5, ': '.date("F j, Y",strtotime($arrData['dtmTOdatefrom'])), 0,0, "L");
		
		// Official Station
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(20);
		$this->fpdf->Cell(35, 5, "Official Station", 0, 0, "L");
		$this->fpdf->SetFont('Arial', "U", 12);
		$this->fpdf->Cell(40, 5, ": ".$sec_code[0]['sectionCode'], 0,0, "L");

		// Arrival Date
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(35, 5, "Arrival Date", 0, 0, "L");
		$this->fpdf->SetFont('Arial', "U", 12);
		$this->fpdf->Cell(40, 5, ': '.date("F j, Y",strtotime($arrData['dtmTOdateto'])), 0,0, "L");

		// Source
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(35, 5, "Appropriations to which travel should be charged ", 0, 0, "L");
		$this->fpdf->Cell(67);
		$this->fpdf->SetFont('Arial', "U", 12);
		$this->fpdf->Cell(40, 5,': '.$arrData['sfunds'], 0,0, "L");

		// Destination and Purpose Table
		$this->fpdf->Ln(20);
		$x = $this->fpdf->GetX();
		$y = $this->fpdf->GetY();
				
		$this->fpdf->SetFont('Arial', "", 12);
		$this->fpdf->Cell(81, 5, "Destination (Place/Office)", 1, 0, "C");		
		$this->fpdf->Cell(81, 5,"Purpose", 1, 0, "C");
		$this->fpdf->Ln(5);		

		// $mx = $this->fpdf->GetX();
		// $my = $this->fpdf->GetY();

		// $this->fpdf->SetFont('Arial', "", 11);
		// $this->fpdf->MultiCell(81, 5, $arrData['strDestination'] , 1,1);
		// $this->fpdf->SetXY($mx + 81, $my+5);
		// $this->fpdf->MultiCell(81, 5, $arrData['strPurpose'] , 1,1);
		$this->MultiCellRow(2, 81, 5, [$empdesti, $emppur]);		

		//Certificate
		$space = $this->spacingCertificate($empdesti,$emppur);
		$this->fpdf->Ln(8 + ceil($space) * 5);
		// $this->fpdf->SetFont('Arial', "", 12);
		// $this->fpdf->Cell(35, 5, $request_status[0]['requestStatus'], 0, 0, "L");
		
		// $this->fpdf->Ln(8);
		// $this->fpdf->SetFont('Arial', "", 12);
		// $this->fpdf->MultiCell(165, 5, $request_status[0]['remarks'], 0, "L");

		if($cancel_or_not){
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->Cell(35, 5, "Remarks:", 0, 0, "L");
			
			$this->fpdf->Ln(8);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->MultiCell(165, 5, "\t\t\t\t\t\t\t\t\t\t\t\t".$request_status[0]['remarks'], 0, "L");
		} else {
			$this->fpdf->SetFont('Arial', "", 12);
			//$this->fpdf->Cell(35, 5, "Certification:", 0, 0, "L");
			$this->fpdf->Cell(35, 5, "Certification:", 0, 0, "L");
			
			$this->fpdf->Ln(8);
			$this->fpdf->SetFont('Arial', "", 12);
			$this->fpdf->MultiCell(165, 5, "\t\t\t\t\t\t\t\t\t\t\t\tThis is to certify that the travel is necessary and is connected with the functions of the official/employee.", 0, "L");
		}

		
		//Sample QR Code
		$y =  $this->GetY;
		$url = $this->current_pdf_url();
		$this->fpdf->Image('https://api.qrserver.com/v1/create-qr-code/?size=120x120&data='.$url,150,$y,32,32,'PNG');

		//Date Approve
		//print_r($arrData);
		$this->fpdf->Ln(5);
		$this->fpdf->SetFont('Arial', "", 11);
		$this->fpdf->Cell(165, 5, "Date Approved : ".$arrData['endate'], 0, 0, "R");

		// No Signature
		$this->fpdf->Ln(20);
		$this->fpdf->SetFont('Arial', "", 8);
		$this->fpdf->Cell(0, 4, "**************** NO SIGNATURE NEEDED. THIS DOCUMENT HAS BEEN APPROVED ONLINE. ****************", 0, 1, "C");		
		// $arrGet = $this->input->get();

		// $strPrgrph1 = "In reply to your letter of  ";
		// $strPrgrph2 = "accepted";
		// $strPrgrph3 = " to take effect ";
		// $strPrgrph4 = " at the close of the office hours on ";        
		// $this->fpdf->Ln(15);
		// $this->fpdf->SetFont('Arial', "", 12);
		// $this->fpdf->Write(5,$strPrgrph1);
		// $this->fpdf->SetFont('Arial', "B", 12);
		// $this->fpdf->Write(5,$strPrgrph2);
		// $this->fpdf->SetFont('Arial', "", 12);
		// $this->fpdf->Write(5,$strPrgrph3);
		// $this->fpdf->SetFont('Arial', "B", 12);
		// $this->fpdf->Write(5,$strPrgrph4);
		// $this->fpdf->SetFont('Arial', "", 12);

		// $this->fpdf->Ln(20);
		// $this->fpdf->Cell(0,10,"Very truly yours,",0,0,'L');
			
		echo $this->fpdf->Output();
	}

	function current_pdf_url() {
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        	$url = "https://";   
	    else  
	        $url = "http://";   

	    // Append the host(domain name, ip) to the URL.   
	    $url.= $_SERVER['HTTP_HOST'];   
	    
	    // Append the requested resource location to the URL   
	    $url.= $_SERVER['REQUEST_URI']; 

	    // Change all "&" in the url to %26, for qr code api to fully generate the url
	    $con_url = preg_replace("(&)", "%26", $url);

	    return $con_url;  
	}

	function spacingCertificate($str1, $str2){
		if(strlen($str1) > strlen($str2)){
			return $this->fpdf->GetStringWidth($str1) / 80;
		} else {
			return $this->fpdf->GetStringWidth($str2) / 80;
		}
	}

	function MultiCellRow($cells, $width, $height, $data)
	{
	    $x = $this->fpdf->GetX();
	    $y = $this->fpdf->GetY();
	    $maxheight = 0;

	    for ($i = 0; $i < $cells; $i++) {
	        $this->fpdf->MultiCell($width, $height, $data[$i]);
	        if ($this->fpdf->GetY() - $y > $maxheight) $maxheight = $this->fpdf->GetY() - $y;
	       	$this->fpdf->SetXY($x + ($width * ($i + 1)), $y);
	    }

	    for ($i = 0; $i < $cells + 1; $i++) {
	        $this->fpdf->Line($x + $width * $i, $y, $x + $width * $i, $y + $maxheight);
	    }

	    $this->fpdf->Line($x, $y, $x + $width * $cells, $y);
	    $this->fpdf->Line($x, $y + $maxheight, $x + $width * $cells, $y + $maxheight);
	}
	
}
/* End of file Reminder_renewal_model.php */
/* Location: ./application/models/reports/Reminder_renewal_model.php */

	
	
