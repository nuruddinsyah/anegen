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
 Library : Luxi
------------------------------------------------------------
*/

function load_library($library){
	if(is_array($library)){
		$list = $library;
	}else{
		$list = array($library);
	}
	
	foreach($list as $library){
		if(file_exists(BASE_PATH . 'system/libraries/user-defined/' . $library . '.lib.php')){
			include(BASE_PATH . 'system/libraries/user-defined/' . $library . '.lib.php');
		}else{
			show_error('Library \'' . $library . '\' not found.');
		}
	}
}

function base_path(){
	return BASE_PATH;
}

function bp(){
	return base_path();
}

function echo_base_path(){
	echo BASE_PATH;
}

function ebp(){
	echo_base_path();
}

function debug($variable, $formatting = true){
	$result = print_r($variable, true);
	if($formatting) $result = str_replace(array("\n", ' '), array('<br>', '&nbsp;'), $result);
	echo '<font style=\'font-size: 8pt; font-family: verdana, arial; background-color: e0e0e0; display: block;\'><b>Luxi Debug: <br><br></b>' . $result . '</font><br>';
}

function redirect($uri, $with_base_path = true){
	$bp = ($with_base_path) ? BASE_PATH : '';
	header('location: ' . $bp . $uri);
}

function js_redirect($uri, $parent = false, $with_base_path = true){
	$bp = ($with_base_path) ? BASE_PATH : '';
	$parent = ($parent) ? 'parent.' : '';
	$uri = $bp . $uri;
	
	echo("<script language='javascript'>" . $parent . "location.replace(\"$uri\");</script>");
	exit();
}

function js_echo($text){
	echo("<script language='javascript'>" . $text . "</script>");
}

function he($text, $br_replace = false, $empty_minus = true){
	$text = htmlentities($text, ENT_QUOTES);
	
	if($br_replace){
		$text = str_replace(array("\r", "\n"), array('', '<br>'), $text);
	}
	
	if($empty_minus==true && $text=='') $text = '-';
	
	return $text;
}

function phe($text, $br_replace = false, $empty_minus = true){
	echo he($text, $br_replace, $empty_minus);
}

function het($text, $br_replace = false, $empty_minus = true){
	$text = str_replace(array('\\'), array('\\\\'), $text);
	$text = htmlentities($text, ENT_QUOTES);
	
	if($br_replace){
		$text = str_replace(array("\r", "\n"), array('', '<br>'), $text);
	}
	
	$text = str_replace(array('&'), array('\&'), $text);
	
	if($empty_minus==true && $text=='') $text = '-';
	
	return $text;
}

function phet($text, $br_replace = false, $empty_minus = true){
	echo het($text, $br_replace, $empty_minus);
}

?>
