<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Settings on pafap page where user can edit, change profile of your own page you have created etc.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Page Settings on pafap</title>
<META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW">
<!--[if IE]>
	<link rel="stylesheet" href="../css/pafap_global_IE.css" type="text/css" />
<![endif]-->
<link rel="icon" href="../images/favicon.ico">
<link rel="stylesheet" href="../css/pafap_global.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap-buttons.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<link rel="stylesheet" href="../css/pafap_settings.css" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="../scripts/functions.js"></script>
<script type="text/javascript" src="../scripts/pafap_settings.js"></script>
<script type="text/javascript" src="../scripts/pafap_xml.js"></script>

</head>
<body vlink="#0000FF" alink="#0000FF">

<?php require('../controls/main_header.php'); ?>

<div id="pafap_game_panel">
<div id="pafap_panel_container">
  <div id="pafap_left_game_panel">
  <div class="ads">Ads</div>
    <div id="page-wrap"></div>
  </div>
  <div id="pafap_center_settings_panel">
  <div class="settings">Page Settings</div>
    <i style="color: #a6acb7;"><center><strong>Tools</strong> to change and save your page settings!</center></i>
<?php
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
if (isset($_SESSION['record']))
{
  $uid = $_SESSION['record'];
  $msql = new pafap_mysql();
  $tmpl = new pafap_templates();
  $sql = "SELECT pafap_users.*, pafap_profile.* FROM pafap_users, pafap_profile WHERE pafap_users.uid = pafap_profile.uid AND pafap_users.uid = $uid";
  $result = array();
  $result = $msql->ArrayResults($sql);
  foreach($result as $key=>$value)
  {
    if($value['owner'] == $_SESSION['uid'])
    {
      $fname = $value['fname'];
      $lname = $value['lname'];
      $mail = $value['email'];
      $owner = $value['owner'];
?>
      <div id="settings_page">
        <p id="editpage">
            <a href="#" class="editpg button" id="editpg"><span class="icon icon191"></span><span class="label">Edit Page</span></a>
        </p>
        <br />
        <div id="editpgarea">
            <center><table>
                <tr>
                    <td class="labelstyle">Record Name:</td>
                    <td><input type="text" name="txtrn" id="txtrn" class="pafap_login" value="<?php echo $fname; ?>" /></td>
                </tr>
                <tr>
                    <td class="labelstyle">Link:</td>
                    <td><input type="text" name="txtlink" id="txtlink" class="pafap_login" value="<?php echo $mail; ?>" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button id="btnupdatepage" class="btn primary start">Update Page</button></td>
                </tr>
                <tr><td></td><td><label id="lblrstatus"></label></td></tr>
            </table></center>
        </div>
    </div>
<?php
    }
  }
}
?>
    <div id="settings_image">
        <p id="editimage">
            <a href="#" class="editimg button" id="editimg"><span class="icon icon120"></span><span class="label">Change Image Page</span></a>
        </p>
        <br />
        <div id="editimgarea"><center>
<?php
if (isset($_SESSION['record']))
{
  include('page_upload.php');
}
?>
        </center></div>
    </div>
  </div>
</div>
</div>
<?php require('../controls/footer.php'); ?>
</body>
</html>