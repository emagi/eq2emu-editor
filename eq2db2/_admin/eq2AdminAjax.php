<?php
define('IN_EDITOR', true);

//Send some headers to keep the user's browser from caching the response.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=utf-8");

//Get our database abstraction file
require('../common/config.php');

if( isset($_COOKIE['eq2db']) )
{
	$eq2->userdata = $eq2->GetCookie();
	$eq2->user_role = intval($eq2->userdata['role']);
}

///Make sure that a value was sent.
if( isset($_GET['table']) && isset($_GET['field']) && isset($_GET['from']) && isset($_GET['to']) ) 
{
	$query = sprintf("UPDATE %s SET config_value = '%s' WHERE config_name = '%s' ", $_GET['table'], $_GET['to'], $_GET['field']); //print($query); exit;
	if( !$result = $eq2->eq2db->db->sql_query($query) )
	 	printf('<span style="color:red; font-weight:bold; font-size:15px;">FAILED!</span>: Could not write to the database<br />');	
	else
		print('<span style="color:green; font-weight:bold; font-size:15px;">Update Successful!</span><br />');
}
else
{
 	printf('<span style="color:red; font-weight:bold; font-size:15px;">Update FAILED!</span>: %s, %s, %s, %s<br />', $_GET['table'], $_GET['field'], $_GET['from'], $_GET['to']);	
}
?>
