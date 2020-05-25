<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Friends page where is the list of user friends, and friends requests">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Friends on pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<link rel="icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap-buttons.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<script type="text/javascript" src="../scripts/pafap_profile.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../scripts/functions.js"></script>
<script type="text/javascript" src="../scripts/pafap_xml.js"></script>

<script>
$(document).ready (function(){
  $('#friends_status').html('<center><img src="../images/pafap-loader.gif" alt="Loading"/></center>');
  $("#friends_status").load('bindFriends.php');
});
</script>
</head>

<body>
<?php include('main_header.php'); ?>
<div id="pafap_panel">
<div id="pafap_panel_container">
<div id="pafap_left_panel">
    <div class="ads" style="margin-top:20px;">Ads</div>
    <div id="page-wrap"></div>
</div>
<div itemscope itemtype="http://schema.org/Person" id="pafap_center_panel_friends">
<div class="notification" style="margin-top:10px;">Friends</div>
<div id="pafap_center_panel_friends_scrol">
<div id="friends_status"></div>
<div id="userinfo_fr"></div>
</div>
</div>
<div id="pafap_right_panel"><div class="notification" style="margin-top:20px;">Notifications</div>
<div id="conf_status"></div>
<?php

if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  include ('../pafap_classes/init.php');
  include ('../pafap_classes/bind_pafap_class.php');
  include ('../pafap_classes/sim_pafap_class.php');
  $sim = new pafap_similarities();
  $tmpl = new pafap_templates();
  $bind = new pafap_bind();
  $sim->filterInvi($uid);
  $sim->getUsersByIID($sim->getInvi());
  $invi = $sim->getInvi();
  if (!empty($invi))
  {
    foreach($sim->getUsr() as $key=>$value)
    {
      if($value['uid'] != $uid)
      {
        $tmpl->inviBinder($value['uid'], $value['image'], $value['fname']." ".$value['lname']);
      }
    }
  }
  else $tmpl->_show("pafap_warning", "Empty list!");
}

?>
</div>

</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>
