<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ʹ�õĈDƬCss·��
 */
if (!function_exists('style_url')){
	function style_url($t='defaut')
	{
		return base_url().'static/'.$t.'/';
	}
}

/**
 * ʹ�õ�Js·��
 */
if (!function_exists('js_url')){
	function js_url()
	{
		return base_url().'static/jscripts/';
	}
}

/**
 * ��ӡ����
 */
if (!function_exists('pr')){
	function pr($data,$htmlHidden=false)
	{
		echo ($htmlHidden) ? '<!-- ' : '<pre>';
		print_r($data);
		echo ($htmlHidden) ? ' -->' : '</pre>';
	}
}