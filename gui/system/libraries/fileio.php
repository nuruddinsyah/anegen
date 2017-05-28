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
 Library : File I/O
------------------------------------------------------------
*/

function read_file($file){
	$fp = fopen($file, "r");
	$buffer = fread($fp, filesize($file));
	fclose($fp);
	
	return $buffer;
}

function write_file($file, $content){
	$fp = fopen($file, "w");
	fwrite($fp, $content);
	fclose($fp);
}

function append_file($file, $content){
	$fp = fopen($file, "a");
	fwrite($fp, $content);
	fclose($fp);
}

function delete_file($file){
	unlink($file);
}

function list_dir($dir){
	if($handle = @opendir($dir)){
		$result = array();
		if(substr($dir, -1) != '/'){
			$dir .= '/';
		}

		while($file = @readdir($handle)){
			if($file!="." && $file!=".."){
				if(is_dir($dir.$file)){
					$result[] = $file;
				}
			}
		}

		@closedir($handle);

		if(strpos(strtolower(PHP_OS),"win")===false){
			sort($result);
		}else{
			asort($result);
		}

		return $result;

	}else{
		return false;
	}
}

function list_dir_unsorted($dir){
	if($handle = @opendir($dir)){
		$result = array();
		if(substr($dir, -1) != '/'){
			$dir .= '/';
		}

		while($file = @readdir($handle)){
			if($file!="." && $file!=".."){
				if(is_dir($dir.$file)){
					$result[] = $file;
				}
			}
		}

		@closedir($handle);

		return $result;

	}else{
		return false;
	}
}

function list_file($dir, $ext){
	$extensions = "";
	$list = dir_content($dir, $extensions);
	if ($list===false) return false;
	$result = array();
	foreach($list as $key => $val){
		if(strtolower(substr($val,-strlen($ext)))==strtolower($ext)){
			$result[] = $val;
		}
	}
	
	if(strpos(strtolower(PHP_OS),"win")===false){
		sort($result);
	}else{
		asort($result);
	}
	
	return $result;
}

function list_file_unsorted($dir, $ext){
	$extensions = "";
	$list = dir_content($dir, $extensions);
	if ($list===false) return false;
	$result = array();
	foreach($list as $key => $val){
		if(strtolower(substr($val,-strlen($ext)))==strtolower($ext)){
			$result[] = $val;
		}
	}
	
	return $result;
}

function list_file_any_ext($dir){
	if($handle = @opendir($dir)){
		$result = array();
		if(substr($dir, -1) != '/'){
			$dir .= '/';
		}
		
		while($file = @readdir($handle)){
			if($file!="." && $file!=".."){
				if(is_file($dir.$file)){
					$result[] = $file;
				}
			}
		}
		
		@closedir($handle);
		
		if(strpos(strtolower(PHP_OS),"win")===false){
			sort($result);
		}else{
			asort($result);
		}
		
		return $result;
	
	}else{
		return false;
	}
}

function list_file_any_ext_unsorted($dir){
	if($handle = @opendir($dir)){
		$result = array();
		if(substr($dir, -1) != '/'){
			$dir .= '/';
		}

		while($file = @readdir($handle)){
			if($file!="."&&$file!=".."){
				if(is_file($dir.$file)){
					$result[] = $file;
				}
			}
		}

		@closedir($handle);

		return $result;

	}else{
		return false;
	}
}

function recursively_remove_dir($dir){
	if(is_dir($dir)){
		$objects = scandir($dir);
		
		foreach($objects as $obj){
			if($obj != '.' && $obj != '..'){
				if(filetype($dir . '/' . $obj) == 'dir'){
					recursively_remove_dir($dir . '/' . $obj);
				}else{
					@unlink($dir . '/' . $obj);
					$GLOBALS['db']->delete_record("section_id = 'resources' and section_value like '%" . addslashes($obj). "'", 'recent_activity');
				}
			}
		}
		
		reset($objects);
		@rmdir($dir);
	}
}

function recursively_copy_dir($source, $destination){
	if(file_exists($destination)) recursively_remove_dir($destination);
	
	if(is_dir($source)){
		mkdir($destination);
		
		$objects = scandir($source);
		
		foreach($objects as $obj){
			if($obj != "." && $obj != "..") recursively_copy_dir("$source/$obj", "$destination/$obj");
		}
	}
	else if(file_exists($source)){
		@copy($source, $destination);
	}
}

function dir_content($dir, $expression = ''){
	if($handle = @opendir($dir)){
		$result = array();
		if(substr($dir, -1) != '/'){
			$dir .= '/';
		}
		while($file = @readdir($handle)){
			if(is_file($dir.$file) && ($expression == '' || preg_match($expression, $file))) {
				$result[] = $file;
			}
		}
		@closedir($handle);
		
		if(strpos(strtolower(PHP_OS),"win")===false){
			sort($result);
		}else{
			asort($result);
		}
		
		return $result;
	}else{
		return false;
	}
}

?>
