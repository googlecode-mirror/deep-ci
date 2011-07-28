<?php

/**
 * controllers views 生成器
 */
class DeepCI_Tool_Controller
{
	private $viewDir;
	private $ControllerDir;
	
	// ------------------------------------------------------------------------
	
	public function __construct()
	{
		$this->viewDir			= FCPATH.'application'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR;
		$this->ControllerDir	= FCPATH.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR;
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * 生成 controllers views
	 */
	public function create($Model_PdoName, $view_url)
	{
		$CI =& get_instance();
		
		$result = array();
		
		try {
			$model = new $Model_PdoName;
		} catch (Exception $e) {
			throw new Exception($Model_PdoName.' model not find.');
		}
		
		if( ! $model instanceof Doctrine_Record) {
			throw new Exception('model is not Doctrine_Record sub class.');
		}
		
		// 字段
		$columns = array();
		foreach ($model as $column => $value) {
			$columns[] = $column;
		}
		
		$dirName = '';
		$controllerName = '';
		
		$view_url = trim($view_url, '/ ');
		$view_url = explode('/', $view_url);
		$count = count($view_url);
		if($count==2) {
			$dirName = $view_url[0];
			$controllerName = $view_url[1];
		} elseif($count==1) {
			$controllerName = $view_url[0];
		} else {
			throw new Exception('view_url must like /admin/member or /member/product.');
		}
		
		// 
		if($dirName) {
			$controllers_path = $this->ControllerDir.$dirName.DIRECTORY_SEPARATOR;
			$views_path = $this->viewDir.$dirName.DIRECTORY_SEPARATOR;
			
			if(! is_dir($controllers_path)) {
				mkdir($controllers_path, 0777);
				@chmod($controllers_path, 0777);
			}
			if(! is_dir($views_path)) {
				mkdir($views_path, 0777);
				@chmod($views_path, 0777);
			}
			
			$controller_base_url = '/'.$dirName.'/'.$controllerName; // /admin/member
		} else {
			$controllers_path = $this->ControllerDir;
			$views_path = $this->viewDir;
			
			$controller_base_url = '/'.$controllerName; // /member
		}
		
		$Model_PdoName = $Model_PdoName; // PdoMember
		
		$Sub_Model_Name = substr($Model_PdoName, 3); // Member
		$Lower_Model_Name = $this->lowerFirstChar($Sub_Model_Name); // member
		$Model_Full_Name = 'Model_'.$Sub_Model_Name; //Model_Member
		$ucfirst_controller_name = ucfirst($controllerName); // Member
		
		// controllers
		if( ! is_file($controllers_path.$controllerName.'.php')) {
			$data = array();
			$data['ucfirst_controller_name']	= $ucfirst_controller_name;
			$data['dirName']					= $dirName;
			$data['Model_PdoName']				= $Model_PdoName;
			$data['Model_Full_Name']			= $Model_Full_Name;
			$data['controller_base_url']		= $controller_base_url;
			
			$str = '<?php'.$CI->load->view('deepci_helper/controllers/index.php',$data,true);
			$str = str_replace('{#member}', $Lower_Model_Name, $str);
			
			// 写入文件
			file_put_contents($controllers_path.$controllerName.'.php', $str);
			@chmod($controllers_path.$controllerName.'.php', 0777);
			$result[] = '[生成] application/controllers'.$controller_base_url.'.php';
		}
		
		// views 
		$controller_views_path = $views_path.$controllerName.DIRECTORY_SEPARATOR;
		if( ! is_dir($controller_views_path)) {
			mkdir($controller_views_path, 0777);
			@chmod($controller_views_path, 0777);
		}
		
		// index.php 
		if( ! is_file($controller_views_path.'index.php')) {
			$data = array();
			$data['columns']			= $columns;
			$data['controller_base_url']		= $controller_base_url;
			
			$str = $CI->load->view('deepci_helper/views/index.php',$data,true);
			$str = str_replace('{#member}', $Lower_Model_Name, $str);
			$str = str_replace('<#', '<?', $str);
			$str = str_replace('#>', '?>', $str);
			
			// 写入文件
			file_put_contents($controller_views_path.'index.php', $str);
			@chmod($controller_views_path.'index.php', 0777);
			$result[] = '[生成] application/views'.$controller_base_url.'/index.php';
		}
		
		// add.php 
		if( ! is_file($controller_views_path.'add.php')) {
			$data = array();
			$data['columns']			= $columns;
			$data['Model_PdoName']				= $Model_PdoName;
			$data['controller_base_url']		= $controller_base_url;
			
			$str = $CI->load->view('deepci_helper/views/add.php',$data,true);
			$str = str_replace('{#member}', $Lower_Model_Name, $str);
			$str = str_replace('<#', '<?', $str);
			$str = str_replace('#>', '?>', $str);
			
			// 写入文件
			file_put_contents($controller_views_path.'add.php', $str);
			@chmod($controller_views_path.'add.php', 0777);
			$result[] = '[生成] application/views'.$controller_base_url.'/add.php';
		}
		
		// edit.php 
		if( ! is_file($controller_views_path.'edit.php')) {
			$data = array();
			$data['columns']			= $columns;
			$data['Model_PdoName']				= $Model_PdoName;
			$data['controller_base_url']		= $controller_base_url;
			
			$str = $CI->load->view('deepci_helper/views/edit.php',$data,true);
			$str = str_replace('{#member}', $Lower_Model_Name, $str);
			$str = str_replace('<#', '<?', $str);
			$str = str_replace('#>', '?>', $str);
			
			// 写入文件
			file_put_contents($controller_views_path.'edit.php', $str);
			@chmod($controller_views_path.'edit.php', 0777);
			$result[] = '[生成] application/views'.$controller_base_url.'/edit.php';
		}
		
		return $result;
	}
	
	/**
	 * 首字母小寫
	 */
	private function lowerFirstChar($str)
	{
		$s1 = substr($str,0,1);
		$s2 = substr($str,1);
		
		return strtolower($s1).$s2;
	}
}