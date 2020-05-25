<?php

include ('mysql_pafap_class.php');

class pafap_SignUp extends pafap_mysql
{
  private $fname;
  private $lname;
  private $email;
  private $remail;
  private $sex;
  private $birthday;
  private $password;
  private $repass;
  private $passmd5;
  private $errors;
  private $token;

  public function __construct()
  {
    $this->pafap_mysql();
    $this->errors = array();
    $this->fname = $this->filter($_POST['txtname']);
    $this->lname = $this->filter($_POST['txtlname']);
    $this->email = $this->filter($_POST['txtmail']);
    $this->remail = $this->filter($_POST['txtremail']);
    $this->sex = $this->filter($_POST['sex']);
    $this->birthday = $this->filter($_POST['year']."-".$_POST['month']."-".$_POST['day']);
    $this->password = $this->filter($_POST['txtpass']);
    $this->token = $_POST['signuptoken'];
    $this->passmd5 = md5($this->password);
  }

  public function process()
  {
    if ($this->validate_token() && $this->validate_form())
    {
      $this->iAffected = 0;
      $users = "INSERT INTO pafap_users (fname, lname, email, sex, birthday, pass, status, role, date_created) VALUES ('{$this->fname}', '{$this->lname}', '{$this->email}', '{$this->sex}', '{$this->birthday}', '{$this->passmd5}', 0, 'user', now())";
      $this->register($users);
      $uid = mysql_insert_id();
      $profile = "INSERT INTO pafap_profile (uid) VALUES ('{$uid}')";
      $this->register($profile);
      $this->addCategories($uid);
      if ($this->iAffected > 0)
        $this->errors[] = 'Success!';
      return true;
    }
    return false;
  }

  public function filter($var)
  {
    return preg_replace('/[^a-zA-Z0-9@_.]/','',$var);
  }

  public function email_exists($table, $field)
  {
    $query = "SELECT $field FROM $table WHERE $field = '{$this->email}'";
    $this->ExecuteSQL($query);
    return($this->iRecords > 0)? 1 : 0;
  }

  public function register($sql)
  {
    $this->ExecuteSQL($sql);
    if($this->iAffected < 1)
        $this->errors[] = $this->strLastError;
  }

  public function show_errors()
  {
    return $this->errors;
  }

  public function validate_form()
  {
    if(empty($this->fname) || empty($this->lname) || empty($this->email) || empty($this->remail)
       || empty($this->birthday) || empty($this->password))
        $this->errors[] = 'Please, Fill The Form!';
    else
    {
      if(!$this->compareEmail($this->email, $this->remail))
        $this->errors[] = 'Re-Enter The Same E-mail!';
      else
      {
        if(!$this->checkEmail($this->email))
          $this->errors[] = 'Invalid Email!';
        else
        {
          if($this->email_exists("pafap_users", "email"))
            $this->errors[] = 'Sory, Email Already In Use!';
        }
      }
    }
    return count($this->errors)? 0 : 1;
  }

  public function validate_token()
  {
    if (!isset($_SESSION['signuptoken']) || $this->token != $_SESSION['signuptoken'])
        $this->errors[] = 'Invalid Submission!';
    return count($this->errors)? 0 : 1;
  }

  public function checkEmail($email)
  {
  	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if (preg_match($regex, $email))
        return true;
    else
        return false;
  }

  public function compareEmail($mail, $remail)
  {
    return (strcmp($mail, $remail))? 0 : 1;
  }

  public function getProfileID($uid)
  {
    $pid = "SELECT pid FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($pid);
  }

  public function getValueFromTable($sql)
  {
    $this->ExecuteSQL($sql);
    list($this->_tmp) = $this->iAssoc;
    return $this->_tmp;
  }

  public function addCategories($uid)
  {
    $pid = $this->getProfileID($uid);
    $catArray = array(array("Art", 101), array("Sport", 102), array("Games", 105));
    $ctArray = array(array("Music", 101), array("Football", 102), array("Angry-Birds-Space", 105));
    foreach($catArray as $c=>$v)
    {
      $catg = "INSERT INTO pafap_profile_category (pid, cid, cname) VALUES ('{$pid}', '{$v[1]}', '{$v[0]}')";
      $this->register($catg);
    }
    foreach($ctArray as $ct=>$vt)
    {
      $cattype = "INSERT INTO pafap_profile_category_type (pid, cid, ctname) VALUES ('{$pid}', '{$vt[1]}', '{$vt[0]}')";
      $this->register($cattype);
    }
  }
}
?>