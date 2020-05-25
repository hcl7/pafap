<?php

include ('mysql_pafap_class.php');

class pafap_panel extends pafap_mysql
{
  private $_id;
  private $_email;
  private $_pass;
  private $_passmd5;

  private $_errors;
  private $_access;
  private $_login;
  private $_token;
  private $_listInvi;

  public function __construct()
  {
    $this->pafap_mysql();
    $this->_errors = array();
    $this->_listInvi = array();
    $this->_login = isset($_POST['login'])? 1 : 0;
    $this->_access = 0;
    $this->_id = 0;
    $this->_email = ($this->_login)? $this->filter($_POST['txtpemail']) : $_SESSION['pemail'];
    $this->_pass = ($this->_login)? $this->filter($_POST['txtppass']) : '';
    $this->_passmd5 = ($this->_login)? md5($this->_pass) : $_SESSION['ppassword'];
  }

  public function _count($sql)
  {
    $this->ExecuteSQL($sql);
    ($this->iAssoc)? list($this->_results) = $this->iAssoc : $this->_results = 0;
  }

  public function show_results()
  {
    return $this->_results;
  }

  public function _runQuery($sql)
  {
    $this->ExecuteSQL($sql);
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
      if (!$this->isDataValid())
        throw new Exception('Invalid Form Data!');

      if (!$this->CheckDatabase())
        throw new Exception('Invalid Email/Password!');

      $this->_access = 1;
      $this->registerSession();
      $this->_errors[] = 'Sucess!';
    }
    catch(Exception $e)
    {
      $this->_errors[] = $e->getMessage();
    }
  }

  public function CheckSession()
  {
    if($this->sessionExist() && $this->CheckDatabase())
        $this->_access = 1;
  }

  public function CheckDatabase()
  {
    $sql = "SELECT uid FROM pafap_users WHERE email = '{$this->_email}' AND pass = '{$this->_passmd5}' AND role = 'admin'";
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

  public function registerSession()
  {
    $_SESSION['puid'] = $this->_id;
    $_SESSION['pemail'] = $this->_email;
    $_SESSION['ppassword'] = $this->_passmd5;
  }

  public function sessionExist()
  {
    return (isset($_SESSION['pemail']) && isset($_SESSION['ppassword']))? 1 : 0;
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

  public function notificationUsers()
  {
    $sql = "SELECT pafap_invitations.iid, pafap_users.fname, pafap_users.lname, pafap_users.email FROM pafap_invitations, pafap_users WHERE pafap_invitations.iid = pafap_users.uid AND pafap_invitations.status = 0";
    return $this->ArrayResults($sql);
  }

  public function deleteAccount($email)
  {
    $delusers = "DELETE FROM pafap_users WHERE email = '{$email}'";
    $delprofile = "DELETE FROM pafap_profile WHERE uid = ";
  }

  public function getLastRegistered()
  {
    $sql = "SELECT fname, lname, email FROM pafap_users WHERE uid = (SELECT MAX(uid) FROM pafap_users WHERE role = 'user')";
    return $this->ArrayResults($sql);
  }

  public function getValueFromTable($sql)
  {
    $this->ExecuteSQL($sql);
    list($val) = $this->iAssoc;
    return $val;
  }

  public function postNews($alb, $eng)
  {
    $news = "UPDATE pafap_news SET noteAlb = '{$alb}', noteEng = '{$eng}', date_modified = now()";
    return $this->ExecuteSQL($news);
  }

}
?>