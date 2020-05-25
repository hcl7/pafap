<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Profile page where user can configure all his own profile interface.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Profile on pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<link rel="icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap-buttons.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<script type="text/javascript" src="../scripts/pafap_profile.js"></script>
<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/functions.js"></script>
<script type="text/javascript" src="../scripts/pafap_xml.js"></script>
<script>
$(document).ready (function(){
  $("#infoStatus").load('bindInfo.php');
});
</script>
</head>

<body>
<?php include('main_header.php'); ?>
<div id="pafap_panel" style="_margin-top:52px;">
<div id="pafap_panel_container">
<div id="pafap_left_panel">
<div id="pafap_profile_image">
<?php
include ('../pafap_classes/init.php');
include ('../pafap_classes/profile_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$defaultimage = "pafap/users/DEFAULT.PNG";
$uid = $_SESSION['uid'];
$prf = new pafap_profile();
$tmpl = new pafap_templates;
$userimage = $prf->getImagePath($uid);
$tmpl->showUserProfile("../".$userimage, $defaultimage, "100%");
?>
</div>
    <ul class="leftmenu">
        <li><a href="../home.php?cid=<?php echo $_SESSION['cid']; ?>">Home</a></li>
        <li><a href="../controls/messages.php">Messages</a></li>
        <li><a href="../controls/userimage.php?images=personal">Images</a></li>
        <li><a href="../games/pafap_games.php?nr=<?php echo (isset($gms))? $gms : 0; ?>">Games</a></li>
        <li><a href="../controls/friends.php">Friends</a></li>
    </ul>
</div>
<div id="pafap_center_panel">
<!--tabmenu -->
<h3><div class="profile_info">Edit User Profile</div></h3>
<i style="color: #a6acb7;"><center>You must complete the profile so you can have services and games to play with!</center></i>
<div class="menu">
<ul>
<li><a href="#" onmouseover="pafap_tabs('1', '1');" onfocus="pafap_tabs('1', '1');" onclick="return false;"  title="" id="tablink1">About</a></li>
<li><a href="#" onmouseover="pafap_tabs('1', '2');" onfocus="pafap_tabs('1', '2');" onclick="return false;"  title="" id="tablink2">Info</a></li>
<li><a href="#" onmouseover="pafap_tabs('1', '3');" onfocus="pafap_tabs('1', '3');" onclick="return false;"  title="" id="tablink3">Categories</a></li>
<li><a href="#" onmouseover="pafap_tabs('1', '4');" onfocus="pafap_tabs('1', '4');" onclick="return false;"  title="" id="tablink4">Upload</a></li>
</ul>
</div>
<link rel="stylesheet" href="../css/pafap_upload.css" type="text/css" media="screen" />
<script src="../scripts/pafap_popup.js" type="text/javascript"></script>
<div id="tabcontent1"><?php include('about.php'); ?></div>
<div id="tabcontent2"><?php include('info.php'); ?></div>
<div id="tabcontent3"><?php include('categories.php'); ?></div>
<div id="tabcontent4">
	<center>
		<div id="uploadbutton"><input type="submit" class="btn danger" value="Upload Images" /></div>
	</center>
	<div id="popupContact">
		<a id="popupContactClose"></a>
		<p id="contactArea">
            <!-- upload -->
            <?php include('upload.php'); ?>
            <!-- upload -->
            <br />
            <br />
            <p><div id="upload_results" class="alert-message info"></div></p>
		</p>
	</div>
	<div id="backgroundPopup"></div>
</div>
<!--tabmenu -->
<br />
<i style="color: #a6acb7;"><center>Information about you and categories that you have selected!</center></i>
<div id="infoStatus"></div>
</div>
<div id="pafap_right_panel">
    <div class="ads" style="margin-top:20px;">Ads</div>
    <div id="page-wrap"></div>
</div>
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>
