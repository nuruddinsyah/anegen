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
 Library : String
------------------------------------------------------------
*/

function random_text($n){
	$d = '';
	
	for($i=0; $i<$n; ++$i){
	    if(rand(0, 9)<6){
			$d .= chr(ord('1') + rand(0, 8));
	    }else{
			do{
				$offset = rand(0, 25);
			}while($offset==14);
			
			$d .= chr(ord('a') + $offset);
	    }
	}
	
	return $d;
}

function get_sliced_chars($string, $max, $end_char = '...'){
	if(strlen($string)<=$max){
		return $string;
	}else{
		return substr($string, 0, $max) . $end_char;
	}
}

function get_sliced_words($string, $max, $end_char = '...'){
	if(trim($string) == '') return $string;
	
	preg_match('/^\s*+(?:\S++\s*+){1,'. (int) $max . '}/', $string, $matches);
	if(strlen($string)==strlen($matches[0])) $end_char = '';
	
	return rtrim($matches[0]) . $end_char;
}

function encode($string, $key){
	$key = sha1($key);
	$strLen = strlen($string);
	$keyLen = strlen($key);
	
	$j = 0;
	$hash = '';
	
	for($i=0; $i<$strLen; $i++){
		$ordStr = ord(substr($string, $i, 1));
		if($j==$keyLen) $j = 0;
		$ordKey = ord(substr($key, $j, 1));
		$j++;
		$hash .= strrev(base_convert(dechex($ordStr+$ordKey), 16, 36));
	}
	
	return $hash;
}

function decode($string, $key){
	$key = sha1($key);
	$strLen = strlen($string);
	$keyLen = strlen($key);
	
	$j = 0;
	$hash = '';
	
	for($i=0; $i<$strLen; $i+=2){
		$ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
		if($j==$keyLen) $j=0;
		$ordKey = ord(substr($key, $j, 1));
		$j++;
		$hash .= chr($ordStr-$ordKey);
	}
	
	return $hash;
}

?>
