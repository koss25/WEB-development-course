<?php

class Database {
	static protected $table = 'users';
	static protected $db = 'Kostya_Slavin';
	static public $pdo; 
 
	static public function connect() {
		try {
			self::$pdo = new PDO(DB_CONFIG, USER, PASS);
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$pdo->exec("CREATE DATABASE IF NOT EXISTS ".self::$db."");
			self::$pdo->exec("use ".self::$db."");
			return self::$pdo;
		} catch(PDOException $e) {
			LogErrors::writeError($e->getMessage());
			Route::errorPage();
		}
	}

	static public function addTable($sql) {
		try {
			if (self::$pdo->exec($sql)) {
				return true;
			}
		} catch (PDOException $e) {
			$error = 'Error in line: '. $e->getLine() .', class: '. __CLASS__ .' - '. $e->getMessage();
			LogErrors::writeError($error);
	 }
	}


	static public function dataQuery($sql, $array = null) {
			try {
				$dataArray = [];
				if (gettype($array) !== 'array') {
					array_push($dataArray, $array);
				} else {
					foreach($array as $value) {
							array_push($dataArray, $value);
					}
				}
				$result = self::$pdo->prepare($sql);
				$res = $result->execute($dataArray);
				if ($sql[0] === "I" or $sql[0] === "i") {
					return $res;
				} elseif ($sql[0] === "S" or $sql[0] === "s") {
					$row = $result->fetch(PDO::FETCH_ASSOC);
					return $row;
				}
			} catch (PDOException $e) {
				$error = 'Error in line: '. $e->getLine() .', class: '. __CLASS__ .' - '. $e->getMessage();
				LogErrors::writeError($error);
			}
	}

}