<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 GUI: Data Store
------------------------------------------------------------
*/

define('BASE_PATH', '../'); include(BASE_PATH . 'luxi.php');

include(BASE_PATH . '../core/core.php');

load_header('Microarray Data Store');

$upload = isset($_GET['upload']) ? true : false;
$records = $GLOBALS['db']->get_records("select * from data_store order by filename asc");

?>

<center>
	<br><br>
	<font style="font-size: 14pt; color: 808080;">Microarray Data Store</font>
    <br><br>
	
	<div class="form">
		<div style="" align="right">
			<input type="button" id="upload" value="  + Upload File  " onClick="upload();">
			<br><br>
		</div>
		
		<table cellpadding="0px" cellspacing="0px" align="center">
		    <tr>
		        <td>
		            <?php if(count($records)>0){ ?>
		                <table class="data_no_border" cellpadding="0px" cellspacing="1px">
		                    <tr>
								<th>No</th>
		                        <th>Filename</th>
		                        <th>Description</th>
		                        <th>Normalised</th>
		                    </tr>
                    
		                    <?php
		                        $ab = false;
		                        for($i=0; $i<count($records); $i++){
		                            $ab=!$ab;
		                            $strab = ($ab)? 'data_a': 'data_b';
                            
		                            $file = $records[$i]['filename'];
									$normalised = $records[$i]['category'] == 'normalised' ? 'Yes' : '-';
		                    ?>
                    
		                    <tr id="<?php echo $strab; ?>" valign="top">
		                        <td align="center"><?php phe($i+1); ?></td>
		                        <td align="left" nowrap><?php echo $file; ?></td>
		                        <td align="left"><?php phe($records[$i]['description']); ?></td>
		                        <td align="center" nowrap><?php phe($normalised); ?></td>
		                    </tr>
                    
		                    <?php } ?>
		                </table>
		            <?php }else{ ?>
		                <br><br>
		                <center><i>There are no microarray data files. Please upload your microarray data file from 'Upload Microarray File' service..</i></center>
						<br><br><br><br>
		            <?php } ?>
		        </td>
		    </tr>
		</table>
	</div>
	
	<br>
</center>

<?php load_footer(); ?>

<script language="javascript">
	$(document).ready(function(){
		<?php if($upload) echo "upload();"; ?>
	});
	
	function upload(){
		openWindow("Upload", base_path + "data-store/upload.php", 450, 150);
	}
</script>