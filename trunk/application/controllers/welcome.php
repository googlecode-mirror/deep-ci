<?php

class Welcome_controller extends Controller {

	function Welcome_controller()
	{
		parent::Controller();
		
		$this->layout->setLayout('layout/base');
	}
	
	function index()
	{
		$this->layout->view('index');
	}
	
	function mk_pdo()
	{
		Doctrine_Core::generateModelsFromDb(dirname(BASEPATH).'/var/pdos');
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */