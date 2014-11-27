<?php
	require_once(dirname(__FILE__)."/../App.class.php");
	class User {
		public function __construct()
		{
			global $sql;
			if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'Users'", $sql)) != 1)
			{
				mysql_query("
					CREATE TABLE Users 
					(
						user text,
						pass text,
						json longtext
					) DEFAULT CHARSET = UTF8; 
				", $sql);
			}
		}
		public function str_check($str)
		{
			$strlen = strlen($str);
			if(!preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $str)){
				return false;
			} elseif ( 20 < $strlen || $strlen < 2 ) {
				return false;
			}
			return true;
		}
		public function user_pass_check($user, $pass)
		{
			return ($this->str_check($user) && $this->str_check($pass));
		}
		public function isLogin()
		{
			return (isset($_SESSION['user']) && isset($_SESSION['pass']));
		}
		public function getUser()
		{
			return $_SESSION['user'];
		}
		public function getPass($user = NULL)
		{
			global $sql;
			if ($user != NULL)
			{
				$result = mysql_query("SELECT pass FROM Users 
										WHERE user = '".$user."'", $sql);
				while($row = mysql_fetch_array($result))
				{
					return $row['pass'];
					break;
				}
				return false;
			} else
				return $_SESSION['pass'];
		}
		public function userLogin($user, $pass)
		{
			global $sql;
			$result = mysql_query("SELECT * FROM Users 
									WHERE user = '".$user."' AND pass = '".$pass."'", $sql);
			while($row = mysql_fetch_array($result))
			{
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				return true;
				break;
			}
			return false;
		}
		public function userLogout()
		{
			$_SESSION = array();
			session_destroy();
			return true;
		}
		public function userRegister($user, $pass, $json)
		{
			global $sql;
			$result = mysql_query("SELECT user FROM Users 
										WHERE user = '".$user."'", $sql);
			while($row = mysql_fetch_array($result))
			{
				return false;
				break;
			}
			if (!get_magic_quotes_gpc())
				$json = addslashes($json);
			
			mysql_query("INSERT INTO Users
							VALUES ('".$user."', '".$pass."', '".$json."')", $sql);
			return true;
		}
		public function userRenew($user, $pass, $json)
		{
			global $sql;
			$result = mysql_query("SELECT user FROM Users 
										WHERE user = '".$user."'", $sql);
			if (!get_magic_quotes_gpc())
				$json = addslashes($json);
			while($row = mysql_fetch_array($result))
			{
				mysql_query("UPDATE Users SET pass = '".$pass."', json = '".$json."'
								WHERE user = '".$user."'", $sql);
				$_SESSION['pass'] = $pass;
				return true;
				break;
			}
			return false;
		}
		public function userDelete($user)
		{
			global $sql;
			$result = mysql_query("SELECT user FROM Users 
										WHERE user = '".$user."'", $sql);
			while($row = mysql_fetch_array($result))
			{
				mysql_query("DELETE FROM Users 
								WHERE user = '".$user."'", $sql);
				$_SESSION = array();
				session_destroy();
				return true;
				break;
			}
			return false;
		}
		public function getJSON($user)
		{
			global $sql;
			$result = mysql_query("SELECT json FROM Users 
									WHERE user = '".$user."'", $sql);
			while($row = mysql_fetch_array($result))
				return unserialize($row['json']);
			return false;
		}
	}
?>