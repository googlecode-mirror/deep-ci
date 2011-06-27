<?php

class Helper extends CI_Controller {

	/**
	 * Ĭ�J���
	 */
	public function index()
	{
		$data = array();
		
		$maker = new DeepCI_Tool_Doctrine();
		$data['pdos'] = $maker->getAllPdoModels();
		
		$this->load->view('helper/index',$data);
	}
	
	/**
	 * ���� models ���ļ�
	 */
	public function update_models()
	{
		$data = array();
		
		$maker = new DeepCI_Tool_Doctrine();
		$data['result'] = $maker->updateModels();
		$data['result'] =  implode('<br>',$data['result']);
		
		$this->load->view('helper/update_models', $data);
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
		
		$this->load->view('helper/create_controllers', $data);
	}
}