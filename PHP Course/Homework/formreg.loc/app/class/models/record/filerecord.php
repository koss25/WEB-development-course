<?php 

class FileRecord {
	public $fname, $lname, $email, $type;
	public $errorAr = [];
	protected $curDate,	$filename, $fp;
	protected $mailRegExp = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
	protected $userRegExp = "/^(?=.{2,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
  
	use DataRecord;

	public function existEmail() {
		if (!file_exists("../lib/regFiles/".$this->getFileName() )) {
      if (!file_exists("../lib/regFiles/")){
        mkdir("../lib/regFiles", 0777, true);
      }
			return false;
		} else {
			foreach (glob("../lib/regFiles/*.txt") as $filename) {
				$file = fopen($filename, "r") or die("can't open file");
					if ($file) {
						while($buf = fgets($file)) {
							$dataAr = explode(",", $buf);
							if ( substr($dataAr[2], 1) === $this->email ) {
								if ($filename === $this->getFileName()) {
									return  $this->errorMessages("Email already exist. <br>
									You registered today.");
								} else {
								return  $this->errorMessages("Email already exist. <br>
								You registered today.");
								}
							}
						}
					}
					fclose($file);
				}
			}
		}

	private function getFileName() {
		date_default_timezone_set("Europe/Kiev");
		$this->curDate = date("d_m_Y");
		$this->filename = "registration_".$this->curDate.".txt";
		return $this->filename;
	}

	public function addData() {
		$this->fp = fopen("../lib/regFiles/".$this->getFileName(), "a+") or die("can't open file");
		fwrite($this->fp, $this->fname.", ".$this->lname.", ".$this->email.", ".$this->type."\r\n") or die("can't write data");
		fclose($this->fp);
		echo "success";
	}

}

// You registered on ".implode("/", explode("_", substr($filename,-14,10))));