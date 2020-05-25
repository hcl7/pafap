<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Images page where user can see his own images, friends images and can comment about them.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Images on pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<link rel="icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap-buttons.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_vlightbox.css" type="text/css" />
<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/jquery.form.js"></script>
<script type="text/javascript" src="../scripts/pafap_xml.js"></script>
</head>
<body  onload="autoresize('imageCommentTextarea');">
<?php include_once ('main_header.php'); ?>
<div id="pafap_panel" style="margin-top:54px;_margin-top:54px;">
<div id="pafap_panel_container">
    <div id="pafap_left_panel">
    <div id="imgupload">
	    <center>
		    <div style="margin-top: 20px;"><a class="button red" href="userprofile.php"><span class="label">Upload Images</span></a></div>
	    </center>
    </div>
    <ul class="leftmenu">
        <li><a href="?images=personal">Personal Images</a></li>
        <li><a href="?images=friends">Friends Images</a></li>
    </ul>
    </div>
<div id="pafap_center_img_panel">
<div class="notification" style="margin-top: 10px;">Images</div>
<div id="img_status"></div>
<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/functions.js"></script>
<?php
error_reporting(0);
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('../pafap_classes/templates_pafap_class.php');
include ('../pafap_classes/image_pafap_class.php');
$tmpl = new pafap_templates;
$img = new pafap_image;
$directory = "../users/ImagesPool/";
if ($_GET['images'] == 'personal')
{
  $img->personalFilter($uid);
  $images = $img->getFiles();
  (!empty($images))? $tmpl->showUserAlbum($directory, $images) : $tmpl->_show("pafap_warning", "Empty!");
}
if ($_GET['images'] == 'friends')
{
  $img->friendsFilter($uid);
  $prs = $img->getFiles();
  (!empty($prs))? $tmpl->showUserAlbum($directory, $prs) : $tmpl->_show("pafap_warning", "Empty!");
}
?>
<script type="text/javascript" src="../scripts/jquery_vlb.js"></script>
<script type="text/javascript">
  var $VisualLightBoxParams$ = {autoPlay:true,borderSize:21,enableSlideshow:false,overlayOpacity:0.4,startZoom:true};
</script>
<script type="text/javascript" src="../scripts/pafap_visuallightbox.js"></script>
</div>
<div id="pafap_right_img_panel">
    <div class="ads">Ads</div>
    <div id="page-wrap"></div>
</div>
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>