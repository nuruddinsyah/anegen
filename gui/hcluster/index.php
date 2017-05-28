<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 GUI: Hierarchical Clustering
------------------------------------------------------------
*/

define('BASE_PATH', '../'); include(BASE_PATH . 'luxi.php');

include(BASE_PATH . '../core/core.php');

load_header('Hierarchical Clustering');

$cluster_method = create_combobox('cluster_method', array('single', 'complete', 'average', 'weighted', 'centroid', 'median', 'ward'), array('Single', 'Complete', 'Average', 'Weighted', 'Centroid', 'Median', 'Ward'));
$distance_measure = create_combobox('distance_measure', array('euclidean', 'cityblock', 'hamming', 'cosine'), array('Euclidean', 'Cityblock', 'Hamming', 'Cosine'));
$id = generate_id();

?>

<center>
	<br><br>
	<font style="font-size: 14pt; color: 808080;">Hierarchical Clustering</font>
    <br><br>
	
	<div class="form">
		<table class="zebra_small_gray" width="100%" cellpadding="0px" cellspacing="0px">
            <tr><td id="zebra_small_gray_title_b" nowrap>Microarray File</td><td id="zebra_small_gray_content_b" width="100%"><input type="text" id="filename" value="" readonly style="width: 200px;"> <input type="button" value="  Choose File  " onClick="pilihFile();"></td></tr>
			<tr><td id="zebra_small_gray_title_a" nowrap>Cluster Method</td><td id="zebra_small_gray_content_a" width="100%"><?php echo $cluster_method; ?></td></tr>
            <tr><td id="zebra_small_gray_title_a" nowrap>Distance Measure</td><td id="zebra_small_gray_content_a" width="100%"><?php echo $distance_measure; ?></td></tr>
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
			'service': 'hcluster',
			'function': 'perform_cluster',
			'identifier': '<?php echo $id; ?>',
			'filename': $("#filename").val(),
			'cluster_method': $("#cluster_method").val(),
			'distance_measure': $("#distance_measure").val()
		},
		
		function(result){
			json = JSON.parse(result);
			
			if(json.response == 'OK'){
				timer_status = setInterval(cekStatus, 300);
			}else{
				$("#data").html("<br>Maaf, clustering process is failed.");
			}
		});
	}
	
	function cekStatus(){
		$.post("http://localhost/bioinformatics/", {
			'service': 'hcluster',
			'function': 'get_status',
			'identifier': '<?php echo $id; ?>'
		},
		
		function(result){
			json = JSON.parse(result);
			
			if(json.status == 'done'){
				clearInterval(timer_status);
				
				$("#data").html("<br>Clustering process is done. Here is the result: <br><br><img src='" + json.result_image + "'>");
				$(".form").css({"width": 1200});
			}
		});
	}
	
	function pilihFile(){
		openWindow("Pilih File", base_path + "data-store/chooser.php?normalised=1", 500, 350);
	}
	
	function setFile(file){
		$("#filename").val(file);
	}
</script>