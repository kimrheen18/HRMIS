<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bio_sync_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		$this->db->initialize();	
	}
	
	// --------------------------------Functions from SyncDB.php------------------------------------- //

	function getLatestData($empNum, $empDatefrom, $empDateto)
	{
		$this->db->select('*');
		$this->db->where('dtrDate >= ', $empDatefrom);
		$this->db->where('dtrDate <=', $empDateto);
		if(!empty($empNum))
			$this->db->where('empNumber', $empNum);

		$latestdata = $this->db->get('tblEmpDTR')->result_array();

		return $latestdata;
	}

	function getLatestHRDate()
	{
		// get latest date from mysql database
		$this->db->select('MAX(dtrDate) AS dtrDate');
		$myLatestDate = $this->db->get('tblEmpDTR')->result_array();
		if(!empty($myLatestDate[0])) {
			$myLatestDate = str_replace("-", "", $myLatestDate[0]);
			return $myLatestDate;
		}
		else {
			return FALSE;
		}
	}

	function lastUpdateTime($strDate) 
	{
		$fldsArray = array("inAM", "outAM", "inPM", "outPM", "inOT", "outOT");
		foreach($fldsArray as $fld){
			$this->db->select('MAX('.$fld.') AS dtrDate');
			$this->db->where('dtrDate', $strDate);
			$fldTime = $this->db->get('tblEmpDTR')->result_array();
			// $sql  = mysql_query("SELECT MAX($fld) FROM tblEmpDTR WHERE dtrDate=$strDate");
			// $fldTime = mysql_fetch_row($sql);
			$timesArray[$fld] = $fldTime[0];
		}
		// $lastTime = $this->formatTimeString($timesArray['inAM']); //getLatestTimes($timesArray);
		return $timesArray['inAM'];
	}



	// --------------------------------Functions from LoginDTR.php------------------------------------- //

	function logDTR($t_strEmpNmbr, $t_strPword, $t_strTime, $t_strDate, $t_blnSwipe=0, $sync=0)
	{
		// check if call DOESNT came from sync 
		if(!$sync){
			// if($t_blnSwipe == 0)
			// {
			// 	$t_strPword = mysql_real_escape_string($t_strPword);
			// 	$t_strEmpNmbr = mysql_real_escape_string($t_strEmpNmbr);
			// 	$strHashPword = md5($this->logDTRPassword($t_strPword));
			// 	$sql="SELECT * FROM tblEmpAccount WHERE empNumber='$t_strEmpNmbr' AND userPassword='$strHashPword'";
			// 	$objRecordset = mysql_query($sql);
				
			// 	if(!mysql_num_rows($objRecordset))   //username password is invalid
			// 	{
			// 		$blnPass = 0;
			// 		$this->addDTRLog($t_strEmpNmbr,$sql,'Invalid password. Please re-enter your Password.');
			// 		return "Invalid password. Please re-enter your Password.";
			// 	}
			// 	else
			// 	{
			// 		$blnPass = 1;
			// 	}
			// }
			// else
			// {
			// 	$objRecordset = mysql_query("SELECT * FROM tblEmpAccount WHERE empNumber='$t_strEmpNmbr'");
			// 	if(!mysql_num_rows($objRecordset))   //username password is invalid
			// 	{
			// 		$blnPass = 0;
			// 		$this->addDTRLog($t_strEmpNmbr,$sql,'Invalid barcode. Please swipe valid code.');
			// 		return "Invalid barcode. Please swipe valid code.";
			// 	}
			// 	else
			// 	{
			// 		$blnPass = 1;
			// 	}		
			// }
			return "Not sync.";
		}
		// call from sync (no need to check user accounts)
		else {
			$blnPass = 1;
		}
		
		if($blnPass)
		{
		    $arrSchema = $this->getSchema($t_strEmpNmbr);  //get the attendance scheme
		   	// print_r($arrSchema);exit(1);
			$objDate = $this->getDtrData($t_strEmpNmbr, $t_strDate);

			if(count($objDate) == 0)   //username password is invalid
			{
				$strDtrDate = ($sync)?$t_strDate:date("Y-m-d"); 
				//INSERT AM IN if biometrics time starts with am time
				//else PM IN if biometrics time starts with pm time
				$strDateTime = strstr($t_strTime,'A')?'inAM':'inPM';
				$isql="INSERT INTO tblEmpDTR (empNumber, $strDateTime, dtrDate) 
									VALUES (?,?,?)";
				//echo $isql."<br>";
				$this->db->query($isql, array($t_strEmpNmbr, substr($t_strTime, 0, -2), $strDtrDate));
				$lastqry = $this->db->last_query();
				
				$this->log_sync($t_strEmpNmbr,$t_strDate);			
				$strConfirm = $this->logDTRConfirm(1); 
				if(!$sync)
					$this->addDTRLog($t_strEmpNmbr,$lastqry,$strConfirm,$strDtrDate." ".substr($t_strTime, 0, -2));   //confirm function			
				return $strConfirm;
			}
			else
			{
				$i = 0;
				while($i < count($objDate))
				{
					$arrLog = array(1=>$objDate[$i]["inAM"], 2=>$objDate[$i]["outAM"], 3=>$objDate[$i]["inPM"], 
						4=>$objDate[$i]["outPM"], 5=>$objDate[$i]["inOT"], 6=>$objDate[$i]["outOT"]);
					$i++; 
				}



				//echo strtotime($t_strTime).' > '.strtotime($arrLog[3]);
				//print_r($arrLog);die();
				$strDateTime = strstr($t_strTime,'A')?'inAM':'inPM';

				//print_r($arrSchema);
				/*echo strtotime($t_strTime)."==".strtotime($arrLog[1])."<br>";
				//echo strtotime($t_strTime).">=".strtotime($arrSchema['nnTimeoutFrom'])
				."<Br>";*/
				//echo strtotime('12:00:00');
				//echo "=>".$strDateTime.' '.strtotime($t_strTime).' '.strtotime($arrSchema['nnTimeoutTo']).'<br>';
				if($strDateTime=='inAM' && strtotime($t_strTime)<strtotime($arrSchema['nnTimeoutFrom'])) return 'You have already logged in!';
				//if(strtotime($t_strTime)<strtotime())
				
				// if($strDateTime=='inAM' && strtotime($t_strTime)>=strtotime($arrSchema['nnTimeoutTo'])) 
				// 	return 'Noon time-out is from '.$arrSchema['nnTimeoutFrom'].' to '.$arrSchema['nnTimeoutTo'];
				// if($arrScheme['nnTimeinTo'])
				// if($strDateTime=='inPM' && strtotime($t_strTime)<=strtotime($arrSchema['nnTimeinFrom'])) 
				// 	return 'Noon time-in is from '.$arrSchema['nnTimeinFrom'].' to '.$arrSchema['nnTimeinTo'];
				//echo $dtrDateTime."||".$strDate."||".substr($t_strTime, 0, -2)."||"."<br>";
				//return false;
				//print_r($arrLog);
				//get vacant time column
				for($intCounter=1; $intCounter<=6; $intCounter++)
				{
					if (trim($arrLog[$intCounter]) != '00:00:00')
					{
						$intTimeColumn = $intCounter;
					}
				}
				++$intTimeColumn;


				//print_r($arrLog);
				//echo "<br>".$t_strTime.'<br>';
				//echo date('a',strtotime($t_strTime)).'<br>';
				if($intTimeColumn==2)
				{
					//echo $t_strTime .'<='. $arrSchema['nnTimeinTo'].'<br>';
					//if(substr($arrSchema['nnTimeinTo'],0,2)=='01')$t_nnTimeinTo='13:00';
					if(substr($t_strTime,0,2) == '12') 
						$intTimeColumn=2;
					else
					{
						if($arrLog[2]=='00:00:00' && $arrLog[3]=='00:00:00') $intTimeColumn=4;
					}
				} 


				
				//echo $intTimeColumn."<br>";
				/*
				if($intTimeColumn==2 && strtotime($t_strTime)>strtotime($arrSchema['nnTimeinFrom']))
					return 'Noon time-out is from '.$arrSchema['nnTimeoutFrom'].' to '.$arrSchema['nnTimeoutTo'];
				if($intTimeColumn==3 && strtotime($t_strTime)<strtotime($arrSchema['nnTimeinFrom']))
					return 'Noon time-in is from '.$arrSchema['nnTimeinFrom'].' to '.$arrSchema['nnTimeinTo'];
				*/

				$strTimeField = $this->logDTRGetFields($t_strEmpNmbr,$t_strDate,$intTimeColumn, $t_strTime, $arrSchema,$sync);
				
				$strErrMsg = $this->logDTRError($strTimeField, $t_strTime, $t_strPword, $arrSchema[0]["nnTimeinFrom"], $arrSchema[0]["nnTimeoutTo"], $arrSchema[0]["overtimeStarts"]);   //function logDTRError
				//echo $strTimeField;
				//die();

				if($strTimeField=='outPM') //check if outPM beyond out-in
				{
					// echo '<br>';
					// echo strtotime($t_strTime) .' < '. strtotime($arrLog[3]); 
					// echo '<br>';
					// echo $t_strTime .' < '. $arrLog[3]; 
					
					if(strtotime($t_strTime) < strtotime($arrLog[3])) $strErrMsg = 'Sorry, your out afternoon is not valid.';
					//echo $strErrMsg;
					//die();
				}
				//echo $strErrMsg;die();
				//inPM should be 30min after outAM
				/*
				if($strTimeField=="inPM")
				{
					$rs = mysql_query("SELECT outAM FROM tblEmpDTR WHERE empNumber='$t_strEmpNmbr' AND dtrDate='$t_strDate'");
					if(mysql_num_rows($rs)>0)
					{
						while($row=mysql_fetch_assoc($rs))
						{
							$strOutAM = $row['outAM'];
							//echo $t_strDate.' '.$strOutAM."<br>";
							//$newtimestamp = strtotime($t_strDate.' '.$strOuAM.' + 30 minute');
							//echo date('Y-m-d H:i:s', $newtimestamp);
							$newtimestamp = strtotime('+30 minutes', strtotime($t_strDate.' '.$strOutAM));
							$dtmInPM = date('H:i:s',$newtimestamp);
							// echo $t_strTime.'=>'.strtotime($t_strTime).'<br>';
							// echo $dtmInPM.'=>'.strtotime($dtmInPM);
							if(strtotime($t_strTime)<strtotime($dtmInPM))
							{
								$strMsg = "Invalid Entry! You can login after ".$dtmInPM;
								$this->addDTRLog($t_strEmpNmbr,'',$strMsg);
								return $strMsg;
							}
							//echo "=>".$strOutAM;
							//exit(1);
						}

					}

				}
				*/
				//echo "=>".$strTimeField; exit(1);
				
				//echo "strTimeField=>".$strTimeField."<bR>";
				if ($strErrMsg)
				{
					$this->addDTRLog($t_strEmpNmbr,'',$strErrMsg,$t_strDate." ".substr($t_strTime, 0, -2));	
					return $strErrMsg;
				}
				elseif (substr($t_strPword, -1) != '*' && $strTimeField && $strTimeField!='inOT' && $strTimeField!='outOT') //&& substr($t_strTime, 0, 2) == '12') //-->hack0827 
				// && $strTimeField!='inOT'
				{  
					$usql="UPDATE tblEmpDTR SET $strTimeField = ? WHERE empNumber=? AND dtrDate=?";
					//echo $usql."<br>";exit(1);
					$this->db->query($usql, array(substr(trim($t_strTime), 0, -2), $t_strEmpNmbr, $t_strDate));

					
					$strConfirm = $this->logDTRConfirm($intTimeColumn); //confirm function
					if(!$sync)	
						$this->addDTRLog($t_strEmpNmbr,$usql,$strConfirm,$t_strDate." ".substr($t_strTime, 0, -2));		
					return $strConfirm;
				}
				//call to matic in-out in manual DTR
				elseif ($strTimeField == 'outAM' && substr($t_strPword, -1) == '*'  && strstr($t_strTime,'P'))//&& substr($t_strTime, 0, 2) == '12'
				{
				 //++$intTimeColumn;
					//return "Sorry! Asterisk (*) cannot be used as there must be 30 minutes interval for noon OUT-IN";//added 5/30/2019
					$intTimeColumn+=1;
				 	$strTimeField2 = $this->logDTRGetFields($t_strEmpNmbr,$strDtrDate, $intTimeColumn, $t_strTime, $arrSchema);

				 	$usql="UPDATE tblEmpDTR SET $strTimeField = ?, $strTimeField2 = ? WHERE empNumber=? AND dtrDate=?";
					//echo $usql."<br>";exit(1);
					$this->db->query($usql, array(substr(trim($t_strTime), 0, -2), substr(trim($t_strTime), 0, -2), $t_strEmpNmbr, $t_strDate));

				 	$strConfirm = $this->logDTRConfirm("OUT-IN");
				 	if(!$sync)
				 		$this->addDTRLog($t_strEmpNmbr,$usql,$strConfirm,$t_strDate." ".substr($t_strTime, 0, -2));
				 	return $strConfirm;
				}
				//end call to matic in-out in manual DTR
			}			
		}
	}

	function getSchema($t_strEmpNmbr)
	{
		$this->db->select('tblAttendanceScheme.nnTimeoutFrom, 
			tblAttendanceScheme.nnTimeoutTo, 
			tblAttendanceScheme.nnTimeinFrom, 
			tblAttendanceScheme.nnTimeinTo, 
			tblAttendanceScheme.overtimeStarts');
		$this->db->where('schemeCode', 'GEN');
		// $this->db->join('tblEmpPosition', 'tblAttendanceScheme.schemeCode = tblEmpPosition.schemeCode');

		$arrSchema = $this->db->get('tblAttendanceScheme')->result_array();
		// print_r($arrSchema);
		// exit(1);
		return $arrSchema;
	}

	function getDtrData($t_strEmpNmbr, $t_strDate)
	{
		$this->db->select('*');
		$this->db->where('empNumber', $t_strEmpNmbr);
		$this->db->where('dtrDate', $t_strDate);
		$arrDtrData = $this->db->get('tblEmpDTR')->result_array();
		
		return $arrDtrData;
	}

	function logDTRGetFields($t_strEmpNmbr,$t_strDate,$t_intTimeColumn, $t_strTime, $arrSchema, $sync='')
	{ 
		$nnTimeoutFrom = strtotime($this->combineTime($arrSchema[0]["nnTimeoutFrom"],PM));
		$nnTimeoutTo = strtotime($this->combineTime($arrSchema[0]["nnTimeoutTo"],PM));		
		$nnTimeinFrom = strtotime($this->combineTime($arrSchema[0]["nnTimeinFrom"],PM));				
		$nnTimeinTo = strtotime($this->combineTime($arrSchema[0]["nnTimeinTo"],PM));

		$t_dtmSchmOutTo = $arrSchema[0]["nnTimeoutTo"];
		$intTime = strtotime($t_strTime);  //the time
		$t_dtmSchmOutTo = $this->combineTime($t_dtmSchmOutTo, PM);
		$intSchmOut = strtotime($t_dtmSchmOutTo); //the nnTimeoutTo

		//this statement only applies if attendance scheme is not from 11 to 12
	    //$t_intTimeColumn = ($t_intTimeColumn == 2 && (($intSchmOut < $intTime) && $t_dtmSchmOutTo!='1:00:00 PM'))?4:$t_intTimeColumn;
		//echo 'logDTRGetFields=>intTimeColumn='.$t_intTimeColumn."<br>";
		//if()
		if($t_intTimeColumn == 2){
		  $t_intTimeColumn = $this->checkDupTime($t_strEmpNmbr,$t_strDate,$t_strTime,'inAM')?0:2;
		 // echo date('H:i:s',$intTime).' >= '.date('H:i:s',$nnTimeoutFrom).' && '.date('H:i:s',$intTime).' <= '.date('H:i:s',$nnTimeoutTo).'<br>';
		  //if not dup compare against IN/OUT scheme if FALSE put in outPM 
		  //$t_intTimeColumn = $t_intTimeColumn == 2 & ($intTime >=$nnTimeoutFrom && $intTime<=$nnTimeoutTo)?2:4;	
		}
		else if($t_intTimeColumn == 3){
			//echo date('H:i:s',$intTime).">=".date('H:i:s',$nnTimeinFrom)."&&".date('H:i:s',$intTime)."<=".date('H:i:s',$nnTimeinTo)."<Br>";
		  $t_intTimeColumn = $intTime >= $nnTimeinFrom && $intTime<=$nnTimeinTo?3:4;	
		}
		
		else if($t_intTimeColumn == 4 ){
		    $t_intTimeColumn = $this->checkDupTime($t_strEmpNmbr,$t_strDate,$t_strTime,'inPM')?0:4;
			//$t_intTimeColumn = $intTime >$nnTimeinTo?$t_intTimeColumn:0;
		}
		//echo "=>".$t_intTimeColumn."<Br>";
		switch($t_intTimeColumn)
		{
			case 1: return "inAM";
			case 2: return "outAM";
			case 3:	return "inPM";
			case 4: return "outPM";
			case 5: return "inOT";
			case 6: return "outOT";
			case 0: return "";
		}
	}

	function checkDupTime($t_strEmpNmbr,$t_strDate,$t_strTime,$t_strDateTime)
	{
		$arrTime = explode(':',$t_strTime);
		$sql = "SELECT * FROM tblEmpDTR WHERE empNumber= ? AND dtrDate= ? AND $t_strDateTime LIKE ?";

		$rs = $this->db->query($sql, array($t_strEmpNmbr, $t_strDate, $arrTime[0].":".$arrTime[1]."%"));
		$result = $rs->result_array();
		// OR outAM='".$t_strTime."' 
		// OR inPM='".$t_strTime."' OR outPM='".$t_strTime."' 
		// OR inOT='".$t_strTime."' OR outOT='".$t_strTime."')";
		//echo $sql.'<br>';				

		return(count($result)>0);
	}

	function logDTRError($t_strTimeField, $t_strTime, $t_strPword, $t_dtmSchmInFrom, $t_dtmSchmOutTo, $t_dtmOvrtmStrt)
	{
		$intTime = strtotime($t_strTime);



		$t_dtmSchmInFrom = $this->combineTime($t_dtmSchmInFrom, PM);	
		$intSchmInFrom = strtotime($t_dtmSchmInFrom);

		$t_dtmSchmOutTo = $this->combineTime($t_dtmSchmOutTo, PM);
		$intSchmOutTo = strtotime($t_dtmSchmOutTo);

		if($t_dtmOvrtmStrt != NULLTIME)
		{
			$t_dtmOvrtmStrt = $this->combineTime($t_dtmOvrtmStrt, PM);
			$intOvrtm = strtotime($t_dtmOvrtmStrt);
		}
		//echo "<br>=>".$intSchmInFrom.">".$intTime;		
		if (substr($t_strPword, -1) != '*' && $t_strTimeField == 'inPM' && ($intSchmOutTo <= $intTime && $intSchmInFrom >= $intTime))//&& $intSchmInFrom > $intTime
		{   //if inPM time is morning no afternoon in...
			return "Afternoon IN starts at ".$t_dtmSchmInFrom." onwards !!!";
		}
		elseif(substr($t_strPword, -1) != '*' && $t_strTimeField == 'inOT' && $t_dtmOvrtmStrt != NULLTIME)
		{
			if ($intOvrtm > $intTime)
			{	//if inOT time is less than 6 eg: 1 pm and morning... no OT			
				return "Overtime starts at ".$t_dtmOvrtmStrt." onwards !!!";
			}
		}
		elseif( $t_strTimeField != 'outAM' && $t_strTimeField != 'inPM' && substr($t_strPword, -1) == '*') 
		{   //if the field is not outAm the OUT_IN is invalid
			return "We're sorry, your OUT-IN is NOT valid !!!";
		}
		elseif($t_strTimeField == 'outAM' && substr($t_strPword, -1) == '*' && ($intSchmInFrom > $intTime || $intSchmOutTo < $intTime))
		{   //out-in in afternoon
			return "Please OUT-IN from ".$t_dtmSchmInFrom." to ".$t_dtmSchmOutTo." !!!";
		}
		elseif($t_strTimeField == 'outOT')
		{
			return "Already Logged OUT!!!";
		}
		else
		{
			return NULL;
		}	
	}

	function addDTRLog($empNumber,$sql,$notify="",$strDate="")
	{
		$qry='INSERT INTO tblEmpDTR_log(empNumber,log_date,log_sql,log_notify,log_ip) VALUES(?,?,?,?,?)';

		$this->db->query($qry, array($empNumber, $strDate!=''?$strDate:date('Y-m-d H:i:s'), $sql, $notify.'', $this->getClientIP()));

		// print_r($this->db->last_query());  
		// exit(1);
	}

	function logDTRConfirm($t_intTimeColumn)
	{
		if($t_intTimeColumn == 'OUT-IN')   // OUT-IN confirmation
		{
			return "You have successfully Logged OUT-IN !!!";
		}
		elseif($t_intTimeColumn%2)   //if 0 then its even, if not zero, their is remainder its odd
		{   //if odd goes here
			return "You have successfully Logged-IN !!!";
		}
		else
		{   //if even
			return "You have successfully Logged-OUT !!!";
		}
	}

	function log_sync($emp_no,$dtr_date)
	{
		// $syncor = ($_SESSION['strLoginName']!='')?$_SESSION['strLoginName']:"Auto Sync";
		$update="UPDATE tblEmpDTR SET name=?, 
									  ip=?, 
									  editdate=NOW()
					 WHERE empNumber=? AND dtrDate=?";
		$this->db->query($update, array("Auto Sync",$_SERVER['REMOTE_ADDR'],$emp_no,$dtr_date));
	}

	function combineTime($t_dtmSchmInFrom, $time)
	{
		return $t_dtmSchmInFrom. ' '.$time;
	}

	function getClientIP()
	{
		return $this->input->ip_address();
	}




}
