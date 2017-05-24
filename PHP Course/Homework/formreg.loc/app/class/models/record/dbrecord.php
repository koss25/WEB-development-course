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

	use DataRecord;

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

}