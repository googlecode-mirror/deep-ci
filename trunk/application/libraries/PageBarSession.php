<?php

class PageBarSession
{
	private static $indexFunction = 'index';
	
	public function __construct()
	{		
		parse_str($_SERVER['QUERY_STRING'],$_GET);
		if(@$_GET['act']=='clean')
			//清空查询条件
			$this->clean();
		elseif(!empty($_POST)) {
			//设置查询条件
			$this->set($_POST);
		}
		
		//设置最后访问Uri
		$this->setLastUri();
	}
	
	public function get()
	{
		$keyName = self::getKeyName();
		$data = @$_SESSION['PageBarData'][$keyName];
		if(empty($data)) $data = array();
		
		return new PageBarSessionData($data);
	}
	
	public function set($data)
	{
		$keyName = self::getKeyName();
		$_SESSION['PageBarData'][$keyName] = $data;
	}
	
	public function clean()
	{
		$keyName = self::getKeyName();
		$_SESSION['PageBarData'][$keyName] = array();
	}
	
	public function setLastUri()
	{
		$keyName = self::getKeyName();
		if(empty($_SESSION['PageBarData'][$keyName]))
			$_SESSION['PageBarData'][$keyName] = array();
		$_SESSION['PageBarData'][$keyName]['_lastUri'] = $_SERVER['REQUEST_URI'];
	}
	
	public static function getLastUri($url)
	{
		$url = tirm($url,' /');
		$arr = explode('/'.$url);
		
		$fir = $url[0];
		$sed = empty($url[1]) ? self::$indexFunction : $url[1];
		
		if(in_array($fir,array('admin','member'))) {
			$thr = empty($url[2]) ? self::$indexFunction : $url[2];
			$keyName = $fir.'_'.$sed.'_'.$thr;
		} else {
			$keyName = $fir.'_'.$sed;
		}
		
		return $_SESSION['PageBarData'][$keyName]['_lastUri'];
	}
	
	public static function getKeyName()
	{
		$CI = & get_instance();
		
		$fir = $CI->uri->segment(1);
		$sed = $CI->uri->segment(2);
		if(empty($sed)) $sed = self::$indexFunction;
		
		if(in_array($fir,array('admin','member'))) {
			$thr = $CI->uri->segment(3);
			if(empty($thr)) $thr = self::$indexFunction;
			return $fir.'_'.$sed.'_'.$thr;
		} else
			return $fir.'_'.$sed;
	}
}

class PageBarSessionData
{
	function __construct($data)
	{		
		if(empty($data))
			return;
		
		foreach($data as $k=>$v)
			$this->$k = $v;
	}
}