<?php

/**
 * SystemName: Dost International S&T Linkages Database System
 * 
 * Author: Maychell M. Alcorin
 * 
 * Copyright (C) 2018 by the Department of Science and Technology Central Office
*/
class Remittances extends CI_Model {

	public function __construct()
	{
		$this->load->model(array('Remittance_model','finance/Deduction_model','finance/Signatory_model'));
		$this->load->library('Fpdf_gen');
		$this->fpdf = new FPDF();
	}

	function generate()
	{
		$deduct_details = $this->Deduction_model->getData($_GET['remitt']);
		$empno = ($_GET['empno'] == '' || $_GET['empno'] == '0') ? '' : $_GET['empno'];
		$appt = isset($_GET['appt'] ) ? ($_GET['appt'] == '' || $_GET['appt'] == '0') ? '' : $_GET['appt'] : '';
		$remittances = $this->Remittance_model->getRemittance($empno, $_GET['remitt'], $_GET['remit_fr'], $_GET['remit_to'],$appt);
		$signatory = $this->Signatory_model->getSignatories($_GET['sign']);

		$this->fpdf->AddPage('P');

		# Begin Header
		$this->fpdf->Image('assets/images/logo.png',10,10,20,20);
		$this->fpdf->SetFont('Times','',12);
		$this->fpdf->Cell(25);
		$this->fpdf->Cell(0,10,'Republic of the Philippines',0,0,'L');
		$this->fpdf->Ln(7);
		$this->fpdf->SetFont('Arial','B',14);
		$this->fpdf->Cell(25);
		$this->fpdf->Cell(0,8,'DOST',0,0,'L');
		$this->fpdf->SetTextColor(0,0,0);

		$this->fpdf->SetFont('Arial','B',12);
		$this->fpdf->Ln(15);
		$this->fpdf->Cell(0, 6,"Remittance List", 0, 1, "C");
		$this->fpdf->SetFont('Arial','B',11);
		$this->fpdf->Cell(0, 6,count($deduct_details) > 0 ? $deduct_details['deductionDesc'] : '', 0, 1, "C");
		$this->fpdf->Cell(0, 6,"From ".$_GET['remit_fr']." to ".$_GET['remit_to'], 0, 1, "C");
		$this->fpdf->Ln(5);

		$name = strtoupper(employee_name($_GET['empno']));
		$this->fpdf->SetFont('Arial','B');
		$this->fpdf->SetX(34);
		$this->fpdf->Cell(15,5,"Name :",0,0,"L");
		$this->fpdf->SetFont('Arial','');
		$this->fpdf->Cell(160,5,$name == '' ? $appt : $name,0,0,"L");
		$this->fpdf->Ln(10);
		# End Header

		# Begin Table header
		$this->fpdf->SetFont('Arial','B',10);
		$this->fpdf->SetX(34);
		$this->fpdf->Cell(20,6,"No",1,0,"C");
		$this->fpdf->Cell(45,6,"Month",1,0,"C");
		$this->fpdf->Cell(35,6,"Year",1,0,"C");
		$this->fpdf->Cell(45,6,"Amount",1,1,"R");
		# End Table header

		# Begin Table body
		$this->fpdf->SetFont('Arial','',9);
		$no = 1;
		$totalRemittance = 0;
		foreach($remittances as $remitt):
			$total_period = $remitt['period1'] + $remitt['period2'] + $remitt['period3'] + $remitt['period4'];
			$totalRemittance = $totalRemittance + $total_period;
			if($total_period > 0):
				$this->fpdf->SetX(34);
				$this->fpdf->Cell(20,5,$no++,1,0,"C");
				$this->fpdf->Cell(45,5,date('M', mktime(0, 0, 0, $remitt['deductMonth'], 10)),1,0,"C");
				$this->fpdf->Cell(35,5,$remitt['deductYear'],1,0,"C");
				$this->fpdf->Cell(45,5,number_format($total_period, 2),1,1,"R");
			endif;
		endforeach;
		$this->fpdf->SetFont('Arial','B');
		$this->fpdf->SetX(34);
		$this->fpdf->Cell(100, 6,"Grand Total",1,0,"R");
		$this->fpdf->Cell(45, 6,number_format($totalRemittance, 2),1,0,"R");
		# End Table body


		# Begin Table Footer
		if(check_module() == 'payroll'):
			$this->fpdf->SetFont('Arial','',11);
			$this->fpdf->Ln(15);
			$this->fpdf->Cell(0,6,'CERTIFIED CORRECT:',0,0,'L');
			$this->fpdf->Ln(15);
			$this->fpdf->SetFont('Arial','B');
			$this->fpdf->Cell(0,6,ucwords($signatory['signatory']),0,1,'L');
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Cell(0,6,ucwords($signatory['signatoryPosition']),0,0,'L');
		endif;
		# End Table Footer

		$this->fpdf->Output();
	}

}