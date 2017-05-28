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
 Configuration : Database
------------------------------------------------------------
*/

// Switch whether your site is using database or not

if(!defined('USE_DATABASE')) define('USE_DATABASE', true);

// Default MySQL hostname

define('LUXI_DB_HOSTNAME', "localhost");

// Default MySQL username

define('LUXI_DB_USERNAME', "root");

// Default MySQL password

define('LUXI_DB_PASSWORD', "");

// Default MySQL database

define('LUXI_DB_DATABASE_NAME', "anegen");

// Print out mysql error

define('LUXI_DB_PRINT_ERROR', false);

?>
