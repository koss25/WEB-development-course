<?php 

class FileRecord {
	public $fname, $lname, $email, $type;
	public $errorAr = [];
	protected $curDate,	$filename, $fp;
	protected $mailRegExp = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
	protected $userRegExp = "/^(?=.{2,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";

  public function init($data) {
		$this->type = isset($data["ticket"]) ? $data["ticket"] : null;
		$this->fname = $data["fname"];
		$this->lname = $data["lname"];
		$this->email = $data["email"];
		$this->array = array_slice($data, 0, 4);
		// $this->printData();
	}

	public function checkData() {
		if ($this->fname === "" or $this->lname === "" or 
				$this->email === "" or $this->type === null) {
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

  public function errorMessages($message) {
		array_push($this->errorAr, $message);
		return $this->errorAr;
	}

  /*=== Show error messages ===*/
	public function showError() {
		foreach($this->errorAr as $key => $value) {
			echo $value."<br>";
		}
	}


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

	public function existEmail() {
		if (!file_exists("../lib/regFiles/".$this->getFileName() )) {
      if (!file_exists("../lib/regFiles/")){
        mkdir("../lib/regFiles", 0777, true);
      }
			return false;
		} else {
			foreach (glob("../lib/regFiles/*.txt") as $filename) {
        // echo $filename;
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
								You registered on ".implode("/", explode("_", substr($filename,-14,10))));
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
