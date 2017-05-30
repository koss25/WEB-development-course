<?php

trait DataRecord {

	public function init($data) {
		$this->type = isset($data["ticket"]) ? $data["ticket"] : null;
		$this->fname = $data["fname"];
		$this->lname = $data["lname"];
		$this->email = $data["email"];
		$this->array = array_slice($data, 0, 4);
		// $this->printData();
	}

  /*=== Live email checking ===*/
	public function initEmail($email) {
		$this->email = $email;
		$this->existEmail();
		$this->showError();
	}
	

	/*=== Checking user input's ===*/
	public function checkData() {
		if ($this->fname === "" OR $this->lname === "" OR 
			$this->email === "" OR $this->type === null) {
			return $this->errorMessages("All fields must be filled and radio button - selected");
		}
	}

	public function checkEmail() {
		if (!preg_match($this->mailRegExp, $this->email)) {
			return $this->errorMessages("Email is invalid");
		}
	}

	public function checkFullName() {
		if (!preg_match($this->userRegExp, $this->fname) || !preg_match($this->userRegExp, $this->lname)) {
			return $this->errorMessages("Firstname / Lastname  is invalid");
		}
	}

	/*=== Puting error messages ===*/
	public function errorMessages($message) {
		array_push($this->errorAr, $message);
		return $this->errorAr;
	}
	
	/*=== Checking exist table ===*/
	public function checkTable() {
		try {
			$sql = "SELECT id FROM `users` LIMIT 1";
			$result = Database::$pdo->query($sql);
			return true;
		} catch (PDOException $e) {
			$error = 'Error in line: '. $e->getLine() .', class: '. __CLASS__ .' - '. $e->getMessage();
			LogErrors::writeError($error);
			Database::addTable($this->table);
			return true;
		}
	}

	/*=== Show error messages ===*/
	public function showError() {
		foreach($this->errorAr as $key => $value) {
			echo $value."<br>";
		}
	}

	/*=== Simple middleware ===*/
	public function check() {
		$this->checkData();
		$this->checkFullName();
		$this->checkEmail();
		$this->getEmails();
		$this->existEmail();
		if ( count($this->errorAr) ) {
			$this->showError();
		} else {
			$this->addData();
		}
	}

}