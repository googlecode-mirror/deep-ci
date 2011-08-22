
/**
 * <?php echo $ucfirst_controller_name;?> Controller
 */
class <?php echo $ucfirst_controller_name;?> extends CI_Controller {
	
	public $ViewBag = array();
	

	function __construct()
	{
		parent::__construct();
		
		$this->ViewBag['layout_title'] = '<?php echo $ucfirst_controller_name;?> 管理'; 
		$this->layout->setLayout('admin/layout/main');
	}
	
	// --------------------------------------------------------------------
	
	// GET
	// <?php echo $controller_base_url; ?> 
	function index($offset=0)
	{
		$this->ViewBag['layout_title'] .= ' > 列表';
		
		// search data
		$this->ViewBag['sData'] = DeepCI::getSearchData();
		
		// query dql
		$q = Doctrine_Query::create()
                ->from('<?php echo $Model_PdoName;?>')
				->orderBy('id desc');
		
		// pageBar
		$pageBar = DeepCI::getPageBar($q, $offset);
		// echo $pageBar->getSqlQuery();
		
		$this->ViewBag['listRows']	= $pageBar->getResult();
		$this->ViewBag['pageBar']	= $pageBar->getHtml();
		
		$this->layout->view();
	}
	
	// --------------------------------------------------------------------
	
	// GET
	// <?php echo $controller_base_url; ?>/add
	function add()
	{
		$this->ViewBag['layout_title'] .= ' > 添加';
		
		// 加載 jquery.validate.unobtrusive
		$this->layout->loadJs('validate.unobtrusive'); 
		
		$this->layout->view();
	}
	
	// --------------------------------------------------------------------
	
	// POST
	// <?php echo $controller_base_url; ?>/add_do
	function add_do()
	{
		// php 驗證
		$validation = DeepCI::createValidation('<?php echo $Model_PdoName;?>');
		if ( ! $validation->run($_POST)) {
			return page_message_error('add', $validation->getMessage());
		}
		
		// 添加
		try {
			${#member} = <?php echo $Model_Full_Name; ?>::save($_POST);
		} catch (Exception $e) {
			return page_message_error('add', $e->getMessage());
		}
		
		// 返回
		return page_message_success('index', '添加成功');
	}
	
	// --------------------------------------------------------------------
	
	// GET
	// <?php echo $controller_base_url; ?>/edit
	public function edit($id='')
	{
		$this->ViewBag['layout_title'] .= ' > 修改';
		
		// 加載 validate.unobtrusive
		$this->layout->loadJs('validate.unobtrusive');
		
		// 獲取 <?php echo $Model_PdoName;?> 
		$this->ViewBag['{#member}'] = <?php echo $Model_Full_Name; ?>::getTable()->find($id);
		if (empty($this->ViewBag['{#member}'] )) {
			return page_message_error('index', '<?php echo $Model_PdoName;?> 不存在');
		}
		
		$this->layout->view();
	}
	
	// --------------------------------------------------------------------
	
	// POST
	// <?php echo $controller_base_url; ?>/edit_do
	public function edit_do($id='')
	{
		// 獲取 <?php echo $Model_PdoName;?> 
		${#member} = <?php echo $Model_Full_Name; ?>::getTable()->find($id);
		if (empty(${#member})) {
			return page_message_error('index', '<?php echo $Model_PdoName;?> 不存在');
		}
		
		// php 驗證
		$validation = DeepCI::createValidation('<?php echo $Model_PdoName;?>');
		if ( ! $validation->run($_POST)) {
			return page_message_error('add', $validation->getMessage());
		}
		
		// 修改
		try {
			${#member} = <?php echo $Model_Full_Name; ?>::save($_POST, ${#member});
		} catch (Exception $e) {
			return page_message_error('edit/'.$id, $e->getMessage());
		}
		
		// 返回
		return page_message_success('edit/'.$id, '修改成功');
	}
	
	// --------------------------------------------------------------------
	
	// GET
	// <?php echo $controller_base_url; ?>/delete
	public function delete($id='')
	{
		// 刪除
		${#member} = <?php echo $Model_Full_Name; ?>::getTable()->find($id);
		if ( ! empty(${#member})) {
			${#member}->delete();
		}
		
		// 返回
		return page_message_success('index', '刪除成功');
	}
}
