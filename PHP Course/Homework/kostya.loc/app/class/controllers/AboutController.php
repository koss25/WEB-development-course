<?php

class AboutController extends Controller {
	public function action_index() {
		$this->view->generate('about.php', 'template.php');
	}
}