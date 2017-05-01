<?php

class RegisterController extends Controller {

	public function __construct() {
		$this->view = new View();
	}

	public function action_index() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!empty($_POST['live'])) { 
				RegisterModel::initEmail($_POST['email']);
			} else {
				$result = [];
				$rawPost = json_decode(file_get_contents("php://input"));
				mb_parse_str($rawPost, $result);
				RegisterModel::init($result);
				RegisterModel::check();
			}
		} else {
			$this->view->generate('register.php', 'template.php');
		}
	}
}