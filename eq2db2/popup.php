<?php
define('IN_EDITOR', true);
include_once("common/header_short.php");

if (isset($_GET['type']))
{
	switch ($_GET['type'])
	{
		case "item_search":
			include_once("popups/eq2ItemSearch.class.php");
			$Search = new eq2ItemSearch;
			$Search->Start();
			break;
	}
}

include_once("common/footer_short.php");
?>