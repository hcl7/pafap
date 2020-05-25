<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. View Records, post notes, comments and ideas.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>View Records on pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<!--[if IE]>
	<link rel="stylesheet" href="../css/pafap_global_IE.css" type="text/css" />
<![endif]-->
<link rel="icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap-buttons.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_settings.css" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../scripts/functions.js"></script>
<script type="text/javascript" src="../scripts/pafap_settings.js"></script>
<script type="text/javascript" src="../scripts/pafap_xml.js"></script>

</head>

<body vlink="#0000FF" alink="#0000FF">

<?php require('main_header.php'); ?>

<div id="pafap_game_panel">
<div id="pafap_panel_container">
  <div id="pafap_left_game_panel">
  <div class="ads">Ads</div>
    <div id="page-wrap"></div>
  </div>
  <div id="pafap_center_settings_panel">
  <div class="viewrecords">View Record, Comments & Ideas!</div>

<!-- page -->
    <center><i style="color: #a6acb7;"><strong>Records</strong> to comment and give Ideas!</i></center>
<?php
if (isset($_SESSION['record'])){
  include ('../pafap_classes/init.php');
  include ('../pafap_classes/record_pafap_class.php');
  $defaultimage = "users/PAGE-DEFAULT.PNG";
  $prf = new pafap_record();
  $tmpl = new pafap_templates;
  $ruid = $_SESSION['record'];
  foreach($prf->bindInfo($ruid) as $key=>$value)
  {
    if ($value['role'] == 'public')
    {
      $tmpl->showRecProfile("../".$value['image'], $defaultimage, "200px", "100%");
      echo "<div style='position:absolute;left: 20px;top:40px;color: #6E6E6E;font-weight: bold;font-size:12px;letter-spacing:12px;'>".$value['fname']. " ". $value['lname']."</div>";
      echo "<div style='float:left;width: 100%;'><a href='javascript:void();' class='addViewFollow button' rel='{$value['uid']}'><span class='icon icon9'></span><span class='label'>Follow</span></a>";
            if ($value['owner'] == $_SESSION['uid']) echo "<a href='page_settings.php' class='recSettings button' rel='{$value['uid']}'><span class='icon icon196'></span><span class='label'>Page Settings</span></a>";
            echo "<span class='label' style='float: right;font-size: 20px;color: #35619d;'>Followers: ".$prf->countFollows($ruid)."</span>";
            echo "<div id='recstatus'></div>";
      echo "</div>";
    }
  }
}
?>
<div class="leftrecord">
    <div class="pafap_wall_box_content">
        <form id="homerecord">
            <textarea class='textarea' name="postrecordwall" id="postrecordwall"></textarea>
            <div class="buttons"><button name="rpost" id="rpost" class="action blue"><span class="label">Post</span></button></div>
        </form>
    </div>
    <br clear="all">
    <div id="current_record_messages"></div>
    <div id="record_messages"></div>
    <div class="more_record_results">
        <center><a href="javascript:void();" class="autolinkrecord" rel="2"><span>More Results</span></a></center>
        <input type="hidden" name="getmorerecord" id="getmorerecord" value="2" />
    </div>
    <div id="userinfo"></div>
</div>
<div class="rightrecord">
<?php
foreach ($prf->bindNews() as $k=>$n)
{
  echo "<div id='recIdeas'><div class='recordIdeasPin'></div><strong>Lajme: </strong>{$n['noteAlb']}<br /><strong>News: </strong>{$n['noteEng']}</div>";
}
?>
</div>
</div>
<!-- page -->

  </div>
</div>
</div>

<?php require('footer.php'); ?>
</body>
</html>