<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Service: Hierarchical Clustering - Perform cluster
------------------------------------------------------------
*/

$response = array();

$identifier = $_POST['identifier'];
$filename = $_POST['filename'];
$cluster_method = $_POST['cluster_method'];
$distance_measure = $_POST['distance_measure'];

$add = $GLOBALS['db']->add_record(array('id', 'service', 'function', 'input', 'user', 'status'), array($identifier, 'hcluster', 'perform_cluster', $filename, '0', 'pending'), 'requests');

if($add){
	$response['response'] = 'OK';
	
	execute_engine('hcluster.py --identifier ' . $identifier . ' --i ' . $filename . ' --row_method ' . $cluster_method . ' --row_metric ' . $distance_measure);
}else{
	$response['response'] = 'Error';
}

$json_response = json_encode($response);
echo $json_response;

?>