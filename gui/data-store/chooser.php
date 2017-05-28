<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 GUI: Data Store - Chooser
------------------------------------------------------------
*/

define('BASE_PATH', '../'); include(BASE_PATH . 'luxi.php');

include(BASE_PATH . '../core/core.php');

load_widget();

$normalised = isset($_GET['normalised']) ? $_GET['normalised'] : '2';

if($normalised == '1'){
	$where = 'where category = \'normalised\'';
}else if($normalised == '0'){
	$where = 'where category = \'\'';
}else{
	$where = '';
}

$records = $GLOBALS['db']->get_records("select * from data_store $where order by filename asc");

?>

<center><font style="font-size: 14pt; color: 808080;">Choose a Microarray File</font></center>
<br>

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
							
							$file = "<a class='link' href='#' onclick=\"pilih('$file');\">$file</a>";
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
                <br><br><br><br><br><br><br>
                <center><i>There are no microarray data files. Please upload your microarray data file from <br>'Upload Microarray File' service.</i></center>
            <?php } ?>
        </td>
    </tr>
</table>

<script language="javascript">
	function pilih(file){
		parent.setFile(file);
		parent.closeWindow();
	}
</script>