<?php
session_start();
include ('../pafap_classes/templates_pafap_class.php');
$tmpl = new pafap_templates();
if(isset($_SESSION['puid']))
{
  if(isset($_POST['postemail']))
  {
    $fromemail = $_POST['postemail'];
    spl_autoload("loadsmtp");
    $ishtml=true;
    $reply_to=$fromemail;
    $reply_name="pafap Notifications";
    $from_name="pafap Notifications";
    $subject="Notifications";
    $resipent_address=$fromemail;
    $htmlcontent="<b>You have notifications pending<br/>http://pafap.com/controls/friends.php<br/>have a good day.</b>";
    send_mail();
    $tmpl->_show("pafap_success", "Email sent!");
  }
  else $tmpl->_show("pafap_warning", "Email Not Sent!");
}
else $tmpl->_show("pafap_warning", "Post error!");
?>