<?php
include ('mysql_pafap_class.php');
include ('templates_pafap_class.php');
class pafap_record extends pafap_mysql
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
    $this->_categories = array();
    $this->_default = "/users/PAGE-DEFAULT.PNG";
  }

  public function sd($data)
  {
    return mysql_real_escape_string($data);
  }

  public function BindRecWall($rid, $limit)
  {
    $tmpl = new pafap_templates;
    $wallsql = "SELECT pafap_profile.image, pafap_wall.wid, pafap_wall.wuid, pafap_wall.notes FROM pafap_profile, pafap_wall WHERE pafap_profile.uid = pafap_wall.wuid AND pafap_wall.cid = '{$rid}' ORDER BY pafap_wall.date_created DESC LIMIT $limit";
    $result = $this->ArrayResults($wallsql);
    foreach ($result as $row)
    {
      echo "<div id='rwall_{$row['wid']}' class='wall_box'>";
      $tmpl->showRecWall($row["wid"], $tmpl->showUserImage($row["image"], $this->_default, "48px"), $row["notes"], "pafap_wall_messages", "pafap_wall_img");
      $this->BindRecordComment($row["wid"]);
      $tmpl->commentRecordInput($this->getImagePath($_SESSION['uid']), $this->_default, "36px", $row["wid"], '0', $this->countAgree($row["wid"]));
      echo "</div>";
    }
  }

  public function BindRecordComment($wid)
  {
    $tmpl = new pafap_templates;
    $commentsql = "SELECT pafap_profile.image, pafap_comments.notes FROM pafap_profile, pafap_comments WHERE pafap_comments.cuid = pafap_profile.uid AND pafap_comments.wid = '{$wid}' ORDER BY date_created ASC";
    $result = $this->ArrayResults($commentsql);
    foreach ($result as $row)
    {
      $tmpl->showComments($tmpl->showUserImage($row["image"], $this->_default, "36px"), $row["notes"],"pafap_comment_messages", "pafap_comment_img");
    }
  }
// post section
  public function PostRecordWall($rid, $wuid, $notes)
  {
    $post = "INSERT INTO pafap_wall (cid, wuid, notes, date_created, status) VALUES ('{$this->sd($rid)}', '{$wuid}', '{$this->sd($notes)}', now(), 'public')";
    $this->ExecuteSQL($post);
  }

  public function PostRecordComments($wid, $cuid, $notes)
  {
    $comment = "INSERT INTO pafap_comments (wid, cuid, notes, date_created) VALUES ('{$wid}', '{$this->sd($cuid)}', '{$this->sd($notes)}', now())";
    $this->ExecuteSQL($comment);
  }
// post section
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

  public function postRecordAgree($wid, $uid)
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

  public function countFollows($fid)
  {
    $sql = "SELECT COUNT(fuid) FROM pafap_follows WHERE fid = '{$fid}'";
    $this->ExecuteSQL($sql);
    ($this->iAssoc)? list($res) = $this->iAssoc : $res = 0;
    return $res;
  }

  public function getUserName($uid)
  {
    $user = "SELECT CONCAT(fname, ' ', lname) FROM pafap_users WHERE uid = '{$uid}'";
    return $this->getValueFromTable($user);
  }

  public function bindInfo($uid)
  {
    $inf = array();
    $info = "SELECT pafap_users.fname, pafap_users.lname, pafap_users.email, pafap_users.role, pafap_users.owner, pafap_profile.* FROM pafap_users, pafap_profile WHERE pafap_users.uid = pafap_profile.uid AND pafap_profile.uid = {$uid}";
    $inf = $this->ArrayResults($info);
    return $inf;
  }

  public function bindNews()
  {
    $news = array();
    $sqlnews = "SELECT * FROM pafap_news ORDER BY date_modified DESC";
    $news = $this->ArrayResults($sqlnews);
    return $news;
  }

  public function _free()
  {
    $this->dbCloseConn();
  }

}

?>