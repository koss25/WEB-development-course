<?php

class LogErrors {
	static public function writeError($error) {
		date_default_timezone_set("Europe/Kiev");
		$curDate = date("d_m_Y");
		$curDate_time = date("H:i:s  d-m-Y");
		$filename = "../app/log/errorLog_".$curDate.".txt";
		$file = fopen($filename, 'a+') or die('cant create file');	
		fwrite($file, $curDate_time . ' ' . $error ."\r\n")  or die("can't write data");
		fclose($file);
	}
}