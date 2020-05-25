<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Pafap search friends page where search result is listed.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Find People and Pages on pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<!--[if IE]>
	<link rel="stylesheet" href="../css/pafap_global_IE.css" type="text/css" />
<![endif]-->
<link rel="icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap-buttons.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../scripts/functions.js"></script>
<script type="text/javascript" src="../scripts/pafap_xml.js"></script>

</head>
<body>
<?php include_once ('main_header.php'); ?>
<div id="pafap_panel" style="margin-top:54px;_margin-top:54px;">
<div id="pafap_panel_container">
<div id="pafap_left_panel">
    <div class="ads" style="margin-top:20px;">Ads</div>
    <div id="page-wrap"></div>
</div>
<div itemscope itemtype="http://schema.org/Person" id="pafap_center_panel">
<div class="notification" style="margin-top:10px;">pafap Search Results:</div>
<div id="search_status"></div>

<?php
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
($_GET['userSearch'] != '')? $queryPost = $_GET['userSearch'] : header('location: /home.php?cid='.$_SESSION[cid]);
include ('../pafap_classes/init.php');
include ('../pafap_classes/bind_pafap_class.php');
$search = new pafap_bind();
$tmpl = new pafap_templates;
$classArray = array('box'=> 'searchBox', 'img'=> 'search_img', 'notes'=> 'pafapitem_text');
$sql = "SELECT pafap_users.*, pafap_profile.image FROM pafap_users, pafap_profile WHERE pafap_users.uid = pafap_profile.uid AND CONCAT(pafap_users.fname, ' ', pafap_users.lname) LIKE '%{$search->sd($queryPost)}%'";
$tmpArray = $search->ArrayResults($sql);
if (!empty($tmpArray))
{
  echo "<ul id='pafaplist'>";
  foreach($search->ArrayResults($sql) as $key=>$value)
  {
    $tmpl->bindingByClass($value['uid'], $value['image'], $value['fname']. " ".$value['lname']. "<br />". $value['sex'], $classArray, $value['role']);
  }
  echo "</ul>";
}
else $tmpl->_show("pafap_error", "Empty results!");
?>
<div id="userinfo_search"></div>
<i style="color: #a6acb7;"><center>pafap search result gives you profile image, first name, last name, sex and you can send a friend request.  You can see the selected user profile by clicking profile image!</center></i>
</div>
</div>
</div>

<?php require('footer.php'); ?>
</body>
</html>

