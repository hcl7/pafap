<?php
//error_reporting(0);
session_start();
include ('../pafap_classes/init.php');
include ('../pafap_classes/profile_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$prf = new pafap_profile();
$tmpl = new pafap_templates;
if (isset($_POST['category']) && $_POST['category'] != 'Categories')
{
  $catid = $_SESSION['catid'];
  $category = $_POST['category'];
  $category_type = $_POST['ctype'];
  if (isset($_SESSION['uid']))
  {
    $uid = $_SESSION['uid'];
    $pid = $prf->getProfileID($uid);
    $catg = "INSERT INTO pafap_profile_category (pid, cid, cname) VALUES ('{$pid}', '{$catid}', '{$category}')";
    $cattype = "INSERT INTO pafap_profile_category_type (pid, cid, ctname) VALUES ('{$pid}', '{$catid}', '{$category_type}')";
    if(!$prf->checkct($uid, "pafap_profile_category", "cname", $pid, $category)){
      $prf->query_profile($uid, $catg);
    }
    if(!$prf->checkct($uid, "pafap_profile_category_type", "ctname", $pid, $category_type)) {
      $prf->query_profile($uid, $cattype);
    }
    $tmpl->_show('pafap_success', "Category added!");
  }
}
else $tmpl->_show('pafap_warning', "Select a Category!");

?>
