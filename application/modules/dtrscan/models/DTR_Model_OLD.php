<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class DTR_Model extends MY_Controller 
{
    protected $date, $time, $table, $position;

    public function __construct()
	{
        $this->load->helper('url'); 
        $this->load->database();

        date_default_timezone_set('Asia/Manila');
        $this->date = date("Y-m-d");
        $this->time = date("H:i:s");
        $this->table = "tblEmpQRScan";
        $this->position = "tblEmpPosition";
        //$this->time = date("H:i:s", mktime(18,15,0));
    }

    // Get Emp Attendance Scheme
    public function getEmpAttendanceScheme($emp){
        $this->db->where('empNumber', $emp);
        $query = $this->db->get($this->position);
        $row = $query->row_array();
        return $row['schemeCode'];
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

    // Check If the user has already data within that date
    public function checkExistData($emp)
    {
        $this->db->where('empNumber',$emp);
        $this->db->where('dtrDate',$this->date);
        $query = $this->db->get($this->table);
        return !$query->num_rows() > 0;
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

    // Updates Time 
    public function updateTime($emp){
        $this->db->where('empNumber',$emp);
        $this->db->where('dtrDate',$this->date);
        $this->db->update($this->table, $this->timeData($emp));
    }

    // Method that calculate minutes 
    public function calculateLate($deadtime, $in) {
        return round(abs(strtotime($in) - strtotime($deadtime)) / 60);
    }

    // Returns data of what time is being updated
    public function timeData($emp){

        // Set time interval 
        $inAm_start = "7:30 AM"; 
        $inAm_end = "9 AM"; 

        $outBreak_start = "12 PM"; 
        $outBreak_end = "12:59 PM"; 

        $inBreak_start = "1 PM"; 
        $inBreak_end = "1:30 PM"; 

        $outPM_start = "5 PM"; 
        $outPM_end = "6 PM"; 
        
        $data = array();
        $now = $this->time;

        // Time In
        // 12:00 AM until 7:29 AM
        if(strtotime($now) < strtotime($inAm_start)) {
            $data = array( 'inAM' => $now);
        }
        
        // Late Time IN
        // 7:30 AM until 9:00 AM 
        // (after 7:30 AM ) and (before 9:00 AM)
        elseif(strtotime($inAm_start) <= strtotime($now) and strtotime($now) <= strtotime($inAm_end)) {
            $data = array( 
                'inAM' => $now,
                'late' => $this->getLate($emp) + $this->calculateLate($inAm_start, $now)
            );
            // Add Code here for computing late
        }

        // Consider Half Day
        // 9:00 Am until Break In
        // (after 9:00 AM) and (before Break In 11:59 AM)
        elseif(strtotime($inAm_end) < strtotime($now) and strtotime($now) < strtotime($outBreak_start)){
            $data = array( 'inBreak' => $now);
        }

        // Break Out
        // From 12:00 PM until 12:59 PM
        // (before 12:59 PM) and (after 12:00 PM)
        elseif(strtotime($now) <= strtotime($outBreak_end) and strtotime($outBreak_start) <= strtotime($now)){

            // If the inAm is null or didnt time in at morning
            if($this->checkIfNull($emp, "inAM")) {
                $data = array( 'inBreak' => $now);
            } else {
                $data = array( 'outBreak' => $now);
            }
           
        }

        // Break In
        // From 1:00 PM until 1:30 PM
        // (before 1:30 PM) and (after 1:00 PM) 
        elseif(strtotime($now) <= strtotime($inBreak_end) and strtotime($inBreak_start) <= strtotime($now)){
            $data = array( 'inBreak' => $now);
        }

        // OutPM
        // From 5:00 PM until 6:00 PM
        // (before 6:00 PM) and (after 5:00 PM)
        elseif(strtotime($now) <= strtotime($outPM_end) and strtotime($outPM_start) <= strtotime($now)){
            $data = array( 'outPM' => $now);
        }

        // Overtime Out
        // Have no exact time, only depends if the the user scan again after overtimeIN
        // if the inOvertime is not null
        elseif(!$this->checkIfNull($emp, "inOvertime")){
            $data = array( 'outOvertime' => $now);
        }

        // Overtime In 
        // Have no exact time but after 6:00 PM
        // (after 6:00 PM ) and If the outPM column is not null
        elseif(strtotime($outPM_end) < strtotime($now) and !$this->checkIfNull($emp, "outPM")){
            $data = array( 'inOvertime' => $now);
        }

        return $data;
    }
}

?>