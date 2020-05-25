<?php

//error_reporting(0);
//session_start();
if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  $bindmenu = new pafap_bind();
  $bindmenu->setCategories($uid);
  $bindmenu->BindLeftMenu($bindmenu->getValue(), "leftmenu");
}

?>