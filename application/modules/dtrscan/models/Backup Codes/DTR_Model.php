<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class DTR_Model extends MY_Controller 
{
    protected $date, $time, $table, $position, $emp_code, $sched, $table_emp;
    protected $inAm_from, $inAm_to, $outBreak_from, $outBreak_to, $inBreak_from, $inBreak_to, $outPm_from, $outPm_to; 

    public function __construct()
	{
        $this->load->helper('url'); 
        $this->load->database();

        date_default_timezone_set('Asia/Manila');
        $this->date = date("Y-m-d");
        $this->time = date("H:i:s");
        $this->table = "tblEmpQRScan";
        $this->table_emp = "tblEmpAccount";
        $this->position = "tblEmpPosition";
        $this->attendscheme = "tblAttendanceScheme";
        //$this->time = "8:00 AM"; 
    }

    // returns true when the date is monday
    public function isMonday(){
        return date("l") == "Monday";
    }

    // Get Emp Attendance Scheme
    public function getEmpAttendanceScheme($emp){
        $this->db->where('empNumber', $emp);
        $query = $this->db->get($this->position);
        $row = $query->row_array();
        return $row['schemeCode'];
    }

    // Get the time from Attendance Scheme  
    public function getTimeAttendance($emp, $col){
        $this->db->where('schemeCode', $this->getEmpAttendanceScheme($emp));
        $query = $this->db->get($this->attendscheme);
        $row = $query->row_array();
        return $row[$col];
    }

    // Get the Scheme Type of the Code
    public function getSchemeType($emp){
        $this->db->where('schemeCode', $this->getEmpAttendanceScheme($emp));
        $query = $this->db->get($this->attendscheme);
        $row = $query->row_array();
        return $row["schemeType"];
    }

    // Returns true if the column is null
    public function checkIfNull($emp, $col){
        $this->db->where(array(
            'empNumber'=> $emp,
            'dtrDate' => $this->date,
            $col => NULL,
        ));
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    // Get Late Minutes
    public function getLate($emp) {
        $this->db->where('empNumber', $emp);
        $this->db->where('dtrDate', $this->date);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return $row['late'];
    } 

    // Get Under Time Minutes
    public function getUnderTime($emp) {
        $this->db->where('empNumber', $emp);
        $this->db->where('dtrDate', $this->date);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return $row['underTime'];
    } 

    // Check If the user has already data within that date
    public function checkExistData($emp)
    {
        $this->db->where('empNumber',$emp);
        $this->db->where('dtrDate',$this->date);
        $query = $this->db->get($this->table);
        return !$query->num_rows() > 0;
    }

    // Check if the user qr exist 
    // Returns true when the user exist
    public function qrCheckExist($emp){
        $this->db->where('empNumber',$emp);
        $query = $this->db->get($this->table_emp);
        return $query->num_rows() > 0;
    }

    // Save Input from Contoller to Database
    public function save($emp)
    {
       $data = array(
            'empNumber' => $emp,
            'dtrDate' => $this->date,
        );

        $this->db->insert($this->table, $data);
    }

    // Method that calculate late in minutes 
    public function calculateLate($deadtime, $in) {
        $deadtime = date("g:i", strtotime($deadtime));
        $in = date("g:i", strtotime($in));
        return round(abs(strtotime($in) - strtotime($deadtime)) / 60);
    }

    // Method that calculates underTime in minutes
    public function calculateUnderTime($endtime, $currentTime){
        $endtime = date("g:i", strtotime($endtime));
        $currentTime = date("g:i", strtotime($currentTime));
        return round(abs(strtotime($endtime) - strtotime($currentTime)) / 60);
    }

     // Return the status when scanning (Time In or Out, Break In or Out or Overtime In or Out)
    public function returnStatus() {
        return $this->sched == null ? "" : $this->sched;
    }

    // Updates Time for Sliding
    public function updateTimeSliding($emp){
        $this->inAm_from = $this->getTimeAttendance($emp, 'amTimeinFrom');
        $this->inAm_to = $this->getTimeAttendance($emp, 'amTimeinTo');
        $this->outBreak_from = $this->getTimeAttendance($emp, 'nnTimeoutFrom');
        $this->outBreak_to = $this->getTimeAttendance($emp, 'nnTimeoutTo');
        $this->inBreak_from = $this->getTimeAttendance($emp, 'nnTimeinFrom'); 
        $this->inBreak_to = $this->getTimeAttendance($emp, 'nnTimeinTo');
        $this->outPm_from = $this->getTimeAttendance($emp, 'pmTimeoutFrom');
        $this->outPm_to = $this->getTimeAttendance($emp, 'pmTimeoutTo');

        $this->db->update($this->table, $this->timeDataSliding($emp), 
            array(
                'empNumber'=> $emp,
                'dtrDate' => $this->date
            )
        );
    }

    // Updates Time for Fixed
    public function updateTimeFix($emp, $start, $end){
        $this->inAm_from = $this->getTimeAttendance($emp, 'amTimeinFrom');
        $this->outBreak_from = $this->getTimeAttendance($emp, 'nnTimeoutFrom');
        $this->outBreak_to = $this->getTimeAttendance($emp, 'nnTimeoutTo');
        $this->inBreak_from = $this->getTimeAttendance($emp, 'nnTimeinFrom'); 
        $this->inBreak_to = $this->getTimeAttendance($emp, 'nnTimeinTo');
        $this->outPm_to = $this->getTimeAttendance($emp, 'pmTimeoutTo');

        $this->db->update($this->table, $this->timeDataFix($emp, $start, $end),
            array(
                'empNumber'=> $emp,
                'dtrDate' => $this->date
            )
        );
    }

    // Returns data of what time is being updated (Fix)
    public function timeDataFix($emp, $start, $end){

        // Fixes Time In
        $inAm_start = is_null($start) ? $this->inAm_from : $start; 

        // Time-Out From (noon)
        $outBreak_start = $this->outBreak_from; 

        // Time-Out To (noon)
        $outBreak_end = $this->outBreak_to; 

        // Time-In From (noon)
        $inBreak_start = $this->inBreak_from; 

        // Time-In To (noon)
        $inBreak_end = $this->inBreak_to; 

        // Time Out
        $outPM_end = is_null($end) ? $this->outPm_to : $end; 
        
        $data = array();
        $now = $this->time;

        /*
         * Here are the conditions for Fixed
         */

        // Time In
        // 12:00 AM until the fixed time in
        if(strtotime($now) <= strtotime($inAm_start)) {

            // If the user didnt time in yet at Morning
            if($this->checkIfNull($emp, "inAM")){
                $data = array( 'inAM' => $now);
                $this->sched = "Time In Success";
            } else {
                $this->sched = "Already Time In";
            }
            
        }

        // Late Morning
        // Between fixed time in and break out
        elseif(strtotime($inAm_start) < strtotime($now) and strtotime($now) < strtotime($outBreak_start)) {

            // If the user didnt time in yet at Morning
            if($this->checkIfNull($emp, "inAM")){
                $data = array( 
                    'inAM' => $now,
                    'late' => $this->getLate($emp) + $this->calculateLate($inAm_start, $now)
                );
                $this->sched = "Time In Late for " + $this->calculateLate($inAm_start, $now) + " minute/s";
            } else {
                $this->sched = "Already Time In";
            }

        }

        // Break Out 
        elseif(strtotime($now) <= strtotime($outBreak_end) and strtotime($outBreak_start) <= strtotime($now)){

            // If the user didnt time in in morning and didnt break out yet
            if($this->checkIfNull($emp, "inAM") and $this->checkIfNull($emp, "outBreak")){
                $data = array( 
                    'inBreak' => $now,
                    'late' => $this->getLate($emp) + $this->calculateLate($inAm_start, $now)
                );
                $this->sched = "Break In Success";
            }
            // If the user didnt break out yet 
            else if($this->checkIfNull($emp, "outBreak")){
                $data = array( 
                    'outBreak' => $now,
                    'underTime' => $this->calculateUnderTime($outBreak_end, $now)
                );
                $this->sched = "Break Out Success";
            } else {

                // If the user scans again around break out, she/he wanted to break in
                $data = array( 'inBreak' => $now);
                $this->sched = "Break In Success";

            }
            
        }

        // Break In
        elseif(strtotime($now) <= strtotime($inBreak_end) and strtotime($inBreak_start) <= strtotime($now)){

            // If the user didnt break in yet
            if($this->checkIfNull($emp, "inBreak")){
                $data = array( 'inBreak' => $now);
                $this->sched = "Break In Success";
            } else {
                $this->sched = "Already Break In";
            }
            
        }

        // Late Break In
        elseif(strtotime($now) < strtotime($outPM_end) and strtotime($inBreak_end) < strtotime($now)){

            // If the user didnt break in yet
            if($this->checkIfNull($emp, "inBreak")){
                $data = array( 
                    'inBreak' => $now,
                    'late' => $this->getLate($emp) + $this->calculateLate($inBreak_end, $now)
                );
                $this->sched = "Late Break In for " + $this->calculateLate($inBreak_end, $now) + " minute/s";
            } else {
                $this->sched = "Already Break In";
            }

        }

        // Time Out
        elseif(strtotime($now) <= strtotime($outPM_end) and strtotime($inBreak_end) <= strtotime($now)){

            // If the user didnt time out at pm yet 
            // The user must have break in data before time out
            if(!$this->checkIfNull($emp, "inBreak")) {

                if($this->checkIfNull($emp, "outPM")){
                    $data = array( 
                        'outPM' => $now,
                        'underTime' => $this->getUnderTime($emp) + $this->calculateUnderTime($outPM_end, $now) 
                    );
                    $this->sched = "Out PM Success";
                } else {
                    $this->sched = "Already Out PM";
                }

            }
            

        }

        // Overtime Out
        // Have no exact time, only depends if the the user scan again after overtimeIN
        // if the inOvertime is not null
        elseif(!$this->checkIfNull($emp, "inOvertime")){

            $data = array( 'outOvertime' => $now);
            $this->sched = "Overtime Out Success";
        }

        // Overtime In 
        // Have no exact time but after Time out and already time out
        elseif(strtotime($outPM_end) < strtotime($now) and !$this->checkIfNull($emp, "outPM")){

            // Set Overtime out at 11:59 PM incase the user didnt overtime out
            // Change the value when he/she out
            $data = array( 
                'inOvertime' => $now,
                'outOvertime' => "23:59:00",
            );
            $this->sched = "Overtime In Success";
        }

        return $data;
    }


    // Returns data of what time is being updated (Sliding)
    public function timeDataSliding($emp){
        
        $inAm_start =  $this->inAm_from; 
        $inAm_end = $this->inAm_to; 

        $outBreak_start = $this->outBreak_from; 
        $outBreak_end = $this->outBreak_to; 

        $inBreak_start = $this->inBreak_from; 
        $inBreak_end = $this->inBreak_to; 

        $outPM_start = $this->outPm_from; 
        $outPM_end = $this->outPm_to; 
        
        $data = array();
        $now = $this->time;

        /*
         * Here are the conditions for Sliding
         */

        // Time In
        // from 12:00 Am to time in to
        if(strtotime($now) <= strtotime($inAm_end)) {

            // If the user didnt time in yet at morning 
            if($this->checkIfNull($emp, "inAM")){
                $data = array( 'inAM' => $now);
                $this->sched = "Time In Success";
            } else {
                $this->sched = "Already Time In";
            }
            
        }

        // Late Time In
        // from time in to to break in
        elseif(strtotime($inAm_end) < strtotime($now) and strtotime($now) < strtotime($outBreak_start)){

            // If the user didnt time in yet at Morning
            if($this->checkIfNull($emp, "inAM")){
                $data = array( 
                    'inAM' => $now,
                    'late' => $this->getLate($emp) + $this->calculateLate($inAm_end, $now)
                );
                $this->sched = "Time In Late for " + $this->calculateLate($inAm_end, $now) + " minute/s";
            } else {
                $this->sched = "Already Time In";  
            }
            
        }

        // Break Out
        elseif(strtotime($now) <= strtotime($outBreak_end) and strtotime($outBreak_start) <= strtotime($now)){

            // If the user didnt time in in morning and didnt break out yet
            if($this->checkIfNull($emp, "inAM") and $this->checkIfNull($emp, "outBreak")){
                $data = array( 
                    'inBreak' => $now,
                    'late' => $this->getLate($emp) + $this->calculateLate($inAm_start, $now)
                );
                $this->sched = "Break In Success";
            }
            // If the user didnt break out yet 
            else if($this->checkIfNull($emp, "outBreak")){
                $data = array( 
                    'outBreak' => $now,
                    'underTime' => $this->calculateUnderTime($outBreak_end, $now)
                );
                $this->sched = "Break Out Success";
            } else {

                // If the user scans again around break out, she/he wanted to in break
                $data = array( 'inBreak' => $now);
                $this->sched = "Break In Success";

            }

        }

        // Break In
        elseif(strtotime($now) <= strtotime($inBreak_end) and strtotime($inBreak_start) <= strtotime($now)){

            // If the user didnt break in yet
            if($this->checkIfNull($emp, "inBreak")){
                $data = array( 'inBreak' => $now);
                $this->sched = "Break In Success";
            } else {
                $this->sched = "Already Break In";
            }
            
        }

        // Late Break In
        elseif(strtotime($now) <= strtotime($outPM_start) and strtotime($inBreak_end) <= strtotime($now)){

            // If the user didnt break in yet 
            if($this->checkIfNull($emp, "inBreak")){
                $data = array( 
                    'inBreak' => $now,
                    'late' => $this->getLate($emp) + $this->calculateLate($inBreak_end, $now)
                );
                $this->sched = "Late Break In for " + $this->calculateLate($inBreak_end, $now) + " minute/s";
            } else {
                $this->sched = "Already Break In";
            }

        }

        // Time Out
        elseif(strtotime($now) <= strtotime($outPM_end) and strtotime($outPM_start) <= strtotime($now)){

            // If the user didnt time out at pm yet 
            // The user must have break in data before time out
            if(!$this->checkIfNull($emp, "inBreak")) {
                if($this->checkIfNull($emp, "outPM")){
                    $data = array( 
                        'outPM' => $now,
                        'underTime' => $this->getUnderTime($emp) + $this->calculateUnderTime($outPM_end, $now)
                    );
                    $this->sched = "Out PM Success";
                } else {
                    $this->sched = "Already Out PM";
                }
            }

        }

         // Overtime Out
        // Have no exact time, only depends if the the user scan again after overtimeIN
        // if the inOvertime is not null
        elseif(!$this->checkIfNull($emp, "inOvertime")){
            $data = array( 'outOvertime' => $now);
            $this->sched = "Overtime Out Success";
        }

        // Overtime In 
        // Have no exact time but after time out pm and already time out
        elseif(strtotime($outPM_end) < strtotime($now) and !$this->checkIfNull($emp, "outPM")){

            // Set Overtime out at 11:59 PM incase the user didnt overtime out
            // Change the value when he/she overtime out
            $data = array( 
                'inOvertime' => $now,
                'outOvertime' => "23:59:00",
            );
            $this->sched = "Overtime In Success";
        }

        return $data;
    }
}

?>