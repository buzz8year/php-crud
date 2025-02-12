<?php

namespace app;

use helpers\Url;


class Dispatcher
{
	const DEFAULT_METHODNAME = 'index';

	protected $className;
	protected $methodName;


	// NOTE: Assign request array data to controller and method relatively
	public function __construct(array $data)
	{
		$this->className = ucfirst($data[0] ?? DEFAULT_CONTROLLER_NAME);
		$this->methodName = strval($data[1] ?? self::DEFAULT_METHODNAME);
	}

	
	public function dispatch()
	{
		if (empty($this->className)) 
		{
			header('Location: ' . Url::getCurrentPath());
			die;
		}
		else {
			// NOTE: Format assumed controller namespace and 
			// instantiate a new controller-object of that very namespace.
			// If method not exists, set error-404 header and exit/die.
			$className = '\controllers\\' . $this->className . 'Controller';
			$objController = new $className();

			if (method_exists($objController, $this->methodName))
			{
				$objController->{$this->methodName}();
			}
			else {
				header('HTTP/2.0 404');
				die;
			}

		}

	}

}
