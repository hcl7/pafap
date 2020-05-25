<?php

class pafap_games extends pafap_mysql
{
  private $_errors;
  private $_tmp;

  public function __construct()
  {
    $this->pafap_mysql();
    $this->_errors = array();
  }

  public function getValueFromTable($sql)
  {
    $this->ExecuteSQL($sql);
    list($tmp) = $this->iAssoc;
    return $tmp;
  }

  public function getGameNames($uid)
  {
    $games = "SELECT * FROM pafap_games";
    return $this->ArrayResults($games);
  }

  public function getProfileID($uid)
  {
    $pid = "SELECT pid FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($pid);
  }

  public function sd($data)
  {
    return mysql_real_escape_string($data);
  }

  public function getImagePath($uid)
  {
    $image = "SELECT image FROM pafap_profile WHERE uid = '{$uid}'";
    return $this->getValueFromTable($image);
  }

  public function getCategories($uid)
  {
    $cat = array();
    $bcat = "SELECT ctname FROM pafap_profile_category_type WHERE pid = '{$this->getProfileID($uid)}' AND cid = 105";
    return $this->ArrayResults($bcat);
  }

  public function showGameMenu($imggame, $link, $target)
  {
    echo "<li><a href='{$this->sd($link)}' target='game_target'><img src='$imggame' alt='$imggame' width='120' /></a></li>";
  }
}
?>
