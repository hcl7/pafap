<div class="profile_info">INFO<a href="javascript:void();" style='color: #ffffff; float: right;text-decoration: none;' class="infouser_hide">X</a></div>
<script type="text/javascript" language="JavaScript">
    $(document).ready(function() {
      $(".infouser_hide").click (function(){
        //$('#userinfo').hide();
        disablePopup('bgPopupProfileInfo', 'userinfo');
        $('#messages').load('controls/BindWall.php', {moreresults:$("#getmore").val()});
        $('#userinfo_fr').hide();
        //disablePopup('bgPopupProfileInfo', 'userinfo_fr');
        $('#friends_status').load('bindFriends.php');
        $('#userinfo_search').hide();
        //disablePopup('bgPopupProfileInfo', 'userinfo_search');
      });
    });
</script>
<div id="pafap_profile_image">
<?php
include ('../pafap_classes/init.php');
include ('../pafap_classes/profile_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$defaultimage = "users/DEFAULT.PNG";
if (isset($_POST['infouser']))
{
  $uid = $_POST['infouser'];
  $prf = new pafap_profile();
  $tmpl = new pafap_templates;
?>
</div>

<div>
<?php
foreach($prf->bindInfo($uid) as $key=>$value)
{
  if ($value['role'] == 'public')
  {
    session_start();
    $tmpl->showUserProfile("../".$value['image'], $defaultimage, "100%");
    $md5page = md5($value['uid']);
    $_SESSION['record'] = $value['uid'];
    echo "<a href='../controls/view.php?record={$md5page}' class='textlink'>View This Page</a>";
  }
  else
  {
    $tmpl->showUserProfile("../".$value['image'], $defaultimage, "100%");
    echo "<strong>Nationality: </strong><i>".$value['nationality']. "</i><br>";
    echo "<strong>Status:      </strong><i>".$value['relationship']. "</i><br>";
    echo "<strong>From:        </strong><i>".$value['residence']. "</i><br>";
  }
}
}
?>
</div>
