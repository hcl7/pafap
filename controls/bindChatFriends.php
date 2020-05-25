<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : $uid = 0;
include ('pafap_classes/chat_pafap_class.php');
$chat = new pafap_chat();
$tmpl = new pafap_templates();
$frds = $chat->getUsersByFid($chat->getFriendsId($uid));
echo "<div class='notification' style='margin-top:10px;'>Online</div>";
if(!empty($frds))
{
  echo "<ul class='chattmenu'>";
  foreach($frds as $k=>$v)
  {
    $tmpl->bindChatFriends($v['uid'], $chat->getImagePath($v['uid']), $v['fname'].$v['lname']);
  }
  echo "</ul>";
}
else $tmpl->_show("pafap_warning", "No One Is Online!");
?>