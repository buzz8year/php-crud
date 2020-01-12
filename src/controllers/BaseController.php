<?php

namespace controllers;

use app\View;
use helpers\Url;


// EXPLAIN: BaseController is prefered over ControllingInterface, /
// since if it was interface, we would have to implement below /
// methods in each controller class; yet, that implementations /
// would be completely same in both controllers classes, which /
// turns out meaningless in the furtherance of this goal.

class BaseController
{
	public $user;
	public $view;


	public function __construct()
	{
	}


	// EXPLAIN: ...
	protected function refresh()
	{
		// EXPLAIN: Refreshing page
		header('Location: ' . Url::getCurrentPath());
		die;
	}


	// EXPLAIN: ...
	protected function redirect(string $query = null)
	{
		// EXPLAIN: ...
		header('Location: ' . Url::getBasePath() . $query);
		die;
	}


	protected function view(string $template, array $data)
	{
		// EXPLAIN: ...
		$view = new View($template);
		$view->render($data);

		unset($_SESSION['flash']);
	}

}