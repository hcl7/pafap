<?php

include ('mysql_pafap_class.php');

class pafap_message extends pafap_mysql
{
  private $_errors;
  private $_tmp;

  public function __construct()
  {
    $this->pafap_mysql();
    $this->_errors = array();
  }

  public function filter($data)
  {
    return preg_replace('/[^a-zA-Z0-9@_.]/','',$data);
  }

  public function show_errors()
  {
    return $this->_errors;
  }

  public function msGet($uid)
  {
    $sql="SELECT pafap_users.*, pafap_messages.*, pafap_profile.image FROM pafap_users, pafap_messages, pafap_profile WHERE pafap_users.uid = pafap_messages.fromUID AND pafap_users.uid = pafap_profile.uid AND pafap_messages.toUID = '{$uid}' ORDER BY pafap_messages.date_created DESC";
    return $this->ArrayResults($sql);
  }

  public function msSend($from, $to, $notes)
  {
     $sql = "INSERT INTO pafap_messages (fromUID, toUID, notes, status, date_created) VALUES ('{$from}', '{$to}', '{$this->sd($notes)}', 0, now())";
     return ($this->ExecuteSQL($sql))? true : false;
  }

  public function msDelete($msid)
  {
     $sql = "DELETE FROM pafap_messages WHERE mid = '{$msid}'";
     return ($this->ExecuteSQL($sql))? true : false;
  }

  public function getValueFromTable($sql)
  {
    $this->ExecuteSQL($sql);
    list($this->_tmp) = $this->iAssoc;
    return $this->_tmp;
  }

  public function getFriendsByUid($uid)
  {
    $sql = "select pafap_users.fname, pafap_users.lname, pafap_profile.image, pafap_friends.* from pafap_users, pafap_profile, pafap_friends where pafap_users.uid = pafap_profile.uid and pafap_friends.fuid = pafap_profile.uid and pafap_friends.uid = '{$uid}'";
    $this->_fid = $this->ArrayResults($sql);
    return $this->_fid;
  }

  public function changeMsStatus($msID)
  {
    $sql = "UPDATE pafap_messages set status = 1 WHERE mid = '{$msID}'";
    $this->ExecuteSQL($sql);
  }

  public function sd($data)
  {
    return mysql_real_escape_string($data);
  }

}
?>