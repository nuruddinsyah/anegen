<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Request Handler
------------------------------------------------------------
*/

define('BASE_PATH', 'gui/'); include(BASE_PATH . 'luxi.php');
include('core/core.php');

$service = $_POST['service'];
$function = $_POST['function'];

$file_json = file_get_contents("services/$service/$service.json");
$json = json_decode($file_json);
$json_function = get_json_function($json->service, $function);

include("services/$service/$function.php");

?>
