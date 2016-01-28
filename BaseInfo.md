# 说明 #

基本上不再使用 include require 。一些加载都是由 `__autoload` 完成。详见最下方的 autoload

  * [Autoload](BaseInfo#Autoload.md)
  * [Model](BaseInfo#Model.md)

# Model #

Model 使用 Doctrine ORM。

Model 分为两层一层是Doctrine ORM 负责数据库操作。 一层是逻辑处理（Model）。

目录说明

  * models
    * Model -- 逻辑处理例如 `Model_Member`
    * Pdo -- Doctrine ORM，负责数据库操作。数据表关联。
      * Base -- 自动生成文件，ORM中数据库字段格式。

## Doctrine ORM ##

主要负责数据库操作，表的关联。

每个表对应的文件名前增加了Pdo，因为php5.3之前没有命名空间。

PdoMember
  * 对应 member表
  * 文件为 models/Pdo/PdoMember.php
  * 继承与 models/Pdo/Base/BaseMember.php
  * 不用使用include，会自动加载


## 逻辑部分 ##

主要负责 逻辑处理，

`Model/Member.php`例子如下：
```
class Model_Member
{
	private static $_table = 'PdoMember';
	
	public static function getTable()
	{
		return Doctrine::getTable(self::$_table);
	}
```

静态变量 `$_table` 指定本Model默认关联的 ORM文件。

静态函数 `getTable()` 会自动返回默认关联ORM的Table。

```
Model_Member::getTable();
//等同于
Doctrine::getTable('PdoMember');
```

# Autoload #
关于系统中的 autoload。 判断顺序
  1. Pdo  继承与Base文件。主要是手写程序。
  1. Base ORM自动生成文件
  1. Model 逻辑处理
  1. libraries 一些lib

```
spl_autoload_register('__autoload');
function __autoload($className) {
	if (class_exists($className, false) || interface_exists($className, false)) {
		return false;
    }
	
	// 加載PdoFile
	if(preg_match('/^Pdo/',$className)) {
		$classFile	= APPPATH."models/Pdo/".$className.EXT;
		if(file_exists($classFile))
		{
			require $classFile;
			return true;
		}
	}
	
	// 加載PdoBase文件
	if(preg_match('/^Base/',$className)) {
		$classFile	= APPPATH."models/Pdo/Base/".$className.EXT;
		if(file_exists($classFile))
		{
			require $classFile;
			return true;
		}
	}
	
	$file = str_replace('_', DIRECTORY_SEPARATOR, $className);	
	
	// Model類， 類似 Model_Member 
	if(preg_match('/^Model\_/',$className)) {
		$classFile	= APPPATH."models/".$file.EXT;
		if(file_exists($classFile))
		{
			require $classFile;
			return true;
		}
	}
	
	if (file_exists(APPPATH."libraries/".$file.EXT)) {  
		require APPPATH."libraries/".$file.EXT;  
	} 
}
```