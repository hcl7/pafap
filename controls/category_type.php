<?php
//error_reporting(0);
session_start();

if(isset($_POST['catid']))
{
  $catid = $_POST['catid'];
  $_SESSION['catid'] = $catid;
  include ('../pafap_classes/init.php');
  include ('../pafap_classes/profile_pafap_class.php');
  include ('../pafap_classes/templates_pafap_class.php');
  $cat = new pafap_profile();
  $tmpl = new pafap_templates;
  $sql = "SELECT ctid, ctname FROM pafap_category_type WHERE ctid = '{$catid}'";
  $cattype = $cat->binder($sql, "", "ctname");
  $tmpl->showbinder($cattype);
}

?>