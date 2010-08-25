<?php

class Welcome_controller extends Controller {

	function Welcome_controller()
	{
		parent::Controller();
		
		if(AdminCurrentUser::user()===false){
			redirect('/admin/user/login', 'refresh');
		}
		
		$this->layout->setLayout('admin/layout/main');
	}
	
	function index()
	{
		$data = array();
		$data['layout_title'] = '首頁';
		
		
		$this->layout->view('admin/index',$data);
	}
}