<?php

class IndexController extends Controller {
	function action_index() {
		$this->view->generate('index.php', 'template.php');
	}
}