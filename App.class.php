<?php
	require_once(dirname(__FILE__)."/Config.php");
	class App {
		private $version = "beta v0.1";
		public function __construct()
		{
			global $sql;
			global $Config;
			date_default_timezone_set('Asia/Shanghai');
			$sql = mysql_connect($Config['DB_HOST'], $Config['DB_USER'], $Config['DB_PASS']);
			if (!$sql)
				die("Error connect database!");
			mysql_select_db($Config['DB_NAME'], $sql);
			mysql_query("SET NAMES utf8");
			@session_start();
		}
		public function version()
		{
			return $this->version;
		}
		public function onFinish()
		{
			die("");
		}
		public function errorMsg($msg = "")
		{
			die("<center><h1>".$msg."</h1></center>");
		}
	}
?>