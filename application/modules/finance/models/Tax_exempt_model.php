<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tax_exempt_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function getData($code='')
	{
		if($code==''):
			return $this->db->order_by('taxStatus','DESC')->get('tblTaxExempt')->result_array();
		else:
			return $this->db->get_where('tblTaxExempt', array('taxStatus' => $code))->result_array();
		endif;
	}
		
}
/* End of file Tax_exempt_model.php */
/* Location: ./application/modules/finance/models/Tax_exempt_model.php */