<?php
	require_once(dirname(__FILE__)."/App.class.php");
	App::loadMod("User");
	if (file_exists(".install"))
		die("<center>You had installed on this server.</center>");
	date_default_timezone_set('Asia/Shanghai');
	$sql = mysql_connect($Config['DB_HOST'], $Config['DB_USER'], $Config['DB_PASS']);
	if (!$sql)
		die("Error connect database!");
	if (!mysql_query("CREATE DATABASE ".$Config['DB_NAME']."", $sql))
		die("Error create database!");
	$app = new App();
	$user = new User();
	$user->userRegister($Config['AUTO_USER'], $Config['AUTO_PASS'], "", 0);
	@file_put_contents(".install", "Cello Studio");
	die("<center>Install finished.</center>");
?>