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
 Library : Security
------------------------------------------------------------
*/

function set_skey($key = '', $value = ''){
	if($key=='') $key = 'luxi_skey';
	if($value=='') $value = md5(random_text(100));
	
	if(isset($_SESSION[$key])) unset($_SESSION[$key]);
	
	$_SESSION[$key] = $value;
}

function get_skey($key = '', $auto_delete = false){
	if($key=='') $key = 'luxi_skey';
	if(!isset($_SESSION[$key])) return false;
	
	$tmp = $_SESSION[$key];
	if($auto_delete) unset($_SESSION[$key]);
	
	return $tmp;
}

function delete_skey($key = ''){
	if($key=='') $key = 'luxi_skey';
	unset($_SESSION[$key]);
}

?>
