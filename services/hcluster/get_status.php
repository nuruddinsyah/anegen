<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Service: Hierarchical Clustering - Get status
------------------------------------------------------------
*/

$response = array();

$identifier = $_POST['identifier'];

$status = $GLOBALS['db']->get_single_record("select * from requests where id = '$identifier'");

if(file_exists('data-store/' . $status['id'] . '-' . $status['input'] . '.clustered.png')){
	$response['status'] = 'done';
	$response['result_table'] = 'http://localhost/bioinformatics/data-store/' . $status['id'] . '-' . $status['input'] . '.clustered';
	$response['result_image'] = 'http://localhost/bioinformatics/data-store/' . $status['id'] . '-' . $status['input'] . '.clustered.png';
	
	$GLOBALS['db']->update_record(array('status'), array('done'), "id = '$identifier'", 'requests');
}else{
	$response['response'] = 'pending';
}

$json_response = json_encode($response);
echo $json_response;

?>