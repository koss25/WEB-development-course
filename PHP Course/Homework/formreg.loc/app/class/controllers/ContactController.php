<?php

class ContactController extends Controller {
	public function action_index() {
		$this->view->generate('contact.php', 'template.php');
	}
}