<?php
session_start();
include ('../pafap_classes/init.php');
include ('../pafap_classes/record_pafap_class.php');
if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  if (isset($_POST['widragree']))
  {
    $wid = $_POST['widragree'];
    $bind = new pafap_record();
    $tmpl = new pafap_templates;
    $bind->postRecordAgree($wid, $uid);
    $tmpl->_show("pafap_warning", "You agreed to this subject!");
  }
}
?>
