<?php
class MemberCurrentUser
{
	private static $user;
	
	private function __construct() {}
	
	public static function user() {
		if(!isset(self::$user)) {
			$member_id = @$_SESSION['member_info']['id'];
			if (!$u = Doctrine::getTable('Member')->find($member_id)) {
				return FALSE;
			}
			self::$user = $u;
		}
		
		return self::$user;
	}
	
	public static function login($username, $password) {
		if ($u = Doctrine::getTable('Member')->findOneByUsername($username)) {
			
			$u_input = new Member();
			$u_input->password = $password;//password匹配（加密过的密码）
			
			if ($u->password == $u_input->password) {
				unset($u_input);
				
				$se = array();
				$se['id'] = $u->id;
				$se['username'] = $u->username;
				$_SESSION['member_info'] = $se;
				
				self::$user = $u;
				return TRUE;
			}
			
			unset($u_input);
		}
		
		return FALSE;
	}
	
	public static function logout()
	{
		unset($_SESSION['member_info']);
	}
}

