<?php
//error_reporting(0);
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/profile_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$prf = new pafap_profile();
$tmpl = new pafap_templates;
$relship = $_POST['relship'];
$country = $_POST['country'];
$city = $_POST['city'];
if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  $sql = "UPDATE pafap_profile SET relationship = '{$relship}', nationality = '{$country}', residence = '{$city}' WHERE uid = '{$uid}'";
  $prf->query_profile($uid, $sql);
  $tmpl->_show('pafap_success', "Updated!");
}

?>
