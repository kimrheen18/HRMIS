<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollProcess extends MY_Controller {

	var $arrData;

	function __construct() {
        parent::__construct();
        $this->load->model(array('ProjectCode_model', 'libraries/Appointment_status_model', 'Process_model'));
    }

	public function index()
	{
		$arrPayroll = $this->Process_model->getProcessData();
		foreach($arrPayroll as $key => $payroll):
			$pprocess = array();
			foreach(explode(',', $payroll['processWith']) as $procwith):
				$process = $this->Appointment_status_model->getData($procwith);
				if(count($process) > 0):
					array_push($pprocess, $process[0]['appointmentDesc']);
				endif;
			endforeach;
			$arrPayroll[$key]['process_with'] = implode(', ', $pprocess);
		endforeach;

		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrPayrollProc'] = $arrPayroll;
		$this->template->load('template/template_view','finance/libraries/payrollprocess/payrollprocess_view',$this->arrData);
	}

	public function add()
	{
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'appointmentCode' => $arrPost['selappointment'],
				'processWith' => implode(',', $arrPost['selprocesswith']),
				'computation' => $arrPost['selsalary']
			);
			
			if(!$this->Process_model->isCodeExists($arrPost['selappointment'],'add')):
				$this->Process_model->add($arrData);
				$this->session->set_flashdata('strSuccessMsg','Payroll process added successfully.');
				redirect('finance/libraries/payrollprocess');
			else:
				$this->arrData['err'] = 'Code already exists';
			endif;
		endif;

		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();

		$this->arrData['action'] = 'add';
		$this->template->load('template/template_view','finance/libraries/payrollprocess/payrollprocess_add',$this->arrData);
	}

	public function edit()
	{
		$id = $this->uri->segment(5);
		$arrPost = $this->input->post();
		if(!empty($arrPost)):
			$arrData = array(
				'processWith' => implode(',', $arrPost['selprocesswith']),
				'computation' => $arrPost['selsalary']
			);
			$this->Process_model->edit($arrData, $id);
			$this->session->set_flashdata('strSuccessMsg','Payroll process updated successfully.');
			redirect('finance/libraries/payrollprocess');
		endif;
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrData'] = $this->Process_model->getProcessData($id);

		$this->arrData['action'] = 'edit';
		$this->template->load('template/template_view','finance/libraries/payrollprocess/payrollprocess_add',$this->arrData);
	}

	public function delete_process()
	{
		$id = $this->uri->segment(5);
		$this->arrData['arrAppointments'] = $this->Appointment_status_model->getData();
		$this->arrData['arrData'] = $this->Process_model->getProcessData($id);

		$this->arrData['action'] = 'delete';
		$this->template->load('template/template_view','finance/libraries/payrollprocess/payrollprocess_add',$this->arrData);
	}

	public function delete()
	{
		$this->load->model('Check_exists_model');
		$arrget = $this->input->get();
		$id = $this->uri->segment(5);
		if($this->Check_exists_model->check_payroll_process($arrget['code']) > 0):
			$this->session->set_flashdata('strMsg','Payroll process is unable to delete. Contact administrator.');
		else:
			$this->Process_model->delete($id);
			$this->session->set_flashdata('strSuccessMsg','Payroll process successfully deleted.');
		endif;
		redirect('finance/libraries/payrollprocess');
	}


}
