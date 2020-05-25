<?php
//error_reporting(0);
session_start();
(isset($_SESSION['uid']) && $_SESSION['uid'] != NULL)? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/image_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$img = new pafap_image();
$tmpl = new pafap_templates;
if (isset($_POST['imageid']))
{
  $iid = $_POST['imageid'];
  if ($_POST['imgpostcomment'] != '')
  {
    $notes = $_POST['imgpostcomment'];
    $img->imgPostComment($iid, $uid, $notes);
    $tmpl->_showWithId("imageCurrentCommentResults", "<div class='imgcommbox'><div class='usr_img'><img src='../{$img->getImagePath($uid)}' width='48px' height='48px' alt='' /></div><div class='img_notes'>{$notes}</div></div>");
  }
  else $tmpl->_show("pafap_error", "Enter Comment!");
}
else $tmpl->_show("pafap_error", "Page Error!");

?>
