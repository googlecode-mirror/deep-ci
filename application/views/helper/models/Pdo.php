

/**
 * <?php echo $Model_PdoName;?> 
 */
class <?php echo $Model_PdoName;?> extends <?php echo $Model_BaseName;?> implements DeepCI_Validation_PdoInterface 
{
	/**
	 * require, number, email, url, date	-- array('xxx','error message');
	 */
	public function validation()
	{
		$rules = array();
		
<?php foreach($columns as $c) { if($c=='id') continue;?>
		// <?php echo $c;?> 	
		$rules['<?php echo $c;?>'][]	= array('required');
		
<?php }?>

		return $rules;
	}
}