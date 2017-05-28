<?php
/*
------------------------------------------------------------
 Luxi - Simple PHP Framework
------------------------------------------------------------
 Version : 1.9.01
 By : Muhammad Faruq Nuruddinsyah
 Division of D-Webs - DaftLabs, Dafturn Technology
------------------------------------------------------------
 License : GNU/LGPL (GNU Lesser GPL)
 Home Page : http://dafturn.org/daftlabs/dwebs/luxi
------------------------------------------------------------
 Copyright 2011. All Rights Reserved.
------------------------------------------------------------
 Library : Error Tracer & Handler
------------------------------------------------------------
*/

function show_error($message){
	$content = read_file(BASE_PATH . LUXI_ERROR);
			
	echo str_replace("%message%", $message, $content);
	exit();
}

function error_mysql_connection(){
	header('location:' . BASE_PATH . LUXI_ERROR_MYSQL_CONNECTION);
	exit();
}

function error_mysql_database(){
	header('location:' .BASE_PATH . LUXI_ERROR_MYSQL_DATABASE);
	exit();
}

function error_handler($errno, $errstr, $errfile, $errline){
	$content = read_file(BASE_PATH . LUXI_ERROR_PHP);
	$abort = false;
	
	if(!(error_reporting() & $errno)){
		// This error code is not included in error_reporting
		return;
	}
	
	switch($errno){
		case E_USER_ERROR: case E_ERROR:
			$err_type = 'PHP Fatal Error';
			$abort = true;
			break;
		case E_USER_WARNING: case E_WARNING:
			$err_type = 'PHP Warning';
			break;
		case E_USER_NOTICE: case E_NOTICE:
			$err_type = 'PHP Notice';
			break;
		default:
			$err_type = 'PHP Unknown Error';
			break;
	}
	
	$content = str_replace("%error_type%", $err_type, $content);
	$content = str_replace("%message%", $errstr, $content);
	$content = str_replace("%file%", $errfile, $content);
	$content = str_replace("%line%", $errline, $content);
	
	echo $content;
	if($abort) exit(1);
	
	return true;
}

?>
