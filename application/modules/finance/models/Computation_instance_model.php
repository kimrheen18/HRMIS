<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Computation_instance_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function getData($mon,$yr,$appt)
	{
		return $this->db->get_where('tblComputationInstance',array('pmonth' => $mon, 'pyear' => $yr, 'appointmentCode' => $appt))->result_array();
	}

	function insert_computation($arrData)
	{
		$this->db->insert('tblComputation', $arrData);
		return $this->db->insert_id();
	}

	function insert_nonperm_computation($arrData)
	{
		$this->db->insert('tblNonPermComputation', $arrData);
		return $this->db->insert_id();
	}

	function insert_computation_instance($arrData)
	{
		$this->db->insert('tblComputationInstance', $arrData);
		return $this->db->insert_id();
	}

	function insert_nonpem_computation_instance($arrData)
	{
		$this->db->insert('tblNonPermComputationInstance', $arrData);
		return $this->db->insert_id();
	}

	function update_nonpem_computation_instance($arrData,$appt,$mon='',$yr='',$period='')
	{
		$this->db->where('appointmentCode',$appt);
		if($mon != ''){
			$this->db->where('pmonth',$mon);
		}
		if($yr != ''){
			$this->db->where('pyear',$yr);
		}
		if($period != ''){
			$this->db->where('period',$period);
		}
		$this->db->update('tblNonPermComputationInstance', $arrData);
		return $this->db->affected_rows();
	}

	function edit_computation_instance($arrData,$appt,$mon='',$yr='')
	{
		if($mon!='' && $yr!=''):
			$this->db->where('pmonth',$mon);
			$this->db->where('pyear',$yr);
		endif;
		$this->db->where('appointmentCode',$appt);
		$this->db->update('tblComputationInstance', $arrData);
		return $this->db->affected_rows();
	}

	# delete computation instance
	function del_computation_instance($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tblComputationInstance');
		return $this->db->affected_rows();
	}

	function del_computation_instance_byperiod($mon,$yr,$appt)
	{
		$this->db->where('pmonth', $mon);
		$this->db->where('pyear', $yr);
		$this->db->where('appointmentCode', $appt);
		$this->db->delete('tblComputationInstance');
		return $this->db->affected_rows();
	}

	# delete computation
	function del_computation($id)
	{
		$this->db->where('fk_id', $id);
		$this->db->delete('tblComputation');
		return $this->db->affected_rows();
	}

	function del_computation_nonperm_instance($appt,$mon,$yr,$per)
	{
		if($appt == 'JO'){
			$this->db->where('appointmentCode', $appt);
		}else{
			$this->db->where('payrollGroupCode', $appt);
		}
		$this->db->where('pmonth', $mon);
		$this->db->where('pyear', $yr);
		$this->db->where('period', $per);
		$this->db->delete('tblNonPermComputationInstance');
		return $this->db->affected_rows();
	}

	function get_computation_details($arrData)
	{
		return $this->db->get_where('tblComputationDetails',array('latest' => 'Y'))->result_array();
	}

	function insert_computation_details($arrData)
	{
		$this->db->insert('tblComputationDetails', $arrData);
		return $this->db->insert_id();
	}

	function edit_computation_details($arrData)
	{
		$this->db->update('tblComputationDetails', $arrData);
		return $this->db->affected_rows();
	}

	# delete computation details
	function del_computation_details($id)
	{
		$this->db->where('fk_id', $id);
		$this->db->delete('tblComputationDetails');
		return $this->db->affected_rows();
	}

	function del_computation_details_byPeriod($mon,$yr)
	{
		$this->db->where('periodMonth', $mon);
		$this->db->where('periodYear', $yr);
		$this->db->delete('tblComputationDetails');
		return $this->db->affected_rows();
	}


}
/* End of file Computation_instance_model.php */
/* Location: ./application/modules/finance/models/Computation_instance_model.php */