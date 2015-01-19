<?php
	class Tools {
		public function dealString($str = "")
		{
			if (!get_magic_quotes_gpc())
				return addslashes($str);
			return $str;
		}
	}
?>