<?php

class deppci_helper extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 默認頁面
	 */
	public function index()
	{
		$data = array();
		
		$maker = new DeepCI_Tool_Doctrine();
		$data['pdos'] = $maker->getAllPdoModels();
		
		$this->load->view('deepci_helper/index',$data);
	}
	
	/**
	 * 更新 models 表文件
	 */
	public function update_models()
	{
		$data = array();
		
		// 忽略Models
		$ignore = array();
		
		$maker = new DeepCI_Tool_Doctrine();
		$maker->setIgnoreModels($ignore);
		
		$data['result'] = $maker->updateModels();
		$data['result'] =  implode('<br>',$data['result']);
		
		$this->load->view('deepci_helper/update_models', $data);
	}
	
	public function create_controllers()
	{
		parse_str($_SERVER['QUERY_STRING'],$_GET);
		
		if(empty($_GET['pdo_name']))
			die('PdoName empty');
		if(empty($_GET['vire_url']))
			die('ViewUrl empty');
		
		$pdo_name = $_GET['pdo_name'];
		$vire_url = $_GET['vire_url'];
		
		$data = array();
		$data['vire_url'] = $vire_url;
		
		$maker = new DeepCI_Tool_Controller();
		
		try {
			$data['result'] = $maker->create($pdo_name, $vire_url);
		} catch (Exception $e) {
			die($e->getMessage());
		}
		
		$data['result'] =  implode('<br>',$data['result']);
		
		$this->load->view('deepci_helper/create_controllers', $data);
	}
}