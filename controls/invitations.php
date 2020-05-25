<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
include ('../pafap_classes/sim_pafap_class.php');
$sim = new pafap_similarities();
$tmpl = new pafap_templates;
if (isset($_POST['af']))
{
  $iid = $_POST['af'];
  if (!$sim->checkFriends($uid, $iid) && !$sim->checkInvi($uid, $iid))
  {
    if ($sim->addInvitation($uid, $iid))
    {
      $tmpl->_show("pafap_success", "Invitation was sent!");
    }
    else
    {
      $tmpl->_show("pafap_error", "Invitation was not sent!");
    }
  }
  else $tmpl->_show("pafap_warning", "Your friend already!");
}
else $tmpl->_show("pafap_warning", "Post Error!");

?>