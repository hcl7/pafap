<?php

//error_reporting(0);
session_start();
(isset($_SESSION['uid']) && $_SESSION['uid'] != NULL)? $cuid = $_SESSION['uid'] : $cuid = 0;
include ('../pafap_classes/init.php');
include ('../pafap_classes/record_pafap_class.php');
$message = $_POST['postrecordcomment'];
$bind = new pafap_record();
$tmpl = new pafap_templates;
if (isset($_POST['crwid']))
{
  $cwid = $_POST['crwid'];
  if ($_POST['postrecordcomment'] != '')
  {
    $bind->PostRecordComments($cwid, $cuid, $message);
    $tmpl->_showWithId("status_{$cwid}", "<div class='current_comment_img'><img src='../{$bind->getImagePath($cuid)}' width='36px' height='36px' alt='' /></div><div class='current_comment_messages'>{$bind->sd($message)}</div>");
  }
  else $tmpl->_show("status_{$cwid}", "Enter Comment!");
}
else $tmpl->_show("status_{$cwid}", "Post error!");

?>
