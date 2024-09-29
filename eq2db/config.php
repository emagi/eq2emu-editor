<?php

if (!defined('IN_EDITOR'))
	die("Hack attempt recorded.");

// cookies won't work if we don't use output buffering
ob_start();
session_start();
set_time_limit(900);

if (env("DEBUG")) {
    ini_set("display_errors", "On");
    ini_set("display_startup_errors", "On");
    //ini_set("short_open_tag", "On");
}


function EQ2EditorErrorHandler($errno, $errstr, $errfile, $errline) {
	if (!(error_reporting() & $errno) || ($errno & (E_ERROR | E_USER_ERROR))) {
        //This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return false;
    }

	global $eq2, $DebugGeneralStartupNotices, $DebugGeneralStartupWarnings;

	$errstr = htmlspecialchars($errstr);

	$errstr = $errstr . " File : " . $errfile . " Line : " . $errline;

	switch ($errno) {
	case E_WARNING:
	case E_USER_WARNING:
		if (isset($eq2)) {
			$eq2->AddDebugGeneral("Warning", $errstr);
		}
		else {
			if (!isset($DebugGeneralStartupWarnings)) $DebugGeneralStartupWarnings = array();
			$DebugGeneralStartupWarnings[sizeof($DebugGeneralStartupWarnings)] = $errstr;
		}
        break;
	case E_NOTICE:
    case E_USER_NOTICE:
		if (isset($eq2)) {
			$eq2->AddDebugGeneral("Warning", $errstr);
		}
		else {
			if (!isset($DebugGeneralStartupNotices)) $DebugGeneralStartupNotices = array();
			$DebugGeneralStartupNotices[sizeof($DebugGeneralStartupNotices)] = $errstr;
		}
        break;
	default:
		//Not sure what this is, just let the default handler take this one.
		return false;
	}

	return true;
}

set_error_handler("EQ2EditorErrorHandler");

// instantiate eq2 class
include_once("class/eq2.class.php");
$eq2 = new eq2Cls();

// Fetch the rest of our dynamic site configs from the `eq2editor`.`config` table
$eq2->LoadConfig();

// a few hacks to get EQ2DB v1 working with EQ2DB 2's globals
//$_SESSION['current_database'] = 1;
if($_SESSION['current_database'] == "")
{
	define("ACTIVE_DB", $GLOBALS['config']['dev_datasource']);				// name of the database your DEV server uses
	$_SESSION['current_database'] = $GLOBALS['config']['dev_datasource'];
}else{
	define("ACTIVE_DB", $_SESSION['current_database']);
}
define("SCRIPT_PATH", $GLOBALS['config']['script_path']);
define("LOG_PATH", $GLOBALS['config']['log_path']);						// path to your eq2 servers LOGS folder (optional)
define("PARSER_DB", $GLOBALS['config']['parser_datasource']);	// name of your parser database
define("RAW_DB", $GLOBALS['config']['raw_datasource']);				// name of the database you -populate into
define("LOGIN_DB", $GLOBALS['config']['login_datasource']);				// name of the database you -populate into
//define("LIVE_DB", $GLOBALS['config']['live_datasource']);			// name of the database your LIVE server uses (optional)
define("SOE_DATA", $GLOBALS['config']['soe_datasource']);			// name of the database of SOE API data (optional)
define("LOGIN_FOLDER", $GLOBALS['config']['login_folder']);		// folder your LoginServer lives in
define("PATCH_FOLDER", $GLOBALS['config']['patch_folder']);		// folder your PatchServer lives in
define("WORLD_FOLDER", $GLOBALS['config']['world_folder']);		// folder your EQ2World lives in
define("SERVER_LOG_TIME", $GLOBALS['config']['server_log_time']);		// Log Viewer settings (optional)
define("PERM_SCRIPT", $GLOBALS['config']['fileperm_script'] ?? null);
