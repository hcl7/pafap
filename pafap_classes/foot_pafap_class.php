<?php

class pafap_foot extends pafap_mysql
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
  }

  public function sd($data)
  {
    return mysql_real_escape_string($data);
  }

  public function bindNews()
  {
    $news = array();
    $sqlnews = "SELECT * FROM pafap_news ORDER BY date_modified DESC";
    $news = $this->ArrayResults($sqlnews);
    foreach($news as $k=>$v)
    {
      echo "<li class='news-item'><a href='#'>{$v['noteEng']}</a></li>";
    }
  }

  public function _free()
  {
    $this->dbCloseConn();
  }

}

?>