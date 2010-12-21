<?php
// system/application/plugins/doctrine_pi.php

// load Doctrine library
require_once BASEPATH.'/plugins/Doctrine/Doctrine.php';

// load database configuration from CodeIgniter
require_once APPPATH.'/config/database.php';

// this will allow Doctrine to load Model classes automatically
spl_autoload_register(array('Doctrine', 'autoload'));

// we load our database connections into Doctrine_Manager
// this loop allows us to use multiple connections later on
foreach ($db as $connection_name => $db_values) {

	// first we must convert to dsn format
	$dsn = $db[$connection_name]['dbdriver'] .
		'://' . $db[$connection_name]['username'] .
		':' . $db[$connection_name]['password'].
		'@' . $db[$connection_name]['hostname'] .
		'/' . $db[$connection_name]['database'];

	Doctrine_Manager::connection($dsn,$connection_name);	
}

// CodeIgniter's Model class needs to be loaded
# require_once BASEPATH.'/libraries/Model.php';


//set charSet
Doctrine_Manager::getInstance()->getCurrentConnection()->setCharset($db['default']['char_set']);

// set to use modelsAutoload.
spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));

// Set the model loading to conservative/lazy loading
Doctrine_Manager::getInstance()->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_CONSERVATIVE);


// telling Doctrine where our models are located 
Doctrine_Core::loadModels(APPPATH.'models/generated');
Doctrine_Core::loadModels(APPPATH.'models');


