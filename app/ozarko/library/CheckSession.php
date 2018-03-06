<?php 
namespace ozarko\library;

class CheckSession {

	private $di;
	private $user;

	public function __construct($di) {
		$this->di = $di;
		$this->user = null;
		$this->start();
	}

	public function start() {
		if (isset($_COOKIE['sess'])) {
			$sess = htmlspecialchars(($_COOKIE['sess']));
 			$this->user = $this->di->db::run("SELECT * FROM User WHERE sess=? LIMIT 1;", [$sess])->fetch();
 			if ($this->user['sess'] != $sess) {
 				setcookie('sess', '');
				header ("Location: /");	
				exit();
 			} 
		} 
	}
	/**
	* $access false - тільки для гостей
	* $access true - для користувачів
	*/
	public function access($access) {
		if(isset($this->user) && $access == false) {
			$_SESSION['error'] = "Ви вже авторизавані";
			header("Location: /dashboard");
			exit();
		}
		if(!isset($this->user) && $access == true) {
			$_SESSION['error'] = "Авторизуйтесь";
			header("Location: /login");
			exit();
		}
	}
   
}