<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Home page where user can see and make discussing categories, similarities etc.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<!--<meta http-equiv="refresh" content="120" />-->
<title>Pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<link rel="icon" href="images/favicon.ico">
<link rel="stylesheet" href="css/pafap-buttons.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="css/pafap_global.css" type="text/css" />
<!--[if IE]>
	<link rel="stylesheet" href="css/pafap_global_IE.css" type="text/css" />
<![endif]-->
<link rel="stylesheet" href="css/pafap_link.css" type="text/css" />
<link rel="stylesheet" media="all" href="chat/css/pafap_chat.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="scripts/functions.js"></script>
<script type="text/javascript" src="scripts/pafap_flash.js"></script>

</head>

<body onload="autoresize('postwall');">
<?php require('/controls/main_header.php'); ?>
<div id="pafap_panel">
<div id="pafap_panel_container">
    <div itemscope itemtype="http://schema.org/Brand" id="pafap_left_panel">
        <div id="pafap_profile_image"><?php require ('controls/profile.php');?></div>
        <div class="notification">Friend Requests
            <div class="ballnumber">
                <a href="controls/friends.php" class="linkStyle"><span itemprop="number of frinends"><?php echo $notifications; ?></span></a>
            </div>
        </div>
        <div class="notification">Messages
            <div class="ballnumber"><a href="controls/messages.php?nr=<?php echo $sms; ?>" class="linkStyle"><span itemprop="number of messages"><?php echo $sms; ?></span></a></div>
        </div>
        <div class="categories">Categories</div><?php require ('controls/menu.php');?>
    </div>
    <div itemscope itemtype="http://schema.org/blog" id="pafap_center_panel_home">
<?php
error_reporting(0);
$cid = $bind->getCategoryByCid($bind->sd($_GET['cid']));
?>
<img itemprop="category type image" src="<?php echo $cid; ?>" />
    <div class="pafap_wall_box_content">
        <form id="home">
            <textarea class='textarea' name="postwall" id="postwall"></textarea>
            <div class="buttons"><button name="post" id="post" class="action blue"><span class="label">Post</span></button></div>
        </form>
    </div>
    <br clear="all">
    <div id="current_messages"></div>
    <div id="messages"></div>
    <div class="more_results">
        <center><a href="javascript:void();" class="autolink" rel="2"><span>More Results</span></a></center>
        <input type="hidden" name="getmore" id="getmore" value="2" />
    </div>
    <div id="userinfo"></div>
<?php

if(!isset($_SESSION['uid']) && empty($_SESSION['uid']))
    header('location: index.php');

if(isset($_GET['cid'])) $_SESSION['cid'] = $_GET['cid'];

?>
<div id="popup"></div>
    </div>
    <div itemscope itemtype="http://schema.org/Person" id="pafap_right_panel">
        <div class="similarities" style="margin-top:20px;">Similarities</div>
        <div id="sim_status"></div>
        <div id="sim_container"><span itemprop="name"><?php include ('controls/similarities.php'); ?></span></div>
        <div id="chat_container"><span itemprop="name"><?php include ('controls/bindChatFriends.php');?></span></div>
        <script type="text/javascript" src="scripts/jquery-1.6.4.js"></script>
        <script type="text/javascript" src="chat/js/pafap_chat.js"></script>
        <script type="text/javascript" src="scripts/pafap_xml.js"></script>
        <div class="ads" style="margin-top:200px;">Ads</div>
        <div id="page-wrap"></div>
    </div>
</div>
</div>

<?php require('controls/footer.php'); ?>

</body>
</html>
