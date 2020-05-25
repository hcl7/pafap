<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
if(isset($_POST['txtrecname']))
{
  $recname = $_POST['txtrecname'];
  if(isset($_POST['category']))
  {
    if ($_POST['category'] !== '-Select-' && isset($_POST['ctype']) && $_POST['ctype'] != '-Select-')
    {
      $rcat = $_POST['category'];
      $rctype = $_POST['ctype'];
      $link = $_POST['txtlink'];
      $sql = "INSERT INTO pafap_users (fname, lname, email, status, role, date_created, owner) VALUES ('{$recname}', '$rcat $rctype', '{$link}', 0, 'public', now(), '{$uid}')";
      $mysql = new pafap_mysql();
      $tmpl = new pafap_templates;
      if($_SESSION['catid'] != '' && $mysql->ExecuteSQL($sql))
      {
        $cid = $_SESSION['catid'];
        $recuid = mysql_insert_id();
        $sqlprofile = "INSERT INTO pafap_profile (uid, image) VALUES('{$recuid}', 'users/PAGE-DEFAULT.PNG')";
        $mysql->ExecuteSQL($sqlprofile);
        $rpid = mysql_insert_id();
        $sqlcat = "INSERT INTO pafap_profile_category (pid, cid, cname) VALUES ('{$rpid}', '{$cid}', '{$rcat}')";
        $mysql->ExecuteSQL($sqlcat);
        $sqlctype = "INSERT INTO pafap_profile_category_type (pid, cid, ctname) VALUES ('{$rpid}', '{$cid}', '{$rctype}')";
        $mysql->ExecuteSQL($sqlctype);
        $tmpl->_show('pafap_success', "Record Created!");
      }
      else
      {
        $tmpl->_show('pafap_warning', "Record Not Created!");
      }
    }
  }
}
?>