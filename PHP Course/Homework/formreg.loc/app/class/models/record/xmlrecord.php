<?php 

class XmlRecord {
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
        $this->createFile();
        return false;
		} else {
        $doc = new DOMDocument();
        $doc->load("../lib/regFiles/".$this->getFileName());
        $email = $doc->getElementsByTagName("email");
        foreach($email as $value) {
          if ($value->nodeValue === $this->email) {
          return  $this->errorMessages("Email already exist. <br>
            You registered today.");
          }
        }
			}
		}

	private function getFileName() {
		date_default_timezone_set("Europe/Kiev");
		$this->curDate = date("d_m_Y");
		$this->filename = "registration_".$this->curDate.".xml";
		return $this->filename;
	}

  public function createFile() {
    $domtree = new DOMDocument('1.0', 'UTF-8');
    $xmlRoot = $domtree->createElement("RegisterData");
    $domtree->appendChild($xmlRoot);
    $domtree->save("../lib/regFiles/".$this->getFileName());
  }

	public function addData() {
    $doc = new DOMDocument('1.0', 'UTF-8');
    $doc->formatOutput = true;
    $doc->preserveWhiteSpace = false;

    $doc->load("../lib/regFiles/".$this->getFileName());
    $user = $doc->createElement('user');
    $doc->firstChild->appendChild($user);

    $firstname = $doc->createElement('firstname', $this->fname);
    $user->appendChild($firstname);
    $lastname = $doc->createElement('lastname', $this->lname);
    $user->appendChild($lastname);
    $email = $doc->createElement('email', $this->email);
    $user->appendChild($email);
    $ticketType = $doc->createElement('ticketType', $this->type);
    $user->appendChild($ticketType);

    if($doc->save("../lib/regFiles/".$this->getFileName())) {
      echo 'success';
    }

	}

}
