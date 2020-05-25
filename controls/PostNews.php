<?php
session_start();
include ('../pafap_classes/init.php');
include ('../pafap_classes/panel_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$nws = new pafap_panel();
$tmpl = new pafap_templates;
if(isset($_POST['postnews']) && $_POST['postnews'] != ''){
  $alb = $_POST['postnews'];
  if(isset($_POST['postnewseng']) && $_POST['postnewseng'] != ''){
    $eng = $_POST['postnewseng'];
    $nws->postNews($alb, $eng);
    $tmpl->_show('pafap_success', "News Posted!");
  }
  else $tmpl->_show('pafap_warning', "Post error!");
}
else $tmpl->_show('pafap_warning', "Post error!");
?>
