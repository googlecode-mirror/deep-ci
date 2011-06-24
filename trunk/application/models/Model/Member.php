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
	 * Ìí¼Ó
	 */
	public static function add($param)
	{
		$member = new PdoMember();
		$member->username	= $param['username'];
		$member->passowrd	= $param['passowrd'];
		$member->email	= $param['email'];
		$member->create_date	= $param['create_date'];
		$member->save();
		
		return $member;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * ĞŞ¸Ä
	 */
	public static function edit($param, PdoMember $member)
	{
		$member->username	= $param['username'];
		$member->passowrd	= $param['passowrd'];
		$member->email	= $param['email'];
		$member->create_date	= $param['create_date'];
		$member->save();
		
		return $member;
	}
}