<?php
	require_once(dirname(__FILE__)."/Talk.class.php");
	if (!isset($_GET['action']))
		die("false");
	$app = new App();
	$talk = new Talk();
	switch ($_GET['action'])
	{
		case "getCode":
			$talk->talkLogin();
			$e = $talk->getCode();
			if (!$e)
				die("false");
			else
				die($e);
		break;
		default:
			die("false");
		break;
	}
?>