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
	public function refresh()
	{
		header('Location: ' . Url::getCurrentPath());
		die;
	}

	public function redirect(string $query = null)
	{
		header('Location: ' . Url::getBasePath() . $query);
		die;
	}

	public function view(string $template, array $data)
	{
		$view = new View($template);
		$view->render($data);

		unset($_SESSION['flash']);
	}

}
