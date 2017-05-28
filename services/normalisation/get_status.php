<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Service: Normalisation - Get status
------------------------------------------------------------
*/

$response = array();

$identifier = $_POST['identifier'];

$status = $GLOBALS['db']->get_single_record("select * from requests where id = '$identifier'");

if(file_exists('data-store/' . $status['input'] . '.normalised')){
	$response['status'] = 'done';
	$response['result_table'] = 'http://localhost/bioinformatics/data-store/' . $status['input'] . '.normalised';
	
	$GLOBALS['db']->update_record(array('status'), array('done'), "id = '$identifier'", 'requests');
	
	$input = $status['input'];
	$file = $GLOBALS['db']->get_single_record("select * from data_store where filename = '$input'");
	$description = $file['description'];
	
	$fields = array('filename', 'description', 'category', 'user');
	$values = array($input . '.normalised', $description, 'normalised', 0);
	
	$GLOBALS['db']->add_record($fields, $values, 'data_store');
}else{
	$response['response'] = 'pending';
}

$json_response = json_encode($response);
echo $json_response;

?>