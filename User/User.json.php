<?php
	require_once(dirname(__FILE__)."/User.class.php");
	if (!isset($_POST['action']))
		die("false");
	$app = new App();
	$user = new User();
	switch ($_GET['action'])
	{
		case "login":
			if (!isset($_POST['user']) || !isset($_POST['pass']))
				die("false");
			if (!$user->user_pass_check($_POST['user'], $_POST['pass']))
				die("false");
			if ($user->userLogin($_POST['user'], $_POST['pass']))
				die("true");
			else
				die("false");
		break;
		case "logout":
			if (!$user->isLogin())
				die("false");
			$user->userLogout();
			die("true");
		break;
		case "register":
			if (!isset($_POST['user']) || !isset($_POST['pass']))
				die("false");
			if (!$user->user_pass_check($_POST['user'], $_POST['pass']))
				die("false");
			if (isset($_POST['json']))
				$json = serialize(json_decode($_POST['json']));
			else
				$json = "";
			if ($user->userRegister($_POST['user'], $_POST['pass'], $json))
				die("true");
			else
				die("false");
		break;
		case "renew":
			if (!$user->isLogin())
				die("false");
			if (!isset($_POST['user']) || !isset($_POST['pass']))
				die("false");
			if ($_POST['user'] != $_SESSION['user'])
				die("false");
			if (!$user->user_pass_check($_POST['user'], $_POST['pass']))
				die("false");
			if (isset($_POST['json']))
				$json = serialize(json_decode($_POST['json']));
			else
				$json = "";
			if ($user->userRenew($_POST['user'], $_POST['pass'], $json))
				die("true");
			else
				die("false");
		break;
		case "delete":
			if (!$user->isLogin())
				die("false");
			if ($user->userDelete($_SESSION['user']))
				die("true");
			else
				die("false");
		break;
		case "json":
			if (!$user->isLogin())
				die("false");
			$json = $user->getJSON($_SESSION['user']);
			if (!$json)
				die("false");
			else
				die(json_encode($json));
		break;
		default:
			die("false");
		break;
	}
?>