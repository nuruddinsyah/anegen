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
 Bootstrap
------------------------------------------------------------
*/


// Initialize session data

session_start();


// Load configurations and libraries

include(BASE_PATH . 'system/core/config.php');
include(BASE_PATH . 'system/core/libraries.php');


// Set error handler

set_error_handler('error_handler');


// Switch SSL on or off

if(USE_SSL==true && $_SERVER['SERVER_PORT']!=443){
	$secure_location = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	header("location: " . $secure_location);
	exit();
}


// Turning on auto-call user function

if(AUTO_CALL_FUNCTION){
	if(isset($_GET['func']) || isset($_GET['function']) || isset($_POST['func']) || isset($_POST['function'])){
		if(isset($_GET['func'])) $function = $_GET['func'];
		if(isset($_GET['function'])) $function = $_GET['function'];
		if(isset($_POST['func'])) $function = $_POST['func'];
		if(isset($_POST['function'])) $function = $_POST['function'];
		
		if(!class_exists('Luxi')){
			show_error('Class \'Luxi\' does not exist in this file: ' . $_SERVER['PHP_SELF']);
		}else{
			$class_luxi = new Luxi();
			
			if(!method_exists($class_luxi, $function)){
				show_error('Method \'Luxi::' . $function . '()\' does not exist in this file: ' . $_SERVER['PHP_SELF']);
			}else{
				eval("\$class_luxi->" . $function . '();');
			}
		}
		
		exit();
	}
}

?>
