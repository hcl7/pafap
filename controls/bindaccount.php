<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$mysql = new pafap_mysql();
$sql = "SELECT pafap_users.*, pafap_profile.* FROM pafap_users, pafap_profile WHERE pafap_users.uid = pafap_profile.uid AND pafap_users.uid = $uid";
$res = $mysql->ArrayResults($sql);
foreach ($res as $key=>$value)
{
  $_POST['txtfn'] = $value['fname'];
  $_POST['txtln'] = $value['lname'];
  $_POST['txtemail'] = $value['email'];
  $_POST['sex'] = $value['sex'];
  $_POST['txtbirth'] = $value['birthday'];
  $_POST['txtstatus'] = $['relationship'];
}
?>