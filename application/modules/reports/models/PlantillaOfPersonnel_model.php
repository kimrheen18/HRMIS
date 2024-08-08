<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PlantillaOfPersonnel_model extends CI_Model {

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

	function getplantillagroup()
	{
		return $this->db->select('*')->order_by('plantillaGroupOrder')->get('tblPlantillaGroup')->result_array();
	}

	function getplantilladetails($strGroupCode)
	{
		$objQuery = $this->db->select('*')->where('plantillaGroupCode',$strGroupCode)->order_by('itemNumber ASC,salaryGrade DESC, xstepNumber DESC')->get('tblPlantilla');
		//echo $this->db->last_query();exit(1);
		return $objQuery->result_array();
	}

	function getsalaryscheddetails($sgNo)
	{
		return $this->db->select('actualSalary')->where('stepNumber',1)->where('salaryGradeNumber',$sgNo)->get('tblSalarySched')->result_array();
	}

	function getcurrentservicefromdate($empno)
	{
		return $this->db->select('serviceFromDate')->where('empNumber',$empno)->order_by('serviceFromDate DESC')->get('tblServiceRecord')->result_array();
	}

	function getlatesteduc($strEmpNum)
	{
		return $this->db->select('tblCourse.courseCode')->join('tblCourse','tblEmpSchool.course = tblCourse.courseDesc','inner')->where('empNumber',$strEmpNum)->order_by('schoolToDate DESC')->get('tblEmpSchool')->result_array();
	}

	function getlatestexam($strEmpNum)
	{
		return $this->db->select('tblEmpExam.examCode, tblExamType.examDesc')->join('tblExamType','tblEmpExam.examCode = tblExamType.examCode','inner')->where('tblEmpExam.empNumber',$strEmpNum)->where('tblExamType.csElligible','Y')->order_by('tblEmpExam.examDate DESC')->get('tblEmpExam')->result_array();
	}

	function getvacantposition($strstepNumber,$strGroupCode,$strItemNumber)
	{
		return $this->db->select('tblPlantilla.itemNumber, tblPosition.positionDesc,tblPlantilla.salaryGrade, tblPlantilla.authorizeSalary, tblPlantilla.xstepNumber')->join('tblPosition','tblPosition.positionCode = tblPlantilla.positionCode','inner')->where('tblPlantilla.xstepNumber',$strstepNumber)->where('tblPlantilla.plantillaGroupCode',$strGroupCode)->where('tblPlantilla.itemNumber',$strItemNumber)->get('tblPlantilla')->result_array();
	}

	function getemployeedetails($strGroupCode,$strItemNumber,$strItemNumberUnique)
	{
		$this->db->select('DISTINCT(tblEmpPersonal.empNumber), tblEmpPersonal.surname,tblEmpPersonal.firstname, tblEmpPersonal.middlename, tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension, tblEmpPersonal.birthday,
			tblEmpPersonal.sex, tblEmpPersonal.tin, tblEmpPosition.stepNumber,
			tblEmpPosition.positionCode, tblPosition.positionDesc,
			tblEmpPosition.salaryGradeNumber, tblEmpPosition.itemNumber,
			tblEmpPosition.authorizeSalary, tblEmpPosition.actualSalary,
			tblEmpPosition.positionDate, tblEmpPosition.appointmentCode,
			tblEmpPosition.firstDayAgency, tblEmpPosition.statusOfAppointment, 
			tblEmpPosition.detailedfrom,tblEmpPosition.nature');
		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');
		$this->db->join('tblPosition','tblEmpPosition.positionCode = tblPosition.positionCode','inner');
		$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		$this->db->where('tblEmpPosition.plantillaGroupCode',$strGroupCode);
		$this->db->where('tblEmpPosition.itemNumber',$strItemNumber);
		//$this->db->like('tblEmpPosition.uniqueItemNumber',$strItemNumberUnique);
		$this->db->where("(tblEmpPosition.detailedfrom = '0' OR tblEmpPosition.detailedfrom = '2')");
		$objQuery = $this->db->get('tblEmpPersonal')->result_array();
		//echo $this->db->last_query();exit(1);
		return $objQuery;
		// $objPersonnel = mysql_query("SELECT DISTINCT tblEmpPersonal.empNumber, tblEmpPersonal.surname,
		// tblEmpPersonal.firstname, tblEmpPersonal.middlename, 
		// tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension, tblEmpPersonal.birthday,
		// tblEmpPersonal.sex, tblEmpPersonal.tin, tblEmpPosition.stepNumber,
		// tblEmpPosition.positionCode, tblPosition.positionDesc,
		// tblEmpPosition.salaryGradeNumber, tblEmpPosition.itemNumber,
		// tblEmpPosition.authorizeSalary, tblEmpPosition.actualSalary,
		// tblEmpPosition.positionDate, tblEmpPosition.appointmentCode, 					
		// tblEmpPosition.firstDayAgency, 
		// tblEmpPosition.statusOfAppointment, 
		// tblEmpPosition.detailedfrom 
		// FROM tblEmpPersonal
		// INNER JOIN tblEmpPosition
		// 	ON tblEmpPersonal.empNumber = tblEmpPosition.empNumber
		// INNER JOIN tblPosition
		// 	ON tblEmpPosition.positionCode = tblPosition.positionCode
	
		//  WHERE tblEmpPosition.statusOfAppointment = 'In-Service' AND
		//   tblEmpPosition.plantillaGroupCode='$strGroupCode' AND
		//   tblEmpPosition.itemNumber='$strItemNumber' 
		//  AND tblEmpPosition.uniqueItemNumber='$strItemNumberUnique' 
	 //  AND (tblEmpPosition.detailedfrom = '0' OR tblEmpPosition.detailedfrom = '2') 
	 // ");
	}

	function generate($arrData)
	{		
		$this->fpdf = new FPDF('L','mm','Legal');
		$this->fpdf->AliasNbPages();
		$this->fpdf->Open();

		$this->fpdf->AddPage('L','Legal');

		$this->setOfficeInfo();
		
		//$this->fpdf->SetFont('Arial','B',12);
		$this->printHeader();
		
		//$this->fpdf->Ln(10);
		
		//SELECT PLANTILLA GROUP CODE
		// $objGroup = mysql_query("SELECT * FROM tblPlantillaGroup ORDER BY plantillaGroupOrder");
		$objGroup = $this->getplantillagroup();
		//$numGroup = mysql_num_rows($objGroup);

		//while($arrDivision = mysql_fetch_array($objGroup))
		foreach($objGroup as $arrDivision)
		{
			$intCounter = 0;
			
			$strGroupCode = $arrDivision['plantillaGroupCode'];
			$strDivisionName = $arrDivision['plantillaGroupName'];

			// CHECK IF GROUP CODE HAS PLANTILLA NUMBER IN TBLEMPPOSITION
			//$objCheckPersonnel = mysql_query("SELECT * FROM tblEmpPosition
			//								 WHERE tblEmpPosition.statusOfAppointment = 'In-Service' AND
			//								  tblEmpPosition.plantillaGroupCode='$strGroupCode' 
			//							  AND (tblEmpPosition.detailedfrom = '0' OR tblEmpPosition.detailedfrom = '2')");
										  
			//$empNumRowsCheck = mysql_num_rows($objCheckPersonnel);
			
			//if($empNumRowsCheck>0)
			//{
			$this->printGroupName($strDivisionName);
				
				//SEARCH ITEM NUMBERS
				//$objItemNumber = mysql_query("SELECT * FROM tblPlantilla WHERE plantillaGroupCode='$strGroupCode' ORDER BY itemNumber , plantillaItemOrder ASC, salaryGrade DESC, stepNumber ASC");
				//$objItemNumber = mysql_query("SELECT * FROM tblPlantilla WHERE plantillaGroupCode='$strGroupCode' ORDER BY  plantillaItemOrder ASC,itemNumber ASC, salaryGrade DESC, stepNumber DESC");
				// $objItemNumber = mysql_query("SELECT * FROM tblPlantilla WHERE plantillaGroupCode='$strGroupCode' ORDER BY itemNumber asc, salaryGrade DESC, stepNumber DESC");
				$objItemNumber = $this->getplantilladetails($strGroupCode);

				$plantillaNumRowsCheck = count($objItemNumber);
				
				if($plantillaNumRowsCheck>0)
				{
					//while($rowItemNumber = mysql_fetch_array($objItemNumber))
					foreach($objItemNumber as $rowItemNumber)
					{
					
						$strItemNumber = $rowItemNumber['itemNumber'];
						$arrItem = explode(':',$rowItemNumber['uniqueItemNumber']);
						$strItemNumberUnique = $arrItem[0];
						$strstepNumber = $rowItemNumber['xstepNumber'];
						$strAreaCode = $rowItemNumber['areaCode'];
						$strAreaType = $rowItemNumber['areaType'];
						$strLevel = $rowItemNumber['level'];

						
						// removed empschool, exam
							// $objPersonnel = mysql_query("SELECT DISTINCT tblEmpPersonal.empNumber, tblEmpPersonal.surname,
							// 	tblEmpPersonal.firstname, tblEmpPersonal.middlename, 
							// 	tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension, tblEmpPersonal.birthday,
							// 	tblEmpPersonal.sex, tblEmpPersonal.tin, tblEmpPosition.stepNumber,
							// 	tblEmpPosition.positionCode, tblPosition.positionDesc,
							// 	tblEmpPosition.salaryGradeNumber, tblEmpPosition.itemNumber,
							// 	tblEmpPosition.authorizeSalary, tblEmpPosition.actualSalary,
							// 	tblEmpPosition.positionDate, tblEmpPosition.appointmentCode, 					
							// 	tblEmpPosition.firstDayAgency, 
							// 	tblEmpPosition.statusOfAppointment, 
							// 	tblEmpPosition.detailedfrom 
							// 	FROM tblEmpPersonal
							// 	INNER JOIN tblEmpPosition
							// 		ON tblEmpPersonal.empNumber = tblEmpPosition.empNumber
							// 	INNER JOIN tblPosition
							// 		ON tblEmpPosition.positionCode = tblPosition.positionCode
							
							// 	 WHERE tblEmpPosition.statusOfAppointment = 'In-Service' AND
							// 	  tblEmpPosition.plantillaGroupCode='$strGroupCode' AND
							// 	  tblEmpPosition.itemNumber='$strItemNumber' 
							// 	 AND tblEmpPosition.uniqueItemNumber='$strItemNumberUnique' 
							//   AND (tblEmpPosition.detailedfrom = '0' OR tblEmpPosition.detailedfrom = '2') 
							//  ");
						//echo $strItemNumber.'=='.$strItemNumberUnique;						
						$objPersonnel = $this->getemployeedetails($strGroupCode,$strItemNumber,$strItemNumberUnique);					
						$empNumRows = count($objPersonnel);
						$printedItemNumber = '';
						if($empNumRows>0)
						{
							// while($arrPersonnel = mysql_fetch_array($objPersonnel))
							$empNum='';
							foreach($objPersonnel as $arrPersonnel)
							{
								$strEmpNum = $arrPersonnel['empNumber'];
								$strMN =  $arrPersonnel['middlename'];
								$strMiddleName = substr($strMN, 0,1);
								$strName = $arrPersonnel['surname']. ", " .$arrPersonnel['firstname']. " ".$arrPersonnel['nameExtension']." ".
								mi($arrPersonnel['middleInitial']);
								$strName = utf8_decode($strName);
								$strSex = $arrPersonnel['sex'];
								$intTin = $arrPersonnel['tin'];
								$strBirthday = $arrPersonnel['birthday'];
								//$strDivisionCode = $arrPersonnel['divisionCode'];
								$strPositionCode = $arrPersonnel['positionCode'];
								$strPositionDesc = $arrPersonnel['positionDesc'];
								//$strDivisionDesc = $arrPersonnel['divisionName'];
								$strAppointmentStatus = $arrPersonnel['statusOfAppointment'];
								//$strItemNumber = $arrPersonnel['itemNumber'] ." Step " .$strstepNumber ;
								$strItemNumber = $arrPersonnel['itemNumber'] ;

								// Authorized salary is salary equivalent to step 1
								// $objAutSalary = mysql_query("SELECT actualSalary FROM tblSalarySched WHERE stepNumber=1 AND salaryGradeNumber='".$arrPersonnel['salaryGradeNumber']."'");
								$objAutSalary = $this->getsalaryscheddetails($arrPersonnel['salaryGradeNumber']);
								// $rowAutSalary = mysql_fetch_array($objAutSalary);
								foreach($objAutSalary as $rowAutSalary)
									$strAuthorizeSalary = $rowAutSalary['actualSalary'];
								
								//$strAuthorizeSalary = $arrPersonnel['authorizeSalary'];
								$strActualSalary = $arrPersonnel['actualSalary'];
								$strStepNumber = $arrPersonnel['stepNumber'];
								$strSalaryGradeNumber = $arrPersonnel['salaryGradeNumber'];
								$strAppointmentCode = $arrPersonnel['appointmentCode'];

								// Get date of current position date
								$objPosDate = $this->getcurrentservicefromdate($strEmpNum);
	 							//$objPosDate = mysql_query("SELECT serviceFromDate FROM tblServiceRecord  WHERE empNumber='".$strEmpNum."' ORDER BY serviceFromDate DESC");

								// $rowPosDate = mysql_fetch_array($objPosDate);
								//$strPositionDate = $rowPosDate['serviceFromDate'];
								$strFirstDayAgency = $arrPersonnel['firstDayAgency'];
								$strPositionDate = $arrPersonnel['positionDate'];
								if($strFirstDayAgency!=$strPositionDate) // if first day agency and position date is equal, dont show position date/last promotion
									$strPositionDate = $arrPersonnel['positionDate'];
								else	
									$strPositionDate = "";
									
								//$strAuthorizeSalary = $rowAutSalary['actualSalary'];
								
								//$strExamCode = $arrPersonnel['examCode'];
								//$strExamDesc = $arrPersonnel['examDesc'];
								$strNature = $arrPersonnel['nature'];
								//$strExamDesc = $arrPersonnel['examDesc'];
								
								// get latest cs eligibility
								//$strExamType = $arrPersonnel['examType'];
								$strExamType = '';
								
								// get latest educ attainment
								$rowEducal = $this->getlatesteduc($strEmpNum);
								// $objEducal = mysql_query("SELECT tblCourse.courseCode FROM tblEmpSchool INNER JOIN tblCourse ON tblEmpSchool.course = tblCourse.courseDesc  WHERE empNumber='$strEmpNum' ORDER BY schoolToDate DESC");
								//$rowEducal = mysql_fetch_array($objEducal);
								if(count($rowEducal)>0)
									$strEducal = $rowEducal[0]['courseCode'];
		
								// get latest exam
								//$objExam = mysql_query("SELECT examCode FROM tblEmpExam WHERE empNumber='$strEmpNum'");											
								$objExam = $this->getlatestexam($strEmpNum);
								// $objExam = mysql_query("SELECT tblEmpExam.examCode, tblExamType.examDesc FROM tblEmpExam 
								// 						INNER JOIN tblExamType
								// 						ON tblEmpExam.examCode = tblExamType.examCode
								// 						WHERE tblEmpExam.empNumber='$strEmpNum' AND tblExamType.csElligible='Y'  ORDER BY tblEmpExam.examDate DESC");											
								
								$arrExamDesc = array();
								//while ($rowExam = mysql_fetch_array($objExam))
								foreach($objExam as $rowExam)
								{
									$strExam = $rowExam['examCode'];
									array_push($arrExamDesc, $strExam);	
								
								}
								
								$arrExamDesc = array_unique($arrExamDesc);
								$strExamDesc = implode(", ",$arrExamDesc);

								//$intPao = 0;	
								//while($rowExam = mysql_fetch_array($objExam)){
								
								//	$strExamDesc2[$intPao] = $rowExam['examCode'];
								//	$strExamDesc= $strExamDesc2[$intPao];
								//	$intPao ++;

								//}




								$strWorkNature = substr($strNature,0,1);
								
								if ($strAppointmentStatus == 'In-Service' && $strEmpNum!=$empNum)
								{
									$empNum=$arrPersonnel['empNumber'];
									$intCounter ++;
									$this->printBody($intCounter, $strName, $strSex, $strBirthday, $intTin, $strPositionDesc, $strItemNumber, number_format($strAuthorizeSalary,2), number_format($strActualSalary,2), $strStepNumber, $strSalaryGradeNumber, $strAppointmentCode, $strPositionDate, $strFirstDayAgency, $strExamType, $strWorkNature, $strEducal, $strExamDesc,$strAreaCode, $strAreaType, $strLevel);
									
								}			
								
								// used to check if the item number is already printed. if already printed, no need to print the item number again.
								
								$printedItemNumber = $strItemNumber;
							}
						} 
						elseif($strstepNumber==1 AND $strItemNumber!=$printedItemNumber)
						{
			
							// PRINT VACANT POSITION PAO
							
							//$strItemNumber = $rowItemNumber['itemNumber'];
							//$strItemNumberUnique = $rowItemNumber['uniqueItemNumber'];
							//$strstepNumber = $rowItemNumber['stepNumber'];
							$objPersonnel2 = $this->getvacantposition($strstepNumber,$strGroupCode,$strItemNumber);
							// $objPersonnel2 = mysql_query("SELECT tblPlantilla.itemNumber, tblPosition.positionDesc,
							// 				tblPlantilla.salaryGrade, tblPlantilla.authorizeSalary, tblPlantilla.stepNumber 
							// 				FROM tblPlantilla
							// 				INNER JOIN tblPosition
							// 				ON tblPosition.positionCode = tblPlantilla.positionCode
							// 				WHERE tblPlantilla.stepNumber = '$strstepNumber' AND tblPlantilla.plantillaGroupCode='$strGroupCode' AND
							// 				tblPlantilla.itemNumber='$strItemNumber'");

														
							$empNumRows2 = count($objPersonnel2);
								

								if($empNumRows2>0)
								{
							
									// $arrPersonnel2 = mysql_fetch_array($objPersonnel2);
									foreach($objPersonnel2 as $arrPersonnel2)
									{
										$strPositionDesc = $arrPersonnel2['positionDesc'];
										$strItemNumber = $arrPersonnel2['itemNumber'] ;

										$strAuthorizeSalary = $arrPersonnel2['authorizeSalary'];
										$strSalaryGrade = $arrPersonnel2['salaryGrade'];
									}
									
									
									$intCounter ++;	
									$this->vacantPosition($intCounter, $strItemNumber, $strPositionDesc, $strAuthorizeSalary, $strSalaryGrade);	
							
								}
								

						} // if($empNumRows>0)
					
					} // while($rowItemNumber = mysql_fetch_array($objItemNumber))
				
				} //	if($plantillaNumRowsCheck<=0)					
				else
				{
					$objPersonnel = $this->db->select('DISTINCT(tblEmpPersonal.empNumber), tblEmpPersonal.surname,
							tblEmpPersonal.firstname,tblEmpPersonal.middlename, tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension,tblEmpPersonal.birthday,tblEmpPersonal.tin, tblEmpPersonal.sex,tblEmpPosition.positionCode, tblPosition.positionDesc,tblEmpPosition.salaryGradeNumber,tblEmpPosition.itemNumber,tblEmpPosition.authorizeSalary,tblEmpPosition.actualSalary,tblEmpPosition.positionDate, tblEmpPosition.appointmentCode,tblEmpPosition.firstDayAgency,tblEmpPosition.statusOfAppointment,tblEmpPosition.detailedfrom,tblPlantilla.level,tblPlantilla.areaCode,tblPlantilla.areaType')->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner')->join('tblPosition','tblEmpPosition.positionCode = tblPosition.positionCode','inner')->join('tblPlantilla','tblEmpPosition.itemNumber = tblPlantilla.itemNumber','left')->where('tblEmpPosition.statusOfAppointment','In-Service')->where('tblEmpPosition.plantillaGroupCode',$strGroupCode)->where("(tblEmpPosition.detailedfrom = '0' OR tblEmpPosition.detailedfrom = '2')")->get('tblEmpPersonal')->result_array();
					//echo $this->db->last_query();exit(1);
					// $objPersonnel = mysql_query("SELECT DISTINCT tblEmpPersonal.empNumber, tblEmpPersonal.surname,
					// 		tblEmpPersonal.firstname, tblEmpPersonal.middlename, 
					// 		tblEmpPersonal.middleInitial, tblEmpPersonal.nameExtension,  
					// 		tblEmpPersonal.birthday, tblEmpPersonal.tin, tblEmpPersonal.sex,
					// 		tblEmpPosition.positionCode, tblPosition.positionDesc,
					// 		tblEmpPosition.salaryGradeNumber, tblEmpPosition.itemNumber,
					// 		tblEmpPosition.authorizeSalary, tblEmpPosition.actualSalary,
					// 		tblEmpPosition.positionDate, tblEmpPosition.appointmentCode, 					
					// 		tblEmpPosition.firstDayAgency, 
					// 		tblEmpPosition.statusOfAppointment, 
					// 		tblEmpPosition.detailedfrom ,
					// 		tblPlantilla.level,tblPlantilla.areaCode,tblPlantilla.areaType
					// 		FROM tblEmpPersonal
					// 		INNER JOIN tblEmpPosition
					// 			ON tblEmpPersonal.empNumber = tblEmpPosition.empNumber
					// 		INNER JOIN tblPosition
					// 			ON tblEmpPosition.positionCode = tblPosition.positionCode
					// 		LEFT JOIN tblPlantilla
					// 			ON tblEmpPosition.uniqueItemNumber = tblPlantilla.itemNumber											
					// 		 WHERE tblEmpPosition.statusOfAppointment = 'In-Service' AND
					// 		  tblEmpPosition.plantillaGroupCode='$strGroupCode' 
					// 	  AND (tblEmpPosition.detailedfrom = '0' OR tblEmpPosition.detailedfrom = '2') 
					// 	 ");
											
												
					$empNumRows = count($objPersonnel);
				
					if($empNumRows>0)
					{
						//while($arrPersonnel = mysql_fetch_array($objPersonnel))
						$empNum='';
						foreach($objPersonnel as $arrPersonnel)
						{
						$strEmpNum = $arrPersonnel['empNumber'];
						$strMN =  $arrPersonnel['middlename'];
						$strMiddleName = substr($strMN, 0,1);
						$strName = $arrPersonnel['surname']. ", " .$arrPersonnel['firstname']. " ".$arrPersonnel['nameExtension']." ".
						$arrPersonnel['middleInitial'].".";
						
						$strSex = $arrPersonnel['sex'];
						$intTin = $arrPersonnel['tin'];
						$strBirthday = $arrPersonnel['birthday'];
						$strDivisionCode = $arrPersonnel['divisionCode'];
						$strPositionCode = $arrPersonnel['positionCode'];
						$strPositionDesc = $arrPersonnel['positionDesc'];
						$strDivisionDesc = $arrPersonnel['divisionName'];
						$strAppointmentStatus = $arrPersonnel['statusOfAppointment'];
						//$strItemNumber = $arrPersonnel['itemNumber'] ." Step " .$strstepNumber ;
						$strItemNumber = $arrPersonnel['itemNumber'] ;

						// Authorized salary is salary equivalent to step 1
						// $objAutSalary = mysql_query("SELECT actualSalary FROM tblSalarySched WHERE stepNumber=1 AND salaryGradeNumber='".$arrPersonnel['salaryGradeNumber']."'");
						$rowAutSalary = $this->getsalaryscheddetails($arrPersonnel['salaryGradeNumber']);
						//$rowAutSalary = mysql_fetch_array($objAutSalary);
						foreach($objAutSalary as $rowAutSalary)
							$strAuthorizeSalary = $rowAutSalary['actualSalary'];
						
						//$strAuthorizeSalary = $arrPersonnel['authorizeSalary'];
						$strActualSalary = $arrPersonnel['actualSalary'];
						$strStepNumber = $arrPersonnel['xstepNumber'];
						$strSalaryGradeNumber = $arrPersonnel['salaryGradeNumber'];
						$strAppointmentCode = $arrPersonnel['appointmentCode'];

						// Get date of current position date
						$objPosDate = $this->getcurrentservicefromdate($strEmpNum);
						// $objPosDate = mysql_query("SELECT serviceFromDate FROM tblServiceRecord  WHERE empNumber='".$strEmpNum."' ORDER BY serviceFromDate DESC");
						// $rowPosDate = mysql_fetch_array($objPosDate);
						//$strPositionDate = $rowPosDate['serviceFromDate'];

						$strFirstDayAgency = $arrPersonnel['firstDayAgency'];		
						$strPositionDate = $arrPersonnel['positionDate'];					
						if($strFirstDayAgency!=$strPositionDate) // if first day agency and position date is equal, dont show position date/last promotion
							$strPositionDate = $arrPersonnel['positionDate'];
						else	
							$strPositionDate = "";
							
						//$strAuthorizeSalary = $rowAutSalary['actualSalary'];

						
						//$strAuthorizeSalary = $rowAutSalary['actualSalary'];

						//$strExamCode = $arrPersonnel['examCode'];
						//$strExamDesc = $arrPersonnel['examDesc'];
						$strNature = $arrPersonnel['nature'];
						$strExamDesc = $arrPersonnel['examDesc'];
						
						// get latest cs eligibility
						$strExamType = $arrPersonnel['examType'];
						
						// get latest educ attainment
						$rowEducal = $this->getlatesteduc($strEmpNum);
						// $objEducal = mysql_query("SELECT tblCourse.courseCode FROM tblEmpSchool INNER JOIN tblCourse ON tblEmpSchool.course = tblCourse.courseDesc  WHERE empNumber='$strEmpNum' ORDER BY schoolToDate DESC");
						//$rowEducal = mysql_fetch_array($objEducal);
						if(count($rowEducal)>0)
							$strEducal = $rowEducal['courseCode'];
						// $objEducal = mysql_query("SELECT tblCourse.courseCode FROM tblEmpSchool INNER JOIN tblCourse ON tblEmpSchool.course = tblCourse.courseDesc  WHERE empNumber='$strEmpNum' ORDER BY schoolToDate DESC");
						// $rowEducal = mysql_fetch_array($objEducal);
						// $strEducal = $rowEducal['courseCode'];

						// get latest exam
						$objExam = $this->getlatestexam($strEmpNum);
						//$objExam = mysql_query("SELECT examCode FROM tblEmpExam WHERE empNumber='$strEmpNum'");											
						
						// $objExam = mysql_query("SELECT tblEmpExam.examCode, tblExamType.examDesc FROM tblEmpExam 
						// 						INNER JOIN tblExamType
						// 						ON tblEmpExam.examCode = tblExamType.examCode
						// 						WHERE tblEmpExam.empNumber='$strEmpNum' AND tblExamType.csElligible='Y'  ORDER BY tblEmpExam.examDate DESC");											
						
						$arrExamDesc = array();
						//while ($rowExam = mysql_fetch_array($objExam))
						foreach($objExam as $rowExam)
						{
							$strExam = $rowExam['examCode'];
							array_push($arrExamDesc, $strExam);	
						
						}
						
						$arrExamDesc = array_unique($arrExamDesc);
						$strExamDesc = implode(", ",$arrExamDesc);

						//$intPao = 0;	
						//while($rowExam = mysql_fetch_array($objExam)){
						
						//	$strExamDesc2[$intPao] = $rowExam['examCode'];
						//	$strExamDesc= $strExamDesc2[$intPao];
						//	$intPao ++;

						//}

						$strAreaCode = $arrPersonnel['areaCode'];
						$strAreaType = $arrPersonnel['areaType'];
						$strLevel = $arrPersonnel['level'];


						$strWorkNature = substr($strNature,0,1);

						
						if ($strAppointmentStatus == 'In-Service' && $strEmpNum!=$empNum)
							{
							$empNum=$arrPersonnel['empNumber'];
							$intCounter ++;
							$this->printBody($intCounter, $strName, $strSex, $strBirthday, $intTin, $strPositionDesc, "", number_format($strAuthorizeSalary,2), $strActualSalary, $strStepNumber, $strSalaryGradeNumber, $strAppointmentCode, $strPositionDate, $strFirstDayAgency, $strExamType, $strWorkNature, $strEducal, $strExamDesc, $strAreaCode, $strAreaType, $strLevel);
							
							}			
						}
					} 
				}//	if($plantillaNumRowsCheck<=0)
			//} // if($empNumRowsCheck>0)	
			

			
			

							
		} //while($arrDivision = mysql_fetch_array($objGroup))	 
		
		//$this->fpdf->Cell(5,4,' ',0,0,'C');				//  space
		$this->fpdf->Cell(339,4,'','LRT',0,'C');
		$this->fpdf->Ln(2);
		
		//$this->fpdf->Cell(5,4,' ',0,0,'C');				//  space				//  space
		$this->fpdf->Cell(339,4,'               I certify to the correctness of the entries from columns 6 to 17 and that employees','LR',0,'L');
		$this->fpdf->Ln(4);
		
		//$this->fpdf->Cell(5,4,' ',0,0,'C');				//  space
		$this->fpdf->Cell(339,4,'     whose names appear on the above plantilla are the incumbents of the positions.','LRB',0,'L');
		$this->fpdf->Ln(4);

		 // if($this->fpdf->GetY()>195)
			//  $this->fpdf->AddPage('L','Legal');
			 
		
			
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
	

	function printHeader()
	{
		//$col = 5;//space
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
		$col = array(35,55,17,17,5,7,5,5,20,50,5,17,20,18,18,5,20,20);
		$InterLigne = 4;

		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->Cell(0,2,'', 0, 0, 'C');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,0,getAgencyName(), 0, 0, 'C');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,2,'PLANTILLA OF PERSONNEL', 0, 0, 'C');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,2,'For the Year '.date('Y'), 0, 0, 'C');
		$this->fpdf->Ln(4);
		$this->fpdf->Cell(0,2,'(Pursuant to RA NO. 7916 as Amended by RA 8748)',0, 0, 'C');
		$this->fpdf->Ln(4);
		
		$this->intPageNo = $this->fpdf->PageNo();
		
		//$this->fpdf->Ln(4);
		$itemNumberCol = 41;
		$salCol = 17;
		$incumbentCol = 55;
		$this->fpdf->SetFont('Arial','B',8);
		//  first line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,' ','LT',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,' ','LT',0,'C');						//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2]+$col[3],$InterLigne,'ANNUAL SALARY','LTB',0,'C');	//  Annual Salary
		$this->fpdf->Cell($col[4],$InterLigne,' ','LTR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5]+$col[6],$InterLigne,'AREA','LTB',0,'C');			//  Area
		$this->fpdf->Cell($col[7],$InterLigne,' ','LT',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,' ','LT',0,'C');						//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','LT',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,' ','LTR',0,'C');					//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,' ','LTR',0,'C');					//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','LT',0,'C');						//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,'Date of','LT',0,'C');				//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,'Date of','LTR',0,'C');				//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,'S','LT',0,'C');						//  Status
		$this->fpdf->Cell($col[16],$InterLigne,' ','LT',0,'C');						//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,' ','LTR',0,'C');					//  Remarks
		$this->fpdf->Ln(4);

		//  second line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,' ','L',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,' ','L',0,'C');						//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,' ','L',0,'C');						//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,' ','L',0,'C');						//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'S','LR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'C','L',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'T','L',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,' ','L',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,' ','L',0,'C');						//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,'S','L',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,' ','L',0,'C');						//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','L',0,'C');						//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,'Original','L',0,'C');				//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,'Last','L',0,'C');					//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,'T','L',0,'C');						//  Status
		$this->fpdf->Cell($col[16],$InterLigne,'Civil','L',0,'C');					//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,' ','LR',0,'C');						//  Remarks
		$this->fpdf->Ln(4);
		
		//  third line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,' ','L',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,'POSITION TITLE','L',0,'C');			//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,' ','L',0,'C');						//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,' ','L',0,'C');						//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'T','LR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'O','L',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'Y','L',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,'L','L',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,'P/P/A','L',0,'C');					//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,'E','L',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,'DATE','L',0,'C');					//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','L',0,'C');						//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,'Appointment','L',0,'C');			//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,'Promotion','L',0,'C');				//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,'A','L',0,'C');						//  Status
		$this->fpdf->Cell($col[16],$InterLigne,'Service','L',0,'C');				//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,' ','LR',0,'C');						//  Remarks
		$this->fpdf->Ln(4);

		//  fourth line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,'ITEM NUMBER','L',0,'C');				//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,'and SALARY','L',0,'C');				//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,'Authorized','L',0,'C');				//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,'Actual','L',0,'C');					//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'E','LR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'D','L',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'P','L',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,'V','L',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,'Attribution','L',0,'C');				//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,'Name of Incumbent','L',0,'C');		//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,'X','L',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,'OF','L',0,'C');						//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,'TIN','L',0,'C');					//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,' ','L',0,'C');						//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,' ','L',0,'C');						//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,'T','L',0,'C');						//  Status
		$this->fpdf->Cell($col[16],$InterLigne,'Eligibility','L',0,'C');			//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,'Remarks','LR',0,'C');				//  Remarks
		$this->fpdf->Ln(4);
		
		//  fifth line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,' ','L',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,'GRADE','L',0,'C');					//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,' ','L',0,'C');						//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,' ','L',0,'C');						//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'P','LR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'E','L',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'E','L',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,'L','L',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,' ','L',0,'C');						//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,' ','L',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,'BIRTH','L',0,'C');					//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','L',0,'C');						//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,' ','L',0,'C');						//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,' ','L',0,'C');						//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,'U','L',0,'C');						//  Status
		$this->fpdf->Cell($col[16],$InterLigne,' ','L',0,'C');						//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,' ','LR',0,'C');						//  Remarks
		$this->fpdf->Ln(4);

		//  sixth line (sub-header)
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,' ','L',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,' ','L',0,'C');						//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,' ','L',0,'C');						//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,' ','L',0,'C');						//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,' ','LR',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,' ','L',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,' ','L',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,' ','L',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,' ','L',0,'C');						//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,' ','L',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,' ','L',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,' ','L',0,'C');						//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,' ','L',0,'C');						//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,' ','L',0,'C');				//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,' ','L',0,'C');					//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,'S','L',0,'C');						//  Status
		$this->fpdf->Cell($col[16],$InterLigne,' ','L',0,'C');					//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,' ','LR',0,'C');						//  Remarks
		$this->fpdf->Ln(4);
	
		//  seventh line (sub-header)
		$this->fpdf->SetFont('Arial','B',6);
		//$this->fpdf->Cell($col,$InterLigne,' ',0,'C');							//  space
		$this->fpdf->Cell($col[0],$InterLigne,'(1)','LB',0,'C');						//  Item NumberNew
		$this->fpdf->Cell($col[1],$InterLigne,'(2)','LB',0,'C');						//  Position Title and Salary Grade
		$this->fpdf->Cell($col[2],$InterLigne,'(3)','LB',0,'C');						//  Annual Salary Authorize
		$this->fpdf->Cell($col[3],$InterLigne,'(4)','LB',0,'C');						//  Annual Salary Actual
		$this->fpdf->Cell($col[4],$InterLigne,'(5)','LRB',0,'C');						//  Step 
		$this->fpdf->Cell($col[5],$InterLigne,'(6)','LB',0,'C');						//  Area Code
		$this->fpdf->Cell($col[6],$InterLigne,'(7)','LB',0,'C');						//  Area Type
		$this->fpdf->Cell($col[7],$InterLigne,'(8)','LB',0,'C');						//  LVL
		$this->fpdf->Cell($col[8],$InterLigne,'(9)','LB',0,'C');						//  P/P/A Attribution
		$this->fpdf->Cell($col[9],$InterLigne,'(10)','LB',0,'C');						//  Name of Incumbent
		$this->fpdf->Cell($col[10],$InterLigne,'(11)','LB',0,'C');						//  Sex
		$this->fpdf->Cell($col[11],$InterLigne,'(12)','LB',0,'C');						//  Date of Birth
		$this->fpdf->Cell($col[12],$InterLigne,'(13)','LB',0,'C');						//  TIN
		$this->fpdf->Cell($col[13],$InterLigne,'(14)','LB',0,'C');				//  Date of Original Appointment
		$this->fpdf->Cell($col[14],$InterLigne,'(15)','LB',0,'C');					//  Date of Last Promotion
		$this->fpdf->Cell($col[15],$InterLigne,'(16)','LB',0,'C');						//  Status
		$this->fpdf->Cell($col[16],$InterLigne,'(17)','LB',0,'C');					//  CS Eligibility
		$this->fpdf->Cell($col[17],$InterLigne,'(18)','LRB',0,'C');						//  Remarks
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
		$this->fpdf->Cell($col14,$InterLigne,'','L',0,'C');		//  Date of Last Appointment
		$this->fpdf->Cell($col15,$InterLigne,'','L',0,'C');		//  Date of Last Promotion
		$this->fpdf->Cell($col16,$InterLigne,'','LR',0,'C');	//  Status
		$this->fpdf->Cell($col17,$InterLigne,'','LR',0,'C');	//  Civil Service Eligibility
		$this->fpdf->Cell($col18,$InterLigne,'','LR',0,'C');	//  Remarks
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