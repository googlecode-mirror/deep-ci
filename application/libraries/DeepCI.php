<?php

/**
 * 接口文件
 */
class DeepCI
{
	public static function createValidation($model, $defaultValue='')
	{
		return new DeepCI_Validation_Core($model, $defaultValue);
	}
	
	public static function getPageMessage()
	{
		return DeepCI_Page_Message::Get();
	}
	
	public static function getPageBar($dql, $offset=0)
	{
		return new DeepCI_Page_PageBar($dql, $offset);
	}
}