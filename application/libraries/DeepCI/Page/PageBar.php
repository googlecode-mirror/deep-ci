<?php
/**
 * 分頁類
 *
 * 整合Doctrine, codeigniter->pagination 的分頁類
 * Doctrine_Pager 用來查詢，并統計
 * pagination 用來生成html
 *
 * @package    Page
 * @subpackage PageBar
 */
class DeepCI_Page_PageBar
{
	private $base_url;
	private $offset		= 0;
	private $per_page		= 12;
	private $dql			= '';
	private $numResults	= 0;
	private $selectPrePage;
	
	public function __construct($dql, $offset=0)
	{
		parse_str($_SERVER['QUERY_STRING'],$_GET);
		
		// dhl
		$this->dql =& $dql;
		
		// 設定 offset
		$this->setOffset($offset);
		
		// 設定 base_url
		$CI		=& get_instance();
		$uri	=& $CI->uri;
		
		$directory = trim($CI->router->directory,'/');
		
		if(empty($directory))
			$base_url = $uri->rsegments[1].'/'.$uri->rsegments[2];
		else
			$base_url = $directory.'/'.$uri->rsegments[1].'/'.$uri->rsegments[2];

		$this->setBaseUrl($base_url);
		
		// set per_page
		if(!empty($_GET['per_page'])) {
			$per_page = ($_GET['per_page']=='all') ? 500 : $_GET['per_page'];
			DeepCI_Page_PageBar_Data::setPerPage($per_page);
		}
		
		// 設定 per_page 默認值
		$this->selectPrePage = array(12,25,50,100);
		$this->setPerPage($this->selectPrePage[0]);
		
		// sort
		if(!empty($_GET['sort_asc'])) {
			DeepCI_Page_PageBar_Data::setDqlSort($_GET['sort_asc'],'asc');
		}
		
		if(!empty($_GET['sort_desc'])) {
			DeepCI_Page_PageBar_Data::setDqlSort($_GET['sort_desc'],'desc');
		}
		
		// set post data
		$this->initSearch();
	}
	
	function initSearch()
	{
		// allow like(llike, rlike flike) eq gt lt
		$allow = array('like','eq','gt','lt','llike','rlike','flike');
		$sData = $this->getData();
		foreach($sData as $k=>$v)
		{
			if (empty($v))
				continue;
			if( ! strpos($k,'__'))
				continue;
			
			$tmp = explode('__',$k);
			$field = $tmp[0];
			$type = $tmp[1];

			switch($type) {
				case 'like':
					$this->dql->andWhere("{$field} like '{$v}'");
					break;
				case 'eq':
					$this->dql->andWhere("{$field} = '{$v}'");
					break;
				case 'gt':
					$this->dql->andWhere("{$field} > {$v}");
					break;
				case 'lt':
					$this->dql->andWhere("{$field} < {$v}");
					break;
				case 'llike':
					$this->dql->andWhere("{$field} like '%{$v}'");
					break;
				case 'rlike':
					$this->dql->andWhere("{$field} like '{$v}%'");
					break;
				case 'flike':
					$this->dql->andWhere("{$field} like '%{$v}%'");
					break;
			}
		}
	}
	
	function getSqlQuery()
	{
		return $this->dql->getSqlQuery();
	}
	
	function getSql()
	{
		return $this->getSqlQuery();
	}
	
	function setBaseUrl($base_url)
	{
		$this->base_url = site_url($base_url);
		
		return $this;
	}
	
	function setPerPage($per_page)
	{
		$sel_per_page = DeepCI_Page_PageBar_Data::getPerPage();

		$this->per_page = (empty($sel_per_page)) ? $per_page : $sel_per_page;
		
		return $this;
	}
	
	function getPerPage()
	{
		return $this->per_page;
	}
	
	function setOffset($offset)
	{
		$this->offset = $offset;
		
		return $this;
	}
	
	public static function getData()
	{
		return DeepCI_Page_PageBar_Data::get();
	}
	
	function getResult()
	{
		// order
		$sort = DeepCI_Page_PageBar_Data::getDqlSort();
		if(!empty($sort)) {
			$this->dql->orderBy($sort['field'].' '.$sort['type']);
		}
		
	
		/** 查詢數據 **/
		$offset			= $this->offset;
		$currentPage	= floor($offset/$this->per_page)+1;
		
		$resultsPerPage = $this->per_page;
		$pager = new Doctrine_Pager($this->dql, $currentPage, $resultsPerPage);
		
		$result =& $pager->execute();
		
		$this->numResults = $pager->getNumResults();
		
		return $result;
	}
	
	function getHtml()
	{
		$CI =& get_instance();
		
		/** 檢測出 uri_segment **/
		$uri_segment = 3;
		for ($i=3; $i<8; $i++)
		{
			if ($CI->uri->segment($i) == $this->offset)
			{
				$uri_segment = $i;
				break;
			}
		}
		
		/** 生成html **/
		$config['base_url']		= $this->base_url;
		$config['uri_segment']	= $uri_segment;
		$config['per_page']		= $this->per_page;
		$config['total_rows']	= $this->numResults;
		
		$config['first_link']	= '&lsaquo; 首頁';
		$config['next_link'] 	= '下頁 &#187;';
		$config['prev_link'] 	= '&#171; 上頁';
		$config['last_link'] 	= '末頁 &rsaquo;';
		$config['num_links']	= 5;
		
		$CI->load->library('pagination');
		$CI->pagination->initialize($config);
		$html = $CI->pagination->create_links();
		
		if ($html) {
			$html .= ' <a href="'.$this->base_url.'?per_page=all">顯示所有</a>';
		}
		
		$html2 = '每頁顯示<select name="per_page" onchange="window.location.href=\''.$this->base_url.'?per_page=\'+this.value"><option value="all">--</option>';
		foreach($this->selectPrePage as $i) {
			$selected = ($i==$this->per_page) ? 'selected' : '';
			$html2 .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
		}
		$html2 .= '</select>條，共'.$this->numResults.'條';
		
		$dql_order = '';
		$sort = DeepCI_Page_PageBar_Data::getDqlSort();
		if(!empty($sort)) {
			$dql_order = "sort_{$sort['type']}='{$sort['field']}'";
		}		
		
		return array('html'=>$html, 'select'=>$html2, 'sort'=>$dql_order);
	}
}