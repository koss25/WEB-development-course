<?php
ob_start();
session_start();

class RegisterController extends Controller {

	public function action_index() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$dataForm = [];
				$rawPost = json_decode(file_get_contents("php://input"));
				mb_parse_str($rawPost, $dataForm);
				// print_r($dataForm);
			if ($dataForm['captcha'] === $_SESSION['string']) {
				$typeRecord = StorageFactory::getTypeRecord($dataForm['record']);
				$typeRecord->init($dataForm);
				$typeRecord->check();
			} else {
				echo 'Wrong captcha';
			}

		} else {
			$this->view->generate('register.php', 'template.php');
		}
	}
}
