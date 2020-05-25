<?php

//session_start();
if (isset($_SESSION['uid']))
{
  if (dirname($_SERVER["PHP_SELF"]) == "\\" || dirname($_SERVER["PHP_SELF"]) == "/")
  {
    include ('../pafap/pafap_classes/init.php');
    include ('../pafap/pafap_classes/bind_pafap_class.php');
  }
  else
  {
    include ('../pafap/pafap_classes/init.php');
    include ('../pafap/pafap_classes/bind_pafap_class.php');
  }
  $defaultimage = "./users/DEFAULT.PNG";
  $uid = $_SESSION['uid'];
  $bind = new pafap_bind();
  $tmpl = new pafap_templates;
  $userimage = $bind->getImagePath($uid);
  $tmpl->showUserProfile("../pafap/".$userimage, $defaultimage, "100%");
  list($notifications) = $bind->notifications($uid);
  list($sms) = $bind->messages($uid);
  //list($gms) = $bind->games_nr($uid);
}

?>