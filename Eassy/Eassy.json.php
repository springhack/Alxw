<?php
	require_once(dirname(__FILE__)."/Eassy.class.php");
	if (!isset($_GET['action']))
		die("false");
	$app = new App();
	$user = new User();
	$eassy = new Eassy();
	switch ($_GET['action'])
	{
		case "createEassy":
			if (!$user->isLogin())
				die("false");
			if (!isset($_POST['title']) || !isset($_POST['author']) || !isset($_POST['type']) || !isset($_POST['content']))
				die("false");
			if (isset($_POST['json']))
				$json = serialize(json_decode($_POST['json']));
			else
				$json = "";
			$tid = $eassy->createEassy($_POST['title'], $_POST['author'], $_POST['type'], $_POST['content'], json_decode($json));
			if (!$tid)
				die("false");
			else
				die($tid);
		break;
		case "updateEassy":
			if (!$user->isLogin())
				die("false");
			if (!isset($_POST['tid']) || !isset($_POST['title']) || !isset($_POST['author']) || !isset($_POST['type']) || !isset($_POST['content']) || !isset($_POST['time']))
				die("false");
			if (isset($_POST['json']))
				$json = serialize(json_decode($_POST['json']));
			else
				$json = "";
			$tid = $eassy->updateEassy($_POST['tid'], $_POST['title'], $_POST['author'], $_POST['type'], $_POST['content'], json_decode($json), $_POST['time']);
			if (!$tid)
				die("false");
			else
				die($tid);
		break;
		case "deleteEassy":
			if (!$user->isLogin())
				die("false");
			if (!isset($_POST['tid']))
				die("false");
			if ($eassy->deleteEassy($_POST['tid']))
				die("true");
			else
				die("false");
		break;
		case "getEassy":
			if (!isset($_POST['tid']))
				die("false");
			$e = $eassy->getEassy($_POST['tid']);
			if (!$e)
				die("false");
			else
				die(json_encode($e));
		break;
		case "getList":
			$type = isset($_POST['type'])?$_POST['type']:false;
			$limit = isset($_POST['limit'])?$_POST['limit']:"";
			$offset = isset($_POST['offset'])?$_POST['offset']:"";
			if ($type == "false")
				$type = false;
			if ($type == "true")
			{
				if ($user->isLogin())
					$type = true;
				else
					die("false");
			}
			$e = $eassy->getList($type, $limit, $offset);
			if (!$e)
				die("false");
			else
				die(json_encode($e));
		break;
		default:
			die("false");
		break;
	}
?>