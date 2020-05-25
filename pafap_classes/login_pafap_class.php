<?php

include ('mysql_pafap_class.php');

class pafap_login extends pafap_mysql
{
  private $_id;
  private $_email;
  private $_pass;
  private $_passmd5;

  private $_errors;
  private $_access;
  private $_login;
  private $_token;

  public function __construct()
  {
    $this->pafap_mysql();
    $this->_errors = array();
    $this->_login = isset($_POST['login'])? 1 : 0;
    $this->_access = 0;
    $this->_token = $_POST['token'];

    $this->_id = 0;
    $this->_email = ($this->_login)? $this->filter($_POST['txtemail']) : $_SESSION['email'];
    $this->_pass = ($this->_login)? $this->filter($_POST['txtpass']) : '';
    $this->_passmd5 = ($this->_login)? md5($this->_pass) : $_SESSION['password'];

  }

  public function isLoggedIn()
  {
    ($this->_login)? $this->CheckPost() : $this->CheckSession();

    return $this->_access;
  }

  public function filter($var)
  {
    return preg_replace('/[^a-zA-z0-9@_.]/','', $var);
  }

  public function CheckPost()
  {
    try
    {
      if (!$this->isTokenValid())
        throw new Exception('Invalid Form Submission!');

      if (!$this->isDataValid())
        throw new Exception('Invalid Form Data!');

      if (!$this->CheckDatabase())
        throw new Exception('Invalid Email/Password!');

      $this->_access = 1;
      $this->updateUserStatus(1);
      $this->registerSession();
      $this->_errors[] = 'Sucess!';
    }
    catch(Exception $e)
    {
      $this->_errors[] = $e->getMessage();
      $_SESSION['loginerror'] = $this->_errors;
    }
  }

  public function CheckSession()
  {
    if($this->sessionExist() && $this->CheckDatabase())
        $this->_access = 1;
  }

  public function CheckDatabase()
  {
    $sql = "SELECT uid FROM pafap_users WHERE email = '{$this->_email}' AND pass = '{$this->_passmd5}' AND role = 'user' OR email = '{$this->_email}' AND pass = '{$this->_passmd5}' AND role = 'admin'";
    $this->ExecuteSQL($sql);

    if ($this->iRecords > 0)
    {
      list($this->_id) = $this->iAssoc;
      return true;
    }
    else
    { return false; }
  }

  public function isDataValid()
  {
    return ($this->_checkEmail($this->_email))? 1 : 0;
  }

  public function isTokenValid()
  {
    return (!isset($_SESSION['token']) || $this->_token != $_SESSION['token'])? 0 : 1;
  }

  public function registerSession()
  {
    $_SESSION['uid'] = $this->_id;
    $_SESSION['email'] = $this->_email;
    $_SESSION['password'] = $this->_passmd5;
    $_SESSION['cid'] = $this->getCategory();
  }

  public function sessionExist()
  {
    return (isset($_SESSION['email']) && isset($_SESSION['password']))? 1 : 0;
  }

  public function showErrors()
  {
    return $this->_errors;
  }

  public function _checkEmail($email)
  {
  	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if (preg_match($regex, $email))
    {
      $this->SecureData($email);
      return true;
    }
    else
    { return false; }
  }

  public function updateUserStatus($status)
  {
    $updateuserstatus = "UPDATE pafap_users SET status = '{$status}' WHERE uid = '{$this->_id}'";
    $this->ExecuteSQL($updateuserstatus);
  }
  
  public function getCategory()
  {
    $tmp = 0;
    $sql = "SELECT pafap_profile_category.cid FROM pafap_profile, pafap_profile_category WHERE pafap_profile.uid = '{$this->_id}' AND pafap_profile.pid = pafap_profile_category.pid LIMIT 1";
    $this->ExecuteSQL($sql);
    if ($this->iRecords > 0)
    {
      list($tmp) = $this->iAssoc;
      return $tmp;
    }
    else
    { return 0; }
  }
  
}


?>