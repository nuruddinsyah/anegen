<?php
/*
------------------------------------------------------------
 Anegen - Web Service untuk Analisis Ekspresi Gen
------------------------------------------------------------
 Oleh: Muhammad Faruq Nuruddinsyah
 Copyright 2017. All Rights Reserved.
------------------------------------------------------------
 Footer
------------------------------------------------------------
*/

?>

                </td>
            </tr>
        </table>
        
        <div id="footer">
            &copy; 2017 Muhammad Faruq Nuruddinsyah. All rights reserved.
        </div>
		
		<div id="screen_lock" style="display: none;">
			<table id="screen_lock_table" width="100%" height="100%" style="position: absolute; top: 0px; left: 0px; z-index: 100;" background="<?php echo(RESOURCES_DIR); ?>images/screen-lock.png"><tr onclick="safelyCloseWindow();"><td>&nbsp;</td></tr></table>
		</div>
		<div id="window"></div>
		
		<div id="window_closed_prevention">
			<div id="back"></div>
			<div id="wcp_content">
				<div id="title">Perhatian!</div>
				<br>
				Anda telah melakukan perubahan data pada form yang ada di dalam jendela ini.<br>Apakah Anda yakin ingin menutup jendela ini?
				
				<br><br>
				
				<input type="button" value="      Ya      " onClick="closeWindow();">
				<input type="button" value="    Tidak    " onClick="hideWindowClosedPrevention();">
			</div>
		</div>
		
		<div id="screen_lock_calendar" style="display: none;">
			<table id="screen_lock_calendar_table" width="100%" height="100%" style="position: absolute; top: 0px; left: 0px; z-index: 102;" background="<?php echo(RESOURCES_DIR); ?>images/screen-lock.png"><tr onclick="closeCalendar();"><td>&nbsp;</td></tr></table>
		</div>
		<div id="window_calendar"></div>
		
		<div id="div_execute" style="position: absolute; top: 40px; <?php if(!SHOW_IFRAME) echo "display: none;"; ?>">
			<iframe name="execute" src=""></iframe>
		</div>
	</body>
</html>
