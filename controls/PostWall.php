<?php
session_start();

include ('../pafap_classes/init.php');
include ('../pafap_classes/bind_pafap_class.php');

(isset($_SESSION['cid']) && $_SESSION['cid'] != '')? $cid = $_SESSION['cid'] : $cid=0;
(isset($_SESSION['uid']) && $_SESSION['uid'] != '')? $uid = $_SESSION['uid'] : $uid=0;
$bind = new pafap_bind();
$tmpl = new pafap_templates;
$bind->setCategories($uid);
if ($bind->chechValue($bind->getValue(), $cid))
{
  if($_POST['postwall'] != '')
  {
    $message = $_POST['postwall'];

    $bind->PostWall($cid, $uid, $message);
    $tmpl->_showWithId("current_messages", "<div class='pafap_wall_img'><img src='../{$bind->getImagePath($uid)}' width='48px' height='48px' alt='' /></div><div class='current_wall_messages'>{$bind->sd($message)}</div>");
  }
}
else
{
  $tmpl->_show("pafap_error", "Please select a category! go to Profile->Categories!");
}


?>