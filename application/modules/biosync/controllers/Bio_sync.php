<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bio_sync extends MY_Controller 
{
	function __construct() 
	{
        parent::__construct();
  		$this->load->model(array('Bio_sync_model'));
    }
    
	public function index()
	{
		$arrPost = $this->input->post();
		
		if(!empty($arrPost)):
			$index=0;
			$insertCount = 0;

			$empNum = $arrPost['txtEmpID']; 
			$empDatefrom = $arrPost['txtSyncRecordDatefrom'];
			$empDateto = $arrPost['txtSyncRecordDateto'];		
			$device = $arrPost['devicename'];
			$device_name = array('VIRDIAC6000','VIRDIAC4000','FINGERTRAKFP305','ANVIZ','ZKTeco');
		
			// $empNum = ''; 
			// $empDatefrom = '20200525';
			// $empDateto = '20200531';
			// $device = 'VIRDIAC4000';
			// $device_name = array('VIRDIAC6000','VIRDIAC4000','FINGERTRAKFP305','ANVIZ','ZKTeco');

			if(empty($empDateto) || empty($empDatefrom))
			{
				$empDatefrom = date('Ymd');
				$empDateto = date('Ymd');
			}
			
	 		$someArray = $this->get_mdbdata($device,$device_name,$empDatefrom,$empDateto,$empNum);
	 	
	        if(!array_key_exists("error",$someArray[0]))
	        {
	        	if(!empty($someArray))
				{	$latestData = $this->Bio_sync_model->getLatestData($empNum,$this->formatStringDate($empDatefrom),$this->formatStringDate($empDateto));

					$n = 0;
					while($n < count($latestData))
					{
						$latestTime = $this->getLatestTimes($latestData[$n]);
						$latestIDTimes[$latestData[$n]['empNumber']][$index] = array('date' => $latestData[$n]['dtrDate'], 'time' => $latestTime);
						$n++;
					}	

					$i = 0;
					while($i < count($someArray))
					{
						$empID = $someArray[$i]['empnum'];
						$empTime = $someArray[$i]['dtrTime'];	
						$empDate = $someArray[$i]['dtrDate'];

						

						// check if there's an existing record for this id
						if(isset($latestIDTimes[$empID][$i]))
						{
							do
							{
								
								if($latestIDTimes[$empID][$i]['date']==$this->formatStringDate($empDate))
								{

									
									
									if($empTime > $latestIDTimes[$empID][$i]['time']) //compares biometrics time to dtr time
									{ 

										$empDate = $this->formatStringDate($empDate);
										$empTime = $this->formatStringTime($empTime);
										
										

										$strLogMsg = $this->Bio_sync_model->logDTR($empID, "", $empTime, $empDate, 0, 1); 
									}
									else 
										$strLogMsg='';
								} 
								$i++; 
							}
							while($i<=sizeof($latestIDTimes[$empID]));
						}
						else
						{ 
							$empDate = $this->formatStringDate($empDate);
							$empTime = $this->formatStringTime($empTime);

							// $strLogMsg = "logdtr2";
							$strLogMsg = $this->Bio_sync_model->logDTR($empID, "", $empTime, $empDate, 0, 1);


							$i++; 
						}

						if($strLogMsg)
						{
							$insertCount++;
							$logMsg .= "<tr><td>".$empID."</td><td>".$empDate."</td><td>".$empTime."</td><td>".$strLogMsg."</td></tr>";
						} 	
					}

					$logMsg .= "</table>";

					// get latest date after updating
					$afterDate = $this->Bio_sync_model->getLatestHRDate();
					$latestDateHR = date('D, F d Y', strtotime($afterDate['dtrDate']));
					$lastTime = $this->formatStringTime($this->formatTimeString($this->Bio_sync_model->lastUpdateTime($afterDate['dtrDate'])['dtrDate']));
					
					$logMsg = ["strSuccessMsg",$insertCount ."|".$logMsg."|".$latestDateHR."|".$lastTime];
				}
				else
					$logMsg = ["strErrorMsg","Please fill up Device."];
	        }
	        else
	        	$logMsg = ["strErrorMsg","Unable to connect to Fingertrack database. Contact your system administrator"];
	        	

	        	
			
			$this->session->set_flashdata($logMsg[0], $logMsg[1]);
			redirect('biosync');
		endif;

		$this->session->set_flashdata('warning','Please fill up dates and device.');
		$this->load->view('default_view');
	}

	public function get_mdbdata($device,$device_name,$empDatefrom,$empDateto,$empNum)
	{
		$accessQuery = $this->getQueryfromDevice($device,$device_name,$empDatefrom,$empDateto,$empNum);
		$command = escapeshellcmd('python py/retrieve.py ' .str_replace(' ', '|', $accessQuery). ' ' .$device);
        $output = shell_exec($command);
        $jsonData = str_replace("'", '"', $output);
        $someArray = json_decode($jsonData, true);

        return $someArray;

        // foreach ($someArray as $key => $v) {
        	// echo date('H:i:s',strtotime($someArray[$key]["C_Time"])).'<br>'; 
        	// print_r();
        	// echo $someArray[$key]["C_Time"];
        // }
        // if (!array_key_exists("msg",$someArray[0]))
        // 	print_r($someArray[0]);
	}

	public function filter_dtr()
	{
		$empNum = $_GET['emp'];
		$empDatefrom = $_GET['dtfrom'];
		$empDateto = $_GET['dtto'];
		$device = $_GET['device'];
		$device_name = array('VIRDIAC6000','VIRDIAC4000','FINGERTRAKFP305','ANVIZ','ZKTeco');
		
		// $empNum = ''; 
		// $empDatefrom = '20200525'; 
		// $empDateto = '20200531'; 
		// $device = 'VIRDIAC4000';
		// $device_name = array('VIRDIAC6000','VIRDIAC4000','FINGERTRAKFP305','ANVIZ','ZKTeco');

		if(empty($empDateto) || empty($empDatefrom))
		{
			$empDatefrom = date('Ymd');
			$empDateto = date('Ymd');
		}
		
 		$someArray = $this->get_mdbdata($device,$device_name,$empDatefrom,$empDateto,$empNum);

 		if(!array_key_exists("error",$someArray[0]) && !empty($someArray))
 		{
 			echo json_encode($someArray);
 		}
 		else
 		{
 			echo json_encode(array('empnum' => "", 'dtrDate' => "", 'dtrTime' => ""));
 		}
	}

	function getQueryfromDevice($fp_version,$fpscanner,$empDatefrom,$empDateto,$empNum)
	{
		switch($fp_version)
		{
			case $fpscanner[0]: 
			case $fpscanner[1]: $fpdata['tenterID'] = 'L_UID';
			$fpdata['CardID']   = 'L_ID';
			$fpdata['fpDate']	  = 'C_Date';
			$fpdata['fpTime']	  = 'C_Time';
			$fpdata['fpCnum']   = 'C_Unique';
			$fpdata['tblTenter']= 'tEnter';
			$fpdata['tblCard']  = 'tUser';
			$andEmpNum=!empty($empNum)?" AND ".$fpdata['tblTenter'].".".$fpdata['fpCnum']." = '".$empNum."'":" AND ".$fpdata['tblCard'].".".$fpdata['fpCnum']." <> ''";
			$orderBy=" ORDER BY ".$fpdata['fpDate']." asc, ".$fpdata['fpTime']." asc";						  
			break;
			case $fpscanner[2]: $andEmpNum=!empty($empNum)?" AND USERINFO.Badgenumber = '".$empNum."'":" AND USERINFO.Badgenumber <> ''";
			$orderBy=" ORDER BY Format(CHECKINOUT.CHECKTIME,'yyyymmdd') asc, Format(CHECKINOUT.CHECKTIME,'hhmmss') asc";						  
			return "SELECT Format(CHECKINOUT.CHECKTIME,'yyyymmdd') AS dtrDate, Format(CHECKINOUT.CHECKTIME,'hhmmss') AS dtrTime, USERINFO.Badgenumber as empnum FROM CHECKINOUT,USERINFO WHERE USERINFO.USERID=CHECKINOUT.USERID AND Format(CHECKINOUT.CHECKTIME,'yyyymmdd') between '$empDatefrom' AND '$empDateto'".$andEmpNum.$orderBy;

			case $fpscanner[3]: $andEmpNum=!empty($empNum)?" AND USERINFO.IDCard = '".$empNum."'":" AND USERINFO.IDCard <> ''";
			$orderBy=" ORDER BY Format(CHECKINOUT.CHECKTIME,'yyyymmdd') asc, Format(CHECKINOUT.CHECKTIME,'hhmmss') asc";						  
			return "SELECT Format(CHECKINOUT.CHECKTIME,'yyyymmdd') AS dtrDate, Format(CHECKINOUT.CHECKTIME,'hhmmss') AS dtrTime, USERINFO.IDCard as empnum FROM CHECKINOUT,USERINFO WHERE USERINFO.USERID=CHECKINOUT.USERID AND Format(CHECKINOUT.CHECKTIME,'yyyymmdd') between '$empDatefrom' AND '$empDateto'".$andEmpNum.$orderBy;
			case $fpscanner[4]: $andEmpNum=!empty($empNum)?" AND USERINFO.identitycard = '".$empNum."'":" AND USERINFO.identitycard <> ''";
			$orderBy=" ORDER BY Format(CHECKINOUT.CHECKTIME,'yyyymmdd') asc, Format(CHECKINOUT.CHECKTIME,'hhmmss') asc";						  
			return "SELECT Format(CHECKINOUT.CHECKTIME,'yyyymmdd') AS dtrDate, Format(CHECKINOUT.CHECKTIME,'hhmmss') AS dtrTime, USERINFO.identitycard as empnum FROM CHECKINOUT,USERINFO WHERE USERINFO.USERID=CHECKINOUT.USERID AND Format(CHECKINOUT.CHECKTIME,'yyyymmdd') between '$empDatefrom' AND '$empDateto'".$andEmpNum.$orderBy; 					  

		}

		return "SELECT ".$fpdata['tblTenter'].".".$fpdata['fpDate']." as dtrDate, "
		.$fpdata['tblTenter'].".".$fpdata['fpTime']." as dtrTime, right("
		.$fpdata['tblCard'].".".$fpdata['fpCnum'].",18) as empnum FROM "
		.$fpdata['tblTenter'].", ".$fpdata['tblCard'].
		" WHERE ".$fpdata['tblTenter'].".".$fpdata['tenterID']."=".$fpdata['tblCard'].".".$fpdata['CardID'].
		" AND ".$fpdata['fpDate']." between '".$empDatefrom."' AND '".$empDateto."' ".$andEmpNum.$orderBy;
	}

	function formatStringTime($inTime) 
	{
		$ampm = 'AM';
		
		$hour = substr($inTime, 0,2);
		$minute = substr($inTime, 2,2);
		$second = substr($inTime, 4,2);
		
		if($hour>=12) {
		  // subtract 12 only if it's greater than 12
		  if($hour>12)
		  	$hour = $hour - 12;
		  
		  $ampm = 'PM';
		} else
		  $ampm = 'AM';
		
		return "$hour:$minute:$second $ampm";
	}
	
	function formatStringDate($strDate) 
	{
		$year = substr($strDate, 0, 4);
		$month = substr($strDate, 4, 2);
		$day = substr($strDate, 6, 2);
		
		return "$year-$month-$day";
	}

	function getLatestTimes($latestData) 
	{
		// compare time values to get latest
		$latestTime = $this->formatTimeString($latestData['inAM']);
		if($this->formatTimeString($latestData['outAM']) > $latestTime)
			$latestTime = $this->formatTimeString($latestData['outAM']);
		if($this->formatTimeString($latestData['inPM'],1) > $latestTime)
			$latestTime = $this->formatTimeString($latestData['inPM'],1);
		if($this->formatTimeString($latestData['outPM'],1) > $latestTime)
			$latestTime = $this->formatTimeString($latestData['outPM'],1);
		if($this->formatTimeString($latestData['inOT'],1) > $latestTime)
			$latestTime = $this->formatTimeString($latestData['inOT'],1);
		if($this->formatTimeString($latestData['outOT'],1) > $latestTime)
			$latestTime = $this->formatTimeString($latestData['outOT'],1);
		
		return $latestTime;
	}

	function formatTimeString($strTime, $isPM=0) 
	{
		$hds = explode(":", $strTime);

		$hour = $hds[0];
		$minute = $hds[1];
		$second = $hds[2];
		
		if($isPM && $hour < 12){
			$hour += 12;
		} 
		return "$hour$minute$second";
	}
   
}
