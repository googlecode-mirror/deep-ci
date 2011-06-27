

class <?php echo $Model_Full_Name;?> 
{
	private static $_table = '<?php echo $Model_PdoName;?>';
	
	public static function getTable()
	{
		return Doctrine::getTable(self::$_table);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 添加
	 */
	public static function add($param)
	{
		${#member} = new <?php echo $Model_PdoName;?>();
<?php foreach($columns as $c) { if($c=='id') continue;?>
		${#member}-><?php echo $c;?>	= $param['<?php echo $c;?>'];
<?php }?>
		${#member}->save();
		
		return ${#member};
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 修改
	 */
	public static function edit($param, <?php echo $Model_PdoName;?> ${#member})
	{
<?php foreach($columns as $c) { if($c=='id') continue;?>
		${#member}-><?php echo $c;?>	= $param['<?php echo $c;?>'];
<?php }?>
		${#member}->save();
		
		return ${#member};
	}
}