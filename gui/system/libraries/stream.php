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
 Library : Stream (Download and Upload)
------------------------------------------------------------
*/

function save_uploaded_file($uploaded_file, $destination = '', $file_name = ''){
	if(substr($destination, -1)!='/' && $destination!='') $destination .= '/';
	if($file_name==''){
		$destination .= get_uploaded_file_base_name($uploaded_file);
	}else{
		$destination .= $file_name;
	}
	
	if(is_uploaded_file(get_uploaded_file_temp($uploaded_file))){
		copy(get_uploaded_file_temp($uploaded_file), $destination);
		return true;
	}else{
		return false;
	}
}

function get_uploaded_file_name($uploaded_file){
	return stripslashes($uploaded_file['name']);
}

function get_uploaded_file_base_name($uploaded_file){
	return basename(stripslashes($uploaded_file['name']));
}

function get_uploaded_file_temp($uploaded_file){
	return $uploaded_file['tmp_name'];
}

function download_file($file_source, $file_name = ''){
	if($file_name=='') $file_name = $file_source;
	
	$basename = basename($file_name);
	$size = filesize($file_source);
	$content = read_file($file_source);
	
	header('Content-Disposition:attachment;filename="'.$basename.'";');
	header('Content-Length:'.$size);
	header('Content-Type:application/octet-stream');
	header('Accept-Ranges:bytes');
	header('X-Pad:avoid browser bug');
	
	echo $content;
}

function download_content($content, $file_name){
	$basename = basename($file_name);
	$size = strlen($content);
	
	header('Content-Disposition:attachment;filename="'.$file_name.'";');
	header('Content-Length:'.$size);
	header('Content-Type:application/octet-stream');
	header('Accept-Ranges:bytes');
	header('X-Pad:avoid browser bug');
	
	echo $content;
}

?>
