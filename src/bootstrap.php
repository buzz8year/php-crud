<?php

require_once 'autoload.php';
require_once 'config.php';


use app\Dispatcher;

try {
	session_start();

	$data = [];
	if (!empty($_GET['r'])) {
		$data = explode('/', $_GET['r']);
	}

	// EXPLAIN: ...
	$dispatcher = new Dispatcher($data);
	$dispatcher->dispatch();

	// IMPORTANT! All below must be replaced with full-fledged dispatcher and controllers' orchestrator


} 
catch (\Exception $e) {

	// TODO: Error handler to catch app specific case errors

}
