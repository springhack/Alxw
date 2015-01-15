<?php
	class Template {
		private $str = "";
		public function __conteructure($tpl)
		{
			$this->str = fule_get_contents("../res/tpl/php/".$tpl.".php");
		}
	}
?>