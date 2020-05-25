<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
include ('../pafap_classes/sim_pafap_class.php');
$sim = new pafap_similarities();
$tmpl = new pafap_templates;
if (isset($_POST['afll']))
{
  $fid = $_POST['afll'];
  if (!$sim->checkFollows($fid, $uid))
  {
    if ($sim->addFollow($fid, $uid, $_SESSION['email']))
    {
      $tmpl->_show("pafap_success", "Following!");
    }
    else
    {
      $tmpl->_show("pafap_error", "Not Following!");
    }
  }
  else $tmpl->_show("pafap_warning", "Joined Already!");
}
else $tmpl->_show("pafap_warning", "Post Error!");

?>
