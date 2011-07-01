<?php

class Model_Member
{
	private static $_table = 'PdoMember';
	
	public static function getTable()
	{
		return Doctrine::getTable(self::$_table);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * ±£´æ
	 */
	public static function save($param, $member='')
	{
		if ($member==='') {
			$member = new PdoMember();
		}
		
		if ( ! ($member instanceof PdoMember)) {
			throw new Exception('Class type is not PdoMember.');
		}
		
		$member->username	= $param['username'];
		$member->passowrd	= $param['passowrd'];
		$member->email	= $param['email'];
		$member->create_date	= $param['create_date'];
		$member->save();
		
		return $member;
	}
}