<?php
include $_SERVER['DOCUMENT_ROOT'].'/app/model/User.php';
class RegistrationController extends ozarko\library\Controller {
	public function indexAction() {

		$this->di->check->access(false);

		if(isset($_POST)) {
			$name = htmlspecialchars($_POST['name']);
			$email = htmlspecialchars($_POST['email']);
			$password = htmlspecialchars($_POST['password']);
			$passRep = htmlspecialchars($_POST['passrep']);

			if (empty($name) || empty($email) || empty($password) || empty($passRep)) {
				$_SESSION['error'] = "Всі поля мають бути заповненні";
				header('Location: /');
				exit;
			}

			if (strcmp($password, $passRep)!=0) {
				$_SESSION['error'] = "Паролі не співпадають";
				header('Location: /');
				exit;
			}

			$user = new User($this->di);

			if ($user->emailExists($email)) {
				$_SESSION['error'] = "Такий користувач вже існує";
				header('Location: /');
				exit;
			}

			if ($user->create($name, md5($password), $email, md5($password.$email.time()))) {
				setcookie("sess", md5($password.$email.time()), time()+3600); 
				header('Location: /dashboard');
				exit;
			} 

		}
	}


	public function loginAction() {
		$this->di->check->access(false);
		if(isset($_POST)) {
			$email = htmlspecialchars($_POST['email']);
			$password = htmlspecialchars($_POST['password']);

			if (empty($email) || empty($password)) {
				$_SESSION['error'] = "Всі поля мають бути заповненні";
				header('Location: /login');
				exit;
			}

			$user = new User($this->di);

			if (!$user->emailExists($email)) {
				$_SESSION['error'] = "Такий користувач не існує";
				header('Location: /login');
				exit;
			}

			$aut = $user->getByEmail($email);

			if($aut['email'] == $email && $aut['password'] == md5($password)) {
				if($user->updateSess(md5($password.$email.time()), $email)) {
					setcookie("sess", md5($password.$email.time()), time()+3600); 
					header('Location: /dashboard');
					exit;
				}
			}
		}
	}
}