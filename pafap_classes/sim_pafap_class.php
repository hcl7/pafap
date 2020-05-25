<?php
class pafap_similarities extends pafap_mysql
{
  private $_sim;
  private $_invi;
  private $_usr;
  private $_usrbypid;
  private $_tmp;
  private $_pid;
  private $_simPid;
  private $_nat;
  private $_fid;
  public function __construct()
  {
    $this->_sim = array();
    $this->_invi = array();
    $this->_usr = array();
    $this->_simPid = array();
    $this->_usrbypid = array();
    $this->_fid = array();
    $this->pafap_mysql();
    $this->_pid = $this->getProfileID($_SESSION['uid']);
  }

  public function getSim()
  {
    return $this->_sim;
  }

  public function getInvi()
  {
    return $this->_invi;
  }

  public function getUsr()
  {
    return $this->_usr;
  }

  public function filterSim($uid)
  {
    $tmp = array();
    $getPIDsim = "select distinct n1.pid, n1.ctname from pafap_profile_category_type n1 join pafap_profile_category_type n2 on n1.ctname = n2.ctname and n1.pid != n2.pid and n1.pid != {$this->_pid} and n2.pid = {$this->_pid}";
    $this->_simPid = $this->ArrayResults($getPIDsim);
    foreach ($this->_simPid as $key=>$pid)
    {
      if(!in_array($pid['pid'], $tmp))
      {
        $tmp[] = $pid['pid'];
        $userbypid = "SELECT pafap_users.*, pafap_profile.image FROM pafap_users, pafap_profile WHERE pafap_users.uid = pafap_profile.uid AND pafap_profile.pid = {$pid['pid']} AND pafap_users.uid NOT IN (SELECT fuid FROM pafap_friends WHERE pafap_friends.uid = '{$uid}') AND pafap_users.uid NOT IN (SELECT fid FROM pafap_follows WHERE pafap_follows.fuid = '{$uid}')";
        list($this->_tmp) = $this->ArrayResults($userbypid);
        $this->_sim[] = $this->_tmp;
      }
    }
    return $this->_sim;
  }

  public function filterInvi($uid)
  {
    $sql = "SELECT uid FROM pafap_invitations WHERE iid = '{$uid}' AND status = 0";
    $this->_invi = $this->ArrayResults($sql);
    return $this->_invi;
  }

  public function getUsersByIID($iid)
  {
    foreach($iid as $key=>$value)
    {
      $sql = "SELECT pafap_users.*, pafap_profile.image FROM pafap_users, pafap_profile WHERE pafap_users.uid = pafap_profile.uid AND pafap_users.uid = {$value[0]}";
      list($this->_tmp) = $this->ArrayResults($sql);
      $this->_usr[] = $this->_tmp;
    }
    return $this->_usr;
  }

  public function addFriend($uid, $fuid)
  {
    $sql = "INSERT INTO pafap_friends (uid, fuid) VALUES ('{$uid}', '$fuid')";
    return ($this->ExecuteSQL($sql))? true : false;
  }

  public function addInvitation($from, $to)
  {
    $sql = "INSERT INTO pafap_invitations (uid, iid, status, type) VALUES ('{$from}', '{$to}', 0, 'friendship')";
    return ($this->ExecuteSQL($sql))? true : false;
  }

  public function addFollow($fid, $fuid, $fusr)
  {
    $sql = "INSERT INTO pafap_follows (fid, fuid, fusr) VALUES ('{$fid}', '{$fuid}', '{$fusr}')";
    return ($this->ExecuteSQL($sql))? true : false;
  }

  public function changeInviStatus($uid, $iid, $status)
  {
    $sql = "UPDATE pafap_invitations SET status = {$status} WHERE uid = {$uid} AND iid = '{$iid}'";
    return ($this->ExecuteSQL($sql))? true : false;
  }

  public function getValueFromTable($sql, $uid)
  {
    $this->ExecuteSQL($sql);
    list($this->_tmp) = $this->iAssoc;
    return $this->_tmp;
  }

  public function getProfileID($uid)
  {
    $pid = "SELECT pid FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($pid, $uid);
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
      $sql = "SELECT * FROM pafap_users WHERE uid = {$value[0]} ORDER BY fname DESC";
      $tmpusr = $this->ArrayResults($sql);
      if(!empty($tmpusr))
      {
        list($this->_tmp) = $tmpusr;
        $this->_fid[] = $this->_tmp;
      }
    }
    return $this->_fid;
  }

  public function checkFriends($uid, $fid)
  {
    $sql = "SELECT fuid FROM pafap_friends WHERE uid = '{$uid}' AND fuid = '{$fid}'";
    $this->ExecuteSQL($sql);
    return ($this->iAffected > 0)? true : false;
  }

  public function checkFollows($fid, $fuid)
  {
    $sql = "SELECT fuid FROM pafap_follows WHERE fuid = '{$fuid}' AND fid = '{$fid}'";
    $this->ExecuteSQL($sql);
    return ($this->iAffected > 0)? true : false;
  }

  public function checkInvi($uid, $iid)
  {
    $sql = "SELECT uid FROM pafap_invitations WHERE uid = '{$uid}' AND iid = '{$iid}' AND status = 0";
    $this->ExecuteSQL($sql);
    return ($this->iAffected > 0)? true : false;
  }

  public function rm_friends($uid, $fid)
  {
    $fd = "DELETE FROM pafap_friends WHERE uid = '{$uid}' AND fuid = '{$fid}' LIMIT 1";
    $ud = "DELETE FROM pafap_friends WHERE uid = '{$fid}' AND fuid = '{$uid}' LIMIT 1";
    $this->ExecuteSQL($fd);
    if ($this->iAffected > 0){
      $this->ExecuteSQL($ud);
      return true;
    }
    else return false;
  }

  public function showFriendsByUserID($uid)
  {
    $sql = "SELECT pafap_profile.image, pafap_users.fname, pafap_users.lname, pafap_users.sex, pafap_friends.fuid FROM pafap_profile, pafap_users, pafap_friends WHERE pafap_profile.uid = pafap_friends.fuid AND pafap_users.uid = pafap_friends.fuid AND pafap_friends.uid = '{$uid}'";
    return $this->ArrayResults($sql);
  }

}

?>