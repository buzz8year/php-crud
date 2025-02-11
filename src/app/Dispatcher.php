<?php

namespace app;

use helpers\Url;


class Dispatcher
{
	const DEFAULT_METHODNAME = 'index';

	protected $className;
	protected $methodName;


	// EXPLAIN: ...
	public function __construct(array $data)
	{
		$this->className = ucfirst($data[0] ?? DEFAULT_CONTROLLER_NAME);
		$this->methodName = strval($data[1] ?? self::DEFAULT_METHODNAME);
	}


	// EXPLAIN: ...
	public function dispatch()
	{
		// EXPLAIN: ...
		if (empty($this->className)) 
		{
			header('Location: ' . Url::getCurrentPath());
			die;
		}
		else
		{
			$className = '\controllers\\' . $this->className . 'Controller';
			$objController = new $className();

			if (method_exists($objController, $this->methodName))
			{
				$objController->{$this->methodName}();
			}
			else 
			{
				header('HTTP/2.0 404');
				die;
			}

		}

	}

}
