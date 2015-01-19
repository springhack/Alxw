<?php
	require_once(dirname(__FILE__)."/../App.class.php");
	if (!isset($_GET['action']))
		die("false");
	switch ($_GET['action'])
	{
		case "getTemplate":
			if (!isset($_GET['tpl']))
				die("false");
			if (!file_exists(dirname(__FILE__)."/../res/tpl/html/".$tpl.".html"))
				die("false");
			die(file_get_contents(dirname(__FILE__)."/../res/tpl/html/".$tpl.".html"));	
		break;
		default:
			die("false");
		break;
	}
?>