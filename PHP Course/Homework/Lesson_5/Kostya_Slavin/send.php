<?php 

class UserRegister {
    public $fname;
    public $lname;
    public $email;
    public $type;
    public $error = false;

    protected $curDate;
    protected $file;
    protected $fp;
    protected $regExp = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
    protected $fileContent;

    public function __construct($fn, $ln, $eml, $tp) {
        $this->fname = $fn;
        $this->lname = $ln;
        $this->email = $eml;
        $this->type = $tp;
    }

    public function checkData() {
        if ($this->fname === '' or $this->lname === '' or 
            $this->email === '' or $this->type === '') {
            $this->error = true;
            return true;
        }
    }

    public function checkEmail() {
        if (!preg_match($this->regExp, $this->email)) {
            $this->error = true;
            return true;
        }
    }

    public function checkNameLength() {
        if (strlen($this->fname) < 2) {
            $this->error = true;
            return true;
        }
    }
    

    public function checkUniq() {        
        if (!file_exists( $this->getFileName() )) {
            return false;
        } else {
            $this->fileContent = htmlentities(file_get_contents($this->getFileName()));            
            if (preg_match("/$this->email/", $this->fileContent)) {
                $this->error = true;
                return true;
            } else {
                $this->error = false;
                return false;
            }
             
        }
    }

    private function getFileName() {
        date_default_timezone_set('Europe/Kiev');
        $this->curDate = date("d_m_Y");
        $this->filename = "registration_".$this->curDate.".txt";
        return $this->filename;
    }


    public function addUser() {        
        $this->fp = fopen($this->getFileName(), "a") or die("can't open file");
        fwrite($this->fp, 'Имя: '.$this->fname.', Фамилия: '. $this->lname. ', email: '.$this->email.', Тип билета: '.$this->type."\r\n");
        fclose($this->fp);        
        $_SESSION['auth']['user'] = $this->fname;
        return true;
    }  
    
}


if (empty($_POST["fname"])) {    
    $checkEmail = new UserRegister(null, null, $_POST["email"], null);
    if ($checkEmail->checkUniq()) {
        echo 'error';
    } else {
        echo 'success';
    }

} else {
    $newUser = new UserRegister($_POST["fname"], $_POST["lname"], $_POST["email"], $_POST["type"]);


if ($newUser->checkData()) {
    echo 'All fields must be filled <br>';    
}

if ($newUser->checkEmail()) {
    echo 'Email is invalid <br>';    
}

if ($newUser->checkNameLength()) {
    echo 'Username is too short <br>';    
}

if ($newUser->checkUniq()) {
    echo 'Email already exist, try another';
} 

if (!$newUser->error) {
    $newUser->addUser();
    echo 'success';
}

}
