<?php

require_once 'autoload.php';
require_once 'config.php';

use app\Dispatcher;


try {
	session_start();

	$data = empty($_GET['r']) 
		? array() 
		: explode('/', $_GET['r']);

	$dispatcher = new Dispatcher($data);
	$dispatcher->dispatch();

} 
catch (\Exception $e) {
	// TODO: Error handler to catch app specific case errors
}
