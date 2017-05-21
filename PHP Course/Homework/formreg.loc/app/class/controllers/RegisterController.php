<?php
ob_start();
session_start();

class RegisterController extends Controller {

	public function action_index() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$result = [];
				$rawPost = json_decode(file_get_contents("php://input"));
				mb_parse_str($rawPost, $result);

			if ($result['captcha'] === $_SESSION['string']) {
				$typeRecord = StorageFactory::getTypeRecord($result['record']);
				$typeRecord->init($result);
				$typeRecord->check();
			} else {
				echo 'Wrong captcha';
			}

		} else {
			$this->view->generate('register.php', 'template.php');
		}
	}
}
