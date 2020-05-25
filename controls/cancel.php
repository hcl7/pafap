<?php

session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/sim_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$sim = new pafap_similarities();
$tmpl = new pafap_templates;
if(isset($_POST['cancel']))
{
  $canc = $_POST['cancel'];
  if ($sim->changeInviStatus($canc, $uid, 2))
  {
    $tmpl->_show("pafap_success", "Invitation was Canceled!");
  }
  else
  {
    $tmpl->_show("pafap_error", "error!");
  }
}
else $tmpl->_show("pafap_error", "post error!");

?>
