<!DOCTYPE html>
<html>
<head>
<title>pafap - panel Social Network - Search Engine Login</title>

<link rel="icon" href="images/favicon.ico">
<link rel="icon" href="images/favicon.ico">
<link rel="stylesheet" href="css/pafap-buttons.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="css/pafap_link.css" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<script>
$(document).ready ( function() {
  $(".logout").click( function() {
    $.post('../controls/plogout.php', function() {
      location.reload();
    });
    return false;
  });

  $('#panelhome').submit ( function() {
    $.post('controls/PostNews.php', $('#panelhome').serialize(), function(data) {
      $("#newsstatus").html(data).hide().fadeIn(2000).fadeOut("slow", function(){
        $("#postnews").val('');
        $("#postnewseng").val('');
	  });
	});
    return false;
  });
});
</script>
</head>
<body vlink="#0000FF" alink="#0000FF">
<?php require('controls/panel_main_header.php'); ?>
<div id="pafap_panel">
<div id="pafap_panel_container">
  <div id="pafap_left_panel">&nbsp;</div>
  <div id="pafap_center_panel">
  <div class="notification" style="margin-top:10px;">Panel Information</div>
<?php
//error_reporting(0);
include ('pafap_classes/init.php');
include ('pafap_classes/panel_pafap_class.php');
include ('pafap_classes/templates_pafap_class.php');
$panel = new pafap_panel();
$tmpl = new pafap_templates();
$users = "SELECT COUNT(uid) FROM pafap_users WHERE role = 'user';";
$panel->_count($users);
echo "Users: ". $panel->show_results(). "<br>";

$online = "SELECT COUNT(uid) FROM pafap_users WHERE status = 1";
$panel->_count($online);
echo "Online: ". $panel->show_results(). "<br>";

$walls = "SELECT COUNT(wid) FROM pafap_wall";
$panel->_count($walls);
echo "Walls: ". $panel->show_results(). "<br>";

$comments = "SELECT COUNT(wid) FROM pafap_comments";
$panel->_count($comments);
echo "Wall Comments: ". $panel->show_results(). "<br>";

$images = "SELECT COUNT(iid) FROM pafap_images";
$panel->_count($images);
echo "Images: ". $panel->show_results(). "<br>";

$img_comments = "SELECT COUNT(iid) FROM pafap_images_comments";
$panel->_count($img_comments);
echo "Images Comments: ". $panel->show_results(). "<br>";

$sms = "SELECT COUNT(mid) FROM pafap_messages";
$panel->_count($sms);
echo "Messages: ". $panel->show_results(). "<br>";

$chat = "SELECT COUNT(id) FROM pafap_chat";
$panel->_count($chat);
echo "Chat Messages: ". $panel->show_results(). "<br>";

$agree = "SELECT COUNT(wid) FROM pafap_agree";
$panel->_count($agree);
echo "Agree Nr: ". $panel->show_results(). "<br>";

$frq = "SELECT COUNT(uid) FROM pafap_invitations WHERE status = 0";
$panel->_count($frq);
echo "Invitations Nr: ". $panel->show_results(). "<br>";

echo "Last registered: <br />";
foreach($panel->getLastRegistered() as $val)
{
  echo $val['fname']. " ". $val['lname']. " ". $val['email']. "<br>";
}


echo "Done!";
?>
<form id="panelhome">
  <strong>Albanian:</strong><textarea class='textarea' name="postnews" id="postnews"></textarea><br />
  <strong>English:</strong><textarea class='textarea' name="postnewseng" id="postnewseng"></textarea>
  <div class="buttons"><button name="post" id="post" class="action blue"><span class="label">Post News</span></button></div>
</form>
<div id="newsstatus"></div>
</div>
  <div id="pafap_right_panel">
    <div class="notification" style="margin-top:20px;">Email Administration</div>
    <div id="panelstatus"></div>
<div id="pafap_right_panel_panel">
<?php
foreach($panel->notificationUsers() as $k=>$val)
{
  $tmpl->mailAdmin($val['iid'], $val['fname'], $val['lname'], $val['email']);
}
?>
</div>
  </div>
</div>
</div>
<?php require('controls/footer.php'); ?>
</body>
</html>