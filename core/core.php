<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Core Functions
------------------------------------------------------------
*/

function get_json_function($json, $function){
	for($i = 0; $i < $json->tasks; $i++){
		if($json->tasks[$i]->id == $function) return $json->tasks[$i];
	}
	
	return null;
}

function generate_id(){
	$id = $GLOBALS['db']->get_single_record("select id from requests order by id desc");
	
	if($id){
		$id = $id['id'] + 1;
	}else{
		$id = 1;
	}
	
	return $id;
}

function execute_engine($service){
	execute_in_background("/Users/faruq/anaconda/bin/python /Applications/XAMPP/htdocs/bioinformatics/execution-engine/" . $service);
}

function execute_in_background($cmd){
	putenv('PYTHONPATH=/Users/faruq/anaconda/bin');
	
    if(substr(php_uname(), 0, 7) == "Windows"){
        pclose(popen("start /B ". $cmd, "r")); 
    }else{
        exec($cmd . " > /dev/null &");
    }
}

?>