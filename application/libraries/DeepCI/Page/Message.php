<?php
/**
 * Session flash 結合 jNotify 提示框效果
 *
 * @package    Page
 */
class DeepCI_Page_Message
{
	public static function Notice($url, $msg, $autoHide='')
	{
		if ($autoHide=='') {
			$autoHide = true;
		}
		
		self::_save('notice',$url,$msg,$autoHide);
	}
	
	public static function Success($url, $msg, $autoHide='')
	{
		if ($autoHide=='') {
			$autoHide = true;
		}
		
		self::_save('success',$url,$msg,$autoHide);
	}
	
	public static function Error($url, $msg, $autoHide='')
	{
		if ($autoHide=='') {
			$autoHide = false;
		}
		
		self::_save('error',$url,$msg,$autoHide);
	}
	
	public static function _save($type,$url,$msg,$autoHide)
	{
		$autoHide	= ($autoHide) ? 1 : 0;
		$data		= array('type'=>$type,'msg'=>$msg,'autoHide'=>$autoHide);
		
		$_SESSION['_page_message_data'] = $data;
		
		//
		if(strpos($url,'/')!==0) {
			$CI =& get_instance();
			$uri =& $CI->uri;
			
			$directory = trim($CI->router->directory,'/');
			
			if(empty($directory))
				$url = $uri->rsegments[1].'/'.$url;
			else
				$url = $directory.'/'.$uri->rsegments[1].'/'.$url;
		}
		
		redirect($url);
	}
	
	public static function Get()
	{
		if(empty($_SESSION['_page_message_data']))
			return '';
		
		$data = $_SESSION['_page_message_data'];
		unset($_SESSION['_page_message_data']);
		
		$str_begin	= '<script type="text/javascript"> $(document).ready(function(){ ';
		$str_end	= ' }); </script>'; 
		
		$msg	= str_replace("'","\\'",$data['msg']);
		$msg	= "<strong>提示：</strong>".$msg;
		
		$subJs	= ($data['autoHide']) ? 'TimeShown : 1200, ' : 'autoHide : false, ';
		$subJs	.= "VerticalPosition : 'center', HorizontalPosition:'center'";
		
		switch($data['type']) {
			case 'success':
				$str = "jSuccess('{$msg}',{".$subJs."});";
				break;
			case 'notice':
				$str = "jNotify('{$msg}',{".$subJs."});";
				break;
			case 'error':
				$str = "jError('{$msg}',{".$subJs."});";
				break;
			default:
				$str = "jNotify('{$msg}',{".$subJs."});";
				break;
		}
		
		return $str_begin.$str.$str_end;
	}
}