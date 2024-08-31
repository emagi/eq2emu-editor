<?php
if (!defined('IN_EDITOR'))
	die();
?>
<table class="footer">
	<tr>
		<td align="center">
			Editor Designed for Internet Explorer 6+ (1280x1024). Non-IE browsers may not display screens properly.<br />
			All content and design &copy; 2011 EQ2Emulator.net, MMOEmulators.com, John Adams and Sony Online Entertainment
		</td>
	</tr>
</table>
<!-- DEBUG -->
<?php 
if( $GLOBALS['config']['debug'] ) 
	$eq2->DisplayDebug();
?>
</div><!-- end of main-body -->
</div><!-- end of site-container -->
</body>
</html>
