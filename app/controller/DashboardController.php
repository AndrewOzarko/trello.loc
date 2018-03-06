<?php
include $_SERVER['DOCUMENT_ROOT'].'/app/model/Dashboard.php';
include $_SERVER['DOCUMENT_ROOT'].'/app/model/Task.php';
class DashboardController extends ozarko\library\Controller {
	public function indexAction() {
		$this->di->check->access(true);
		$dashboard = new Dashboard($this->di);
		$dashboards = $dashboard->getAll();

		$task = new Task($this->di);
		$tasks = $task->getAll();

		include ($_SERVER['DOCUMENT_ROOT'].'/app/view/dashboard/index.phtml');
	}

	public function addAction() {
		$this->di->check->access(true);
		if (isset($_POST)) {
			$name = htmlspecialchars($_POST['name']);
			if (empty($name)) {
				$_SESSION['error'] = "Назва таск блоку не може бути пустою";
				header('Location: /dashboard');
				exit;
			}

			$dashboard = new Dashboard($this->di);

			if($dashboard->create($name)) {
				header('Location: /dashboard');
				exit;
			}

		}
	}

	public function taskAction() {
		$this->di->check->access(true);
		if (isset($_POST)) {
			$desc = htmlspecialchars($_POST['desc']);
			$dashid = htmlspecialchars($_POST['dashid']);
			
			if (empty($desc) || empty($dashid)) {
				$_SESSION['error'] = "Таск не може бути пустим";
				header('Location: /dashboard');
				exit;
			}

			$task = new Task($this->di);

			if($task->create($desc, $dashid)) {
				header('Location: /dashboard');
				exit;
			}

		}
	}
}