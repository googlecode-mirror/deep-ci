<?php

class Tool extends CI_Controller {

	/**
	 * Ĭ�J���
	 */
	public function index()
	{
		$this->load->view('tool/welcome_message');
	}
	
	/**
	 * ���� ORM ���ļ�
	 */
	public function updatePdo()
	{
		$maker = new DeepCI_Tool_Doctrine();
		$maker->updatePdo();
		
		$this->load->view('tool/updatePdo');
	}
}