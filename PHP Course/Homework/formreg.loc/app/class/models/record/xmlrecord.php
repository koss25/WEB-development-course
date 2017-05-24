<?php 

class XmlRecord {
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
