<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Header
------------------------------------------------------------
*/

?>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="icon" type="image-x/icon" href="<?php echo(RESOURCES_DIR); ?>images/icons/favicon-alt.png">
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo(CSS_DIR); ?>system.css">
		
		<script src="<?php echo(JS_DIR); ?>jquery.js"></script>
		<script src="<?php echo(JS_DIR); ?>autoresize.jquery.js"></script>
		<script src="<?php echo(JS_DIR); ?>jquery.customSelect.min.js"></script>
		<script language="javascript">
			var base_path = "<?php ebp(); ?>";
		</script>
		<script src="<?php echo(JS_DIR); ?>global.js"></script>
		<script src="<?php echo(JS_DIR); ?>calendar.js"></script>
	</head>
	<body>
		<div id="header">
			<div id="big">Anegen</div> <div id="small">Web Service for Gene Expression Analysis</div>
		</div>
		
        <a id="logo" href="<?php ebp(); ?>" title="Home"><img src="<?php echo(RESOURCES_DIR); ?>images/logo.png" alt="" border="0"></a>
        
		<!--
        <?php if(isset($_SESSION['ekamitra_header_text'])){ ?>
            <div id="username"><?php phe($_SESSION['ekamitra_header_text']); ?></div>
            <img id="logout_button" src="<?php echo(RESOURCES_DIR); ?>images/icons/quit.png" alt="" border="0" title="Logout" onClick="location.replace('<?php ebp(); ?>logout/');">
        <?php } ?>
        -->
		
        <table id="content" width="100%" cellpadding="0px" cellspacing="0px">
            <tr valign="top">
                <td width="100%" id="td_content">
                    