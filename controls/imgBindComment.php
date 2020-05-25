<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ("../pafap_classes/image_pafap_class.php");
include ("../pafap_classes/templates_pafap_class.php");
$imgbind = new pafap_image();
$tmpl = new pafap_templates;
$imgcomm = array();
if (isset($_POST['imgcommid']))
{
  $iid = $_POST['imgcommid'];
  $imgcomm = $imgbind->bindImgComments($iid);
  foreach($imgcomm as $key=>$value)
  {
    $tmpl->imgCommentsBinder($value['iid'], $imgbind->getUserName($value['icuid']), $imgbind->getImagePath($value['icuid']), $value['notes']);
  }
}
else $tmpl->_showWithId("imageCommentResults", "imgcommid: error!");

?>
