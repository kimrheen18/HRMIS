<?php

function doAuthenticate() {
    if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW'])) {

        if ($_SERVER['PHP_AUTH_USER'] == "hrmisv10" && $_SERVER['PHP_AUTH_PW'] == "!7D$0@9"):
            return true;
        else:
            return false;
        endif;
    }
}

function getData($empno)
{
	if (!doAuthenticate()):
    	return "Invalid Authentication";
    else:
		$dir = explode('/',dirname(dirname(__FILE__)));
		if(isset($_SERVER['HTTPS'])){
	        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	    }
	    else{
	        $protocol = 'http';
	    }
	    $url = $protocol . "://" . $_SERVER['HTTP_HOST'] .'/'. end($dir);

		$json = file_get_contents($url.'/xml/api?fingerprint=!7D$0@9&empid='.$empno);
		
		header('content-type: application/json; charset=latin1');
		return $json;
	endif;
}

function getEmployees()
{
	if (!doAuthenticate()):
    	return "Invalid Authentication";
    else:
		$dir = explode('/',dirname(dirname(__FILE__)));
		if(isset($_SERVER['HTTPS'])){
	        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	    }
	    else{
	        $protocol = 'http';
	    }
	    $url = $protocol . "://" . $_SERVER['HTTP_HOST'] .'/'. end($dir);

		$json = file_get_contents($url.'/xml/api?fingerprint=!7D$0@9');
		
		header('content-type: application/json; charset=latin1');
		return $json;
	endif;
}

function getDivisions()
{
	if (!doAuthenticate()):
    	return "Invalid Authentication";
    else:
		$dir = explode('/',dirname(dirname(__FILE__)));
		if(isset($_SERVER['HTTPS'])){
	        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	    }
	    else{
	        $protocol = 'http';
	    }
	    $url = $protocol . "://" . $_SERVER['HTTP_HOST'] .'/'. end($dir);

		$json = file_get_contents($url.'/xml/api/divisions/?fingerprint=!7D$0@9');
		
		header('content-type: application/json; charset=latin1');
		return $json;
	endif;
}

function getGroups()
{
	if (!doAuthenticate()):
    	return "Invalid Authentication";
    else:
		$dir = explode('/',dirname(dirname(__FILE__)));
		if(isset($_SERVER['HTTPS'])){
	        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	    }
	    else{
	        $protocol = 'http';
	    }
	    $url = $protocol . "://" . $_SERVER['HTTP_HOST'] .'/'. end($dir);

		$json = file_get_contents($url.'/xml/api/groups/?fingerprint=!7D$0@9');
		
		header('content-type: application/json; charset=latin1');
		return $json;
	endif;
}

include('nusoap/lib/nusoap.php');

error_reporting(0);
$server = new soap_server();
$server->configureWSDL('hrmis_api_users', 'urn:details');
$server->register("getData", array('empno' => 'xsd:string'), array('return' => 'xsd:string'), 'urn:details', 'urn:details#getData');
$server->register("getEmployees", array('empno' => 'xsd:string'), array('return' => 'xsd:string'), 'urn:details', 'urn:details#getEmployees');
$server->register("getDivisions", array('empno' => 'xsd:string'), array('return' => 'xsd:string'), 'urn:details', 'urn:details#getDivisions');
$server->register("getGroups", array('empno' => 'xsd:string'), array('return' => 'xsd:string'), 'urn:details', 'urn:details#getGroups');


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service(file_get_contents("php://input"));
