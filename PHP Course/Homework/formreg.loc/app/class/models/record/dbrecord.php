<?php

class DbRecord {
	public $fname, $lname, $email, $type, $array;	
	public $errorAr = [];
	protected $curDate,	$filename, $fp;
	private $mailRegExp = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
	private $userRegExp = "/^(?=.{2,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
	private $table = <<<SQL
CREATE TABLE users (
		id int(11) NOT NULL AUTO_INCREMENT,
		firstname varchar(50) NOT NULL,
		lastname varchar(50) NOT NULL,
		email varchar(50) NOT NULL,
		ticket_type varchar(20) NOT NULL,
		register_date timestamp NOT NULL default CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11;
SQL;

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
		$this->existEmail();
		if ( count($this->errorAr) ) {
			$this->showError();
		} else {
			$this->addData();
		}
	}

	/*=== Adding data to table ===*/
	public function addData() {
		if ($this->checkTable()) {
			$sql = "INSERT INTO `users`
								(`firstname`, `lastname`, `email`, `ticket_type`)
									VALUES (?,?,?,?)";
			if (Database::dataQuery($sql, $this->array)) {
				echo 'success';
			}
		}
	}

	/*=== Avoid email duplicate ===*/
	public function existEmail() {
		Database::connect();
		$dataQuery = [$this->email, date("Y-m-d")."%"];
		$sql = "SELECT firstname, lastname FROM `users`
							WHERE `email`= ? AND `register_date` LIKE ?";
		if(Database::dataQuery($sql, $dataQuery)) {
			$res = Database::dataQuery($sql, $dataQuery);
			return $this->errorMessages("Dear, " .$res['firstname']. " " . $res['lastname']. "!".
																 "<br>You have been already registered today.
																	<br>Try tomorrow or enter another email.");
		}
	}

	public function printData() {
		print_r($this->array);
	}

}