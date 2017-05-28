<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Service: Normalisation - Perform normalisation
------------------------------------------------------------
*/

$response = array();

$identifier = $_POST['identifier'];
$filename = $_POST['filename'];
$method = $_POST['method'];

$add = $GLOBALS['db']->add_record(array('id', 'service', 'function', 'input', 'user', 'status'), array($identifier, 'normalisation', 'perform_normalisation', $filename, '0', 'pending'), 'requests');

if($add){
	$response['response'] = 'OK';
	
	execute_engine('normalisation.py --filename ' . $filename . ' --method ' . $method);
}else{
	$response['response'] = 'Error';
}

$json_response = json_encode($response);
echo $json_response;

?>