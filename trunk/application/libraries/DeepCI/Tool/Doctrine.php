<?php

/**
 * 跟新數據表結構到 /application/models/Pdo/ 下
 */
class DeepCI_Tool_Doctrine
{
	private $tmpDir;
	private $tmpBaseDir;
	private $pdoDir;
	private $pdoBaseDir;
	
	// ------------------------------------------------------------------------
	
	public function __construct()
	{
		$this->tmpDir		= VARPATH.'Pdo'.DIRECTORY_SEPARATOR;
		$this->tmpBaseDir	= $this->tmpDir.'generated'.DIRECTORY_SEPARATOR;
		$this->pdoDir		= FCPATH.'application'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Pdo'.DIRECTORY_SEPARATOR;
		$this->pdoBaseDir	= $this->pdoDir.'Base'.DIRECTORY_SEPARATOR;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * 根據數據庫表 更新 Doctrine 對應的文件
	 */
	public function updatePdo()
	{
		// 生成 ORM 文件
		Doctrine_Core::generateModelsFromDb($this->tmpDir);

		// Base 文件
		$files = $this->getFileList($this->tmpBaseDir);
		foreach($files as $file)
		{
			if(is_file($this->pdoBaseDir.$file['name']))
			{
				unlink($this->pdoBaseDir.$file['name']);
			}
			
			rename($file['path'],$this->pdoBaseDir.$file['name']);
		}

		// Pdo 文件
		$files = $this->getFileList($this->tmpDir);
		foreach($files as $file)
		{
			$strlne = strlen($file['name'])-4; 
			$oldClassName = substr($file['name'],0,$strlne); // 去掉 .php
			$className = 'Pdo'.$oldClassName;
				
			if( ! is_file($this->pdoDir.$className.'.php'))
			{
				$str = file_get_contents($file['path']);
				
				$str = str_replace($oldClassName, $className, $str);
				
				file_put_contents($this->pdoDir.$className.'.php', $str);
			}
			
			unlink($file['path']);
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * 獲取所有文件名稱以及絕對路徑
	 */
	private function getFileList($dir)
	{
		$reDir = array();
		if ($handle = opendir($dir)) {

			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && $file != ".svn") {
					if(is_file($dir.$file)) {
						$reDir[] = array('name'=>$file,'path'=>$dir.$file);
					}
				}
			}

			closedir($handle);
		}
		
		return $reDir;
	}
}