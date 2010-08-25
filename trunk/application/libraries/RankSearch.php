<?php

class RankSearch
{
	var $a = 1;
	function getOrd($key,$domain,$type)
	{
		$domain = trim($domain);
		if(preg_match("/^http\:\/\//i",$domain)) {
			$domain = substr($domain,7);
		}
		if($type=='google')
			$s = new google_com_search();
			
		if($type=='google_tw')
			$s = new google_com_tw_search();
		
		if($type=='google_hk')
			$s = new google_com_hk_search();
			
		if($type=='baidu')
			$s = new baidu_com_search();
			
		if($type=='bing')
			$s = new bing_com_search();
		
		if($type=='yahoo_tw')
			$s = new yahoo_com_tw_search();
		
		$res = $s->getOrd($key,$domain);
		
		return $res;
	}
}

class yahoo_com_tw_search
{
	function getOrd($key,$domain)
	{
		$page = 1;
		$html = $this->getHtml($key,$page);
		$ord = $this->_getOrd($domain,$html);
		
		if($ord==0) {
			$page = 2;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 3;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 4;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 5;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0)
			$t = 0;
		else 
			$t = ($page-1)*10+$ord;
		return array('total'=>$t,'page'=>$page,'ord'=>$ord);
	}
	
	function _getOrd($domain,$html)
	{
		$sArr = explode('<div class="res">',$html);
		$c = count($sArr);
		
		for($i=1;$i<$c;$i++) {
			$s = $sArr[$i];
			$s = explode('</div>',$s);
			$s = $s[0];

			if(strstr($s,$domain))
				return $i;
		}

		return 0;
	}
	
	function getHtml($key,$page)
	{
		$key_encode = urlencode($key);
		if($page==1) {
			$url = 'http://tw.search.yahoo.com/search?p='.$key_encode.'&fr2=sb-top&fr=yfp&rd=r1';
		} else {
			$start = ($page-1)*10+1;
			$url = 'http://tw.search.yahoo.com/search?p='.$key_encode.'&rd=r1&fr=yfp&fr2=sb-top&pstart=1&b='.$start.'';
		}

		$f = fopen($url,'r');

		$str = '';
		while (!feof($f)) {
			$str .= fread($f, 1024);
		}
		
		return $str;
	}
}


class bing_com_search
{
	function getOrd($key,$domain)
	{
		$page = 1;
		$html = $this->getHtml($key,$page);
		$ord = $this->_getOrd($domain,$html);
		
		if($ord==0) {
			$page = 2;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 3;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 4;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 5;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0)
			$t = 0;
		else 
			$t = ($page-1)*10+$ord;
		return array('total'=>$t,'page'=>$page,'ord'=>$ord);
	}
	
	function _getOrd($domain,$html)
	{
		$sArr = explode('<div class="sa_cc">',$html);
		$c = count($sArr);
		
		for($i=1;$i<$c;$i++) {
			$s = $sArr[$i];
			$s = explode('</div>',$s);
			$s = $s[0];

			if(strstr($s,$domain))
				return $i;
		}

		return 0;
	}
	
	function getHtml($key,$page)
	{
		$key_encode = urlencode($key);
		$start = ($page-1)*10+1;
		$url = 'http://www.bing.com/search?q='.$key_encode.'&go=&filt=custom&mkt=zh-TW&first='.$start.'&FORM=PERE';

		$f = fopen($url,'r');

		$str = '';
		while (!feof($f)) {
			$str .= fread($f, 1024);
		}
		
		return $str;
	}
}

class baidu_com_search
{
	function getOrd($key,$domain)
	{
		$page = 1;
		$html = $this->getHtml($key,$page);
		$ord = $this->_getOrd($domain,$html);
		
		if($ord==0) {
			$page = 2;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 3;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 4;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 5;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0)
			$t = 0;
		else 
			$t = ($page-1)*10+$ord;
		return array('total'=>$t,'page'=>$page,'ord'=>$ord);
	}
	
	function _getOrd($domain,$html)
	{
		$sArr = explode('<table border="0" cellpadding="0" cellspacing="0" id="',$html);
		$c = count($sArr);
		
		for($i=1;$i<$c;$i++) {
			$s = $sArr[$i];
			$s = explode('</table>',$s);
			$s = $s[0];
			
			if(strstr($s,$domain))
				return $i;
		}

		return 0;
	}
	
	function getHtml($key,$page)
	{
		$key = iconv('UTF-8','GBK',$key);
		$key_encode = urlencode($key);
		$start = ($page-1)*10;
		$url = 'http://www.baidu.com/s?wd='.$key_encode.'&pn='.$start.'&usm=1';

		$f = fopen($url,'r');

		$str = '';
		while (!feof($f)) {
			$str .= fread($f, 1024);
		}
		
		return $str;
	}
}

class google_com_hk_search
{
	function getOrd($key,$domain)
	{
		$page = 1;
		$html = $this->getHtml($key,$page);
		$ord = $this->_getOrd($domain,$html);
		
		if($ord==0) {
			$page = 2;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 3;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 4;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 5;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0)
			$t = 0;
		else 
			$t = ($page-1)*10+$ord;
		return array('total'=>$t,'page'=>$page,'ord'=>$ord);
	}
	
	function _getOrd($domain,$html)
	{
		$sArr = explode('<li class=g>',$html);

		$c = count($sArr);
		for($i=1;$i<$c;$i++) {
			$s = $sArr[$i];
			$s = explode('<div',$s);
			$s = $s[0];

			if(strstr($s,$domain))
				return $i;
		}
		
		return 0;
	}
	
	function getHtml($key,$page)
	{
		$key_encode = urlencode($key);
		if($page==1) {
			$url = 'http://www.google.com.hk/search?hl=zh-TW&newwindow=1&safe=active&q='.$key_encode.'&btnG=%E6%90%9C%E5%B0%8B&aq=f&aqi=&aql=&oq=&gs_rfai=';
		} else {
			$start = ($page-1)*10;
			$url = 'http://www.google.com.hk/search?q='.$key_encode.'&hl=zh-TW&newwindow=1&safe=active&start='.$start.'&sa=N';
		}
		
		$f = fopen($url,'r');

		$str = '';
		while (!feof($f)) {
			$str .= fread($f, 1024);
		}
		
		return $str;
	}
}

class google_com_tw_search
{
	function getOrd($key,$domain)
	{
		$page = 1;
		$html = $this->getHtml($key,$page);
		$ord = $this->_getOrd($domain,$html);
		
		if($ord==0) {
			$page = 2;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 3;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 4;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 5;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0)
			$t = 0;
		else 
			$t = ($page-1)*10+$ord;
		return array('total'=>$t,'page'=>$page,'ord'=>$ord);
	}
	
	function _getOrd($domain,$html)
	{
		$sArr = explode('<li class=g>',$html);

		$c = count($sArr);
		for($i=1;$i<$c;$i++) {
			$s = $sArr[$i];
			$s = explode('<div',$s);
			$s = $s[0];

			if(strstr($s,$domain))
				return $i;
		}
		
		return 0;
	}
	
	function getHtml($key,$page)
	{
		$key_encode = urlencode($key);
		if($page==1) {
			$url = 'http://www.google.com.tw/search?hl=zh-TW&newwindow=1&q='.$key_encode.'&btnG=%E6%90%9C%E5%B0%8B&aq=f&aqi=&aql=&oq=&gs_rfai=';
		} else {
			$start = ($page-1)*10;
			$url = 'http://www.google.com.tw/search?q='.$key_encode.'&hl=zh-TW&newwindow=1&start='.$start.'&sa=N';
		}
		
		$f = fopen($url,'r');

		$str = '';
		while (!feof($f)) {
			$str .= fread($f, 1024);
		}
		
		return $str;
	}
}


class google_com_search
{
	function getOrd($key,$domain)
	{
		$page = 1;
		$html = $this->getHtml($key,$page);
		$ord = $this->_getOrd($domain,$html);
		
		if($ord==0) {
			$page = 2;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 3;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 4;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0) {
			$page = 5;
			$html = $this->getHtml($key,$page);
			$ord = $this->_getOrd($domain,$html);
		}
		
		if($ord==0)
			$t = 0;
		else 
			$t = ($page-1)*10+$ord;
		return array('total'=>$t,'page'=>$page,'ord'=>$ord);
	}
	
	function _getOrd($domain,$html)
	{
		$sArr = explode('<li class=g>',$html);

		$c = count($sArr);
		for($i=1;$i<$c;$i++) {
			$s = $sArr[$i];
			$s = explode('<div',$s);
			$s = $s[0];

			if(strstr($s,$domain))
				return $i;
		}
		
		return 0;
	}
	
	function getHtml($key,$page)
	{
		$key_encode = urlencode($key);
		if($page==1) {
			$url = 'http://www.google.com/search?hl=en&source=hp&q='.$key_encode.'&aq=f&aqi=&aql=&oq=&gs_rfai=';
			//$url = 'http://www.google.com/search?q=roll+forming+mill&hl=en&newwindow=1&start=10&sa=N';
		} else {
			$start = ($page-1)*10;
			$url = 'http://www.google.com/search?q='.$key_encode.'&hl=en&newwindow=1&start='.$start.'&sa=N';
		}
		
		$f = fopen($url,'r');

		$str = '';
		while (!feof($f)) {
			$str .= fread($f, 1024);
		}
		
		return $str;
	}
}