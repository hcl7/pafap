<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Messages page where is the list of received messages send by user friends">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Messages on pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<link rel="icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap-buttons.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_popup.css" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../scripts/jquery.form.js"></script>
<script type="text/javascript" src="../scripts/pafap_xml.js"></script>
<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/functions.js"></script>
</head>
<body onload="autoresize('msTextArea');">
<?php include('main_header.php'); ?>
<div id="pafap_panel">
<div id="pafap_panel_container">
<div id="pafap_left_panel">
    <ul class="leftmenu" style="margin-top:20px;">
        <li><a href="../home.php?cid=<?php echo $_SESSION['cid']; ?>">Home</a></li>
        <li><a href="../controls/userprofile.php">Profile</a></li>
        <li><a href="../controls/userimage.php?images=personal">Images</a></li>
        <li><a href="../games/pafap_games.php?nr=<?php echo (isset($gms))? $gms : 0; ?>">Games</a></li>
        <li><a href="../controls/friends.php">Friends</a></li>
    </ul>
</div>
<div id="pafap_center_panel">
<div class="notification" style="margin-top:10px;color:#35619d;"><?php echo $mail; ?></div>
<div id="messages_status" style="width:98%;"></div>
<!-- popup friends -->
<div id="fr_popup_container">
<div id="fr_popup"></div>
</div>
<!-- popup friends -->
<script>
$(document).ready ( function() {
  $('#inbox').html('<center><img src="../images/pafap-loader.gif" alt="Loading"/></center>');
  $('#inbox').load('inbox.php');
  $('#sendHideShow #newMS').click(function(event){
    event.preventDefault();
    $(this).parent('#sendHideShow').siblings('#textCompose').slideToggle("fast");
    $('#msTextArea').focus();
  });

  $('.msPost').click (function(){
    var notes = $('#msTextArea').val();
    var msid = $('#frlID').val();
    $.post('msSend.php', {msto:msid, msNotes:notes}, function(d){
      $('#messages_status').html(d).hide().fadeIn(2000).fadeOut("slow", function(){
        location.reload();
      });
    });
  });

  $('#txtto').click (function(e){
    $('#fr_popup').html('<center><img src="../images/pafap-loader.gif" alt="Loading"/></center>');
    $('#fr_popup').load('ms2fr.php');
    $('#fr_popup').show();
  });

});
</script>
<?php
include ('../pafap_classes/init.php'); 
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$tmpl = new pafap_templates;
$tmpl->msComposeBox();
?>
<div id="inbox"></div>
</div>
<div id="pafap_right_panel" style="margin-top:10px;">
    <div class="ads" style="margin-top:10px;">Ads</div>
    <div id="page-wrap"></div>
</div>
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>