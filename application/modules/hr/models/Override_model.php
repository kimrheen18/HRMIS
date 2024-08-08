<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Override_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}

	# BEGIN OB
	function get_override_ob($obid='')
	{
		if($obid!=''):
			$this->db->join('tblOverride','tblOverride.override_id = tblEmpOB.override_id','left');
			$res = $this->db->get_where('tblEmpOB',array('tblEmpOB.obID' => $obid, 'tblOverride.override_type' => 1))->result_array();
		else:
			strict_mode();
			$this->db->group_by('obID');
			$res = $this->db->get_where('tblEmpOB',array('is_override' => 1))->result_array();
		endif;
		// print_r($this->db->last_query());
		// exit(1);
		return $res;
	}

	function add($arrData)
	{
		$this->db->insert('tblOverride', $arrData);
		return $this->db->insert_id();
	}

	function save($arrData, $id)
	{
		$this->db->where('override_id', $id);
		$this->db->update('tblOverride', $arrData);
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}

	function delete($id)
	{
		$this->db->where('override_id', $id);
		$this->db->delete('tblOverride');
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
	# END OB

	# BEGIN EXC DTR
	function get_override_excdtr($edtrid='')
	{
		$res = array();
		if($edtrid!=''):
			$override_excdtr = $this->db->get_where('tblOverride' ,array('override_type' => 2, 'override_id' => $edtrid))->result_array();
			$emps = $this->db->select('empNumber')->get_where('tblEmpPosition', array('tblEmpPosition.override_id' => $override_excdtr[0]['override_id']))->result_array();
			$res = array('emps' => $emps, 'excdtr' => $override_excdtr[0]);
		else:
			$override_excdtr = $this->db->get_where('tblOverride' ,array('override_type' => 2))->result_array();
			foreach($override_excdtr as $execdtr):
				$emps = $this->db->select('empNumber')->get_where('tblEmpPosition', array('tblEmpPosition.override_id' => $execdtr['override_id']))->result_array();
				$res[] = array('emps' => $emps, 'excdtr' => $execdtr);
			endforeach;
		endif;
		return $res;
	}

}
