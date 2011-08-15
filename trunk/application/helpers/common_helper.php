<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 使用的圖片Css路徑
 */
function style_url($t='defaut')
{
	return base_url().'static/'.$t.'/';
}

/**
 * 使用的Js路徑
 */
function js_url()
{
	return base_url().'static/jscripts/';
}

/**
 * 打印數據
 */
function pr($data,$htmlHidden=false)
{
	echo ($htmlHidden) ? '<!-- ' : '<pre>';
	
	if( is_object($data) && $data instanceof IteratorAggregate ) {
		print_r($data->toArray());
	} else {
		print_r($data);
	}
	
	echo ($htmlHidden) ? ' -->' : '</pre>';
}

function page_message_success($url, $message, $autoHide='')
{	
	DeepCI_Page_Message::Success($url, $message, $autoHide);
	return true;
}

function page_message_error($url, $message, $autoHide='')
{
	DeepCI_Page_Message::Error($url, $message, $autoHide);
	return true;
}

function page_message_notice($url, $message, $autoHide='')
{	
	DeepCI_Page_Message::Notice($url, $message, $autoHide);
	return true;
}