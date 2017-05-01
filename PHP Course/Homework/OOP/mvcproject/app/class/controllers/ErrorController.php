<?php

class ErrorController extends Controller {
	public function action_index() {
		$this->view->generate('error.php', 'template.php');
	}
}