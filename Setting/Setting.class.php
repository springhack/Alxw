<?php
	require_once(dirname(__FILE__)."/../App.class.php");
	App::loadMod("MySQL");
	class Setting {
		private $db = NULL;
		public function __construct()
		{
			$this->db = new MySQL();
			if ($this->db->query("SHOW TABLES LIKE 'Setting'")->num_rows() != 1)
			{
				$this->db->struct(array(
						'key' => 'text',
						'val' => 'longtext'
					))->create("Setting");
			}
		}
		public function set($key, $val)
		{
			if ($this->db->from("setting")->where("`key` = '".$key."'")->select("*")->num_rows() != 1)
				$ret = $this->db->value(array(
						'key' => $key,
						'val' => $val
					))->insert("Setting");
			else
				$ret = $this->db->set(array(
						'val' => $val
					))->where("`key` = '".$key."'")->update("Setting");
			return $val;
		}
		public function get($key, $val = "")
		{
			$ret = $this->db->from("setting")->where("`key` = '".$key."'")->select("*")->fetch_one();
			if ($ret == "")
				return $val;
			return $ret['val'];
		}
	}
?>