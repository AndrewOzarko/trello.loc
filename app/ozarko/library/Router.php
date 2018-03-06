<?php
namespace ozarko\library;

/**
* class Router (Singleton)
* Обробляє request
* Викликає необхідний controller
*/

class Router {

	private static $instance = null;
    /**
    * Роути
    */
    private static $routes;

    private static $di;

	/**
	* Щоб не можна було створити екземпляр класу
	*/
	private function __construct()     {   }
    private function __clone() {    }

    public static function getRoute($di) {
    	self::$di = $di; 
    	self::$routes = include($_SERVER[DOCUMENT_ROOT].'/app/config/routes.php');
        return (self::$instance === NULL) ? self::$instance = new self() : self::$instance;
    }

	private static function getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}
    public static function run() {
    	$uri = self::getURI();

    	$uri = (empty($uri)) ? "/" : $uri;

    	foreach (self::$routes as $url => $path) {
    		/**
    		* url - це роут і ми його порівнюємо з існуючими роутами
    		* path - це типу шлях до роута
    		*/
    		/*
    		preg_replace ( mixed $pattern , mixed $replacement , mixed $subject)
			Выполняет поиск совпадений в строке subject с шаблоном pattern и заменяет их на replacement.
			*/
	    	if(preg_match("~$url~", $uri)) {
	    		/**
	    		* В config/routes.php є роут :
	    		* 'user/([0-9]+)' => 'user/view/$1'
	    		* ми напр шлемо реквест trello.loc/user/1 - відобразити користувача з id 1
	    		* ця строчка(що нижче) бере урлу і шукає її в routes
	    		* натикається на регулярку user/([0-9]+)
	    		* і підставляє її(цифирку) в 'user/view/$1' (замість $1) 
	    		* таким чином я отримую роут /user/view/1
	    		*/
	    		$route = preg_replace("~$url~", $path, $uri);
	    		$segments = explode('/', $route);

	    		$controllerName = array_shift($segments).'Controller';
				$controllerName = ucfirst($controllerName);

				$actionName = lcfirst(array_shift($segments)).'Action';

				$parameters = $segments;

				$controllerFile = $_SERVER['DOCUMENT_ROOT'].'/app/controller/'.$controllerName.'.php';

				if(file_exists($controllerFile)) {
					include_once($controllerFile);
				}
				
				$controllerObject = new $controllerName(self::$di);
				/**
				* Викликаю метод $actionName -  і передаю йому всі параметри $parameters
				*/
				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);

				if ($result != null) {
					break;
				}
	    	}
	    }
    }
}