<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/init.php');
include ('../pafap_classes/settings_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
if(isset($_POST['oldpass']))
{
  $set = new pafap_settings();
  $tmpl = new pafap_templates;
  $old = $_POST['oldpass'];
  $oldpassmd5 = md5($old);
  $oldpasssql = "SELECT pass FROM pafap_users WHERE pass = '{$oldpassmd5}'";
  if($set->getValue($oldpasssql))
  {
  if(isset($_POST['newpass']))
  {
    $new = $_POST['newpass'];
    if (isset($_POST['renewpass']))
    {
      $renew = $_POST['renewpass'];
      if ($new == $renew)
      {
        $md5pass = md5($renew);
        $sql = "UPDATE pafap_users SET pass = '{$md5pass}' WHERE uid = $uid";
        if($set->ExecuteSQL($sql))
        {
          $tmpl->_show('pafap_success', "Password changed!");
        }
        else
        {
          $tmpl->_show('pafap_warning', $mysql->strLastError);
        }
      }
      else $tmpl->_show('pafap_warning', "Renew password not the same!");
    }
  }
  }
  else $tmpl->_show('pafap_warning', "Wrong old password!");
}
?>