<?php
if (!defined('IN_EDITOR'))
	die("Hack attempt recorded.");

session_start();

// Define default database $GLOBALS - NEVER display this data in DEBUG unless user_role & 16  (admin)
$GLOBALS['database'][0]['id'] 		 					= 0;
$GLOBALS['database'][0]['db_display_name']	= 'EQ2Editor';
$GLOBALS['database'][0]['db_name'] 					= 'eq2editor';
$GLOBALS['database'][0]['db_host'] 					= '<dbhost>';
$GLOBALS['database'][0]['db_port'] 					= '3306';
$GLOBALS['database'][0]['db_user'] 					= '<dbuser>';
$GLOBALS['database'][0]['db_pass'] 					= '<dbpassword>';
$GLOBALS['database'][0]['db_description']		= 'Required DB for EQ2Editor';
$GLOBALS['database'][0]['db_world_id']			= 0;
$GLOBALS['database'][0]['is_active']				= 0;

require_once("eq2Functions.class.php");
$eq2 = new eq2Functions;

// Fetch the rest of our dynamic site configs from the `eq2editor`.`config` table
$eq2->LoadConfig();
//$eq2->ForMe($GLOBALS['database']);

require_once('eq2FormBuilder.class.php'); // instantiate as needed: $eq2form = new EQ2FormBuilder()

?>
