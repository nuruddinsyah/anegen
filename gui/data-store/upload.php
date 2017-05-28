<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 GUI: Data Store - Upload
------------------------------------------------------------
*/

define('BASE_PATH', '../'); include(BASE_PATH . 'luxi.php');

include(BASE_PATH . '../core/core.php');

load_widget();

?>

<body style="margin: 12px 10px 12px 12px;">
<div id="ppanel"><div class="scrollpane" id="panel"><p>
	<form action="do-upload.php" target="execute" method="post" enctype="multipart/form-data" onSubmit="return validateForm();" >
		<div id="message"></div>
        
		<table class="zebra_small_gray" width="100%" cellpadding="0px" cellspacing="0px">
            <tr><td id="zebra_small_gray_title_b" nowrap>Microarray File</td><td id="zebra_small_gray_content_b" width="100%"><input type="file" id="file" name="file"></td></tr>
			<tr><td id="zebra_small_gray_title_a" nowrap>Description</td><td id="zebra_small_gray_content_a" width="100%"><input type="text" id="deskripsi" name="deskripsi" value="" style="width: 90%;"></td></tr>
            <tr>
				<td></td>
				<td width="100%" style="padding-left: 10px;">                
					<br>
					<input type="submit" value="  Upload  ">
					<input type="button" value="   Cancel   " onClick="parent.closeWindow();">
				</td>
			</tr>
		</table>
	</form>
</body>

<script language="javascript">
	function validateForm(){
		var pesan = "";
		
		if(!validateText($("#file").val())) pesan += "Maaf, file belum dipilih.<br>";		
		if(!validateText($("#deskripsi").val())) pesan += "Maaf, deskripsi masih kosong.<br>";		
		
		if(pesan!=""){
			message(pesan, "warning");
			return false;
		}else{
			return true;
		}
	}
</script>