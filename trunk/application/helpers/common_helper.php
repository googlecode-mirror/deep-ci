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
 * 根據循環中的i變量，得到該行的樣式
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
 * trim一個數組
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

/**
 * 變成多為陣列
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
 * 截取字符串
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