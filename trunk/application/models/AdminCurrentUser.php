<?php
class AdminCurrentUser
{
	private static $user;
	
	private function __construct() {}
	
	public static function user() {
		if(!isset(self::$user)) {
			$aid = @$_SESSION['admin_info']['aid'];
			if (!$u = Doctrine::getTable('Admin')->find($aid)) {
				return FALSE;
			}
			self::$user = $u;
		}
		
		return self::$user;
	}
	
	public static function login($username, $password) {
		if ($u = Doctrine::getTable('Admin')->findOneByUsername($username)) {
			
			$u_input = new Admin();
			$u_input->password = $password;//password匹配（加密过的密码）
			
			if ($u->password == $u_input->password) {
				unset($u_input);
				
				$se = array();
				$se['aid'] = $u->id;
				$se['username'] = $u->username;
				$_SESSION['admin_info'] = $se;
				
				self::$user = $u;
				return TRUE;
			}
			
			unset($u_input);
		}
		
		return FALSE;
	}
	
	public static function logout()
	{
		unset($_SESSION['admin_info']);
	}
}

