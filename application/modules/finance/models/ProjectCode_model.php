<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ProjectCode_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function add($arrData)
	{
		$this->db->insert('tblProject', $arrData);
		return $this->db->insert_id();
	}

	function edit($arrData, $id)
	{
		$this->db->where('projectId',$id);
		$this->db->update('tblProject', $arrData);
		return $this->db->affected_rows();
	}

	public function delete($id)
	{
		$this->db->where('projectId', $id);
		$this->db->delete('tblProject');
		return $this->db->affected_rows(); 
	}

	function getData($id)
	{
		if($id==''):
			return $this->db->order_by('projectOrder','ASC')->get('tblProject')->result_array();
		else:
			$result = $this->db->get_where('tblProject', array('projectId' => $id))->result_array();
			return $result[0];
		endif;
	}
	
	function isCodeExists($code, $action)
	{
		$result = $this->db->get_where('tblProject', array('projectCode' => $code))->result_array();
		if($action == 'add'):
			if(count($result) > 0):
				return true;
			endif;
		else:
			if(count($result) > 1):
				return true;
			endif;
		endif;
		return false;
	}
		
}
/* End of file ProjectCode_model.php */
/* Location: ./application/modules/finance/models/ProjectCode_model.php */