<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/bind_pafap_class.php');
if(isset($_POST['wallID']))
{
  $wid = $_POST['wallID'];
  $wall = new pafap_bind;
  $tmpl = new pafap_templates;
  $wall->rm_wall($wid, $uid);
  $tmpl->_show('pafap_success', "Subject deleted!");
}
?>

