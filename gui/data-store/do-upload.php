<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 GUI: Data Store - Upload
------------------------------------------------------------
*/

define('BASE_PATH', '../'); include(BASE_PATH . 'luxi.php');

include(BASE_PATH . '../core/core.php');

$file = $_FILES['file'];
$basename = get_uploaded_file_base_name($file);
$deskripsi = $_POST['deskripsi'];

if(save_uploaded_file($file, '../../data-store')){
	$fields = array('filename', 'description', 'category', 'user');
	$values = array($basename, $deskripsi, '', 0);
	
	$GLOBALS['db']->add_record($fields, $values, 'data_store');
	
	js_echo('setTimeout(function(){parent.parent.location.replace("../data-store");}, 650); parent.parent.closeWindow();');
}else{
	js_echo('parent.message("Maaf, file tidak berhasil ter-upload.", "warning");');
}

?>