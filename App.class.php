<?php
	require_once(dirname(__FILE__)."/Config.php");
	class App {
		private $version = "beta v0.1";
		public static $Tools = NULL;
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
			die();
		}
		public static function loadMod($mod)
		{
			require_once(dirname(__FILE__)."/".$mod."/".$mod.".class.php");
			if ($mod == "Tools")
				App::$Tools = new Tools();
		}
		public function errorMsg($msg = "")
		{
			die("<center><h1>".$msg."</h1></center>");
		}
	}
?>