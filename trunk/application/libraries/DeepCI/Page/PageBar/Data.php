<?php
/**
 * 使用静态函数，变量
 *
 * 增加默认function 名称。
 * 增加 prePage 变动(每页显示多少行)。
 * 增加 getLastUri(), 最后访问的路径。
 *
 * @package    Page
 * @subpackage PageBar
 * @version 1.2
 */
class DeepCI_Page_PageBar_Data
{
	private static $indexFunction	= 'index';
	private static $inited			= false;
	private static $pageKeyName		= '';
	
	/**
	 * 判断_GET,_POST数据, 只执行一次
	 */
	public static function init()
	{
		if(self::$inited==true)
			return;

		parse_str($_SERVER['QUERY_STRING'],$_GET);
		if(!empty($_GET['act'])&&$_GET['act']=='clean')
			//清空查询条件
			self::clean();
		elseif(!empty($_POST)) {
			//设置查询条件
			self::set($_POST);
		}
		
		if(!empty($_GET['perpage'])) {
			self::setPerPage($_GET['perpage']);
		}
		
		//设置最后访问Uri
		self::setLastUri();
		
		//设置已经执行 init
		self::$inited = true;
	}
	
	/**
	 * 获取搜索等数据
	 */
	public static function get()
	{
		self::init();
		
		$pageKeyName = self::getPageKeyName();
		$data = @$_SESSION['PageBarData'][$pageKeyName];
		if(empty($data)) $data = array();
		
		return new Page_PageBar_Data_Obj($data);
	}
	
	private static function set($data)
	{
		$pageKeyName = self::getPageKeyName();
		
		if(!empty($_SESSION['PageBarData'][$pageKeyName]))
			$da2 = self::cleanPostData($_SESSION['PageBarData'][$pageKeyName]);
		else 
			$da2 = array();
		
		$data = array_merge($da2,$data);
		$_SESSION['PageBarData'][$pageKeyName] = $data;
	}
	
	/**
	 * 去掉post過來的數據
	 */
	private static function cleanPostData($da)
	{
		$reArr = array();
		
		foreach ($da as $k=>$v)
			if (preg_match('/^\_/i',$k))
				$reArr[$k] = $v;
		
		return $reArr;
	}
	
	private static function clean()
	{
		$pageKeyName = self::getPageKeyName();
		
		$data = $_SESSION['PageBarData'][$pageKeyName];
		$da = array();
		foreach($data as $k=>$v) {
			if(preg_match('/^\_/i',$k))
				$da[$k] = $v;
		}
		
		$_SESSION['PageBarData'][$pageKeyName] = $da;
	}
	
	private static function getPageKeyName()
	{
		if(!empty(self::$pageKeyName))
			return self::$pageKeyName;
		
		/** 计算出pageKeyName **/
		$CI = & get_instance();
		
		$fir = $CI->uri->segment(1);
		$sed = $CI->uri->segment(2);
		if(empty($sed)) $sed = self::$indexFunction;
		
		if(in_array($fir,array('admin','member'))) {
			$thr = $CI->uri->segment(3);
			if(empty($thr)) $thr = self::$indexFunction;
			$pageKeyName = $fir.'_'.$sed.'_'.$thr;
		} else
			$pageKeyName = $fir.'_'.$sed;
		
		self::$pageKeyName = $pageKeyName;
		return $pageKeyName;
	}
	
	public static function setDqlSort($field,$type)
	{
		$data = array();
		$data['_dql_sort'] = array('field'=>$field,'type'=>$type);
		
		self::set($data);
	}
	
	public static function getDqlSort()
	{
		$sData = self::get();
		return (empty($sData->_dql_sort)) ? '' : $sData->_dql_sort;
	}
	
	public static function setPerPage($perPage)
	{
		$data = array();
		$data['_perPage'] = $perPage;
		
		self::set($data);
	}
	
	public static function getPerPage()
	{
		$sData = self::get();
		return (empty($sData->_perPage)) ? '' : $sData->_perPage;
	}
	
	private static function setLastUri()
	{
		$pageKeyName = self::getPageKeyName();
		if(empty($_SESSION['PageBarData'][$pageKeyName]))
			$_SESSION['PageBarData'][$pageKeyName] = array();
		$_SESSION['PageBarData'][$pageKeyName]['_lastUri'] = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	
	public static function getLastUri($url)
	{
		$url = trim($url,' /');
		if(strstr($url,'/'))
			$url = explode('/',$url);
		else
			$url = array($url);
		
		$fir = $url[0];
		$sed = empty($url[1]) ? self::$indexFunction : $url[1];
		
		if(in_array($fir,array('admin','member'))) {
			$thr = empty($url[2]) ? self::$indexFunction : $url[2];
			$pageKeyName = $fir.'_'.$sed.'_'.$thr;
		} else {
			$pageKeyName = $fir.'_'.$sed;
		}

		return $_SESSION['PageBarData'][$pageKeyName]['_lastUri'];
	}
}

class Page_PageBar_Data_Obj
{
	function __construct($data)
	{		
		if(empty($data))
			return;
		
		foreach($data as $k=>$v)
			$this->$k = $v;
	}
	
	function get($key)
	{
		if(empty($this->$key))
			return '';
		else
			return $this->$key;
	}
	
	function has($key)
	{
		if(empty($this->$key))
			return false;
		else
			return true;
	}
}