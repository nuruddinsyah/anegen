<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 GUI: Home
------------------------------------------------------------
*/

define('BASE_PATH', ''); include(BASE_PATH . 'luxi.php');

load_header('');

?>

<center style="font-size: 11pt; color: 808080; line-height: 1.4em;">
	<br><br>
	Welcome to <b>Anegen</b>.<br>
	Please choose one of the services below:
    <br><br>
	
	<a href="<?php ebp(); ?>data-store/?upload=1" class="help_link">
		<div id="help_item" align="center">
			<img src="<?php echo(RESOURCES_DIR); ?>images/icons/upload-alt.png">
			<br>
			Upload Microarray Data File
		</div>
	</a>
	
	<a href="<?php ebp(); ?>data-store" class="help_link">
		<div id="help_item" align="center">
			<img src="<?php echo(RESOURCES_DIR); ?>images/icons/data-store-alt.png">
			<br>
			Microarray Data Store
		</div>
	</a>

	<a href="<?php ebp(); ?>normalisation" class="help_link">
		<div id="help_item" align="center">
			<img src="<?php echo(RESOURCES_DIR); ?>images/icons/normalisation.png">
			<br>
			Microarray Data Normalisation
		</div>
	</a>

	<a href="<?php ebp(); ?>hcluster" class="help_link">
		<div id="help_item" align="center">
			<img src="<?php echo(RESOURCES_DIR); ?>images/icons/hierarchy.png">
			<br>
			Hierarchical Clustering
		</div>
	</a>
	
	<br><br>
</center>

<?php load_footer(); ?>
