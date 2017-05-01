<?php

class RegisterModel {

	static public $fname, $lname, $email, $type, $array;
	static $dt = false;
	static public $errorAr = [];
	static protected $curDate,	$filename, $fp;
	static protected $mailRegExp = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
	static protected $userRegExp = "/^(?=.{2,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
	static protected $table = <<<SQL
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

	static public function init($data) {
		self::$fname = $data["fname"];
		self::$lname = $data["lname"];
		self::$email = $data["email"];
		self::$type = $data["ticket"];
		self::$array = $data;
		// self::printData();
	}

	/*=== Live email checking ===*/
	static public function initEmail($email) {
		self::$email = $email;
		self::existEmail();
		self::showError();
	}
	

	/*=== Checking user input's ===*/
	static public function checkData() {
		if (self::$fname === "" OR self::$lname === "" OR 
			self::$email === "" OR self::$type === null) {
			return self::errorMessages("All fields must be filled and radio button - selected");
		}
	}

	static public function checkEmail() {
		if (!preg_match(self::$mailRegExp, self::$email)) {
			return self::errorMessages("Email is invalid");
		}
	}

	static public function checkFullName() {
		if (!preg_match(self::$userRegExp, self::$fname) || !preg_match(self::$userRegExp, self::$lname)) {
			return self::errorMessages("Firstname / Lastname  is invalid");
		}
	}

	/*=== Puting error messages ===*/
	static public function errorMessages($message) {
		array_push(self::$errorAr, $message);
		return self::$errorAr;
	}
	
	/*=== Checking exist table ===*/
	static public function checkTable() {
		try {
			$sql = "SELECT id FROM `users` LIMIT 1";
			$result = Database::$pdo->query($sql);
			return true;
		} catch (PDOException $e) {
			$error = 'Error in line: '. $e->getLine() .', class: '. __CLASS__ .' - '. $e->getMessage();
			LogErrors::writeError($error);
			Database::addTable(self::$table);
			return true;
		}
	}

	/*=== Show error messages ===*/
	static public function showError() {
		foreach(self::$errorAr as $key=>$value) {
			echo $value."<br>";
		}
	}

	/*=== Simple middleware ===*/
	static public function check() {
		self::checkData();
		self::checkFullName();
		self::checkEmail();
		self::existEmail();
		if ( count(self::$errorAr) ) {
			self::showError();
		} else {
			self::addData();
		}
	}

	/*=== Adding data to table ===*/
	static public function addData() {
		if (self::checkTable()) {
			$sql = "INSERT INTO `users`
								(`firstname`, `lastname`, `email`, `ticket_type`)
									VALUES (?,?,?,?)";
			if (Database::dataQuery($sql, self::$array)) {
				echo 'success';
			}
		}
	}

	/*=== Avoid email duplicate ===*/
	static public function existEmail() {
		Database::connect();
		$dataQuery = [self::$email, date("Y-m-d")."%"];
		$sql = "SELECT firstname, lastname FROM `users`
							WHERE `email`= ? AND `register_date` LIKE ?";
		if(Database::dataQuery($sql, $dataQuery)) {
			$res = Database::dataQuery($sql, $dataQuery);
			return self::errorMessages("Dear, " .$res['firstname']. " " . $res['lastname']. "!".
																 "<br>You have been already registered today.
																	<br>Try tomorrow or enter another email.");
		}
	}

	// static public function printData() {
	// 	echo self::$fname;
	// 	echo self::$lname;
	// 	echo self::$email;
	// 	echo self::$type;
	// 	exit;
	// }

}