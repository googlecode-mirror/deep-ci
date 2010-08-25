<?php
/**
 * 管理員管理，管理員登錄、登出
 */
class User_controller extends Controller {

	function User_controller()
	{
		parent::Controller();
		
		$action = $this->uri->segment(3);
		if($action!='login'&&$action!='logout') {
			//admin check
		}

		$this->layout->setLayout('admin/layout/main');
	}
	
	/**
	 * admin 列表
	 */
	function index()
	{
		if(!$this->Admin->islogin()) {
			redirect('/admin/user/login', 'refresh');
			exit;
		}
		
		if(!$this->Admin->isAllow($this->_qxStr)) {
			redirect('/admin/', 'refresh');
			exit;
		}

		$this->layout->loadJs('mootools');
		$this->layout->setData('title','管理員設定 > 列表');
		
		$data = array();
		$data['listRows'] = $this->Admin->getList();
		$this->layout->view('admin/user/list', $data);
	}
	
	function add()
	{
		if(!$this->Admin->islogin()) {
			redirect('/admin/user/login', 'refresh');
			exit;
		}

		if(!$this->Admin->isAllow($this->_qxStr)) {
			redirect('/admin/', 'refresh');
			exit;
		}
		
		$this->layout->loadJs('mootools','validator');
		$this->layout->setData('title','管理員設定 > 添加');
		
		$data = array();
		$data['qxArr'] = $this->Admin->getAllQx();
		$this->layout->view('admin/user/add', $data);
		
		//添加用户
		if(!empty($_POST['form_id'])&&$_POST['form_id']=='add'
			&&$_POST['username']!==''&&$_POST['passwd']!=='') 
		{
			if($this->Admin->hasUser($_POST['username'])){
				js()->alert('用戶名重復！');
				js()->goto(site_url('admin/user/add'));
				exit;
			}
			
			$res = $this->Admin->add(array_trim($_POST));
			if($res) {
				js()->alert('添加成功');
				js()->goto(site_url('admin/user'));
				exit;
			}
		}
	}
	
	function edit()
	{
		if(!$this->Admin->islogin()) {
			redirect('/admin/user/login', 'refresh');
			exit;
		}

		if(!$this->Admin->isAllow($this->_qxStr)) {
			redirect('/admin/', 'refresh');
			exit;
		}
		
		$this->layout->loadJs('mootools','validator');
		$this->layout->setData('title','管理員設定 > 修改');
		
		$aid = $this->uri->segment(4);
		if(empty($aid))
			redirect('/admin/user', 'refresh');
		$admin = $this->Admin->getInfo($aid);
		
		//update
		$data = array_trim($_POST);
		if(!empty($data)&&$data['username']!='') {
			if($data['username']!=$admin['username']
				&&$this->Admin->hasUser($data['username'])){
				js()->alert('用戶名重復！');
				js()->goto(site_url('admin/user/edit/'.$aid));
				exit;
			}
			
			if(empty($data['passwd']))
				unset($data['passwd']);
				
			$this->Admin->updateAdmin($data);
			js()->alert('修改成功');
			js()->goto(site_url('admin/user/edit/'.$aid));
		}
		
		//show
		$reArr = array();
		$qxStr = trim($admin['qx'],',');
		$qxArr = $this->Admin->getAllQx();
		$myQx = (empty($qxStr)) ? array() : explode(',',$qxStr);
		foreach($qxArr as $k=>$v) {
			$tmp = array();
			$tmp['k'] = $k;
			$tmp['v'] = $v;
			$tmp['s'] = (in_array($k,$myQx)) ? true : false;
			
			$reArr[] = $tmp;
		}
		
		$data = array();
		$data['aid'] = $aid;
		$data['adminInfo'] = $admin;
		$data['qxArr'] = $reArr;
		$this->layout->view('admin/user/edit', $data);
	}
	
	function del()
	{
		if(!$this->Admin->islogin()) {
			redirect('/admin/user/login', 'refresh');
			exit;
		}

		if(!$this->Admin->isAllow($this->_qxStr)) {
			redirect('/admin/', 'refresh');
			exit;
		}
		
		$aid = $this->uri->segment(4);
		if(empty($aid))
			redirect('/admin/user', 'refresh');
		
		$this->Admin->del($aid);
		js()->alert('刪除成功');
		js()->goto(site_url('admin/user'));
	}
	

	function login()
	{
		$this->load->view('admin/login');
		
		$da = array_trim($_POST);
		if(!empty($da['username'])&&!empty($da['password'])) {
			if(AdminCurrentUser::login($da['username'],$da['password'])) {
				redirect('/admin/', 'refresh');
			} else {
				js()->alert('用戶名或密碼錯誤');
				js()->goto('admin/user/login');
			}
		}
		
	}
	
	function logout()
	{
		AdminCurrentUser::logout();
		js()->alert('登出成功');
		js()->goto('admin');
	}
	
}
