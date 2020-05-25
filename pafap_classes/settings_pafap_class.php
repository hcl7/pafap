<?php

include ('mysql_pafap_class.php');

class pafap_settings extends pafap_mysql
{
  private $_email;
  private $_pass;
  private $_tmp;

  public function __construct()
  {
    $this->pafap_mysql();
  }

  public function getValue($sql)
  {
    $this->ExecuteSQL($sql);
    if ($this->iRecords > 0)
    {
      list($oldtmp) = $this->iAssoc;
      return true;
    }
    else
    return false;
  }

  public function email_exists($table, $field, $email)
  {
    $query = "SELECT $field FROM $table WHERE $field = '{$email}'";
    $this->ExecuteSQL($query);
    return($this->iRecords > 0)? 1 : 0;
  }
  public function filter($var)
  {
    return preg_replace('/[^a-zA-Z0-9@_.]/','',$var);
  }
  public function runQuery($sql)
  {
    $this->ExecuteSQL($sql);
    return $this->strLastError;
  }

  public function updatePage($rn, $lnk, $ruid)
  {
    $sql = "UPDATE pafap_users SET fname = '{$rn}', email = '{$lnk}' WHERE uid = '{$ruid}'";
    return $this->ExecuteSQL($sql);
  }
}
?>