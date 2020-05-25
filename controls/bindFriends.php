<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/init.php');
include ('../pafap_classes/bind_pafap_class.php');
include ('../pafap_classes/sim_pafap_class.php');
$sim = new pafap_similarities();
$tmpl = new pafap_templates();
$bind = new pafap_bind();

$frds = $sim->showFriendsByUserID($uid);
if(!empty($frds))
{   
  foreach($frds as $k=>$v)
  {
    $tmpl->friendsBinder($v['fuid'], $v['image'], $v['fname']." ".$v['lname']. "<br />". $v['sex']);
  }
}
else $tmpl->_show("pafap_warning", "Friends list empty!");

?>