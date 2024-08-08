<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dtr extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('hr/Hr_model','libraries/Attendance_scheme_model','hr/Attendance_summary_model','hr/Attendance_qr_summary_model','libraries/Agency_profile_model','libraries/Holiday_model','employee/Leave_model'));
    	$this->load->helper(array('dtr_helper'));
    }
	
	public function print_preview()
	{
		// $month = isset($_GET['month']) ? $_GET['month'] : date('m');
		// $yr = isset($_GET['yr']) ? $_GET['yr'] : date('Y');

		// $empid = $this->uri->segment(4);

		// $total_undertime = 0;
		// $total_late = 0;
		// $days_late_ut = 0;
		// $days_absent = 0;
		// $days_lwop = 0;
		// $in_am  = '';
		// $out_am = '';
		// $in_pm  = '';
		// $out_pm = '';
		// $offset_wkdays = 0;
  //   	$offset_wkends = 0;

  //   	$datefrom = isset($_GET['datefrom']) ? $_GET['datefrom'] : date($yr.'-'.sprintf('%02d',$month).'-01');
  //   	$dateto = isset($_GET['dateto']) ? $_GET['dateto'] : date($yr.'-'.sprintf('%02d',$month).'-'.cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')));
		// // $datefrom = currdfrom();
		// // $dateto = currdto();
		// $holidays = $this->Holiday_model->getAllHolidates($empid,$datefrom,$dateto);
		// $working_days = get_workingdays('','',$holidays,$datefrom,$dateto);
		// $agencyname = $this->Agency_profile_model->getData();
		// $agencyname = $agencyname[0]['agencyName'];

		// $arrLatestBalance = $this->Leave_model->getLatestBalance($empid);
		// // echo '<pre>';
		// // echo '<br>datefrom = '.$datefrom;
		// // echo '<br>dateto = '.$dateto;
		// // echo '<br>agencyname = '.$agencyname;
		// // exit(1);
		
		// $this->load->library('general/Pdf_gen');
		// $this->fpdf = new Pdf_gen();

		// $this->fpdf->AddPage('P');
		// $this->fpdf->SetTitle(date('F Y', strtotime($datefrom)));

		// # header
		// $this->fpdf->Image('assets/images/logo.png',10,10,20,20);
		// $this->fpdf->SetFont('Times','',12);
		// $this->fpdf->Cell(25);
		// $this->fpdf->Cell(0,10,'Republic of the Philippines',0,0,'L');
		// $this->fpdf->Ln(7);
		// $this->fpdf->SetFont('Arial','B',14);
		// $this->fpdf->Cell(25);
		// $this->fpdf->Cell(0,8,strtoupper($agencyname),0,0,'L');
		// $this->fpdf->SetTextColor(0,0,0);

		// $this->fpdf->Ln(15);
		// $this->fpdf->Cell(0, 5,"Daily Time Record", 0, 1, "C");
		// $this->fpdf->Ln(2);

		// # employee details
		// $empdata = $this->Hr_model->getData($empid,'','all');
		// $empdata = $empdata[0];
		// $emp_att_scheme = $this->Attendance_scheme_model->getData($empdata['schemeCode']);
		// if(count($emp_att_scheme) > 0):
		// 	$emp_att_scheme = $emp_att_scheme[0];
			
		// 	$this->fpdf->SetFont('Arial','', 8);
		// 	$this->fpdf->Cell(27,5,'Employee Number:','TL',0,'L');
		// 	$this->fpdf->Cell(93,5,$empid,'T',0,'L');
		// 	$this->fpdf->Cell(20,5,'Month/Year:','T',0,'L');
		// 	$this->fpdf->Cell(50,5,date('M. d, Y', strtotime($datefrom)).' - '.date('M. d, Y', strtotime($dateto)),'TR',1,'L');

		// 	$this->fpdf->Cell(27,5,'Employee Name:','L',0,'L');
		// 	$this->fpdf->Cell(93,5,iconv('UTF-8', 'ISO-8859-1', $empdata['surname']).', '.iconv('UTF-8', 'ISO-8859-1', $empdata['firstname']).' '.iconv('UTF-8', 'ISO-8859-1', $empdata['middlename']).' '.$empdata['nameExtension'],0,0,'L');
		// 	$this->fpdf->Cell(20,5,'Official Time:',0,0,'L');
		// 	$this->fpdf->Cell(50,5,date('h:i',strtotime($emp_att_scheme['amTimeinFrom'])).' - '.date('h:i',strtotime($emp_att_scheme['pmTimeoutTo'])),'R',1,'L');

		// 	$this->fpdf->Cell(27,5,'Position:','L',0,'L');
		// 	$this->fpdf->Cell(163,5,$empdata['positionDesc'],'R',1,'L');

		// 	$this->fpdf->Cell(27,5,'Group:','L',0,'L');
		// 	$this->fpdf->Cell(163,5,office_name(employee_office($empid)),'R',1,'L');

		// 	$this->fpdf->Cell(0,2,'','BLR',1,'L');

		// 	# DTR Header
		// 	$this->fpdf->SetFont('Arial','B', 8);
		// 	$arr_header = array('DAY','IN','OUT','IN','OUT','IN','OUT','LATE','Overtime','Undertime','REMARKS');
		// 	$header_w = array(19,12,12,12,12,12,12,12,17,17,53);
		// 	foreach($arr_header as $hk => $colheader):
		// 		$this->fpdf->Cell($header_w[$hk],5,$colheader,'LRB',0,'C');	
		// 	endforeach;
		// 	$this->fpdf->Ln();

		// 	# DTR Content
		// 	$this->fpdf->SetFont('Arial','', 7);
		// 	# DTR Details
		// 	// $arremp_dtr = $this->Attendance_summary_model->getemp_dtr($empid, $month, $yr);

		// 	$arremp_dtr = $this->Attendance_summary_model->getemp_dtr($empid, $datefrom, $dateto);

		// 	foreach($arremp_dtr as $dtr):
		// 		$ddate  = '  '.date('M-d',strtotime($dtr['dtrdate'])).'  '.$dtr['day'];
		// 		$in_am  = count($dtr['dtr']) > 0 ? $dtr['dtr']['inAM']  == '00:00:00' || $dtr['dtr']['inAM']  == '' ? '00:00' : date('h:i',strtotime($dtr['dtr']['inAM']))  : '';
		// 		$out_am = count($dtr['dtr']) > 0 ? $dtr['dtr']['outAM'] == '00:00:00' || $dtr['dtr']['outAM'] == '' ? '00:00' : date('h:i',strtotime($dtr['dtr']['outAM'])) : '';
		// 		$in_pm  = count($dtr['dtr']) > 0 ? $dtr['dtr']['inPM']  == '00:00:00' || $dtr['dtr']['inPM']  == '' ? '00:00' : date('h:i',strtotime($dtr['dtr']['inPM']))  : '';
		// 		$out_pm = count($dtr['dtr']) > 0 ? $dtr['dtr']['outPM'] == '00:00:00' || $dtr['dtr']['outPM'] == '' ? '00:00' : date('h:i',strtotime($dtr['dtr']['outPM'])) : '';
		// 		$remarks= array();
		// 		$certified_ot = 0;
		// 		if(count($dtr['dtr']) > 0):
		// 		    if($dtr['dtr']['OT'] == 1):
		// 		        $certified_ot = 1;
		// 		    endif;
		// 		endif;

		// 		if(count($dtr['holiday_name']) > 0):
		// 		    foreach($dtr['holiday_name'] as $hday): 
		// 		    	$remarks[] = $hday;
		// 		    endforeach;
		// 		endif;

		// 		if(count($dtr['emp_ws']) > 0):
		// 		    foreach($dtr['emp_ws'] as $ws):
		// 		    	$remarks[] = $ws['holidayName'].' - '.date('h:i A',strtotime($ws['holidayTime']));
		// 		    endforeach;
		// 		endif;

		// 		if(count($dtr['obs']) > 0):
		// 		    foreach($dtr['obs'] as $ob):
		// 		    	$remarks[] = 'OB '.date('M.d',strtotime($ob['obDateFrom'])).' to '.date('M.d',strtotime($ob['obDateTo'])).' ('.date('h:i a',strtotime($ob['obTimeFrom'])).')';
		// 		    endforeach;
		// 		endif;
		// 		if(count($dtr['tos']) > 0):
		// 		    foreach($dtr['tos'] as $to):
		// 		    	$remarks[] = 'TO '.date('M.d',strtotime($to['toDateFrom'])).' to '.date('M.d',strtotime($to['toDateTo']));
		// 		    endforeach;
		// 		endif;
		// 		if(count($dtr['leaves']) > 0):
		// 		    foreach($dtr['leaves'] as $leave):
		// 		        $remarks[] = 'Leave '.date('M.d',strtotime($leave['leaveFrom'])).' to '.date('M.d',strtotime($leave['leaveTo']));
		// 		    endforeach;
		// 		endif;
		// 		if(count($dtr['dtr']) > 0):
		// 		    if($dtr['dtr']['remarks'] == 'CL'):
		// 		        $remarks[] = 'CTO';
		// 		    endif;
		// 		endif;
		// 		if(count($dtr['dtr']) > 0):
		// 		    if($dtr['dtr']['wfh']):
		// 		        $remarks[] = 'WFH';
		// 		    endif;
		// 		endif;

		// 		$total_undertime = $total_undertime + $dtr['utimes'];
		// 		$total_late = $total_late + $dtr['lates'];
		// 		if($dtr['lates'] + $dtr['utimes'] > 0):
		// 		    $days_late_ut = $days_late_ut + 1;
		// 		endif;

		// 		if((count($dtr['dtr']) + count($dtr['obs']) + count($dtr['tos']) + count($dtr['holiday_name']) < 1) && !in_array($dtr['day'],array('Sat','Sun'))):
		// 		    if(count($dtr['leaves']) == 0):
		// 		        $days_lwop = $days_lwop + 1;
		// 		    else:
		// 		        $days_absent = $days_absent + 1;
		// 		    endif;
		// 		endif;

		// 		// if((count($dtr['dtr']) + count($dtr['obs']) + count($dtr['tos']) + count($dtr['holiday_name']) < 1) && !in_array($dtr['day'],array('Sat','Sun'))):
		// 		//     $days_absent = $days_absent + 1;
		// 		// endif;

		// 		# check ot
		// 		if($dtr['ot'] > 0 && $certified_ot == 1):
		// 		    if((count($dtr['holiday_name']) < 1) && !in_array($dtr['day'],array('Sat','Sun'))):
		// 		        $offset_wkdays = $offset_wkdays + $dtr['ot'];
		// 		    else:
		// 		        $offset_wkends = $offset_wkends + $dtr['ot'];
		// 		    endif;
		// 		endif;

		// 		$row_detail = array($ddate,
		// 							$in_am,
		// 							$out_am,
		// 							$in_pm,
		// 							$out_pm,
		// 							'', // (count($dtr['dtrdata']) > 0 ? date('H:i', strtotime($dtr['dtrdata']['outOT'])) : ':'),
		// 							'', // (count($dtr['dtrdata']) > 0 ? date('H:i', strtotime($dtr['dtrdata']['outOT'])) : ':'),
		// 							$dtr['lates'] > 0 ? date('H:i', mktime(0, $dtr['lates'])) : '',
		// 							count($dtr['dtr']) > 0 ? $dtr['dtr']['OT'] == 1 ? $dtr['ot'] > 0 ? date('H:i', mktime(0, $dtr['ot'])) : '' : '' : '',
		// 							$dtr['utimes'] > 0 ? date('H:i', mktime(0, $dtr['utimes'])) : '',
		// 							implode('; ',$remarks));

		// 		// foreach($row_detail as $hk => $row):
		// 		// 	$this->fpdf->Cell($header_w[$hk],5,$row,'LRB',0,$hk==0 ? 'L' : 'C');	
		// 		// endforeach;

		// 		$align = array('L','C','C','C','C','C','C','C','C','C','C');
		// 		$border = array(1,1,1,1,1,1,1,1,1,1,1);
		// 		$this->fpdf->SetWidths($header_w);
		// 		// $this->fpdf->SetAligns($width);
		// 		$this->fpdf->FancyRow_small(5,$row_detail,$border,$align);
				
		// 		// $this->fpdf->Ln();
		// 	endforeach;

		// 	$this->fpdf->Ln(2);

		// 	# footer
		// 	$this->fpdf->SetFont('Arial','', 8);

		// 	$this->fpdf->Cell(45,5,'Total Number of Working Days: ',0,0,'L');
		// 	$this->fpdf->Cell(70,5,count($working_days),0,0,'L');
		// 	$this->fpdf->Cell(35,5,'Total Days Absent: ',0,0,'L');
		// 	$this->fpdf->Cell(40,5,$days_absent,0,1,'L');

		// 	$this->fpdf->Cell(45,5,'Total Undertime: ',0,0,'L');
		// 	$this->fpdf->Cell(70,5,date('H:i', mktime(0, $total_undertime)),0,0,'L');
		// 	$this->fpdf->Cell(35,5,'VL: ',0,0,'L');
		// 	$this->fpdf->Cell(40,5,count($arrLatestBalance) > 0 ? $arrLatestBalance['vlBalance'] : '',0,1,'L');
		// 	// echo '<pre>';
		// 	// print_r($arrLatestBalance);
		// 	// die();
		// 	$this->fpdf->Cell(45,5,'Total Late:',0,0,'L');
		// 	$this->fpdf->Cell(70,5,date('H:i', mktime(0, $total_late)),0,0,'L');
		// 	$this->fpdf->Cell(35,5,'SL: ',0,0,'L');
		// 	$this->fpdf->Cell(40,5,count($arrLatestBalance) > 0 ? $arrLatestBalance['slBalance'] : '',0,1,'L');

		// 	$this->fpdf->Cell(45,5,'Late/Undertime: ',0,0,'L');
		// 	$this->fpdf->Cell(70,5,date('H:i', mktime(0, ($total_undertime + $total_late))),0,0,'L');
		// 	$this->fpdf->Cell(35,5,'Offset Balance: ',0,0,'L');
		// 	$this->fpdf->Cell(40,5,count($arrLatestBalance) > 0 ? date('H:i', mktime(0, $arrLatestBalance['off_bal'])) : '',0,1,'L');

		// 	$this->fpdf->Cell(45,5,'Total Days Late/Undertime: ',0,0,'L');
		// 	$this->fpdf->Cell(70,5,$days_late_ut,0,0,'L');
		// 	$this->fpdf->Cell(35,5,'Offset Gain: ',0,0,'L');
		// 	$this->fpdf->Cell(40,5,($offset_wkdays + $offset_wkends) > 0 ? date('H:i', mktime(0, ($offset_wkdays + $offset_wkends))) : '',0,1,'L');
			
		// 	$this->fpdf->Cell(45,5,'Total Days LWOP: ',0,0,'L');
		// 	$this->fpdf->Cell(70,5,$days_lwop,0,0,'L');
		// 	$this->fpdf->Cell(35,5,'Offset Used: ',0,0,'L');
		// 	$this->fpdf->Cell(40,5,count($arrLatestBalance) > 0 ? date('H:i', mktime(0, $arrLatestBalance['off_used'])) : '',0,1,'L');

		// 	$this->fpdf->Ln(5);
		// 	$this->fpdf->MultiCell(190, 5, 'I HEREBY CERTIFY that the above records are true and correct report of the hours of work performed of which was made daily from the time of arrival and departure from the office.','T','J');

		// 	$this->fpdf->SetFont('Arial','B', 8);
		// 	$this->fpdf->Ln(3);
		// 	$this->fpdf->Cell(20,5,'',0,0,'L');
		// 	$this->fpdf->Cell(45,5,"EMPLOYEE'S SIGNATURE","T",0,'C');
		// 	$this->fpdf->Cell(10,5,'',0,0,'L');
		// 	$this->fpdf->Cell(95,5,"DIVISION CHIEF / IMMEDIATE SUPERVISOR'S SIGNATURE","T",0,'C');
		// 	$this->fpdf->Cell(20,5,'',0,0,'L');
		// else:
		// 	$this->fpdf->SetTextColor(255, 85, 0);
		// 	$this->fpdf->Ln(15);
		// 	$this->fpdf->Cell(0, 5,"Attendance Scheme for ".getfullname($empdata['firstname'], $empdata['surname'], $empdata['middlename'], $empdata['nameExtension'])." is not yet set.", 0, 1, "C");
		// 	$this->fpdf->Ln(2);
		// endif;

		#Variables
		$empid = $this->uri->segment(4);
		$month = isset($_GET['month-dtr']) ? $_GET['month-dtr'] : date('m');
		$yr = isset($_GET['year-dtr']) ? $_GET['year-dtr'] : date('Y');
		$date_from = $_GET['datefrom'];
		$date_to = $_GET['dateto'];

		# Date
		#first_date = date("d/m/Y", strtotime("1-".$month."-".$yr));
		#$last_date = date("t/m/Y", strtotime("1-".$month."-".$yr));

		# Get the date of date_from
		$first_date_month = date('j', strtotime($date_from));

		# Get the date of date_to
		$last_date_month = date("j", strtotime($date_to));

		# employee details
		$empdata = $this->Hr_model->getData($empid,'','all');
		$empdata = $empdata[0];
		$empno = $arrData['strEmpNo'] == "" ? $_SESSION['sessEmpNo'] : $arrData['strEmpNo'];
		$emp = $this->Hr_model->getData($empno,'','all')[0];
		$sec_code = $this->Hr_model->get_employee_position($emp['empNumber']);
		

		$this->load->library('general/Pdf_gen');
		$this->fpdf = new Pdf_gen();

		$this->fpdf->AddPage('P');
		$this->fpdf->SetAutoPageBreak(true,10);

		#Header
		$this->fpdf->SetFont('Arial','B',14);
		$this->fpdf->Image('assets/images/DENR-LOGO.png',13,10,30,30,'PNG');
		$this->fpdf->Cell(38);

		if($sec_code[0]['sectionCode'] == "PILOILO"):

		$this->fpdf->Cell(50, 12, "DENR - PENRO ILOILO", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Port Area, Brgy. Concepcion-Montes", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Iloilo City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CGUIMBAL"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO ILOILO", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Port Area, Brgy. Concepcion-Montes", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Iloilo City", 0, 0, "L");
	
		elseif($sec_code[0]['sectionCode'] == "CBAROTAC"):

		$this->fpdf->Cell(50, 12, "DENR - PENRO ILOILO", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Port Area, Brgy. Concepcion-Montes", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Iloilo City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CSARA"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO ILOILO", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Port Area, Brgy. Concepcion-Montes", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Iloilo City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PILOILO TSD"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO ILOILO", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Port Area, Brgy. Concepcion-Montes", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Iloilo City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "FMP-PPMO"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO ILOILO", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Port Area, Brgy. Concepcion-Montes", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Iloilo City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PAKLAN"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO AKLAN", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bliss Site, Kalibo", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Aklan", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CBORACAY"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO AKLAN", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bliss Site, Kalibo", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Aklan", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PAKLAN TSD"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO AKLAN", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bliss Site, Kalibo", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Aklan", 0, 0, "L");

	elseif($sec_code[0]['sectionCode'] == "CENRO BORACAY"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO AKLAN", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bliss Site, Kalibo", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Aklan", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PANTIQUE"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO ANTIQUE", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Maybato Sur, San Jose", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Antique", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CBELISON"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO ANTIQUE", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Maybato Sur, San Jose", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Antique", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CCULASI"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO ANTIQUE", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Maybato Sur, San Jose", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Antique", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PCAPIZ"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO CAPIZ", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Brgy. Lanot, Roxas City", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Capiz", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CMAMBUSAO"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO CAPIZ", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Brgy. Lanot, Roxas City", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Capiz", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PCAPIZ TSD"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO CAPIZ", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Brgy. Lanot, Roxas City", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Capiz", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PGUIMARAS"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO GUIMARAS", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Capitol Compound, San Miguel", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Jordan, Guimaras", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PGUIMARAS TSD"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO GUIMARAS", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Capitol Compound, San Miguel", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Jordan, Guimaras", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PNEGROS"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO NEGROS OCC.", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Corner Porras - Abad Santos Sts., Brgy. 39", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bacolod City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "PNEGROS TSD"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO NEGROS OCC.", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Corner Porras - Abad Santos Sts., Brgy. 39", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bacolod City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CCADIZ"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO NEGROS OCC.", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Corner Porras - Abad Santos Sts., Brgy. 39", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bacolod City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CKABANKALAN"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO NEGROS OCC.", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Corner Porras - Abad Santos Sts., Brgy. 39", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bacolod City", 0, 0, "L");

		elseif($sec_code[0]['sectionCode'] == "CBAGO"):
		
		$this->fpdf->Cell(50, 12, "DENR - PENRO NEGROS OCC.", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Corner Porras - Abad Santos Sts., Brgy. 39", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Bacolod City", 0, 0, "L");

		else:

		$this->fpdf->Cell(50, 12, "DENR - REGION VI", 0, 0, "L");
		$this->fpdf->Cell(35);
		$this->fpdf->Cell(50, 12, "Legend:", 0, 1, "L");
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Port Area, Brgy. Concepcion-Montes", 0, 0, "L");	
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "WD - Whole Day", 0, 1, "L");
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Iloilo City", 0, 0, "L");

		endif;
		
			
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "HD - Half Day", 0, 1, "L");	
		$this->fpdf->Cell(38);
		$this->fpdf->Cell(50, 5, "Philippines", 0, 0, "L");
		$this->fpdf->Cell(42);
		$this->fpdf->Cell(50, 5, "HDL - Half Day Leave", 0, 1, "L");	
		$this->fpdf->Cell(130);
		$this->fpdf->Cell(50, 5, "LT - Lates", 0, 1, "L");	
		$this->fpdf->Cell(0, 5,"", 0, 1);
		$this->fpdf->Cell(123);
		$this->fpdf->Cell(1, 5, "Note:", 0, 0, "L");
		$this->fpdf->Cell(10);	
		$this->fpdf->MultiCell(50, 5, "*** All computation below are in hour and minutes format ***", 0);

		# Content
		$this->fpdf->SetFont('Arial','B', 12);
		$this->fpdf->Cell(0, 6,"", 0, 1);
		$this->fpdf->Cell(3);	
		$this->fpdf->Cell(0, 8, "Daily Time Record for the period of " . $date_from . " to " . $date_to, 0, 1, "L");
		$this->fpdf->SetFont('Arial','',12);
		$this->fpdf->Cell(3);
		$this->fpdf->SetFont('Arial','U', 12);	
		$this->fpdf->Cell(30, 8, "Employee No.:", 0, 0, "L");

		$this->fpdf->SetFont('Arial','B', 12);
		$this->fpdf->Cell(60, 8, $empid , 0, 0, "L");

		$this->fpdf->SetFont('Arial','U', 12);	
		$this->fpdf->Cell(15, 8, "Name:", 0, 0, "L");

		$this->fpdf->SetFont('Arial','B', 12);
		$this->fpdf->Cell(10, 8, $empdata['surname']. ", ". $empdata['firstname']. " " . $empdata['middlename'], 0, 1, "L");

		# Table Header
		$this->fpdf->SetFont('Arial','',9);
		$this->fpdf->Cell(0, 3, "",0,1);
		$this->fpdf->Cell(4);

		$this->fpdf->Cell(16, 12, "Date", 1, 0, "C");
		$this->fpdf->Cell(16, 12, "Day", 1, 0, "C");
		$this->fpdf->Cell(16, 12, "In", 1, 0, "C");

		$this->fpdf->Cell(32, 6, "Break", 1, 0, "C");
		$this->fpdf->Cell(16, 12, "Out", 1, 0, "C");

		$this->fpdf->Cell(32, 6, "Overtime", 1, 0, "C");

		$this->fpdf->Cell(16, 12, "LT", 1, 0, "C");

		$this->fpdf->Cell(16, 12, "UT", 1, 0, "C");

		$this->fpdf->Cell(24, 12, "Remarks", 1, 1, "C");

		$my = $this->fpdf->GetY();
		$this->fpdf->SetY($my-6); 

		$this->fpdf->Cell(52);
		$this->fpdf->Cell(16, 6, "Out", 1, 0, "C");
		$this->fpdf->Cell(16, 6, "In", 1, 0, "C");

		$this->fpdf->Cell(16);
		$this->fpdf->Cell(16, 6, "In", 1, 0, "C");
		$this->fpdf->Cell(16, 6, "Out", 1, 0, "C");

		$getetodtrdata = $this->Attendance_qr_summary_model->getDTReto($empid);
		

		# Table Cells
		$this->fpdf->Ln();
		$this->fpdf->SetFont('Arial','',9);
		
		for ($i = $first_date_month; $i <= $last_date_month; $i++) {
			$d = $yr."-".$month."-".$i;
			$dayofweek = date('D', strtotime($d));
			$dimprove = date('Y-m-d', strtotime($d));

			foreach($getetodtrdata as $etodata){
				$requesttype = $etodata['requestCode'];
				if ($requesttype == 'TO'):
					$therequest = explode(';', $etodata['requestDetails']);
					if(($dimprove >= $therequest[1]) && ($dimprove <= $therequest[2])){
						$requestdate = $etodata['requestDate'];
						$toyear = substr($requestdate, 0,4);
						$etoid = 'DENR6-'.$toyear.'-'.$etodata['requestID'];
						break;
					}else{
						$etoid = '';
					}
				endif;
			}

			# Get Data from Database
			$scanqr_dtr = $this->Attendance_qr_summary_model->getSingleData($empid, $d); 

			# Convert 12oClock Time
			$inAm = ($scanqr_dtr['inAM'] == null) ? "" : $this->twelfthOClock($scanqr_dtr['inAM']);
			$outBreak = ($scanqr_dtr['outBreak'] == null) ? "" : $this->twelfthOClock($scanqr_dtr['outBreak']);
			$inBreak = ($scanqr_dtr['inBreak'] == null) ? "" : $this->twelfthOClock($scanqr_dtr['inBreak']);
			$outPM = ($scanqr_dtr['outPM'] == null) ? "" : $this->twelfthOClock($scanqr_dtr['outPM']);
			$inOvertime = ($scanqr_dtr['inOvertime'] == null) ? "" : $this->twelfthOClock($scanqr_dtr['inOvertime']);
			$outOvertime = ($scanqr_dtr['outOvertime'] == null) ? "" : $this->twelfthOClock($scanqr_dtr['outOvertime']);
			
			if($scanqr_dtr['underTime'] != null || $scanqr_dtr['underTime'] != ""){
				$undertime = $scanqr_dtr['underTime'];
			}else{
				$undertime = 0;
			}

			$this->fpdf->Cell(4);

			if($this->isWeekend($i."-".$month."-".$yr)){
				$this->fpdf->setFillColor(154,205,50); 
			} 
			else {
				$this->fpdf->setFillColor(255,255,255); 
			}
			

			$this->MultiCellRow(10, 16, 5, [$i, $dayofweek, $inAm, $outBreak, $inBreak, $outPM, $inOvertime, $outOvertime, date('H:i', mktime(0,$scanqr_dtr['late'])),'00:00' ,$etoid]);
			$this->fpdf->SetFont('Arial','',7);
			$this->fpdf->Cell(24, 5, $etoid, 1, 0, "C");
			$this->fpdf->Ln();
		}


		# Signature
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(4);
		$this->fpdf->MultiCell(180, 5, "I certify that the entries on this record which were made by myself daily at the time of arrival at end departure from the office are true and correct.", 0,  "L");

		$y = $this->fpdf->GetY();
		$this->fpdf->Line(15, $y + 10, 95, $y + 10);
		$this->fpdf->Line(115, $y + 10, 195, $y + 10);

		$y = $this->fpdf->GetY();
		$this->fpdf->SetY($y + 12);
		$this->fpdf->SetFont('Arial','',10);
		$this->fpdf->Cell(5);	
		$this->fpdf->Cell(80, 5, "Employee's Signature", 0, 0, "C");
		$this->fpdf->Cell(20);	
		$this->fpdf->Cell(80, 5, "Authorized Official", 0, 0, "C");

		$this->fpdf->Output();
	}

	public function MultiCellRow($cells, $width, $height, $data)
	{
	    $x = $this->fpdf->GetX();
	    $y = $this->fpdf->GetY();
	    $maxheight = 0;

	    for ($i = 0; $i < $cells; $i++) {
	        $this->fpdf->MultiCell($width, $height, $data[$i], 0, 'C', 1, true);
	        if ($this->fpdf->GetY() - $y > $maxheight) $maxheight = $this->fpdf->GetY() - $y;
	       	$this->fpdf->SetXY($x + ($width * ($i + 1)), $y);
	    }

	    for ($i = 0; $i < $cells + 1; $i++) {
	        $this->fpdf->Line($x + $width * $i, $y, $x + $width * $i, $y + $maxheight);
	    }

	    $this->fpdf->Line($x, $y, $x + $width * $cells, $y);
	    $this->fpdf->Line($x, $y + $maxheight, $x + $width * $cells, $y + $maxheight);
	}

	public function isWeekend($date) {
	    return (date('N', strtotime($date)) >= 6);
	}

	public function twelfthOClock($time) {
	    return date("h:i A", strtotime($time));
	}
}
/* End of DTR Controller */
