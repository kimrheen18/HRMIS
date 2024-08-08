<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Benefit_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}
	
	function add($arrData)
	{
		$this->db->insert('tblEmpBenefits', $arrData);
		return $this->db->insert_id();
	}

	function edit($arrData, $benefitcode,$empid='')
	{
		if($empid!=''){
			$this->db->where('empNumber',$empid);
		}
		$this->db->where('benefitCode',$benefitcode);
		$this->db->update('tblEmpBenefits', $arrData);
		return $this->db->affected_rows();
	}

	function editByFields($arrData, $arrwhere)
	{
		$this->db->where($arrwhere);
		$this->db->update('tblEmpBenefits', $arrData);
		return $this->db->affected_rows();
	}

	function update_benefits($arrData,$empid='',$incomeCode='')
	{
		$this->db->where('empNumber',$empid);
		$this->db->where('incomeCode',$incomeCode);
		$this->db->update('tblEmpBenefits', $arrData);
		return $this->db->affected_rows();
	}

	function getBenefits($empid='', $incomeCode='')
	{
		$arrWhere = $incomeCode!='' ? array('incomeCode' => $incomeCode, 'empNumber' => $empid) : array('empNumber' => $empid);
		return $this->db->get_where('tblEmpBenefits', $arrWhere)->result_array();
	}

	function getEmployeeBenefit($empid, $yr, $mon)
	{
		return $this->db->join('tblIncome', 'tblIncome.incomeCode = tblEmpIncome.incomeCode', 'left')
					->where('empNumber',$empid)
					->where('tblIncome.incomeType','Benefit')
					->where('hidden',0)
					->where('incomeYear',$yr)
					->where('incomeMonth',$mon)
					->get('tblEmpIncome')->result_array();
	}

	function getBenefitsfromArray($arrBenefits, $arrIncome)
	{
		foreach($arrIncome as $inc_id => $income):	
			$key = array_search($income['incomeCode'], array_column($arrBenefits, 'incomeCode'));
			if($key!=''):
				$arrIncome[$inc_id]['arrbenefits'] = $arrBenefits[$key];
			endif;
		endforeach;

		return $arrIncome;
	}

	function delete_empbenefit_byempNumber($appt, $arrempNumbers)
	{
		foreach($arrempNumbers as $empno):
			if($appt == 'P'):
				# permanent
				$this->db->where('empNumber', $empno);
				$this->db->where_in('incomeCode', array('HAZARD','LAUNDRY','SUBSIS','LONGI','TA','RA'));
				$this->db->delete('tblEmpBenefits');
			endif;
			
			$this->db->where('empNumber', $empno);
			$this->db->where_in('incomeCode', array('SALARY'));
			$this->db->delete('tblEmpBenefits');
		endforeach;
	}

	function setamount_benefits($arrbenefit,$empdetail,$proc_mon,$proc_yr,$income_data)
	{
		$arr_amt = 0;
		$amount = 0;
		$itw = 0;
		$period_amt = 0;
		$stat = 1;
		
		switch ($arrbenefit['incomeCode']):
			# 1
			case 'COMMA':
				# Get empdetails status and 
				$key = array_search('COMMA', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = 0; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 2
			case 'EME':
				$key = array_search('EME', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = 0; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 3
			case 'HAZARD':
				$key = array_search('HAZARD', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = $empdetail['hp']; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 4
			case 'LAUNDRY':
				$key = array_search('LAUNDRY', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = $empdetail['laundry']; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 5
			case 'LONGI':
				$key = array_search('LONGI', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = $empdetail['longevity']; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 6
			case 'OT':
				$key = array_search('OT', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = 0; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 7
			case 'PERA':
				$key = array_search('PERA', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = 0; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 8
			case 'RA':
				$key = array_search('RA', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = $empdetail['rata']['ra_amount']; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			/* RATA has been separated as RA & TA
			# 9
			case 'RATA':
				$key = array_search('RATA', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = 0; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break; */
			# 9
			case 'Reffund':
				$key = array_search('Reffund', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = 0; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 10
			case 'RefundSikat':
				$key = array_search('RefundSikat', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = 0; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 11
			case 'SUBSIS':
				$key = array_search('SUBSIS', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = $empdetail['subsis']; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 12
			case 'TA':
				$key = array_search('TA', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = $empdetail['rata']['ta_amount']; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
			# 13
			case 'Underpay':
				$key = array_search('Underpay', array_column($income_data, 'incomeCode'));
				if($key!=''):
					$arr_amt = $income_data[$key];
					$amount = 0; $itw = $arr_amt['ITW']; $stat = $arr_amt['status'];
				endif;
				break;
		endswitch;

		$arrData = array('empNumber' 	=> $empdetail['emp_detail']['empNumber'],
						 'incomeCode' 	=> $arrbenefit['incomeCode'],
						 'incomeMonth' 	=> $proc_mon,
						 'incomeYear'	=> $proc_yr,
						 'incomeAmount' => $amount == '' ? 0 : $amount,
						 'ITW' 			=> $itw == '' ? 0.00 : $itw,
						 'period1' 		=> 0,
						 'period2' 		=> 0,
						 'period3' 		=> 0,
						 'period4' 		=> 0,
						 'status' 		=> $stat == '' ? 1 : $stat);
		return $arrData;
	}

	public function multiple_delete($arrids)
	{
		foreach($arrids as $id):
			$this->db->where('benefitCode', $id);
			$this->db->delete('tblEmpBenefits');
		endforeach;
	}
		
}
/* End of file Benefit_model.php */
/* Location: ./application/modules/finance/models/Benefit_model.php */