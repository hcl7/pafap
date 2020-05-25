<?php
session_start();
include ('../pafap_classes/init.php');
include ('../pafap_classes/bind_pafap_class.php');
if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  if (isset($_POST['widagree']))
  {
    $wid = $_POST['widagree'];
    $bind = new pafap_bind();
    $tmpl = new pafap_templates;
    $bind->postAgree($wid, $uid);
    $tmpl->_show("pafap_warning", "You agreed to this subject!");
  }
}
?>
