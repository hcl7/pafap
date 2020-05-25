<link rel="stylesheet" href="../css/pafap_messages.css" type="text/css" />
<?php

session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/image_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
if(isset($_POST['iid']))
{
  $iid = $_POST['iid'];
  $img = new pafap_image;
  $tmpl = new pafap_templates;
  $img->rm_image($uid, $iid);
  $tmpl->show_message($img->_showerror(), 'pafap_success');
}

?>
