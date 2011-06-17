<?php# 必须有 $config array$config['session_start'] = true;# start session. if isn't Command Line.if (isset($_SERVER['REMOTE_ADDR'])) {	session_start();		# set UTF-8 for web site	header("Content-type: text/html; charset=utf-8");}# define var pathdefine('VARPATH', FCPATH.'static'.DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR);// -----------------------------------// 设置自动加载// -----------------------------------spl_autoload_register('__autoload');function __autoload($className) {	if (class_exists($className, false) || interface_exists($className, false)) {		return false;    }		// 加載PdoFile	if(preg_match('/^Pdo/',$className)) {		$classFile	= APPPATH."models/Pdo/".$className.EXT;		if(file_exists($classFile))		{			require $classFile;			return true;		}	}		// 加載PdoBase文件	if(preg_match('/^Base/',$className)) {		$classFile	= APPPATH."models/Pdo/Base/".$className.EXT;		if(file_exists($classFile))		{			require $classFile;			return true;		}	}		$file = str_replace('_', DIRECTORY_SEPARATOR, $className);			// Model類， 類似 Model_Member 	if(preg_match('/^Model\_/',$className)) {		$classFile	= APPPATH."models/".$file.EXT;		if(file_exists($classFile))		{			require $classFile;			return true;		}	}		if (file_exists(APPPATH."libraries/".$file.EXT)) {  		require APPPATH."libraries/".$file.EXT;  	} }// -----------------------------------// Set Doctrine. 關於加載Doctrine的model文件。在 __autoload 函數中有設定 (Pdo Base部份)。// -----------------------------------// load database configuration from CodeIgniterrequire_once APPPATH.'/config/database.php';if($db['default']['username'] && $db['default']['password']){	// load Doctrine library	require_once BASEPATH.'database_doctrine/Doctrine.php';	// this will allow Doctrine to load Model classes automatically	spl_autoload_register(array('Doctrine', 'autoload'));	// dsn	$dsn = $db['default']['dbdriver'] .		'://' . $db['default']['username'] .		':' . $db['default']['password'].		'@' . $db['default']['hostname'] .		'/' . $db['default']['database'];	// create connection	Doctrine_Manager::connection($dsn,'default');		// set charSet	Doctrine_Manager::getInstance()->getCurrentConnection()->setCharset($db['default']['char_set']);}