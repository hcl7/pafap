<?php
session_start();
include ('../pafap_classes/init.php');
include ('../pafap_classes/settings_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
if(isset($_SESSION['record']))
{
  $ruid = $_SESSION['record'];
  $msql = new pafap_settings();
  $tmpl = new pafap_templates();
  if(isset($_POST['pgrn']) && $_POST['pgrn'] != '')
  {
    $rn = $_POST['pgrn'];
    if(isset($_POST['pglnk']) && $_POST['pglnk'] != '')
    {
      $lnk = $_POST['pglnk'];
      $msql->updatePage($rn, $lnk, $ruid);
      $tmpl->_show('pafap_success', "Settings updated!");
    }
  }
  else $tmpl->_show('pafap_warning', "Post error!");
}
?>