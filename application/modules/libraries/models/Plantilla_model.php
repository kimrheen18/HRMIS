<?php 
/** 
Purpose of file:    Model for Plantilla Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plantilla_model extends CI_Model {

	var $table = 'tblPlantilla';
	var $tableid = 'plantillaID';

	function __construct()
	{
		$this->load->database();
		//$this->db->initialize();	
	}

	function getData($intPlantillaId = '')
	{		
		$this->db->select($this->table.'.*,tblPosition.positionDesc,tblPlantillaGroup.plantillaGroupName');
		if($intPlantillaId != "")
		{
			$this->db->where($this->tableid,$intPlantillaId);
		}
		 $this->db->join('tblPosition','tblPosition.positionCode = '.$this->table.'.positionCode','left');
		 $this->db->join('tblPlantillaGroup','tblPlantillaGroup.plantillaGroupCode = '.$this->table.'.plantillaGroupCode','left');
		 $this->db->join('tblExamType','tblExamType.examCode = '.$this->table.'.examCode','left');
		 $this->db->order_by('tblPlantilla.'.$this->tableid,'ASC');
		$objQuery = $this->db->get($this->table);
		// echo $this->db->last_query();
		return $objQuery->result_array();	
	}

	function getAllSG($salaryGradeNumber='')
	{
		$this->db->select('distinct(salaryGradeNumber)');
		if($salaryGradeNumber != "")
		{
			$this->db->where('tblSalarySched',$salaryGradeNumber);
		}
			$this->db->order_by('salaryGradeNumber','ASC');
			// $this->db->group_by('salaryGradeNumber');
		$objQuery = $this->db->get('tblSalarySched');
		return $objQuery->result_array();	
	}

	function getAllPlantilla($plantillaId='')
	{
		if($plantillaId!=''):
			$res = $this->db->get_where('tblPlantilla', array('plantillaID' => $plantillaId))->result_array();
			return count($res) > 0 ? $res[0] : array(); 
		else:
			return $this->db->order_by('itemNumber','ASC')->get($this->table)->result_array();	
		endif;
	}

	function get_plantilla_byItemNumber($itemNumber)
	{
		$res = $this->db->get_where('tblPlantilla', array('itemNumber' => $itemNumber))->result_array();
		return count($res) > 0 ? $res[0] : array(); 
	}

	function add($arrData)
	{
		$this->db->insert($this->table, $arrData);
		// echo $this->db->last_query();
		return $this->db->insert_id();		
	}

	function checkExist($strPlantilla = '', $strPosition = '')
	{		
		$this->db->where('itemNumber',$strPlantilla);
		$this->db->or_where('positionCode', $strPosition);			
		
		$objQuery = $this->db->get($this->table);
		return $objQuery->result_array();	
	}

	function save($arrData, $intPlantillaId)
	{
		$this->db->where($this->tableid, $intPlantillaId);
		$this->db->update($this->table, $arrData);
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
	function delete($intPlantillaId)
	{
		$this->db->where($this->tableid, $intPlantillaId);
		$this->db->delete($this->table); 	
		//echo $this->db->affected_rows();
		return $this->db->affected_rows()>0?TRUE:FALSE;
	}
		
}
