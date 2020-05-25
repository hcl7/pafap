<?php
//include ('mysql_pafap_class.php');

class pafap_chat extends pafap_mysql
{
  private $_errors;
  private $_tmp;
  private $_fid;

  public function __construct()
  {
    $this->pafap_mysql();
    $this->_fid = array();
    $this->_errors = array();
  }

  public function getValueFromTable($sql)
  {
    $this->ExecuteSQL($sql);
    list($tmp) = $this->iAssoc;
    return $tmp;
  }

  public function getUserName($uid)
  {
    $user = "SELECT CONCAT(fname, lname) FROM pafap_users WHERE uid = '{$uid}'";
    return $this->getValueFromTable($user);
  }

  public function sd($data)
  {
    return mysql_real_escape_string($data);
  }

  public function getFriendsId($uid)
  {
    $fsql = "SELECT fuid FROM pafap_friends WHERE uid = '{$uid}'";
    return $this->ArrayResults($fsql);
  }

  public function getUsersByFid($fid)
  {
    foreach($fid as $key=>$value)
    {
      $sql = "SELECT * FROM pafap_users WHERE status = 1 AND uid = {$value[0]} ORDER BY fname DESC";
      $tmpusr = $this->ArrayResults($sql);
      if(!empty($tmpusr))
      {
        list($this->_tmp) = $tmpusr;
        $this->_fid[] = $this->_tmp;
      }
    }
    return $this->_fid;
  }

  public function getImagePath($uid)
  {
    $image = "SELECT image FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($image);
  }
}
?>
