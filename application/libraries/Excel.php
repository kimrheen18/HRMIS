<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  PHPExcel
* 
* Author: Jd Fiscus
* 	 	  jdfiscus@gmail.com
*         @iamfiscus
*          
* 
* Location: https://github.com/PHPOffice/PHPExcel
*          
* 
* Description:  This is a Codeigniter library which exports the data to excel file
* 
*/

require_once APPPATH."/third_party/PHPExcel/Classes/PHPExcel.php";
  
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}