<?php

namespace controllers;

use app\View;
use helpers\Url;
use interfaces\ControllerInterface;


// EXPLAIN: Extendable BaseController class is prefered over interface, /
// since if it was interface, we would have to implement below /
// methods in each controller class; yet, that implementations /
// would be completely same in all controllers classes, which /
// turns out meaningless in the furtherance of this goal.

class BaseController implements ControllerInterface
{
	public $user;
	public $view;


	// EXPLAIN: ...
	public function refresh()
	{
		// EXPLAIN: Refreshing page
		header('Location: ' . Url::getCurrentPath());
		die;
	}


	// EXPLAIN: ...
	public function redirect(string $query = null)
	{
		// EXPLAIN: ...
		header('Location: ' . Url::getBasePath() . $query);
		die;
	}


	public function view(string $template, array $data)
	{
		// EXPLAIN: ...
		$view = new View($template);
		$view->render($data);

		unset($_SESSION['flash']);
	}

}