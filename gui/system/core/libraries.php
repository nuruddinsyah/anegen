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
 Libraries Loader
------------------------------------------------------------
*/

include(BASE_PATH . 'system/libraries/luxi.php');
include(BASE_PATH . 'system/libraries/fileio.php');
include(BASE_PATH . 'system/libraries/datetime.php');
include(BASE_PATH . 'system/libraries/string.php');
include(BASE_PATH . 'system/libraries/security.php');
include(BASE_PATH . 'system/libraries/stream.php');
include(BASE_PATH . 'system/libraries/gui.php');
include(BASE_PATH . 'system/libraries/image.php');
include(BASE_PATH . 'system/libraries/error.php');

// Load database library

if(USE_DATABASE) include(BASE_PATH . 'system/libraries/database.php');

// Load the auto-load libraries

$lib_list = list_file(BASE_PATH . 'system/libraries/user-defined/auto-load', '.lib.php');

foreach($lib_list as $list){
	include(BASE_PATH . 'system/libraries/user-defined/auto-load/' . $list);
}

?>
