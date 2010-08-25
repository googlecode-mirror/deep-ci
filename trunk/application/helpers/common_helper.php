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
 * ����ѭ�h�е�i׃�����õ�ԓ�еĘ�ʽ
 */
if (!function_exists('getTrStyle')){
	function getTrStyle($i)
	{
		if(($i%2)==0)
			$str = 'odd';
		else
			$str = 'event';

		return $str;
	}
}

/**
 * trimһ�����M
 */
if (!function_exists('array_trim')){
	function array_trim($arr)
	{
		if(empty($arr)) return array();

		$reArr = array();
		foreach($arr as $k=>$v) {
			if(is_array($v)||is_object($v))
				$reArr[$k] = $v;
			else
				$reArr[$k] = trim($v);
		}
		return $reArr;
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

/**
 * ׃�ɶ������
 */
if(!function_exists('array_split')) {
    function array_split($arr, $sum)
    {
        $i = 0;
        $lists = array();
        foreach($arr as $v) {
            $tmp[$i] = $v;
            $i++;
            
            if($i == $sum) {
                $lists[] = $tmp;
                $tmp = array();
                $i = 0;
            }
        }
        
        if($i!=0) {
            $lists[] = $tmp;
        }
        
        return $lists;
    }
}

/**
 * ��ȡ�ַ���
 */
if(!function_exists('mbSubstr')) {
	function mbSubstr($str, $sublen)
    {
        if(strlen($str)<=$sublen) {
            $rStr =  $str;
        } else {
            $I = 0;
            while ($I<$sublen) {
                $StringTMP = substr($str,$I,1);
                
                if (ord($StringTMP)>=224) {
                    $StringTMP = substr($str,$I,3);
                    $I = $I + 3;
                } elseif (ord($StringTMP)>=192) {
                    $StringTMP = substr($str,$I,2);
                    $I = $I + 2;
                } else {
                    $I = $I + 1;
                }
                
                $StringLast[] = $StringTMP;
            }
            
            $rStr = implode("",$StringLast).'...';
        } 
        
        return $rStr;
    }
}