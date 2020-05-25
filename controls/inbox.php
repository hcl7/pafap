<?php
session_start();
//error_reporting(0);
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/message_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$mess = new pafap_message();
$tmpl = new pafap_templates;
$msList = array();
$msList = $mess->msGet($uid);
if (!empty($msList))
{
  foreach ($msList as $mskey=>$msvalue)
  {
    $tmpl->msBinder($msvalue['mid'], $msvalue['fromUID'], $msvalue['fname']. ' '. $msvalue['lname'], $msvalue['notes'], $msvalue['image'], substr($msvalue['date_created'], 0, 10));
  }
}
else $tmpl->_show("pafap_warning", "Inbox is Empty!");
?>
