<?php

namespace controllers;

use models\Task;

use app\UserAuth;
use app\View;

use helpers\Url;
use helpers\Validator;
use helpers\Strings;


// EXPLAIN: ...
class TaskController extends BaseController
{
	const PAGE_FIRST = 1;
	const PAGE_LIMIT = 3;

	// EXPLAIN: ...
	public $prepared;

	private $args;
	private $countAll;
	private $sortInvert;



	// EXPLAIN: ...
	public function __construct() 
	{
		$this->countAll = (int)Task::countAll();
	}



	// EXPLAIN: ...
	private function processGet() : void
	{
		// EXPLAIN: ...
		$toSesssion = [
			'sort' => Task::SORT_DEFAULT,
			'page' => self::PAGE_FIRST,
		];

		// EXPLAIN: ...
		if (empty($_GET['page'])) 
		{
			$toSession['page'] = self::PAGE_FIRST;
		} 
		else 
		{
			$toSession['page'] = $_GET['page'];
		}


		// EXPLAIN: ...
		if (!empty($_GET['sort'])) 
		{
			$toSession['sort'] = $_GET['sort'];
			$this->sortInvert = boolval(strpos($_GET['sort'], '-') === false);

			if (!$this->sortInvert && ltrim($_GET['sort'], '-') === $_SESSION['args']['sort']) 
			{
				$toSession['page'] = intval($_SESSION['page-amount']);
			}

		}
		elseif (!empty($_SESSION['args']['sort'])) 
		{
			$toSession['sort'] = $_SESSION['args']['sort'];
		}	
		else 
		{
			$toSession['sort'] = Task::SORT_DEFAULT;
		}



		// EXPLAIN: ...
		if (isset($_SESSION['args']) && empty(array_diff($toSession, $_SESSION['args']))) 
		{
			// var_dump($toSession);
			// var_dump($_SESSION);
		}
		else 
		{
			$_SESSION['args'] = $toSession;
			$query = '?r=task&sort=' . $toSession['sort'] . '&page=' . $toSession['page'];

			$this->redirect($query);

		}

	}




	// EXPLAIN: Default
	public function index() : void
	{
		// EXPLAIN: ...
		$this->processGet();

        $limit = self::PAGE_LIMIT;
        $offset = $limit * ((int)$_SESSION['args']['page'] - 1);
        $orderBy = Strings::prepareOrderBy($_SESSION['args']['sort'], Task::SORT_DEFAULT);

		$this->prepared = Task::getSlice($orderBy, $limit, $offset);


		// EXPLAIN: ...
		$pages = intval($this->countAll / self::PAGE_LIMIT) + intval($this->countAll % self::PAGE_LIMIT > 0 ? 1 : 0);
		$_SESSION['page-amount'] = $pages;

		// EXPLAIN: ...
		$data = array(
			'pages' 		=> $pages,
			'tasks' 		=> $this->prepared,
			'page' 			=> $_SESSION['args']['page'],
			'sort' 			=> ltrim($_SESSION['args']['sort'], '-'),
			'message' 		=> empty($_SESSION['flash']['message']) ? null : $_SESSION['flash']['message'],
			'inout_string' 	=> UserAuth::isUserAuthenticated() ? 'out' : 'in',
			'sort_invert' 	=> $this->sortInvert ? '-' : '',
			'current_path' 	=> Url::getCurrentPath(),
			'base_path' 	=> Url::getBasePath(),
		);

		$this->view('list', $data);
	}






	// EXPLAIN: Create new task
	public function create() : void
	{
		// EXPLAIN: ...
		if (!empty($_POST) && $this->validate()) 
		{
			$task = new Task();

			if ($task->create($_POST))
			{
				$_SESSION['flash']['message'] = 'Task has been successfully created';
				$_SESSION['args']['sort'] = '-id';
				$this->redirect();
			}
		}

		// EXPLAIN: ...
		$data = [
			'message' => empty($_SESSION['flash']['message']) ? null : $_SESSION['flash']['message'],
			'form_action' => Url::getCurrentPath(),
			'basepath' => Url::getBasePath(),
		];

		$this->view('create', $data);
	}


	// EXPLAIN: ...
	public function update() : void
	{
		// EXPLAIN: ...
		if (UserAuth::isUserAuthenticated()) 
		{
			// EXPLAIN: ...
			if (!empty($_GET['id'])) 
			{
				$task = Task::get($_GET['id']);

				// EXPLAIN: ...
				if (!empty($task) && !empty($_POST) && $this->validate()) 
				{
					if ($_POST['task_text'] === $task->getText()) 
					{
						$_SESSION['flash']['message'] = 'Nothing changed, not updated';
						$this->refresh();
					}

					if ($task->update($_POST))
					{
						$_SESSION['flash']['message'] = 'Task has been successfully updated';
						$this->refresh();
					}
				}

				// EXPLAIN: ...
				$data = array(
					'task' => $task,
					'message' => empty($_SESSION['flash']['message']) ? null : $_SESSION['flash']['message'],
					'form_action' => Url::getCurrentPath() . '&id=' . $task->getId(),
					'basepath' => Url::getBasePath(),
				);

				$this->view('update', $data);
			}
			else
			{
				$_SESSION['flash']['message'] = 'ID provided is bad';
				$this->redirect();
			}

		}
		else
		{
			$_SESSION['flash']['message'] = 'You do not have enough rights';
			$this->redirect();
		}

	}




	// EXPLAIN: ...
	public function finalize() : void
	{
		if (UserAuth::isUserAuthenticated()) 
		{
			// EXPLAIN: ...
			if (!empty($_POST['id']) && ($task = Task::get($_POST['id']))) 
			{
				// EXPLAIN: ...
				if ($task->update(['task_status' => Task::STATUS_COMPLETED]))
				{
					$_SESSION['flash']['message'] = 'Task #' . $task->getId() . ' has been successfully completed';
				}
			}
		}
		else
		{
			$_SESSION['flash']['message'] = 'You do not have enough rights';
		}

	}




	// EXPLAIN: ...
	protected function validate() : bool
	{
		if (empty($_POST['task_usermail']) || empty($_POST['task_name']) || empty($_POST['task_text'])) 
		{
			$_SESSION['flash']['message'] = 'Please, fill in all fields.';
			return false;
		}

		if (!Validator::is_email($_POST['task_usermail'])) 
		{
			$_SESSION['flash']['message'] = 'Email seems to be invalid, - please, check if you spell it correctly.';
			return false;
		}

		if (!Validator::is_alnum($_POST['task_name'])) 
		{
			$_SESSION['flash']['message'] = 'Task name must contain letters and digits only.';
			return false;
		}

		return true;
	}




}