<?php
include ("init.php");
include ("mysql_pafap_class.php");
class pafap_image extends pafap_mysql
{
  private $filelist;
  private $errors;
  private $_tmp;
  public function __construct()
  {
    $this->filelist = array();
    $this->errors = array();
    $this->pafap_mysql();
  }
  public function getFiles()
  {
    return $this->filelist;
  }
  public function _showerror()
  {
    return $this->errors;
  }
  public function fnfilter($uid)
  {
    $sql = "SELECT iid, img_url FROM pafap_images WHERE iuid = '{$uid}'";
    $this->filelist = $this->ArrayResults($sql);
    foreach($this->imgFriendsID($uid) as $key=>$value)
    {
      if ($value['fuid'] != $uid)
      {
        $fid = "SELECT iid, img_url FROM pafap_images WHERE iuid = '{$value['fuid']}'";
        $this->filelist = array_merge($this->ArrayResults($fid), $this->filelist);
      }
    }
  }

  public function personalFilter($uid)
  {
    $sql = "SELECT iid, img_url FROM pafap_images WHERE iuid = '{$uid}'";
    $this->filelist = $this->ArrayResults($sql);
  }

  public function friendsFilter($uid)
  {
    foreach($this->imgFriendsID($uid) as $key=>$value)
    {
      if ($value['fuid'] != $uid)
      {
        $fid = "SELECT iid, img_url FROM pafap_images WHERE iuid = '{$value['fuid']}'";
        $this->filelist = array_merge($this->ArrayResults($fid), $this->filelist);
      }
    }
  }

  public function rm_image($uid, $iid)
  {
    $img = "DELETE FROM pafap_images WHERE iid = '{$iid}' AND iuid = '{$uid}'";
    $img_comm = "DELETE FROM pafap_images_comments WHERE iid = '{$iid}'";
    $this->ExecuteSQL($img);
    if ($this->iAffected > 0){
      $this->ExecuteSQL($img_comm);
      $this->errors[] = "Image deleted and its comments!";
    }
    else $this->errors[] = "Image is not yours!";
  }
  public function asProfile($uid, $file)
  {
    if ($this->getUidByImg($file) == $uid)
    {
      $sql = "UPDATE pafap_profile SET image = 'users/ImagesPool/{$file}' WHERE uid = '{$uid}'";
      $this->ExecuteSQL($sql);
      ($this->iAffected > 0)? $this->errors[] = "Image Uploaded as profile!" : $this->errors[] = "asProfile() error!";

    }
    else $this->errors[] = "Image is not yours!";
  }
  public function imgPostComment($iid, $uid, $notes)
  {
    $sql = "INSERT INTO pafap_images_comments (iid, icuid, notes, date_created) VALUES ('{$iid}', '{$uid}', '{$this->sd($notes)}', now())";
    return ($this->ExecuteSQL($sql))? true : false;
  }
  public function imgFriendsID($uid)
  {
    $sql = "SELECT fuid FROM pafap_friends WHERE uid = '{$uid}'";
    return ($this->ArrayResults($sql));
  }
  public function getUidByImg($img)
  {
    $sql = "SELECT iuid FROM pafap_images WHERE img_url = '{$img}'";
    $this->ExecuteSQL($sql);
    list($tmp) = $this->iAssoc;
    return $tmp;
  }
  public function bindImgComments($iid)
  {
    $sql = "SELECT * FROM pafap_images_comments WHERE iid = '{$iid}' ORDER BY date_created DESC";
    return $this->ArrayResults($sql);
  }
  public function getValueFromTable($sql)
  {
    $this->ExecuteSQL($sql);
    list($this->_tmp) = $this->iAssoc;
    return $this->_tmp;
  }
  public function getImagePath($uid)
  {
    $image = "SELECT image FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($image);
  }
  public function getUserName($uid)
  {
    $user = "SELECT CONCAT(fname, ' ', lname) FROM pafap_users WHERE uid = '{$uid}'";
    return $this->getValueFromTable($user);
  }
  public function asWallImg($uid, $cid, $url)
  {
    $sql = "INSERT INTO pafap_wall (cid, wuid, notes, date_created, status) VALUES ('{$cid}', '{$uid}', '{$url}', now(), 'private')";
    $this->ExecuteSQL($sql);
    ($this->iAffected > 0)? $this->errors[] = "Image became as wall!" : $this->errors[] = "asWall() error!";
  }

  public function getIidByImg($img)
  {
    $sql = "SELECT iid FROM pafap_images WHERE img_url = '{$img}'";
    $this->ExecuteSQL($sql);
    list($tmp) = $this->iAssoc;
    return $tmp;
  }

  public function sd($data)
  {
    return mysql_real_escape_string($data);
  }

}

?>