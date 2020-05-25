<?php
session_start();
if (isset($_SESSION['puid']))
{
  session_destroy();
  header("Location: /plogin.php");
}
else header("Location: /plogin.php");
?>