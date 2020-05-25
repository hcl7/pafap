<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/sim_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
if(isset($_POST['frID']))
{
  $fid = $_POST['frID'];
  $fr = new pafap_similarities();
  $tmpl = new pafap_templates;
  $fr->rm_friends($uid, $fid);
  $tmpl->_show('pafap_success', "Friend deleted!");
}
?>

