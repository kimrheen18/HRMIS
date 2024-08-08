<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_qr_summary_model extends CI_Model {
	
	function __construct()
	{
		$this->load->database();
	}

	// Save Input from Contoller to Database
    public function save($emp, $date)
    {
       $data = array(
            'empNumber' => $emp,
            'dtrDate' => $date,
        );

        $this->db->insert("tblEmpQRScan", $data);
    }

	public function updateData($emp, $date, $col, $val) {
		$this->db->update("tblEmpQRScan", 
			array(
				$col=>$val 
			)
		,
            array(
                'empNumber'=> $emp,
                'dtrDate' => $date
            )
        );
	}

	function getData($empid, $datefrom, $dateto)
	{
		$data = array();

		foreach(dateRange($datefrom,$dateto) as $dtrdate):
			if($this->checkExist($empid, $dtrdate)){
				$this->db->where('empNumber', $empid);
		        $this->db->where('dtrDate', $dtrdate);
		        $query = $this->db->get("tblEmpQRScan");
		        $row = $query->row_array();

				array_push($data, $row);
			} else {
				array_push($data, "");
			}
		endforeach;
		
		return $data;
	}

	public function getSingleData($empid, $date){
		$this->db->where('empNumber', $empid);
		$this->db->where('dtrDate', $date);
		$query = $this->db->get("tblEmpQRScan");
		$row = $query->row_array();
		return $row;
	}

	public function getDTReto($empid){
		$this->db->where('empNumber', $empid);
		$this->db->where('requestStatus', 'CERTIFIED');
		$result = $this->db->get('tblEmpRequest')->result_array();
		return $result;
	}

	function checkExist($emp, $date){
		$this->db->where('empNumber',$emp);
        $this->db->where('dtrDate',$date);
        $query = $this->db->get("tblEmpQRScan");
        return $query->num_rows() > 0;
	}

	public function exportDataExcel($date){
		$this->db->select(array('empNumber', 'inAM', 'outBreak', 'inBreak', 'outPM', 'inOvertime', 'outOvertime', 'late', 'underTime'));
		$this->db->where('dtrDate', $date);
		$this->db->from('tblEmpQRScan');
		$query = $this->db->get();
		return $query->result();
	}

	public function getEmployeeName($emp){
		$this->db->where('empNumber', $emp);
        $query = $this->db->get("tblEmpPersonal");
        $row = $query->row_array();
		return $row["surname"] . ', ' . $row["firstname"] . ' ' .  $row["middlename"];
	}
}

?>