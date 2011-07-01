

class <?php echo $Model_Full_Name;?> 
{
	private static $_table = '<?php echo $Model_PdoName;?>';
	
	public static function getTable()
	{
		return Doctrine::getTable(self::$_table);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Save
	 */
	public static function save($param, ${#member} ='')
	{
		if (${#member}==='') {
			${#member} = new <?php echo $Model_PdoName;?>();
		}
		
		if ( ! (${#member} instanceof <?php echo $Model_PdoName;?>)) {
			throw new Exception('Class type is not <?php echo $Model_PdoName;?>.');
		}
		
<?php foreach($columns as $c) { if($c=='id') continue;?>
		${#member}-><?php echo $c;?>	= $param['<?php echo $c;?>'];
<?php }?>
		${#member}->save();
		
		return ${#member};
	}
}