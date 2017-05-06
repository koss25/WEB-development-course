<?php

class RegisterController extends Controller {

	public function action_index() {
		$regModel = new RegisterModel();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!empty($_POST['live'])) {
				$regModel->initEmail($_POST['email']);
			} else {
				$result = [];
				$rawPost = json_decode(file_get_contents("php://input"));
				mb_parse_str($rawPost, $result);
				$regModel->init($result);
				$regModel->check();
			}
		} else {
			$this->view->generate('register.php', 'template.php');
		}
	}
}