<?php
include $_SERVER['DOCUMENT_ROOT'].'/app/model/Dashboard.php';
class DashboardController extends ozarko\library\Controller {
	public function indexAction() {
		$this->di->check->access(true);
		$dashboard = new Dashboard($this->di);
		$dashboards = $dashboard->getName();
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
}