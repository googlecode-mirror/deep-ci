<?php
/**
 * ʹ�þ�̬����������
 *
 * ����Ĭ��function ���ơ�
 * ���� prePage �䶯(ÿҳ��ʾ������)��
 * ���� getLastUri(), �����ʵ�·����
 *
 * version 1.2
 */
class PageBarSession
{
	private static $indexFunction	= 'index';
	private static $inited			= false;
	private static $pageKeyName		= '';
	
	/**
	 * �ж�_GET,_POST����, ִֻ��һ��
	 */
	private function init()
	{
		if(self::$inited==true)
			return;

		parse_str($_SERVER['QUERY_STRING'],$_GET);
		if(!empty($_GET['act'])&&$_GET['act']=='clean')
			//��ղ�ѯ����
			self::clean();
		elseif(!empty($_POST)) {
			//���ò�ѯ����
			self::set($_POST);
		}
		
		if(!empty($_GET['perpage'])) {
			self::setPerPage($_GET['perpage']);
		}
		
		//����������Uri
		self::setLastUri();
		
		//�����Ѿ�ִ�� init
		self::$inited = true;
	}
	
	/**
	 * ��ȡ����������
	 */
	public static function get()
	{
		self::init();
		
		$pageKeyName = self::getPageKeyName();
		$data = @$_SESSION['PageBarData'][$pageKeyName];
		if(empty($data)) $data = array();
		
		return new PageBarSessionData($data);
	}
	
	private static function set($data)
	{
		$pageKeyName = self::getPageKeyName();
		$_SESSION['PageBarData'][$pageKeyName] = $data;
	}
	
	private static function clean()
	{
		$pageKeyName = self::getPageKeyName();
		$_SESSION['PageBarData'][$pageKeyName] = array();
	}
	
	private static function getPageKeyName()
	{
		if(!empty(self::$pageKeyName))
			return self::$pageKeyName;
		
		/** �����pageKeyName **/
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
	
	private static function setPerPage($perPage)
	{
		$pageKeyName = self::getPageKeyName();
		$data = $_SESSION['PageBarData'][$pageKeyName];
		$data['_perPage'] = $perPage;
		
		self::set($data);
	}
	
	public static function getPerPage($perPage)
	{
		$sData = self::get();
		if(empty($sData->_perPage)) {
			self::setPerPage($perPage);
			return $perPage;
		} else 
			return $sData->_perPage;
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