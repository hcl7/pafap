<?php
include('../pafap_classes/init.php');
include('../pafap_classes/login_pafap_class.php');
session_start();
$logout = new pafap_login();
if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  $logoutsql = "UPDATE pafap_users SET status = 0 WHERE uid = '{$uid}'";
  $logout->ExecuteSQL($logoutsql);
  $logout->dbCloseConn();
  session_destroy();
  header("Location: /index.php");
}
else
{
  header("Location: /index.php");
}
?>