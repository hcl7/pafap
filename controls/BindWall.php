<?php
session_start();
include ('../pafap_classes/init.php');
include ('../pafap_classes/bind_pafap_class.php');
if (isset($_POST['moreresults']))
{
if (isset($_SESSION['uid']))
{
  $index = 0;
  $uid = $_SESSION['uid'];
  if (isset($_SESSION['cid'])) $cid = $_SESSION['cid'];
  $wid = array();
  $bind = new pafap_bind();
  $tmpl = new pafap_templates;
  $userimage = $bind->getImagePath($uid);
  $defaultimage = "/users/DEFAULT.PNG";

  foreach ($bind->getFriendsId($uid) as $key=>$value)
  {
    $wid = array_merge($bind->getWallIds($value, $cid));
  }
  $wid = array_merge($bind->getWallIds($uid, $cid));

  $index +=$_POST['moreresults'];
  $bind->BindWall($bind->sort_array($wid), $cid, $index);
}
}
//$bind->_free();
?>
