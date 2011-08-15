<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ʹ�õĈDƬCss·��
 */
function style_url($t='defaut')
{
	return base_url().'static/'.$t.'/';
}

/**
 * ʹ�õ�Js·��
 */
function js_url()
{
	return base_url().'static/jscripts/';
}

/**
 * ��ӡ����
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