<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Settings on pafap page where user can edit, change passwords, change profile etc.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Settings on pafap</title>
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
  <div class="settings">Settings</div>
    <i style="color: #a6acb7;"><center><strong>Tools</strong> to change and save the site settings!</center></i>
    <div id="settings_pass">
        <p id="changepass">
            <a href="#" class="editpass button" id="editpass"><span class="icon icon141"></span><span class="label">Change Password</span></a>
        </p>
        <br />
        <div id="editpassarea">
            <center><table>
                <tr>
                    <td class="labelstyle">Old Password:</td>
                    <td><input type="password" name="txtchangepass" id="txtchangepass" class="pafap_login" /></td>
                </tr>
                <tr>
                    <td class="labelstyle">New Password:</td>
                    <td><input type="password" name="txtchangenewpass" id="txtchangenewpass" class="pafap_login" /></td>
                </tr>
                <tr>
                    <td class="labelstyle">Re Enter New Password:</td>
                    <td><input type="password" name="txtchangerenewpass" id="txtchangerenewpass" class="pafap_login" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button id="btnchangepass" class="action blue"><span class="label">Change Password</span></button></td>
                </tr>
                <tr><td></td><td><label id="lblstatus"></label></td></tr>
            </table></center>
        </div>
    </div>
<?php
include ('../pafap_classes/init.php');
include ('../pafap_classes/mysql_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  $msql = new pafap_mysql();
  $tmpl = new pafap_templates();
  $sql = "SELECT pafap_users.*, pafap_profile.* FROM pafap_users, pafap_profile WHERE pafap_users.uid = pafap_profile.uid AND pafap_users.uid = $uid";
  $result = array();
  $result = $msql->ArrayResults($sql);
  foreach($result as $key=>$value)
  {
    $fname = $value['fname'];
    $lname = $value['lname'];
    $mail = $value['email'];
    $birth = $value['birthday'];
    $status = $value['relationship'];
  }
}
?>
    <div id="settings_account">
        <p id="editaccount">
            <a href="#" class="editacc button" id="editacc"><span class="icon icon191"></span><span class="label">Edit Account</span></a>
        </p>
        <br />
        <div itemscope itemtype="http://schema.org/Person" id="editaccarea">
            <center><table>
                <tr>
                    <td class="labelstyle"><span itemprop="name">Firstname:</span></td>
                    <td><input type="text" name="txtfn" id="txtfn" class="pafap_login" value="<?php echo $fname; ?>" /></td>
                </tr>
                <tr>
                    <td class="labelstyle"><span itemprop="name">Lastname:</span></td>
                    <td><input type="text" name="txtln" id="txtln" class="pafap_login" value="<?php echo $lname; ?>" /></td>
                </tr>
                <tr>
                    <td class="labelstyle"><span itemprop="email">Email:</span></td>
                    <td><input type="text" name="txtmail" id="txtmail" class="pafap_login" value="<?php echo $mail; ?>" /></td>
                </tr>
                <tr>
                    <td class="labelstyle"><span itemprop="birthDate">Birthday:</span></td>
                    <td><input type="text" name="txtbirth" id="txtbirth" class="pafap_login" value="<?php echo $birth; ?>" /></td>
                </tr>
                <tr>
                    <td class="labelstyle">Status:</td>
                    <td><input type="text" name="txtstatus" id="txtstatus" class="pafap_login" value="<?php echo $status; ?>" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button id="btnupdateaccount" class="action blue"><span class="label">Update Account</span></button></td>
                </tr>
                <tr><td></td><td><label id="lblaccstatus"></label></td></tr>
            </table></center>
        </div>
    </div>
    <div id="settings_cat">
        <p id="editcategories">
            <a href="#" class="editcatg button" id="editcatg"><span class="icon icon120"></span><span class="label">Edit Categories</span></a>
        </p>
        <br />
        <div id="editcatgarea">
<?php
if (isset($_SESSION['uid']))
{
  $uid = $_SESSION['uid'];
  $sqlcatg = "SELECT pafap_profile_category_type.* FROM pafap_profile, pafap_profile_category_type WHERE pafap_profile.pid = pafap_profile_category_type.pid AND pafap_profile.uid = '{$uid}'";
  $catlist = $msql->ArrayResults($sqlcatg);
  if (!empty($catlist))
  {
    foreach ($catlist as $key=>$value)
    {
      $tmpl->catbinder($value['pid'], $value['cid'], $value['ctname']);
      echo "<br />";
    }
  }
  else
  {
    $tmpl->_show("pafap_warning", "Category list empty!");
  }
}
?>
        </div>
    </div>
  </div>
</div>
</div>
<?php require('../controls/footer.php'); ?>
</body>
</html>