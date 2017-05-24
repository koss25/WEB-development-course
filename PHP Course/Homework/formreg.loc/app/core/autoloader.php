<?php

class Autoloader {
	static public $ext = '.php';

	// static public function loadDbClass ($class_name) {
	// 	$class = strtolower($class_name);
	// 	$file = PATH.'/app/database/'.$class.self::$ext;
	// 	if (file_exists($file)) {
	// 		require_once $file;
	// 	}
	// }

	static public function loadCoreClass ($class_name) {
		$class = strtolower($class_name);
		$file = PATH.'/app/core/'.$class.self::$ext;
		if (file_exists($file)) {
			require_once $file;
		}
	}

	static public function loadRecordClass ($class_name) {
		$class = strtolower($class_name);
		$file = PATH.'/app/class/models/record/'.$class.self::$ext;
		if (file_exists($file)) {
			require_once $file;
		}
	}

}
