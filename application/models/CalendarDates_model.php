<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CalendarDates_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}

	# dates checking holidays and weekends
	public function dates_nw_nh($datefrom, $dateto, $yr, $empid)
	{
		$arrfiltered_dates = array();
		# break dates
		$arrdates = breakdates(date('Y-m-d', strtotime($datefrom)), date('Y-m-d', strtotime($dateto)));
		
		# Regular Holiday
		$this->db->join('tblHolidayYear','tblHolidayYear.holidayCode = tblHoliday.holidayCode','inner');
		$this->db->like('holidayDate', $yr.'-', 'after');
		$reg_holidays = $this->db->get('tblHoliday')->result_array();

		# Local Holiday
		$this->db->join('tblLocalHoliday', 'tblLocalHoliday.holidayCode = tblEmpLocalHoliday.holidayCode', 'left');
		$emplocholiday = $this->db->get_where('tblEmpLocalHoliday', array('holidayYear' => $yr, 'empNumber' => $empid))->result_array();

		foreach($arrdates as $date):
			$dday = date('D', strtotime($date));
			
			# Holiday
			$holikey = array_search($date, array_column($reg_holidays, 'holidayDate'));
			$holiday = is_numeric($holikey) ? $reg_holidays[$holikey]['holidayName'] : '';

			# Local Holiday
			$locholikey = array_search($date, array_column($emplocholiday, 'holidayDay'));
			$localholi = is_numeric($locholikey) ? $emplocholiday[$locholikey]['holidayName'] : '';

			if($holiday == '' && $localholi == '' && !in_array($dday, array('Sat','Sun'))):
				array_push($arrfiltered_dates, $date);
			endif;
		endforeach;

		return $arrfiltered_dates;
	}


}
/* End of file CalendarDates_model.php */
/* Location: ./application/models/CalendarDates_model.php */