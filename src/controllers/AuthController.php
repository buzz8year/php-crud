<?php

namespace controllers;

use app\View;
use app\UserAuth;
use models\User;
use helpers\Url;


class AuthController extends BaseController
{
	// EXPLAIN: ...
	public function login() : void
	{
		if (UserAuth::isUserAuthenticated()) {
			$_SESSION['flash']['message'] = 'Authenticated';
			$this->redirect();
		}

		// EXPLAIN: ...
		if (!empty($_POST)) 
		{
			$login = $_POST['login'];
			$password = $_POST['password'];

			$user = User::getByLogin($login);

			if (!empty($user) && password_verify($password, $user->getPasswordHash()) === true)
			{
				UserAuth::setAuthenticatedUser($user);
				$this->user = $user;
				$this->redirect();
			}
			else
			{
				$_SESSION['flash']['message'] = 'Login or password is incorrect';
				$this->refresh();
			}

		}

		// EXPLAIN: ...
		$data = array(
			'message' => $_SESSION['flash']['message'] ?? null,
			'form_action' => Url::getCurrentPath(),
			'basepath' => Url::getBasePath(),
		);

		$this->view('login', $data);
	}


	// EXPLAIN: ...
	public function logout() : void
	{
		if (UserAuth::isUserAuthenticated()) 
		{
			UserAuth::clearAuthenticatedUser();
			$_SESSION['flash']['message'] = 'Signed out';
			$this->user = null;
		}

		$this->redirect();
	}

}