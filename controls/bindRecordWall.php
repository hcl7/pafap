<?php
session_start();
include ('../pafap_classes/init.php');
include ('../pafap_classes/record_pafap_class.php');
if (isset($_POST['morerecordresults']))
{
  if (isset($_SESSION['uid']))
  {
    $limit = 0;
    $uid = $_SESSION['uid'];
    if (isset($_SESSION['record'])) $rid = $_SESSION['record'];
    $bind = new pafap_record();
    $tmpl = new pafap_templates;
    $defaultimage = "/users/PAGE-DEFAULT.PNG";
    $limit += $_POST['morerecordresults'];
    $bind->BindRecWall($rid, $limit);
  }
}
?>
