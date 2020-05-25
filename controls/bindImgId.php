<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ("../pafap_classes/image_pafap_class.php");
$imgbind = new pafap_image();
if (isset($_POST['imagename']))
{
  $iname = $_POST['imagename'];
  echo $imgbind->getIidByImg($iname);
}
else echo 1;
?>
