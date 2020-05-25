<?php

include ('mysql_pafap_class.php');

class pafap_profile extends pafap_mysql
{
  private $_pid;
  private $_uid;
  private $_rlship;
  private $_nationality;
  private $_residence;
  private $_education;
  private $_infoid;
  private $_cid;     //array();
  private $_cname;   //array();
  private $_ctid;    //array();
  private $_ctname;  //array();
  private $_errors;
  private $_tmp;

  public function __construct()
  {
    $this->pafap_mysql();
    $this->_errors = array();
    $this->_cid = array();
    $this->_cname = array();
    $this->_ctid = array();
    $this->_ctname = array();
  }

  public function filter($data)
  {
    return preg_replace('/[^a-zA-Z0-9@_.]/','',$data);
  }

  public function query_profile($uid, $sql)
  {
    $this->ExecuteSQL($sql);
    if($this->iAffected < 1)
        $this->_errors[] = $this->strLastError;
  }

  public function show_errors()
  {
    return $this->_errors;
  }

  public function binder($sql, $fieldID, $fieldName)
  {
    $arr = array();
    $result = mysql_query($sql);
    while($row=mysql_fetch_assoc($result))
    {
      ($fieldID == "")? $arr[] = $row[$fieldName] : $arr[$row[$fieldID]] = $row[$fieldName];
    }
    return $arr;
  }

  public function getValueFromTable($sql)
  {
    $this->ExecuteSQL($sql);
    list($this->_tmp) = $this->iAssoc;
    return $this->_tmp;
  }

  public function getProfileID($uid)
  {
    $pid = "SELECT pid FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($pid);
  }

  public function getImagePath($uid)
  {
    $image = "SELECT image FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($image, $uid);
  }

  public function checkct($uid, $table, $field, $pid, $value)
  {
    $sql = "SELECT $field FROM $table WHERE pid = '{$pid}' AND $field = '{$value}'";
    $this->ExecuteSQL($sql);
    return ($this->iRecords > 0)? true : false;
  }

  public function bindInfo($uid)
  {
    $inf = array();
    $info = "SELECT pafap_users.fname, pafap_users.lname, pafap_users.email, pafap_users.role, pafap_users.owner, pafap_profile.* FROM pafap_users, pafap_profile WHERE pafap_users.uid = pafap_profile.uid AND pafap_profile.uid = {$uid}";
    $inf = $this->ArrayResults($info);
    return $inf;
  }

  public function bindCategories($uid)
  {
    $cat = array();
    $bcat = "SELECT ctname FROM pafap_profile_category_type WHERE pid = '{$this->getProfileID($uid)}'";
    $cat = $this->ArrayResults($bcat);
    return $cat;
  }

}
?>