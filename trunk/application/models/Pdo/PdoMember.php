<?php

/**
 * PdoMember
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PdoMember extends BaseMember implements DeepCI_Validation_PdoInterface 
{
	/**
	 * require, number, email, url, date	-- array('xxx','error message');
	 * regex   -- array('regex','[0-9a-zA-Z]{6,}','error message');  // 正則表達式不能 ^ $ ，php中會自動加載
	 * equalto   -- array('equalto','username','必須與username相等');
	 */
	public function validation()
	{
		$rules = array();
		
		// username
		$rules['username'][]	= array('required');
		
		// passowrd
		$rules['passowrd'][]	= array('required');
		$rules['passowrd'][]	= array('regex','[0-9a-zA-Z]{6,}','必須為6位以上');
		// $rules['passowrd'][]	= array('equalto','username','必須與username相等');
		
		// email
		$rules['email'][]	= array('required');
		$rules['email'][]	= array('email');
		
		// create_date
		$rules['create_date'][]	= array('required');
		$rules['create_date'][]	= array('date');
		
		return $rules;
	}
}