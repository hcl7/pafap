<link rel="stylesheet" href="../css/pafap_messages.css" type="text/css" />
<?php

session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/sim_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$sim = new pafap_similarities();
$tmpl = new pafap_templates;
if(isset($_POST['confirm']))
{
  $cfrm = $_POST['confirm'];
  if (!$sim->checkFriends($uid, $cfrm))
  {
    $sim->addFriend($uid, $cfrm);
    $sim->addFriend($cfrm, $uid);
    $sim->changeInviStatus($cfrm, $uid, 1);
    $tmpl->_show("pafap_success", "success!");
  }
  else
  {
    $tmpl->_show("pafap_error", "Your Friend already!");
  }
}
else $tmpl->_show("pafap_error", "postError!");

?>
