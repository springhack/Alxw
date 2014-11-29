<?php
	require_once(dirname(__FILE__)."/Page.class.php");
	if (!isset($_GET['action']))
		die("false");
	$app = new App();
	$user = new User();
	$page = new Page();
	switch ($_GET['action'])
	{
		case "createPage":
			if (!$user->isLogin())
				die("false");
			if (!isset($_POST['name']) || !isset($_POST['title']) || !isset($_POST['author']) || !isset($_POST['content']))
				die("false");
			if (isset($_POST['json']))
				$json = serialize(json_decode($_POST['json']));
			else
				$json = "";
			$tid = $page->createPage($_POST['name'], $_POST['title'], $_POST['author'], $_POST['content'], json_decode($json));
			if (!$tid)
				die("false");
			else
				die($tid);
		break;
		case "updatePage":
			if (!$user->isLogin())
				die("false");
			if (!isset($_POST['name']) || !isset($_POST['title']) || !isset($_POST['author']) || !isset($_POST['content']) || !isset($_POST['time']))
				die("false");
			if (isset($_POST['json']))
				$json = serialize(json_decode($_POST['json']));
			else
				$json = "";
			$tid = $page->updatePage($_POST['name'], $_POST['title'], $_POST['author'], $_POST['content'], json_decode($json), $_POST['time']);
			if (!$tid)
				die("false");
			else
				die($tid);
		break;
		case "deletePage":
			if (!$user->isLogin())
				die("false");
			if (!isset($_POST['name']))
				die("false");
			if ($page->deletePage($_POST['name']))
				die("true");
			else
				die("false");
		break;
		case "getPage":
			if (!isset($_POST['name']))
				die("false");
			if (!$user->str_check($_POST['name']))
				die("false");
			$e = $page->getPage($_POST['name']);
			if (!$e)
				die("false");
			else
				die(json_encode($e));
		break;
		case "getList":
			$limit = isset($_POST['limit'])?$_POST['limit']:"";
			$offset = isset($_POST['offset'])?$_POST['offset']:"";
			$e = $page->getList($limit, $offset);
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