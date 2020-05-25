<link rel="stylesheet" href="../css/pafap_link.css" type="text/css" />
<?php
session_start();
error_reporting(0);
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/message_pafap_class.php');
include ('../pafap_classes/templates_pafap_class.php');
$ms2fr = new pafap_message();
$tmpl = new pafap_templates;
echo "<ul id='pafaplist'>";
foreach($ms2fr->getFriendsByUid($uid) as $k=>$v)
{
  $tmpl->bind2SelectFriends($v['fuid'], $v['image'], $v['fname']." ".$v['lname']);
}
echo "</ul>";
echo "<a href='javascript:void();' class='button green ms2gr_hide' id='btnlink'><span class='label'>Close</span></a>";
?>
<script type="text/javascript" language="JavaScript">
    $(document).ready(function() {
      $('.frSelected').click (function(){
        var frs = $(this).attr('fid');
        var frname = $(this).attr('frn');
        $("input[name=frlID]").val(frs);
        $('#txtto').val(frname);
      });

      $(".ms2gr_hide").click (function(){
        $('#fr_popup').hide();
      });
    });
</script>
