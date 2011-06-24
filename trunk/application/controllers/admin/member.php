<?php
/**
 * 會員管理
 */
class Member extends CI_Controller {
	
	public $ViewBag = array();
	

	function __construct()
	{
		parent::__construct();
		
		$this->ViewBag['layout_title'] = 'member 管理'; 
		$this->layout->setLayout('admin/layout/main');
	}
	
	// --------------------------------------------------------------------
	
	// GET
	// /admin/member
	function index($offset=0)
	{
		$this->ViewBag['layout_title'] .= ' > 列表';
		
		// query dql
		$q = Doctrine_Query::create()
                ->from('PdoMember')
				->orderBy('id desc');
		
		//page bar
		$pageBar = DeepCI::getPageBar($q, $offset);
		$this->ViewBag['listRows']	= $pageBar->getResult();
		$this->ViewBag['pageBar']	= $pageBar->getHtml();
		
		$this->layout->view();
	}
	
	// --------------------------------------------------------------------
	
	// GET
	// /admin/member/add
	function add()
	{
		$this->ViewBag['layout_title'] .= ' > 添加';
		
		// 加載 jquery.validation
		$this->layout->loadJs('validation'); 
		
		$this->layout->view();
	}
	
	// --------------------------------------------------------------------
	
	// POST
	// /admin/member/add_do
	function add_do()
	{
		// php 驗證
		$validation = DeepCI::createValidation('PdoMember');
		if ( ! $validation->run($_POST)) {
			return page_message_error('add', $validation->getMessage());
		}
		
		// 嘗試添加
		try {
			$member = Model_Member::add($_POST);
		} catch (Exception $e) {
			return page_message_error('add', $e->getMessage());
		}
		
		// 返回
		return page_message_success('index', '添加成功');
	}
	
	// --------------------------------------------------------------------
	
	// GET
	// /admin/member/edit
	public function edit($id='')
	{
		$this->ViewBag['layout_title'] .= ' > 修改';
		
		// 加載 jquery.validation
		$this->layout->loadJs('validate');
		
		// 獲取 PdoMember
		$this->ViewBag['member'] = Model_Member::getTable()->find($id);
		if (empty($this->ViewBag['member'] )) {
			return page_message_error('index', 'PdoMember 不存在');
		}
		
		$this->layout->view();
	}
	
	// --------------------------------------------------------------------
	
	// POST
	// /admin/member/edit_do
	public function edit_do($id='')
	{
		// 獲取 PdoMember
		$member = Model_Member::getTable()->find($id);
		if (empty($member)) {
			return page_message_error('index', 'PdoMember 不存在');
		}
		
		// php 驗證
		$validation = DeepCI::createValidation('PdoMember');
		if ( ! $validation->run($_POST)) {
			return page_message_error('add', $validation->getMessage());
		}
		
		// 嘗試添加
		try {
			$member = Model_Member::edit($_POST, $member);
		} catch (Exception $e) {
			return page_message_error('edit/'.$id, $e->getMessage());
		}
		
		// 返回
		return page_message_success('edit/'.$id, '修改成功');
	}
	
	// --------------------------------------------------------------------
	
	// GET
	// /admin/member/delete
	public function delete($id='')
	{
		// 刪除
		$member = Model_Member::getTable()->find($id);
		if ( ! empty($member)) {
			$member->delete();
		}
		
		// 返回
		return page_message_success('index', '刪除成功');
	}
}
