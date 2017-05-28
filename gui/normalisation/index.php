<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 GUI: Normalisation
------------------------------------------------------------
*/

define('BASE_PATH', '../'); include(BASE_PATH . 'luxi.php');

include(BASE_PATH . '../core/core.php');

load_header('Microarray Data Normalisation');

$method = create_combobox('method', array('l1', 'l2', 'max',), array('L1', 'L2', 'Max'));
$id = generate_id();

?>

<center>
	<br><br>
	<font style="font-size: 14pt; color: 808080;">Microarray Data Normalisation</font>
    <br><br>
	
	<div class="form">
		<table class="zebra_small_gray" width="100%" cellpadding="0px" cellspacing="0px">
            <tr><td id="zebra_small_gray_title_b" nowrap>Microarray File</td><td id="zebra_small_gray_content_b" width="100%"><input type="text" id="filename" value="" readonly style="width: 200px;"> <input type="button" value="  Choose File  " onClick="pilihFile();"></td></tr>
			<tr><td id="zebra_small_gray_title_a" nowrap>Method</td><td id="zebra_small_gray_content_a" width="100%"><?php echo $method; ?></td></tr>
            <tr>
				<td></td>
				<td width="100%" style="padding-left: 10px;">                
					<br>
					<input type="button" id="proses" value="  Process  " onClick="proses();">
				</td>
			</tr>
		</table>
		
		<div id="line" style="width: 100%; height: 1px; background-color: #d0d0d0; margin-top: 25px;"></div>
		<div id="data"></div>
	</div>
	
	<br>
</center>

<?php load_footer(); ?>

<script language="javascript">
	var timer_status;
	$("#line").hide();
	
	function proses(){
		$("#line").show();
		loadData();
		
		$.post("http://localhost/bioinformatics/", {
			'service': 'normalisation',
			'function': 'perform_normalisation',
			'identifier': '<?php echo $id; ?>',
			'filename': $("#filename").val(),
			'method': $("#method").val()
		},
		
		function(result){
			json = JSON.parse(result);
			
			if(json.response == 'OK'){
				timer_status = setInterval(cekStatus, 300);
			}else{
				$("#data").html("<br>Sorry, but normalisation process is failed.");
			}
		});
	}
	
	function cekStatus(){
		$.post("http://localhost/bioinformatics/", {
			'service': 'normalisation',
			'function': 'get_status',
			'identifier': '<?php echo $id; ?>'
		},
		
		function(result){
			json = JSON.parse(result);
			
			if(json.status == 'done'){
				clearInterval(timer_status);
				
				$("#data").html("<br>Normalisation process is done. Here is the result: <br><br><a href='" + json.result_table + "'>Result</a>");
			}
		});
	}
	
	function pilihFile(){
		openWindow("Pilih File", base_path + "data-store/chooser.php?normalised=0", 500, 350);
	}
	
	function setFile(file){
		$("#filename").val(file);
	}
</script>