<?php
	require_once(dirname(__FILE__)."/../App.class.php");
	require_once(dirname(__FILE__)."/../User/User.class.php");
	class Talk {
		private $user = NULL;
		public function __construct()
		{
			$this->user = new User();
		}
		public function talkLogin($email = "", $uface = "", $ulink = "", $expire = "3600")
		{
			global $Config;
			if (!$this->user->isLogin())
				return false;
			if (!$Config['UYAN_SETTING']['CAN_USE'])
				return false;
			$uid = $uname = $this->user->getUser();
			$key = $Config['UYAN_SETTING']['UYAN_KEY'];
			$encode_data = array(
					'uid' => $uid,
					'uname' => $uname,
					'email' => $email,
					'uface' => $uface,
					'ulink' => $ulink,
					'expire' => $expire
				);
			//print_r($this->des_encrypt(json_encode($encode_data), $key));
			//setcookie('syncuyan', "ssssssssssssssssss");
			setcookie('syncuyan', $this->des_encrypt(json_encode($encode_data), $key));
			return true;
		}
		public function getCode()
		{
			global $Config;
			if (!$this->user->isLogin())
				return false;
			if (!$Config['UYAN_SETTING']['CAN_USE'])
				return false;
			return '<!-- UY BEGIN --><div id="uyan_frame"></div><script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid='.$Config['UYAN_SETTING']['UYAN_UID'].'"></script><!-- UY END -->';
		}
		private function des_encrypt($string, $key)
		{
			$size = mcrypt_get_block_size('des', 'ecb');
			$string = mb_convert_encoding($string, 'GBK', 'UTF-8');
			$pad = $size - (strlen($string) % $size);
			$string = $string . str_repeat(chr($pad), $pad);
			$td = mcrypt_module_open('des', '', 'ecb', '');
			$iv = @mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
			@mcrypt_generic_init($td, $key, $iv);
			$data = mcrypt_generic($td, $string);
			mcrypt_generic_deinit($td);
			mcrypt_module_close($td);
			$data = base64_encode($data);
			return $data;
		}
	}
?>