<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
if(isset($_POST['catgpid']))
{
  $pid = $_POST['catgpid'];
  if(isset($_POST['catgcid']))
  {
    $cid = $_POST['catgcid'];
    if (isset($_POST['catgctname']))
    {
      $ctname = $_POST['catgctname'];
      $sql = "DELETE FROM pafap_profile_category_type WHERE pid = $pid AND cid = $cid AND ctname = '$ctname'";
      $mysql = new pafap_mysql();
      $tmpl = new pafap_templates;
      if($mysql->ExecuteSQL($sql))
      {
        $tmpl->_show('pafap_success', "Category_Type deleted!");
      }
      else
      {
        $tmpl->_show('pafap_warning', "Category_Type not deleted!");
      }
    }
  }
}
?>