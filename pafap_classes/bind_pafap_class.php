<?php
include ('mysql_pafap_class.php');
include ('templates_pafap_class.php');
class pafap_bind extends pafap_mysql
{
  private $_wid;
  private $_fuid;
  private $_post;
  private $_postwall;
  private $_tmp;
  private $_default;
  private $_categories;

  public function __construct()
  {
    $this->pafap_mysql();
    $this->_wid = array();
    $this->_fuid = array();
    $this->_categories = array();
    $this->_default = "/users/DEFAULT.PNG";
  }

  public function sd($data)
  {
    return mysql_real_escape_string($data);
  }

  public function BindWall($wid, $cid, $limit)
  {
    $index = 0;
    $tmpl = new pafap_templates;
    foreach($wid as $key=>$value)
    {
      $index += 1;
      if ($index <= $limit)
      {
        echo "<div id='wall_{$value}' class='wall_box'>";
        $wallsql = "SELECT pafap_profile.image, pafap_wall.wid, pafap_wall.wuid, pafap_wall.notes FROM pafap_profile, pafap_wall WHERE pafap_profile.uid = pafap_wall.wuid AND pafap_wall.wid = '{$value}' AND pafap_wall.cid = '{$cid}' ORDER BY pafap_wall.date_created DESC;";
        $result = $this->ArrayResults($wallsql);
        foreach ($result as $row)
        {
          $tmpl->showWall($row["wid"], $tmpl->showUserImage($row["image"], $this->_default, "48px"), $row["notes"], "pafap_wall_messages", "pafap_wall_img");
          //$this->bindAgree(($value));
          $this->BindComment($value);
        }
        $tmpl->commentInput($this->getImagePath($_SESSION['uid']), $this->_default, "36px", $value, $this->sd($cid), $this->countAgree($value));
        echo "</div>";
      }
    }
    $this->clearArray();
  }

  public function BindComment($wid)
  {
    $tmpl = new pafap_templates;
    $commentsql = "SELECT pafap_profile.image, pafap_comments.notes FROM pafap_profile, pafap_comments WHERE pafap_comments.cuid = pafap_profile.uid AND pafap_comments.wid = '{$wid}' ORDER BY date_created ASC";
    $result = $this->ArrayResults($commentsql);
    foreach ($result as $row)
    {
      $tmpl->showComments($tmpl->showUserImage($row["image"], $this->_default, "36px"), $row["notes"],"pafap_comment_messages", "pafap_comment_img");
    }
  }

  public function bindAgree($wid)
  {
    $tmpl = new pafap_templates;
    $agreesql = "SELECT pafap_users.fname, pafap_users.lname, pafap_profile.image, pafap_agree.wid FROM pafap_users, pafap_profile, pafap_agree WHERE pafap_users.uid = pafap_agree.auid AND pafap_profile.uid = pafap_agree.auid AND pafap_agree.wid = '{$wid}'";
    $result = $this->ArrayResults($agreesql);
    foreach ($result as $row)
    {
      $tmpl->showAgree($tmpl->showUserImage($row["image"], $this->_default, "36px"), $row["fname"]. " ". $row["lname"], "<img src='../images/agree.PNG' width='24' height='24' />", "pafap_comment_messages", "pafap_comment_img");
    }
  }

  public function getWallIds($uid, $cid)
  {
    $widsql = "SELECT wid FROM pafap_wall WHERE wuid = '{$uid}' AND cid = '{$this->sd($cid)}' AND status = 'private'";
    $result = $this->ArrayResults($widsql);

    foreach ($result as $row)
    {
      $this->_wid[] = $row["wid"];
    }
    return $this->_wid;
  }

  public function getFriendsId($uid)
  {
    $fsql = "SELECT fuid FROM pafap_friends WHERE uid = '{$uid}'";
    $result = $this->ArrayResults($fsql);
    foreach ($result as $row)
    {
      $this->_fuid[] = $row["fuid"];
    }
    return $this->_fuid;
  }

  public function PostWall($cid, $wuid, $notes)
  {
    $post = "INSERT INTO pafap_wall (cid, wuid, notes, date_created, status) VALUES ('{$this->sd($cid)}', '{$wuid}', '{$this->sd($notes)}', now(), 'private')";
    $this->ExecuteSQL($post);
  }

  public function PostComments($wid, $cuid, $notes)
  {
    $comment = "INSERT INTO pafap_comments (wid, cuid, notes, date_created) VALUES ('{$wid}', '{$this->sd($cuid)}', '{$this->sd($notes)}', now())";
    $this->ExecuteSQL($comment);
  }

  public function clearArray()
  {
    $this->_wid = array();
  }

  public function getImagePath($uid)
  {
    $image = "SELECT image FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($image, $uid);
  }

  public function sort_array($a)
  {
    $array = array();
    rsort($a);
    foreach($a as $key=>$value)
    {
      $array[] = $value;
    }
    return $array;
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

  public function setCategories($uid)
  {
    $menu = "SELECT cid, cname FROM pafap_profile_category WHERE pid = '{$this->getProfileID($uid)}'";
    $result = $this->ArrayResults($menu);
    foreach ($result as $row)
    {
       $this->_categories[$row["cid"]] = $row["cname"];
    }
  }

  public function getCategoryByCid($cid)
  {
    $sql = "SELECT cicon FROM pafap_category WHERE cid = {$this->sd($cid)}";
    $result = $this->ArrayResults($sql);
    foreach ($result as $row)
    {
       $tmp = $row["cicon"];
    }
    return $tmp;
  }

  public function BindLeftMenu($val, $class)
  {
    $tmpl = new pafap_templates;
    echo "<ul itemprop='Review' class='".$class."'>";
    foreach ($val as $key=>$value)
    {
       $tmpl->showLeftMenu($value, $key);
    }
    echo "</ul>";
  }

  public function chechValue($aData, $val)
  {
    $i=0;
    foreach($aData as $key=>$value)
    {
      if ($val == $key) $i+=1;
    }
    return ($i > 0)? true : false;
  }

  public function getValue()
  {
    return $this->_categories;
  }

  public function notifications($uid)
  {
    $sql = "SELECT COUNT(iid) FROM pafap_invitations WHERE iid = '{$uid}' AND status = 0";
    return ($this->ExecuteSQL($sql))? $this->iAssoc : 0;
  }

  public function messages($uid)
  {
    $sql = "SELECT COUNT(mid) FROM pafap_messages WHERE toUID = '{$uid}'";
    return ($this->ExecuteSQL($sql))? $this->iAssoc : 0;
  }

  public function games_nr($uid)
  {
    $sql = "SELECT COUNT(ctname) FROM pafap_profile_category_type WHERE pid = '{$this->getProfileID($uid)}'";
    return ($this->ExecuteSQL($sql))? $this->iAssoc : 0;
  }

  public function rm_wall($wid, $uid)
  {
    $wall = "DELETE FROM pafap_wall WHERE wid = '{$wid}' AND wuid = '{$uid}'";
    $wc = "DELETE FROM pafap_comments WHERE wid = '{$wid}'";
    $agree = "DELETE FROM pafap_agree WHERE wid = '{$wid}'";
    $this->ExecuteSQL($wall);
    if ($this->iAffected > 0){
      $this->ExecuteSQL($wc);
      $this->ExecuteSQL($agree);
      return true;
    }
    else return false;
  }

  public function postAgree($wid, $uid)
  {
    $sql = "INSERT INTO pafap_agree (wid, auid, date_created) VALUES ('{$wid}', '{$uid}', now())";
    $this->ExecuteSQL($sql);
  }

  public function countAgree($wid)
  {
    $sql = "SELECT COUNT(wid) FROM pafap_agree WHERE wid = '{$wid}'";
    $this->ExecuteSQL($sql);
    ($this->iAssoc)? list($res) = $this->iAssoc : $res = 0;
    return $res;
  }

  public function getUserName($uid)
  {
    $user = "SELECT CONCAT(fname, ' ', lname) FROM pafap_users WHERE uid = '{$uid}'";
    return $this->getValueFromTable($user);
  }

  public function _free()
  {
    $this->dbCloseConn();
  }

}

?>