 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qr extends MY_Controller {
	var $arrData;
	function __construct() {
        parent::__construct();
        $this->load->model(array('Hr_model'));
    }

	public function generate()
	{
		$this->load->library('ciqrcode');
		$rs = $this->Hr_model->getData();
		//print_r($rs);
		foreach($rs as $row):
			$qr_image=$row['empNumber'].'.png';
			echo $qr_image."<br>";
			//url
			// $strData = 'http://10.10.10.54/hrmis/scanqr/index.php?empNo='.$row['empNumber'];
			$strData = 'http://hrmis.dost.gov.ph/scanqr/index.php?empNo='.$row['empNumber'];
			$params['data'] = $strData;
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."uploads/qr/".$qr_image;
			print_r($params);
			if($this->ciqrcode->generate($params))
			{
				//$this->arrTemplateData['img_url']=$qr_image;
				//Set QR Code value in DB
				//$arrData = array('reg_qr_code'=>$qr_image);
				echo '<img src="'.base_url('uploads/qr/'.$qr_image).'">';
			}
		endforeach;
	}

	public function print()
	{
		//$this->fpdf->AddPage('P','A4');
		require_once APPPATH.'third_party/fpdf/fpdf-1.7.php';
		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();
		$this->fpdf = $pdf;
		
		$rs=$this->Hr_model->getData();
		
		$this->fpdf->SetFont('Arial','',10);
		$x=8;$y=8;
		$w=30;
		$arrAligns = array('C');
		$arrWidth = array(30);
		$this->fpdf->SetWidths($arrWidth);
		$this->fpdf->SetAligns($arrAligns);
		
		$height=30;$i=0;$ctr=0;
		// $arrEmp=array('0516-CO0-2018','2528-CO0-2018','2503-CO0-2018','3528-CO0-2018','0703-CO0-2017','0019-CO0-2018','0001-GAA-2018','0301-CO0-2018','1292-CO0-2007','0015-CO0-2018','0528-CO0-2018','0003-GAA-2018','1290-CO0-2004','0011-CO0-2018','2018-DOST-TRC-00103','1633-TRCDOST-2016','1630-TRCDOST-2016','2018-DOST-TRC-00101','0018-CO0-2018','1301-CO0-2008','1302-CO0-2008','1218-CO0-2000','0313-CO0-2012','2516-CO0-2016','0004-CO0-2012','0003-CO0-2016','0003-CO0-2009','0007-CO0-2015','0016-CO0-2016','0007-CO0-2017','0015-CO0-2016','0030-CO0-2016','0019-GAA-2017','0003-DOSTTRC-2017');
		
		// additional
		$arrEmp=array('1302-CO0-2009','0618-CO0-2018','0009-CO0-2018');
		foreach($rs as $row):
			$strQRCode = $row['empNumber'].'.png';

			if(@getimagesize(base_url('uploads/qr/'.$strQRCode))!='' && in_array($row['empNumber'],$arrEmp))
		//if(@getimagesize(base_url('uploads/qr/'.$strQRCode))!='')
			{
				$img = base_url('uploads/qr/'.$strQRCode);
				
				//print qr code
				$qrcode_img = $this->fpdf->Image($img,$this->fpdf->GetX(),$this->fpdf->GetY(),$w,$height);
				$this->fpdf->Cell($arrWidth[0],$height,$qrcode_img,1,0,'C');
				
				//print employee number
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->setXY($this->fpdf->GetX()-$w,$this->fpdf->GetY()+($height));
				$this->fpdf->Cell($arrWidth[0],7,$row['surname'].', '.$row['firstname'],1,0,'C');
				
				//$this->fpdf->Cell($arrWidth[0],5,'x='.$this->fpdf->GetX().'|y='.$this->fpdf->GetY(),1,0,'C');
				$this->fpdf->setXY($this->fpdf->GetX(),$this->fpdf->GetY()-30);
				
				$ctr++;$i++;
				if($ctr==6)
				{
					$this->fpdf->Ln(37);$ctr=0;
					//$this->fpdf->setXY(10.00125+$w,30.00125);
				}
				if($i==42)
				{
					$this->fpdf->AddPage();$i=0;
				}
			}
			//$this->fpdf->Cell(0,5,$row['prf_lastname'],0,1,'C');
		endforeach;
		
		//$pdf->Image(base_url('uploads/qr_image/.png',10,10,-300);
		echo $this->fpdf->Output();
	}

	public function print_official()
	{
		//$this->fpdf->AddPage('P','A4');
		require_once APPPATH.'third_party/fpdf/fpdf-1.7.php';
		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();
		$this->fpdf = $pdf;
		
		$rs=$this->Hr_model->getData();
		
		$this->fpdf->SetFont('Arial','',10);
		$x=8;$y=8;
		$w=30;
		$arrAligns = array('C');
		$arrWidth = array(30);
		$this->fpdf->SetWidths($arrWidth);
		$this->fpdf->SetAligns($arrAligns);
		
		$height=30;$i=0;$ctr=0;
		$arrEmp=array('0701-CO0-2016','0126-CO0-2017','1136-CO0-1998','0305-CO0-2015','0306-CO0-2017','1128-CO0-2016','0907-CO0-2016',' 0306-CO0-2017','1006-CO0-2016','1047-CO0-1991',' 0106-CO0-2014','1031-CO0-1993','1201-CO0-2014', '0106-CO0-2014');
		foreach($rs as $row):
			$strQRCode = $row['empNumber'].'.png';

			if(@getimagesize(base_url('uploads/qr/'.$strQRCode))!='' && in_array($row['empNumber'],$arrEmp))
		//if(@getimagesize(base_url('uploads/qr/'.$strQRCode))!='')
			{
				$img = base_url('uploads/qr/'.$strQRCode);
				
				//print qr code
				$qrcode_img = $this->fpdf->Image($img,$this->fpdf->GetX(),$this->fpdf->GetY(),$w,$height);
				$this->fpdf->Cell($arrWidth[0],$height,$qrcode_img,1,0,'C');

				//print space
				$this->fpdf->Cell(20,$height,'',0,0,'C');
				
				//print employee number
				$this->fpdf->SetFont('Arial','',7);
				$this->fpdf->setXY($this->fpdf->GetX()-$w-20,$this->fpdf->GetY()+($height));
				$strName = $row['surname'].', '.$row['firstname'];
				$strName = utf8_decode($strName);
				$this->fpdf->Cell($arrWidth[0],7,$strName,1,0,'C');
				
				//$this->fpdf->Cell($arrWidth[0],5,'x='.$this->fpdf->GetX().'|y='.$this->fpdf->GetY(),1,0,'C');
				$this->fpdf->setXY($this->fpdf->GetX()+15,$this->fpdf->GetY()-30);
				
				$ctr++;$i++;
				if($ctr==4)
				{
					$this->fpdf->Ln(47);$ctr=0;
					//$this->fpdf->setXY(10.00125+$w,30.00125);
				}
				if($i==20)
				{
					$this->fpdf->AddPage();$i=0;
				}
			}
			//$this->fpdf->Cell(0,5,$row['prf_lastname'],0,1,'C');
		endforeach;
		
		//$pdf->Image(base_url('uploads/qr_image/.png',10,10,-300);
		echo $this->fpdf->Output();
	}
}