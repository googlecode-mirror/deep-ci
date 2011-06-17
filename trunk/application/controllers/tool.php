<?php

class Tool extends CI_Controller {

	/**
	 * 默認頁面
	 */
	public function index()
	{
		$this->load->view('tool/welcome_message');
	}
	
	/**
	 * 更新 ORM 表文件
	 */
	public function updatePdo()
	{
		$maker = new DeepCI_Tool_Doctrine();
		$maker->updatePdo();
		
		$this->load->view('tool/updatePdo');
	}
}