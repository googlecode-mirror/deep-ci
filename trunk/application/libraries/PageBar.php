<?php
/**
 * 分頁類
 *
 * 整合Doctrine, codeigniter->pagination 的分頁類
 * Doctrine_Pager 用來查詢，并統計
 * pagination 用來生成html
 *
 */
class PageBar
{
	private $base_url;
	private $uri_segment	= 3;
	private $per_page		= 12;
	private $returnType		= 'object'; //return obj or array
	
	const PERPAGE_CHANGE	= 'PerPageChange'; 
	
	function setBaseUrl($base_url)
	{
		$this->base_url = site_url($base_url);
		
		return $this;
	}
	
	function setPerPage($per_page,$prePageChange='')
	{
		if($prePageChange==self::PERPAGE_CHANGE) {
			$per_page = PageBarSession::getPerPage($per_page);
		}
		
		$this->per_page = $per_page;
		return $this;
	}
	
	function getPerPage()
	{
		return $this->per_page;
	}
	
	function setUriSegment($uri_segment)
	{
		$this->uri_segment = $uri_segment;
		
		return $this;
	}
	
	function setReturn($return)
	{
		$this->returnType = $return;
		
		return $this;
	}
	
	function get($q)
	{
		$CI =& get_instance();
		
		/** 查詢數據 **/
		$offset = $CI->uri->segment($this->uri_segment);
		$offset = (empty($offset)) ? 0 : $offset;
		$currentPage = floor($offset/$this->per_page)+1;
		
		$resultsPerPage = $this->per_page;
		$pager = new Doctrine_Pager($q,$currentPage,$resultsPerPage);
		
		if($this->returnType=='array')
			$items = $pager->execute()->toArray();
		else
			$items = $pager->execute();
		
		/** 生成html **/
		$config['base_url']		= $this->base_url;
		$config['uri_segment']	= $this->uri_segment;
		$config['per_page']		= $this->per_page;
		$config['total_rows']	= $pager->getNumResults();
		
		$config['first_link']	= '&lsaquo; 首頁';
		$config['next_link'] 	= '下頁 &#187;';
		$config['prev_link'] 	= '&#171; 上頁';
		$config['last_link'] 	= '末頁 &rsaquo;';
		
		$CI->load->library('pagination');
		$CI->pagination->initialize($config);
		$html = $CI->pagination->create_links();
		
		return array($items, $html);
	}
}