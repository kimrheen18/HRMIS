<?php
class Common_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();		
		//$this->load->model(array());
	}

	function getAgencyName()
    {
        // $obj=new General;
        // $sql = "SELECT agencyName FROM tblAgency";
        // $result = mysql_query($sql);    
        // $row=mysql_fetch_array($result);
        // return $row['agencyName'];
    }
    
    function getSalutation($t_strGender)
    {
        if($t_strGender == 'F')
        {
            return "Madam";
        }
        else
        {
            return "Sir";
        }   
    }
    
    function pronoun($t_strGender)
    {
        if($t_strGender == 'F')
        {
            return "Her";
        }
        else
        {
            return"Him";
        }   
    }
    
    function pronoun2($t_strGender)
    {
        if($t_strGender == 'F')
        {
            return "Her";
        }
        else
        {
            return"His";
        }   
    }
    
    function titleOfCourtesy($t_strGender)
    {
        if($t_strGender == 'F')
        {
            return "Ms.";
        }
        else
        {
            return"Mr.";
        }
    }
    
    function numOrder($numYears)
    {
    	$arr=array(1=>"First",2=>"Second",3=>"Third",4=>"Fourth",
               5=>"Fifth",6=>"Sixth",7=>"Seventh",8=>"Eighth",
               9=>"Ninth",10=>"Tenth",11=>"Eleventh",12=>"Twelfth",
               13=>"Thirteenth",14=>"Fourteenth");
    	return $arr["$numYears"];
    }
    
    function intToBuwan($t_intMonth)
    {
        $arrMonths = array(1=>"Enero", 2=>"Pebrero", 3=>"Marso", 
                        4=>"Abril", 5=>"Mayo", 6=>"Hunyo", 
                        7=>"Hulyo", 8=>"Agosto", 9=>"Septembre", 
                        10=>"Oktubre", 11=>"Nobyembre", 12=>"Disyembre");
        return $arrMonths[$t_intMonth];
    }
}