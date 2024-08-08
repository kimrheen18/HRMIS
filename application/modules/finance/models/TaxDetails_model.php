<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TaxDetails_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function getTaxDetails($empid)
	{
		$res = $this->db->get_where('tblTaxDetails', array('empNumber' => $empid))->result_array();
		return count($res) > 0 ? $res[0] : null;
	}

	function add($arrData)
	{
		$this->db->insert('tblTaxDetails', $arrData);
		return $this->db->insert_id();
	}
	
	function editTaxDetails($arrData, $empid)
	{
		$this->db->where('empNumber',$empid);
		$this->db->update('tblTaxDetails', $arrData);
		return $this->db->affected_rows();
	}
		
}
/* End of file TaxDetails_model.php */
/* Location: ./application/modules/finance/models/TaxDetails_model.php */