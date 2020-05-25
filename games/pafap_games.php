<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Games on pafap page where user can play with games selected in profile menu.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Games on pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">

<link rel="icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<!--[if IE]>
	<link rel="stylesheet" href="../css/pafap_global_IE.css" type="text/css" />
<![endif]-->
<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap-buttons.css" type="text/css" />
<link rel="stylesheet" href="pafap_games.css" type="text/css" />
<script type="text/javascript" src="../scripts/jquery-1.6.4.js"></script>
<script type="text/javascript" src="../scripts/functions.js"></script>
<script type="text/javascript" src="../scripts/pafap_xml.js"></script>

</head>
<body vlink="#0000FF" alink="#0000FF">

<?php require('../controls/main_header.php'); ?>

<div id="pafap_game_panel">
<div id="pafap_panel_container">
  <div id="pafap_left_game_panel">
  <div class="game_tool">Game Menu</div>
  <div id="pafap_game_slide">
<?php
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/game_pafap_class.php');
$gm = new pafap_games();
$games = array();
$usergames = array();
if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  $games = $gm->getGameNames($uid);
  $usergames = $gm->getCategories($uid);
  echo "<ul class='game_menu'>";
  foreach($games as $game)
  {
    foreach($usergames as $ug)
    {
      if ($game['name'] == $ug['ctname'])
      {
        $gm->showGameMenu("images/".$game['img_url'], $game['link'], "game_target");
      }
    }
  }
  echo "</ul>";
}
?>
  </div>
  <div class="ads">Ads</div>
  <div id="page-wrap"></div>
  </div>
  <div id="pafap_center_games_panel">
  <div class="game_tool">Game Field</div>
    <i style="color: #a6acb7;"><center>Choose a game in the <strong>game menu</strong> and you will play the game in the <strong>game field</strong> after you add game category at the profile menu!</center></i>
    <div id="game_target"><iframe name="game_target" width="100%" height="450px" frameborder="0" src=""></iframe></div>
  </div>
</div>
</div>
<?php require('../controls/footer.php'); ?>
</body>
</html>