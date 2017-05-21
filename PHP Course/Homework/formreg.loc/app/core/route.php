<?php

class Route {

	static function init() {
		
		$controller_name = 'Index';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		
		if (!empty($routes[1])) {
			$controller_name = ucfirst($routes[1]);
		}
		

		if (!empty($routes[2])) {
			$action_name = $routes[2];
		}

	 	$model_name = $controller_name.'Model';
		$controller_name = $controller_name.'Controller';
		$action_name = 'action_'.$action_name;

		$model_file = ucfirst($model_name).'.php';

		$model_path = PATH.'/app/class/models/'.$model_file;
		if (file_exists($model_path)) {
			require $model_path;
		}

		$controller_file = ucfirst($controller_name).'.php';
		$controller_path = PATH.'/app/class/controllers/'.$controller_file;
		
		try {
			if (file_exists($controller_path)) {
				require $controller_path;
			} else {
				throw new Exception($controller_path.' not exist' );
			}
		} catch (Exception $e) {
			$error = 'Error in line: '. $e->getLine() .', class: '. __CLASS__ .' - '. $e->getMessage();
			LogErrors::writeError($error);
			self::errorPage();
		}
		
		$controller = new $controller_name;
		$action = $action_name;

		try {
			if ( method_exists($controller, $action) ) {
				$controller->$action();
			} else {
				throw new Exception($controller.'doesn\'t has '.$action. ' method');
			}
		} catch(Exception $e) {
			$error = 'Error in line: '. $e->getLine() .', class: '. __CLASS__ .' - '. $e->getMessage();
			LogErrors::writeError($error);
			self::errorPage();
		}
	}

	static function errorPage() {
		header("Status: 404 Not Found");
		header('Location:'.ERROR_ROUTE);
		exit;
	}

}



?>