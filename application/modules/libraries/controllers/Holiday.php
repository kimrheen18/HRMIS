<?php 
/** 
Purpose of file:    Controller for Holiday Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('libraries/holiday_model'));
    }

	public function index()
	{
		$this->arrData['arrHoliday'] = $this->holiday_model->getData();
		$this->template->load('template/template_view', 'libraries/holiday/list_view', $this->arrData);
	}
	
	//ADD HOLIDAY NAME
	public function add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->template->load('template/template_view','libraries/holiday/add_view',$this->arrData);	
		}
		else
		{	
			$strHolidayCode = $arrPost['strHolidayCode'];
			$strHolidayName = $arrPost['strHolidayName'];
			if(!empty($strHolidayCode) && !empty($strHolidayName))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->holiday_model->checkExist($strHolidayCode, $strHolidayName))==0)
				{
					$arrData = array(
						'holidayCode'=>$strHolidayCode,
						'holidayName'=>$strHolidayName
					);
					$blnReturn  = $this->holiday_model->add($arrData);

					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHoliday','Added '.$strHolidayCode.' Holiday',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Holiday added successfully.');
					}
					redirect('libraries/holiday');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Holiday code and/or Holiday Name already exists.');
					$this->session->set_flashdata('strHolidayCode',$strHolidayCode);
					$this->session->set_flashdata('strHolidayName',$strHolidayName);
					redirect('libraries/holiday/add');
				}
			}
		}
    }

	public function edit()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$strCode = urldecode($this->uri->segment(4));
			$this->arrData['arrHoliday']=$this->holiday_model->getData($strCode);
			$this->template->load('template/template_view','libraries/holiday/edit_view', $this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			$strHolidayCode = $arrPost['strHolidayCode'];
			$strHolidayName = $arrPost['strHolidayName'];
			if(!empty($strHolidayCode) AND !empty($strHolidayName)) 
			{
				$arrData = array(
					'holidayCode'=>$strHolidayCode,
					'holidayName'=>$strHolidayName
					
				);
				$blnReturn = $this->holiday_model->save($arrData, $strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHoliday','Edited '.$strHolidayCode.' Holiday',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Holiday updated successfully.');
				}
				redirect('libraries/holiday');
			}
		}		
	}

	public function delete()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strCode = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->holiday_model->getData($strCode);
			$this->template->load('template/template_view','libraries/holiday/delete_view',$this->arrData);
		}
		else
		{
			$strCode = $arrPost['strCode'];
			//add condition for checking dependencies from other tables
			if(!empty($strCode))
			{
				$arrHoliday = $this->holiday_model->getData($strCode);
				$strHolidayCode = $arrHoliday[0]['holidayCode'];	
				$blnReturn = $this->holiday_model->delete($strCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHoliday','Deleted '.$strHolidayCode.' Holiday',implode(';',$arrHoliday[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Holiday deleted successfully.');
				}
				redirect('libraries/holiday');
			}
		}		
	}

	//MANAGE HOLIDAY 
    public function manage_add()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrHolidayName']=$this->holiday_model->getHolidayName();
			$this->arrData['arrManageHoliday']=$this->holiday_model->getManageHoliday();
			$this->arrData['arrWorkSus'] = $this->holiday_model->getWorkSuspension();
			$this->template->load('template/template_view','libraries/holiday/manage_add_view',$this->arrData);	
		}
		else
		{	
			$strHolidayName = $arrPost['strHolidayName'];
			$dtmHolidayDate = $arrPost['dtmHolidayDate'];
			if(!empty($strHolidayName) && !empty($dtmHolidayDate))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->holiday_model->checkHolidayExist($strHolidayName, $dtmHolidayDate))==0)
				{
					$arrData = array(
						'holidayCode'=>$strHolidayName,
						'holidayDate'=>$dtmHolidayDate

					);
					$blnReturn  = $this->holiday_model->manage_add($arrData);
					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHolidayYear','Added '.$strHolidayName.' Holiday',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Holiday added successfully.');
					}
					redirect('libraries/holiday/manage_add');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Holiday name and/or date already exists.');
					$this->session->set_flashdata('strHolidayName',$strHolidayName);
					$this->session->set_flashdata('dtmHolidayDate',$dtmHolidayDate);
					redirect('libraries/holiday/manage_add');
				}
			}
		}
    	
    }
    public function edit_manage()
	{
		$arrPost = $this->input->post();
		if(empty($arrPost))
		{
			$this->arrData['arrManageHoliday']=$this->holiday_model->getManageHoliday();
			$this->arrData['arrDataHoliday']=$this->holiday_model->getManageHoliday(urldecode($this->uri->segment(4)));
			$this->arrData['arrHoliday']=$this->holiday_model->getData();
			$this->template->load('template/template_view','libraries/holiday/edit_manage_view', $this->arrData);
		}
		else
		{
			$intHolidayId = $arrPost['intHolidayId'];
			$strHolidayName = $arrPost['strHolidayName'];
			$dtmHolidayDate = $arrPost['dtmHolidayDate'];
			if(!empty($strHolidayName))
			{	
				$arrData = array(
						'holidayCode'=>$strHolidayName,
						'holidayDate'=>$dtmHolidayDate
				
				);
				$blnReturn = $this->holiday_model->save_manage($arrData, $intHolidayId);
				// print_r($arrData);
				// exit(1);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHolidayYear','Edited '.$strHolidayName.' Holiday',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Holiday saved successfully.');
				}
				redirect('libraries/holiday/manage_add');
			}
		}
	}

	public function delete_manage()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intHolidayId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrManageHoliday']=$this->holiday_model->getManageHoliday($intHolidayId);
			$this->template->load('template/template_view','libraries/holiday/delete_manage_view',$this->arrData);
		}
		else
		{
			$intHolidayId = $arrPost['intHolidayId'];
			$strHolidayName = $arrPost['strHolidayName'];
			$dtmHolidayDate = $arrPost['dtmHolidayDate'];
			$arrManageHoliday=$this->holiday_model->getManageHoliday($intHolidayId);
			if(!empty($intHolidayId))
			{
				$blnReturn = $this->holiday_model->delete_manage($intHolidayId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHoliday','Deleted '.$strHolidayName.','.$dtmHolidayDate.'Holiday',implode(';',$arrManageHoliday[0]),'');
					$this->session->set_flashdata('strSuccessMsg','Holiday deleted successfully.');
				}
				redirect('libraries/holiday');
			}
		}		
	}

	 //ADD LOCAL HOLIDAY
    public function add_local()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrLocHoliday'] = $this->holiday_model->getLocalHoliday();
			$arrLocalCode = $this->holiday_model->getLastLocalCode();
			foreach ($arrLocalCode as $row):
				if($row['holidayCode']!=''):
					$arrCode=explode('-', $row['holidayCode']);
					$i = $arrCode[1]+1;
					if (strlen($i)==1)
					{
						$i = '000'.$i;
					}
					if (strlen($i)==2)
					{
						$i = '00'.$i;
					}
					if (strlen($i)==3)
					{
						$i = '0'.$i;
					}
					$strNewCode='LOC-'.$i;
					//echo $strNewCode;
					$this->arrData['strLocalCode'] = $strNewCode;	
					break;
					//echo $i;
					//exit(1);
				endif;
			endforeach;
			$this->arrData['arrHoliday'] = $this->holiday_model->getData();
			
			$this->template->load('template/template_view','libraries/holiday/add_local_view',$this->arrData);	
		}
		else
		{	
			$strLocalCode = $arrPost['strLocalCode'];
			$strLocalName = $arrPost['strLocalName'];
			$dtmHolidayDate = $arrPost['dtmHolidayDate'];
			if(!empty($strLocalName) && !empty($dtmHolidayDate))
			{	

				if(count($this->holiday_model->checkLocExist($strLocalName, $dtmHolidayDate))==0)
				{   
					$tmpDate=explode('-',$dtmHolidayDate);

					$arrData = array(
						'holidayCode'=>$strLocalCode,
						'holidayName'=>$strLocalName,
						'holidayDate'=>$dtmHolidayDate,
						'holidayDay'=> $tmpDate[2],
						'holidayMonth'=> $tmpDate[1],
						'holidayYear'=>$tmpDate[0]
					);
					$blnReturn  = $this->holiday_model->add_local($arrData);
					//print_r($arrData);
					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tbllocalholiday','Added '.$strLocalName.' Holiday',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Local Holiday added successfully.');
					}
					redirect('libraries/holiday/add_local');
				}
				else
				{	
					//print_r($arrData);
					$this->session->set_flashdata('strErrorMsg','Local Holiday already exists.');
					$this->session->set_flashdata('strLocalName',$strLocalName);
					$this->session->set_flashdata('dtmHolidayDate',$dtmHolidayDate);
					redirect('libraries/holiday/add_local');
				}
			}
		}
    }

    public function edit_local()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$strLocalCode = urldecode($this->uri->segment(4));
			$this->arrData['arrData'] = $this->holiday_model->getLocalHoliday($strLocalCode);
			$this->arrData['arrLocHoliday'] = $this->holiday_model->getLocalHoliday();
			$this->arrData['arrHoliday']=$this->holiday_model->getData();
			$this->template->load('template/template_view','libraries/holiday/edit_local_view', $this->arrData);
		}
		else
		{
			$strLocalCode = $arrPost['strLocalCode'];
			$strLocalName = $arrPost['strLocalName'];
			$dtmHolidayDate = $arrPost['dtmHolidayDate'];

			if(!empty($strLocalName))
			{	
				$tmpDate=explode('-',$dtmHolidayDate);
				$arrData = array(				
						'holidayName'=>$strLocalName,
						'holidayDate'=>$dtmHolidayDate,
						'holidayDay'=> $tmpDate[2],
						'holidayMonth'=> $tmpDate[1],
						'holidayYear'=>$tmpDate[0]
				);
				// print_r($arrData); echo $strLocalCode;
				// exit(1);
				$blnReturn = $this->holiday_model->save_local($arrData, $strLocalCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tbllocalholiday','Edited '.$strLocalName.','.$dtmHolidate.' Holiday',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Local Holiday saved successfully.');
				}
				redirect('libraries/holiday/add_local');
			}
		}
	}

	public function delete_local()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$strLocalCode = urldecode($this->uri->segment(4));
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->holiday_model->getLocalHoliday($strLocalCode);
			$this->template->load('template/template_view','libraries/holiday/delete_local_view',$this->arrData);
		}
		else
		{
			$strLocalCode = $arrPost['strLocalCode'];
			$strHolidayName = $arrPost['strHolidayName'];
			$dtmHolidayDate = $arrPost['dtmHolidayDate'];
			$arrLocHoliday=$this->holiday_model->getLocalHoliday($strLocalCode);
			if(!empty($strLocalCode))
			{
				$blnReturn = $this->holiday_model->delete_local($strLocalCode);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHoliday','Deleted '.$strHolidayName.','.$dtmHolidayDate.'Holiday',implode(';',$arrLocHoliday),'');
					$this->session->set_flashdata('strSuccessMsg','Holiday deleted successfully.');
				}
				redirect('libraries/holiday/add_local');
			}
		}		
	}

    

	 //ADD WORK SUSPENSION
    public function add_worksuspension()
    {
    	$arrPost = $this->input->post();
		if(empty($arrPost))
		{	
			$this->arrData['arrHoliday'] = $this->holiday_model->getData();
			// $this->arrData['arrgetWS']=$this->holiday_model->getManageHoliday();
			$this->arrData['arrWorkSuspend'] = $this->holiday_model->getWorkSuspension();
			$this->template->load('template/template_view','libraries/holiday/add_worksuspension_view',$this->arrData);	
		}
		else
		{	
			$dtmSuspensionDate = $arrPost['dtmSuspensionDate'];
			$dtmSuspensionTime = $arrPost['dtmSuspensionTime'];
			$strWholeday = $arrPost['strWholeday'];
			if(!empty($dtmSuspensionDate) && !empty($dtmSuspensionTime))
			{	
				// check if exam code and/or exam desc already exist
				if(count($this->holiday_model->checkWorkSuspensionExist($dtmSuspensionDate))==0)
				{
					$arrData = array(
						'holidayCode'=>'WS',
						'holidayDate'=>$dtmSuspensionDate,
						'holidayTime'=>isset($strWholeday) ? '' : $dtmSuspensionTime
					);
					$blnReturn  = $this->holiday_model->add_worksuspension($arrData);
					if(count($blnReturn)>0)
					{	
						log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHolidayYear','Added '.$dtmSuspensionDate.' Holiday',implode(';',$arrData),'');
						$this->session->set_flashdata('strSuccessMsg','Work Suspension added successfully.');
					}
					redirect('libraries/holiday/add_worksuspension');
				}
				else
				{	
					$this->session->set_flashdata('strErrorMsg','Work Suspension already exists.');
					$this->session->set_flashdata('dtmSuspensionDate',$dtmSuspensionDate);
					$this->session->set_flashdata('dtmSuspensionTime',$dtmSuspensionTime);
					redirect('libraries/holiday/add_worksuspension');
				}
			}
		}
    }

    public function edit_worksuspension()
	{
		$arrPost = $this->input->post();
		//print_r($arrPost);
		if(empty($arrPost))
		{
			$intHolidayId = urldecode($this->uri->segment(4));
			$this->arrData['arrHoliday'] = $this->holiday_model->getData();
			$this->arrData['arrWorkSuspend'] = $this->holiday_model->getWorkSuspension($intHolidayId);
			$this->arrData['arrSuspendData'] = $this->holiday_model->getWorkSuspension(urldecode($this->uri->segment(4)));
			$this->template->load('template/template_view','libraries/holiday/edit_worksuspension_view', $this->arrData);
		}
		else
		{
			$intHolidayId = $arrPost['intHolidayId'];
			$dtmSuspensionDate = $arrPost['dtmSuspensionDate'];
			$dtmSuspensionTime = $arrPost['dtmSuspensionTime'];
			if(!empty($dtmSuspensionDate) && !empty($dtmSuspensionTime))
			{	
				$arrData = array(
						'holidayDate'=>$dtmSuspensionDate,
						'holidayTime'=>$dtmSuspensionTime
					
				);
				$blnReturn = $this->holiday_model->save_worksuspension($arrData, $intHolidayId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHolidayYear','Edited '.$dtmSuspensionDate.' Holiday',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Work Suspension saved successfully.');
				}
				redirect('libraries/holiday/add_worksuspension');
			}
		}
	}


	public function delete_worksuspension()
	{
		//$strDescription=$arrPost['strDescription'];
		$arrPost = $this->input->post();
		$intHolidayId = $this->uri->segment(4);
		if(empty($arrPost))
		{
			$this->arrData['arrData'] = $this->holiday_model->getWorkSuspension($intHolidayId);
			$this->template->load('template/template_view','libraries/holiday/delete_worksuspension_view',$this->arrData);
		}
		else
		{
			$intHolidayId = $arrPost['intHolidayId'];
			$dtmHolidayDate = $arrPost['dtmHolidayDate'];
			$dtmHolidayTime = $arrPost['dtmHolidayTime'];
			$arrData=$this->holiday_model->getWorkSuspension($intHolidayId);
			if(!empty($intHolidayId))
			{
				$blnReturn = $this->holiday_model->delete_worksuspension($intHolidayId);
				if(count($blnReturn)>0)
				{
					log_action($this->session->userdata('sessEmpNo'),'HR Module','tblHoliday','Deleted '.$dtmHolidayDate.','.$dtmHolidayTime.'Holiday',implode(';',$arrData),'');
					$this->session->set_flashdata('strSuccessMsg','Holiday deleted successfully.');
				}
				redirect('libraries/holiday/add_worksuspension');
			}
		}		
	}


}
