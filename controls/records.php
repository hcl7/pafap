<!DOCTYPE html>
<html>
<head>
<META NAME="Description" CONTENT="Social Network based on discussions by categories that are activated in the menu Profile in which can also upload images.
Similarities based on the types of categories depends on the completion of the Profile menu.
You can talk about what you want and with the right persons for this. Records on pafap page where user can create pages with memories.">
<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<title>Records on pafap</title>
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
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#category").change(function()
        {
            var catid=$("#category option:selected").attr("rel");
            var dataString = 'catid='+ catid;
            $.ajax({
                type: "POST",
                url: "category_type.php",
                data: dataString,
                cache: false,
                success: function(html){
                    $("#ctype").html(html);
                }
            });
        });

        //create records
    $('#createrec').submit ( function() {
      $.post('newrecord.php', $('#createrec').serialize(), function(data) {
        $('#lblstatus').html(data).hide().fadeIn(2000).fadeOut("slow", function(){
          location.reload();
        });
      });
	  return false;
    });

 $(".dropdown .button, .dropdown button").click(function () {
  if (!$(this).find('span.toggle').hasClass('active')) {
    $('.dropdown-slider').slideUp();
	$('span.toggle').removeClass('active');
  }
  $(this).parent().find('.dropdown-slider').slideToggle('fast');
  $(this).find('span.toggle').toggleClass('active');
  return false;
 });

    });
</script>
</head>
<body>

<!-- pafap_header-->
<div id="pafap_header">
<div id="pafap_header_container">
    <div id="pafap_left_header">
        <div id="pafap_header_logo">
        </div>
    </div>
    <div id="pafap_center_header">
    <ul>
		<li>
			<a href="../home.php?cid=<?php session_start(); echo (isset($_SESSION['cid']))? $_SESSION['cid'] : 100; ?>" title="Home" id="homes"></a>
		</li>
		<li>
			<a href="../controls/userprofile.php" title="Profile" id="profile"></a>
		</li>
		<li>
			<a href="../controls/userimage.php?images=personal" title="Photo" id="photo"></a>
		</li>
		<li>
			<a href="../games/pafap_games.php?nr=<?php echo (isset($gms))? $gms : 0; ?>" title="game" id="game"></a>
		</li>
        <li>
			<a href="../controls/records.php" title="Records" id="record"></a>
		</li>
        <li>
            <form id="searchFrm" method="GET" action="../controls/search.php" style="display:inline;">
				<input style="margin-top:4px;" id="userSearch" name="userSearch" class="pafap_search" type="text"/>
			</form>
        </li>
	</ul>
    </div>
    <div id="pafap_right_header">
        <div class="buttons" style="float:right;">

            <div class="dropdown left">
                <a href="#" class="button left"><span class="icon icon96"></span><span class="label">Options</span><span class="toggle"></span></a>
                <div class="dropdown-slider">
                    <a href="../controls/messages.php" title="Messages" class="ddm"><span class="icon icon125"></span><span class="label">Inbox<?php (isset($_SESSION['email']))? $mail = $_SESSION['email'] : header("location: /index.php"); ?></span></a>
                    <a href="../controls/settings.php?profile=edit" title="Settings" class="ddm"><span class="icon icon196"></span><span class="label">Settings</span></a>
                    <a href="#" class="logout ddm negative"><span class="icon icon151"></span><span class="label">Logout</span></a>
                </div>
            </div>
            <a href="../controls/friends.php" title="Friends" class="button left"><span class="icon icon127"></span><span class="label blue">Friends</span></a>
            <a href="../controls/downloads.php" title="Downloads" class="button left"><span class="icon icon70"></span><span class="label blue">Downloads</span></a>
        </div>
    </div>
</div>
</div>
<!-- pafap_header-->

<div id="pafap_game_panel">
<div id="pafap_panel_container">
  <div id="pafap_left_game_panel">
  <div class="ads">Ads</div>
    <div id="page-wrap"></div>
  </div>
  <div itemscope itemtype="http://schema.org/page" id="pafap_center_panel">
  <div class="notification" style="margin-top:10px;">New Record</div>
  <i style="color: #a6acb7;"><center>Create <strong>Record</strong> as your own page!</center></i>
            <form id="createrec" method="POST"><center><table>
                <tr>
                    <td class="labelstyle"><span itemprop="Page Name">Record Name:</span></td>
                    <td><input type="text" name="txtrecname" id="txtrecname" class="pafap_login" /></td>
                </tr>
                <tr>
                    <td class="labelstyle"><span itemprop="genre">Record Category:</span></td>
                    <td><select name="category" id="category" class="controls">
                        <option selected="selected">-Select-</option>
<?php

include ('../pafap_classes/init.php');
include ('../pafap_classes/profile_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$prf = new pafap_profile();
$tmpl = new pafap_templates;
$sql = "SELECT cid, cname FROM pafap_category";
$catg = $prf->binder($sql, "cid", "cname");
$tmpl->showbinder($catg);
?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="labelstyle"><span itemprop="genre">Record Category Type:</span></td>
                    <td><select name="ctype" id="ctype" class="controls">
                        <option selected="selected">-Select-</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="labelstyle"><span itemprop="url">Website Link:</span></td>
                    <td><input type="text" name="txtlink" id="txtlink" class="pafap_login" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button id="btnCreateRecord" name="btnCreateRecord" class="action blue"><span class="label">Create Record</span></button></td>
                </tr>
                <tr><td colspan="2"><label id="lblstatus"></label></td></tr>
            </table></center>
            </form>
  </div>
  <div id="pafap_right_panel"></div>
</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>