<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 使用的圖片Css路徑
 */
if (!function_exists('style_url')){
	function style_url($t='defaut')
	{
		return base_url().'static/'.$t.'/';
	}
}

/**
 * 使用的Js路徑
 */
if (!function_exists('js_url')){
	function js_url()
	{
		return base_url().'static/jscripts/';
	}
}

/**
 * 打印數據
 */
if (!function_exists('pr')){
	function pr($data,$htmlHidden=false)
	{
		echo ($htmlHidden) ? '<!-- ' : '<pre>';
		print_r($data);
		echo ($htmlHidden) ? ' -->' : '</pre>';
	}
}