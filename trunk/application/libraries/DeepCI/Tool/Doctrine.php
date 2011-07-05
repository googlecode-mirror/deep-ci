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
	private $modelDir;
	
	// ------------------------------------------------------------------------
	
	public function __construct()
	{
		$this->tmpDir		= VARPATH.'Pdo'.DIRECTORY_SEPARATOR;
		$this->tmpBaseDir	= $this->tmpDir.'generated'.DIRECTORY_SEPARATOR;
		$this->pdoDir		= FCPATH.'application'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Pdo'.DIRECTORY_SEPARATOR;
		$this->pdoBaseDir	= $this->pdoDir.'Base'.DIRECTORY_SEPARATOR;
		$this->modelDir		= FCPATH.'application'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'Model'.DIRECTORY_SEPARATOR;
		
		if(! is_dir($this->tmpBaseDir)) {
			mkdir($this->tmpBaseDir, 0777);
			@chmod($this->tmpBaseDir, 0777);
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * 根據數據庫表 更新 Doctrine 對應的文件
	 */
	public function updateModels()
	{
		$result		= array();
		$result2	= array();
		
		// 生成 ORM 文件
		Doctrine_Core::generateModelsFromDb($this->tmpDir);

		// Base 文件
		$files = $this->getFileList($this->tmpBaseDir);
		foreach($files as $file)
		{
			// 清除以前生产的文件
			if(is_file($this->pdoBaseDir.$file['name']))
			{
				unlink($this->pdoBaseDir.$file['name']);
			}
			
			// 读取文件
			$str = file_get_contents($file['path']);
			
			// 更新Pdo文件制定連接
			$strlne = strlen($file['name'])-4; 
			$BaseClassName = substr($file['name'],4,$strlne-4); // Member 
			
			$str = str_replace("bindComponent('{$BaseClassName}',", "bindComponent('Pdo{$BaseClassName}',", $str);
			
			// 写入文件
			file_put_contents($this->pdoBaseDir.$file['name'], $str);
			@chmod($this->pdoBaseDir.$file['name'], 0777);
			
			// 删除临时文件
			@unlink($file['path']);
		}
		$result[] = '[更新] application/models/Pdo/Base/*';

		// Pdo 文件
		$files = $this->getFileList($this->tmpDir);
		foreach($files as $file)
		{
			$CI =& get_instance();
			$model = '';
			$strlne = strlen($file['name'])-4; 
			$oldClassName = substr($file['name'],0,$strlne); // Member , 去掉 .php
			$className = 'Pdo'.$oldClassName; // PdoMember
			$Model_PdoName = $className; // PdoMember
			$Model_BaseName = 'Base'.$oldClassName; // BaseMember
			$Model_Name = $oldClassName; // Member
			$Model_Full_Name = 'Model_'.$Model_Name; //Model_Member
			$modelNameStr = strtolower($oldClassName); // member
				
			if( ! is_file($this->pdoDir.$className.'.php'))
			{
				// 读取文件
				$str = file_get_contents($file['path']);
				
				// 更新Class Name
				$str = str_replace('class '.$oldClassName, 'class '.$className, $str);
				
				// 写入文件
				file_put_contents($this->pdoDir.$className.'.php', $str);
				@chmod($this->pdoDir.$className.'.php', 0777);
				
				// 所有字段
				$model = new $className;
				$columns = array();
				foreach ($model as $column => $value) {
					$columns[] = $column;
				}
				
				// 添加验证功能
				$data = array();
				$data['Model_PdoName']	= $Model_PdoName;
				$data['Model_BaseName']	= $Model_BaseName;
				$data['Model_Full_Name'] = $Model_Full_Name;
				$data['columns']		= $columns;
				$str = '<?php'.$CI->load->view('helper/models/Pdo.php',$data,true);
				
				// 写入文件
				file_put_contents($this->pdoDir.$className.'.php', $str);
				@chmod($this->pdoDir.$className.'.php', 0777);
				
				$result[] = '[生成] application/models/Pdo/'.$className.'.php';
			}
			
			// 生成Model文件
			if( ! is_file($this->modelDir.$Model_Name.'.php'))
			{
				if(empty($columns)) {
					$model = new $className;
					$columns = array();
					foreach ($model as $column => $value) {
						$columns[] = $column;
					}
				}
				
				$data = array();
				$data['Model_PdoName']	= $Model_PdoName;
				$data['columns']		= $columns;
				$data['Model_Name']		= $Model_Name;
				$data['Model_Full_Name'] = $Model_Full_Name;
				
				$str = '<?php'.$CI->load->view('helper/models/Model.php',$data,true);
				$str = str_replace('{#member}', $modelNameStr, $str);
				
				//写入文件
				file_put_contents($this->modelDir.$Model_Name.'.php', $str);
				@chmod($this->modelDir.$Model_Name.'.php', 0777);
				$result2[] = '[生成] application/models/Modle/'.$Model_Name.'.php';
			}
			
			unlink($file['path']);
		}
		
		return array_merge($result, $result2);
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
	
	// ------------------------------------------------------------------------
	
	/**
	 * 獲取所有Pdo
	 */
	public function getAllPdoModels()
	{
		$fiels = $this->getFileList($this->pdoDir);
		
		$reArr = array();
		foreach($fiels as $file) {
			if(strpos($file['name'],'Pdo')===0) {
				$strlne = strlen($file['name'])-4; 
				$reArr[] = substr($file['name'],0,$strlne); // Member , 去掉 .php
			}
		}
		
		return $reArr;
	}
}