<?php
	class Template {
		private $file = "";
		public function __conteructure($tpl)
		{
			$file = dirname(__FILE__)."/../res/tpl/php/".$tpl.".php";
			if (!file_exists($file))
				return false;
			$this->file = $file;
			return $this;
		}
		public function show($o = false)
		{
			if ($o)
				echo file_get_contents($this->file);
			else
				include($this->file);
		}
	}
?>