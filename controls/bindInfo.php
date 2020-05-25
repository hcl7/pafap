<?php
session_start();
(isset($_SESSION['uid']))? $uid = $_SESSION['uid'] : header('location: /index.php');
include ('../pafap_classes/init.php');
include ('../pafap_classes/profile_pafap_class.php');
$prf = new pafap_profile();
echo "<div class='profile_info'>INFO</div>";
foreach($prf->bindInfo($uid) as $key=>$value)
{
  echo "Nationality: ".$value['nationality']. "<br>";
  echo "Status: ".$value['relationship']. "<br>";
  echo "From: ".$value['residence']. "<br>";
  echo "Education: ".$value['education']. "<br>";
  echo "Information: ".$value['infocontact']. "<br>";
}
echo "<div class='profile_info'>CATEGORIES</div>";
foreach($prf->bindCategories($uid) as $key=>$value)
{
  echo $value['ctname']. "<br>";
}
?>