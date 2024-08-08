<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  FPDF
* 
* Author: Jd Fiscus
* 	 	  jdfiscus@gmail.com
*         @iamfiscus
*          
*
* Origin API Class: http://www.fpdf.org/
* 
* Location: http://github.com/iamfiscus/Codeigniter-FPDF/
*          
* Created:  06.22.2010 
* 
* Description:  This is a Codeigniter library which allows you to generate a PDF with the FPDF library
* 
*/

class Fpdf_gen {
		
	public function __construct() {
		
		require_once APPPATH.'third_party/fpdf/fpdf-1.7.php';
		
		$pdf = new FPDF();
		//$pdf->AddPage();
		
		$CI =& get_instance();
		$CI->fpdf = $pdf;
		
	}

	function Footer()
    {
    	$CI =& get_instance();
        // Go to 1.5 cm from bottom
        $CI->fpdf->SetY(-15);
        // Select Arial italic 8
        $CI->fpdf->SetFont('Arial','I',8);
        // Print centered page number
        $CI->fpdf->Cell(0,10,'Page '.$CI->fpdf->PageNo(),0,0,'C');
    }
	
}