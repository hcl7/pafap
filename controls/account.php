<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/init.php');
include ('../pafap_classes/settings_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$msql = new pafap_settings();
$tmpl = new pafap_templates();
if(isset($_POST['accfn']) && $_POST['accfn'] != '')
{
  $fn = $_POST['accfn'];
  if(isset($_POST['accln']) && $_POST['accln'] != '')
  {
    $ln = $_POST['accln'];
    if(isset($_POST['accmail']) && !$msql->email_exists("pafap_users", "email", $_POST['accmail']) && $_POST['accmail'] != '')
    {
      $email = $_POST['accmail'];
      if(isset($_POST['accbirth']) && $_POST['accbirth'] != '')
      {
        $brth = $_POST['accbirth'];
        if(isset($_POST['accstatus']) && $_POST['accstatus'] != '')
        {
          $sts = $_POST['accstatus'];
          $sqlacc = "UPDATE pafap_users SET fname = '{$fn}', lname = '{$ln}', email = '{$email}', birthday = '{$brth}' WHERE uid = $uid";
          $sqlprf = "UPDATE pafap_profile SET relationship = '{$sts}' WHERE uid = $uid";
          echo $msql->runQuery($sqlacc);
          echo $msql->runQuery($sqlprf);
          $tmpl->_show('pafap_success', "Settings updated!");
        }
      }
    }
    else $tmpl->_show('pafap_warning', "This email account already exists!");
  }
}
else $tmpl->_show('pafap_warning', "Post error!");
?>