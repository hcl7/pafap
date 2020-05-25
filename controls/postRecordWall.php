<?php
session_start();

include ('../pafap_classes/init.php');
include ('../pafap_classes/record_pafap_class.php');

(isset($_SESSION['record']) && $_SESSION['record'] != '')? $rid = $_SESSION['record'] : $rid=0;
(isset($_SESSION['uid']) && $_SESSION['uid'] != '')? $uid = $_SESSION['uid'] : $uid=0;
$rec = new pafap_record();
$tmpl = new pafap_templates;
if($_POST['postrecordwall'] != '')
{
  $message = $_POST['postrecordwall'];
  $rec->PostRecordWall($rid, $uid, $message);
  $tmpl->_showWithId("current_record_messages", "<div class='pafap_wall_img'><img src='../{$rec->getImagePath($uid)}' width='48px' height='48px' alt='' /></div><div class='current_wall_messages'>{$rec->sd($message)}</div>");
}
else
{
  $tmpl->_show("pafap_error", "Post Error!");
}


?>