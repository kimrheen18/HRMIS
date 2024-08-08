<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH.'third_party/fpdf/fpdf-1.7.php';

    class Payroll_register_template extends FPDF {

    	function __construct() {
    	    parent::__construct();
    	    $this->project_code = '';
    	}

        function Header()
        {
        	$CI =& get_instance();
        	$CI->load->helper('report_helper');
        	$this->AliasNbPages();
        	$this->SetLeftMargin(4);
        	$this->SetAutoPageBreak(true,35);
            $this->SetFont('Arial','B',9);
			$this->cell(135,5,strtoupper(getAgencyName()),0,0,'L');
			$this->SetFont('Arial','',9);
			$this->cell(135,5,'Page '.$this->PageNo().' of {nb}',0,1,'R');

			$this->ln(8);
			$this->SetFont('Arial','B',9);
			$this->cell(0,5,'PAYROLL REGISTER',0,1,'C');

			$this->ln(8);
			$this->SetFont('Arial','B',8);
			$this->cell(0,5,'   '.$this->project_code,0,1,'L');
			$this->cell(25,5,'Employee No',1,0,'C');
			$this->cell(25,5,'Employee Name',1,0,'C');
			$this->cell(45,5,'Office/Division/Section/Unit',1,0,'C');
			$this->cell(24,5,'Basic Monthly',1,0,'C');
			$this->cell(24,5,'Period Pay',1,0,'C');
			$this->cell(24,5,'Undertime/Abs',1,0,'C');
			$this->cell(24,5,'Overtime',1,0,'C');
			$this->cell(24,5,'Gross Pay',1,0,'C');
			$this->cell(24,5,'Benefits',1,0,'C');
			$this->cell(24,5,'Deductions',1,0,'C');
			$this->cell(24,5,'Net Pay',1,1,'C');
        }

        function Footer()
        {
        	$this->SetY(-35);
        	$this->SetFont('Arial','',8);
        	$this->Cell(0,10,'I certify on my oath that the services of the above-mentioned employees have been duly rendered as stated.',0,1,'L');
        	$this->ln(4);
        	$this->SetFont('Arial','B',8);
        	$this->cell(40,5,'',0,0,'C');
        	$this->cell(94,5,'1ST SIGNATORY','T',0,'C');
        	$this->cell(20,5,'',0,0,'C');
        	$this->cell(94,5,'2ND SIGNATORY','T',0,'C');
        	$this->cell(40,5,'',0,1,'C');
        	#
        	$this->SetFont('Arial','',8);
        	$this->cell(40,5,'',0,0,'C');
        	$this->cell(94,5,'Position',0,0,'C');
        	$this->cell(20,5,'',0,0,'C');
        	$this->cell(94,5,'Position',0,0,'C');
        	$this->cell(40,5,'',0,1,'C');

        }

        function setproject_code($project_code){
			$this->project_code = $project_code;
		}

    }