<!-- DEBUG -->
<?php 
global $GLOBALS, $eq2;
if (env("DEBUG"))
	$eq2->DisplayDebug();
?>
</div><!-- end of main-body -->
</div><!-- end of site-container -->
<script>
		HandleScrollTracking();
</script>
</body>
</html>

<?php
// cookies won't work if we don't use output buffering
ob_end_flush();
?>