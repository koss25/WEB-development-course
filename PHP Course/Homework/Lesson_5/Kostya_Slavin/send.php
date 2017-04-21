<?php 

class UserRegister {
	public $fname;
	public $lname;
	public $email;
	public $type;
	public $error = false;
	public $errorAr = [];
	protected $curDate;
	protected $filename;    
	protected $fp;
	protected $regExp = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
	protected $userRegExp = "/^(?=.{2,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
	
	public function __construct($fn, $ln, $eml, $tp) {
		$this->fname = $fn;
		$this->lname = $ln;
		$this->email = $eml;
		$this->type = $tp;
	}

	public function checkData() {
		if ($this->fname === "" or $this->lname === "" or 
				$this->email === "" or $this->type === null) {
				return $this->errorMessages("All fields must be filled and radio button - selected");
		}
	}

	public function checkEmail() {
		if (!preg_match($this->regExp, $this->email)) {
				return $this->errorMessages("Email is invalid");
		}
	}

	public function checkFullName() {
		if (!preg_match($this->userRegExp, $this->fname) || !preg_match($this->userRegExp, $this->lname)) {
				return $this->errorMessages("Firstname / Lastname  is invalid");
		}
	}
	
	public function checkUniq() {
		if (!file_exists( $this->getFileName() )) {
				return false;
		} else {
			foreach (glob("*.txt") as $filename) {
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

	public function addUser() {
		$this->fp = fopen($this->getFileName(), "a+") or die("can't open file");
		fwrite($this->fp, $this->fname.", ".$this->lname.", ".$this->email.", ".$this->type."\r\n") or die("can't write data");
		fclose($this->fp);
		return "success";
	}

	public function errorMessages($message) {
		array_push($this->errorAr, $message);
		return $this->errorAr;
	}
	
}

$result = [];
$rawPost = json_decode(file_get_contents("php://input"));
mb_parse_str($rawPost, $result);

if (!empty($_POST["live"])) {
	$checkEmail = new UserRegister(null, null, $_POST["email"], null);
	$checkEmail->checkUniq();
	
	if ( count($checkEmail->errorAr) ) {
		echo "error";
	} 

} else {
	$newUser = new UserRegister($result["fname"], $result["lname"], $result["email"], $result["ticket"]);
	$newUser->checkData();
	$newUser->checkFullName();
	$newUser->checkEmail();
	$newUser->checkUniq();

	if ( count($newUser->errorAr) ) {
		foreach($newUser->errorAr as $key=>$value) {
			echo $value."<br>";
		}
	} else {
		echo $newUser->addUser();
	}
}
