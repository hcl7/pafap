<?php
session_start();
error_reporting(0);
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/message_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$del = new pafap_message();
$tmpl = new pafap_templates;
if(isset($_POST['msid']))
{
  $mid = $_POST['msid'];
  ($del->msDelete($mid))? $tmpl->_show("pafap_success", "Message Deleted!") : 'error!';
}
?>
