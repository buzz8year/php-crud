<?php

spl_autoload_register( function($className) {
	$exp = explode('\\', $className);
	$path = implode('/', $exp);

	include_once '../src/' . $path . '.php';
});