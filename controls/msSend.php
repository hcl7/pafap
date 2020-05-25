<?php
session_start();
error_reporting(0);
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/init.php');
include ('../pafap_classes/message_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$send = new pafap_message();
$tmpl = new pafap_templates;
if(isset($_POST['msto']) && isset($_POST['msNotes']))
{
  $to = $_POST['msto'];
  $notes = htmlspecialchars(stripslashes($_POST['msNotes']));
  ($send->msSend($uid, $to, $send->sd($notes)))? $tmpl->_show("pafap_success", "Message sent!") : 'error!';
}
?>
