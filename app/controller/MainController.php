<?php
class MainController extends ozarko\library\Controller {
	public function indexAction() {
		$this->di->check->access(false);
		include ($_SERVER['DOCUMENT_ROOT'].'/app/view/index.phtml');
	}

	public function loginAction() {
		$this->di->check->access(false);
		include ($_SERVER['DOCUMENT_ROOT'].'/app/view/login.phtml');
	}
}