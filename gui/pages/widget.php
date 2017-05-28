<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Widget
------------------------------------------------------------
*/

?>

<link rel="stylesheet" type="text/css" media="all" href="<?php ebp(); ?>css/system.css">
<link rel="stylesheet" type="text/css" media="all" href="<?php ebp(); ?>css/widget.css">
<script src="<?php ebp(); ?>js/jquery.js"></script>
<script src="<?php ebp(); ?>js/autoresize.jquery.js"></script>
<script src="<?php ebp(); ?>js/jquery.mousewheel.js"></script>
<script src="<?php ebp(); ?>js/jquery.jscrollpane.min.js"></script>
<script src="<?php ebp(); ?>js/jquery.customSelect.min.js"></script>

<script language="javascript">
	var base_path = "<?php ebp(); ?>";
	var jspAPI;
	
	$(document).ready(function(){
		$(".autoresize").autoResize({
			animate: false,
			extraSpace: 8,
			onResize: function(){
				setTimeout(function(){jspAPI.reinitialise();}, 10);
			}
		});
		
		var pane = $("#panel");
		pane.jScrollPane({verticalGutter: -9, horizontalGutter: 9});
		jspAPI = pane.data("jsp");
		
		$("select").customSelect();
	});
	
	function reinitialiseJSP(){
		jspAPI.reinitialise();
	}
</script>
<script src="<?php ebp(); ?>js/widget.js"></script>

<div id="div_execute" style="z-index: 9; position: absolute; top: 0px; <?php if(!SHOW_IFRAME) echo "display: none;"; ?>">
	<iframe name="execute" src=""></iframe>
</div>
