<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PanunumpaSaKatungkulan_model extends CI_Model {

	var $w=array(70,70,60,60);

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('report_helper');
	}
	
	public function Header()
	{

	}
	
	function Footer()
	{		
		$this->fpdf->SetFont('Arial','',7);	
		$this->fpdf->Cell(50,3,date('Y-m-d h:i A'),0,0,'L');
		$this->fpdf->Cell(0,3,"Page ".$this->fpdf->PageNo(),0,0,'R');
	}

	function getSQLData($t_strEmpNmbr="",$t_strOfc="")
	{
		

		$this->db->select('tblEmpPersonal.empNumber, tblEmpPersonal.surname, 
			tblEmpPersonal.firstname, tblEmpPersonal.middlename,tblEmpPersonal.middleInitial,tblEmpPersonal.nameExtension, tblEmpPersonal.sex, 
			tblPosition.positionDesc, 
			tblEmpPersonal.comTaxNumber, tblEmpPersonal.issuedAt, 
			tblEmpPersonal.issuedOn, tblEmpPosition.positionDate,tblAppointment.appointmentDesc,
			tblEmpPosition.firstDayAgency');

		$this->db->join('tblEmpPosition','tblEmpPersonal.empNumber = tblEmpPosition.empNumber','inner');
		$this->db->join('tblPosition','tblEmpPosition.positionCode = tblPosition.positionCode','inner');
		$this->db->join('tblAppointment','tblAppointment.appointmentCode=tblEmpPosition.appointmentCode','inner');
		
		//$this->db->where('tblEmpPosition.statusOfAppointment','In-Service');
		//$this->db->where('(tblEmpPosition.detailedfrom="2" OR tblEmpPosition.detailedfrom=0)');
		
		if($t_strEmpNmbr!='')
			$this->db->where('tblEmpPersonal.empNumber',$t_strEmpNmbr);
		if($t_strOfc!='')
			$this->db->where('tblEmpPosition.group3',$t_strOfc);
		$this->db->order_by('tblEmpPersonal.surname, tblEmpPersonal.firstname');
		$objQuery = $this->db->get('tblEmpPersonal');
		//echo $this->db->last_query();exit(1);
		return $objQuery->result_array();
	}

	function generate($arrData)
	{		
		
		//print_r($arrData); exit(1);
		$t_arrEmpInfo = $this->getSQLData($arrData['strSelectPer']==1?$arrData['empno']:'',$arrData['strSelectPer']==2?$arrData['ofc']:'');
		//print_r($t_arrEmpInfo);exit(1);
		if(count($t_arrEmpInfo)>0)
		{
			for($i=0;$i<sizeof($t_arrEmpInfo);$i++)		
			{
				$this->fpdf->AddPage('P','A4');
				$this->fpdf->Ln(18);
				$this->fpdf->SetFont('Arial','B',10);
				$extension = (trim($t_arrEmpInfo[$i]['nameExtension'])=="") ? "" : " ".$t_arrEmpInfo[$i]['nameExtension'];		
				$strName = $t_arrEmpInfo[$i]['firstname']." ".mi($t_arrEmpInfo[$i]['middleInitial']).$t_arrEmpInfo[$i]['surname'].$extension;	
				$strName = utf8_decode($strName);
			
				$strPrgrph1 = "     Ako, si ".strtoupper($strName)
							." ng ".strtoupper(getAgencyName())." na (hinirang/itinalaga) sa katungkulan bilang ".$t_arrEmpInfo[$i]['positionDesc']." ay taimtim na nanunumpa na tutuparin"
							." kong buong husay at katapatan, sa abot na aking kakayahan, ang mga tungkulin ng"
							." aking kasalukuyang katungkulan at ng mga iba pang pagkaraan nito'y gagampanan ko sa"
							." ilalim ng Republika ng Pilipinas; na aking itataguyod at ipagtatanggol ang"
							." Konstitusyon ng Pilipinas; na tunay na mananalig at tatalima ako rito; na susundin"
							." ko ang mga batas, mga kautusang legal, at mga dekretong pinaiiral ng mga sadyang"
							." itinakdang may kapangyarihan ng Republika ng Pilipinas; at kusang babalikatin"
							." ang pananagutang ito, nang walang ano mang pasubali o hangaring umiwas.";
				
				/*$strPrgrph2 = "     Nilagdaan at pinanumpaan sa harap ko ngayon ika ".date("j")
							." ng ".$this->intToBuwan(date("n"))." ".date("Y").", A.D., sa Bicutan, Taguig, Metro Manila, Pilipinas.";					*/
				$strPrgrph2 = "     Nilagdaan at pinanumpaan sa harap ko ngayong ika ";
				$strPrgrph3 = " ng ";
				$strPrgrph4 = " ";
				$strPrgrph5 = " sa ".$arrData['strNilagdaan'].".";
				
				$this->fpdf->SetFont('Arial', "", 12);	
				$this->fpdf->Cell(0, 5, "Pormulasyong S.S. Blg. 32", 0, 0, "L");
				$this->fpdf->Ln(10);
				$this->fpdf->SetFont('Arial', "", 14);
				$this->fpdf->Cell(0, 5, "Republika ng Pilipinas", 0, 1, "C");
				$this->fpdf->Cell(0, 5, "KOMISYON NG SERBISYO SIBIL", 0, 0, "C");
				$this->fpdf->Ln(10);
				$this->fpdf->SetFont('Arial', "B", 16);
				$this->fpdf->Cell(0, 5, "PANUNUMPA SA KATUNGKULAN", 0, 0, "C");

				$this->fpdf->Ln(15);
				$this->fpdf->SetFont('Arial', "", 12);
				$this->fpdf->MultiCell(0, 8, $strPrgrph1, 0, 'J', 0);
				
				$this->fpdf->Ln(2);
				$this->fpdf->Cell(0, 5, "             KASIHAN NAWA AKO NG DIYOS.", 0, 0, "L");
				$this->fpdf->Ln(15);
				$this->fpdf->SetFont('Arial', "B", 12);
				$this->fpdf->Cell(100);
				$this->fpdf->Cell(0, 5, strtoupper($strName), 0, 1, "C");

				$this->fpdf->Ln(15);
				$this->fpdf->Cell(0, 5, "__ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ ", 0, 0, "C");
				$this->fpdf->Ln(10);
				$this->fpdf->SetFont('Arial', "", 12);
				$this->fpdf->Ln(5);
				$arrDate = explode('-',$arrData['dtmDate']);
				$this->fpdf->Write(5, $strPrgrph2);
				$this->fpdf->Write(5, $arrDate[2]);
				$this->fpdf->Write(5, $strPrgrph3);
				$this->fpdf->Write(5, intToBuwan(($arrDate[1]+0)));
				$this->fpdf->Write(5, $strPrgrph4);
				$this->fpdf->Write(5, $arrDate[0]);
				$this->fpdf->Write(5, $strPrgrph5);

				/* Signatory */
				 if($this->fpdf->GetY()>195)
					 $this->fpdf->AddPage();
					 
				
					
				$this->fpdf->Ln(20);
				$this->fpdf->Cell(30);
				$this->fpdf->Cell(30);				
				$this->fpdf->SetFont('Arial','B',12);		
				$this->fpdf->Cell(0,10,"Certified Correct:",0,0,'L');
				

				$sig=getSignatories($arrData['intSignatory']);
				if(count($sig)>0)
				{
					$sigName = $sig[0]['signatory'];
					$sigPos = $sig[0]['signatoryPosition'];
				}
				else
				{
					$sigName='';
					$sigPos='';
				}
				$this->fpdf->Ln(20);
				$this->fpdf->Cell(30);
				$this->fpdf->Cell(30);				
				$this->fpdf->SetFont('Arial','B',12);		
				$this->fpdf->Cell(0,10,$sigName,0,0,'L');

				$this->fpdf->Ln(4);
				$this->fpdf->Cell(30);
				$this->fpdf->Cell(30);				
				$this->fpdf->SetFont('Arial','',12);				
				$this->fpdf->Cell(0,10,$sigPos,0,0,'L');
				
				$this->fpdf->Ln(4);
				$this->fpdf->Cell(30);
				$this->fpdf->Cell(30);				
				$this->fpdf->SetFont('Arial','',12);				
				//$this->fpdf->Cell(0,10,$sig[0],0,0,'L');
				$this->fpdf->Ln(15);
					
				$this->fpdf->SetFont('Arial', "", 11);
				
				/*
				$this->Cell(20);
				$this->Cell(0, 5, "Com. Tax. Cert. No. ".$t_arrEmpInfo["comTaxNumber"], 0, 1, "L");
				$this->Cell(20);
				$this->Cell(0, 5, "Issued on ".$t_arrEmpInfo["issuedAt"], 0, 1, "L");
				$this->Cell(20);
				$this->Cell(0, 5, "Issued ".$t_arrEmpInfo["issuedOn"], 0, 1, "L");
				*/
				$this->fpdf->Cell(40);
				$this->fpdf->Cell(30, 5, "Sedula, Klase A ", 0, 0, "R");
				$this->fpdf->SetFont('Arial', "U", 11);
				$this->fpdf->Cell(30, 5, $arrData['strSedula'], 0, 1, "L");
				$this->fpdf->Cell(40);
				$this->fpdf->SetFont('Arial', "", 11);
				$this->fpdf->Cell(30, 5, "Kinuha sa ", 0, 0, "R");
				$this->fpdf->SetFont('Arial', "U", 11);
				$this->fpdf->Cell(30, 5, $arrData['strKinuha'], 0, 1, "L");
			}
		}

		echo $this->fpdf->Output();
	}
	
}
/* End of file ListEmployeesTraining_model.php */
/* Location: ./application/modules/reports/models/reports/ListEmployeesTraining_model.php */